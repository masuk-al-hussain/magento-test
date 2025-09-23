<?php

namespace Strativ\BlogExtra\Plugin;

use Magento\Framework\App\RequestInterface;
use Strativ\Blog\Controller\Post\Detail;

class AlternatePostDetailTemplate
{
    public function __construct(
        private RequestInterface $request,
    )
    {
    }

    public function afterExecute(Detail $subject, $result)
    {


        if($this->request->getParam('alternate')) {
            $result->getLayout()
                ->getBlock('blog.post.detail')
                ->setTemplate('Strativ_BlogExtra::post/detail.phtml');
        }

        return $result;
    }
}
