<?php
namespace Team2\OrderComment\Model\Data;

use Team2\OrderComment\Api\Data\OrderCommentInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class OrderComment extends AbstractSimpleObject implements OrderCommentInterface
{
    const COMMENT_FIELD_NAME = 'bold_order_comment';

    /**
     * @return string|null
     */
    public function getComment()
    {
        return $this->_get(static::COMMENT_FIELD_NAME);
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        return $this->setData(static::COMMENT_FIELD_NAME, $comment);
    }
}
