<?php
include_once "Mage".DS."Cms".DS."controllers".DS."indexController.php";

class Xtwocn_Debug_Cms_IndexController extends Mage_Cms_IndexController{
    public function indexAction(){
        var_dump('haha');
        parent::indexAction();
    }
}
