<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Libraries\ResponseHandler;
use App\Services\Country\CountryService;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param string $countryIso
     * @return JsonResponse
     */
    public function stateIndex(string $countryIso): JsonResponse
    {
        return ResponseHandler::success(
            'success',
            app(CountryService::class)->getStates($countryIso)
        );
    }

    /**
     * @param string $countryIso
     * @param string $stateIso
     * @return JsonResponse
     */
    public function cityIndex(string $countryIso, string $stateIso): JsonResponse
    {
        return ResponseHandler::success(
            'success',
            app(CountryService::class)->getCityes($countryIso, $stateIso)
        );
    }
}
