<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/5/2016
 * Time: 10:14 PM
 */

class Repiit_Subscription_Model_Customer_Fieldmapper
{
    protected $arrFieldMapper = array(
        "name" => "NAME",
        "repiit_customerid" => "ROWNUMBER",
        "email" => "EMAIL",
        "phone" => "PHONE",
        "vat_id" => "VATNUMBER"
    );

    public function getFieldName($key)
    {
        return isset($this->arrFieldMapper[$key])?$this->arrFieldMapper[$key]:'';
    }
}