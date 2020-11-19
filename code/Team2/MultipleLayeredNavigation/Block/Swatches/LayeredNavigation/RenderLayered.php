<?php

namespace Team2\MultipleLayeredNavigation\Block\Swatches\LayeredNavigation;
class RenderLayered extends \Magento\Swatches\Block\LayeredNavigation\RenderLayered {
	protected $urlBuilder;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Eav\Model\Entity\Attribute $eavAttribute,
		\Magento\Catalog\Model\ResourceModel\Layer\Filter\AttributeFactory $layerAttribute,
		\Magento\Swatches\Helper\Data $swatchHelper,
		\Magento\Swatches\Helper\Media $mediaHelper,
		\Team2\MultipleLayeredNavigation\Model\Url\Builder $urlBuilder,
		array $data = []
	) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct(
			$context,
			$eavAttribute,
			$layerAttribute,
			$swatchHelper,
			$mediaHelper,
			$data
		);
	}
	public function buildUrl($attributeCode, $optionId){
		if(in_array($optionId, $this->urlBuilder->getValuesFromUrl($attributeCode))){
			return $this->urlBuilder->getRemoveFilterUrl($attributeCode, $optionId);
		}
		else{
			return $this->urlBuilder->getFilterUrl($attributeCode, $optionId);
		}
	}
}