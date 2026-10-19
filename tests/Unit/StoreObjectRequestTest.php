<?php

namespace Tests\Unit;

use App\Http\Requests\StoreObjectRequest;
use PHPUnit\Framework\TestCase;

class StoreObjectRequestTest extends TestCase
{
    public function test_it_extracts_the_key_and_value_from_json(): void
    {
        $request = StoreObjectRequest::create(
            uri: '/object',
            method: 'POST',
            content: '{"mykey":"value1"}',
        );

        $this->assertSame([
            'key' => 'mykey',
            'value' => 'value1',
        ], $request->validationData());
    }
}
