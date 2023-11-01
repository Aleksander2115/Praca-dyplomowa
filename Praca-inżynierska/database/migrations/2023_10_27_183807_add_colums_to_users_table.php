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
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('end_time')->nullable()->after('password');
            $table->dateTime('start_time')->nullable()->after('password');
            $table->dateTime('sign_up_time')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sign_up_time');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
};
