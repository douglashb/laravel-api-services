<?php

namespace App\Http\Controllers\Remittance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Remittance\PayerAdditionalFieldPostRequest;
use App\Http\Requests\Remittance\PayerBranchesPostRequest;
use App\Http\Requests\Remittance\PayerWithReceptionMethodsPostRequest;
use App\Libraries\ApiErrorCode;
use App\Libraries\ResponseHandler;
use App\Libraries\UnitellerHandler;
use App\Services\Uniteller\Classes\Base;
use App\Services\Uniteller\Classes\CountryStates;
use App\Services\Uniteller\Classes\StateDisclaimer;
use App\Services\Uniteller\Resources\PayerAdditionalFieldResource;
use App\Services\Uniteller\Resources\PayerBranchesResource;
use App\Services\Uniteller\Resources\PayerReceptionMethodResource;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use JsonMapper;

class CommonController extends Controller
{
    private JsonMapper $mapper;

    public function __construct()
    {
        $this->mapper = new JsonMapper();
        $this->mapper->bEnforceMapType = false;
    }

    /**
     * @return JsonResponse
     */
    public function licensedStates(): JsonResponse
    {
        $result = Cache::remember('licensed_states', '3600', static function () {
            $base = new Base();
            $base->setLocale(app()->getLocale());

            return app(UnitellerService::class)->common()->licensedStates($base);
        });

        return UnitellerHandler::response($result, 'licensedState');
    }

    /**
     * @return JsonResponse
     */
    public function destCountriesWithCurrencies(): JsonResponse
    {
        $result = Cache::remember('dest_countries_currency', '3600', static function () {
            $base = new Base();
            $base->setLocale(app()->getLocale());

            return app(UnitellerService::class)->common()->destCountryWithCurrency($base);
        });

        if (isset($result['destCountryWithCurrency']) && count($result['destCountryWithCurrency']) > 0) {
            foreach ($result['destCountryWithCurrency'] as $key => $value) {
                $c = country($value['destinationCountry']['isoCode']);
                $result['destCountryWithCurrency'][$key]['destinationCountry']['isoCallingCode'] = $c->getCallingCode();
            }
        }

        return UnitellerHandler::response($result, 'destCountryWithCurrency');
    }

    /**
     * @return JsonResponse
     */
    public function destCountries(): JsonResponse
    {
        $result = Cache::remember('dest_countries', '3600', static function () {
            $base = new Base();
            $base->setLocale(app()->getLocale());

            return app(UnitellerService::class)->common()->destCountries($base);
        });

        return UnitellerHandler::response($result, 'destinationCountriesList');
    }

    /**
     * @return JsonResponse
     */
    public function receptionMethodsName(): JsonResponse
    {
        $result = Cache::remember('reception_methods_name', '3600', static function () {
            $base = new Base();
            $base->setLocale(app()->getLocale());

            return app(UnitellerService::class)->common()->receptionMethodsNameList($base);
        });

        return UnitellerHandler::response($result, 'receptionMethod');
    }

    /**
     * @param PayerWithReceptionMethodsPostRequest $request
     *
     * @return JsonResponse
     */
    public function payerWithReceptionMethods(PayerWithReceptionMethodsPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->common()->payerWithReceptionMethodList(
                new PayerReceptionMethodResource($request->validated())
            ),
            'payerWithReceptionMethods'
        );
    }

    /**
     * @param string $countryIso
     *
     * @return JsonResponse
     */
    public function countryStates(string $countryIso): JsonResponse
    {
        $country_states = new CountryStates();
        $country_states->setCountryIsoCode($countryIso);

        return UnitellerHandler::response(
            app(UnitellerService::class)->common()->countryStates($country_states),
            'state'
        );
    }

    /**
     * @param PayerAdditionalFieldPostRequest $request
     *
     * @return JsonResponse
     */
    public function payerAdditionalField(PayerAdditionalFieldPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->common()->payerAdditionalField(new PayerAdditionalFieldResource($request->validated())),
            'additionalFieldInfo'
        );
    }

    /**
     * @return JsonResponse
     */
    public function payerBranches(PayerBranchesPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->common()->payerBranches(new PayerBranchesResource($request->validated())),
            'payerBranches'
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function stateDisclaimer(Request $request): JsonResponse
    {
        $stateDisclaimer = new StateDisclaimer();
        $stateDisclaimer->setStateIsoCode($request->user()->province_state_iso);

        $result = app(UnitellerService::class)->common()->stateDisclaimer($stateDisclaimer);

        foreach ($result['page'] as $key => $value) {
            if ($key === $request->user()->province_state_iso) {
                return ResponseHandler::success($result['responseMessage'], $value, ApiErrorCode::REMIT_SHOW_STATE_DISCLAIMER);
            }
        }

        return ResponseHandler::success($result['responseMessage']);
    }
}
