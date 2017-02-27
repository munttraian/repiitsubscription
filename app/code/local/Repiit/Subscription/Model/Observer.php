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
                    "DATASET" => "DAT",
                    "ITEMNUMBER" => $data['sku'],
                    "ITEMTXT" => $data['name'],
                    "ITEMTEXT" => $data['name'],
                    "PRICE" => $data['subscription_price'],
                    "RULEID" => $data['subscription_intervals'],
                    "COSTPRICE" => 1,
                    "UNIT" => 1,
                    "DELIVERYTIME" => $data['subscription_deliverytime'],
                    "SUPPLIER" => $product->getAttributeText('manufacturer')
                );

                if ($data['subscription_id'])
                {
                    //item exists, modify it
                    $postData['rownumber'] = $data['subscription_id'];

                    //check if something has changed on subscription data
                    // if ($origData <> $data)

                    $jsonData = json_encode($postData);

                    $ret = Mage::getModel('repiit_subscription/api_item')->modifyItem($jsonData);

                    Mage::log($jsonData);
                    Mage::log($ret);
                }
                else
                {
                    //item does not exists, create it
                    $ret = Mage::getModel('repiit_subscription/api_item')->createItem($postData);

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


    /* Send order on repiit*/
    public function afterOrderSaved(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $order = $event->getOrder();

        if ($order->getSubscriptionId() || $order->getSubscriptionId <> 0) return; //already sent

        $realOrderId = (string)$order->getIncrementId();

        $repiitOrder = Mage::getModel('repiit_subscription/api_sales');
        $repiitOrder->setOrder($order);
        $ret = $repiitOrder->sendOrderToRepiit();

        $helper = Mage::helper('Repiit_Subscription');

        if ($ret) {
            $event->getOrder()->setSubscriptionId($ret);
            $helper->setOrderSubscriptionId($order->getId(), $ret);
        }

    }

    }