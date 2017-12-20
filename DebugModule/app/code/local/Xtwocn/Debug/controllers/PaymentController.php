<?php

class Xtwocn_Debug_PaymentController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $cfg=Mage::getStoreConfig('payment/wrcd_alipayxborder');
        var_dump($cfg);exit;
    }
    public function testAction()
    {
         $quote=Mage::getSingleton('checkout/session')->getQuote();
         var_dump($quote->getId());exit;
    }
    public function methodsAction()
    {
       var_dump(Mage::app()->getConfig()->getNode('default/payment')) ;exit;
        $quoteId=309926646;
        $quote=Mage::getModel('sales/quote')->load($quoteId);
        if($quote->getId())
        {
            $store=$this->getRequest()->getParams('store');
            $store=$store?$store:null;
            $methods = Mage::helper('payment')->getStoreMethods($store,$quote);
            foreach($methods as $key=>$vale)
            {
                var_dump($key,get_class($vale));
            }
           
        }else{
            echo "there is no quote which's id is {$quoteId}";
        }
    }
    public function demoAction()
    {
//        $payment         = $observer->getPayment();
//        $this->_order    = $payment->getOrder();
//        $storeId         = $this->_order->getStoreId();
//        $paymentInstance = $payment->getMethodInstance();
        
        $paymentMethod='alipay-xborder';
        $merchantAccountId='pending';
        $requestId='MY-ORDER-1';
        $transactionType='debit';
        $requestedAmount=1.01;
        $currency='USD';
        $orderNumber=37530;
        $orderDetails='Test product 001';
        $ipAddress='127.0.0.1';
        $locale='en';
        $processingRedirectUrl='';
        $acHolderFirstName='Max';
        $acHolderLastname='Cavalera';
        $acHolderEmail='max.cavalera@wirecard.com';
        $xmlData="<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
     <payment xmlns='http://www.elastic-payments.com/schema/payment'>
         <payment-methods>
             <payment-method name='$paymentMethod'/>
         </payment-methods>
         <merchant-account-id>$merchantAccountId</merchant-account-id>
         <request-id>$requestId</request-id>
         <transaction-type>$transactionType</transaction-type>
         <requested-amount currency='$currency'>$requestedAmount</requested-amount>
         <order-number>$orderNumber</order-number>
         <order-detail>$orderDetails</order-detail>
         <ip-address>$ipAddress</ip-address>
         <locale>$locale</locale>
         <processing-redirect-url>$processingRedirectUrl</processing-redirect-url>
         <account-holder>
             <first-name>$acHolderFirstName</first-name>
             <last-name>$acHolderLastname</last-name>
             <email>$acHolderEmail</email>
         </account-holder>
     </payment>"   ;
        
//     $credentials="70000-APITEST-AP:qD2wzQ_hrc!8";
//     $httpClient=$this->_getZendHttpClient();
//     $httpClient->setHeaders(array('Conent-type'=>'application/xml','Authorization'=>'Basic '.base64_encode($credentials)));
//     $httpClient->setParameterPost('payment-methods.payment-method-name',$paymentMethod);
//     $httpClient->setParameterPost('merchant-account-id',$merchantAccountId);
//     $httpClient->setParameterPost('request-id',$requestId);
//     $httpClient->setParameterPost('transaction-type',$transactionType);
//     $httpClient->setParameterPost('requested-amount',$requestedAmount);
//     $httpClient->setParameterPost('requested-amount-currency',$currency);
//     $httpClient->setParameterPost('order-number',$orderNumber);
//     $httpClient->setParameterPost('order-detail',$orderDetails);
//     $httpClient->setParameterPost('ip-address',$ipAddress);
//     $httpClient->setParameterPost('processing-redirect-url',$processingRedirectUrl);
//     $httpClient->setParameterPost('account-holder.first-name',$acHolderFirstName);
//     $httpClient->setParameterPost('account-holder.last-name',$acHolderLastname);
//     $httpClient->setParameterPost('account-holder.email',$acHolderEmail);
//     $response=$httpClient->request(Zend_Http_Client::POST);
//     var_dump($response);exit;

    }
    
    public function demo2Action()
    {
$xmlData='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<payment xmlns="http://www.elastic-payments.com/schema/payment">
    <payment-methods>
        <payment-method name="alipay-xborder"/>
    </payment-methods>
    <merchant-account-id>7ca48aa0-ab12-4560-ab4a-af1c477cce43</merchant-account-id>
    <request-id>xtwostore-cn-test-5</request-id>
    <transaction-type>debit</transaction-type>
    <requested-amount currency="CNY">0.1</requested-amount>
    <order-number>37530</order-number>
    <order-detail>Test product 001</order-detail>
    <ip-address>127.0.0.1</ip-address>
    <locale>en</locale>
    <processing-redirect-url>http://test.local/paySuccesss.php</processing-redirect-url>
    <account-holder>
        <first-name>Max</first-name>
        <last-name>Cavalera</last-name>
        <email>max.cavalera@wirecard.com</email>
    </account-holder>
</payment>';
$timestamp=time();
$xmlData="<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<payment xmlns='http://www.elastic-payments.com/schema/payment'>
    <payment-methods>
        <payment-method name='alipay-xborder'/>
    </payment-methods>
    <merchant-account-id>7ca48aa0-ab12-4560-ab4a-af1c477cce43</merchant-account-id>
    <request-id>xtwostore-cn-test-$timestamp</request-id>
    <transaction-type>debit</transaction-type>
    <requested-amount currency='CNY'>0.1</requested-amount>
    <order-number>37530</order-number>
    <order-detail>Test product 001</order-detail>
    <ip-address>127.0.0.1</ip-address>
    <locale>en</locale>
    <processing-redirect-url>http://test.local/paySuccesss.php</processing-redirect-url>
    <account-holder>
        <first-name>Max</first-name>
        <last-name>Cavalera</last-name>
        <email>max.cavalera@wirecard.com</email> 
    </account-holder>
</payment>";
$url = 'https://api-test.wirecard.com/engine/rest/paymentmethods/'; //接收xml数据的文件
$header[] = "Content-type: application/xml";      //定义content-type为xml,注意是数组
$credentials="70000-APITEST-AP:qD2wzQ_hrc!8"; 
$header[] ="Authorization: Basic " . base64_encode($credentials) ;
$ch = curl_init ($url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $xmlData);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
$response = curl_exec($ch);
if(curl_errno($ch)){
    print curl_error($ch);
}
curl_close($ch);
echo($response) ;
        $sortedConfig = new Mage_Core_Model_Config_Base();
        $sortedConfig->loadString($response);
        $url=$sortedConfig->getNode('payment-methods/payment-method')->getAttribute('url');
        $this->_redirectUrl($url);return;
        var_dump(get_class_methods(Mage_Core_Model_Config_Element));
    }
    public function setZendHttpClient($client)
    {
        $this->_httpClient=$client;
    }
    protected function _getZendHttpClient()
    {
        if($this->_httpClient == null)
        {
            $this->setZendHttpClient(new Zend_Http_Client($this->_getRequestUrl()));
        }
        else
        {
            $this->_httpClient->resetParameters(true);
            $this->_httpClient->setUri($this->_getRequestUrl());
        }
        return $this->_httpClient;
    }
    
    protected function _getRequestUrl()
    {
        return 'https://api-test.wirecard.com/engine/rest/paymentmethods/';
    }
}
