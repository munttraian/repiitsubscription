<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/10/2016
 * Time: 5:52 PM
 */

class Repiit_Subscription_Model_Api_Item extends Repiit_Subscription_Model_Api
{
    //get item by id
    /**
     * @param $apiUrl
     * @param $key
     * @param $itemId
     * @return string: json format|error message
     */
    public function getItemData($apiUrl, $key, $itemId)
    {
        //construct apiUrl = apiUrl /Item [/ItemId]
        $apiUrl = $apiUrl . "Item" . ((isset($itemId) && $itemId)?"/" .$itemId:"");

        $response = $this->curlGet($apiUrl, $key);

        return $response;
    }

    //post item
    /**
     * @param $postData
     * @return mixed|string
     */
    public function createItem($postData)
    {
        $helper = Mage::helper('Repiit_Subscription');
        //$apiUrl = $this->getApiUrl() . "Item" . $helper->makeUrl($postData);
        $apiUrl = $this->getApiUrl() . "Item";

        $jsonData = json_encode($postData);

        Mage::log($apiUrl);

        $key = $this->getAuthorizationKey();

        Mage::log($key);

        $ret = $this->curlPostBody($apiUrl, $key, $jsonData);

        return $ret;
    }

    //put item - modify
    /**
     * @param $jsonData
     * @return mixed
     */
    public function modifyItem($jsonData)
    {
        $helper = Mage::helper('Repiit_Subscription');
        $apiUrl = $this->getApiUrl() . "Item";
        $key = $this->getAuthorizationKey();

        $ret = $this->curlPut($apiUrl, $key, $jsonData);

        return $ret;
    }
}