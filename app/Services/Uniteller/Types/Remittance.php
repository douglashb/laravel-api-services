<?php

namespace App\Services\Uniteller\Types;

use App\Http\Resources\Remittance\RemitExchangeRateResource;
use App\Http\Resources\Remittance\RemitQuoteExternalResource;
use App\Http\Resources\Remittance\RemitQuoteResource;
use App\Services\Uniteller\Classes\ApplyPromotion;
use App\Services\Uniteller\Resources\RemitTransactionCancelResource;
use App\Services\Uniteller\Resources\RemitTransactionReceiptResource;
use App\Services\Uniteller\Resources\RemitTransactionsResource;
use App\Services\Uniteller\Resources\SendMoneyConfirmResource;
use App\Services\Uniteller\Resources\SendMoneyPreviewResource;
use App\Services\Uniteller\Resources\TxSmsAlertResource;
use App\Services\Uniteller\Resources\UnitellerSessionResource;
use App\Services\Uniteller\UnitellerService;

class Remittance
{
    public function __construct(
        private UnitellerService $service
    ) {
    }

    /**
     * Send Money Preview
     *
     * #[Route("Remittance/SendMoneyPreview", methods: ["POST"])]
     *
     * @param SendMoneyPreviewResource $sendMoneyPreview
     *
     * @return array
     */
    public function sendMoneyPreview(SendMoneyPreviewResource $sendMoneyPreview): array
    {
        return $this->service->post('/Remittance/SendMoneyPreview', $sendMoneyPreview->jsonSerialize());
    }

    /**
     * Send Money Confirm
     *
     * #[Route("Remittance/SendMoneyConfirm", methods: ["POST"])]
     *
     * @param SendMoneyConfirmResource $sendMoneyConfirm
     *
     * @return array
     */
    public function sendMoneyConfirm(SendMoneyConfirmResource $sendMoneyConfirm): array
    {
        return $this->service->post('/Remittance/SendMoneyConfirm', $sendMoneyConfirm->jsonSerialize());
    }

    /**
     * Send SMS
     *
     * #[Route("Remittance/TxSMSAlert", methods: ["POST"])]
     *
     * @param TxSmsAlertResource $txSMSAlert
     *
     * @return array
     */
    public function txSmsAlert(TxSmsAlertResource $txSMSAlert): array
    {
        return $this->service->post('/Remittance/TxSMSAlert', $txSMSAlert->jsonSerialize());
    }

    /**
     * User Compliance Limit
     *
     * #[Route("Remittance/UserComplianceLimit", methods: ["POST"])]
     *
     * @param UnitellerSessionResource $unitellerWithSession
     *
     * @return array
     */
    public function userComplianceLimit(UnitellerSessionResource $unitellerWithSession): array
    {
        return $this->service->post('/Remittance/UserComplianceLimit', $unitellerWithSession->jsonSerialize());
    }

    /**
     * Transaction Summary List
     *
     * #[Route("Remittance/TransactionSummaryList", methods: ["POST"])]
     *
     * @param RemitTransactionsResource $TransactionSummaryList
     *
     * @return array
     */
    public function transactionSummaryList(RemitTransactionsResource $TransactionSummaryList): array
    {
        return $this->service->post('/Remittance/TransactionSummaryList', $TransactionSummaryList->jsonSerialize());
    }

    /**
     * Transaction Receipt
     *
     * #[Route("Remittance/TransactionReceipt", methods: ["POST"])]
     *
     * @param RemitTransactionReceiptResource $TransactionSummaryList
     *
     * @return array
     */
    public function transactionReceipt(RemitTransactionReceiptResource $TransactionSummaryList): array
    {
        return $this->service->post('/Remittance/TransactionReceipt', $TransactionSummaryList->jsonSerialize());
    }

    /**
     * Cancel Transaction
     *
     * #[Route("Remittance/CancelTransaction", methods: ["POST"])]
     *
     * @param RemitTransactionCancelResource $cancelTransaction
     *
     * @return array
     */
    public function cancelTransaction(RemitTransactionCancelResource $cancelTransaction): array
    {
        return $this->service->post('/Remittance/CancelTransaction', $cancelTransaction->jsonSerialize());
    }

    /**
     * Current Exchange Rate
     *
     * #[Route("Remittance/CurrentExchangeRate", methods: ["POST"])]
     *
     * @param RemitExchangeRateResource $currentExchangeRate
     *
     * @return array
     */
    public function currentExchangeRate(RemitExchangeRateResource $currentExchangeRate): array
    {
        return $this->service->post('/Remittance/CurrentExchangeRate', $currentExchangeRate->jsonSerialize());
    }

    /**
     * Quick Quote
     *
     * #[Route("Remittance/QuickQuote", methods: ["POST"])]
     *
     * @param RemitQuoteResource $quickQuote
     *
     * @return array
     */
    public function quickQuote(RemitQuoteResource $quickQuote): array
    {
        return $this->service->post('/Remittance/QuickQuote', $quickQuote->jsonSerialize());
    }

    /**
     * Quick Quote External
     *
     * #[Route("Remittance/QuickQuoteExternal", methods: ["POST"])]
     *
     * @param RemitQuoteExternalResource $quickQuoteExternal
     *
     * @return array
     */
    public function quickQuoteExternal(RemitQuoteExternalResource $quickQuoteExternal): array
    {
        return $this->service->post('/Remittance/QuickQuoteExternal', $quickQuoteExternal->jsonSerialize());
    }

    /**
     * Apply Promotion
     *
     * #[Route("Remittance/v2/ApplyPromotion", methods: ["POST"])]
     *
     * @param ApplyPromotion $applyPromotion
     *
     * @return array
     */
    public function applyPromotion(ApplyPromotion $applyPromotion): array
    {
        return $this->service->post('/Remittance/v2/ApplyPromotion', $applyPromotion);
    }
}
