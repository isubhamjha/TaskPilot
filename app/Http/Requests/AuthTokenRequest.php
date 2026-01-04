<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        $allowedIps = config('auth.token_allowed_ips', []);

        if (empty($allowedIps)) {
            return true;
        }

        return in_array($this->ip(), $allowedIps, true);
    }

    /**
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
