<?php

namespace Team3Vendor\GiftwrapSlider\Block\Adminhtml\Sales;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Sales\Model\Order;

class Giftmessage extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    public function __construct(
        TemplateContext $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/comment.phtml';
        parent::__construct($context, $data);
    }

    public function getOrder() : Order
    {
        return $this->coreRegistry->registry('current_order');
    }

    public function getOrderGiftmessage()
    {
        return $this->getOrder()->getData('giftmessage');
    }


}
