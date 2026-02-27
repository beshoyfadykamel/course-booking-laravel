<?php

namespace App\Traits\Api;

trait ApiResponse
{
    protected function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
        ], $code);
    }

    protected function error($message = null, $errors = null, $code = 400)
    {
        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => null,
            'errors'  => $errors,
        ], $code);
    }
}
