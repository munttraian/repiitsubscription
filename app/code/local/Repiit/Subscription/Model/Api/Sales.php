<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/6/2016
 * Time: 9:58 PM
 */

class Repiit_Subscription_Model_Api_Sales extends Repiit_Subscription_Model_Api
{

    protected $_order;
    protected $_orderItem;
    protected $_orderProduct;
    protected $_billingAddress;
    protected $_shippingAddress;
    protected $_dataMapped = array();

    /**
     * @param $order
     */
    public function __construct($order)
    {
        $this->setOrder($order);
    }

    public function setOrder($order)
    {
        $this->_order = $order;
        $this->_shippingAddress = $order->getShippingAddress();
        $this->_billingAddress = $order->getBillingAddress();
        $this->_orderItem = $this->getOrderItem();
        $this->_orderProduct = $this->getOrderProduct();
    }

    /**
     * @return string
     */
    protected function getDataset()
    {
        return "DAT";
    }

    /**
     * @return int
     */
    protected function getRownumber()
    {
        return $this->_orderProduct->getSubscriptionId();
    }

    /**
     * @return Mage_Sales_Flat_Order_Item
     */
    protected function getOrderItem()
    {
        $orderedItems = $this->_order->getAllVisibleItems();
        $orderedProductIds = [];

        foreach ($orderedItems as $item) {
            $orderedProductIds[] = $item->getData('product_id');
        }

        return $item;
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    protected function getOrderProduct()
    {
        $orderedItems = $this->_order->getAllVisibleItems();
        $orderedProductIds = [];

        foreach ($orderedItems as $item) {
            $orderedProductIds[] = $item->getData('product_id');
        }

        if (!count($orderedProductIds)) return;

        $product = Mage::getModel('catalog/product')->load($orderedProductIds[0]);

        return $product;
    }

    /**
     * @return datetime
     */
    protected function getLastchanged()
    {
        return $this->_order->getUpdatedAt();
    }

    /**
     * @return string
     */
    protected function getSearchname()
    {
        return "search string";
    }

    /**
     * @return datetime
     */
    protected function getCreated()
    {
        return $this->_order->getCreatedAt();
    }

    /**
     * @return datetime
     */
    protected function getNextdeliverydate()
    {
        return "2017-02-23T00:00:00";
    }

    /**
     * @return string
     */
    protected function getCustomer()
    {
        return "customer";
    }


    /**
     * @return string
     */
    protected function getName()
    {
        return $this->_billingAddress->getFirstname() . " " . $this->_billingAddress->getLastname();
    }

    /**
     * @return string
     */
    protected function getAddress1()
    {
        return $this->_billingAddress->getStreet();
    }

    /**
     * @return string
     */
    protected function getAddress2()
    {
        return $this->_billingAddress->getStreet();
    }

    /**
     * @return string
     */
    protected function getZipcity()
    {
        return $this->_billingAddress->getPostcode() . " ". $this->_billingAddress->getCity();
    }

    /**
     * @return mixed
     */
    protected function getCountry()
    {
        $countryModel = Mage::getModel('directory/country')->loadByCode($this->_billingAddress->getCountryId());

        $countryName = $countryModel->getName();

        return $countryName;
    }

    /**
     * @return string
     */
    protected function getAttention()
    {
        return "sample string";
    }

    /**
     * @return mixed
     */
    protected function getPhone()
    {
        return $this->_billingAddress->getTelephone();
    }

    /**
     * @return string
     */
    protected function getGroup()
    {
        return "sample string";
    }

    /**
     * @return string
     */
    protected function getFixeddiscpct()
    {
        return "1.0";
    }


    /**
     * @return varchar
     */
    protected function getCurrency()
    {
        return $this->_order->getOrderCurrencyCode();
    }

    /**
     * @return string
     */
    protected function getLanguage()
    {
        return '1';
    }

    /**
     * @return string
     */
    protected function getVat()
    {
        return '1';
    }

    /**
     * @return mixed
     */
    protected function getDlvaddress1()
    {
        return $this->_shippingAddress->getStreet();
    }

    /**
     * @return mixed
     */
    protected function getDlvaddress2()
    {
        return $this->_shippingAddress->getStreet();
    }

    /**
     * @return string
     */
    protected function getDlvzipcity()
    {
        return $this->_shippingAddress->getPostcode() . " " . $this->_shippingAddress->getCity();
    }

    /**
     * @return mixed
     */
    protected function getDlvcountry()
    {
        $countryModel = Mage::getModel('directory/country')->loadByCode($this->_billingAddress->getCountryId());

        $countryName = $countryModel->getName();

        return $countryName;
    }

    /**
     * @return string
     */
    protected function getYourref()
    {
        return 'sample string';
    }

    /**
     * @return string
     */
    protected function getOurref()
    {
        return 'sample string';
    }

    /**
     * @return string
     */
    protected function getReferencenumber()
    {
        return 'sample string';
    }

    /**
     * @return float
     */
    protected function getDiscount()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getFeetaxable()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getVatamount()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getInvoiceamount()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getLinevat()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getOrderbalance()
    {
        return 1.0;
    }

    /**
     * @return float
     */
    protected function getVatbase()
    {
        return 1.0;
    }

    /**
     * @return mixed
     */
    protected function getEmail()
    {
        return $this->_order->getCustomerEmail();
    }

    /**
     * @return mixed
     */
    protected function getDlvemail()
    {
        return $this->_shippingAddress->getEmail();
    }

    /**
     * @return string
     */
    protected function getCancelled()
    {
        return "2017-02-23T00:00:00";
    }

    /**
     * @return mixed
     */
    protected function getItemnumber()
    {
        return $this->_orderItem->getSku();
    }
    /**
     * @return mixed
     */
    protected function getQty()
    {
        return $this->_orderItem->getQty();
    }

    /**
     * @return mixed
     */
    protected function getPrice()
    {
        return $this->_orderItem->getPrice();
    }

    /**
     * @return mixed
     */
    protected function getItemtxt()
    {
        return $this->_orderProduct->getSubscriptionDescription();
    }

    /**
     * @return string
     */
    protected function getUnitcode()
    {
        return 'unitcode';
    }

    /**
     * @return mixed
     */
    protected function getPriceunit()
    {
        return $this->_orderItem->getPrice();
    }

    /**
     * @return mixed
     */
    protected function getCostprice()
    {
        return $this->_orderItem->getBaseCost();
    }

    /**
     * @return mixed
     */
    protected function getVoucher()
    {
        return $this->_order->getCouponCode();
    }

    /**
     * @return string
     */
    protected function getInvoicenumber()
    {
        return '0';
    }

    protected function getInvoicedate()
    {
        return '0';
    }

    /**
     *
     */
    protected function mapData() {

        $this->_dataMapped = array(
            "DATASET" => $this->getDataset(),
            "ROWNUMBER" => $this->getRownumber(),
            "LASTCHANGED" => $this->getLastchanged(),
            "NUMBER_" => $this->getRownumber(),
            "SEARCHNAME" => $this->getSearchname(),
            "CREATED" => $this->getCreated(),
            "NEXTDELIVERYDATE" => $this->getNextdeliverydate(),
            "ACCOUNT" => $this->getAccount(),
            "NAME" => $this->getName(),
            "ADDRESS1" => $this->getAddress1(),
            "ADDRESS2" => $this->getAddress2(),
            "ZIPCITY" => $this->getZipcity(),
            "COUNTRY" => $this->getCountry(),
            "ATTENTION" => $this->getAttention(),
            "PHONE" => $this->getPhone(),
            "GROUP_" => $this->getGroup(),
            "FIXEDDISCPCT" => $this->Fixeddiscpct(),
            "CURRENCY" => $this->getCurrency(),
            "LANGUAGE_" => $this->getLanguage(),
            "VAT" => $this->getVat(),
            "DLVADDRESS1" => $this->getDlvaddress1(),
            "DLVADDRESS2" => $this->getDlvaddress2(),
            "DLVZIPCITY" => $this->getDlvzipcity(),
            "DLVCOUNTRY" => $this->getDlvcountry(),
            "YOURREF" => $this->getYourself(),
            "OURREF" => $this->getOurref(),
            "REFERENCENUMBER" => $this->getReferencenumber(),
            "DISCOUNT" => $this->getDiscount(),
            "FEETAXABLE" => $this->getFeetaxable(),
            "VATAMOUNT" => $this->getVatamount(),
            "INVOICEAMOUNT" => $this->getInvoiceamount(),
            "LINEVAT" => $this->getLinevat(),
            "ORDERBALANCE" => $this->getOrderbalance(),
            "VATBASE" => $this->getVatbase(),
            "EMAIL" => $this->getEmail(),
            "DLVEMAIL" => $this->getDlvemail(),
            "CANCELLED" => $this->getCancelled(),
            "ITEMNUMBER" => $this->getItemnumber(),
            "QTY" => $this->getQty(),
            "PRICE" => $this->getPrice(),
            "ITEMTXT" => $this->getItemtxt(),
            "UNITCODE" => $this->getUnitcode(),
            "COSTPRICE" => $this->getCostprice(),
            "PRICEUNIT" => $this->getPriceunit(),
            "VOUCHER" => $this->getVoucher(),
            "INVOICENUMBER" => $this->getInvoicenumber(),
            "INVOICEDATE" => $this->getInvoicedate()
        );
    }

    /**
     * @return mixed|string
     */
    public function sendOrderToRepiit()
    {
        $helper = Mage::helper('Repiit_Subscription');
        $apiUrl = $this->getApiUrl() . "SalesTableAr";
        $key = $this->getAuthorizationKey();

        $ret = $this->curlPut($apiUrl, $key, $this->_dataMapped);

        return $ret;

    }
}