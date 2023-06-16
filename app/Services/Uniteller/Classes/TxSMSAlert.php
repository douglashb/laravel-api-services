<?php

namespace App\Services\Uniteller\Classes;

class TxSMSAlert extends BaseSession
{
    public string $transactionNumber;
    public string $beneCellPhone;
    public ?string $remiCellPhone = null;

    /**
     * @param string $transaction_number
     */
    public function setTransactionNumber(string $transaction_number): void
    {
        $this->transactionNumber = $transaction_number;
    }

    /**
     * @param string $bene_cell_phone
     */
    public function setBeneCellPhone(string $bene_cell_phone): void
    {
        $this->beneCellPhone = $bene_cell_phone;
    }

    /**
     * @param string $remi_cell_phone
     */
    public function setRemiCellPhone(string $remi_cell_phone): void
    {
        $this->remiCellPhone = $remi_cell_phone;
    }
}
