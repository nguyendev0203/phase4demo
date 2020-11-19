<?php

namespace Team3Vendor\GiftwrapSlider\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var LayoutInterface  */
    protected $_layout;
    protected $giftwrapGet;

    public function __construct(
        LayoutInterface $layout,
        \Team3Vendor\GiftwrapSlider\Block\GiftwrapGet $giftwrapGet
    )
    {
        $this->_layout = $layout;
        $this->giftwrapGet = $giftwrapGet;
    }

    public function getConfig()
    {

        return [
            'giftwrap_block_content' => $this->_layout->createBlock('Team3Vendor\GiftwrapSlider\Block\GiftwrapGet')->setTemplate('Team3Vendor_GiftwrapSlider::giftwrapSlider.phtml')->toHtml(),
            'giftwrap_label' => $this->giftwrapGet->getCurrentGiftwrapName()
        ];
    }
}