<?php

namespace Team2\MultipleLayeredNavigation\Model\Layer\Filter;

class Attribute extends \Magento\CatalogSearch\Model\Layer\Filter\Attribute {
	protected $tagFilter;
	protected $urlBuilder;
	protected $request;
	protected $storeManager;
	protected $collectionProvider;
    protected $categoryFactory;
    protected $productCollectionFactory;
	public function __construct(
		\Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Catalog\Model\Layer $layer,
		\Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder,
		\Magento\Framework\Filter\StripTags $tagFilter,
		\Magento\Framework\App\RequestInterface $request,
		\Team2\MultipleLayeredNavigation\Model\Url\Builder $urlBuilder,
		\Team2\MultipleLayeredNavigation\Model\Layer\ItemCollectionProvider $collectionProvider,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		array $data = []
	){
		parent::__construct(
			$filterItemFactory,
			$storeManager,
			$layer,
			$itemDataBuilder,
			$tagFilter,
			$data
		);
		$this->tagFilter = $tagFilter;
		$this->urlBuilder = $urlBuilder;
		$this->request = $request;
		$this->storeManager = $storeManager;
		$this->collectionProvider = $collectionProvider;
        $this->categoryFactory = $categoryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
	}
	public function apply(\Magento\Framework\App\RequestInterface $request){
		$values = $this->urlBuilder->getValuesFromUrl($this->_requestVar);
		if (!$values){
			return $this;
		}

        $attribute = $this->getAttributeModel();
        /** @var \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $productCollection */
        $productCollection = $this->getLayer()
            ->getProductCollection();
        // $productCollection->addAttributeToFilter($attribute->getAttributeCode(), array('in' => $values));
        $productCollection->addFieldToFilter($attribute->getAttributeCode(), $values);

        if (($attribute->getAttributeCode() == "color" || $attribute->getAttributeCode() == "size") && count($values)>1) {
            $productCollectionClone = $this->collectionProvider->getCollection($this->getCurrentCategory());
            $productCollectionClone->addAttributeToSelect("*")->addAttributeToFilter("type_id", "configurable");

            $productArr = array();
            foreach ($productCollectionClone as $configurableProduct){
                $childrenIds = $configurableProduct->getTypeInstance()->getChildrenIds($configurableProduct->getId());
                $productCollectionFactory = $this->productCollectionFactory->create()->addIdFilter($childrenIds);
                $productCollectionFactory->addAttributeToSelect($attribute->getAttributeCode());
                $attributeArr = array();
                foreach ($productCollectionFactory as $product){
                    array_push($attributeArr, $product->getData($attribute->getAttributeCode()));
                }

                $check = true;
                foreach ($values as $value) {
                    if (!in_array($value, $attributeArr)) {
                        $check = false; 
                    }
                }

                if ($check == true) {
                    array_push($productArr, $configurableProduct->getId());
                }

                // print_r($configurableProduct->getData());
                // echo "<br>";
            }  
            // print_r($productArr);

            $productCollection->addAttributeToFilter('entity_id', array('in' => $productArr));
        }
        // exit();
        
        // foreach ($productCollection as $product){
        //     echo 'Name  =  '.$product->getName().'<br>';
        // }  
        // exit();

        // print_r($values);
        // exit();

        // foreach ((array) $values as $value) {
        //     $productCollection->addFieldToFilter($attribute->getAttributeCode(), $value);
        // }
        // $productCollection->addFieldToFilter('type_id', 'configurable')->load();

        $labels = [];
        foreach ((array) $values as $value) {
            $label = $this->getOptionText($value);
            $this->getLayer()->getState()->addFilter($this->_createItem($label, $value));
            // $labels[] = is_array($label) ? $label : [$label];
        }
        // $label = implode(',', array_unique(array_merge(...$labels)));
        // $this->getLayer()
        //     ->getState()
        //     ->addFilter($this->_createItem($label, $values));

        // $this->setItems([]); // set items to disable show filtering
        return $this;
	}

