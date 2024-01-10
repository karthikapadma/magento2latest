<?php
namespace Vendor\Module\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('custom_404_logs'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'url',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'URL'
            )
            ->addColumn(
                'attempt_count',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 1],
                'Attempt Count'
            )
            ->setComment('custom 404 logs');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
 
}
