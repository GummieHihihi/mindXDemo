<?php 
namespace Reward\Point\Controller\CustomerAccount;  
class Transaction extends \Magento\Framework\App\Action\Action { 
  
 public function execute() { 
    $this->_view->loadLayout(); 
    $this->_view->renderLayout(); 
  } 

} 
?>