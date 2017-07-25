<?php

class Xtwocn_Debug_QuoteController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        var_dump(session_id()); 
        //exit;
        $customerSession=Mage::getSingleton('customer/session');
        
        if(!$customerSession->isLoggedIn())
        {
            Mage::getSingleton('customer/session')->login("547249121@qq.com",'123456');
        }
        
        $checkoutSession=Mage::getSingleton('checkout/session');
        var_dump($checkoutSession->getQuote()->getId(),$checkoutSession->getData());
        $checkoutSession->unsetAll();
        var_dump($checkoutSession->getData(),$_SESSION['checkout']);
        $storeId=1;
        $reservedOrderId=Mage::getSingleton('eav/config')->getEntityType(Mage_Sales_Model_Order::ENTITY)
            ->fetchNewIncrementId($storeId);
        var_dump($reservedOrderId);
    }
}