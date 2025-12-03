<?php

namespace Strativ\ExtAttr\Plugin;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductRepositoryPlugin
{
    /**
     * @var ProductExtensionFactory
     */
    private ProductExtensionFactory $extensionFactory;

    /**
     * Constructor
     *
     * @param ProductExtensionFactory $extensionFactory
     */
    public function __construct(
        ProductExtensionFactory $extensionFactory
    )
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     *  After plugin for get method to add a custom extension attribute
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface           $product
    )
    {
        $extAttrs = $product->getExtensionAttributes();

        if (!$extAttrs) {
            $extAttrs = $this->extensionFactory->create();
        }

        // Add custom field value
        $extAttrs->setCustomNote("This is a custom note");

        $product->setExtensionAttributes($extAttrs);

        return $product;
    }
}
