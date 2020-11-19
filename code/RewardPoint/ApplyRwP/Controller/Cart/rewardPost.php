<?php

namespace RewardPoint\ApplyRwP\Controller\Cart;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;

class rewardPost extends \Magento\Checkout\Controller\Cart implements HttpPostActionInterface
{
    protected $scopeConfig;
    const XML_PATH_REWARD_POINT = 'rwpoint_section/';
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        // \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        // \Magento\Framework\View\Result\PageFactory $pageFactory,
		// \MagentoVendor\CRUD\Model\PostFactory $postFactory,
		\Magento\Quote\Model\Quote $quote,
		\Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) 
    {
         // $this->couponFactory = $couponFactory;
         $this->quoteRepository = $quoteRepository;
         // $this->_pageFactory = $pageFactory;
         // $this->_postFactory = $postFactory;
         $this->scopeConfig = $scopeConfig;
        return parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
       
    }
    public function updateQuoteData($quoteId, $point)
    {
        $quote = $this->quoteRepository->get($quoteId); // Get quote by id
        $quote->setData('rewardpoint', $point); // Fill data
        $this->quoteRepository->save($quote); // Save quote
    }
    public function execute()
    {
        // $pointCurrent = 1900;  // Take from database
        //point obj
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        
        $customer_id = $cart->getQuote()->getData('customer_id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('reward_point');
        $sql2 = "Select * FROM " . $tableName." Where customer_id=".$customer_id;
        $result = $connection->fetchAll($sql2);
        foreach($result as $row){
            $rwpoint = $row["point"];
        }
        $pointCurrent = $rwpoint;
        //end point
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		// get earning rate order 
		$pointSpendRate = $this->scopeConfig->getValue(self::XML_PATH_REWARD_POINT.'point_earn_calc/point_spendr', $storeScope);

        // get minium rate order 
        $pointMinimumRequire = $this->scopeConfig->getValue(self::XML_PATH_REWARD_POINT.'order_limit/min_point', $storeScope);

        // Get limit point per order 
		$pointLimitperOrder = $this->scopeConfig->getValue(self::XML_PATH_REWARD_POINT.'order_limit/redem_order', $storeScope);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        // Get sub total of cart 
        $orderTotal = $cart->getQuote()->getSubtotal();

        $rewardPoint = $this->getRequest()->getParam('remove') == 1
            ? ''
            : trim($this->getRequest()->getParam('reward_point'));
            
        
        try {
            $escaper = $this->_objectManager->get(\Magento\Framework\Escaper::class);
            if ($rewardPoint < 0){
                $this->messageManager->addWarningMessage(
                    __(
                        'Your redemption points are not valid. Please try again.'
                        // $escaper->escapeHtml($rewardPoint)
                    ));
                    return $this->_goBack();
            }
            elseif ($rewardPoint > $pointCurrent){
                $this->messageManager->addWarningMessage(
                    __(
                        'Your redemption points are higher than your current points. Please try again.'
                        // $escaper->escapeHtml($pointLimitperOrder)
                    ));
                    return $this->_goBack();
            }
            elseif ($rewardPoint > $pointLimitperOrder){
                $this->messageManager->addWarningMessage(
                    __(
                        'Number of redemption reward points cannot exceed "%1" for this order. You used "%1" point(s)',
                        $escaper->escapeHtml($pointLimitperOrder)
                    ));
                    return $this->_goBack();
            }
            elseif ($rewardPoint*$pointSpendRate > $orderTotal){
                $this->messageManager->addWarningMessage(
                    __(
                        'Reward point higher than total order. '
                    ));
                    return $this->_goBack();
            }
            else{
                // $this->_checkoutSession->getQuote()->setCouponCode($rewardPoint)->save();
                $this->messageManager->addSuccessMessage(
                    __(
                        'You used "%1" points.',
                        $escaper->escapeHtml($rewardPoint)
                    )
                );
                $hasReward = true;
                $quoteId = $cart->getQuote()->getId();
                // echo $cart->getQuote()->getId();
                $point = $rewardPoint/$pointSpendRate;
                $this->updateQuoteData($quoteId, $point);

                return $this->_goBack();

        
            }
            // $isCodeLengthValid = $codeLength && $codeLength <= \Magento\Checkout\Helper\Cart::COUPON_CODE_MAX_LENGTH;

            // $itemsCount = $cartQuote->getItemsCount();
            // if ($itemsCount) {
            //     $cartQuote->getShippingAddress()->setCollectShippingRates(true);
            //     $cartQuote->setCouponCode($isCodeLengthValid ? $couponCode : '')->collectTotals();
            //     $this->quoteRepository->save($cartQuote);
            // }

            // if ($codeLength) {
            //     $escaper = $this->_objectManager->get(\Magento\Framework\Escaper::class);
            //     $coupon = $this->couponFactory->create();
            //     $coupon->load($couponCode, 'code');
            //     if (!$itemsCount) {
            //         if ($isCodeLengthValid && $coupon->getId()) {
            //             $this->_checkoutSession->getQuote()->setCouponCode($couponCode)->save();
            //             $this->messageManager->addSuccessMessage(
            //                 __(
            //                     'You used coupon code "%1".',
            //                     $escaper->escapeHtml($couponCode)
            //                 )
            //             );
            //         } else {
            //             $this->messageManager->addErrorMessage(
            //                 __(
            //                     'The coupon code "%1" is not valid.',
            //                     $escaper->escapeHtml($couponCode)
            //                 )
            //             );
            //         }
            //     } else {
            //         if ($isCodeLengthValid && $coupon->getId() && $couponCode == $cartQuote->getCouponCode()) {
            //             $this->messageManager->addSuccessMessage(
            //                 __(
            //                     'You used coupon code "%1".',
            //                     $escaper->escapeHtml($couponCode)
            //                 )
            //             );
            //         } else {
            //             $this->messageManager->addErrorMessage(
            //                 __(
            //                     'The coupon code "%1" is not valid.',
            //                     $escaper->escapeHtml($couponCode)
            //                 )
            //             );
            //         }
            //     }
            // } else {
            //     $this->messageManager->addSuccessMessage(__('You canceled the coupon code.'));
            // }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('We cannot apply the reward.'));
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
        }
        // echo "cc";
        return $this->_goBack();
    }

}
