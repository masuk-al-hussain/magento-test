<?php

namespace Strativ\CategoryBanner\Block\Category;

use Magento\Catalog\Block\Category\View;
use Magento\Catalog\Model\Category;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Helper\Category as CategoryHelper;

class Banner extends View
{
    /** @var StoreManagerInterface */
    protected StoreManagerInterface $storeManager;

    /**
     * @param Context $context
     * @param Resolver $layerResolver
     * @param Registry $registry
     * @param CategoryHelper $categoryHelper
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context               $context,
        Resolver              $layerResolver,
        Registry              $registry,
        CategoryHelper        $categoryHelper,
        StoreManagerInterface $storeManager,
        array                 $data = []
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
    }

    /**
     * Get the current category from the registry
     *
     * @return Category|null
     */
    public function getCurrentCategory(): ?Category
    {
        return $this->_coreRegistry->registry('current_category');
    }

    /**
     * Get the banner image URL for the current category
     *
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getBannerImage(): ?string
    {
        $category = $this->getCurrentCategory();
        if ($category && $category->getCategoryBannerImage()) {
            $imageValue = $category->getCategoryBannerImage();

            if (str_starts_with($imageValue, 'http')) {
                return $imageValue;
            }

            $baseUrl = $this->storeManager->getStore()->getBaseUrl();

            if (str_starts_with($imageValue, '/media/')) {
                return $baseUrl . ltrim($imageValue, '/');
            }

            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            if (str_starts_with($imageValue, 'catalog/category/')) {
                return $mediaUrl . $imageValue;
            } else {
                return $mediaUrl . 'catalog/category/' . $imageValue;
            }
        }
        return null;
    }

    /**
     * Check if the current category has a banner image
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function hasBannerImage(): bool
    {
        return $this->getBannerImage() !== null;
    }

    /**
     * Get the name of the current category
     *
     * @return string
     */
    public function getCategoryName(): string
    {
        $category = $this->getCurrentCategory();
        return $category ? $category->getName() : '';
    }
}
