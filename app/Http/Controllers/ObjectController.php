<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetObjectRequest;
use App\Http\Requests\StoreObjectRequest;
use App\Models\StoredObject;
use Illuminate\Http\JsonResponse;

class ObjectController extends Controller
{
    public function index(): JsonResponse
    {
        $objects = StoredObject::orderBy('timestamp')
            ->orderBy('id')
            ->get(['key', 'value', 'timestamp']);

        return response()->json($objects);
    }

    public function show(GetObjectRequest $request): JsonResponse
    {
        $query = StoredObject::where('key', $request->validated('key'));
        $timestamp = $request->validated('timestamp');

        if ($timestamp !== null) {
            $query->where('timestamp', '<=', $timestamp);
        }

        $object = $query->orderByDesc('timestamp')->orderByDesc('id')->firstOrFail();

        return response()->json()->setData($object->value);
    }

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
