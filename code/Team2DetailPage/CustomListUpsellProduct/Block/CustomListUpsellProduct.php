<?php
    namespace Team2DetailPage\CustomListUpsellProduct\Block;
    class CustomListUpsellProduct extends \Magento\Framework\View\Element\Template{
        protected $_registry;
        public function __construct(  
            \Magento\Backend\Block\Template\Context $context,
            \Magento\Framework\Registry $registry,
        array $data = []
        )
        {
            $this->_registry = $registry;
            parent::__construct($context,$data);
        }
        public function _prepareLayout(){
            return parent::_prepareLayout();
        }
        public function _getCurrentProduct(){
            return $this->_registry->registry('current_product');
        }
        
        public function getItems() {
            $items = $this->getData('items');
            if ($items === null) {
                $product = $this->getCurrentProduct();
                $items = $product->getCrossSellProducts();
                $this->setData('items', $items);
            }
            return $items;
        }

        public function getItemCount() {
            return count($this->getItems());
        }
    }
?>