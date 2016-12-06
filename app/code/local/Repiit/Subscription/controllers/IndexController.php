<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 11/21/2016
 * Time: 8:56 PM
 */

class Repiit_Subscription_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction() {

        $url = Mage::getStoreConfig('repiitsubscription/api/redirect_url');
        $this->getResponse()->setRedirect($url);

    }

}