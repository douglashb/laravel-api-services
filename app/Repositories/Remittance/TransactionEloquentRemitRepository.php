<?php

namespace App\Repositories\Remittance;

use App\Interfaces\Remittance\TransactionRemitRepository;
use App\Models\Remittance\TransactionRemit;

class TransactionEloquentRemitRepository implements TransactionRemitRepository
{
    public function __construct(
        private TransactionRemit $model
    ) {
    }

    public function find(int $userId, string $unitellerId)
    {
        return $this->model->byUser($userId)->byUniteller($unitellerId)->first();
    }

    public function create(
        int $userId,
        string $sendingMethodId,
        string $beneficiaryId,
        array $result
    ) {
        return $this->model->create([
            'profile_user_id' => $userId,
            'uniteller_sending_method_id' => $sendingMethodId,
            'uniteller_beneficiary_id' => $beneficiaryId,
            'uniteller_tx_internal_reference' => $result['transactionInternalReference'],
            'send_method_name' => $result['sendingMethodName'],
            'send_method_number' => $result['sendingMethodLast4Digits'],
            'send_method_type' => $result['sendingMethodType'],
            'reception_method' => $result['receptionMethodName'],
            'send_amount' => $result['txAmount'],
            'send_currency' => $result['txCurrency'],
            'service_fee' => $result['serviceFee'],
            'exchange_rate' => $result['exchangeRate'],
            'payment_country_iso' => $result['beneficiaryAddress']['country'],
            'review_at' => now(),
        ]);
    }

    public function update(int $userId, array $request, array $result)
    {
        return $this->model->byUser($userId)
            ->byUniteller($request['transaction_internal_reference'])
            ->update([
                'uic_required' => $request['uic'] !== null,
                'uic_method' => $request['uic_receipt_mode'],
                'send_total_amount' => $result['actualTotalTxAmount'],
                'payment_amount' => $result['totalReceivableAmount'],
                'payment_currency' => $result['payCurrency'],
                'uniteller_tx_number' => $result['txNumber'],
                'available_date' => $result['availableDate'],
                'status' => $result['txDisplayStatus'],
                'confirm' => true,
                'confirm_at' => now(),
            ]);
    }
}
