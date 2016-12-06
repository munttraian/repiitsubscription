<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 9:48 PM
 */

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales/order'), 'is_subscription', 'tinyint(1) NOT NULL default 0');

$installer->endSetup();