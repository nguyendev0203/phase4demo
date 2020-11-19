 <?php

namespace Team3Vendor\GiftwrapSlider\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('team3vendor_giftwrapslider_giftwrap')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('team3vendor_giftwrapslider_giftwrap'))
                ->addColumn(
                    'giftwrap_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true
                    ],
                    'Giftwrap ID'
                )
                ->addColumn('store_ids', Table::TYPE_TEXT, 255, [])
                ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Status')
                ->addColumn('image', Table::TYPE_TEXT, 255, [], 'Giftwrap Image')         
                ->addColumn('title', Table::TYPE_TEXT, 255, [], 'Title')
                ->addColumn('price', Table::TYPE_TEXT, 255, [], 'Price')
                ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Giftwrap Created At')
                ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Giftwrap Updated At')
                ->setComment('Gitwrap Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('team3vendor_giftwrapslider_giftwrap'),
                $setup->getIdxName(
                    $installer->getTable('team3vendor_giftwrapslider_giftwrap'),
                    ['image', 'title', 'link_url'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['image', 'title', 'price'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        $installer->endSetup();
    }
}
