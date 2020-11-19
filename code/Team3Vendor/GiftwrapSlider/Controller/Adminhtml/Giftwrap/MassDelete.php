<?php

namespace Team3Vendor\GiftwrapSlider\Controller\Adminhtml\Giftwrap;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Team3Vendor\GiftwrapSlider\Model\GiftwrapFactory;

/**
 * Class Index
 */
class MassDelete extends Action
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $_giftwrapFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        GiftwrapFactory $giftwrapFactory,
        PageFactory $resultPageFactory
    ) {
        $this->_giftwrapFactory = $giftwrapFactory;
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
        $ids = $this->getRequest()->getParam('selected');
        $giftwrap=$this->_giftwrapFactory->create();

        foreach ($ids as $id) {
            $giftwrap->load($id)->delete();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }
}
