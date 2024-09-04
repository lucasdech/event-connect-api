<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function jsonResponse(string $status, string $message, array $data = [], int $statusCode = 200){
        return response()->json(['message' => $message, 'data'=> $data, 'status'=>$status], $statusCode);
    }
}
