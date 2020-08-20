<?php
namespace Reward\Point\Block\Frontend\Customer;
class Grid extends \Magento\Framework\View\Element\Template
{
    protected $_objectManager;
    protected $_storeManager;
    protected $connection;
    protected $total;
    protected $coreSession;
    const STATUS_ENABLED = 1;
    const TYPE_GIVE = 'give';
    const Type_exchange = 'exchange';
    protected $_customerFactory;
    protected $transaction;
    protected $transcollectionFactory;
    protected $exchange;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Quote\Model\Quote\Address\Total $total,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \Reward\Point\Model\TransactionFactory $transaction,
        \Reward\Point\Model\ResourceModel\Transaction\CollectionFactory $transcollection,
        \Reward\Point\Model\ResourceModel\ExchangeRate\CollectionFactory $exchange,
        array $data
    )
    {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $context->getStoreManager();
        parent::__construct($context, $data);
        $this->connection = $resource->getConnection();
        $this->total = $total;
        $this->coreSession = $coreSession;
        $this->_customerFactory = $customerFactory;
        $this->transaction = $transaction;
        $this->exchange = $exchange;
        $this->transcollectionFactory = $transcollection;
        $this->exchange = $exchange;
    }
    public function getCustomerId()
    {
        $id = $this->getRequest()->getParam('id');
        $customer = $this->_objectManager->create('\Magento\Customer\Model\Session');
        $collection = $customer->getData()['customer_id'];
        
        return $collection;
    }
    public function getCustomerCollection()
    {
        return $this->_customerFactory->create();
    }
    public function getCustomerRewardPoint()
    { 
        $clientPointModel = $this->_objectManager->create('Reward\Point\Model\ClientPoint');
        $customer = $clientPointModel->load($this->getCustomerId());
        $point = (int)$customer->getData('client_point');
        return $point;
    }
    public function getAllEarning(){
        //thu bang collection 
        $total = 0;
        $customer2 = $this->transcollectionFactory->create()->addFieldToFilter('entity_id', $this->getCustomerId())->getData();
        for ($i=0; $i < count($customer2) ; $i++) { 
            if($customer2[$i]['change_point'] > 0){
                $total += $customer2[$i]['change_point'];
            }
        }
        return $total;
    }

    public function getAllSpending(){
        //thu bang collection 
        $total = 0;
        $customer2 = $this->transcollectionFactory->create()->addFieldToFilter('entity_id', $this->getCustomerId())->getData();
        for ($i=0; $i < count($customer2) ; $i++) { 
            if($customer2[$i]['change_point'] < 0){
                $total += $customer2[$i]['change_point'];
            }
        }
        return $total;
    }

    public function getExchangeRate(){
        $model = $this->exchange->create()->addFieldToFilter('status', 1)->getData();
        $current = 0;
        if(count($model) == 1 ){
            $current = $model[0]["exchangeRate"];
        }
        else{
            for ($i=0; $i <count($model)-1 ; $i++) { 
                if($model[$i]["priority"] < $model[$i+1]["priority"]){
                    $current = $model[$i]["exchangeRate"];
                }
                else{
                    $current = $model[$i+1]["exchangeRate"];
                }
            }
        }
        return $current;
    }

}