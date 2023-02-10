<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handle Api response error
     *
     * @param string $message
     * @param int $code
     * @param int $httpStatus
     * @return JsonResponse
     */
    final protected function responseJsonError(
        string $message,
        int $code = ResponseCode::ERROR_CODE,
        int $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
            ],
            $httpStatus
        );
    }

    /**
     * Handle Api response success
     *
     * @param array| null $data
     * @return JsonResponse
     */
    protected function responseJsonSuccess(array $data)
    {
        return response()->json([
            'data' => $data,
            'code' => ResponseCode::SUCCESS_CODE,
            'message' => 'success',
        ]);
    }

    /**
     * Handle Api response success with no data
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    final protected function responseJsonSuccessNoData(string $message = 'Success.')
    {
        return response()->json([
            'code' => ResponseCode::SUCCESS_CODE,
            'message' => $message,
        ]);
    }
}
