<?php

namespace App\Http\Resources\Remittance;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitRequestPasswordResource extends JsonResource
{
    use UnitellerAttributes;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this['email'],
            'platform' => session('user_remote_platform'),
            'uic' => $this['uic'] ?? null,
            'new_password' => $this['password'] ?? null,
        ] + self::base();
    }
}
