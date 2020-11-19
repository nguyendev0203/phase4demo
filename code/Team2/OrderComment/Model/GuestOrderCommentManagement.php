<?php
namespace Team2\OrderComment\Model;

use Magento\Quote\Model\QuoteIdMaskFactory;

class GuestOrderCommentManagement implements \Team2\OrderComment\Api\GuestOrderCommentManagementInterface
{

    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var \Team2\OrderComment\Api\OrderCommentManagementInterface
     */
    protected $orderCommentManagement;

    /**
     * GuestOrderCommentManagement constructor.
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Team2\OrderComment\Api\OrderCommentManagementInterface $orderCommentManagement
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Team2\OrderComment\Api\OrderCommentManagementInterface $orderCommentManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->orderCommentManagement = $orderCommentManagement;
    }

    /**
     * {@inheritDoc}
     */
    public function saveOrderComment(
        $cartId,
        \Team2\OrderComment\Api\Data\OrderCommentInterface $orderComment
    ) {
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->orderCommentManagement->saveOrderComment($quoteIdMask->getQuoteId(), $orderComment);
    }
}
