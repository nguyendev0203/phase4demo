<?php
namespace Team2\RewardPoint\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Team2\RewardPoint\Helper\Data;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Team2\RewardPoint\Model\DataExampleFactory;
use Magento\Framework\App\Helper\Context;


class AddActionCompletedRewardPointToOrderObserver extends AbstractHelper implements ObserverInterface
{
    const XML_PATH_REWARD_POINT = 'rwpoint_section/';

    protected $_dataExample;
    /**
     * Set payment fee to order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function __construct(Context $context,
                                DataExampleFactory $dataExample
                                )
    {
        parent::__construct($context);
        $this->_dataExample = $dataExample;
    }

    public function getConfigValue($field, $storeCode=null){
        return $this->scopeConfig->getValue($field,ScopeInterface::SCOPE_STORE, $storeCode);
    }
    public function getPointEarnSpend($fieldid = 'point_earnr', $storeCode=null){
        return $this->getConfigValue(self::XML_PATH_REWARD_POINT.'point_earn_calc/'.$fieldid, $storeCode);
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_order = $observer->getEvent()->getOrder();
        // $_invoice = $_event->getInvoice();
        // $_order = $_invoice->getOrder();
        //handle
        if($_order->getStatus()=="complete"){
            
            // echo "customer_id: ".$_order->getData("customer_id")."<br>";
            $customer_id = $_order->getData("customer_id");
            if($customer_id != "")
            {
                $reward_point = $_order->getData("base_subtotal")*$this->getPointEarnSpend();
                $order_id = $_order->getId();
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('reward_point_history');
                $sql = "INSERT INTO ".$tableName." (customer_id,action,point,type,order_id,author) values ($customer_id,'Order Completed',$reward_point,'shopping cart',$order_id,'Admin')";
                $connection->query($sql);

                $tableName2 = "reward_point" ;
                $sql2 = "Select * FROM " . $tableName2." Where customer_id=".$customer_id;
                $result = $connection->fetchAll($sql2);
                $count = count($result);
                if($count>0)
                {
                    //code update
                    foreach ($result as $row) {
                    $pointOld = $row["point"];
                    }
                    $newPoint = $pointOld + $reward_point;
                    $sql3 = "Update " . $tableName2 . " Set point = ".$newPoint." where customer_id = ".$customer_id;
                    $connection->query($sql3);

                } else {
                    //code save
                    $sql4 = "INSERT INTO ".$tableName2." (customer_id,point,type) values ($customer_id,$reward_point,'shopping cart')";
                    $connection->query($sql4);

                }

            }
            // echo "action: complete<br>";
            // echo "point reward: ".$_order->getData("base_subtotal")*$this->getPointEarnSpend()."<br>";
            
            // echo "type: "."<br>";
            // echo "order_id: ".$_order->getId()."<br>";
            
            // echo "author: "."<br>";
            // echo "comment"."<br>"; 
            //gives table name with prefix
            // $sql = "INSERT INTO reward_point_history (customer_id,action,point,type,order_id,author) values ($customer_id,'Order Completed',$reward_point,'shopping cart',$odid,'Zeus')";
            // $sql = "Select * FROM " . $tableName;
            
            // if ($result) {
            //  $this->messageManager->addSuccess(__('Insert Record Successfully !'));
            // }

           

            
            
        }
    }

}
