<?php

namespace App\Helpers;


class ResponseFormatter {
    private static  $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null
        ],
        'data' => null
    ];

    public static function success($data, $message) {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function error($data = null, $code = 400, $status = 'failed', $message = null) {
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = $status;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
