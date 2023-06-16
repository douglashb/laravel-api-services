<?php

namespace App\Services\Uniteller\Classes;

class Signup extends Base
{
    public RemitterPersonalInfo $remitterPersonalInfo;
    public string $password;
    public string $privacyPolicyAgreement = 'YES';
    public ?string $remiterReferral = null;
    public string $userIPAddress;
    public ?string $agreementLocale = null;
    public string $questionId;
    public string $answer;
    public string $answerHint;

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param RemitterPersonalInfo $remitterPersonalInfo
     */
    public function setRemitterPersonalInfo(RemitterPersonalInfo $remitterPersonalInfo): void
    {
        $this->remitterPersonalInfo = $remitterPersonalInfo;
    }

    /**
     * @param string $user_ip_address
     */
    public function setUserIPAddress(string $user_ip_address): void
    {
        $this->userIPAddress = $user_ip_address;
    }

    /**
     * @param string $questionId
     */
    public function setQuestionId(string $questionId): void
    {
        $this->questionId = $questionId;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @param string $answerHint
     */
    public function setAnswerHint(string $answerHint): void
    {
        $this->answerHint = $answerHint;
    }
}
