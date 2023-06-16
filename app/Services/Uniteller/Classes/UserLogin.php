<?php

namespace App\Services\Uniteller\Classes;

class UserLogin extends Base
{
    public string $userId;
    public string $password;
    public string $uniqueDeviceId;
    public string $saveUniqueDeviceId;
    public ?string $uicReceiptMode;
    public ?string $uic;
    public string $userIPAddress;

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->userId = $user_id;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $unique_device_id
     */
    public function setUniqueDeviceId(string $unique_device_id): void
    {
        $this->uniqueDeviceId = $unique_device_id;
    }

    /**
     * @param string $save_unique_device_id
     */
    public function setSaveUniqueDeviceId(string $save_unique_device_id): void
    {
        $this->saveUniqueDeviceId = $save_unique_device_id;
    }

    /**
     * @param string $uic_reception_mode
     */
    public function setUicReceptionMode(string $uic_reception_mode): void
    {
        $this->uicReceiptMode = $uic_reception_mode;
    }

    /**
     * @param string $uic
     */
    public function setUic(string $uic): void
    {
        $this->uic = $uic;
    }

    /**
     * @param string $user_ip_address
     */
    public function setUserIPAddress(string $user_ip_address): void
    {
        $this->userIPAddress = $user_ip_address;
    }
}
