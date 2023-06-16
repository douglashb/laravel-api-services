<?php

namespace App\Services\Uniteller\Types;

use App\Services\Uniteller\Classes\Base;
use App\Services\Uniteller\Classes\CountryStates;
use App\Services\Uniteller\Resources\PayerAdditionalFieldResource;
use App\Services\Uniteller\Resources\PayerBranchesResource;
use App\Services\Uniteller\Resources\PayerReceptionMethodResource;
use App\Services\Uniteller\UnitellerService;

class Common
{
    public function __construct(
        private UnitellerService $service
    ) {
    }

    /**
     * Licensed States
     *
     * #[Route("Common/LicensedStates", methods: ["POST"])]
     *
     * @Route("/Common/LicensedStates", methods={"POST"})
     *
     * @param Base $licensedStates
     *
     * @return array
     */
    public function licensedStates(Base $licensedStates): array
    {
        return $this->service->post('/Common/LicensedStates', $licensedStates);
    }

    /**
     * Destination Countries With Currency
     *
     * #[Route("Common/DestCountryWithCurrency", methods: ["POST"])]
     *
     * @Route("/Common/DestCountryWithCurrency", methods={"POST"})
     *
     * @param Base $uniteller
     *
     * @return array
     */
    public function destCountryWithCurrency(Base $uniteller): array
    {
        return $this->service->post('/Common/DestCountryWithCurrency', $uniteller);
    }

    /**
     * Destination Currencies
     *
     * #[Route("Common/DestCountries", methods: ["POST"])]
     *
     * @Route("/Common/DestCountries", methods={"POST"})
     *
     * @param Base $destCountries
     *
     * @return array
     */
    public function destCountries(Base $destCountries): array
    {
        return $this->service->post('/Common/DestCountries', $destCountries);
    }
    /**
     * Reception Methods Name List
     *
     * This method provides list of reception method available. like:Account Credit , Cash PickUp.
     *
     * #[Route("Common/ReceptionMethodsNameList", methods: ["POST"])]
     *
     * @Route("/Common/ReceptionMethodsNameList", methods={"POST"})
     *
     * @param Base $receptionMethodsNameList
     *
     * @return array
     */
    public function receptionMethodsNameList(Base $receptionMethodsNameList): array
    {
        return $this->service->post('/Common/ReceptionMethodsNameList', $receptionMethodsNameList);
    }

    /**
     * Payer With Reception Method List
     *
     * #[Route("Common/v2/PayerWithReceptionMethodsList", methods: ["POST"])]
     *
     * @param PayerReceptionMethodResource $payerWithReceptionMethodsList
     *
     * @return array
     */
    public function payerWithReceptionMethodList(PayerReceptionMethodResource $payerWithReceptionMethodsList): array
    {
        return $this->service->post('/Common/v2/PayerWithReceptionMethodsList', $payerWithReceptionMethodsList->jsonSerialize());
    }

    /**
     * Country States
     *
     * #[Route("Common/CountryStates", methods: ["POST"])]
     *
     * @Route("/Common/CountryStates", methods={"POST"})
     *
     * @param CountryStates $countryStates
     *
     * @return array
     */
    public function countryStates(CountryStates $countryStates): array
    {
        return $this->service->post('/Common/CountryStates', $countryStates);
    }

    /**
     * Payer Additional Field
     *
     * payer additional fields with their options value.
     *
     * #[Route("Common/PayerAdditionalField", methods: ["POST"])]
     *
     * @Route("/Common/PayerAdditionalField", methods={"POST"})
     *
     * @param PayerAdditionalFieldResource $additionalField
     *
     * @return array
     */
    public function payerAdditionalField(PayerAdditionalFieldResource $additionalField): array
    {
        return $this->service->post('/Common/PayerAdditionalField', $additionalField->jsonSerialize());
    }

    /**
     * Payer Branches
     *
     * #[Route("Common/PayerBranches", methods: ["POST"])]
     *
     * @Route("/Common/PayerBranches", methods={"POST"})
     *
     * @param PayerBranchesResource $payerBranches
     *
     * @return array
     */
    public function payerBranches(PayerBranchesResource $payerBranches): array
    {
        return $this->service->post('/Common/PayerBranches', $payerBranches->jsonSerialize());
    }

    /**
     * State Disclaimer
     *
     * #[Route("Common/StateDisclaimer", methods: ["POST"])]
     *
     * @Route("/Common/StateDisclaimer", methods={"POST"})
     *
     * @param StateDisclaimer $stateDisclaimer
     *
     * @return array
     */
    public function stateDisclaimer(StateDisclaimer $stateDisclaimer): array
    {
        return $this->service->post('/Common/StateDisclaimer', $stateDisclaimer);
    }
}
