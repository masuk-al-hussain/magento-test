<?php
namespace Strativ\Patch\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InsertDefaultRow implements DataPatchInterface
{
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $table = $this->moduleDataSetup->getTable('strativ_patch_item');

        $this->moduleDataSetup->getConnection()->insert($table, [
            'name' => 'First Item',
            'description' => 'This row was added by a patch.',
        ]);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies() { return []; }

    public function getAliases() { return []; }
}
