<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/22/2016
 * Time: 9:56 AM
 */

class Repiit_Click_Model_Resource_Repiitcredits_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        $this->_init('repiit_click/repiitcredits');
        parent::_construct();
    }

}