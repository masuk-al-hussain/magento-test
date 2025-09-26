<?php

namespace Strativ\FormGrid\Block\Adminhtml\Faq\Edit\Button;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back implements ButtonProviderInterface
{
    /** @var UrlInterface $urlBuilder */
    private UrlInterface $urlBuilder;

    /**
     * Back button constructor
     *
     * @param UrlInterface $url
     */
    public function __construct(
        UrlInterface $url,
    )
    {
        $this->urlBuilder = $url;
    }

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->urlBuilder->getUrl('*/*/');

        return [
            'label' => __('Back'),
            'class' => 'back',
            'on_click' => sprintf("location.href = '%s';", $url),
        ];
    }
}
