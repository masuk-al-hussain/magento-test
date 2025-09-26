<?php

namespace Strativ\FormGrid\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Strativ\FormGrid\Model\Faq;
use Strativ\FormGrid\Model\FaqFactory;
use Strativ\FormGrid\Model\ResourceModel\Faq as FaqResource;

class Save extends Action implements HttpPostActionInterface
{
    /** @var string */
    public const ADMIN_RESOURCE = 'Strativ_FormGrid::faq_save';

    /** @var FaqFactory */
    private FaqFactory $faqFactory;

    /** @var FaqResource */
    private FaqResource $faqResource;

    /**
     * FAQ Form Save constructor
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     * @param FaqResource $faqResource
     */
    public function __construct(
        Context     $context,
        FaqFactory  $faqFactory,
        FaqResource $faqResource,
    )
    {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->faqResource = $faqResource;
    }

    /**
     *
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $post = $this->getRequest()->getPost();

        $isExistingPost = $post->id;

        /** @var Faq $faq */
        $faq = $this->faqFactory->create();

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if ($isExistingPost) {
            try {
                $this->faqResource->load($faq, $post->id);

                if (!$faq->getData('id')) {
                    throw new NotFoundException(__('This Record no longer exists.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $redirect->setPath('*/*/');
            }

        } else {
            unset($post->id);
        }

        $faq->setData(array_merge($faq->getData(), $post->toArray()));

        try {
            $this->faqResource->save($faq);
            $this->messageManager->addSuccessMessage(__('The record has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage('There was a problem saving the record.');
        }

        return $redirect->setPath('*/*/');
    }
}
