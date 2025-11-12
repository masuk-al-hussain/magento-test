<?php

namespace Strativ\Patch\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class AddNewColumnToTable implements SchemaPatchInterface
{
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();
        $tableName = $this->moduleDataSetup->getTable('strativ_patch_item');

        if ($connection->isTableExists($tableName)) {
            $connection->addColumn(
                $tableName,
                'status',
                ['type' => Table::TYPE_SMALLINT, 'nullable' => false, 'default' => 1, 'comment' => 'Item Status'],
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();

    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
