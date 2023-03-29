<?php

namespace App\Http\Controllers\Web\Referral\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferralListResource extends JsonResource
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
            'id' => $this->id,
            'email' => $this->email,
            'is_registered' => $this->is_registered,
            'referrer' => $this->referredBy->name,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
