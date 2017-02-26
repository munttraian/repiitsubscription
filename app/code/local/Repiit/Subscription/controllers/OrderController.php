<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/6/2016
 * Time: 8:15 PM
 */

class Repiit_Subscription_OrderController extends Mage_Core_Controller_Front_Action
{

    public function createAction()
    {
        $params = $this->getRequest()->getParams();

        $token = $params['token'];
        $json = $params['data'];
        $jsonArray = json_decode($json, true);

        print_r($jsonArray);

        //check if it allowed
        if (!$token || !Mage::getModel('repiit_subscription/access')->accessAllowed($token) )
        {
            echo "You do not have access on this service.";
            Mage::getSingleton('adminhtml/session')->addError($this->__('You do not have access on this service.'));
            //$this->_redirect('*/*/');
        }

        $orderModel = Mage::getModel('repiit_subscription/sales_order');
        $orderMapperModel = Mage::getModel('repiit_subscription/sales_order_fieldmapper');


        //get keys
        $emailKey = $orderMapperModel->getFieldName('email');
        $currencyKey = $orderMapperModel->getFieldName('currency');
        $firstnameKey = $orderMapperModel->getFieldName('name');
        $lastnameKey = $orderMapperModel->getFieldName('name');
        $address1Key = $orderMapperModel->getFieldName('address1');
        $address2Key = $orderMapperModel->getFieldName('address2');
        $telephone = $orderMapperModel->getFieldName('telephone');
        $postcode = $orderMapperModel->getFieldName('postcode');
        $city = $orderMapperModel->getFieldName('city');
        $countryKey = $orderMapperModel->getFieldName('country');
        //shipping
        $shipAddress1Key= $orderMapperModel->getFieldName('shipAddress1');
        $shipAddress2Key= $orderMapperModel->getFieldName('shipAddress2');
        $shipAddress3Key= $orderMapperModel->getFieldName('shipAddress3');
        $shipAddress4Key= $orderMapperModel->getFieldName('shipAddress4');
        $shipCityKey = $orderMapperModel->getFieldName('shipCity');
        $shipCountryKey = $orderMapperModel->getFieldName('shipCountry');

        //get values
        $email = $jsonArray[$emailKey];
        $currency = $jsonArray[$currencyKey];
        $firstname = explode(' ',$jsonArray[$firstnameKey])[0];
        $lastname = explode(' ', $jsonArray[$lastnameKey])[1];
        $address1 = $jsonArray[$address1Key];
        $address2 = $jsonArray[$address2Key];
        $postcode = explode(' ', $jsonArray[$postcode])[0];
        $city = explode(' ', $jsonArray[$city])[0];
        $country = $jsonArray[$countryKey];
        //shipping
        $shipAddress1 = $jsonArray[$shipAddress1Key];
        $shipAddress2 = $jsonArray[$shipAddress2Key];
        $shipAddress3 = $jsonArray[$shipAddress3Key];
        $shipAddress4 = $jsonArray[$shipAddress4Key];
        $shipCity = $jsonArray[$shipCityKey];
        $shipCountry = $jsonArray[$shipCountryKey];

        //get customer
        $customer = Mage::getModel('customer/customer')
            ->setWebsiteId(1)
            ->loadByEmail($email);

        //get product with subscription id ROWNUMBER
        $product = Mage::getModel('catalog/product')->loadByAttribute('subscription_id', $jsonArray['ROWNUMBER']);
        if (!$product) return;

        //set order data
        $orderModel->setProductids( array($product->getId()) );
        $orderModel->setCustomer($customer);
        $orderModel->setEmail($email);
        $orderModel->setBillingAddress(
            array(
                'customer_address_id' => '',
                'prefix' => '',
                'firstname' => $firstname,
                'middlename' => '',
                'lastname' => $lastname,
                'suffix' => '',
                'company' => '',
                /*
                'street' => array(
                    '0' => $address1,
                    '1' => $address2
                ),*/
                'street' => $address1 . " " . $address2,
                'city' => $city,
                'country_id' => Mage::helper('Repiit_Subscription')->getCountryId($country),
                'region' => '',
                'postcode' => $postcode,
                'telephone' => $telephone,
                'fax' => '',
                'vat_id' => '',
                'save_in_address_book' => 1
            )
        );

        $orderModel->setShippingAddress(
            array(
                'customer_address_id' => '',
                'prefix' => '',
                'firstname' => $firstname,
                'middlename' => '',
                'lastname' => $lastname,
                'suffix' => '',
                'company' => '',
                /*
                'street' => array(
                    '0' => $shipAddress1,
                    '1' => $shipAddress2
                ),
                */
                'street' => $shipAddress1 . " " . $shipAddress2,
                'city' => $shipCity,
                'country_id' => Mage::helper('Repiit_Subscription')->getCountryId($shipCountry),
                'region' => '',
                'postcode' => $postcode,
                'telephone' => $telephone,
                'fax' => '',
                'vat_id' => '',
                'save_in_address_book' => 1
            )
        );

        //add extra data on order
        $orderModel->setOrderData(
            array('is_subscription' => 1)
        );

        try{
            $orderModel->createOrder();
        }
        catch (Exception $e)
        {
            print_r($e);
        }
    }

}