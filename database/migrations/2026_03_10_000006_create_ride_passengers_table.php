<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ride_passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained('rides')->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->enum('assignment_reason', [
                'same_area',
                'same_axis',
                'neighbor_axis',
                'manual_override',
            ])->default('manual_override');
            $table->timestamps();

            // A passenger can only be on ONE ride per event (enforced via ride → event)
            $table->unique(['ride_id', 'registration_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_passengers');
    }
};
