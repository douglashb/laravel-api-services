<?php

namespace App\Services\Uniteller\Classes;

class SendingMethodsSummary extends BaseSession
{
    public string $sendingMethodName = 'All';
    public string $sendingMethodStatus = 'All';

    /**
     * @param string $sending_method_name
     */
    public function setSendingMethodName(string $sending_method_name): void
    {
        $this->sendingMethodName = $sending_method_name;
    }

    /**
     * @param string $sending_method_status
     */
    public function setSendingMethodStatus(string $sending_method_status): void
    {
        $this->sendingMethodStatus = $sending_method_status;
    }
}
