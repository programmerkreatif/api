<?php


namespace App\Http\Controllers\API;

use App\Enums\HttpStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, HttpStatus::HTTP_OK);
    }


    /**
     * return error response.
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($error, $errorMessages = [], $code = HttpStatus::HTTP_BAD_REQUEST)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}