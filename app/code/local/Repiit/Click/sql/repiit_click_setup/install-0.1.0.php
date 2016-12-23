<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/21/2016
 * Time: 9:21 PM
 */


$installer = $this;

$installer->startSetup();

//$installer->getConnection()->addColumn();
$installer->getConnection()->query("CREATE TABLE IF NOT EXISTS `repiitcredits` (`credit_id` INT(10) PRIMARY KEY AUTO_INCREMENT,
`customer_id` int(10) unsigned DEFAULT NULL,
`credits` INT(10),
`created_time` datetime,
`updated_time` datetime,
KEY(`customer_id`),
FOREIGN KEY (`customer_id`) REFERENCES `customer_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
)");

$installer->getConnection()->query("CREATE TABLE IF NOT EXISTS `repiitcredits_transaction`
(
  `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `credit_id` int(10),
  `customer_id` int(10) unsigned DEFAULT NULL,
  `customer_email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `action` varchar(63) NOT NULL,
  `store_id` smallint(5) NOT NULL,
  `credit_amount` int(11) NOT NULL DEFAULT '0',
  `credit_spent` int(11) NOT NULL DEFAULT '0',
  `real_credits` int(11) NOT NULL DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `expiration_time` datetime DEFAULT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `order_increment_id` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY (`credit_id`),
  KEY (`customer_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `repiitcredits` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`credit_id`) REFERENCES `repiitcredits` (`credit_id`) ON DELETE SET NULL ON UPDATE CASCADE
)");

$installer->endSetup();