<?php
namespace Reward\Point\Model\ResourceModel\Invoice;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    protected $_idFieldName = 'invoiceid';
    public function _construct(){
        parent::_construct();
        $this->_init('Reward\Point\Model\Invoice', 'Reward\Point\Model\ResourceModel\Invoice');
    }
}