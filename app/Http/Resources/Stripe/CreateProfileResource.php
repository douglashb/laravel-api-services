<?php

namespace App\Http\Resources\Stripe;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $merchant = cache(session('merchant'));

        return [
            'name' => $this['first_name'] . ' ' . $this['first_last_name'],
            'email' => $this['email'],
            'phone' => $this['phone'],
            'metadata' => [
                'merchant' => $merchant['name'],
                'platform' => session('user_remote_platform')
            ]
        ];
    }
}
