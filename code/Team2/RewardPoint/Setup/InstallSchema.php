<?php

namespace Team2\RewardPoint\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

            $table = $installer->getConnection()->newTable(
                $installer->getTable('reward_point')
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned'=>true,
                        'nullable => false',
                        'default'=>'0'
                    ],
                    'Customer ID'
                )
                ->addColumn(
                    'point',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable => false',
                        'default'=>'0'
                    ],
                    'Point Number'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Type'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'reward_point','customer_id',
                        'customer_entity','entity_id'
                    ),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id'
                )
                ->setComment('Post2 Table');
            $installer->getConnection()->createTable($table);




            $table = $installer->getConnection()->newTable(
                $installer->getTable('reward_point_history')
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned'=>true,
                        'nullable => false',
                        'default'=>'0'
                    ],
                    'Customer ID'
                )
                ->addColumn(
                    'action',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Action'
                )
                ->addColumn(
                    'point',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable => false',
                        'default'=>'0'
                    ],
                    'Point Number'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Type'
                )
                ->addColumn(
                    'order_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned'=>true,
                        'nullable => false',
                        'default'=>'0'
                    ],
                    'Order ID'
                )
                ->addColumn(
                    'author',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Author'
                )
                ->addColumn(
                    'comment',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Comment'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->addForeignKey(
                    $installer->getFkName(
                        'reward_point_history','customer_id',
                        'customer_entity','entity_id'
                    ),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'reward_point_history','order_id',
                        'sales_order','entity_id'
                    ),
                    'order_id',
                    $installer->getTable('sales_order'),
                    'entity_id'
                )

                ->setComment('Post Table');


            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('reward_point_history'),
                $setup->getIdxName(
                    $installer->getTable('reward_point_history'),
                    ['action','point','type', 'order_id','author'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['action','type', 'author'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        $installer->getConnection()->addIndex(
            $installer->getTable('reward_point'),
            $setup->getIdxName(
                $installer->getTable('reward_point'),
                ['type'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['type'],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );


        $installer->endSetup();
    }
}
