<?php

class Xtwocn_Debug_CheckoutController extends Mage_Core_Controller_Front_Action{
    protected $_httpClient;
    
    public function currencyAction()
    {

        var_dump(Mage::getModel('wirecard/upop')->canUseForCurrency('CNY'));exit;
        
        $store=Mage::app()->getStore();
        $c=$store->getBaseCurrency();
        var_dump($c,$store->getData());exit;
    }
    
    public function paymentMethodsAction()
    {
        $layout=$this->getLayout();
        $methodsBlock=$layout->createBlock('checkout/onepage_payment_methods');
        $methods=$methodsBlock->getMethods();
        var_dump($methods);
        
    }
    
    
    public function testAction()
    {
//        $config=Mage::getStoreConfig('payment/wrcd_alipayxborder');
//        $configObj=new Varien_Object($config);
//        $merchantAccountId=$configObj->getData('merchant-account-id');   
//        var_dump($merchantAccountId);
        
        $alipayInfo=Mage::getModel('wirecard/AlipayxborderPayinfo');
               echo $alipayInfo->getNode()->asXML();
        var_dump( get_class_methods($alipayInfo->getNode()));exit;
    }
    public function indexAction()
    {
        //Xtwocn_Wirecard_Model_AlipayxborderPayinfo
        $model= Mage::getModel('wirecard/alipayxborderPayinfo');
        var_dump($model->getNode('merchant-account-id'),get_class_methods($model));exit;
        
        new Mage_Core_Model_Config_Base();
       /*
                $payment         = $observer->getPayment();
                $this->_order    = $payment->getOrder();
                $storeId         = $this->_order->getStoreId();
                $paymentInstance = $payment->getMethodInstance();

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
*/
       // new Zend_Http_Client_Adapter_Socket();
            $httpClient=$this->_getZendHttpClient();
            $header[] = "Content-type: application/xml";      //定义content-type为xml,注意是数组
            $credentials="70000-APITEST-AP:qD2wzQ_hrc!8"; 
            $header[] ="Authorization: Basic " . base64_encode($credentials) ;
           
            $httpClient->setHeaders('Content-type',"application/xml");
            $httpClient->setHeaders('Authorization',"Basic " . base64_encode($credentials));
            
//            $requestId=time();
//            $httpClient->setParameterPost('request-id',$requestId);
//            
//            $paymentMethod='alipay-xborder';
//            $httpClient ->setParameterPost('payment-methods.payment-method-name',$paymentMethod);
//            
//            $merchantAccountId='7ca48aa0-ab12-4560-ab4a-af1c477cce43';
//            $httpClient->setParameterPost('merchant-account-id',$merchantAccountId);
//            $transactionType='debit';
//            $httpClient->setParameterPost('transaction-type',$transactionType);
//
//            $accountFirstName='Max-';
//            $httpClient->setParameterPost('account-holder.first-namespace',$accountFirstName);  
//            $accountLastName='Cavalera';
//            $httpClient->setParameterPost('account-holder.last-name',$accountLastName);
//            $accountLastEmail="max.cavalera@wirecard.com";
//            $httpClient->setParameterPost('account-holder.email',$accountLastEmail);
//                
//            $requestedAmount=0.1;
//            $httpClient->setParameterPost('requested-amount',$requestedAmount);
            $timestamp=time();
            $successUrl=Mage::getUrl('wirecard/payment/success');
            $failUrl=Mage::getUrl('wirecard/payment/fail');
            $orderIncrementId=123456;
            $currency='USD';
            $xmlData="<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
            <payment xmlns='http://www.elastic-payments.com/schema/payment'>
                <payment-methods>
                    <payment-method name='alipay-xborder'/>
                </payment-methods>
                <merchant-account-id>7ca48aa0-ab12-4560-ab4a-af1c477cce43</merchant-account-id>
                <request-id>xtwostore-cn-test-$timestamp</request-id>
                <transaction-type>debit</transaction-type>
                <requested-amount currency='$currency'>0.1</requested-amount>

                <order-detail>Test product 001</order-detail>
                <ip-address>127.0.0.1</ip-address>
                <locale>en</locale>
                <success-redirect-url>$successUrl</success-redirect-url>
                <fail-redirect-url>$failUrl</fail-redirect-url>
                <order-number>$orderIncrementId</order-number>
                <account-holder>
                    <first-name>Max-</first-name>
                    <last-name>Cavalera</last-name>
                    <email>max.cavalera@wirecard.com</email> 
                </account-holder>
            </payment>";
            $httpClient->setRawData($xmlData);
            
            $response=$httpClient->request(Zend_Http_Client::POST);
            
            
            $sortedConfig = new Mage_Core_Model_Config_Base();
            $sortedConfig->loadString($response->getBody());
            
            var_dump($response,$sortedConfig->getNode('statuses'),$sortedConfig,get_class_methods($response));
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
    public function setZendHttpClient($client)
    {
        $this->_httpClient=$client;
    }
    
}
