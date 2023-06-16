<?php

namespace App\Libraries;

use App\Models\Remittance\ProfileRemit;
use Illuminate\Http\JsonResponse;

class UnitellerHandler
{
    /**
     * @param array $response
     * @param string|null $property
     * @param bool $setData
     * @param string|null $alternativeMessage
     *
     * @return JsonResponse
     */
    public static function response(array $response, ?string $property = null, bool $setData = false, ?string $alternativeMessage = null): JsonResponse
    {
        UnitellerErrorCode::setErrorCode($response['responseCode']);
        $message = $response['responseMessage'] ?? 'Success';

        if (UnitellerErrorCode::isSuccess()) {
            $data = self::refactorData($response, $property, $setData);
            $message = $alternativeMessage !== null && $data === null ? $alternativeMessage : $message;
            return ResponseHandler::success($message, $data);
        }

        if (UnitellerErrorCode::isLogOut()) {
            return ResponseHandler::unauthorized(ApiErrorCode::TOKEN_NOT_FOUND, $message);
        }

        if (UnitellerErrorCode::isNotActive()) {
            return ResponseHandler::unauthorized(ApiErrorCode::REMIT_NEED_ACCOUNT_ACTIVATION, $message);
        }

        if (UnitellerErrorCode::isUic()) {
            self::saveUicStatus($response['responseCode'], $response['responseMessage']);
            return ResponseHandler::unauthorized(ApiErrorCode::REMIT_DEVICE_REGISTER, $message);
        }

        if (UnitellerErrorCode::isCustomerService()) {
            self::saveCustomerServiceStatus($response['responseCode'], $response['responseMessage']);
            return ResponseHandler::forbidden(ApiErrorCode::REMIT_ACCOUNT_BLOCKED, $message);
        }

        if (UnitellerErrorCode::isSystemFailure()) {
            cache()->flush();
            return ResponseHandler::serviceUnavailable($message);
        }

        if (UnitellerErrorCode::isInvalidSendingMethod() || UnitellerErrorCode::isInvalidDataBeneficiary() ||
            UnitellerErrorCode::isFailTransaction() || UnitellerErrorCode::isInvalidData() ||
            UnitellerErrorCode::isSystemError() || UnitellerErrorCode::isNeededChangePassword()) {
            return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, $message);
        }

        return ResponseHandler::badRequest(ApiErrorCode::REMIT_INVALID_DATA, 'The code: ' . $response['responseCode'] . ' is not applied');
    }

    /**
     * @param string $responseCode
     * @param string $responseMessage
     *
     * @return void
     */
    private static function saveUicStatus(string $responseCode, string $responseMessage): void
    {
        if (auth()->check()) {
            ProfileRemit::ByUserId(auth()->id())->update([
                'uic' => 1,
                'uic_at' => now(),
                'error_code' => $responseCode,
                'error_message' => $responseMessage,
            ]);
        }
    }

    private static function saveCustomerServiceStatus(string $responseCode, string $responseMessage): void
    {
        if (auth()->check()) {
            ProfileRemit::ByUserId(auth()->id())->update([
                'locked' => 1,
                'locked_at' => now(),
                'error_code' => $responseCode,
                'error_message' => $responseMessage,
            ]);
        }
    }

    private static function unsetUnitellerProperties(array $unitellerResponse): array
    {
        unset(
            $unitellerResponse['errorCode'],
            $unitellerResponse['responseCode'],
            $unitellerResponse['interactionId'],
            $unitellerResponse['responseMessage'],
            $unitellerResponse['requestTimestamp'],
            $unitellerResponse['responseTimestamp'],
            $unitellerResponse['executionTimestamp'],
        );

        return $unitellerResponse;
    }

    private static function refactorData(array $response, ?string $property, bool $setData)
    {
        if ($setData === false && $property === null) {
            return null;
        }

        if ($property !== null) {
            $data = $response[$property] ?? null;

            if (is_array($data) && count($data) > 0) {
                if (count(array_filter(array_keys($data), 'is_string')) === 0) {
                    $data = array_filter($data);
                }
            } else {
                $data = null;
            }
        } else {
            $data = $setData ? self::unsetUnitellerProperties($response) : null;
        }

        return $data;
    }
}
