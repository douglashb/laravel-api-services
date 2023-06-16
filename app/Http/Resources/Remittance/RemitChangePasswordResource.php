<?php

namespace App\Http\Resources\Remittance;

use App\Services\Uniteller\Traits\UnitellerAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RemitChangePasswordResource extends JsonResource
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
            'currentPassword' => auth()->user()->auth,
            'newPassword' => $this['password'],
            'userId' => auth()->user()->email,
        ] + self::base();
    }
}
