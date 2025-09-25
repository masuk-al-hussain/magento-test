<?php

namespace Strativ\FormGrid\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Strativ\FormGrid\Model\ResourceModel\Faq\Collection;
use Strativ\FormGrid\Model\ResourceModel\Faq\CollectionFactory;

class Faq extends AbstractDataProvider
{
    /** @var Collection $collection */
    protected $collection;

    /** @var array $loadedData */
    private array $loadedData;

    /**
     * Faq Data Provider Constructor
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $this->loadedData = [];

        foreach ($this->collection->getItems() as $item) {
            $this->loadedData[$item->getData('id')] = $item->getData();
        }

        return $this->loadedData;
    }
}
