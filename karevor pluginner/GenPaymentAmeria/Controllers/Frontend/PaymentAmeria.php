<?php

use GenPaymentAmeria\Components\AmeriaPayment\PaymentResponse;
use GenPaymentAmeria\Components\AmeriaPayment\AmeriaPaymentService;

class Shopware_Controllers_Frontend_PaymentAmeria extends Shopware_Controllers_Frontend_Payment
{    
    const PAYMENTSTATUSOPEN = 17;

    public function preDispatch()
    {
        /** @var \Shopware\Components\Plugin $plugin */
        $plugin = $this->get('kernel')->getPlugins()['GenPaymentAmeria'];

        $this->get('template')->addTemplateDir($plugin->getPath() . '/Resources/views/');
    }

    /**
     * Index action method.
     *
     * Forwards to the correct action.
     */
//    1
    public function indexAction()
    {
        /**
         * Check if one of the payment methods is selected. Else return to default controller.
         */
        switch ($this->getPaymentShortName()) {
            case 'ameria_payment_cc':
                return $this->redirect(['action' => 'direct', 'forceSecure' => true]);
            default:
                return $this->redirect(['controller' => 'checkout']);
        }
    }

    /**
     * Direct action method.
     *
     * Collects the payment information and transmits it to the payment provider.
     */
//    2
    public function directAction()
    {
        $providerUrl = $this->getProviderUrl();
        $this->redirect($providerUrl . $this->getUrlParameters());
    }

    /**
     * Return action method
     *
     * Reads the transactionResult and represents it for the customer.
     */
//    6
    public function returnAction()
    {
        /** @var AmeriaPaymentService $service */
        $service = $this->container->get('gen_payment_ameria.ameria_payment_service');
        $user = $this->getUser();
        $billing = $user['billingaddress'];
        /** @var PaymentResponse $response */
        $response = $service->createPaymentResponse($this->Request());
        $token = $service->createPaymentToken($this->getAmount(), $billing['customernumber']);

        if (!$service->isValidToken($response, $token)) {
            $this->forward('cancel');

            return;
        }

        switch ($response->status) {
            case 'accepted':
                $orderNumber = $this->saveOrder(
                    $response->transactionId,
                    $response->token,
                    self::PAYMENTSTATUSOPEN
                );                
                
                $responseRegister = http_build_query($this->registerPay($orderNumber));     
                parse_str($responseRegister, $responseRegisterDb);  
                
                //insert to db payment id
                if ($responseRegisterDb['ResponseCode'] == 1){
                    $ameriaPaymentID = $responseRegisterDb['PaymentID'];
                    $orderId = Shopware()->Db()->fetchOne(
                        'SELECT id
                        FROM s_order           
                        WHERE s_order.ordernumber = :ordernumber',            
                        ['ordernumber' => $orderNumber]
                    );
                    if ($orderId && $ameriaPaymentID){
                        Shopware()->Db()->query(
                            'UPDATE s_order_attributes
                            SET s_order_attributes.ameria_payment_id = :ameria_paymentId
                            WHERE s_order_attributes.orderID = :orderID',
                            ['orderID' => $orderId, 'ameria_paymentId' => $ameriaPaymentID]           
                        ); 
                    }                    
                }                
                
                $this->redirect(['controller' => 'PaymentProvider', 'action' => 'pay', 'response' => $responseRegister]);
                break;
            default:
                $this->forward('cancel');
                break;
        }
    }
//    6.1
    //register pay and get payment provider order number
    private function registerPay($orderNumber){        
        
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenPaymentAmeria');
        $order = Shopware()->Modules()->Order();
        
        $db = Shopware()->Db();
        $shopId = $db->fetchOne(
            'SELECT currency_id FROM s_core_shops WHERE host = ?',
            [$_SERVER['HTTP_HOST']]
        );     
        $currencyName = $db->fetchOne(
            'SELECT currency FROM s_core_currencies WHERE id = ?',
            [$shopId]
        );        
        $currencies = ['AMD' => '051','RUB' => '643','USD' => '840','EUR' => '978'];        
        $currency = $currencies[$currencyName];        
        
        $apiClientId = $config['testmode'] ? $config['api_test_client_id'] : $config['api_client_id'];
        $apiUserName = $config['testmode'] ? $config['api_test_user_name'] : $config['api_user_name'];
        $apiPass = $config['testmode'] ? $config['api_test_pass'] : $config['api_pass'];
        $providerUrl = $config['testmode'] ? 'https://servicestest.ameriabank.am/VPOS/api/VPOS/' : 'https://ipay.arca.am/payment/rest/';
        //$amount = floatval($order->sAmount)*100;
        $amount = floatval($order->sAmount);
        if ($currencyName == 'AMD'){
            $language = 'am';
        }else if ($currencyName == 'RUB'){
            $language = 'ru';
        }else{
            $language = 'en';
        }
        $paramOrderNumber = ['orderNumber' => $orderNumber];
        $returnUrl = Shopware()->Front()->Router()->assemble(['controller' => 'PaymentProvider', 'action' => 'payfinish', 'ordernumber' => $orderNumber]);
        
//        custom
        $description = 'Masisy.com';
        $amount = 10;
        //$orderNumber = 2357723;        
        
        // Создаём Post запрос                     
        # Our new data
        $data = [
            'Currency' => $currency,
            'ClientID' => $apiClientId,
            'Username' => $apiUserName,
            'Password' => $apiPass,
            'Amount' => $amount,
            'Description' => $description,
            'OrderID' => (int)$orderNumber,
            'BackURL' => $returnUrl,
            'Opaque' => $paramOrderNumber,
        ];
        
        # Create a connection
        $url = $providerUrl . 'InitPayment?';        
        $ch = curl_init($url);
        # Form data string
        $postString = http_build_query($data);      
        # Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Get json response and convert to php array
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);           
        return $response;        
    }

    /**
     * Cancel action method
     */
    public function cancelAction()
    {
    }

    /**
     * Creates the url parameters
     */
//    4
    private function getUrlParameters()
    {        
        /** @var AmeriaPaymentService $service */
        $service = $this->container->get('gen_payment_ameria.ameria_payment_service');
        $router = $this->Front()->Router();
        $user = $this->getUser();
        $billing = $user['billingaddress'];

        $parameter = [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrencyShortName(),
            'firstName' => $billing['firstname'],
            'lastName' => $billing['lastname'],
            'returnUrl' => $router->assemble(['action' => 'return', 'forceSecure' => true]),
            'cancelUrl' => $router->assemble(['action' => 'cancel', 'forceSecure' => true]),
            'token' => $service->createPaymentToken($this->getAmount(), $billing['customernumber'])            
        ];

        return '?' . http_build_query($parameter);
    }    
    
    /**
     * Returns the URL of the payment provider. This has to be replaced with the real payment provider URL
     *
     * @return string
     */
//    3
    protected function getProviderUrl()
    {
        return $this->Front()->Router()->assemble(['controller' => 'PaymentProvider', 'action' => 'payRegister']);
    }
}
