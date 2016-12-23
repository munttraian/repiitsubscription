<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/23/2016
 * Time: 11:07 AM
 */

class Repiit_Click_Model_Cron extends Mage_Core_Model_Abstract
{

    public function checkExpiredCredits()
    {
        $collection = Mage::getModel('repiit_click/repiitcredits')->getCollection();
        $collection->addFieldToFilter('real_credits', array('gt' => 0));
        $collection->addFieldToFilter('expiration_time', array('lt' => date('Y-m-d H:i:s'), 'notnull' => true ) );

        foreach ($collection as $item)
        {
            $dataTransaction = $item->getData();
            $dataTransaction['credit_amount'] = $item->getData('real_credits') - $item->getData('credit_amount');
            $dataTransaction['action'] = 'cron_expired';
            $dataTransaction['title'] = 'Expire points';

            $item->setData('updated_time', date('Y-m-d H:i:s'));
            $item->setData('real_credits', 0);
            $item->save();

            Mage::helper('Repiit_Click')->addTransaction(null, $dataTransaction);
        }
    }

}