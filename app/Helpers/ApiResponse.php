<?php

function successResponse($message, $data = [], $httpCode = 200)
{
    return response()->json([
        'status_code' => 1,
        'status'      => true,
        'message'     => $message,
        'data'        => $data
    ], $httpCode);
}

function errorResponse($message, $httpCode = 400)
{
    return response()->json([
        'status_code' => 0,
        'status'      => false,
        'message'     => $message
    ], $httpCode);
}