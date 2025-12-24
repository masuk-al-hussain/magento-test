<?php

namespace Strativ\CategoryBanner\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Category\Attribute\Backend\Image;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Validator\ValidateException;

class AddCategoryBannerAttribute implements DataPatchInterface
{
    /**@var ModuleDataSetupInterface */
    private ModuleDataSetupInterface $moduleDataSetup;
    /** @var EavSetupFactory */
    private EavSetupFactory $eavSetupFactory;

    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Apply the data patch to add the category banner image attribute
     *
     * @return $this
     * @throws LocalizedException|ValidateException
     */
    public function apply(): self
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            Category::ENTITY,
            'category_banner_image',
            [
                'type' => 'varchar',
                'label' => 'Banner Image',
                'input' => 'image',
                'backend' => Image::class,
                'required' => false,
                'sort_order' => 10,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Content',
                'used_in_product_listing' => false,
                'visible_on_front' => true,
            ]
        );

        return $this;
    }

    /**
     * Get the dependencies for this data patch
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get the aliases for this data patch
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
