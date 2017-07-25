<?php

class Xtwocn_Debug_IndexerController extends Mage_Core_Controller_Front_Action{


    public function testAction()
    {
        $eventsCollection = Mage::getResourceModel('index/event_collection');
        $eventsCollection->addProcessFilter($this, Mage_Index_Model_Process::EVENT_STATUS_NEW);
        echo $eventsCollection->getSelect();
    }
    
    protected function _processses()
    {
        $indexerInterFace=Mage::getModel('index/indexer');
        return $indexerInterFace->getProcessesCollection();
    }
    public function processesAction()
    {
        foreach($this->_processses() as $process)
        {
            
            $processCode=$process->getData('indexer_code');
            echo $processCode,"  (",get_class($process),")","<br>";
//            echo get_class($indexerInterFace->getProcessByCode($processCode));
//            echo "&nbsp;";
            var_dump($process->debug());
        }
    }
    public function indexersAction()
    {
        try{
            foreach($this->_processses() as $process)
            {
                $code=$process->getData('indexer_code');
                $xmlPath = Mage_Index_Model_Process::XML_PATH_INDEXER_DATA . '/' . $code;
                $config = Mage::getConfig()->getNode($xmlPath);
                if (!$config || empty($config->model)) {
                    Mage::throwException(Mage::helper('index')->__('Indexer model is not defined.'));
                }
                $model = Mage::getModel((string)$config->model);
                if ($model instanceof Mage_Index_Model_Indexer_Abstract) {
                    echo "$code : <span style='color:red'> ".get_class($model)."</span><br><br>";
                    $reflection=new ReflectionClass (get_class($model));
                    echo "<br>parentClass:",$reflection->getParentClass()->getName() ,"<br>"; 
                    $this->_indexer = $model;
                } else {
                    Mage::throwException(Mage::helper('index')->__('Indexer model should extend Mage_Index_Model_Indexer_Abstract.'));
                }
            } 
        } catch (Exception $ex) {
            var_dump($ex);
        }
    }
}
