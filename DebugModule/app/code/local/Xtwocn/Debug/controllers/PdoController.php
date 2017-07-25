<?php

class Xtwocn_Debug_PdoController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $setUpd=new Xtwocn_Hero_Model_Resource_Setup();
        var_dump(get_class_methods($setUpd->getConnection()));
    }
}
