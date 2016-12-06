<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/21/2016
 * Time: 1:28 PM
 */

class Repiit_Subscription_Model_Observer
{

    /**
     * @param $observer
     */
    public function productSaveAfter($observer)
    {
        $event = $observer->getEvent();

        $product = $event->getProduct();

        $origData = $product->getOrigData();
        $data = $product->getData();

        try {
            //do action
            if ($data['subscription_activ']) {

                $ret = ""; //api return code

                $postData = array(
                    "itemNumber" => $data['sku'],
                    "itemText" => $data['name'],
                    "price" => $data['subscription_price'],
                    "ruleID" => "02",
                    "costPrice" => 1,
                    "unit" => 1,
                    "deliverytime" => 7,//$data['subscription_deliverytime'],
                    "supplier" => $product->getAttributeText('manufacturer')
                );

                if ($data['subscription_id'])
                {
                    //item exists, modify it
                    $postData['rownumber'] = $data['subscription_id'];

                    //check if something has changed on subscription data
                    // if ($origData <> $data)

                    $jsonData = json_encode($postData);

                    Mage::log($jsonData);
                }
                else
                {
                    //item does not exists, create it
                    $ret = Mage::getModel('repiit_subscription/api')->createItem($postData);

                    Mage::log($ret);

                    $jsonRet = json_decode($ret, true);

                    if (isset($jsonRet['ROWNUMBER']) && $jsonRet['ROWNUMBER'])
                    {
                        //update subscription_id on product
                        Mage::helper('Repiit_Subscription')->updateProductAttribute($product->getId(), 'subscription_id' , $jsonRet['ROWNUMBER'], 0);
                    }
                    else
                    {
                        Mage::log('Repiit Subscription - Error on saving product. Return code ' . $ret);
                    }

                }
            }
        }
        catch (Exception $e)
        {
            Mage::log('Repiit Subscription - Error on saving product. Return code ' . $ret . '. Message ' . $e->getMessage() );
        }
    }

}