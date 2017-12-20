<?php

class Xtwocn_Debug_Model_Logger extends Varien_Object{
    protected $_hasObserveTarge=false;
    protected $_targets=array();
    protected $_onlyLogObsTarget;
    /*
     * @params $methodPaths  
     * // objectType->methodName1,array(objectType->methodName2,objectType->methodName3)
     * methodName3 runs in methodName2 ; both methodName2 and methodName3 will be called when methodName1 runing, but there are not in methodName1
     * // objectType::methodName1,array(objectType::methodName2,objectType->methodName3)
     * This situation means methodName1 && methodName2 are static function
     * 
     */
    public function addObserveTarget()
    {
        $this->_targets[]=func_get_args();
    }
    public function setOnlyLogObsTarget($flag)
    {
        if(!isset($this->_onlyLogObsTarget))
        {
            $this->_onlyLogObsTarget=$flag?true:false;
        }else{
            throw new Exception("onlyLogObsTarget has been seted already");
        }
        return $this;
    }
    public function isOnlyLogObsTarget()
    {
        return $this->_onlyLogObsTarget?true:false;
    }
    public function calledByObsTarget()
    {
        $obj='Mage_Core_Model_Resource_Design';
        $func='loadChange';
        foreach($this->_targets as $methodPaths)
        {
            $debugger=new Xtwocn_Debug_Backtrace();
             if($debugger->isCalledBy($methodPaths))
             {
                 return array('method'=>json_encode($methodPaths));
             }
        }
        return false;
    }
    public function doLog($msg,$fileName='',$tips=false)
    { 
         if($this->isOnlyLogObsTarget())
         {
             
             if($called=$this->calledByObsTarget())
             {
                 // $fileName=$called['logInto']?$called['logInto']:$fileName;
                 $fileName=$fileName?$fileName:"Logger.log";
                 $this->_do($msg,$fileName,"=========={$called['method']}===========");
             }
         }else{
             
             $fileName=$fileName?$fileName:"Logger.log";
             $this->_do($msg,$fileName,$tips);
         }
    }
    protected function _do($msg,$fileName='',$tips=false)
    {
           if($tips)
           {
               Mage::log("=============$tips==============",null,$fileName);
           }else{
                
           }
           Mage::log("\r\n\r\n".(string)$msg."\r\n\r\n",null,$fileName);
    }
}

