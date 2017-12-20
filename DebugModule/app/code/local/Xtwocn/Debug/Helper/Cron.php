<?php

class Xtwocn_Debug_Helper_Cron extends Mage_Core_Helper_Abstract{
    public function getWhiteList()
    {
        $str=Mage::getStoreConfig('debug/cron/whitelist');
        if($str)
        {
            return explode(',',$str);
        }
        return array();
    }
    public function _enable_only_whitelist()
    {
        return Mage::getStoreConfig('debug/cron/enable_only_whitelist')?true:false;
    }
    public function filterJobs()
    {
        $whiteList=$this->getWhiteList();
        $nodes = array('crontab/jobs', 'default/crontab/jobs');
        foreach ($nodes as $node) {
            $codesNotInWL=array();
            $jobs = Mage::getConfig()->getNode($node);
            if ($jobs && $jobs->hasChildren()) {
                foreach ($jobs->children() as $code => $child) {
                    if(!in_array($code, $whiteList))
                    {
                        $codesNotInWL[]=$code;
                    }
                }
            } 
            if($this->_enable_only_whitelist())
            {
                foreach($codesNotInWL as $code)
                {
                    unset ($jobs->$code);
                }
            }
        }
        $this->_handleExistSchedules();
    }
    protected function _handleExistSchedules()
    {
        if($this->_enable_only_whitelist())
        {
            //delete exist schedules
            $resource=Mage::getSingleton('core/resource');
            $table=$resource->getTableName('cron/schedule');
            $connection=$resource->getConnection('core/write');
            $connection->delete($table);
            // clear cache
            Mage::app()->removeCache(Mage_Cron_Model_Observer::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT);
        }
    }
    
}

