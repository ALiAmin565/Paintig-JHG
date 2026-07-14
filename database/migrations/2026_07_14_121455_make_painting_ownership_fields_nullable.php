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
        Schema::table('paintings', function (Blueprint $table) {
            $table->string('owned_by')->nullable()->change();
            $table->string('purchased_by')->nullable()->change();
            $table->string('paid_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->string('owned_by')->nullable(false)->change();
            $table->string('purchased_by')->nullable(false)->change();
            $table->string('paid_by')->nullable(false)->change();
        });
    }
};
