<?php
namespace Team2\RewardPoint\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper{

    const XML_PATH_REWARD_POINT = 'rwpoint_section/';

    public function getConfigValue($field, $storeCode=null){
        return $this->scopeConfig->getValue($field,ScopeInterface::SCOPE_STORE, $storeCode);
    }

    public function getGeneralConfig($fieldid, $storeCode=null){
        return $this->getConfigValue(self::XML_PATH_REWARD_POINT.'general/'.$fieldid, $storeCode);
    }

    public function getPointEarnSpend($fieldid, $storeCode=null){
        return $this->getConfigValue(self::XML_PATH_REWARD_POINT.'point_earn_calc/'.$fieldid, $storeCode);
    }
    public function getOrderLimit($fieldid, $storeCode=null){
        return $this->getConfigValue(self::XML_PATH_REWARD_POINT.'order_limit/'.$fieldid, $storeCode);
    }


}
