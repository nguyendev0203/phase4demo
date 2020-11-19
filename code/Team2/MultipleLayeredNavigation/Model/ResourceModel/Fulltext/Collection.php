<?php

namespace Team2\MultipleLayeredNavigation\Model\ResourceModel\Fulltext;
use Magento\Framework\App\ObjectManager;

class Collection extends \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection {
	protected $_addedFilters = [];
	public function updateSearchCriteriaBuilder(){
		$searchCriteriaBuilder = ObjectManager::getInstance()
			->create(\Magento\Framework\Api\Search\SearchCriteriaBuilder::class);
		$this->setSearchCriteriaBuilder($searchCriteriaBuilder);
		return $this;
	}
}