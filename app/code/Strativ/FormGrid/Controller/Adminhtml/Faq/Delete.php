<?php

namespace Strativ\FormGrid\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Strativ\FormGrid\Model\FaqFactory;
use Strativ\FormGrid\Model\ResourceModel\Faq as FaqResource;

class Delete extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Strativ_FormGrid::faq_delete';

    /** @var FaqFactory */
    private FaqFactory $faqFactory;

    /** @var FaqResource */
    private FaqResource $faqResource;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     * @param FaqResource $faqResource
     */
    public function __construct(
        Context     $context,
        FaqFactory  $faqFactory,
        FaqResource $faqResource,
    ) {
        $this->faqFactory = $faqFactory;
        $this->faqResource = $faqResource;
        parent::__construct($context);
    }

    /**
     * Delete action
     */
    public function execute()
    {
        try {
            $id = $this->getRequest()->getParam('id');
            $faq = $this->faqFactory->create();
            $this->faqResource->load($faq, $id);
            if ($faq->getId()) {
                $this->faqResource->delete($faq);
                $this->messageManager->addSuccessMessage(__('The FAQ has been deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('The FAQ no longer exists.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
