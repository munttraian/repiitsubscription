<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/23/2016
 * Time: 4:16 PM
 */

class Repiit_Subscription_Model_Customer
{

    /*
     * Create new customer
     */
    public function createCustomer($websiteId, $email, $store, $firstname, $lastname, $password)
    {
        $customer = Mage::getModel('customer/customer')
            ->setWebsiteId($websiteId)
            ->loadByEmail($email);
        if (!$customer || !$customer->getId()) {
            $customer = Mage::getModel('customer/customer');
            $customer->setWebsiteId($websiteId)
                ->setStore($store)
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setPassword($password);

            try {
                $customer->save();
            }
            catch (Exception $e)
            {
                Mage::logException($e);
            }

            return $customer;
        }
        else return $customer;
    }

    /*
     * Check if customer exists
     */
    public function isCustomer($websiteId, $email)
    {
        $customer = Mage::getModel('customer/customer')
            ->setWebsiteId($websiteId)
            ->loadByEmail($email);

        if ($customer->getId() == "") return false;
        else return true;
    }

    /*
     * Generate random password
     */
    public function generateRandomPassword()
    {
        return 'password123';
    }

}