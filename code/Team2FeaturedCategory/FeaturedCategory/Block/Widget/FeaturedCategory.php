<?php
namespace Team2FeaturedCategory\FeaturedCategory\Block\Widget;

class FeaturedCategory extends \Magento\Framework\View\Element\Template
{
    protected $_categoryFactory;
    protected $helperData;
    protected $_template = 'widget/FeaturedCategory.phtml';
    /**
     * @var \Magento\Review\Model\RatingFactory
     */

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Team2FeaturedCategory\FeaturedCategory\Helper\Data $helperData,
        array $data = []
    )
    {
        $this->_categoryFactory = $categoryFactory;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    public function getCategoryProductCollection()
    {
        $categoryId = $this->helperData->getGeneralConfig('category_id');
        $category = $this->_categoryFactory->create()->load($categoryId);

        $collection = $category->getProductCollection()
            ->addAttributeToSelect('*')
            ->setPageSize($this->helperData->getGeneralConfig('limit_product'));
        //$collection->getSelect()->orderRand();
        return $collection;
    }

    public function getNameDisplay()
    {
        return $this->helperData->getGeneralConfig('display_name');
    }

    public function getProductPriceHtml(
        \Magento\Catalog\Model\Product $product,
        $priceType = null,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }
        $arguments['price_id'] = isset($arguments['price_id'])
            ? $arguments['price_id']
            : 'old-price-' . $product->getId() . '-' . $priceType;
        $arguments['include_container'] = isset($arguments['include_container'])
            ? $arguments['include_container']
            : true;
        $arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
            ? $arguments['display_minimal_price']
            : true;

            /** @var \Magento\Framework\Pricing\Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                $arguments
            );
        }
        return $price;
    }
}
