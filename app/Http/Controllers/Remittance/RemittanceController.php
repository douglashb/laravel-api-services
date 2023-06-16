<?php

namespace App\Http\Controllers\Remittance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Remittance\RemitExchangeRateGetRequest;
use App\Http\Requests\Remittance\RemitPromotionPostRequest;
use App\Http\Requests\Remittance\RemitQuotePostRequest;
use App\Http\Requests\Remittance\RemitTransactionDeleteRequest;
use App\Http\Requests\Remittance\RemitTransactionsGetRequest;
use App\Http\Requests\Remittance\SendMoneyConfirmPostRequest;
use App\Http\Requests\Remittance\SendMoneyPreviewPostRequest;
use App\Http\Resources\Remittance\RemitExchangeRateResource;
use App\Http\Resources\Remittance\RemitQuoteExternalResource;
use App\Http\Resources\Remittance\RemitQuoteResource;
use App\Interfaces\Remittance\RemitTransactionRepository;
use App\Libraries\UnitellerErrorCode;
use App\Libraries\UnitellerHandler;
use App\Services\Uniteller\Resources\RemitTransactionCancelResource;
use App\Services\Uniteller\Resources\RemitTransactionReceiptResource;
use App\Services\Uniteller\Resources\RemitTransactionsResource;
use App\Services\Uniteller\Resources\SendMoneyConfirmResource;
use App\Services\Uniteller\Resources\SendMoneyPreviewResource;
use App\Services\Uniteller\Resources\TxSmsAlertResource;
use App\Services\Uniteller\Resources\UnitellerSessionResource;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Http\JsonResponse;
use Propaganistas\LaravelPhone\PhoneNumber;

class RemittanceController extends Controller
{
    public function __construct(
        private RemitTransactionRepository $remitTransactionRepository
    ) {
    }

    public function sendMoneyPreviewCreate(SendMoneyPreviewPostRequest $request): JsonResponse
    {
        $result = app(UnitellerService::class)->remittance()->sendMoneyPreview(
            new SendMoneyPreviewResource($request->validated())
        );

        UnitellerErrorCode::setErrorCode($result['responseCode']);
        if (UnitellerErrorCode::isSuccess()) {
            $this->remitTransactionRepository->create(
                $request->user()->id,
                $request->input('sending_method_id'),
                $request->input('beneficiary_id'),
                $result
            );
        }

        return UnitellerHandler::response($result, null, true);
    }

    /**
     * @param SendMoneyConfirmPostRequest $request
     *
     * @return JsonResponse
     */
    public function sendMoneyConfirmCreate(SendMoneyConfirmPostRequest $request): JsonResponse
    {
        $result = app(UnitellerService::class)->remittance()->sendMoneyConfirm(new SendMoneyConfirmResource($request->validated()));

        UnitellerErrorCode::setErrorCode($result['responseCode']);
        if (UnitellerErrorCode::isSuccess()) {
            $unitellerTransaction = $this->remitTransactionRepository->find($request->user()->id, $request->input('transaction_internal_reference'));
            if ($unitellerTransaction !== null) {
                $day = substr($result['availableDate'], 0, 2);
                $month = substr($result['availableDate'], 2, 2);
                $year = substr($result['availableDate'], 4, 4);
                $dateFront = date('m/d/Y', strtotime($day . '/' . $month . '/' . $year));
                $dateForDB = date('Y-m-d', strtotime($day . '/' . $month . '/' . $year));
                $result['availableDate'] = $dateForDB;
                $this->remitTransactionRepository->update($request->user()->id, $request->validated(), $result);
                $result['availableDate'] = $dateFront;

                if ($result['isOptedInSMSAlert'] === 'YES') {
                    $result['beneCellPhone'] = str_replace(' ', '', PhoneNumber::make($result['beneCellPhone'], $unitellerTransaction->payment_country_iso)->formatNational());

                    dispatch(static function () use ($result) {
                        app(UnitellerService::class)->remittance()->txSmsAlert(
                            new TxSmsAlertResource($result)
                        );
                    })->afterResponse();
                }
            }
        }

        if ($result['responseCode'] === '50102010') {
            $result['responseCode'] = '00000000';
        }

        return UnitellerHandler::response($result, null, true);
    }

    /**
     *
     * @return JsonResponse
     */
    public function userComplianceLimitShow(): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->userComplianceLimit(
                new UnitellerSessionResource([])
            ),
            null,
            true
        );
    }

    /**
     * @param RemitTransactionsGetRequest $request
     *
     * @return JsonResponse
     */
    public function transactionsIndex(RemitTransactionsGetRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->transactionSummaryList(
                new RemitTransactionsResource($request->validated())
            ),
            'transactionSummary',
            true,
            __('remittance.no_trans')
        );
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function transactionsReceiptShow(string $id): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->transactionReceipt(
                new RemitTransactionReceiptResource(['id' => $id])
            ),
            null,
            true
        );
    }

    /**
     * @param string $id
     * @param RemitTransactionDeleteRequest $request
     *
     * @return JsonResponse
     */
    public function transactionDelete(string $id, RemitTransactionDeleteRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->cancelTransaction(
                new RemitTransactionCancelResource($request->validated() + ['id' => $id])
            )
        );
    }

    /**
     * @param RemitExchangeRateGetRequest $request
     *
     * @return JsonResponse
     */
    public function exchangeRateShow(RemitExchangeRateGetRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->currentExchangeRate(
                new RemitExchangeRateResource($request->validated())
            ),
            'exchangeRate'
        );
    }

    /**
     * @param RemitQuotePostRequest $request
     *
     * @return JsonResponse
     */
    public function quoteShow(RemitQuotePostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->quickQuote(
                new RemitQuoteResource($request->validated())
            ),
            null,
            true
        );
    }

    /**
     * @param RemitQuotePostRequest $request
     *
     * @return JsonResponse
     */
    public function quoteExternalShow(RemitQuotePostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->quickQuoteExternal(
                new RemitQuoteExternalResource($request->validated())
            ),
            null,
            true
        );
    }

    /**
     * @param RemitPromotionPostRequest $request
     *
     * @return JsonResponse
     */
    public function promotionCreate(RemitPromotionPostRequest $request): JsonResponse
    {
        return UnitellerHandler::response(
            app(UnitellerService::class)->remittance()->quickQuoteExternal(
                new RemitQuoteExternalResource($request->validated())
            ),
            null,
            true
        );
    }
}
