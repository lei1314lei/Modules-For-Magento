<?php

//CalculateTotalsController.php
class Xtwocn_Debug_CalculateTotalsController extends Mage_Core_Controller_Front_Action{
    protected function _formatAndShow($collection)
    {
        foreach($collection as $key=>$item)
        {
            echo ("$key\r\n<br>".get_class($item)."<br><br>");
        }
    }
    public function getCollectorsAction()
    {
        $collectorFactory=Mage::getModel('sales/quote_address_total_collector');//Mage_Sales_Model_Quote_Address_Total_Collector
        $collectors=$collectorFactory->getCollectors();
        $this->_formatAndShow($collectors);
        exit;
        
    }
    public function getRetrieversAction()
    {
        $collectorFactory=Mage::getModel('sales/quote_address_total_collector');//Mage_Sales_Model_Quote_Address_Total_Collector
        $collectors=$collectorFactory->getRetrievers();
        $this->_formatAndShow($collectors);
        exit;
    }



    public function testAction(){

        try{
            
            $store=Mage::app()->getStore();
            $totalCollector = Mage::getSingleton(
                'sales/quote_address_total_collector',
                array('store' => $store)
            );
            
            $totalsConfigNode= 'global/sales/quote/totals' ;
            $totalsConfig = Mage::getConfig()->getNode($totalsConfigNode);
            $sorts = Mage::getStoreConfig('sales/totals_sort', $store);
            //var_dump(get_class_methods($totalsConfig));
            foreach($totalsConfig->children() as $cfg)
            {
                $classes[]=get_class(Mage::getModel((string)$cfg->class));
            }
            var_dump($this->sameParent($classes));
            var_dump($totalsConfig,$sorts);exit;
        } catch (Exception $ex) {
             var_dump($ex);exit;
        }
    }
}