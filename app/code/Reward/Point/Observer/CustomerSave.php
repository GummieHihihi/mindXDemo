<?php
namespace Reward\Point\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\AlreadyExistsException;

class CustomerSave implements ObserverInterface
{
    protected $_objectManager;
    protected $_customerCollectionFactory;
    protected $request;
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->request = $request;
        $this->_objectManager = $objectManager;
        $this->connection = $resource->getConnection();
    }


    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $customerData = $event->getCustomer();
        $update = (int)$this->request->getPostValue()['update_balance'];
        if($this->request->getPostValue()['update_balance']){
            $update = (int)$this->request->getPostValue()['update_balance'];
        }
        else{
            $update = 0;
        }
        if($this->request->getPostValue()['note']){
            $note = $this->request->getPostValue()['note'];
        }
        else{
            $note = "";
        }
        
        $clientPointModel = $this->_objectManager->create('Reward\Point\Model\ClientPoint');
        $point = $clientPointModel->load($customerData->getId());
        $currenpoint  = (int)$point->getData('client_point');
        $newPoint = $currenpoint + $update;

        // set the data 
        $customerInModel = $clientPointModel->load($customerData->getId());
        $customerInModel->setData('client_point', $newPoint);
        $customerInModel->save();

        //save data to the database table 
        $transactionDate = date('Y-m-d');
        $customerEntity = $customerData->getData()['entity_id'];
        
        $customerName = $customerData->getData()['firstname'] ." " . $customerData->getData()['lastname'];
        $customerMail = $customerData->getData()['email'];

        $changePoint = $update;
        $pointnow = $clientPointModel->load($customerData->getId());
        $currenpoint2  = (int)$point->getData('client_point');
        $balance = $currenpoint2;
        $point_expire = 0;
        $website = "Main Website";
        $createdBy = "Admin";
        
        
        $notee = $this->request->getPostValue()['note'];
        $type = 'admin change';
        //create model
        $transactionModel = $this->_objectManager->create('Reward\Point\Model\Transaction');
        
        
         /*$data = [
           'entity_id' => $customerEntity,
           'customer_name' => $customerName,
           'mail' => $customerMail,
           'change_point' => $changePoint,
           'balance' => $balance,
           'point_expire' => $point_expire,
           'website' => $website,
           'create_by' => $createdBy,
           'note' => $notee,
           'transaction_date' => $transactionDate,
           'expires_date' => 'nothing',
           'type' => $type
       ];
       $transactionModel->setData($data);
       $transactionModel->save(); */

       // $this->insertinto($customerEntity,$customerName, $customerMail, $changePoint, $balance, $point_expire, $website, $createdBy, $notee, $transactionDate, 'todady', $type);
       // die('123');
       $transactionModel->setData('entity_id', $customerEntity);
        $transactionModel->setData('customer_name', $customerName);
        $transactionModel->setData('mail', $customerMail);
        $transactionModel->setData('change_point', $changePoint);
        $transactionModel->setData('balance', $balance);
        $transactionModel->setData('point_expire', $point_expire);
        $transactionModel->setData('website', $website);
        $transactionModel->setData('create_by', $createdBy);
        $transactionModel->setData('note', $notee);
        $transactionModel->setData('transaction_date', $transactionDate);
        $transactionModel->setData('expires_date', $transactionDate);
        $transactionModel->setData('type', $type);
        $transactionModel->save();
        // $transactionModel->save();



   }
   

}
