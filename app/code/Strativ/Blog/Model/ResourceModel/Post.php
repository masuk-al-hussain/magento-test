<?php

namespace Strativ\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    const MAIN_TABLE = 'strativ_blog_post';
    const ID_FIELD_NAME = 'id';
    protected function _construct() {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
