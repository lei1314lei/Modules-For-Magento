<?php

class Xtwocn_Debug_TestController extends Mage_Core_Controller_Front_Action{

    public function moduleAction()
    {
        //Mage_Catalog_Model_Resource_Category_Indexer_Product
        $object=Mage::getModel('catalog/category_indexer_product');
        var_dump(get_class($object->getResource()),Mage::getResourceSingleton('catalog/category_indexer_product'));exit;
//       $object=  Mage::getResourceHelper('eav');
//       var_dump($object);exit;
    }
    public function testAction()
    {
        $client = new SoapClient('http://www.bellecat.com/api/soap/?wsdl');

        // If somestuff requires api authentification,
        // then get a session token
        $session = $client->login('martin.t', '123456');

        $result = $client->call($session, 'order.list');
        var_dump ($result);exit;
    }
    
    public function indexAction(){
        
        $resource       = Mage::getModel('customer/customer');
        $table=$resource->getAttribute('password_hash')->getBackend()->getTable();
        
        $connection=Mage::getSingleton('core/resource')->getConnection('write');

        $tableName='customer_entity_varchar';
        
        $tableData[] = array(
                        'entity_id'      => 140,
                        'entity_type_id' => 1,
                        'attribute_id'   => 12,
                        'value'          => NULL
        );
        $connection->insertOnDuplicate($tableName, $tableData, array('value'));
        var_dump($table);exit;
        
        $app=Mage::app();
        $routers=$app->getFrontController()->getRouters();
        foreach($routers as $router){
            echo "<hr>";
            var_dump($router);
        }
        echo 'breakpoint';exit;
    }
}

