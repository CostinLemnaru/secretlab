<?php

namespace Tests\Feature;

use App\Models\StoredObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListObjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_versions_in_chronological_order(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'second', 'timestamp' => 200]);
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'first', 'timestamp' => 100]);
        StoredObject::factory()->create(['key' => 'other', 'value' => null, 'timestamp' => 200]);

        $this->getJson('/object/get_all_records')->assertOk()->assertExactJson([
            ['key' => 'mykey', 'value' => 'first', 'timestamp' => 100],
            ['key' => 'mykey', 'value' => 'second', 'timestamp' => 200],
            ['key' => 'other', 'value' => null, 'timestamp' => 200],
        ]);
    }

    public function test_it_returns_an_empty_array_when_no_records_exist(): void
    {
        $this->getJson('/object/get_all_records')->assertOk()->assertExactJson([]);
    }
}
