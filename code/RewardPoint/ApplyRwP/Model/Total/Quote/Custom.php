<?php
/**
 * Copyright © 2019 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace RewardPoint\ApplyRwP\Model\Total\Quote;

/**
 * Class Custom
 * @package Magenest_Discount\Discount\Model\Total\Quote
 */
class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return $this|\Magento\Quote\Model\Quote\Address\Total\AbstractTotal
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        // Get sub total of cart 
        $subTotal = $cart->getQuote()->getSubtotal();
        $point = $cart->getQuote()->getData('rewardpoint');
        $discount = $point;
        $total->addTotalAmount($this->getCode(), -$discount);
        $total->addBaseTotalAmount($this->getCode(), -$discount);
        $quote->setDiscount($discount);

        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return array
     */
    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        // Get sub total of cart 
        $subTotal = $cart->getQuote()->getSubtotal();
        $point = $cart->getQuote()->getData('rewardpoint');
        $discount = $point;

        return [
            'code'  => 'discount',
            'title' => $this->getLabel(),
            'value' => -$discount  //You can change the reduced amount, or replace it with your own variable
        ];
    }
}
