<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use stdClass;

class StoreObjectRequest extends FormRequest
{
    public function validationData(): array
    {
        $payload = json_decode($this->getContent());

        if (! $payload instanceof stdClass || count((array) $payload) !== 1) {
            throw ValidationException::withMessages([
                'body' => 'Provide a JSON object with exactly one key and value.',
            ]);
        }

        $properties = get_object_vars($payload);
        $key = (string) array_key_first($properties);

        return [
            'key' => $key,
            'value' => $properties[$key],
        ];
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255'],
            'value' => ['present'],
        ];
    }
}
