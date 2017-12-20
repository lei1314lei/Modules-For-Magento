<?php

class Xtwocn_Debug_SslController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
                
            $timestamp=time();
            $successUrl='http://localhost/wirecard/payment/success';
            $failUrl='http://localhost/wirecard/payment/fail';
            $currency='GBP';
            $orderIncrementId='abcd';
            $xmlData="<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
            <payment xmlns='http://www.elastic-payments.com/schema/payment'>
                <merchant-account-id>7ca48aa0-ab12-4560-ab4a-af1c477cce43</merchant-account-id>
                <account-holder>
                    <first-name>Max-</first-name>
                    <last-name>Cavalera</last-name>
                    <email>max.cavalera@wirecard.com</email> 
                </account-holder>
                <transaction-type>debit</transaction-type>
                <payment-methods>
                    <payment-method name='alipay-xborder'/>
                </payment-methods>
                <success-redirect-url>$successUrl</success-redirect-url>
                <fail-redirect-url>$failUrl</fail-redirect-url>
                <request-id>xtwostore-cn-test-$timestamp</request-id>
                <requested-amount currency='$currency'>0.1</requested-amount>
                <order-detail>Test product 001</order-detail>
                <order-number>$orderIncrementId</order-number>
            </payment>";

                $url = 'https://api-test.wirecard.com/engine/rest/paymentmethods/'; //接收xml数据的文件
                $url = 'https://test.local/ssl.php';
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
               // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
//curl_setopt($ch, CURLOPT_CAINFO,  'D:/ca/ca.crt'); 
//                curl_setopt($ch,CURLOPT_SSLCERT,'D:/ca/server.crt');
//                curl_setopt($ch,CURLOPT_SSLCERTTYPE,'DER');
//                curl_setopt($ch,CURLOPT_SSLKEY,'D:/ca/D:/ca/server.key');
                //
                $response = curl_exec($ch);
                if(curl_errno($ch)){
                    print curl_error($ch);
                }
                curl_close($ch);
                echo $response;
    }
}

