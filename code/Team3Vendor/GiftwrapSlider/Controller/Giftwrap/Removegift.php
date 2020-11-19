<?php

namespace Team3Vendor\GiftwrapSlider\Controller\Giftwrap;

/**
 * Class Index
 */
class Removegift extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $quoteRepository;
    protected $resultFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->resultFactory = $resultFactory;

        parent::__construct($context);
    }

    public function removeQuoteData($quoteId)
    {
        $quote = $this->quoteRepository->get($quoteId); // Get quote by id
        $quote->setData('giftmessage', ''); // Fill data
        $quote->setData('giftwrap', 0); // Fill data
        $quote->setData('giftwrap_name', '');
        $this->quoteRepository->save($quote); // Save quote
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');    
        // $totalItems = $cart->getQuote()->getItemsCount(); 
        // $totalQuantity = $cart->getQuote()->getItemsQty();
        // $grandTotal = $cart->getQuote()->getGrandTotal();
        // $giftwrap = $cart->getQuote()->getGiftwrap();
        // echo $giftwrap;

        $quoteId = $cart->getQuote()->getId();
        // echo $cart->getQuote()->getId();
        $this->removeQuoteData($quoteId);

        $grandTotal = $cart->getQuote()->getGrandTotal();
        $response = $this->resultFactory
        ->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
        ->setData([
            'grandtotal'  => $grandTotal,
        ]);
        return $response;
    }
}
