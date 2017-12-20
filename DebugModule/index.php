<?php
//$_SERVER["HTTPS"]="on";
//$_SERVER["HTTP_X_FORWARDED_PROTO"]="https";

if (false && (strpos($_SERVER['HTTP_X_FORWARDED_FOR'],'5.146.40.165')===false)) {

    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>xTWOstore - maintenance (<?php echo $_SERVER["HTTP_X_FORWARDED_FOR"] ?>)</title>
    </head>
    <body style="padding: 50px; text-align: center; font-size: 16px;">
    <img src="https://www.xtwostore.com/skin/frontend/rwd/xtwo/images/logo.png" alt="xTWOstore.com" class="large">
    <br/>
    <br><br>

    <strong>Wichtige Wartungsarbeiten</strong>
    <p>
        Sehr geehrter xTWOstore Kunde, das System wird momentan gewartet<br/> und ist bald wieder für Sie online.<br>
        <br>
        <em>Ihr xTWOstore Team</em>
    </p>

    <br/><br/>

    <strong>Important Maintenance</strong>
    <p>
        Dear xTWOstore customers, we will be back online soon.<br>
        Please visit us again later.<br><br>
        <em>Your xTWOstore Team</em>
    </p>

    <br><br>

    <strong>Entretien Important</strong>
    <p>
        Chers clients de xTWOstore, nous serons bientôt de retour en ligne.<br>
        S'il vous plaît nous rendre visite plus tard.<br/><br/>
        <em>Ton xTWOstore équipe</em>
    </p>

    </body>
    </html>
    <?php
    exit;
}

/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage
 * @copyright Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


if ('/hersteller.html/' == @$_SERVER['REQUEST_URI']) {
    header("Location: /hersteller.html", true, 302);
    exit;
}

if ('/manufacturer.html/' == @$_SERVER['REQUEST_URI']) {
    header("Location: /manufacturer.html", true, 302);
    exit;
}

if (version_compare(phpversion(), '5.3.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
Whoops, it looks like you have an invalid PHP version.</h3></div><p>Magento supports PHP 5.3.0 or newer.
<a href="http://www.magentocommerce.com/install" target="">Find out</a> how to install</a>
 Magento using PHP-CGI as a work-around.</p></div>';
    exit;
}

/**
 * Error reporting
 */
error_reporting(E_ALL | E_STRICT);

/**
 * Compilation includes configuration file
 */
define('MAGENTO_ROOT', getcwd());

$compilerConfig = MAGENTO_ROOT . '/includes/config.php';
if (file_exists($compilerConfig)) {
    include $compilerConfig;
}

$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
$maintenanceFile = 'maintenance.flag';

if (!file_exists($mageFilename)) {
    if (is_dir('downloader')) {
        header("Location: downloader");
    } else {
        echo $mageFilename." was not found";
    }
    exit;
}

if (file_exists($maintenanceFile)) {
    include_once dirname(__FILE__) . '/errors/503.php';
    exit;
}

require_once $mageFilename;

Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
    Mage::setIsDeveloperMode(true);
}
$queryLogger=new Xtwocn_Debug_Model_Logger();
$queryLogger->setOnlyLogObsTarget(true);
////$return=$debugger->isCalledBy('Mage_Core_Controller_Varien_Front->dispatch',array('Xtwocn_Debug_IndexController->indexAction','Mage::getModel'));
//$queryLogger->addObserveTarget("Mage_Catalog_Model_Resource_Category_Indexer_Product->reindexAll");
//$queryLogger->addObserveTarget('Mage_Core_Model_Resource_Design->loadChange');
//$queryLogger->addObserveTarget(array("Xtwocn_Hero_Model_Resource_Catalog_Category_Indexer_Product->reindexAll","Magento_Db_Adapter_Pdo_Mysql->query"));
//$queryLogger->addObserveTarget(array("Xtwocn_Hero_Model_Resource_Catalog_Category_Indexer_Product->reindexAll"));
$queryLogger->addObserveTarget(array("Xtwocn_Hero_Model_Resource_Merchandiser_Merchandiser->getOutofStockProducts"));
$queryLogger->addObserveTarget(array("Xtwocn_Hero_Model_Resource_Merchandiser_Merchandiser->getMaxInstockPositionFromCategory"));
$queryLogger->addObserveTarget(array("Xtwocn_Hero_Model_Resource_Merchandiser_Merchandiser->getSaleCategoryProducts"));

Mage::register('queryLogger',$queryLogger);

/*if($_GET['bedebug'] == 2) {
	ini_set('display_errors', 1);
}*/
umask(0);

/* Store or website code */
$mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';

/* Run store or run website */
$mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';


$deStores = array('vh-ch006-martin.de','xtwostore_local.de', 'xtwostore.de', 'www.xtwostore.yunicon.net', 'staging-ce.xtwostore.yunicon.net');
$comStores = array('vh-ch006-martin.com','xtwostore_local.com', 'xtwostore.com', 'com.xtwostore.yunicon.net', 'staging-ce-com.xtwostore.yunicon.net');
$frStores = array('vh-ch006-martin.fr','xtwostore_local.fr', 'xtwostore.fr', 'fr.xtwostore.yunicon.net', 'staging-ce-fr.xtwostore.yunicon.net');
$cnStores = array('vh-ch006-martin.cn','xtwostore_local.cn', 'xtwostore.cn', 'cn.xtwostore.yunicon.net', 'cnstore.xtwostore.de', 'staging-ce-cn.xtwostore.yunicon.net');


if (in_array($_SERVER['HTTP_HOST'], $deStores)) {
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'xtwostore_de';

} else if (in_array($_SERVER['HTTP_HOST'], $frStores))  {
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'xtwostore_fr';

} else if (in_array($_SERVER['HTTP_HOST'], $comStores))  {
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'xtwostore_com';

} else if (in_array($_SERVER['HTTP_HOST'], $cnStores))  {
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'xtwostore_cn';
}
//var_dump($_SERVER['HTTP_HOST'],$mageRunCode, $mageRunType);exit;
Mage::run($mageRunCode, $mageRunType);