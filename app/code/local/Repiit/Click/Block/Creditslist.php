<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/24/2016
 * Time: 5:44 PM
 */

class Repiit_Click_Block_Creditslist extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        $timezone = ((Mage::app()->getLocale()->date()->get(Zend_Date::TIMEZONE_SECS)) / 3600);
        $collection = Mage::getModel('repiit_click/transaction')->getCollection()
            ->addFieldToFilter('main_table.customer_id', $customerId);
        $collection->setOrder('transaction_id', 'DESC');
        $this->setCollection($collection);
    }

    public function getBalanceAccount()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        $repiitcredits = Mage::getModel('repiit_click/repiitcredits')->load($customerId, 'customer_id');

        return $repiitcredits->getActivePoints();
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'repiitclick_pager')
            ->setTemplate('page/html/pager.phtml')
            ->setCollection($this->getCollection());
        $this->setChild('repiitclick_pager', $pager);

        $grid = $this->getLayout()->createBlock('repiit_click/grid', 'repiitclick_grid');
        // prepare column

        $grid->addColumn('transaction_id', array(
            'header' => $this->__('Transaction Id'),
            'index' => 'transaction_id',
            'align' => 'left',
            'searchable' => true,
        ));

        $grid->addColumn('title', array(
            'header' => $this->__('Title'),
            'align' => 'left',
            'index' => 'title',
            'searchable' => true,
        ));
        $grid->addColumn('real_credits', array(
            'header' => $this->__('Credits'),
            'align' => 'left',
            'index' => 'real_credits',
            'width' => '50px',
            'searchable' => true,
        ));

        $grid->addColumn('created_time', array(
            'header' => $this->__('Create Date'),
            'index' => 'created_time',
            'type' => 'date',
            'align' => 'left',
            'searchable' => true,
        ));
        $grid->addColumn('expiration_time', array(
            'header' => $this->__('Expired Date'),
            'index' => 'expiration_time',
            'type' => 'date',
            'align' => 'left',
            'searchable' => true,
        ));

        $grid->addColumn('action', array(
            'header' => $this->__('Action'),
            'align' => 'left',
            'type' => 'action',
            'width' => '300px',
        ));

        $this->setChild('repiitclick_grid', $grid);
        return $this;
    }

    protected function _toHtml()
    {
        $this->getChild('repiitclick_grid')->setCollection($this->getCollection());
        return parent::_toHtml();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('repiitclick_pager');
    }

    public function getGridHtml()
    {
        return $this->getChildHtml('repiitclick_grid');
    }
}