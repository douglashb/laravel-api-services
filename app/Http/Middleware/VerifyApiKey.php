<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseHandler;
use App\Services\Supplier\SupplierService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelXssProtection\Middleware\XssCleanInput;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [];

        /*
        * Search the header with the API KEY.
        */
        foreach ($request->header() as $key => $value) {
            if (Str::contains($key, 'pvm') !== false) {
                $headers['x-api-value'] = $value[0]; // Save API KEY in var $header
                $headers['x-api-key'] = $key; // Save API KEY in var $header
                break;
            }
        }

        /*
        * If API KEY header isn't come in request, reject request.
        */
        if (count($headers) === 0) {
            return ResponseHandler::unauthorized();
        }

        /*
        * Do request to API PROVIDER to get information of this API and
         * save in cache 60 minutes.
        */
        $result = Cache::remember($headers['x-api-key'], '3600', static function () use ($headers) {
            $supplierService = app(SupplierService::class);
            $supplierService->setHeaders($headers);

            $tmpResult = $supplierService->getMerchantByApiKey();

            if ($tmpResult['code'] === 0) {
                $sortService = [];
                foreach ($tmpResult['data']['services'] as $key => $value) {
                    if ($value['alias'] === 'uniteller') {
                        $value['reception_mode'] = $tmpResult['data']['notification_mode'] === 'email' ? 'Email' : 'Mobile';
                    }
                    $sortService[$value['alias']] = $value;
                }

                $tmpResult['data']['services'] = $sortService;

                return $tmpResult['data'];
            }

            return false;
        });

        if ($result === false) {
            cache()->forget($headers['x-api-key']);
            return ResponseHandler::serviceUnavailable(__('api.service_down_title'));
        }

        session(['merchant' => $headers['x-api-key']]);
        session(['merchant_notify_mode' => $result['notification_mode']]);

        /*
         *  Set on the fly CONFIGURATIONS ON API.
         */
        $databaseMerchantConfig = array_merge(['driver' => $result['database']['type']['name']], Arr::except($result['database'], ['type']));
        config()->set('database.connections.' . $result['database']['type']['name'], $databaseMerchantConfig);
        config()->set('app.timezone', $result['timezone']);
        config()->set('app.key', $result['encrypt_decrypt_key']);
        config(['auth.defaults.guard' => 'api']); // Set guard api here because default guard jwt get conflicts with change database on the fly

        return $next($request);
    }
}
