<?php

namespace Strativ\BlogExtra\Plugin;

use Magento\Framework\Event\Observer;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Strativ\Blog\Observer\LogPostDetailView;

class AddDataToPostDetailObserver
{
    public function __construct(
        private TimezoneInterface $timezone,
    )
    {}
    public function beforeExecute(
        LogPostDetailView $subject,
        Observer $observer,
    ) {
        $request = $observer->getData('request');
        $request->setParams(['datetime', $this->timezone->date()]);

        return [$observer];
    }
}
