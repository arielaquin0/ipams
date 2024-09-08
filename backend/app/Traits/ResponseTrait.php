<?php

namespace App\Traits;

trait ResponseTrait
{
    protected function json(int $code = 200, string $message = 'ok', $data = array()): array
    {
        return [
            'code' => $code,
            'msg'  => $message,
            'data' => $data,
        ];
    }
}
