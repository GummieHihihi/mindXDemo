<?php
namespace Reward\Point\Block\Frontend\Checkout;
class EarningRules extends \Magento\Framework\View\Element\Template
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
    protected $invoice;
    protected $_checkoutSession;
    protected $earningFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Quote\Model\Quote\Address\Total $total,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \Reward\Point\Model\TransactionFactory $transaction,
        \Reward\Point\Model\InvoiceFactory $invoice,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Reward\Point\Model\ResourceModel\EarningRules\CollectionFactory $earningFactory,
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
        $this->invoice = $invoice;
        $this->_checkoutSession = $checkoutSession;
        $this->earningFactory = $earningFactory;
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


    public function getAllRules()
    {
        $allRules = array();
        $availibble = $this->connection->fetchAll("SELECT * FROM earning_rules");
        return $availibble;
    }

    public function getHighestRules()
    {
        $model = $this->earningFactory->create();
        $data = $model->getData();
        $highestRules = $data[0]['priority'];
        if(count($data) == 1){
            $highestRules = $data[0];
        }
        else{
            for($i =0; $i<count($data)-1;$i++)
                if($data[$i]['priority']<$data[$i+1]['priority']){
                    $highestRules = $data[$i+1];
                }
            }
            return $highestRules;
        }

        public function getTotal(){
            $cart = $this->_objectManager->get('\Magento\Checkout\Model\Cart'); 
            $subTotal = $cart->getQuote()->getSubtotal();
            return $subTotal;
        }

        public function addGiveRewardPoint($number){
            $query = $this->connection->fetchAll("SELECT client_point_id FROM clientpoint_demo Where entity_id = ".$this->getCustomerId());
            $oldPoint = $this->connection->fetchAll("SELECT client_point FROM clientpoint_demo Where entity_id = ".$this->getCustomerId());

            $newPoint = $oldPoint[0]['client_point'] + $number;

            $sql = "UPDATE clientpoint_demo SET client_point = '$newPoint' WHERE entity_id = ".$query[0]['client_point_id'];
            $q = $this->connection->query($sql);
        }

        public function minusRewardPoint($number){
            $query = $this->connection->fetchAll("SELECT client_point_id FROM clientpoint_demo Where entity_id = ".$this->getCustomerId());
            $oldPoint = $this->connection->fetchAll("SELECT client_point FROM clientpoint_demo Where entity_id = ".$this->getCustomerId());

            $newPoint = $oldPoint[0]['client_point'] - $number;

            $sql = "UPDATE clientpoint_demo SET client_point = '$newPoint' WHERE entity_id = ".$query[0]['client_point_id'];
            $q = $this->connection->query($sql);
        }

        public function saveTemp($number, $status){
            $sql = "INSERT INTO temp_trans(total, status) VALUES ($number, $status)";
            $q = $this->connection->query($sql);
        }

        public function getTempTotal(){
            $temp_id = $this->connection->fetchAll("SELECT total FROM temp_trans ORDER BY temp_id DESC limit 1");
            return $temp_id;
        }

        public function getMediaUrlImage($imagePath = '')
        {
            return $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $imagePath;
        }
        public function setSessionData($name, $value){
            $this->coreSession->setData($name, $value);
        }
        public function getSessionData($name){
            return $this->coreSession->getData($name);
        }
        public function saveToTransaction($customerEntity, $customerName, $customerMail, $changePoint, $balance, $pointExpire, $website, $createBy, $notee,$transactionDate, $expires_date, $type)
        {
            $model = $this->transaction->create();
            $model->setData('entity_id', $customerEntity);
            $model->setData('customer_name', $customerName);
            $model->setData('mail', $customerMail);
            $model->setData('change_point', $changePoint);
            $model->setData('balance', $balance);
            $model->setData('point_expire', $pointExpire);
            $model->setData('website', $website);
            $model->setData('create_by', $createBy);
            $model->setData('note', $notee);
            $model->setData('transaction_date', $transactionDate);
            $model->setData('expires_date', $expires_date);
            $model->setData('type', $type);
            $model->save();
        }
        public function getBillId(){
            return (int)$this->_checkoutSession->getData()['last_order_id'];
        }
        public function saveDiscount2Invoice($billid, $money){
            $model = $this->invoice->create();
            $model->setData('billid', $billid);
            $model->setData('money', $money);
            $model->save();
        }
        
    }
