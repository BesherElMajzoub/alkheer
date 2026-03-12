<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Add area_id as structured reference (nullable for backward compat)
            $table->foreignId('area_id')->nullable()->after('area')->constrained('areas')->nullOnDelete();
            $table->string('nearest_landmark')->nullable()->after('area_id');
            $table->boolean('willing_to_drive')->default(false)->after('available_seats');
            $table->boolean('needs_ride')->default(false)->after('willing_to_drive');
            $table->string('driver_token', 64)->nullable()->unique()->after('needs_ride');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['area_id']);
            $table->dropColumn(['area_id', 'nearest_landmark', 'willing_to_drive', 'needs_ride', 'driver_token']);
        });
    }
};
