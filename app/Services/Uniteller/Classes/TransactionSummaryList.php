<?php

namespace App\Services\Uniteller\Classes;

class TransactionSummaryList extends BaseSession
{
    public ?string $transactionNumber = null;
    public string $transactionStatus;
    public ?string $thisWeek = null;
    public ?string $lastWeek = null;
    public ?string $thisMonth = null;
    public ?string $lastMonth = null;
    public string $toDate;
    public string $fromDate;
    public ?string $beneficiaryNickName = null;
    public ?int $maxTransactionCount = null;

    /**
     * @param string|null $transaction_number
     */
    public function setTransactionNumber(?string $transaction_number): void
    {
        $this->transactionNumber = $transaction_number;
    }

    /**
     * @param string $transaction_status | paid, cancel, hold, payable, refund, replaced
     */
    public function setTransactionStatus(string $transaction_status): void
    {
        $this->transactionStatus = $transaction_status;
    }

    /**
     * @param string|null $this_week
     */
    public function setThisWeek(?string $this_week): void
    {
        $this->thisWeek = $this_week;
    }

    /**
     * @param string|null $last_week
     */
    public function setLastWeek(?string $last_week): void
    {
        $this->lastWeek = $last_week;
    }

    /**
     * @param string|null $this_month
     */
    public function setThisMonth(?string $this_month): void
    {
        $this->thisMonth = $this_month;
    }

    /**
     * @param string|null $this_month
     */
    public function setLastMonth(?string $this_month): void
    {
        $this->lastMonth = $this_month;
    }

    /**
     * @param string|null $to_date
     */
    public function setToDate(?string $to_date): void
    {
        $this->toDate = $to_date;
    }

    /**
     * @param string|null $from_date
     */
    public function setFromDate(?string $from_date): void
    {
        $this->fromDate = $from_date;
    }
}
