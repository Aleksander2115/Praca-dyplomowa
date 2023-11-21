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
        Schema::table('charging_stations', function (Blueprint $table) {
            $table->renameColumn('`number_of_chargers`', 'number_of_charging_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->renameColumn('`number_of_charging_points`', 'number_of_chargers');
    }
};
