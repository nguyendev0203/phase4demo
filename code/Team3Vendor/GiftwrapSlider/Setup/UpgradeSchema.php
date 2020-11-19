<?php

namespace Team3Vendor\GiftwrapSlider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quoteAddressTable = 'quote_address';
        $quoteTable = 'quote';
        $orderTable = 'sales_order';
        $invoiceTable = 'sales_invoice';
        $creditmemoTable = 'sales_creditmemo';

        //Setup two columns for quote, quote_address and order
        //Quote address tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'giftwrap',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Giftwrap'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'giftwrap_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftwrap Name'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'giftmessage',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftmessage'
                ]
            );

        //Quote tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'giftwrap',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Giftwrap'
                ]
            );

            $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'rewardpoint',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'default' => 0,
                    'nullable' => true,
                    'comment' =>'rewardpoint'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'giftwrap_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftwrap Name'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'giftmessage',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftmessage'
                ]
            );

        //Order tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'giftwrap',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Giftwrap'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'giftwrap_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftwrap Name'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'giftmessage',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' =>'255',
                    'default' => '',
                    'nullable' => true,
                    'comment' =>'Giftmessage'
                ]
            );

        //Invoice tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($invoiceTable),
                'giftwrap',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Giftwrap'
                ]
            );
        //Credit memo tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($creditmemoTable),
                'giftwrap',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' =>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Giftwrap'
                ]
            );


        $setup->endSetup();
    }
}
