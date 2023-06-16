<?php

namespace App\Services\Uniteller\Classes;

class ResetPassword extends Base
{
    public string $userId;
    public ?array $securityQuestionAnswers = null;
    public ?string $uicReceiptMode = null;
    public ?string $uic = null;
    public ?string $newPassword = null;

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->userId = $user_id;
    }

    /**
     * @param ?array $security_question_answer
     */
    public function setSecurityQuestionAnswers(?array $security_question_answer): void
    {
        $this->securityQuestionAnswers = $security_question_answer;
    }

    /**
     * @param ?string $uic_reception_method
     */
    public function setUicReceiptMode(?string $uic_reception_method): void
    {
        $this->uicReceiptMode = $uic_reception_method;
    }

    /**
     * @param ?string $uic
     */
    public function setUic(?string $uic): void
    {
        $this->uic = $uic;
    }

    /**
     * @param ?string $new_password
     */
    public function setNewPassword(?string $new_password): void
    {
        $this->newPassword = $new_password;
    }
}
