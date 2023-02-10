<?php

namespace App\Exceptions\Traits;

use App\Exceptions\InternalServerError;
use App\Exceptions\Orders\CannotCancelOrderException;
use App\Exceptions\Orders\OrderItemsIsEmptyException;
use App\Exceptions\Orders\OrderMissingPropertyException;
use App\Exceptions\Orders\VoucherCanNotApplyStore;
use App\Exceptions\Orders\VoucherCanNotUseException;
use App\Exceptions\Orders\VoucherHasNotReachedMinimumValueException;
use App\Exceptions\Orders\VoucherIsOverusedException;
use App\Exceptions\Orders\WorkingTimeException;
use App\Exceptions\Otps\InvalidOtpException;
use App\Exceptions\Otps\OtpCanNotBeResendedException;
use App\Exceptions\Payments\MomoRequestFailException;
use App\Exceptions\Payments\HandlerMomoDataException;
use App\Exceptions\Payments\MomoSignatureException;
use App\Exceptions\Payments\OrderPaidException;
use App\Exceptions\Payments\TransactionStatusConflict;
use App\Exceptions\ProductNotExisted;
use App\Exceptions\Reviews\ReviewExistsException;
use App\Exceptions\Reviews\ReviewOrderNotCompleteException;
use App\Exceptions\Shipping\DeliveryTypeUnsupportedException;
use App\Exceptions\Shipping\MissingShippingConfigException;
use App\Exceptions\Shipping\OrderMissingShippingException;
use App\Exceptions\Shipping\OrderProcessedException;
use App\Exceptions\Shipping\ShippingCreatedException;
use App\Exceptions\Shipping\ShippingNotExistedException;
use App\Exceptions\Shipping\ShippingServiceException;
use App\Exceptions\StoreNotExisted;
use App\Exceptions\UserAccess\UserBlockException;
use App\Exceptions\UserAccess\UserUnverifiedException;
use App\Http\Responses\ResponseCode;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

trait JsonHandler
{
    /**
     * Response json unauthenticated.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseJsonUnauthenticated()
    {
        return $this->responseJsonError(
            __('app.messages.error.unauthenticated'),
            ResponseCode::UNAUTHENTICATED,
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Response not found json.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseJsonNotFound()
    {
        return $this->responseJsonError(
            __('app.messages.error.notfound'),
            ResponseCode::NOT_FOUND,
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Response json internal server error.
     *
     * @param  \App\Exceptions\InternalServerError $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseJsonInternalServerError(InternalServerError $e)
    {
        return $this->responseJsonError(
            isWeb() && $e->getMessage()
                ? $e->getMessage()
                : __('app.messages.error.internal_server'),
            ResponseCode::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Map exception to response code and message
     *
     * @param  Throwable  $e
     * @return array
     */
    private function mapExceptionResponse(Throwable $e)
    {
        $message = '';
        $code = null;
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        switch (get_class($e)) {
            case InvalidOtpException::class:
                $message = isWeb() && $e->getMessage()
                    ? $e->getMessage()
                    : __('app.otp.wrong_otp');
                $code = ResponseCode::OTP_INVALID;
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case OtpCanNotBeResendedException::class:
                $message = isWeb() && $e->getMessage()
                    ? $e->getMessage()
                    : __('app.otp.fail_to_send');
                $code = ResponseCode::OTP_CAN_NOT_BE_RESENDED;
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case OrderMissingPropertyException::class:
                $message = $e->getMessage() ?? __('app.messages.error.order_missing_property');
                $code = ResponseCode::ORDER_MISSING_PROPERTY;
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case VoucherCanNotUseException::class:
            case VoucherCanNotApplyStore::class:
            case VoucherHasNotReachedMinimumValueException::class:
            case VoucherIsOverusedException::class:
            case OrderItemsIsEmptyException::class:
            case StoreNotExisted::class:
            case ProductNotExisted::class:
            case ReviewExistsException::class:
            case ReviewOrderNotCompleteException::class:
            case CannotCancelOrderException::class:
            case ShippingServiceException::class:
            case DeliveryTypeUnsupportedException::class:
            case OrderProcessedException::class:
            case MissingShippingConfigException::class:
            case ShippingCreatedException::class:
            case OrderMissingShippingException::class:
            case ShippingNotExistedException::class:
            case OrderPaidException::class:
            case MomoRequestFailException::class:
            case MomoSignatureException::class:
            case HandlerMomoDataException::class:
            case TransactionStatusConflict::class:
            case WorkingTimeException::class:
                $message = $e->getMessage();
                $code = $e->code;
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;

            case UserUnverifiedException::class:
                $message = __('app.messages.error.user_is_unverified');
                $code = ResponseCode::CUSTOMER_UNVERIFIED;
                $status = Response::HTTP_FORBIDDEN;
                break;

            case UserBlockException::class:
                $message = __('app.messages.error.user_has_been_blocked');
                $code = ResponseCode::CUSTOMER_BLOCKED;
                $status = Response::HTTP_FORBIDDEN;
                break;

            default:
                break;
        }

        return compact('status', 'code', 'message');
    }

    /**
     * Handle json response error
     *
     * @param string $message
     * @param int $code
     * @param int $httpStatus
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseJsonError(
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
     * Response json permission error.
     *
     * @param  Spatie\Permission\Exceptions\UnauthorizedException $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseJsonPermissionError(UnauthorizedException $e)
    {
        return $this->responseJsonError(
            $e->getMessage(),
            ResponseCode::PERMISSION_DENIED,
            Response::HTTP_FORBIDDEN
        );
    }
}
