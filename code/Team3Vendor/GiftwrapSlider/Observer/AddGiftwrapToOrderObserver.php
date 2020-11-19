<?php
namespace Team3Vendor\GiftwrapSlider\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class AddGiftwrapToOrderObserver implements ObserverInterface
{
    /**
     * Set payment fee to order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();
        $giftwrap = $quote->getGiftwrap();
        $giftwrapName = $quote->getGiftwrapName();
        $giftmessage = $quote->getGiftmessage();
        if (!$giftwrap) {
            return $this;
        }
        //Set fee data to order
        $order = $observer->getOrder();
        $order->setData('giftwrap', $giftwrap);
        $order->setData('giftwrap_name', $giftwrapName);
        $order->setData('giftmessage', $giftmessage);
        
		return $this;
    }
}
