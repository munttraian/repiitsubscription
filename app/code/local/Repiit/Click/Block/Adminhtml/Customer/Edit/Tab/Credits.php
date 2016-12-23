<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/21/2016
 * Time: 10:55 PM
 */

class Repiit_Click_Block_Adminhtml_Customer_Edit_Tab_Credits
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected $_creditAccount = null;

    /**
     * get Current Credit Account Model
     *
     * @return Repiit_Click_Model_Customer
     */
    public function getCreditAccount()
    {
        if (is_null($this->_creditAccount)) {
            $customerId = $this->getRequest()->getParam('id');
            $this->_creditAccount = Mage::getModel('repiit_click/repiitcredits')->load($customerId, 'customer_id');
        }
        return $this->_creditAccount;
    }

    /**
     * prepare tab form's information
     *
     */
    protected function _prepareForm()
    {

        $this->getCreditAccount();

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('repiitcredits_');
        $this->setForm($form);

        $fieldset = $form->addFieldset('repiitcredits_form', array(
            'legend' => Mage::helper('Repiit_Click')->__('Repiit Credits Information')
        ));

        $fieldset->addField('credits_balance', 'note', array(
            'label' => Mage::helper('Repiit_Click')->__('Available Credits'),
            'title' => Mage::helper('Repiit_Click')->__('Available Credits'),
            'text'  => isset($this->_creditAccount)?$this->_creditAccount->getCredits():0,
        ));

        $fieldset->addField('change_balance', 'text', array(
            'label' => Mage::helper('Repiit_Click')->__('Change Balance'),
            'title' => Mage::helper('Repiit_Click')->__('Change Balance'),
            'name'  => 'repiitcredits[change_balance]',
            'note'  => Mage::helper('Repiit_Click')->__('Add or subtract customer\'s balance. For ex: 99 or -99 points.'),
        ));

        $fieldset->addField('expiration_day', 'text', array(
            'label' => Mage::helper('Repiit_Click')->__('Credits Expire On'),
            'title' => Mage::helper('Repiit_Click')->__('Credits Expire On'),
            'name'  => 'repiitcredits[expiration_day]',
            'note'  => Mage::helper('Repiit_Click')->__('day(s) since the transaction date. If empty or zero, there is no limitation.')
        ));

        $fieldset->addField('admin_editing', 'hidden', array(
            'name'  => 'repiitcredits[admin_editing]',
            'value' => 1,
        ));

        $fieldset = $form->addFieldset('repiitcredits_history_fieldset', array(
            'legend' => Mage::helper('Repiit_Click')->__('Transaction History')
        ))->setRenderer($this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset')->setTemplate(
            'repiit/click/history.phtml'
        ));

        /*
        $fieldset->addField('holding_point', 'note', array(
            'label' => Mage::helper('Repiit_Click')->__('On Hold Points Balance'),
            'title' => Mage::helper('Repiit_Click')->__('On Hold Points Balance'),
            'text'  => '<strong>' . Mage::helper('Repiit_Click')->format(
                    $this->getRewardAccount()->getHoldingBalance()) . '</strong>',
        ));

        $fieldset->addField('spent_point', 'note', array(
            'label' => Mage::helper('Repiit_Click')->__('Spent Points'),
            'title' => Mage::helper('Repiit_Click')->__('Spent Points'),
            'text'  => '<strong>' . Mage::helper('Repiit_Click')->format(
                    $this->getRewardAccount()->getSpentBalance()) . '</strong>',
        ));

        $fieldset->addField('change_balance', 'text', array(
            'label' => Mage::helper('Repiit_Click')->__('Change Balance'),
            'title' => Mage::helper('Repiit_Click')->__('Change Balance'),
            'name'  => 'rewardpoints[change_balance]',
            'note'  => Mage::helper('Repiit_Click')->__('Add or subtract customer\'s balance. For ex: 99 or -99 points.'),
        ));

        $fieldset->addField('change_title', 'textarea', array(
            'label' => Mage::helper('Repiit_Click')->__('Change Title'),
            'title' => Mage::helper('Repiit_Click')->__('Change Title'),
            'name'  => 'rewardpoints[change_title]',
            'style' => 'height: 5em;'
        ));

        $fieldset->addField('expiration_day', 'text', array(
            'label' => Mage::helper('Repiit_Click')->__('Points Expire On'),
            'title' => Mage::helper('Repiit_Click')->__('Points Expire On'),
            'name'  => 'rewardpoints[expiration_day]',
            'note'  => Mage::helper('Repiit_Click')->__('day(s) since the transaction date. If empty or zero, there is no limitation.')
        ));

        $fieldset->addField('admin_editing', 'hidden', array(
            'name'  => 'rewardpoints[admin_editing]',
            'value' => 1,
        ));

        $fieldset->addField('is_notification', 'checkbox', array(
            'label' => Mage::helper('Repiit_Click')->__('Update Points Subscription'),
            'title' => Mage::helper('Repiit_Click')->__('Update Points Subscription'),
            'name'  => 'rewardpoints[is_notification]',
            'checked'   => $this->getRewardAccount()->getIsNotification(),
            'value' => 1,
        ));

        $fieldset->addField('expire_notification', 'checkbox', array(
            'label' => Mage::helper('Repiit_Click')->__('Expire Transaction Subscription'),
            'title' => Mage::helper('Repiit_Click')->__('Expire Transaction Subscription'),
            'name'  => 'rewardpoints[expire_notification]',
            'checked'   => $this->getRewardAccount()->getExpireNotification(),
            'value' => 1,
        ));
        */

        /*
        $fieldset = $form->addFieldset('rewardpoints_history_fieldset', array(
            'legend' => Mage::helper('Repiit_Click')->__('Transaction History')
        ))->setRenderer($this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset')->setTemplate(
            'rewardpoints/history.phtml'
        ));
        */

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return Mage::helper('Repiit_Click')->__('Repiit Credits');
    }

    public function getTabTitle()
    {
        return Mage::helper('Repiit_Click')->__('Repiit Credits');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}