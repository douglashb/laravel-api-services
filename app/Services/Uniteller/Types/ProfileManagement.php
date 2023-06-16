<?php

namespace App\Services\Uniteller\Types;

use App\Http\Resources\Remittance\PersonalInfoResource;
use App\Services\Uniteller\Classes\AddBeneficiary;
use App\Services\Uniteller\Classes\BankAccountLinkInfo;
use App\Services\Uniteller\Classes\EditUserProfile;
use App\Services\Uniteller\Classes\ValidateRoutingNumber;
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

class ProfileManagement
{
    public function __construct(
        private UnitellerService $service
    ) {
    }

    /**
     * User Profile Info
     *
     * #[Route("ProfileManagement/UserProfileInfo", methods: ["POST"])]
     *
     * @param UnitellerSessionResource $unitellerWithSession
     *
     * @return array
     */
    public function userProfileInfo(UnitellerSessionResource $unitellerWithSession): array
    {
        return $this->service->post('/ProfileManagement/UserProfileInfo', $unitellerWithSession->jsonSerialize());
    }

    /**
     * Calculate Profile Completeness
     *
     * #[Route("ProfileManagement/CalculateProfileCompleteness", methods: ["POST"])]
     *
     * @param UnitellerSessionResource $calculateProfileCompleteness
     *
     * @return array
     */
    public function calculateProfileCompleteness(UnitellerSessionResource $calculateProfileCompleteness): array
    {
        return $this->service->post('/ProfileManagement/CalculateProfileCompleteness', $calculateProfileCompleteness->jsonSerialize());
    }

    /**
     * Setup Personal Info
     *
     * #[Route("ProfileManagement/SetupPersonalInfo", methods: ["POST"])]
     *
     * @param PersonalInfoResource $setupPersonalInfo
     *
     * @return array
     */
    public function setupPersonalInfo(PersonalInfoResource $setupPersonalInfo): array
    {
        return $this->service->post('/ProfileManagement/SetupPersonalInfo', $setupPersonalInfo->jsonSerialize());
    }

    /**
     * Information Verification
     *
     * #[Route("ProfileManagement/InformationVerification", methods: ["POST"])]
     *
     * @param UnitellerSessionResource $informationVerification
     *
     * @return array
     */
    public function informationVerification(UnitellerSessionResource $informationVerification): array
    {
        return $this->service->post('/ProfileManagement/InformationVerification', $informationVerification->jsonSerialize());
    }

    /**
     * Get All Beneficiaries by User
     *
     * #[Route("ProfileManagement/BeneficiarySummaryList", methods: ["POST"])]
     *
     * @param BeneficiaryIndexResource $beneficiarySummaryList
     *
     * @return array
     */
    public function beneficiarySummaryList(BeneficiaryIndexResource $beneficiarySummaryList): array
    {
        return $this->service->post('/ProfileManagement/BeneficiarySummaryList', $beneficiarySummaryList->jsonSerialize());
    }

    /**
     * Add Beneficiaries
     *
     * #[Route("ProfileManagement/AddBeneficiary", methods: ["POST"])]
     *
     * @param AddBeneficiaryResource $addBeneficiary
     *
     * @return array
     */
    public function addBeneficiary(AddBeneficiaryResource $addBeneficiary): array
    {
        return $this->service->post('/ProfileManagement/AddBeneficiary', $addBeneficiary->jsonSerialize());
    }

    /**
     * Deactivate Beneficiaries
     *
     * #[Route("ProfileManagement/beneficiaries", methods: ["POST"])]
     *
     * @param BeneficiaryResource $deactivateBeneficiary
     *
     * @return array
     */
    public function deactivateBeneficiary(BeneficiaryResource $deactivateBeneficiary): array
    {
        return $this->service->post('/ProfileManagement/DeactivateBeneficiary', $deactivateBeneficiary->jsonSerialize());
    }

    /**
     * Beneficiary Detail
     *
     * #[Route("ProfileManagement/BeneficiaryDetail", methods: ["POST"])]
     *
     * @param BeneficiaryResource $beneficiaryDetail
     *
     * @return array
     */
    public function beneficiaryDetail(BeneficiaryResource $beneficiaryDetail): array
    {
        return $this->service->post('/ProfileManagement/BeneficiaryDetail', $beneficiaryDetail->jsonSerialize());
    }

