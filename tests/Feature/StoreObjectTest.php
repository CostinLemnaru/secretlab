<?php

namespace Tests\Feature;

use App\Models\StoredObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreObjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_value(): void
    {
        $this->freezeTime();

        $response = $this->postJson('/object', ['mykey' => 'value1']);

        $response->assertCreated()->assertExactJson([
            'key' => 'mykey',
            'value' => 'value1',
            'timestamp' => now()->getTimestamp(),
        ]);

        $object = StoredObject::sole();

        $this->assertSame('mykey', $object->key);
        $this->assertSame('value1', $object->value);
        $this->assertSame(now()->getTimestamp(), $object->timestamp);
    }
}
