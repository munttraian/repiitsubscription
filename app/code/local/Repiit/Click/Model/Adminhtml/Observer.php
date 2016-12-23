<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/22/2016
 * Time: 9:42 AM
 */

class Repiit_Click_Model_Adminhtml_Observer
{

    public function customerSaveAfter($observer) {
        $customer = $observer['customer'];
        $params = Mage::app()->getRequest()->getParam('repiitcredits');
        if (empty($params['admin_editing'])) {
            return;
        }

        $repiitcredits = Mage::getModel('repiit_click/repiitcredits')->load($customer->getId(), 'customer_id');

        if (!$repiitcredits || !$repiitcredits->getId())
        {
            $repiitcredits->setCustomerId($customer->getId());
            $repiitcredits->setData('credits', 0);
            $repiitcredits->setData('created_time', date('Y-m-d H:i:s'));
            $repiitcredits->save();
        }

        if (!empty($params['change_balance']))
        {
            Mage::helper('Repiit_Click')->addTransaction(
                $customer,
                array(
                    'title' => 'Admin add credits',
                    'action' => 'credits_added',
                    'credit_amount' => $params['change_balance'],
                    'expiration_day' => $params['expiration_day'],
                    'credit_id' => $repiitcredits->getId()
                )
            );

            $repiitcredits->setActivePoints();
            $repiitcredits->save();
        }

        /*
        // Update reward account settings
        $rewardAccount = Mage::getModel('rewardpoints/customer')->load($customer->getId(), 'customer_id');
        $rewardAccount->setCustomerId($customer->getId());
        if (!$rewardAccount->getId()) {
            $rewardAccount->setData('point_balance', 0)
                ->setData('holding_balance', 0)
                ->setData('spent_balance', 0);
        }
        $params['is_notification'] = empty($params['is_notification']) ? 0 : 1;
        $params['expire_notification'] = empty($params['expire_notification']) ? 0 : 1;
        $rewardAccount->setData('is_notification', $params['is_notification'])
            ->setData('expire_notification', $params['expire_notification']);
        $rewardAccount->save();

        // Create transactions for customer if need
        if (!empty($params['change_balance'])) {
            try {
                Mage::helper('rewardpoints/action')->addTransaction('admin', $customer, new Varien_Object(array(
                        'point_amount' => $params['change_balance'],
                        'title' => $params['change_title'],
                        'expiration_day' => (int) $params['expiration_day'],
                    ))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('rewardpoints')->__("An error occurred while changing the customer's point balance.")
                );
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        */
    }

}