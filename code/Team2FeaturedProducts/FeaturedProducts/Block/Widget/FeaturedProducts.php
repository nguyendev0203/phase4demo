<?php


namespace Team2FeaturedProducts\FeaturedProducts\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class FeaturedProducts extends Template implements BlockInterface
{
    protected $_template = 'Team2FeaturedProducts_FeaturedProducts::widget/FeaturedProducts.phtml';

    protected $_productCollectionFactory;
    protected $_categoryCollectionFactory;
    protected $_productRepository;
    protected $_registry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get category collection
     *
     * @param bool $isActive
     * @param bool|int $level
     * @param bool|string $sortBy
     * @param bool|int $pageSize
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection or array
     */
    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('feature_status','1');

        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }

        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    /**
     * @param $ids
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollectionByCategories($ids)
    {
        $numberProduct = (int)$this->getData('numberProduct');
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);
        $collection->getSelect()->orderRand()->limit($numberProduct);
        return $collection;
    }

    public function getProductNewArrival()
    {
        $objectManager=   \Magento\Framework\App\ObjectManager::getInstance();

        $attrSetName = 'GiftWrap';
        $attribute_set_factoryCollection = $objectManager->get('\Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory');

        $attribute_set_collection = $attribute_set_factoryCollection->create();

        $attribute_set_collection
        ->addFieldToFilter('entity_type_id',4)
        ->addFieldToFilter('attribute_set_name',$attrSetName);

        $att_set = current($attribute_set_collection->getData());
        $attribute_set_id = $att_set["attribute_set_id"];

        $numberProduct = (int)$this->getData('numberProduct');
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addFieldToFilter('attribute_set_id',array('nin' => array($attribute_set_id)));
        $collection->addAttributeToSort('created_at', 'DESC');
        $collection->getSelect()->limit($numberProduct);
        return $collection;
    }

    public function getProductPrice(\Magento\Catalog\Model\Product $product)
    {
        $priceRender = $this->getPriceRender();

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]
            );
        }

        return $price;
    }

    /**
     * Specifies that price rendering should be done for the list of products
     * i.e. rendering happens in the scope of product list, but not single product
     *
     * @return \Magento\Framework\Pricing\Render
     */
    protected function getPriceRender()
    {
        return $this->getLayout()->getBlock('product.price.render.default')
                    ->setData('is_product_list', true);
    }
}
