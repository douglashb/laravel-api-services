<?php

namespace App\Services\Uniteller\Resources;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitTransactionsResource extends JsonResource
{
    use UnitellerAttributes;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'transactionNumber' => $this['id'] ?? null,
            'transactionStatus' => $this['status'] ?? null,
            'thisWeek' => $this['this_week'] ?? null,
            'lastWeek' => $this['last_month'] ?? null,
            'thisMonth' => ! isset($this['month']) ? 'Yes' : null,
            'lastMonth' => $this['last_month'] ?? null,
            'toDate' => isset($this['month']) ? str_pad($this['month'], 2, '0', STR_PAD_LEFT) . '31' . $this['year'] : null,
            'fromDate' => isset($this['month']) ? str_pad($this['month'], 2, '0', STR_PAD_LEFT) . '01' . $this['year'] : null,
            'beneficiaryNickName' => null,
            'maxTransactionCount' => null,
        ] + self::baseSession();
    }
}
