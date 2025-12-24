<?php

namespace Strativ\CategoryBanner\Block\Category;

use Magento\Catalog\Block\Category\View;
use Magento\Catalog\Model\Category;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Helper\Category as CategoryHelper;

class Banner extends View
{
    protected $storeManager;

    public function __construct(
        Context $context,
        Resolver $layerResolver,
        Registry $registry,
        CategoryHelper $categoryHelper,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
    }

    public function getCurrentCategory()
    {
        return $this->_coreRegistry->registry('current_category');
    }

    public function getBannerImage()
    {
        $category = $this->getCurrentCategory();
        if ($category && $category->getCategoryBannerImage()) {
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            return $mediaUrl . 'catalog/category/' . $category->getCategoryBannerImage();
        }
        return null;
    }

    public function hasBannerImage()
    {
        return $this->getBannerImage() !== null;
    }

    public function getCategoryName()
    {
        $category = $this->getCurrentCategory();
        return $category ? $category->getName() : '';
    }
}
