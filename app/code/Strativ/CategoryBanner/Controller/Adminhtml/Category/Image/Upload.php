<?php

namespace Strativ\CategoryBanner\Controller\Adminhtml\Category\Image;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Upload extends Action implements HttpPostActionInterface
{
    /** @var ImageUploader */
    protected ImageUploader $imageUploader;

    /**
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context       $context,
        ImageUploader $imageUploader
    )
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Execute the image upload action
     *
     * @return Json
     */
    public function execute(): Json
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('category_banner_image');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * Check if the user has permission to access this action
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Strativ_CategoryBanner::category_banner');
    }
}
