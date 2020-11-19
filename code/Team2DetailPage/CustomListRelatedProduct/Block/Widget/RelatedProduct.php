<?php
namespace Team2DetailPage\CustomListRelatedProduct\Block\Widget;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Widget\Block\BlockInterface;

class RelatedProduct extends Template implements BlockInterface{
    protected $registry;
    protected $_template = "widget/items.phtml";
    public function __construct(
        Context $context,
        Registry $registry,
        array $data =[]
    )
    {
        $this->registry = $registry;
        parent::__construct($context,$data);
    }
    public function _prepareLayout(){
        return parent::_prepareLayout();
    }
    public function getCurrentProduct(){
        return $this->registry->registry('current_product');
    }
}