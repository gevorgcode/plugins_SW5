<?php
class Shopware_Controllers_Frontend_PaymentProvider extends Enlight_Controller_Action
{
    const PAYMENTSTATUSPAID = 12;
    const PAYMENTSTATUSCANCELED = 35;
    
    public function preDispatch()
    {
        /** @var \Shopware\Components\Plugin $plugin */
        $plugin = $this->get('kernel')->getPlugins()['GenPaymentAcba'];

        $this->get('template')->addTemplateDir($plugin->getPath() . '/Resources/views/');
    }

    public function payRegisterAction()
    {         
        $returnUrl = $this->Request()->getParam('returnUrl') . '?' . http_build_query([
            'status' => 'accepted',
            'token' => $this->Request()->getParam('token'),
            'transactionId' => random_int(1000000000, 9999999999)
        ]);
        
        header("Location: $returnUrl"); exit;
    }
    
    public function payAction(){
        $response = $this->Request()->getParam('response');
        $formUrl = $response['formUrl'];
        if ($response['errorCode'] == 0){
            header("Location: $formUrl");
            exit;
        }else{
             $this->redirect(['controller' => 'checkout', 'action' => 'cart', 'responseFromPay' => http_build_query($response)]);                      
        }        
    }
    
    public function payfinishAction(){
        $ordernumber = $this->Request()->getParam('ordernumber');
        $orderId = $this->Request()->getParam('orderId');
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenPaymentAcba');
        $apiUserName = $config['testmode'] ? $config['api_test_user_name'] : $config['api_user_name'];
        $apiPass = $config['testmode'] ? $config['api_test_pass'] : $config['api_pass'];
        $providerUrl = $config['testmode'] ? 'https://ipaytest.arca.am:8445/payment/rest/' : 'https://ipay.arca.am/payment/rest/';
        
        $db = Shopware()->Db();
        $shopId = $db->fetchOne(
            'SELECT currency_id FROM s_core_shops WHERE host = ?',
            [$_SERVER['HTTP_HOST']]
        );     
        $currencyName = $db->fetchOne(
            'SELECT currency FROM s_core_currencies WHERE id = ?',
            [$shopId]
        );      
        if ($currencyName == 'AMD' || $currencyName == 'RUB'){
            $language = 'ru';
        }else{
            $language = 'en';
        }
        $data = [
            'userName' => $apiUserName,
            'password' => $apiPass,
            'orderId' => $orderId,
            'language' => $language,
        ];
        # Create a connection
        $url = $providerUrl . 'getOrderStatusExtended.do?';        
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
        
        if ($response['paymentAmountInfo']['paymentState'] == 'DEPOSITED'){
            $paymentStatus = self::PAYMENTSTATUSPAID;            
        }else{
            $paymentStatus = self::PAYMENTSTATUSCANCELED;            
        }
        
        Shopware()->Db()->query(
                'UPDATE `s_order` SET `cleared` = ? WHERE `ordernumber` = ?',
                [$paymentStatus, $ordernumber]
            );
        //$RedirectUrl = Shopware()->Front()->Router()->assemble(['controller' => 'checkout', 'action' => 'finish', 'ordernumber' => $orderNumber]);
        $this->redirect(['controller' => 'checkout', 'action' => 'finish', 'orderStatusExtended' => http_build_query($response)]);
    }
}
