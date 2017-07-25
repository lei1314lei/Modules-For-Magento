<?php

class Xtwocn_Debug_PriceController extends Mage_Core_Controller_Front_Action{
   public function priceModelsAction()
   {
       $types= Mage_Catalog_Model_Product_Type::getTypes();
       foreach($types as $typeId=>$type)
       {
           echo "<hr>";
           var_dump($typeId,$type,get_class(Mage_Catalog_Model_Product_Type::priceFactory($typeId)));
       }
   }
    public function finalPriceAction()
    {
       Mage::getSingleton('customer/session')->login('547249121@qq.com','123456');
       
       $product=Mage::getModel('catalog/product')->load('410');
       var_dump($product->debug(),$product->getFinalPrice());exit;
    }
}

