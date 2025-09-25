<?php

namespace Strativ\FormGrid\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Strativ\FormGrid\Model\Faq;
use Strativ\FormGrid\Model\FaqFactory;
use Strativ\FormGrid\Model\ResourceModel\Faq as FaqResource;

class InlineEdit extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Strativ_FormGrid::faq_save';

    /** @var FaqFactory */
    protected FaqFactory $faqFactory;

    /** @var FaqResource */
    protected FaqResource $faqResource;

    /** @var JsonFactory */
    protected JsonFactory $jsonFactory;

    /**
     * Edit Inline Action
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     * @param FaqResource $faqResource
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context     $context,
        FaqFactory  $faqFactory,
        FaqResource $faqResource,
        JsonFactory $jsonFactory,
    )
    {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->faqResource = $faqResource;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Execute action to save inline edited items
     *
     * @return Json
     */
    public function execute()
    {
        $json = $this->jsonFactory->create();
        $messages = [];
        $error = false;
        $isAjax = $this->getRequest()->getParam('isAjax', false);
        $items = $this->getRequest()->getParam('items', []);

        if (!$isAjax || !count($items)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
        }

        if (!$error) {
            foreach ($items as $item) {
                try {
                    $id = $item['id'];
                    /** @var Faq $faq */
                    $faq = $this->faqFactory->create();
                    $this->faqResource->load($faq, $id);
                    $faq->addData($item);
                    $this->faqResource->save($faq);
                } catch (\Exception $e) {
                    $messages[] = "Something went wrong while saving the item $id";
                }
            }
        }

        return $json->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
