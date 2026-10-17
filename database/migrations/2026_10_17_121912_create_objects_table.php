<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objects', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 255)->collation('utf8mb4_bin');
            $table->json('value');
            $table->unsignedBigInteger('timestamp');

            $table->index(['key', 'timestamp', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects');
    }
};
