<?php
namespace Strativ\ApiDemo\Model;

use Strativ\ApiDemo\Api\SaveInterface;

class Save implements SaveInterface
{
    /**
     * Return a sample response
     *
     * @param $data
     * @return array
     */
    public function saveData($data)
    {
        return [
            "success" => true,
            "received_data" => $data
        ];
    }
}
