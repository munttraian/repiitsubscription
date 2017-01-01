<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 9:48 PM
 */

$installer = $this;

$installer->startSetup();

$read = Mage::getSingleton('core/resource')->getConnection('core_read');

$results = $read->query("DESC `". $this->getTable('sales/order') . "`");

$columnExists = 0;

foreach ($results as $result)
    if ($result['Field'] == "is_subscription") $columnExists = 1;

if (!$columnExists) $installer->getConnection()->addColumn($this->getTable('sales/order'), 'is_subscription', 'tinyint(1) NOT NULL default 0');

$installer->endSetup();