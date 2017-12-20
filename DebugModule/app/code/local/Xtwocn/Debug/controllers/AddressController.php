<?php

class Xtwocn_Debug_AddressController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $id=391091886;
        $address=Mage::getModel('sales/quote_address')->load($id);
        $city=$address->getCity()?trim($address->getCity()):null;
        $lastname=$address->getLastname()?trim($address->getLastname()):null;
        $firstname=empty($address->getFirstname())?trim($address->getFirstname()):null;
         var_dump($address->getStreet());exit;
        $street=$address->getStreet()?trim($address->getStreet()):null;
        $postcode=$address->getPostcode()?trim($address->getPostcode()):null;
       
    }
}
