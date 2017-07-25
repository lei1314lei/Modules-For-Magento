<?php

class Xtwocn_Debug_CatalogruleController extends Mage_Core_Controller_Front_Action{
    public function applyAllAction()
    {
         Mage::getModel('catalogrule/rule')->applyAll();exit;
    }
}

