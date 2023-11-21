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
        Schema::create('charging_points', function (Blueprint $table) {
            $table->id();
            $table->string('type_of_electric_current')->nullable();
            $table->string('plug_type')->nullable();
            $table->string('power')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charging_points');
    }
};
