<?php
namespace Team2\OrderComment\Api;

/**
 * Interface for saving the checkout comment to the quote for orders of logged in users
 * @api
 */
interface OrderCommentManagementInterface
{
    /**
     * @param int $cartId
     * @param \Team2\OrderComment\Api\Data\OrderCommentInterface $orderComment
     * @return string
     */
    public function saveOrderComment(
        $cartId,
        \Team2\OrderComment\Api\Data\OrderCommentInterface $orderComment
    );
}
