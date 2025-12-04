<?php

namespace Strativ\CacheDemo\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\CacheInterface;
use Strativ\CacheDemo\Model\Cache\Type as DemoCache;

class Example extends Template
{
    private const string CACHE_KEY = 'cache_demo_example';

    /**
     * @var CacheInterface
     */
    protected CacheInterface $cache;

    /**
     * @param Template\Context $context
     * @param CacheInterface $cache
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CacheInterface   $cache,
        array            $data = []
    )
    {
        $this->cache = $cache;
        parent::__construct($context, $data);
    }

    /**
     * Get cached data or generate new data:
     * - bin/magento cache:flush clears all the cache so the output will be (NEW GENERATED: + current time)
     * and on refresh the page the output will be (NEW GENERATED: + cached value)
     * - bin/magento cache:clean doesn't clear custom cache but clears full page cache so the output will be
     * (FROM CACHE: + cached value) and on refresh the output will be (FROM CACHE: + cached value)
     *
     * Note: After the lifespan of the custom cache bin/magento cache:clean can clear the cache
     * and the output will be (NEW GENERATED: + current time)
     *
     * @return string
     */
    public function getCachedData(): string
    {
        $cached = $this->cache->load(self::CACHE_KEY);

        if ($cached) {
            return "FROM CACHE: " . $cached;
        }

        // Simulate dynamic data
        $value = "Generated at " . date('H:i:s');

        // Save to cache (with tag)
        $this->cache->save(
            $value,
            self::CACHE_KEY,
            [DemoCache::CACHE_TAG],
            3600 // 1 hour
        );

        return "NEW GENERATED: " . $value;
    }
}
