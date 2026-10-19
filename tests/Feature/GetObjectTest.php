<?php

namespace Tests\Feature;

use App\Models\StoredObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetObjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_latest_value_for_the_requested_key(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'latest', 'timestamp' => 200]);
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'old', 'timestamp' => 100]);
        StoredObject::factory()->create(['key' => 'other', 'value' => 'unrelated', 'timestamp' => 300]);

        $this->getJson('/object/mykey')->assertOk()->assertContent('"latest"');
    }

    public function test_it_returns_the_value_at_or_before_the_timestamp(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'first', 'timestamp' => 100]);
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'second', 'timestamp' => 200]);

        $this->getJson('/object/mykey?timestamp=150')->assertOk()->assertContent('"first"');
        $this->getJson('/object/mykey?timestamp=200')->assertOk()->assertContent('"second"');
        $this->getJson('/object/mykey?timestamp=300')->assertOk()->assertContent('"second"');
    }

    public function test_the_last_insert_wins_when_timestamps_are_equal(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'first', 'timestamp' => 100]);
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'second', 'timestamp' => 100]);

        $this->getJson('/object/mykey')->assertOk()->assertContent('"second"');
        $this->getJson('/object/mykey?timestamp=100')->assertOk()->assertContent('"second"');
    }

    public function test_it_returns_not_found_when_no_version_exists(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'timestamp' => 100]);

        $this->getJson('/object/missing')->assertNotFound();
        $this->getJson('/object/mykey?timestamp=99')->assertNotFound();
    }

    public function test_zero_is_a_valid_timestamp(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'first', 'timestamp' => 0]);
        StoredObject::factory()->create(['key' => 'mykey', 'value' => 'second', 'timestamp' => 100]);

        $this->getJson('/object/mykey?timestamp=0')->assertOk()->assertContent('"first"');
    }

    public function test_it_rejects_invalid_timestamps(): void
    {
        $invalidQueries = [
            'timestamp=',
            'timestamp=-1',
            'timestamp=1.5',
            'timestamp=abc',
            'timestamp=999999999999999999999999',
            'timestamp[]=1',
        ];

        foreach ($invalidQueries as $query) {
            $this->getJson('/object/mykey?'.$query)
                ->assertUnprocessable()
                ->assertJsonValidationErrors('timestamp');
        }
    }

    public function test_it_returns_json_null_for_a_saved_null_value(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => null]);

        $this->getJson('/object/mykey')->assertOk()->assertContent('null');
    }

    public function test_it_returns_a_json_object_without_a_wrapper(): void
    {
        StoredObject::factory()->create(['key' => 'mykey', 'value' => (object) ['name' => 'Ana']]);

        $this->getJson('/object/mykey')->assertOk()->assertExactJson(['name' => 'Ana']);
    }

    public function test_it_reads_a_key_with_spaces_and_a_slash(): void
    {
        $key = 'folder/my key';
        StoredObject::factory()->create(['key' => $key, 'value' => 'found']);

        $this->getJson('/object/'.rawurlencode($key))->assertOk()->assertContent('"found"');
    }
}
