<?php

namespace Team3Vendor\GiftwrapSlider\Controller\Adminhtml\Giftwrap;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Team3Vendor\GiftwrapSlider\Model\Giftwrap as Giftwrap;

/**
 * Class Index
 */
class Edit extends Action
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Team 3 Manage Giftwraps')));

        return $resultPage;
    }
}
