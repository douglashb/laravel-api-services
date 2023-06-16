<?php

namespace App\Libraries;

use Illuminate\Http\JsonResponse;

class ResponseHandler
{
    public function jsonResponse(string $message, null|array|object $data = null, int $status = 200, int $code = 0): JsonResponse
    {
        return response()->json([
            'success' => $status >= 200 && $status <= 299,
            'code' => $code,
            'locale' => app()->getLocale(),
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * @param string $message
     * @param array|object|null $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function success(string $message, null|array|object $data = null, int $code = 0): JsonResponse
    {
        return app(self::class)->jsonResponse($message, $data, 200, $code);
    }

    /**
     * @param object|array $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function created(object|array $data, string $message = 'Created'): JsonResponse
    {
        return app(self::class)->jsonResponse($message, $data, 201, 0);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function noContent(string $message): JsonResponse
    {
        return app(self::class)->jsonResponse($message, null, 204, 0);
    }

    /**
     * @param int $code
     * @param string $message
     * @param null $data
     *
     * @return JsonResponse
     */
    public static function unauthorized(int $code = 0, string $message = 'Unauthorized', $data = null): JsonResponse
    {
        return app(self::class)->jsonResponse($message, $data, 401, $code);
    }

    /**
     * @param int $code
     * @param string $message
     * @param null $data
     *
     * @return JsonResponse
     */
    public static function forbidden(int $code, string $message = 'Forbidden', $data = null): JsonResponse
    {
        return app(self::class)->jsonResponse($message, $data, 403, $code);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function internalError(string $message = 'Internal Error'): JsonResponse
    {
        return app(self::class)->jsonResponse($message, null, 500, 50);
    }

    /**
     * @param int $code
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function conflict(int $code, string $message): JsonResponse
    {
        return app(self::class)->jsonResponse($message, null, 409, $code);
    }

    /**
     * @param int $code
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function badRequest(int $code, string $message): JsonResponse
    {
        return app(self::class)->jsonResponse($message, null, 400, $code);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function serviceUnavailable(string $message): JsonResponse
    {
        return app(self::class)->jsonResponse($message, null, 503, 53);
    }
}
