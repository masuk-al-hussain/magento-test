<?php

namespace Strativ\FormGrid\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Strativ\FormGrid\Model\ResourceModel\Faq\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Strativ_FormGrid::faq_delete';

    /** @var CollectionFactory */
    protected CollectionFactory $collectionFactory;

    /** @var Filter */
    protected Filter $filter;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context           $context,
        Filter            $filter,
        CollectionFactory $collectionFactory,
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Mass delete action for selected FAQ records
     *
     * @return Redirect
     */
    public function execute()
    {
        $collection = $this->collectionFactory->create();
        $items = $this->filter->getCollection($collection);
        $itemSize = $items->getSize();

        foreach ($items as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($items)));

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
