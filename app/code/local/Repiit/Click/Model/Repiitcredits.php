<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/22/2016
 * Time: 9:49 AM
 */

class Repiit_Click_Model_Repiitcredits extends Mage_Core_Model_Abstract
{
    public function __construct()
    {
        $this->_init('repiit_click/repiitcredits');
        parent::_construct();
    }

    public function getActivePoints()
    {
        $collection = Mage::getModel('repiit_click/transaction')->getCollection()->addFieldToFilter('customer_id', $this->getCustomerId());
        $activePoints = 0;

        foreach ($collection as $item)
        {
            $activePoints += (int)$item->getRealCredits();
        }

        return $activePoints;
    }

    public function setActivePoints()
    {
        $this->setCredits($this->getActivePoints());

        return $this;
    }
}