<?php

namespace Strativ\Blog\Controller\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;

class ListAction implements HttpGetActionInterface {
    private $resultFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultFactory
    )
    {
        $this->resultFactory = $resultFactory;
    }

    public function execute(): Page
    {
        return $this->resultFactory->create();
    }
}
