<?php
class Shopware_Controllers_Frontend_PaymentProvider extends Enlight_Controller_Action
{
    const PAYMENTSTATUSPAID = 12;
    const PAYMENTSTATUSCANCELED = 35;
    
    public function preDispatch()
    {
        /** @var \Shopware\Components\Plugin $plugin */
        $plugin = $this->get('kernel')->getPlugins()['GenPaymentAmeria'];

        $this->get('template')->addTemplateDir($plugin->getPath() . '/Resources/views/');
    }
//5
    public function payRegisterAction()
    {         
        $returnUrl = $this->Request()->getParam('returnUrl') . '?' . http_build_query([
            'status' => 'accepted',
            'token' => $this->Request()->getParam('token'),
            'transactionId' => random_int(1000000000, 9999999999)
        ]);
        
        header("Location: $returnUrl"); exit;
    }
//    7
    public function payAction(){
        $responseUrl = $this->Request()->getParam('response');
        parse_str($responseUrl, $response);
        $paymentId = $response['PaymentID'];
        $ResponseCode = $response['ResponseCode'];
        $ResponseMessage = $response['ResponseMessage'];     
        
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenPaymentAmeria');
        $db = Shopware()->Db();
        $shopId = $db->fetchOne(
            'SELECT currency_id FROM s_core_shops WHERE host = ?',
            [$_SERVER['HTTP_HOST']]
        );     
        $currencyName = $db->fetchOne(
            'SELECT currency FROM s_core_currencies WHERE id = ?',
            [$shopId]
        );      
        if ($currencyName == 'AMD'){
            $language = 'am';
        }
        else if($currencyName == 'RUB'){
            $language = 'ru';
        }    
        else{
            $language = 'en';
        }
        
        $payUrl = $config['testmode'] ? "https://servicestest.ameriabank.am/VPOS/Payments/Pay?id=$paymentId&lang=$language" : 'https://ipay.arca.am/payment/rest/';
        
        if ($ResponseCode == 1){
            header("Location: $payUrl");            
            exit;
        }else{            
             $this->redirect(['controller' => 'checkout', 'action' => 'cart', 'responseFromPay' => http_build_query($response)]);     
        }        
    }
//    8 from ameria pay page
    public function payfinishAction(){
        
        $ordernumber = $this->Request()->getParam('ordernumber');
        $orderId = $this->Request()->getParam('orderId');
        $paymentID = $this->Request()->getParam('paymentID');
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenPaymentAmeria');
        $apiUserName = $config['testmode'] ? $config['api_test_user_name'] : $config['api_user_name'];
        $apiPass = $config['testmode'] ? $config['api_test_pass'] : $config['api_pass'];
        $providerUrl = $config['testmode'] ? "https://servicestest.ameriabank.am/VPOS/api/VPOS/" : 'https://ipay.arca.am/payment/rest/';
        
        $db = Shopware()->Db();
        $shopId = $db->fetchOne(
            'SELECT currency_id FROM s_core_shops WHERE host = ?',
            [$_SERVER['HTTP_HOST']]
        );     
        $currencyName = $db->fetchOne(
            'SELECT currency FROM s_core_currencies WHERE id = ?',
            [$shopId]
        );      
//        if ($currencyName == 'AMD'){
//            $language = 'am';
//        }
//        else if($currencyName == 'RUB'){
//            $language = 'ru';
//        }    
//        else{
//            $language = 'en';
//        }
        $data = [
            'PaymentID' => $paymentID,
            'Username' => $apiUserName,
            'Password' => $apiPass,
        ];
        # Create a connection
        $url = $providerUrl . 'GetPaymentDetails?';        
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
        
        
        if ($response['ResponseCode'] == '00'){
            $paymentStatus = self::PAYMENTSTATUSPAID;            
        }else{
            $paymentStatus = self::PAYMENTSTATUSCANCELED;            
        }
        
        Shopware()->Db()->query(
                'UPDATE `s_order` SET `cleared` = ? WHERE `ordernumber` = ?',
                [$paymentStatus, $ordernumber]
            );
       
        $this->redirect(['controller' => 'checkout', 'action' => 'finish', 'PaymentDetails' => http_build_query($response)]);
    }
}
