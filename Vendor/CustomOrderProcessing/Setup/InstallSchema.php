<?php
namespace Vendor\CustomOrderProcessing\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('vendor_order_status_history')
        )->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false]
        )->addColumn(
            'old_status',
            Table::TYPE_TEXT,
            32,
            ['nullable' => false]
        )->addColumn(
            'new_status',
            Table::TYPE_TEXT,
            32,
            ['nullable' => false]
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['default' => Table::TIMESTAMP_INIT]
        )->addIndex(
            $installer->getIdxName('vendor_order_status_history', ['order_id']),
            ['order_id']
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}