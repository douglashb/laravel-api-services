<?php

namespace App\Http\Controllers\Remittance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Remittance\CreateBeneficiaryPostRequest;
use App\Http\Requests\Remittance\CreateSendingMethodCardPostRequest;
use App\Http\Requests\Remittance\PlaidPostRequest;
use App\Interfaces\Remittance\BeneficiaryRemitRepository;
use App\Libraries\UnitellerErrorCode;
use App\Libraries\UnitellerHandler;
use App\Services\Uniteller\Resources\AddBeneficiaryResource;
use App\Services\Uniteller\Resources\BankAccountPlaidResource;
use App\Services\Uniteller\Resources\BankAccountPlaidTokenResource;
use App\Services\Uniteller\Resources\BeneficiaryIndexResource;
use App\Services\Uniteller\Resources\BeneficiaryResource;
use App\Services\Uniteller\Resources\SendingMethodCreateResource;
use App\Services\Uniteller\Resources\SendingMethodIndexResource;
use App\Services\Uniteller\Resources\SendingMethodResource;
use App\Services\Uniteller\Resources\UnitellerSessionResource;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonMapper;

class ProfileManagementController extends Controller
{
    public function __construct(
        private BeneficiaryRemitRepository $beneficiaryRepository,
        private JsonMapper                 $mapper
    ) {
        $this->mapper = new JsonMapper();
        $this->mapper->bEnforceMapType = false;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function profileShow(Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->userProfileInfo(
                new UnitellerSessionResource([])
            ),
            null,
            true
        );
    }

    /**
     * Get All Beneficiaries
     *
     * #[Route("v1/api/beneficiaries", methods: ["GET"])]
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function beneficiaryIndex(Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->beneficiarySummaryList(
                new BeneficiaryIndexResource([])
            ),
            'beneficiarySummaryList',
            false,
            __('remittance.no_beneficiaries')
        );
    }

    /**
     * @param CreateBeneficiaryPostRequest $request
     *
     * @return JsonResponse
     *
     * @throws \JsonMapper_Exception
     */
    public function beneficiaryCreate(CreateBeneficiaryPostRequest $request): JsonResponse
    {
        $result = app(UnitellerService::class)->profile()->addBeneficiary(
            new AddBeneficiaryResource($request->validated())
        );

        UnitellerErrorCode::setErrorCode($result['responseCode']);
        if (UnitellerErrorCode::isSuccess()) {
            $this->beneficiaryRepository->create($request->user()->id, $result);
        }

        return UnitellerHandler::response($result, 'beneficiarySummary');
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function beneficiaryShow($id, Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->beneficiaryDetail(
                new BeneficiaryResource(['beneficiary_id' => $id])
            ),
            'beneficiarySummary'
        );
    }

    /**
     * Deactivate Beneficiary
     *
     * #[Route("v1/api/beneficiaries/{id}", methods: ["DELETE"])]
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function beneficiaryDelete($id, Request $request): JsonResponse
    {
        $result = app(UnitellerService::class)->profile()->deactivateBeneficiary(
            new BeneficiaryResource(['beneficiary_id' => $id])
        );

        UnitellerErrorCode::setErrorCode($result['responseCode']);
        if (UnitellerErrorCode::isSuccess()) {
            $this->beneficiaryRepository->delete($id);
        }

        return UnitellerHandler::response($result);
    }

    /**
     * Get All Sending Methods
     *
     * #[Route("v1/api/sending-methods", methods: ["GET"])]
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function sendingMethodIndex(Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->sendingMethodSummaryList(
                new SendingMethodIndexResource([])
            ),
            'sendingMethodSummary',
            false,
            __('remittance.no_sending_methods')
        );
    }

    /**
     * @param CreateSendingMethodCardPostRequest $request
     *
     * @return JsonResponse
     */
    public function sendingMethodCardCreate(CreateSendingMethodCardPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->addSendingMethod(
                new SendingMethodCreateResource($request->validated() + [
                    'country' => $request->user()->country->name,
                    'countryISOCode' => $request->user()->country->iso_code,
                ])
            )
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function sendingMethodShow($id, Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->sendingMethodDetail(
                new SendingMethodResource(['sending_method_id' => $id, 'sending_method_name' => $request->input('sending_method_name')])
            ),
            'sendingMethodSummary'
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function SendingMethodDelete($id, Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->deactivateSendingMethod(
                new SendingMethodResource($request->merge(['sending_method_id' => $id, 'sending_method_name' => $request->input('sending_method_name')]))
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function bankAccountPlaidTokenShow(Request $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->generatePlaidToken(
                new BankAccountPlaidTokenResource($request->only('sendingMethodId'))
            ),
            null,
            true
        );
    }

    /**
     * @param PlaidPostRequest $request
     *
     * @return JsonResponse
     */
    public function bankAccountPlaidCreate(PlaidPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->profile()->sendPlaidLinkDetails(
                new BankAccountPlaidResource($request->validated())
            )
        );
    }
}
