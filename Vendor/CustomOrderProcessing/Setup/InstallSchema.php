<?php
namespace Vendor\CustomOrderProcessing\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('custom_order_status_log')) {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('custom_order_status_log')
            )->addColumn(
                'log_id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ], 'ID'
            )->addColumn(
                'order_id', Table::TYPE_INTEGER, null, ['nullable' => false], 'Order ID'
            )->addColumn(
                'old_status', Table::TYPE_TEXT, 32, [], 'Old Status'
            )->addColumn(
                'new_status', Table::TYPE_TEXT, 32, [], 'New Status'
            )->addColumn(
                'changed_at', Table::TYPE_TIMESTAMP, null, ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], 'Changed At'
            )->setComment('Custom Order Status Log');
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
