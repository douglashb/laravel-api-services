<?php

namespace App\Services\Uniteller\Classes;

class Errors
{
    public string $merchant;
    public string $api_name;
    public string $status_text;
    public int $status_code;
    public string $class_name;
    public string $file_name;
    public int $line;

    /**
     * @param string $api_name
     */
    public function setApiName(string $api_name): void
    {
        $this->api_name = $api_name;
    }

    /**
     * @param string $status_text
     */
    public function setStatusText(string $status_text): void
    {
        $this->status_text = $status_text;
    }

    /**
     * @param int $status_code
     */
    public function setStatusCode(int $status_code): void
    {
        $this->status_code = $status_code;
    }

    /**
     * @param string $class_name
     */
    public function setClassName(string $class_name): void
    {
        $this->class_name = $class_name;
    }

    /**
     * @param string $file_name
     */
    public function setFileName(string $file_name): void
    {
        $this->file_name = $file_name;
    }

    /**
     * @param int $line
     */
    public function setLine(int $line): void
    {
        $this->line = $line;
    }

    /**
     * @param string $merchant
     */
    public function setMerchant(string $merchant): void
    {
        $this->merchant = $merchant;
    }
}
