<?php
namespace Team3Vendor\GiftwrapSlider\Model\ResourceModel\Giftwrap;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'giftwrap_id';
	protected $_eventPrefix = 'team3vendor_giftwrapslider_giftwrap';
	protected $_eventObject = 'giftwrap_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Team3Vendor\GiftwrapSlider\Model\Giftwrap', 'Team3Vendor\GiftwrapSlider\Model\ResourceModel\Giftwrap');
	}

}