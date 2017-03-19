<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/2/2016
 * Time: 12:36 PM
 */

class Repiit_Subscription_Model_Api_Customer extends Repiit_Subscription_Model_Api
{

    //get all customers from repiit
    /**
     * @return array
     */
    public function getAllCustomers()
    {
        $apiUrl = $this->getApiUrl() . "Customer";
        $key = $this->getAuthorizationKey();

        $customers = array();

        try {
            $ret = $this->curlGet($apiUrl,$key);

            $customers = json_decode($ret,true);

            return $customers;
        }
        catch (Exception $e)
        {
            Mage::logException("Error getting customers from repiit" . $e->getMessage());

            return false;
        }

    }

    //get customer from repiit by id
    /**
     * @param $customerId
     * @return bool|array
     */
    public function getCustomer($customerId)
    {
        $apiUrl = $this->getApiUrl() . "Customer/" . $customerId;
        $key = $this->getAuthorizationKey();

        try {
            $ret = $this->curlGet($apiUrl,$key);

            $customer = json_decode($ret, true);

            return $customer;
        }
        catch (Exception $e)
        {
            Mage::logException("Error getting customer with id " . $customerId . ". Message: " . $e->getMessage());

            return false;
        }

    }

    //get customer from repiit by email
    /**
     * @param $email
     * @return bool|array
     */
    public function getCustomerByEmail($email)
    {
        $apiUrl = $this->getApiUrl() . "Customer/GetCustomerByEmail?email=" . $email;
        $key = $this->getAuthorizationKey();

        try {
            $ret = $this->curlGet($apiUrl,$key);

            $customer = json_decode($ret, true);

            return $customer;
        }
        catch (Exception $e)
        {
            Mage::logException("Error getting customer by email" . $email . ". Message: " . $e->getMessage());

            return false;
        }
    }

    //get customer by attribute
    /**
     * @param $attributeCode
     * @param $attributeValue
     * @return bool|array
     */
    public function getCustomerByAttribute($attributeCode, $attributeValue)
    {
        $customers = $this->getAllCustomers();

        if (!$customers) return false;

        foreach ($customers as $customer)
        {
            if ($customer[$attributeCode] == $attributeValue) return $customer;
        }

        return false;
    }

    //create new customer on repiit
    /**
     * @param $customerData
     *
     */
    public function createCustomer($customerData)
    {
        $apiUrl = $this->getApiUrl() . "Customer";
        $key = $this->getAuthorizationKey();

        $ret = $this->curlPost($apiUrl,$key);
    }

}