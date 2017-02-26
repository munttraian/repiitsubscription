<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/5/2016
 * Time: 10:14 PM
 */

class Repiit_Subscription_Model_Sales_Order_Fieldmapper
{
    protected $arrFieldMapper = array(
        "name" => "NAME",
        "repiit_customerid" => "ROWNUMBER",
        "email" => "EMAIL",
        "phone" => "PHONE",
        "vat_id" => "VATNUMBER",
        "currency" => "CURRENCY",
        "address1" => "ADDRESS1",
        "address2" => "ADDRESS2",
        "telephone" => "PHONE",
        "city" => "ZIPCITY",
        "postcode" => "ZIPCITY",
        "country" => "COUNTRY",

        "shipAddress1" => "DLVADDRESS1",
        "shipAddress2" => "DLVADDRESS2",
        "shipAddress3" => "DLVADDRESS3",
        "shipAddress4" => "DLVADDRESS4",
        "shipCity" => "DLVZIPCITY",
        "shipPostcode" => "DLVZIPCITY",
        "shipCountry" => "DLVCOUNTRY"
    );

    /*
     * {
  "DATASET": "DAT",
  "ROWNUMBER": 130100,
  "LASTCHANGED": "2017-02-23T00:00:00",
  "NUMBER_": "130100",
  "SEARCHNAME": "search string",
  "CREATED": "2017-02-23T00:00:00",
  "NEXTDELIVERYDATE": "2017-02-23T00:00:00",
  "ACCOUNT": "customer",
  "NAME": "Søren Andersen",
  "ADDRESS1": "Fiskerihavnsgade 13",
  "ADDRESS2": "1st TH",
  "ZIPCITY": "6700 Esbjerg",
  "COUNTRY": "Denmark",
  "ATTENTION": "sample string",
  "PHONE": "+4575454888",
  "GROUP_": "sample string",
  "FIXEDDISCPCT": 1.0,
  "CURRENCY": "DKK",
  "LANGUAGE_": 1,
  "VAT": "sample string",
  "DLVADDRESS1": "Fiskerihavnsgade 13",
  "DLVADDRESS2": "1st TH",
  "DLVZIPCITY": "6700 Esbjerg",
  "DLVCOUNTRY": "Denmark",
  "YOURREF": "sample string",
  "OURREF": "sample string",
  "REFERENCENUMBER": "sample string",
  "DISCOUNT": 1.0,
  "FEETAXABLE": 1.0,
  "VATAMOUNT": 1.0,
  "INVOICEAMOUNT": 1.0,
  "LINEVAT": 1.0,
  "ORDERBALANCE": 1.0,
  "VATBASE": 1.0,
  "EMAIL": "sha@commit.dk",
  "DLVEMAIL": "sha@commit.dk",
  "CANCELLED": "2017-02-23T00:00:00",
  "ITEMNUMBER": "Item Number",
  "QTY": 1.0,
  "PRICE": 1.0,
  "ITEMTXT": "Text of the item",
  "UNITCODE": "string",
  "COSTPRICE": 1.0,
  "PRICEUNIT": "string",
  "VOUCHER": "string",
  "DELIVERYINTERVAL": 1
}
     */

    public function getFieldName($key)
    {
        return isset($this->arrFieldMapper[$key])?$this->arrFieldMapper[$key]:'';
    }
}