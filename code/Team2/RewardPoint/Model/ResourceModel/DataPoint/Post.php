<?php
namespace Team2\RewardPoint\Model\ResourceModel\DataPoint;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Post extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'rewardpoint_index_collection';
    protected $_eventObject = 'index_collection';

    public function _construct()
    {
        $this->_init("Team2\RewardPoint\Model\DataPoint",
            "Team2\RewardPoint\Model\ResourceModel\DataPoint");

    }
}
