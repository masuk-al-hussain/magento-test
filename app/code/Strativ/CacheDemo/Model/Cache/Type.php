<?php

namespace Strativ\CacheDemo\Model\Cache;

use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\App\Cache\Type\FrontendPool;

class Type extends TagScope
{
    public const string TYPE_IDENTIFIER = 'cachedemo_data';
    public const string CACHE_TAG = 'CACHEDEMO_TAG';

    /**
     * @param FrontendPool $frontendPool
     */
    public function __construct(FrontendPool $frontendPool)
    {
        parent::__construct($frontendPool->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);
    }
}
