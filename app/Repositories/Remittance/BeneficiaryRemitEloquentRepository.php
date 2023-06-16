<?php

namespace App\Repositories\Remittance;

use App\Interfaces\Remittance\BeneficiaryRemitRepository;
use App\Models\Remittance\BeneficiaryRemit;

class BeneficiaryRemitEloquentRepository implements BeneficiaryRemitRepository
{
    public function __construct(
        private BeneficiaryRemit $model
    ) {
    }

    public function all(int $userId)
    {
        return $this->model->byUser($userId)->active()->get();
    }

    public function create(int $userId, array $result)
    {
        return $this->model->create([
            'profile_user_id' => $userId,
            'uniteller_beneficiary_id' => $result['beneficiarySummary']['id'],
            'first_name' => $result['beneficiarySummary']['firstName'],
            'middle_name' => $result['beneficiarySummary']['midName'],
            'first_lastname' => $result['beneficiarySummary']['lastName'],
            'second_lastname' => $result['beneficiarySummary']['secLastName'],
            'cell_phone' => $result['beneficiarySummary']['cellPhone'],
            'reception_method' => $result['beneficiarySummary']['receptionMethod'],
            'dest_country_iso_code' => $result['beneficiarySummary']['destCountryISOCode'],
            'dest_currency_iso_code' => $result['beneficiarySummary']['destCurrencyISOCode'],
            'payer_name' => $result['beneficiarySummary']['payer'],
            'country' => $result['beneficiarySummary']['address']['country'],
            'error_code' => $result['responseCode'],
            'error_message' => $result['responseMessage'],
        ]);
    }

    public function delete(int $beneficiaryId)
    {
        return $this->model->where('uniteller_beneficiary_id', $beneficiaryId)->update([
            'active' => 0,
            'deactivated_at' => now(),
        ]);
    }
}
