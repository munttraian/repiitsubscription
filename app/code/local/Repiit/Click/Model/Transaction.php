<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/22/2016
 * Time: 9:58 AM
 */

class Repiit_Click_Model_Transaction extends Mage_Core_Model_Abstract
{
    public function __construct()
    {
        $this->_init('repiit_click/transaction');
        parent::_construct();
    }

    public function spendCredits()
    {

        $remainCredits = abs($this->getCreditAmount());

        $collection = Mage::getModel('repiit_click/transaction')->getCollection()
            ->addFieldToFilter('customer_id', $this->getCustomerId())
            ->addFieldToFilter('real_credits', array('gt' => 0));

        $collection->getSelect()->order('IFNULL(expiration_time, date_add(now(), INTERVAL 2 YEAR))','asc');
        $collection->getSelect()->order('transaction_id','asc');


        foreach ($collection as $item)
        {
            if ($item->getRealCredits() >= $remainCredits)
            {
                $creditsToExtract = $remainCredits;
                $remainCredits = 0;
                $realCredits = $item->getRealCredits() - $creditsToExtract;
            }
            else
            {
                $creditsToExtract = $item->getRealCredits();
                $remainCredits = $remainCredits - $item->getRealCredits();
                $realCredits = $item->getRealCredits() - $creditsToExtract;
            }

            $item->setCreditSpent($creditsToExtract);
            $item->setRealCredits($realCredits);
            $item->setUpdatedTime(date('Y-m-d H:i:s'));
            $item->save();

            if ($remainCredits <= 0 ) break;
        }
    }

    public function expireCredits()
    {
        $this->setUpdatedTime(date('Y-m-d H:i:s'));
        $this->setRealCredits(0);
        $this->save();
    }
}