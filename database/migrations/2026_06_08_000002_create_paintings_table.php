<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->binary('photo')->nullable();
            $table->string('photo_mime')->nullable();
            $table->string('title');
            $table->string('media');
            $table->unsignedSmallInteger('production_year');
            $table->decimal('dimensions_with_frame', 10, 2);
            $table->decimal('dimensions_without_frame', 10, 2);
            $table->string('owned_by');
            $table->string('purchased_by');
            $table->string('purchased_from');
            $table->string('paid_by');
            $table->string('certificate_of_authenticity');
            $table->timestamps();
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE paintings MODIFY photo LONGBLOB NULL');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('paintings');
    }
};
