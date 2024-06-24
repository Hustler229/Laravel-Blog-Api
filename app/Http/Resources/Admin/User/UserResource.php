<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->rule == 'admin') {
            $rule = "Administrator";
        }elseif ($this->rule == 'default') {
            $rule = "Default User";
        }
        if ($this->email_verified_at == null) {
            $verified = false;
        }else{
            $verified = true;
        }
        return [
            'name' => $this->name,
            'email' => $this->email,
            'rule' => $rule,
            'remember_token' => $this->remember_token,
            'creation date' => $this->created_at->format('Y-m-d H:i:s'),
            'email verified' => $verified
        ];
    }
}
