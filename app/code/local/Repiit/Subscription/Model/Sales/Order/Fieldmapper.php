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

        "shipAddress1" => "DLVADDRESS1",
        "shipAddress2" => "DLVADDRESS2",
        "shipAddress3" => "DLVADDRESS3",
        "shipAddress4" => "DLVADDRESS4",
    );

    public function getFieldName($key)
    {
        return isset($this->arrFieldMapper[$key])?$this->arrFieldMapper[$key]:'';
    }
}