    /**
     * Edit Beneficiary
     *
     * #[Route("ProfileManagement/EditBeneficiary", methods: ["POST"])]
     *
     * @param AddBeneficiary $addBeneficiary
     *
     * @return array
     */
    public function editBeneficiary(AddBeneficiary $addBeneficiary): array
    {
        return $this->service->post('/ProfileManagement/EditBeneficiary', $addBeneficiary);
    }

    /**
     * Get All Sending Methods by User
     *
     * #[Route("ProfileManagement/SendingMethodSummaryList", methods: ["POST"])]
     *
     * @param SendingMethodIndexResource $sendingMethodsSummary
     *
     * @return array
     */
    public function sendingMethodSummaryList(SendingMethodIndexResource $sendingMethodsSummary): array
    {
        return $this->service->post('/ProfileManagement/SendingMethodSummaryList', $sendingMethodsSummary->jsonSerialize());
    }

    /**
     * Add Sending Method
     *
     * #[Route("ProfileManagement/AddSendingMethod", methods: ["POST"])]
     *
     * @param SendingMethodCreateResource $addSendingMethod
     *
     * @return array
     */
    public function addSendingMethod(SendingMethodCreateResource $addSendingMethod): array
    {
        return $this->service->post('/ProfileManagement/AddSendingMethod', $addSendingMethod->jsonSerialize());
    }

    /**
     * Sending Method Detail
     *
     * #[Route("ProfileManagement/SendingMethodDetail", methods: ["POST"])]
     *
     * @param SendingMethodResource $sendingMethodDetail
     *
     * @return array
     */
    public function sendingMethodDetail(SendingMethodResource $sendingMethodDetail): array
    {
        return $this->service->post('/ProfileManagement/SendingMethodDetail', $sendingMethodDetail->jsonSerialize());
    }

    /**
     * Deactivate Sending Method
     *
     * #[Route("ProfileManagement/DeactivateSendingMethod", methods: ["POST"])]
     *
     * @param SendingMethodResource $deactivateSendingMethod
     *
     * @return array
     */
    public function deactivateSendingMethod(SendingMethodResource $deactivateSendingMethod): array
    {
        return $this->service->post('/ProfileManagement/DeactivateSendingMethod', $deactivateSendingMethod->jsonSerialize());
    }


    /**
     * Send Plaid Link Details
     *
     * #[Route("ProfileManagement/SendPlaidLinkDetails", methods: ["POST"])]
     *
     * @param BankAccountPlaidResource $sendPlaidLinkDetails
     *
     * @return array
     */
    public function sendPlaidLinkDetails(BankAccountPlaidResource $sendPlaidLinkDetails): array
    {
        return $this->service->post('/ProfileManagement/SendPlaidLinkDetails', $sendPlaidLinkDetails->jsonSerialize());
    }

    /**
     * Validate Routing Number
     *
     * #[Route("ProfileManagement/ValidateRoutingNumber", methods: ["POST"])]
     *
     * @param ValidateRoutingNumber $validateRoutingNumber
     *
     * @return array
     */
    public function validateRoutingNumber(ValidateRoutingNumber $validateRoutingNumber): array
    {
        return $this->service->post('/ProfileManagement/ValidateRoutingNumber', $validateRoutingNumber);
    }

    /**
     * Edit User Profile
     *
     * #[Route("ProfileManagement/EditUserProfile", methods: ["POST"])]
     *
     * @param EditUserProfile $editUserProfile
     *
     * @return array
     */
    public function editUserProfile(EditUserProfile $editUserProfile): array
    {
        return $this->service->post('/ProfileManagement/EditUserProfile', $editUserProfile);
    }

    /**
     * Generate link Token
     *
     * #[Route("ProfileManagement/link/token/create", methods: ["POST"])]
     *
     * @param BankAccountPlaidTokenResource $bankLinkTokenCreate
     *
     * @return array
     */
    public function generatePlaidToken(BankAccountPlaidTokenResource $bankLinkTokenCreate): array
    {
        return $this->service->post('/ProfileManagement/link/token/create', $bankLinkTokenCreate->jsonSerialize());
    }

    /**
     * Bank Account Link Info
     *
     * #[Route("ProfileManagement/BankAccountLinkInfo", methods: ["POST"])]
     *
     * @param BankAccountLinkInfo $bankAccountLinkInfo
     *
     * @return array
     */
    public function bankAccountLinkInfo(BankAccountLinkInfo $bankAccountLinkInfo): array
    {
        return $this->service->post('/ProfileManagement/BankAccountLinkInfo', $bankAccountLinkInfo);
    }
}
