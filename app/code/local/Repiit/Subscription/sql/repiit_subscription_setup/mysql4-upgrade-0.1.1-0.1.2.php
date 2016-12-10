<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 9:48 PM
 */

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_product', 'subscription_id', array(
    'type' => 'varchar',        // "varchar" for input type text box
    'group'     => 'Subscription',
    'backend' => '',
    'frontend' => '',
    'label' => "Subscription Id",
    'input' => 'label',    // "text" for input type text box
    'class' => '',
    'source' => '',            // Leave blank for input type text box
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
    'default' => '0',        //Leave blank for input type text box
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
));

$installer->endSetup();