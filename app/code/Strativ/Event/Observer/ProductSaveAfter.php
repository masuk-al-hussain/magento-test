<?php
declare(strict_types=1);

namespace Strativ\Event\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class ProductSaveAfter implements ObserverInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function execute(Observer $observer): void
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();

        // Current values
        $newPrice = (float)$product->getPrice();
        $sku      = $product->getSku();

        // Get old price stored in original data
        $origPrice = (float)$product->getOrigData('price');

        // Compare old and new
        $priceDiff = $newPrice - $origPrice;

        $this->logger->info('Product saved', [
            'sku'        => $sku,
            'old_price'  => $origPrice,
            'new_price'  => $newPrice,
            'diff'       => $priceDiff,
            'has_changed' => $origPrice !== $newPrice,
        ]);
    }
}
