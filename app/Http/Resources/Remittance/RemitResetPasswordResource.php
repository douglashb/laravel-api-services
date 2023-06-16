<?php

namespace App\Http\Resources\Remittance;

use Illuminate\Http\Resources\Json\JsonResource;

class RemitResetPasswordResource extends JsonResource
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
            'userId' => $this['email'],
            'securityQuestionAnswers' => $this['security_question'] ?? null,
            'uicReceiptMode' => $this['reception_mode'] ?? null,
            'uic' => $this['code'] ?? null,
            'newPassword' => $this['password'] ?? null,
        ];
    }
}
