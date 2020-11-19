<?php
namespace Team2\OrderComment\Api;

/**
 * Interface for saving the checkout comment to the quote for guest orders
 */
interface GuestOrderCommentManagementInterface
{
    /**
     * @param string $cartId
     * @param \Team2\OrderComment\Api\Data\OrderCommentInterface $orderComment
     * @return \Magento\Checkout\Api\Data\PaymentDetailsInterface
     */
    public function saveOrderComment(
        $cartId,
        \Team2\OrderComment\Api\Data\OrderCommentInterface $orderComment
    );
}
