<?php

use GenPaymentAcba\Components\AcbaPayment\PaymentResponse;
use GenPaymentAcba\Components\AcbaPayment\AcbaPaymentService;

class Shopware_Controllers_Frontend_PaymentAcba extends Shopware_Controllers_Frontend_Payment
{    
    const PAYMENTSTATUSOPEN = 17;

    public function preDispatch()
    {
        /** @var \Shopware\Components\Plugin $plugin */
        $plugin = $this->get('kernel')->getPlugins()['GenPaymentAcba'];

        $this->get('template')->addTemplateDir($plugin->getPath() . '/Resources/views/');
    }

    /**
     * Index action method.
     *
     * Forwards to the correct action.
     */
    public function indexAction()
    {
        /**
         * Check if one of the payment methods is selected. Else return to default controller.
         */
        switch ($this->getPaymentShortName()) {
            case 'acba_payment_cc':
                return $this->redirect(['action' => 'direct', 'forceSecure' => true]);
            default:
                return $this->redirect(['controller' => 'checkout']);
        }
    }

    /**
     * Gateway action method.
     *
     * Collects the payment information and transmit it to the payment provider.
     */
    public function gatewayAction()
    {
        $providerUrl = $this->getProviderUrl();
        $this->View()->assign('gatewayUrl', $providerUrl . $this->getUrlParameters());
    }

    /**
     * Direct action method.
     *
     * Collects the payment information and transmits it to the payment provider.
     */
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
    public function returnAction()
    {
        /** @var AcbaPaymentService $service */
        $service = $this->container->get('gen_payment_acba.acba_payment_service');
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
                
                $this->redirect(['controller' => 'PaymentProvider', 'action' => 'pay', 'response' => $responseRegister]);
                break;
            default:
                $this->forward('cancel');
                break;
        }
    }
    
    //register pay and get payment provider order number
    private function registerPay($orderNumber){        
        
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenPaymentAcba');
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
        
        $apiUserName = $config['testmode'] ? $config['api_test_user_name'] : $config['api_user_name'];
        $apiPass = $config['testmode'] ? $config['api_test_pass'] : $config['api_pass'];
        $providerUrl = $config['testmode'] ? 'https://ipaytest.arca.am:8445/payment/rest/' : 'https://ipay.arca.am/payment/rest/';
        $amount = floatval($order->sAmount)*100;
        if ($currencyName == 'AMD' || $currencyName == 'RUB'){
            $language = 'ru';
        }else{
            $language = 'en';
        }
        $paramOrderNumper = ['orderNumber' => $orderNumber];
        $returnUrl = Shopware()->Front()->Router()->assemble(['controller' => 'PaymentProvider', 'action' => 'payfinish', 'ordernumber' => $orderNumber]);
        
        if ($order->deviceType == 'mobile'){
            $pageView = 'MOBILE';
        }else{
            $pageView = 'DESCTOP';
        }        
                  
        // Создаём Post запрос                     
        # Our new data
        $data = [
            'currency' => $currency,
            'userName' => $apiUserName,
            'password' => $apiPass,
            'amount' => (int)$amount,
            'language' => $language,            
            'orderNumber' => $orderNumber,
            'returnUrl' => $returnUrl,
            'jsonParams' => $paramOrderNumper,
            'pageView' => $pageView,
        ];
        
        # Create a connection
        $url = $providerUrl . 'register.do?';        
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
    private function getUrlParameters()
    {        
        /** @var AcbaPaymentService $service */
        $service = $this->container->get('gen_payment_acba.acba_payment_service');
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
    protected function getProviderUrl()
    {
        return $this->Front()->Router()->assemble(['controller' => 'PaymentProvider', 'action' => 'payRegister']);
    }
}
