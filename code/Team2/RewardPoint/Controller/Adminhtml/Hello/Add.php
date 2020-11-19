<?php
namespace Team2\RewardPoint\Controller\Adminhtml\Hello;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Team2\RewardPoint\Model\DataExampleFactory;
use Team2\RewardPoint\Model\DataPointFactory;

class Add extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    /**
     * @var DataExampleFactory
     */
    protected $dataExample;
    protected $dataPoint;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        PageFactory $resultPageFactory,
        DataExampleFactory $dataExample,
        DataPointFactory $dataPoint
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->dataExample = $dataExample;
        $this->dataPoint = $dataPoint;
        $this->_coreRegistry = $registry;
    }

    public function execute()
    {
//        echo $_POST['action'] . "+" . $_POST['amount'] . "+" . $_POST['comment'];
        //Add to Reward Point History
        $cusId = $_POST['cusId'];
        $amount = $_POST['amount'];
        $type = $_POST['action'];
        $point = $_POST['point'];
        $comment = $_POST['comment'];

        $model = $this->dataExample->create();
        //validate
        if ($type == 'Add' && $amount >= 0)
        {
            $model->addData([
                "customer_id" => $cusId,
                "action" => 'Admin Point Change',
                "point" => $amount,
                "type" => 1,
                "order_id" => null,
                "author" => 'Admin',
                "sort_order" => 1,
                "comment" => $comment
            ]);
        }
        if ($type == 'Deduct')
        {
            if ($amount >= 0 && $amount <= $point)
            {
                $rw = $amount * -1;
                $model->addData([
                    "customer_id" => $cusId,
                    "action" => 'Admin Point Change',
                    "point" => $rw,
                    "type" => 1,
                    "order_id" => null,
                    "author" => 'Admin',
                    "sort_order" => 1,
                    "comment" => $comment
                ]);
            }
            else {
                $this->messageManager->addWarning( __('Amount in valid.') );
            }
        }
        $model->save();

        //Update to Reward Point
        $cusId = $_POST['cusId'];
        $amount = $_POST['amount'];
        $type = $_POST['action'];
        $point = $_POST['point'];

        if ($type == 'Add' && $amount >= 0)
        {
            $total = $amount + $point;
        }
        if ($type == 'Deduct')
        {
            if ($amount >= 0 && $amount <= $point)
            {
                $total = $point - $amount;
            }
            else {
                $this->messageManager->addWarning( __('Amount in valid.') );
            }
        }
        $post = $this->dataPoint->create();
        $postUpdate = $post->load($cusId);
        $postUpdate->setPoint($total);
        $postUpdate->save();


        $saveData = $model->save();
        $postData = $postUpdate->save();
        if ($saveData && $postData) {
            $this->messageManager->addSuccess(__('Insert Record Successfully !'));
        }
    }
}
