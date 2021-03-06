<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 3:48 PM
 */

class Repiit_Click_Model_Sales_Order extends Mage_Core_Model_Abstract
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
        $shipprice = 0;
        $websiteId = 1;

        $websiteId = Mage::app()->getWebsite()->getId();
        $store = Mage::app()->getStore();

        // Start New Sales Order Quote
        $quote = Mage::getModel('sales/quote')->setStoreId($store->getId());

        // Set Sales Order Quote Currency
        $quote->setCurrency($this->getCurrency());

        // Assign Customer To Sales Order Quote
        $quote->assignCustomer($this->getCustomer());

        // Configure Notification
        //$quote->setSendCconfirmation(1);
        $productids = $this->getProductids();
        foreach ($productids as $id)
        {
            $product = Mage::getModel('catalog/product')->load($id);

            //set click data on product
            $product->setPrice($product->getClickdownloadPrice());

            $quote->addProduct($product, new Varien_Object(array('qty' => $this->getQty(), 'links' => $this->getLinks())));
        }

        // Set Sales Order Billing Address
        $billingAddress = $quote->getBillingAddress()->addData(
            $this->getBillingAddress()
        );

        // Set Sales Order Shipping Address
        $shippingAddress = $quote->getShippingAddress()->addData(
            $this->getShippingAddress()
        );

        if (empty($shipprice) || $shipprice == 0) {
            $shipmethod = 'freeshipping_freeshipping';
        }

        // Collect Rates and Set Shipping & Payment Method
        $shippingAddress->setFreeShipping(true)
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('freeshipping_freeshipping')
            ->setPaymentMethod('checkmo');

        // Set Sales Order Payment
        $quote->getPayment()->importData(array('method' => 'checkmo'));

        // Collect Totals & Save Quote
        //$quote->collectTotals()->save();
        $quote->save();

        try {
            // Create Order From Quote
            $service = Mage::getModel('sales/service_quote', $quote);
            $service->submitAll();
            $increment_id = $service->getOrder()->getRealOrderId();
        }
        catch (Exception $ex) {
            echo $ex->getMessage();
        }
        catch (Mage_Core_Exception $e) {
            echo $e->getMessage();
        }

        //invoice order
        if ($increment_id) Mage::helper('Repiit_Click')->invoiceOrder($service->getOrder());

        // Resource Clean-Up
        $quote = $customer = $service = null;

        // Finished
        return $increment_id;
    }

}