<?php
namespace Team2\RewardPoint\Model;
class DataPoint extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED = 'demo';
    const STATUS_DISABLED = 'pending';


    const CACHE_TAG = 'reward_point_history';
    //Unique identifier for use within caching
    protected $_cacheTag = self::CACHE_TAG;

    public function _construct(){
        $this->_init("Team2\RewardPoint\Model\ResourceModel\DataPoint");
    }

    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues(){
        $values = [];
        return $values;
    }

    public function getAvailableStatuses(){
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
