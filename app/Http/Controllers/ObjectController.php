<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectRequest;
use App\Models\StoredObject;
use Illuminate\Http\JsonResponse;

class ObjectController extends Controller
{
    public function store(StoreObjectRequest $request): JsonResponse
    {
        $object = StoredObject::create([
            'key' => $request->validated('key'),
            'value' => $request->validated('value'),
            'timestamp' => now()->getTimestamp(),
        ]);

        return response()->json([
            'key' => $object->key,
            'value' => $object->value,
            'timestamp' => $object->timestamp,
        ], 201);
    }
}
