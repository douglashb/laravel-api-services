<?php

namespace App\Http\Resources\Remittance;

use Illuminate\Http\Resources\Json\JsonResource;

class RemitAutenticateSignupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'authenticationCode' => $this['code'],
            'userId' => $this['email'],
            'password' => $this['password'],
        ];
    }
}
