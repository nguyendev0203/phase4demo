<?php
namespace MagentoVendor\CRUD\Model\ResourceModel;


class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('mageplaza_helloworld_post', 'post_id');
	}
	public function fetchItemsSummary($quoteId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            ['point' => $this->getTable('mageplaza_helloworld_post')],
        )->where(
            'point.name = :hung'
        );

        $result = $connection->fetchRow($select, [':hung' => $quoteId]);
        return $result;
    }
}