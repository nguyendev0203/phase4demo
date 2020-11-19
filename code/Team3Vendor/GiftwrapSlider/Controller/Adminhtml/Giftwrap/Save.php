<?php

namespace Team3Vendor\GiftwrapSlider\Controller\Adminhtml\Giftwrap;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Team3Vendor\GiftwrapSlider\Model\GiftwrapFactory;
use Team3Vendor\GiftwrapSlider\Model\Giftwrap\ImageUploader;

/**
 * Class Index
 */
class Save extends Action
{

    protected $resultPageFactory;
    protected $_giftwrapFactory;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        GiftwrapFactory $giftwrapFactory,
        PageFactory $resultPageFactory,
        ImageUploader $imageUploader
    ) {
        $this->_giftwrapFactory = $giftwrapFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->imageUploader = $imageUploader;

        parent::__construct($context);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        $giftwrapDatas = $this->getRequest()->getPostValue();
        $giftwrap=$this->_giftwrapFactory->create();
        // print_r($giftwrapDatas);

        $imageName = '';
        if (!empty($giftwrapDatas['image'])) {
            $imageName = $giftwrapDatas['image'][0]['name'];
            $giftwrapDatas['image'] = $imageName;
        }

        //create new
        if (isset($giftwrapDatas['giftwrap_id']) && $giftwrapDatas['giftwrap_id'] == '') {

            unset($giftwrapDatas['giftwrap_id']);
            
            // print_r($giftwrapDatas);
            $giftwrap->setData($giftwrapDatas)->save();

        } else {
            // edit
            $id = $giftwrapDatas['giftwrap_id'];
            $giftwrap->load($id);
            $giftwrap->setData($giftwrapDatas)->save();
        }

        if ($imageName) {
            $this->imageUploader->moveFileFromTmp($imageName);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }
}
