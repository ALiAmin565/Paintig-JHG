<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
        });

        Schema::table('paintings', function (Blueprint $table) {
            $table->enum('location_type', ['hotel', 'location', 'none'])->default('none')->after('hotel_id');
            $table->foreignId('location_id')->nullable()->after('location_type')->constrained()->nullOnDelete();
            $table->unsignedBigInteger('hotel_id')->nullable()->change();
            $table->string('painter_name')->default('Unknown')->after('title');
            $table->decimal('price', 12, 2)->nullable()->after('painter_name');
            $table->enum('certificate_type', ['text', 'file'])->default('text')->after('paid_by');
            $table->text('certificate_text')->nullable()->after('certificate_type');
            $table->string('certificate_file_path')->nullable()->after('certificate_text');
        });

        if (Schema::hasColumn('paintings', 'certificate_of_authenticity')) {
            DB::table('paintings')->whereNotNull('certificate_of_authenticity')->update([
                'certificate_text' => DB::raw('certificate_of_authenticity'),
                'certificate_type' => 'text',
            ]);
        }

        DB::table('paintings')->whereNotNull('hotel_id')->update(['location_type' => 'hotel']);

        Schema::table('paintings', function (Blueprint $table) {
            $table->foreign('hotel_id')->references('id')->on('hotels')->nullOnDelete();
        });

        if (Schema::hasColumn('paintings', 'certificate_of_authenticity')) {
            Schema::table('paintings', function (Blueprint $table) {
                $table->dropColumn('certificate_of_authenticity');
            });
        }

        Schema::create('painting_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('painting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('painting_notes');

        Schema::table('paintings', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropForeign(['location_id']);
        });

        Schema::table('paintings', function (Blueprint $table) {
            $table->dropColumn([
                'location_type',
                'location_id',
                'painter_name',
                'price',
                'certificate_type',
                'certificate_text',
                'certificate_file_path',
            ]);
            $table->string('certificate_of_authenticity')->default('');
            $table->unsignedBigInteger('hotel_id')->nullable(false)->change();
        });

        Schema::table('paintings', function (Blueprint $table) {
            $table->foreign('hotel_id')->references('id')->on('hotels')->cascadeOnDelete();
        });
    }
};
