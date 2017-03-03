<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 3:48 PM
 */

class Repiit_Subscription_Model_Sales_Order extends Mage_Core_Model_Abstract
{

    protected $productids = array();
    protected $email;
    public $customer;
    protected $ba; //billing address
    protected $sa; //shipping address

    /*
     * Create order
     */
    public function createOrder()
    {
        $appEmulation = Mage::getSingleton('core/app_emulation');

        //Start environment emulation of the specified store
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation(Mage::app()->getStore()->getId());

        $shipprice = 0;
        $websiteId = 1;

        $websiteId = Mage::app()->getWebsite()->getId();
        Mage::app()->getStore()->setCurrentCurrencyCode('DKK');
        $store = Mage::app()->getStore();

        // Start New Sales Order Quote
        $quote = Mage::getModel('sales/quote')->setStoreId($store->getId());

        // Set Sales Order Quote Currency
        //$quote->setCurrency($this->getCurrency());
        $quote->setQuoteCurrencyCode($this->getCurrency());
        $quote->setStoreCurrencyCode($this->getCurrency());

        // Assign Customer To Sales Order Quote
        $quote->assignCustomer($this->getCustomer());

        //set coupon code
        $quote->setCouponCode($this->getCouponCode());

        // Configure Notification
        //$quote->setSendCconfirmation(1);
        $productids = $this->getProductids();
        foreach ($productids as $id)
        {
            $product = Mage::getModel('catalog/product')->load($id);

            //set subscription data on product
            $product->setPrice($product->getSubscriptionPrice());

            $quote->addProduct($product, new Varien_Object(array('qty' => $this->getQty())));
        }

        // Set Sales Order Billing Address
        $billingAddress = $quote->getBillingAddress()->addData(
            $this->getBillingAddress()
        );

        // Set Sales Order Shipping Address
        $shippingAddress = $quote->getShippingAddress()->addData(
            $this->getShippingAddress()
        );

        if ($shipprice == 0) {
            $shipmethod = 'freeshipping_freeshipping';
        }

        $shippingAddress->setShippingMethod('freeshipping_freeshipping');
        $shippingAddress->setFreeShipping(true);

        // Collect Rates and Set Shipping & Payment Method
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setPaymentMethod('checkmo');

        // Set Sales Order Payment
        $quote->getPayment()->importData(array('method' => 'checkmo'));

        // Collect Totals & Save Quote
        $quote->collectTotals()->save();

        try {
            // Create Order From Quote
            $service = Mage::getModel('sales/service_quote', $quote);
            $service->setOrderData($this->getOrderData());
            $service->submitAll();
            $increment_id = $service->getOrder()->getRealOrderId();
        }
        catch (Exception $ex) {
            echo $ex->getMessage();
        }
        catch (Mage_Core_Exception $e) {
            echo $e->getMessage();
        }


        //Stop environment emulation and restore original store
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Resource Clean-Up
        $quote = $customer = $service = null;

        // Finished
        return $increment_id;
    }

}