<?php

namespace Team2\RewardPoint\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Team2\RewardPoint\Model\DataExampleFactory;
use Team2\RewardPoint\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Team2\RewardPoint\Model\DataPointFactory;

class Index extends Action
{
    protected $_dataExample;
    protected $resultRedirect;
    protected $resultPageFactory;


    public function __construct(
        Context $context,
        DataExampleFactory $dataExample,
        ResultFactory $result,
        Data $helperData,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->_dataExample = $dataExample;
        $this->resultRedirect = $result;
        $this->helperData = $helperData;
        $this->resultPageFactory = $resultPageFactory;

    }

    public function execute()
    {
//        $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
//        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//        $model = $this->_dataExample->create();
//        $model->addData([
//            "customer_id" => 1,
//            "action" => 'demo',
//            "point" => 100,
//            "type" => 'shopping cart',
//            "order_id" => 2,
//            "author" => 'Demo SP',
//            "sort_order" => 1
//        ]);
//        $saveData = $model->save();
//        if ($saveData) {
//            $this->messageManager->addSuccess(__('Insert Record Successfully !'));
//        }
//        Data from config system nguyen
        echo $this->helperData->getPointEarnSpend('point_spendr');
        echo $this->helperData->getPointEarnSpend('point_earnr');
        echo $this->helperData->getOrderLimit('min_point');
        echo $this->helperData->getOrderLimit('redem_order');
        exit();
//        return $resultRedirect;

//        $dataPoint = $this->dataPoinFactory->create();
//        $pointCollection = $dataPoint->getCollection();
//        echo '<pre>';print_r($pointCollection->getData());

//        $resultPage = $this->resultPageFactory->create();
//        $resultPage->getConfig()->getTitle()->prepend(__('All News'));
//        return $resultPage;
    }

}
