<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/24/2016
 * Time: 6:16 PM
 */

class Repiit_Click_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction() {

        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::helper('core/url')->getCurrentUrl());
            $this->_redirect("customer/account/login");
            return;
        }
        $this->loadLayout();
        $this->renderLayout();

    }

    public function purchaseAction()
    {
        $params = $this->getRequest()->getParams();

        $productId = $params['product'];

        $customerId = $params['customerId'];

        $customer = Mage::getSingleton('customer/customer')->load($customerId);

        $_product = Mage::getSingleton('catalog/product')->load($productId);

        $clickPrice = $_product->getData('clickdownload_price');

        $repiitCredits = Mage::getModel('repiit_click/repiitcredits');
        $repiitCredits->setCustomerId($customerId);

        $activePoints = $repiitCredits->getActivePoints();

        if ($activePoints >= ($clickPrice * $params['qty']))
        {
            //create order
            $ba = $customer->getPrimaryBillingAddress(); //billing address
            $sa = $customer->getPrimaryShippingAddress(); //shipping address
            $orderClick = Mage::getModel('repiit_click/sales_order');
            $orderClick->setCustomer($customer);
            $orderClick->setEmail($customer->getEmail());
            $orderClick->setProductids(array($productId));
            $orderClick->setLinks($params['links']);
            $orderClick->setQty($params['qty']);
            $orderClick->setBillingAddress(
                array(
                    'customer_address_id' => '',
                    'prefix' => '',
                    'firstname' => $ba->getFirstname(),
                    'middlename' => '',
                    'lastname' => $ba->getLastname(),
                    'suffix' => '',
                    'company' => '',
                    'street' => 'Download Street 1',
                    'city' => 'Download',
                    'country_id' => 'IN',
                    'region' => 'UP',
                    'postcode' => '000',
                    'telephone' => '555',
                    'fax' => '',
                    'vat_id' => '',
                    'save_in_address_book' => 1
                )
            );
            $orderClick->setShippingAddress(
                array(
                    'customer_address_id' => '',
                    'prefix' => '',
                    'firstname' => $sa->getFirstname(),
                    'middlename' => '',
                    'lastname' => $sa->getLastname(),
                    'suffix' => '',
                    'company' => '',
                    'street' => 'Download Street 1',
                    'city' => 'Download',
                    'country_id' => 'IN',
                    'region' => 'UP',
                    'postcode' => '000',
                    'telephone' => '555',
                    'fax' => '',
                    'vat_id' => '',
                    'save_in_address_book' => 1
                )
            );

            $orderIncrementId = $orderClick->createOrder();


            //substract credits
            $repiitcredits = Mage::getModel('repiit_click/repiitcredits')->load($customer->getId(), 'customer_id');

            if (!$repiitcredits || !$repiitcredits->getId())
            {
                $repiitcredits->setCustomerId($customer->getId());
                $repiitcredits->setData('credits', 0);
                $repiitcredits->setData('created_time', date('Y-m-d H:i:s'));
                $repiitcredits->save();
            }

            Mage::helper('Repiit_Click')->addTransaction(
                $customer,
                array(
                    'title' => 'Spend credits order',
                    'action' => 'credits_spend_order',
                    'credit_amount' => ($clickPrice * $params['qty']) * (-1),
                    'expiration_day' => null,
                    'credit_id' => $repiitcredits->getId()
                )
            );

            if ($orderIncrementId)
            {
                Mage::getSingleton('core/session')->addSuccess($this->__('Product bought'));

                $this->_redirect('downloadable/customer/products/');

                return;

            }

            $this->_redirectReferer();

        }
        else
        {
            Mage::getSingleton('core/session')->addError($this->__('Not enough credits'));
            $this->_redirectReferer();
        }
    }

}