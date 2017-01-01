<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 1/8/2017
 * Time: 4:03 PM
 */

class Repiit_Subscription_Model_Api_Ruleidtable extends Repiit_Subscription_Model_Api
{

    //get all customers from repiit
    /**
     * @return array
     */
    public function getAllRulesIds()
    {
        $toOptionArray = array();

        $apiUrl = $this->getApiUrl() . "Customer";
        $key = $this->getAuthorizationKey();

        try {
            $ret = $this->curlGet($apiUrl,$key);

            $ruleids = json_decode($ret,true);

            foreach ($ruleids as $ruleid)
            {
                if (!isset($ruleid['RULEID'])) continue;
                $toOptionArray[$ruleid['RULEID']] = $ruleid['TXT'];
            }

        }
        catch (Exception $e)
        {
            Mage::logException("Error getting rulesids from repiit" . $e->getMessage());

            return false;
        }

        return $toOptionArray;

    }

}
