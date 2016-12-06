<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/6/2016
 * Time: 7:41 PM
 */

class Repiit_Subscription_Model_Customer_Address
{

    public function addAddress($customer, $countryCode, $zip, $city, $phone, $fax, $company, $street)
    {
        $address = Mage::getModel("customer/address");
        $address->setCustomerId($customer->getId())
            ->setFirstname($customer->getFirstname())
            ->setMiddleName($customer->getMiddlename())
            ->setLastname($customer->getLastname())
            ->setCountryId($countryCode)
            //->setRegionId('1') //state/province, only needed if the country is USA
            ->setPostcode($zip)
            ->setCity($city)
            ->setTelephone($phone)
            ->setFax($fax)
            ->setCompany($company)
            ->setStreet($street)
            ->setIsDefaultBilling('1')
            ->setIsDefaultShipping('1')
            ->setSaveInAddressBook('1');

        try{
            $address->save();
        }
        catch (Exception $e) {
            Mage::logException($e);
        }
    }
}