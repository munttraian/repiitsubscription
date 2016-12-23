<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/22/2016
 * Time: 10:42 AM
 */

class Repiit_Click_Block_Adminhtml_Customer_Edit_Tab_History extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('repiitcreditsTransactionGrid');
        $this->setDefaultSort('repiitcredits_transaction_transaction_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    /**
     * prepare collection for block to display
     *
     */
    protected function _prepareCollection()
    {
        $collection = null;
        try {
            $collection = Mage::getModel('repiit_click/transaction')->getCollection()
                ->addFieldToFilter('customer_id', $this->getRequest()->getParam('id'));
        }
        catch (Exception $e)
        {
            Mage::log($e->getMessage(), null, 'repiit.log');
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare columns for this grid
     *
     */
    protected function _prepareColumns()
    {
        $this->addColumn('transaction_id', array(
            'header'    => Mage::helper('Repiit_Click')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'transaction_id',
            'type'      => 'number',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('Repiit_Click')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));

        $this->addColumn('action', array(
            'header'    => Mage::helper('Repiit_Click')->__('Action'),
            'align'     => 'left',
            'index'     => 'action',
            'type'      => 'options',
            'options'   => array('credits_added' => 'Credits Added'), //Mage::helper('Repiit_Click/action')->getActionsHash(),
        ));

        $this->addColumn('credit_amount', array(
            'header'    => Mage::helper('Repiit_Click')->__('Credits'),
            'align'     => 'right',
            'index'     => 'credit_amount',
            'type'      => 'number',
        ));

        $this->addColumn('credit_spent', array(
            'header'    => Mage::helper('Repiit_Click')->__('Credits Spent'),
            'align'     => 'right',
            'index'     => 'credit_spent',
            'type'      => 'number',
        ));

        $this->addColumn('real_credits', array(
            'header'    => Mage::helper('Repiit_Click')->__('Real Credits'),
            'align'     => 'right',
            'index'     => 'real_credits',
            'type'      => 'number',
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('Repiit_Click')->__('Created On'),
            'index'     => 'created_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('updated_time', array(
            'header'    => Mage::helper('Repiit_Click')->__('Updated On'),
            'index'     => 'updated_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('expiration_time', array(
            'header'    => Mage::helper('Repiit_Click')->__('Expires On'),
            'index'     => 'expiration_time',
            'type'      => 'datetime',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('Repiit_Click')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(), //Mage::getSingleton('repiit_click/transaction')->getStatusHash(),
        ));

        $this->addColumn('store_id', array(
            'header'    => Mage::helper('Repiit_Click')->__('Store View'),
            'align'     => 'left',
            'index'     => 'store_id',
            'type'      => 'options',
            'options'   => Mage::getModel('adminhtml/system_store')->getStoreOptionHash(true),
        ));

        /*
        $this->addExportType('repiitclickadmin/adminhtml_customer/exportCsv'
            , Mage::helper('Repiit_Click')->__('CSV')
        );
        $this->addExportType('repiitclickadmin/adminhtml_customer/exportXml'
            , Mage::helper('Repiit_Click')->__('XML')
        );
        */
        return parent::_prepareColumns();
    }

    /**
     * Add column to grid
     *
     * @param   string $columnId
     * @param   array || Varien_Object $column
     * @return  Repiit_Click_Block_Adminhtml_Customer_Edit_Tab_History
     */
    public function addColumn($columnId, $column)
    {
        $columnId = 'repiitcredits_transaction_' . $columnId;
        return parent::addColumn($columnId, $column);
    }

    /**
     * get url for each row in grid
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('repiitclickadmin/adminhtml_transaction/edit', array('id' => $row->getId()));
    }

    /**
     * get grid url (use for ajax load)
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('repiitclickadmin/adminhtml_customer/grid', array('_current' => true));
    }
}