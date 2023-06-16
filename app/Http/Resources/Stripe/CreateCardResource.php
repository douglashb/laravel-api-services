<?php

namespace App\Http\Resources\Stripe;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'card',
            'card' => [
                'number' => $this['number'],
                'exp_month' => $this['exp_month'],
                'exp_year' => $this['exp_year'],
                'cvc' => $this['cvc'],
            ],
            'billing_details' =>
                [
                    'address' => [
                        'city' => $this['city'],
                        'country' => 'US',
                        'line1' => $this['address_1'],
                        'line2' => $this['address_2'],
                        'postal_code' => $this['postal_code'],
                        'state' => $this['state']
                    ]
                ]
        ];
    }
}
