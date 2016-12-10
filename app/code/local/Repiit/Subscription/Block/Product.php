<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/21/2016
 * Time: 2:29 PM
 */

class Repiit_Subscription_Block_Product extends Mage_Catalog_Block_Product {

    public $redirectLink = "";

    public function getSubscriptionData(array $excludeAttr = array())
    {
        $data = array();
        $product = Mage::registry('current_product');

        $attributeSetId = $product->getAttributeSetId();
        $subscriptionGroupName = Mage::helper('Repiit_Subscription')->getSubscriptionAttributeGroup();
        $subscriptionGroupId = Mage::helper('Repiit_Subscription')->getAttributeGroupId($attributeSetId, $subscriptionGroupName);

        $attributes = $product->getAttributes($subscriptionGroupId);
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

    public function getSubscriptionDataConfigurable(array $excludeAttr = array())
    {

        $data = array();
        $product = Mage::registry('current_product');

        $childProductsIds = $product->getTypeInstance()->getUsedProductIds();

        $attributeSetId = $product->getAttributeSetId();
        $subscriptionGroupName = Mage::helper('Repiit_Subscription')->getSubscriptionAttributeGroup();
        $subscriptionGroupId = Mage::helper('Repiit_Subscription')->getAttributeGroupId($attributeSetId, $subscriptionGroupName);

        foreach ($childProductsIds as $simpleId) {

            $sProduct = Mage::getModel('catalog/product')->load($simpleId);

            $attributes = $sProduct->getAttributes($subscriptionGroupId);

            foreach ($attributes as $attribute) {
    //            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                    $value = $attribute->getFrontend()->getValue($sProduct);

                    if (!$sProduct->hasData($attribute->getAttributeCode())) {
                        $value = Mage::helper('catalog')->__('N/A');
                    } elseif ((string)$value == '') {
                        $value = Mage::helper('catalog')->__('No');
                    } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                        $value = Mage::app()->getStore()->convertPrice($value, true);
                    }

                    if (is_string($value) && strlen($value)) {
                        $data[$simpleId][$attribute->getAttributeCode()] = array(
                            'label' => $attribute->getStoreLabel(),
                            'value' => $value,
                            'code'  => $attribute->getAttributeCode()
                        );
                    }
                }
            }
        }

        return json_encode($data);

    }

}