<?php
class Xtwocn_Debug_ConfigController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
        var_dump(Mage::getResourceSingleton('catalog/category'));
        exit;
        $model='hero';
        $resourceModel = (string)Mage::getConfig()->getNode()->global->models->{$model}->resourceModel;
        var_dump($resourceModel);
    }
}

