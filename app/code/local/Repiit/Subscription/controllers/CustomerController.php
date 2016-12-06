<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/5/2016
 * Time: 9:30 PM
 */

class Repiit_Subscription_CustomerController extends Mage_Core_Controller_Front_Action
{

    public function createAction()
    {
        $params = $this->getRequest()->getParams();

        $token = $params['token'];
        $json = $params['data'];
        $jsonArray = json_decode($json, true);


        //check if it allowed
        if (!$token || !Mage::getModel('repiit_subscription/access')->accessAllowed($token) )
        {
            Mage::getSingleton('adminhtml/session')->addError($this->__('You do not have access on this service.'));
            //$this->_redirect('*/*/');
        }

        //create customer
        $customerModel = Mage::getModel('repiit_subscription/customer');
        $customerModelMapper = Mage::getModel('repiit_subscription/customer_fieldmapper');

        $firstnameKey   = $customerModelMapper->getFieldName('name');
        $lastnameKey    = $customerModelMapper->getFieldName('name');
        $emailKey       = $customerModelMapper->getFieldName('email');


        $firstname      = $jsonArray[$firstnameKey];
        $lastname       = $jsonArray[$lastnameKey];
        $email          = $jsonArray[$emailKey];

        $website = Mage::helper('Repiit_Subscription')->getDefaultWebsite();
        $store   = Mage::app()->getStore(1);
        $password = $customerModel->generateRandomPassword();

        if (!$customerModel->isCustomer($website, $email))
        {
            $customer = $customerModel->createCustomer($website, $email, $store, $firstname, $lastname, $password);
        }

        $this->_redirect('*/*/');

    }

}