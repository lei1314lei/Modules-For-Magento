<?php

class Xtwocn_Debug_Model_Observer{
    public function debugBlock(Varien_Event_Observer $observer){
        $block=$observer->getEvent()->getBlock();
        $helper=Mage::helper('xtwocndebug');
        $app=Mage::app();
        if($helper->showLayoutXml()){
            if($block->getNameInLayout()=='root'){
                $layoutString=$app->getLayout()->getUpdate()->asString();
                echo ($helper->xmlToHtml($layoutString)) ; exit;
            }
        }
        if($helper->hintTemplate()){
            if($block instanceof Mage_Core_Block_Template){
                $app->getStore()->setConfig(Mage_Core_Block_Template::XML_PATH_DEBUG_TEMPLATE_HINTS,1);
                $app->getStore()->setConfig(Mage_Core_Block_Template::XML_PATH_DEBUG_TEMPLATE_HINTS_BLOCKS,1);
            }
 
        }
    }
    public function debugAction(Varien_Event_Observer $observer){
        try{
            $action=$observer->getEvent()->getControllerAction();
            $request=$action->getRequest();
            $cf=Mage::app()->getConfig()->getNode('debug');

            $module=$request->getModuleName();
            $controller=$request->getControllerName();
            $action=$request->getActionName();
            $requestUri=$request->getRequestUri();
            $debugMessage=":wrap module:$module :wrap controller:$controller :wrap action:$action :wrap requestUri:$requestUri :wrap :wrap :wrap";
            //两种方式  echo优先级更高

            $debugWay=$request->getParam('debugAction');
            if(!$debugWay) $debugWay=(int)$cf->logs->action->on?"log":null;
            if($debugWay=='echo'){
                echo preg_replace('/:wrap/', "<br>", $debugMessage);
            }elseif($debugWay=='log'){
                $debugMessage=preg_replace('/:wrap/', "\r\n", $debugMessage);
                $fileName=(string)$cf->logs->action->fileName;
                if(!$fileName){
                    $fileName="debug_action.log";
                }
                Mage::log($debugMessage,null,$fileName);
            }
        }catch(Exception $e){
            Mage::log($e->getMessage(),null,'debug.log');
        }
       
        
        

    }
}
