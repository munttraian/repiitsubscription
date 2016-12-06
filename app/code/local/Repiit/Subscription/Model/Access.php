<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/5/2016
 * Time: 9:32 PM
 */

class Repiit_Subscription_Model_Access extends Mage_Core_Model_Abstract
{

    /**
     * @param string $token
     * @return bool
     */
    public function accessAllowed($token)
    {
        $user = Mage::getStoreConfig('repiitsubscription/general/partener_id');
        $pass = Mage::getStoreConfig('repiitsubscription/general/key');

        $tokenLocal = md5(implode(':', array($user,$pass)));

        if ($token == $tokenLocal) return true;

        return false;
    }

}