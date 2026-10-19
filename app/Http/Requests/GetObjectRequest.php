<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetObjectRequest extends FormRequest
{
    public function validationData(): array
    {
        return [
            ...$this->query(),
            'key' => $this->route('key'),
        ];
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255'],
            'timestamp' => ['sometimes', 'required', 'integer', 'min:0', 'max:'.PHP_INT_MAX],
        ];
    }
}
