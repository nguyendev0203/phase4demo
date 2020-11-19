<?php
namespace Team2DetailPage\CustomHTMLBlock\Block\Widget;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class CustomHtmlBlock extends Template implements BlockInterface {
    protected $_template = "Team2DetailPage_CustomHTMLBlock::widget/CustomHtmlBlock.phtml";
}   