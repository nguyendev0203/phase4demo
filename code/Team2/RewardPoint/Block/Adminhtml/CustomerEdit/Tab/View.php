<?php

namespace Team2\RewardPoint\Block\Adminhtml\CustomerEdit\Tab;

use Magento\Framework\App\ObjectManager;
use Team2\RewardPoint\Model\ResourceModel\DataExample\CollectionFactory;

class View extends \Magento\Backend\Block\Template implements \Magento\Ui\Component\Layout\Tabs\TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'tab/rewardpoint_history_view.phtml';

    /**
     * View constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CollectionFactory $historyCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        CollectionFactory $historyCollectionFactory,

        array $data = []
    )
    {
        $this->_historyCollectionFactory = $historyCollectionFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return \Team2\RewardPoint\Model\ResourceModel\DataExample\Collection
     */
    public function getHistoryCollection()
    {
        $customerId = $this->_coreRegistry->registry(\Magento\Customer\Controller\RegistryConstants::CURRENT_CUSTOMER_ID);
        $collection = $this->_historyCollectionFactory->create()
        ->addFieldToFilter('customer_id', $customerId);
        return $collection;
    }

    public function getHistoryCollectionFront(){
        $objectManager = ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        $customerId = $customerSession->getCustomer()->getId();
        $collection = $this->_historyCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);
        return $collection;
    }
    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(\Magento\Customer\Controller\RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Reward Point History');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Reward Point History');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        if ($this->getCustomerId()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        if ($this->getCustomerId()) {
            return false;
        }
        return true;
    }

    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        return '';
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }
}