	protected function _getItemsData(){
        // $pricefrom = $this->getLayer()->getProductCollection()->getMinPrice();
        // $priceto = $this->getLayer()->getProductCollection()->getMaxPrice();

		$attribute = $this->getAttributeModel();

        $values = $this->urlBuilder->getValuesFromUrl($this->_requestVar);

        /** @var \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $productCollection */
        $productCollection = $this->getLayer()
            ->getProductCollection();

        // echo count($productCollection);

        
        // $productCollection->addAttributeToFilter('entity_id', 2052);

        // foreach ($productCollection as $product){
        //     echo 'Name  =  '.$product->getName().'<br>';
        // }  
        // exit();
        // $productCollection = $this->collectionProvider->getCollection($this->getCurrentCategory());
        // $productCollection->updateSearchCriteriaBuilder();
        // $productCollection->addCategoryFilter($this->getCurrentCategory());

        // if ($this->request->getParam('cat')) {
        //     $categoryId = $this->request->getParam('cat');
        //     $category = $this->categoryFactory->create()->load($categoryId);
        //     $productCollection->addCategoryFilter($category);
        // }     

        // $productCollection = $productCollection->addFieldToFilter('price', array('from' => $pricefrom, 'to' => $priceto));

        $optionsFacetedData = $productCollection->getFacetedData($attribute->getAttributeCode());

        // if (($attribute->getAttributeCode() == "color" || $attribute->getAttributeCode() == "size") && count($values)>1) {
        //     $productCollectionClone = $this->collectionProvider->getCollection($this->getCurrentCategory());
        //     $productCollectionClone->addAttributeToSelect("*")->addAttributeToFilter("type_id", "configurable");

        //     $productArr = array();
        //     foreach ($productCollectionClone as $configurableProduct){
        //         $childrenIds = $configurableProduct->getTypeInstance()->getChildrenIds($configurableProduct->getId());
        //         $productCollectionFactory = $this->productCollectionFactory->create()->addIdFilter($childrenIds);
        //         $productCollectionFactory->addAttributeToSelect($attribute->getAttributeCode());
        //         $attributeArr = array();
        //         foreach ($productCollectionFactory as $product){
        //             array_push($attributeArr, $product->getData($attribute->getAttributeCode()));
        //         }

        //         $check = true;
        //         foreach ($values as $value) {
        //             if (!in_array($value, $attributeArr)) {
        //                 $check = false; 
        //             }
        //         }

        //         if ($check == true) {
        //             array_push($productArr, $configurableProduct->getId());
        //         }

        //     }  
        //     $productCollection->addAttributeToFilter('entity_id', array('in' => $productArr));

        //     $optionsFacetedDataClone = array();
        //     foreach ($productCollection as $configurableProduct) {
        //         $childrenIds = $configurableProduct->getTypeInstance()->getChildrenIds($configurableProduct->getId());
        //         $productCollectionFactory = $this->productCollectionFactory->create()->addIdFilter($childrenIds);
        //         $productCollectionFactory->addAttributeToSelect($attribute->getAttributeCode());
        //         $attributeArr = array();
        //         foreach ($productCollectionFactory as $product){
        //             array_push($attributeArr, $product->getData($attribute->getAttributeCode()));
        //         }

        //         foreach ($optionsFacetedData as $key => $value) {
        //             if (in_array($key, $attributeArr)) {
        //                 $optionsFacetedDataClone[$key] = $value; 
        //             }
        //         }
        //     }

        //     $optionsFacetedData = $optionsFacetedDataClone;
        //     // print_r($optionsFacetedDataClone);
        //     // exit();
        // }

        if ($attribute->getAttributeCode()) {
            $optionsFacetedDataClone = array();
            foreach ($productCollection as $currentProduct) {
                $childrenIds = $currentProduct->getTypeInstance()->getChildrenIds($currentProduct->getId());
                
                if (count($childrenIds) > 0) {

                    $productCollectionFactory = $this->productCollectionFactory->create()->addIdFilter($childrenIds);
                    $productCollectionFactory->addAttributeToSelect($attribute->getAttributeCode());
                    $attributeArr = array();
                    foreach ($productCollectionFactory as $product){
                        array_push($attributeArr, $product->getData($attribute->getAttributeCode()));
                    }

                    foreach ($optionsFacetedData as $key => $value) {
                        if (in_array($key, $attributeArr)) {
                            $optionsFacetedDataClone[$key] = $value; 
                        }
                    }
                } else {
                    foreach ($optionsFacetedData as $key => $value) {
                        if ($key == $currentProduct->getData($attribute->getAttributeCode())) {
                            $optionsFacetedDataClone[$key] = $value; 
                        }
                    }
                }
            }
            $optionsFacetedData = $optionsFacetedDataClone; 
        }

        

        $isAttributeFilterable =
            $this->getAttributeIsFilterable($attribute) === static::ATTRIBUTE_OPTIONS_ONLY_WITH_RESULTS;

        // print_r($optionsFacetedData);

        if (count($optionsFacetedData) === 0 && !$isAttributeFilterable) {
            return $this->itemDataBuilder->build();
        }

        $options = $attribute->getFrontend()
            ->getSelectOptions();
        foreach ($options as $option) {
            $this->buildOptionData($option, $isAttributeFilterable, $optionsFacetedData);
        }

        return $this->itemDataBuilder->build();
	}

	/**
     * Build option data
     *
     * @param array $option
     * @param boolean $isAttributeFilterable
     * @param array $optionsFacetedData
     * @return void
     */
    private function buildOptionData($option, $isAttributeFilterable, $optionsFacetedData)
    {
        $value = $this->getOptionValue($option);
        if ($value === false) {
            return;
        }
        $count = $this->getOptionCount($value, $optionsFacetedData);
        if ($isAttributeFilterable && $count === 0) {
            return;
        }

        $this->itemDataBuilder->addItemData(
            $this->tagFilter->filter($option['label']),
            $value,
            $count
        );
    }

    /**
     * Retrieve option value if it exists
     *
     * @param array $option
     * @return bool|string
     */
    private function getOptionValue($option)
    {
        if (empty($option['value']) && !is_numeric($option['value'])) {
            return false;
        }
        return $option['value'];
    }

    /**
     * Retrieve count of the options
     *
     * @param int|string $value
     * @param array $optionsFacetedData
     * @return int
     */
    private function getOptionCount($value, $optionsFacetedData)
    {
        return isset($optionsFacetedData[$value]['count'])
            ? (int)$optionsFacetedData[$value]['count']
            : 0;
    }

	private function getCurrentCategory(){
		return $this->getLayer()->getCurrentCategory();
	}
}