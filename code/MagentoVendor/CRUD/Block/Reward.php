<?php
/**
 * Catalog layer filter renderer
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MagentoVendor\CRUD\Block;
use Magento\Framework\View\Element\Template;

class Reward extends Template
{
	protected $scopeConfig;
	protected $_pageFactory;
	protected $_postFactory;
	const XML_PATH_REWARD_POINT = 'rwpoint_section/';

	// public function getConfigValue($field, $storeCode=null){
    //     return $this->scopeConfig->getValue($field,ScopeInterface::SCOPE_STORE, $storeCode);
    // }
    // public function getPointEarnSpend($fieldid = 'point_earnr', $storeCode=null){
    //     return $this->getConfigValue(self::XML_PATH_REWARD_POINT.'point_earn_calc/'.$fieldid, $storeCode);
	// }
	
	public function __construct(
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\MagentoVendor\CRUD\Model\PostFactory $postFactory,
		\Magento\Quote\Model\Quote $quote,
		\Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_postFactory = $postFactory;
		$this->scopeConfig = $scopeConfig;
		return parent::__construct($context);
	}
	public function getRewardpoint()
	{
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		// get earning rate order 
		$earning_rate = $this->scopeConfig->getValue(self::XML_PATH_REWARD_POINT.'point_earn_calc/point_earnr', $storeScope);

		// Get limit point per order 
		$limit_order = $this->scopeConfig->getValue(self::XML_PATH_REWARD_POINT.'order_limit/redem_order', $storeScope);


		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		if($customerSession->isLoggedIn()){
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
			// Get sub total of cart 
			$subTotal = $cart->getQuote()->getSubtotal();
			$grandTotal = $cart->getQuote()->getGrandTotal();
			$result = $earning_rate * $subTotal;
			$reward = number_format((float)$result, 0, '', '');
			
				return $reward;

		}
		else{
			$reward = "Please login to have reward points for this order !";
		}
		return $reward;
		//TODO: Luu xuong database cai reward nay de check history order
	}
}
