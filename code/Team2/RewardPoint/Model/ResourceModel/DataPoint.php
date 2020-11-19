<?php
namespace Team2\RewardPoint\Model\ResourceModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;

class DataPoint extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct(){
        $this->_init("reward_point","id");
    }
}
