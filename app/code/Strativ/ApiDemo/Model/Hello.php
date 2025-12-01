<?php

namespace Strativ\ApiDemo\Model;

use Strativ\ApiDemo\Api\HelloInterface;

class Hello implements HelloInterface
{
    public function getHello(): string
    {
        return "Hello World!";
    }
}
