<?php

class Xtwocn_Debug_PriceIndexController extends Mage_Core_Controller_Front_Action{
    public function reindexAllAction()
    {
         Mage::getModel('index/process')->load(2)->reindexAll();exit;
    }
    public function testAction()
    {
        $product=Mage::getModel('catalog/product')->load(231);
        var_dump($product->getFinalPrice());exit;
    }
    public function priceTypeIndexersAction()
    {
             $types = Mage::getSingleton('catalog/product_type')->getTypesByPriority();
            foreach ($types as $typeId => $typeInfo) {
                if (isset($typeInfo['price_indexer'])) {
                    $modelName = $typeInfo['price_indexer'];
                } else {
                    $modelName = 'catalog/product_indexer_price_default';
                }
                $isComposite = !empty($typeInfo['composite']);
                $indexer = Mage::getResourceModel($modelName)
                    ->setTypeId($typeId)
                    ->setIsComposite($isComposite);

                var_dump($typeId,get_class($indexer));
            }
    }
    public function productTypeAction()
    {
            $types = Mage::getSingleton('catalog/product_type')->getTypesByPriority();
            foreach ($types as $typeId => $typeInfo) {
                if (isset($typeInfo['price_indexer'])) {
                    $modelName = $typeInfo['price_indexer'];
                } else {
                    $modelName = 'catalog/product_indexer_price_default';
                }
                $isComposite = !empty($typeInfo['composite']);
                $indexer = Mage::getResourceModel($modelName)
                    ->setTypeId($typeId)
                    ->setIsComposite($isComposite);
                var_dump($typeId, get_class()) ;
            }
    }
}