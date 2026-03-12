<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('driver_registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('transport_axis_id')->nullable()->constrained('transport_axes')->nullOnDelete();
            $table->unsignedInteger('seats_capacity');
            $table->unsignedInteger('seats_reserved')->default(0);
            $table->text('route_note')->nullable();
            $table->enum('assignment_source', ['auto', 'manual'])->default('auto');
            $table->enum('status', ['pending', 'ready', 'on_the_way', 'completed'])->default('pending');
            $table->timestamps();

            // A driver can have only ONE ride per event
            $table->unique(['event_id', 'driver_registration_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
