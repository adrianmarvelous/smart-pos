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
        Schema::table('models_has_roles', function (Blueprint $table) {
            $table->string('store_id')->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('models_has_roles', function (Blueprint $table) {
            $table->dropColumn('store_id');
        });
    }
};
