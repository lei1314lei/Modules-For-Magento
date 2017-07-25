<?php

class Xtwocn_Debug_Cron_TriggerController extends Mage_Core_Controller_Front_Action{
    public function emialAction()
    {
        try{
            Mage::getModel('core/email_queue')->send();
        } catch (Exception $ex) {
            var_dump($ex);
        }
        echo 'trigger  email sending finished ';
    }
}

