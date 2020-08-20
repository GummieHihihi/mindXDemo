<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Tax totals modification block. Can be used just as subblock of \Magento\Sales\Block\Order\Totals
 */
namespace Reward\Point\Block\Adminhtml\Sales\Order;



class Invoice extends \Magento\Framework\View\Element\Template
{
    /**
     * Tax configuration model
     *
     * @var \Magento\Tax\Model\Config
     */
    protected $_config;

    /**
     * @var Order
     */
    protected $_order;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $_source;
    protected $order;
    protected $invoiceCollection;
    protected $coreSession;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Sales\Model\OrderFactory $order,
        \Reward\Point\Model\ResourceModel\Invoice\CollectionFactory $invoiceCollection,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        array $data = []
    ) {
        $this->_config = $taxConfig;
        parent::__construct($context, $data);
        $this->order = $order;
        $this->invoiceCollection = $invoiceCollection;
        $this->coreSession = $coreSession;
    }

    /**
     * Check if we nedd display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }
    
    public function getStore()
    {
        return $this->_order->getStore();
    }

      /**
     * @return Order
     */
      public function getOrder()
      {
        return $this->_order;
    }

    /**
     * @return array
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return array
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    public function setSessionData($name, $value){
        $this->coreSession->setData($name, $value);
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return \Magento\Tax\Block\Sales\Order\Tax
     */
    public function initTotals()
    {

        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();
        $source = $this->getSource();
        $this->_order->setTotalInvoiced(100);
        $this->_order->setGrandTotal(100);
        $store = $this->getStore();
        $id = $source->getOrderId();
        if($this->invoiceCollection->create()->addFieldToFilter('billid',$id)->getData()){
            $discount = (int)$this->invoiceCollection->create()->addFieldToFilter('billid',$id)->getData()[0]['money'];
            $this->setSessionData('money', $discount);
            $fee = new \Magento\Framework\DataObject(
                [
                    'code' => 'fee',
                    'strong' => false,
                    'value' => $discount,
                    //'value' => $this->_source->getFee(),
                    'label' => __('Reward Point'),
                ]
            );

            $parent->addTotal($fee, 'fee');
           // $this->_addTax('grand_total');
            $parent->addTotal($fee, 'fee');
        }

        return $this;
    }

}