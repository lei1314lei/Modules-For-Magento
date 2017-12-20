<?php

class Xtwocn_Debug_Helper_Data extends Mage_Core_Helper_Abstract{

    public function hintTemplate(){
        $request=$this->_getRequest();
        $params=$request->getParams();
        if(isset($params['debug'])){
            return true;
        }else{
            return false;
        }
    }
    public function showLayoutXml(){
        $request=$this->_getRequest();
        $params=$request->getParams();
        if(isset($params['showLayoutXml'])){
            return true;
        }else{
            return false;
        }
    }
    public function xmlToHtml($xmlString){
        return "<pre>".htmlentities($xmlString)."</pre>";
    }
}
