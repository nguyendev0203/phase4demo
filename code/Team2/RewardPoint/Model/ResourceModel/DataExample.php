<?php
namespace Team2\RewardPoint\Model\ResourceModel;
class DataExample extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    public function _construct(){
        $this->_init("reward_point_history","id");
    }
}
