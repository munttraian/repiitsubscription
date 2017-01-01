<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/21/2016
 * Time: 9:32 PM
 */

class Repiit_Click_Helper_Data extends Mage_Core_Helper_Abstract {

    public function addTransaction($customer = null, $data)
    {

        if ($customer && $customer->getId()) {
            $customerId    = $customer->getId();
            $customerEmail = $customer->getEmail();
        }
        else {
            $customerId = isset($data['customer_id'])?$data['customer_id']:0;
            $customerEmail = isset($data['customer_email'])?$data['customer_email']:'';
        }

        $repiitcreditsTransaction = Mage::getModel('repiit_click/transaction');
        $repiitcreditsTransaction->setData('credit_id', $data['credit_id']);
        $repiitcreditsTransaction->setData('customer_id', $customerId);
        $repiitcreditsTransaction->setData('customer_email', $customerEmail);
        $repiitcreditsTransaction->setData('title', $data['title']);
        $repiitcreditsTransaction->setData('action', $data['action']);
        $repiitcreditsTransaction->setData('credit_amount', $data['credit_amount']);
        $repiitcreditsTransaction->setData('credit_spent', 0);
        $repiitcreditsTransaction->setData('created_time', date('Y-m-d H:i:s'));

        if (isset($data['expiration_day']) && $data['expiration_day']) $repiitcreditsTransaction->setData('expiration_time', date('Y-m-d H:i:s',strtotime('now +' . $data['expiration_day'] . ' days' )));

        if ($data['credit_amount'] >= 0) $repiitcreditsTransaction->setData('real_credits', $data['credit_amount']);
        else $repiitcreditsTransaction->setData('real_credits', 0); //0 real credits in case of correction

        $repiitcreditsTransaction->save();

        if ($data['credit_amount'] < 0 && $data['action'] != 'cron_expired')
        {
            $repiitcreditsTransaction->spendCredits();
        }


        return $repiitcreditsTransaction->getId();
    }

    //get repiit url
    /**
     * @return string
     */
    public function getRepiitCreditsUrl()
    {
        return Mage::getUrl('repiitclick/index');
    }

    //get repiit url
    /**
     * @return string
     */
    public function getRepiitCreditsLabel()
    {
        //get customer data
        $customer = Mage::getSingleton('customer/session')->getCustomer();

        $repiitCredits = Mage::getModel('repiit_click/repiitcredits');
        $repiitCredits->setCustomerId($customer->getId());

        return $this->__('Repiit Credits') . " ( " . $repiitCredits->getActivePoints() . " )";
    }

    //get click/download attribute group name
    /**
     * @return string
     */
    public function getClickDownloadAttributeGroup()
    {
        return 'ClickDownload';
    }

    public function getClickDownloadPurchase($customer_data)
    {
        return Mage::getUrl('repiitclick/index/purchase', array('customerId' => $customer_data->getId()));
    }

    //invoice order
    /*
     * @param order Mage_Sales_Model_Order
     */
    public function invoiceOrder($order)
    {
        $capture = Mage_Sales_Model_Order_Invoice::NOT_CAPTURE;
        /** @var Mage_Sales_Model_Order_Invoice $invoice */
        $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
        $invoice->setRequestedCaptureCase($capture);
        $invoice->register();

        $transaction = Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder());

        $transaction->save();
    }

}