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
        return (int)$this->_order->getSubscriptionId();
    }

    /**
     * @return string
     */
    protected function getNumber()
    {
        return (string)$this->_order->getSubscriptionId();
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
    protected function getAccount()
    {
        return 'test';
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
        return (string)$this->_billingAddress->getFirstname() . " " . $this->_billingAddress->getLastname();
    }

    /**
     * @return string
     */
    protected function getAddress1()
    {
        return is_array($this->_billingAddress->getStreet())?(string)$this->_billingAddress->getStreet()[0]:(string)$this->_billingAddress->getStreet();
    }

    /**
     * @return string
     */
    protected function getAddress2()
    {
        return (is_array($this->_billingAddress->getStreet()) && isset($this->_billingAddress->getStreet()[1]) )?(string)$this->_billingAddress->getStreet()[1]:'';
    }

    /**
     * @return string
     */
    protected function getZipcity()
    {
        $zipcity = $this->_billingAddress->getPostcode() . " ". $this->_billingAddress->getCity();
        return (string)$zipcity;
    }

    /**
     * @return string
     */
    protected function getCountry()
    {
        $countryModel = Mage::getModel('directory/country')->loadByCode($this->_billingAddress->getCountryId());

        $countryName = $countryModel->getName();

        return (string)$countryName;
    }

    /**
     * @return string
     */
    protected function getAttention()
    {
        return (string)"sample string";
    }

    /**
     * @return mixed
     */
    protected function getPhone()
    {
        return (string)$this->_billingAddress->getTelephone();
    }

    /**
     * @return string
     */
    protected function getGroup()
    {
        return (string)"sample";
    }

    /**
     * @return string
     */
    protected function getFixeddiscpct()
    {
        return (float) 1.0;
    }


    /**
     * @return varchar
     */
    protected function getCurrency()
    {
        return (string)$this->_order->getOrderCurrencyCode();
    }

    /**
     * @return int
     */
    protected function getLanguage()
    {
        return 1;
    }

    /**
     * @return string
     */
    protected function getVat()
    {
        return (string)'1';
    }

    /**
     * @return string
     */
    protected function getDlvaddress1()
    {
        return is_array($this->_shippingAddress->getStreet())?(string)$this->_shippingAddress->getStreet()[0]:(string)$this->_shippingAddress->getStreet();
    }

    /**
     * @return string
     */
    protected function getDlvaddress2()
    {
        return (is_array($this->_shippingAddress->getStreet()) && isset($this->_shippingAddress->getStreet()[1]))?(string)$this->_shippingAddress->getStreet()[1]:'';
    }

    /**
     * @return string
     */
    protected function getDlvzipcity()
    {
        $dlvzipcity = $this->_shippingAddress->getPostcode() . " " . $this->_shippingAddress->getCity();
        return (string)$dlvzipcity;
    }

    /**
     * @return string
     */
    protected function getDlvcountry()
    {
        $countryModel = Mage::getModel('directory/country')->loadByCode($this->_billingAddress->getCountryId());

        $countryName = $countryModel->getName();

        return (string)$countryName;
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
     * @return string
     */
    protected function getEmail()
    {
        return (string)$this->_order->getCustomerEmail();
    }

    /**
     * @return string
     */
    protected function getDlvemail()
    {
        return (string)$this->_shippingAddress->getEmail();
    }

    /**
     * @return string
     */
    protected function getCancelled()
    {
        return "2017-02-23T00:00:00";
    }

    /**
     * @return string
     */
    protected function getItemnumber()
    {
        return (string)$this->_orderItem->getSku();
    }
    /**
     * @return float
     */
    protected function getQty()
    {
        return (float)$this->_orderItem->getQtyOrdered();
    }

    /**
     * @return float
     */
    protected function getPrice()
    {
        return (float)$this->_orderItem->getPrice();
    }

    /**
     * @return string
     */
    protected function getItemtxt()
    {
        return (string)$this->_orderProduct->getSubscriptionDescription();
    }

    /**
     * @return string
     */
    protected function getUnitcode()
    {
        return 'unitcode';
    }

    /**
     * @return string
     */
    protected function getPriceunit()
    {
        return (string)$this->_orderItem->getPrice();
    }

    /**
     * @return float
     */
    protected function getCostprice()
    {
        return (float)$this->_orderItem->getBaseCost();
    }

    /**
     * @return string
     */
    protected function getVoucher()
    {
        return (string)$this->_order->getCouponCode();
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
        return '2017-02-23T00:00:00';
    }

    /**
     *
     */
    protected function mapData() {

        $this->_dataMapped = array(
            "DATASET" => $this->getDataset(),
            "ROWNUMBER" => $this->getRownumber(),
            "LASTCHANGED" => $this->getLastchanged(),
            "NUMBER_" => $this->getNumber(),
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
            "FIXEDDISCPCT" => $this->getFixeddiscpct(),
            "CURRENCY" => $this->getCurrency(),
            "LANGUAGE_" => $this->getLanguage(),
            "VAT" => $this->getVat(),
            "DLVADDRESS1" => $this->getDlvaddress1(),
            "DLVADDRESS2" => $this->getDlvaddress2(),
            "DLVZIPCITY" => $this->getDlvzipcity(),
            "DLVCOUNTRY" => $this->getDlvcountry(),
            "YOURREF" => $this->getYourref(),
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

        $apiUrl = $this->getApiUrl() . "SalesTableAr";
        $key = $this->getAuthorizationKey();

        $this->mapData();
        Mage::log(json_encode($this->_dataMapped));

        if ($this->_dataMapped['ROWNUMBER']) $ret = $this->curlPut($apiUrl, $key, json_encode($this->_dataMapped));
        else $ret = $this->curlPostBody($apiUrl, $key, json_encode($this->_dataMapped));

        $retJson = json_decode($ret, true);

        if (!$ret || !is_array($retJson)) return false;

        if ($retJson['ROWNUMBER']) return $retJson['ROWNUMBER'];

        return false;

    }
}