<?php

namespace App\Http\Controllers;

abstract class Controller
{

    /**
     * @OA\Info(
     *     title="API Documentation",
     *     version="1.0.0",
     *     description="Documentation for the API",
     *     @OA\Contact(
     *         email="lucasdechavanne22@gmail.com"
     *     ),
     *     @OA\License(
     *         name="MIT",
     *         url="http://opensource.org/licenses/MIT"
     *     )
     * )
     */
    public function jsonResponse(string $status, string $message, array $data = [], int $statusCode = 200)
    {
        return response()->json(['message' => $message, 'data' => $data, 'status' => $status], $statusCode);
    }
}
