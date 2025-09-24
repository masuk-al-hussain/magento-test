<?php declare(strict_types=1);

namespace Strativ\FormGrid\Model\ResourceModel\Faq;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Strativ\FormGrid\Model\Faq;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Faq::class, \Strativ\FormGrid\Model\ResourceModel\Faq::class);
    }
}
