<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/19/2016
 * Time: 9:48 PM
 */

function getProductAttribute($code)
{
    $model = Mage::getModel('catalog/resource_eav_attribute');
    $model->loadByCode(Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId(), $code);

    return $model;
}

function attributeExists($code)
{
    $model = getProductAttribute($code);

    if (!$model || !$model->getId()) return false;

    return true;
}

function getAttributeGroup($attributeSetId, $name)
{
    $collection = Mage::getResourceModel('eav/entity_attribute_group_collection')
        ->addFieldToFilter('attribute_set_id',$attributeSetId)
        ->addFieldToFilter('attribute_group_name', $name);

    foreach ($collection as $item) $attributeGroupModel = $item;

    return $attributeGroupModel;
}

function createAttributeGroup($setId, $groupName)
{
    //create an attribute group instance
    $modelGroup = Mage::getModel('eav/entity_attribute_group');         //set the group name
    $modelGroup->setAttributeGroupName($groupName) //change group name
    //link to the current set
    ->setAttributeSetId($setId)
    //set the order in the set
    ->setSortOrder(100);
    //save the new group
    $modelGroup->save();
}

//create attribute
function createAttribute($code, $label, $attribute_type, $product_type = 0, $is_filterable = 0, $attribute_exists = 0, $source_model )
{
    if ($attribute_exists)
    {
        $_attribute_data = array(
            'attribute_code' => $code,
            'frontend_input' => $attribute_type,
            'apply_to' => array($product_type),
            'is_filterable' => $is_filterable,
            'frontend_label' => array($label),
            'source' => $source_model,
        );
    } else {
        $_attribute_data = array(
            'attribute_code' => $code,
            'is_global' => '0', //1 - global, 0 - non global
            'frontend_input' => $attribute_type, //'boolean',
            'default_value_text' => '',
            'default_value_yesno' => '0',
            'default_value_date' => '',
            'default_value_textarea' => '',
            'is_unique' => '0',
            'is_required' => '0',
            'apply_to' => array($product_type), //array('grouped')
            'is_configurable' => '0',
            'is_searchable' => '0',
            'is_visible_in_advanced_search' => '0',
            'is_comparable' => '0',
            'is_used_for_price_rules' => '0',
            'is_wysiwyg_enabled' => '0',
            'is_html_allowed_on_front' => '1',
            'is_visible_on_front' => '1',
            'is_filterable' => $is_filterable,
            'used_in_product_listing' => '0',
            'used_for_sort_by' => '0',
            'frontend_label' => array($label),
            'source' => $source_model,
        );
    }

    $model = Mage::getModel('catalog/resource_eav_attribute');
    $model->loadByCode(Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId(), $code);

    if (!isset($_attribute_data['is_configurable'])) {
        $_attribute_data['is_configurable'] = 0;
    }

    if (!isset($_attribute_data['is_filterable'])) {
        $_attribute_data['is_filterable'] = 0;
    }

    if (!isset($_attribute_data['is_filterable_in_search'])) {
        $_attribute_data['is_filterable_in_search'] = 0;
    }

    if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
        $_attribute_data['backend_type'] = $model->getBackendTypeByInput($_attribute_data['frontend_input']);
    }

    $defaultValueField = $model->getDefaultValueByInput($_attribute_data['frontend_input']);
    if ($defaultValueField) {
        //  $_attribute_data['default_value'] = $this->getRequest()->getParam($defaultValueField);
    }

    $model->addData($_attribute_data);

    $model->setEntityTypeId(Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId());
    $model->setIsUserDefined(1);

    try {
        $model->save();
        //$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        //-------------- add attribute to set and group

        //$attribute_code = $code;

        //$attribute_set_id=$setup->getAttributeSetId('catalog_product', $attribute_set_name);
        //$attribute_group_id=$setup->getAttributeGroupId('catalog_product', $attribute_set_id, $group_name);
        //$attribute_id=$setup->getAttributeId('catalog_product', $attribute_code);

        //$setup->addAttributeToSet($entityTypeId='catalog_product',$attribute_set_id, $attribute_group_id, $attribute_id);

    } catch (Exception $e) { echo '<p>Sorry, error occured while trying to save the attribute ' . $code . '. Error: '.$e->getMessage().'</p>' . "\n"; }
}

//========================Start Installer==================//

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

//======create attributes
$arrAttributes = array(
    0 => array("code" => "subscription_price",
                "label" => "Subscription Price",
                "attribute_type" => "price",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    1 => array("code" => "subscription_activ",
                "label" => "Subscription Activ",
                "attribute_type" => "boolean",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    2 => array("code" => "subscription_description",
                "label" => "Subscription Description",
                "attribute_type" => "text",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    /*
    3 => array("code" => "subscription_months",
                "label" => "Subscription Months",
                "attribute_type" => "select",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    4 => array("code" => "subscription_weeks",
                "label" => "Subscription Weeks",
                "attribute_type" => "select",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    5 => array("code" => "subscription_days",
                "label" => "Subscription Days",
                "attribute_type" => "select",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    6 => array("code" => "subscription_deliverytime",
                "label" => "Subscription Deliverytime",
                "attribute_type" => "date",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),
    */
    7 => array("code" => "subscription_delivery",
                "label" => "Subscription Delivery",
                "attribute_type" => "boolean",
                "product_type" => 0,
                "is_filterable" => 0,
                "attribute_exists" => 0),

);

foreach ($arrAttributes as $attribute)
{
    createAttribute($attribute['code'], $attribute['label'], $attribute['attribute_type'], $attribute['product_type'], $attribute['is_filterable'], $attribute['attribute_exists'], $attribute['source_model'] );
}

//=======create groups on sets
//get group name
$subscriptionGroupName = Mage::helper('Repiit_Subscription')->getSubscriptionAttributeGroup();

//get entity type id for product
$entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();

$collection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter($entityTypeId);

//add "Subscription" group to each attribute set
foreach ($collection as $item)
{
    $attributeSetId = $item->getId();

    $attributeGroup = getAttributeGroup($attributeSetId, $subscriptionGroupName);

    //create group if not exists
    if (!$attributeGroup || !$attributeGroup->getId())
    {
        createAttributeGroup($attributeSetId, $subscriptionGroupName);
        $attributeGroup = getAttributeGroup($attributeSetId, $subscriptionGroupName);
    }

    //add attributes to group and set
    $pos = 0;
    foreach ($arrAttributes as $attribute) {
        $pos++;
        $attribute_id = $setup->getAttributeId('catalog_product', $attribute['code']);
        $setup->addAttributeToSet('catalog_product', $attributeSetId, $attributeGroup->getId(), $attribute_id, $pos);
    }
}

$installer->endSetup();