<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->decimal('width_with_frame', 10, 2)->nullable()->change();
            $table->decimal('height_with_frame', 10, 2)->nullable()->change();
            $table->decimal('width_without_frame', 10, 2)->nullable()->change();
            $table->decimal('height_without_frame', 10, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->decimal('width_with_frame', 10, 2)->nullable(false)->change();
            $table->decimal('height_with_frame', 10, 2)->nullable(false)->change();
            $table->decimal('width_without_frame', 10, 2)->nullable(false)->change();
            $table->decimal('height_without_frame', 10, 2)->nullable(false)->change();
        });
    }
};
