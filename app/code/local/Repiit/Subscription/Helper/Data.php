<?php

class Repiit_Subscription_Helper_Data extends Mage_Core_Helper_Abstract {

    //get subscription attribute group name
    /**
     * @return string
     */
    public function getSubscriptionAttributeGroup()
    {
        return 'Subscription';
    }

    //get api subscription url
    /**
     * @return string
     */
    public function getSubscriptionUrl()
    {
        return Mage::getStoreConfig('repiitsubscription/api/redirect_url');
    }

    //get attribute group model by AttributeSetId and AttributeGroupName
    /**
     * @param $attributeSetId
     * @param $name - AttributeGroupName
     * @return Mage_Eav_Entity_Attribute_Group
     */
    public function getAttributeGroup($attributeSetId, $name)
    {
        $collection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->addFieldToFilter('attribute_set_id',$attributeSetId)
            ->addFieldToFilter('attribute_group_name', $name);

        foreach ($collection as $item) $attributeGroupModel = $item;

        return $attributeGroupModel;
    }

    //get attribute group id by AttributeSet and AttributeGroupName
    /**
     * @param $attributeSetId
     * @param $name - AttributeGroupName
     * @return int
     */
    public function getAttributeGroupId($attributeSetId, $name)
    {
        $collection = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->addFieldToFilter('attribute_set_id',$attributeSetId)
            ->addFieldToFilter('attribute_group_name', $name);

        foreach ($collection as $item) $attributeGroupModel = $item;

        return (isset($attributeGroupModel) && $attributeGroupModel)?$attributeGroupModel->getId():0;
    }

    //make url from params in array
    /**
     * @param $array - url get params in array format
     * @return string
     */
    public function makeUrl($array)
    {

        $retText = "";

        foreach ($array as $key => $value)
        {
            $retText .= "&" . $key . "=" . rawurlencode($value);
        }

        $retText = trim($retText, "&");
        $retText = "?" . $retText;

        return $retText;
    }

    //update attribute value using direct sql
    /**
     * @param $product_id
     * @param $attribute_code
     * @param $attribute_value
     * @param int $store_id
     * @return bool
     */
    public function updateProductAttribute($product_id, $attribute_code ,$attribute_value, $store_id = 0)
    {
        $resource = Mage::getSingleton('core/resource');
        $conn = $resource->getConnection('core_write');

        $entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();

        $sql = "SELECT attribute_id, backend_type FROM " . $resource->getTableName('eav/attribute') . " WHERE attribute_code = :attribute_code AND entity_type_id = :entity_type_id";
        $binds = array("attribute_code" => $attribute_code, "entity_type_id" => $entityTypeId);
        $results = $conn->fetchAll($sql, $binds);

        if (count($results)) {
            $attribute = $results[0];
            $backendType = $attribute['backend_type'];
            $attributeId = $attribute['attribute_id'];

            if (!$backendType) return false;
            if (!$attributeId) return false;

            $sql_upd = "INSERT INTO " . $resource->getTableName('catalog/product') . "_" . $backendType . " (entity_type_id, attribute_id, store_id, entity_id, value)
                        VALUES (:entity_type_id, :attribute_id, :store_id, :entity_id, :value)
                        ON DUPLICATE KEY UPDATE value = :value";
            $binds_upd = array("entity_type_id" => $entityTypeId,
                "attribute_id" => $attributeId,
                "store_id" => $store_id,
                "entity_id" => $product_id,
                "value" => $attribute_value
            );
            $conn->query($sql_upd, $binds_upd);

            return true;
        }

        return false;
    }

    //get default website
    public function getDefaultWebsite()
    {
        $websites = Mage::app()->getWebsites();

        if (is_array($websites))
        {
            foreach ($websites as $website) if ($website->getIsDefault()) return $website->getId();
        }

        return 0;
    }

    //check if children has subscription activ
    public function childrenHasSubscriptionActiv($product)
    {
        if ($product->getTypeId() != 'configurable') return false;

        $childProductsIds = $product->getTypeInstance()->getUsedProductIds();

        foreach ($childProductsIds as $simpleId)
        {
            $sProduct = Mage::getModel('catalog/product')->load($simpleId);
            if ($sProduct->getData('subscription_activ')) return true;
        }

        return false;
    }

    //get country_id by name
    function getCountryId($countryName) {
        $countryId = '';
        $countryCollection = Mage::getModel('directory/country')->getCollection();
        foreach ($countryCollection as $country) {
            if ($countryName == $country->getName()) {
                $countryId = $country->getCountryId();
                break;
            }
        }
        return $countryId;
    }
}

?>