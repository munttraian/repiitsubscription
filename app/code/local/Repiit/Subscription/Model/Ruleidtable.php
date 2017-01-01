<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 1/8/2017
 * Time: 3:31 PM
 */

class Repiit_Subscription_Model_Ruleidtable extends Mage_Core_Model_Abstract
{

    static public function getOptionArray()
    {
        //return Mage::getModel('repiit_subscription/api_ruleidtable')->getAllRulesIds();

        return array(
            1    => Mage::helper('catalog')->__('Enabled'),
            2   => Mage::helper('catalog')->__('Disabled')
        );
    }

    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOption()
    {
        $options = self::getOptionArray();
        array_unshift($options, array('value'=>'', 'label'=>''));
        return $options;
    }

    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOptions()
    {
        $res = array(
            array(
                'value' => '',
                'label' => Mage::helper('catalog')->__('-- Please Select --')
            )
        );
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = array(
                'value' => $index,
                'label' => $value
            );
        }
        return $res;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    static public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

}