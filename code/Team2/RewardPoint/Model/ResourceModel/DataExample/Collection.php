<?php
namespace Team2\RewardPoint\Model\ResourceModel\DataExample;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    public function _construct(){
        $this->_init("Team2\RewardPoint\Model\DataExample","Team2\RewardPoint\Model\ResourceModel\DataExample");
    }
}
