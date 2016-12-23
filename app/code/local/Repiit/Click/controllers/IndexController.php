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

}