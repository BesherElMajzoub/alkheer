<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('axis_neighbors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('axis_id')->constrained('transport_axes')->cascadeOnDelete();
            $table->foreignId('neighbor_axis_id')->constrained('transport_axes')->cascadeOnDelete();
            $table->unsignedInteger('priority')->default(1); // 1 = closest neighbor
            $table->timestamps();

            $table->unique(['axis_id', 'neighbor_axis_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('axis_neighbors');
    }
};
