<?php

namespace Reward\Point\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class Fee extends AbstractTotal
{
	protected $_coreSession;
	protected $invoiceCollection;
	public function __construct(
		\Magento\Framework\Event\ManagerInterface $eventManager,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\SalesRule\Model\Validator $validator,
		\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Framework\Session\SessionManagerInterface $coreSession,
		\Reward\Point\Model\ResourceModel\Invoice\CollectionFactory $invoiceCollection
	) 
	{
		$this->setCode('testdiscount');
		$this->eventManager = $eventManager;
		$this->calculator = $validator;
		$this->storeManager = $storeManager;
		$this->priceCurrency = $priceCurrency;
		$this->connection = $resource->getConnection();
		$this->_coreSession = $coreSession;
		$this->invoiceCollection = $invoiceCollection;
	}

	public function getSessionData($name){
		return $this->_coreSession->getData($name);
	}

	public function setSessionData($name, $value){
            $this->_coreSession->setData($name, $value);
        }

	public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
	{

		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/fee.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info('model calling:');
		
		$discount = $this->getSessionData('money');
    // $amount = $invoice->getOrder()->getFee();
		
		$invoice->setFee(-$discount);


    $invoice->setGrandTotal($invoice->getGrandTotal() - $discount);
    $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() - $discount);

    return $this;
}
}