<?php
namespace Strativ\Plugin\Plugin;

use Magento\Catalog\Model\Product;

class ProductNamePlugin
{
    /**
     * AFTER plugin example
     * This runs *after* getName() is called.
     * $result is the value returned by the original method.
     */
    public function afterGetName(Product $subject, $result): string
    {
        return '[ ' . $result . ' ]';
    }
}
