<?php

namespace Team3Vendor\GiftwrapSlider\Model\Total\Quote;

class GiftwrapCustom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal {

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        
        $giftwrap = $quote->getGiftwrap();
        $giftwrapName = $quote->getGiftwrapName();
        // $total->addTotalAmount($this->getCode(), $giftwrapPrice);
        // $total->addBaseTotalAmount($this->getCode(), $giftwrapPrice);
        // $quote->setGiftwrap($giftwrapPrice);

        // return $this;

        $total->setTotalAmount('giftwrap', $giftwrap);
        $total->setBaseTotalAmount('giftwrap', $giftwrap);
        $total->setGiftwrap($giftwrap);
        $quote->setGiftwrap($giftwrap);

        $total->setGiftwrapName($giftwrapName);
        $quote->setGiftwrapName($giftwrapName);
        
        return $this;
    }
 
    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $giftwrap = $quote->getGiftwrap();
        return [
            'code' => 'giftwrap',
            'title' => $this->getLabel(),
            'value' => $giftwrap  //You can change the reduced amount, or replace it with your own variable
        ];
    }
}