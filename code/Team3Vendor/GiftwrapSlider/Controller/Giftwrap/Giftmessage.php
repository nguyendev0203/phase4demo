<?php

namespace Team3Vendor\GiftwrapSlider\Controller\Giftwrap;

/**
 * Class Index
 */
class Giftmessage extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $quoteRepository;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;

        parent::__construct($context);
    }

    public function updateQuoteData($quoteId, $giftmessage)
    {
        $quote = $this->quoteRepository->get($quoteId); // Get quote by id
        $quote->setData('giftmessage', $giftmessage); // Fill data
        $this->quoteRepository->save($quote); // Save quote
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        $giftmessage = $this->getRequest()->getParam('giftmessage');

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');    
        // $totalItems = $cart->getQuote()->getItemsCount(); 
        // $totalQuantity = $cart->getQuote()->getItemsQty();
        // $grandTotal = $cart->getQuote()->getGrandTotal();
        // $giftwrap = $cart->getQuote()->getGiftwrap();
        // echo $giftwrap;
        echo $giftmessage;
        $quoteId = $cart->getQuote()->getId();
        // echo $cart->getQuote()->getId();
        $this->updateQuoteData($quoteId, $giftmessage);

    }
}
