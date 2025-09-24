<?php

namespace Strativ\FormGrid\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Strativ\FormGrid\Model\ResourceModel\Faq;

class InitialFaqs implements DataPatchInterface
{

    /** @var ModuleDataSetupInterface */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /** @var ResourceConnection */
    protected ResourceConnection $resource;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ResourceConnection $resource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ResourceConnection       $resource,
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->resource = $resource;
    }

    /**
     * Retuns array of dependencies
     *
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Returns array of aliases
     *
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Run patch
     *
     * @return self
     */
    public function apply(): self
    {
        $connection = $this->resource->getConnection();
        $data = [
            [
                'question' => 'How do I install Magento?',
                'answer' => 'You can install Magento by following the instructions on the Magento website.',
                'is_published' => 1,
            ],
            [
                'question' => 'How do I update Magento?',
                'answer' => 'You can update Magento by following the instructions on the Magento website.',
                'is_published' => 1,
            ],
            [
                'question' => 'How do I uninstall Magento?',
                'answer' => 'You can uninstall Magento by following the instructions on the Magento website.',
                'is_published' => 0,
            ]
        ];
        $connection->insertMultiple(Faq::MAIN_TABLE, $data);

        return $this;
    }
}
