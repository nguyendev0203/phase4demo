<?php 
namespace MagentoVendor\CRUD\Controller\Point;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Result\Page;

class Point extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	protected $_postFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\MagentoVendor\CRUD\Model\PostFactory $postFactory
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_postFactory = $postFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		// $post = $this->_postFactory->create();
		// $collection = $post->getCollection();
		// foreach($collection as $item){
		// 	echo "<pre>";
		// 	print_r($item->getData());
		// 	echo "</pre>";
		// }
        // exit();
        $reward = 1;
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        /** @var Template $block */
        // $block = $page->getLayout()->getBlock('checkout.cart.reward.points.message.block');
        // $block->setData('reward_point', 'abc');

        return $page;
	}
}