<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/21/2016
 * Time: 2:29 PM
 */

class Repiit_Click_Block_Product extends Mage_Catalog_Block_Product {

    public $redirectLink = "";

    public function getClickData(array $excludeAttr = array())
    {
        $data = array();
        $product = Mage::registry('current_product');

        $attributeSetId = $product->getAttributeSetId();
        $clickGroupName = Mage::helper('Repiit_Click')->getClickDownloadAttributeGroup();
        $clickGroupId = Mage::helper('Repiit_Click')->getAttributeGroupId($attributeSetId, $clickGroupName);

        $attributes = $product->getAttributes($clickGroupId);
        foreach ($attributes as $attribute) {
//            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = Mage::helper('catalog')->__('N/A');
                } elseif ((string)$value == '') {
                    $value = Mage::helper('catalog')->__('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }

                if (is_string($value) && strlen($value)) {
                    $data[$attribute->getAttributeCode()] = array(
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code'  => $attribute->getAttributeCode()
                    );
                }
            }
        }
        return $data;
    }
}