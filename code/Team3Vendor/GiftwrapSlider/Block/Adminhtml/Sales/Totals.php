<?php

namespace Team3Vendor\GiftwrapSlider\Block\Adminhtml\Sales;

class Totals extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magecomp\Extrafee\Helper\Data
     */
    protected $giftwrapGet;
   

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $_currency;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Team3Vendor\GiftwrapSlider\Block\GiftwrapGet $giftwrapGet,
        \Magento\Directory\Model\Currency $currency,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->giftwrapGet = $giftwrapGet;
        $this->_currency = $currency;
    }

    /**
     * Retrieve current order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    /**
     *
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getOrder();
        $this->getSource();

        if(!$this->getSource()->getGiftwrap()) {
            return $this;
        }

        $label = 'Giftwrap ' . $this->getSource()->getGiftwrapName();

        $total = new \Magento\Framework\DataObject(
            [
                'code' => 'giftwrap',
                'value' => $this->getSource()->getGiftwrap(),
                'label' => $label,
            ]
        );
        $this->getParentBlock()->addTotalBefore($total, 'grand_total');

        return $this;
    }
}
