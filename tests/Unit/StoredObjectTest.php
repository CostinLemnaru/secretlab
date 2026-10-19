<?php

namespace Tests\Unit;

use App\Models\StoredObject;
use PHPUnit\Framework\TestCase;

class StoredObjectTest extends TestCase
{
    public function test_it_reads_a_json_value_as_an_object(): void
    {
        $object = new StoredObject;
        $object->setRawAttributes(['value' => '{"name":"Ana"}']);

        $value = $object->value;

        $this->assertInstanceOf(\stdClass::class, $value);
        $this->assertSame('Ana', $value->name);
    }
}
