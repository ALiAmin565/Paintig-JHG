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
            $table->string('currency', 3)->default('USD')->after('price');
            $table->decimal('width_with_frame', 10, 2)->nullable()->after('production_year');
            $table->decimal('height_with_frame', 10, 2)->nullable()->after('width_with_frame');
            $table->decimal('width_without_frame', 10, 2)->nullable()->after('height_with_frame');
            $table->decimal('height_without_frame', 10, 2)->nullable()->after('width_without_frame');
        });

        if (Schema::hasColumn('paintings', 'dimensions_with_frame')) {
            DB::table('paintings')->update([
                'width_with_frame' => DB::raw('dimensions_with_frame'),
                'height_with_frame' => DB::raw('dimensions_with_frame'),
                'width_without_frame' => DB::raw('dimensions_without_frame'),
                'height_without_frame' => DB::raw('dimensions_without_frame'),
            ]);
        }

        DB::table('paintings')->whereNull('price')->update(['price' => 0]);

        Schema::table('paintings', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->change();
            $table->decimal('width_with_frame', 10, 2)->nullable(false)->change();
            $table->decimal('height_with_frame', 10, 2)->nullable(false)->change();
            $table->decimal('width_without_frame', 10, 2)->nullable(false)->change();
            $table->decimal('height_without_frame', 10, 2)->nullable(false)->change();
        });

        Schema::table('paintings', function (Blueprint $table) {
            if (Schema::hasColumn('paintings', 'dimensions_with_frame')) {
                $table->dropColumn(['dimensions_with_frame', 'dimensions_without_frame']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->decimal('dimensions_with_frame', 10, 2)->nullable();
            $table->decimal('dimensions_without_frame', 10, 2)->nullable();
        });

        DB::table('paintings')->update([
            'dimensions_with_frame' => DB::raw('width_with_frame'),
            'dimensions_without_frame' => DB::raw('width_without_frame'),
        ]);

        Schema::table('paintings', function (Blueprint $table) {
            $table->decimal('dimensions_with_frame', 10, 2)->nullable(false)->change();
            $table->decimal('dimensions_without_frame', 10, 2)->nullable(false)->change();
            $table->decimal('price', 12, 2)->nullable()->change();
            $table->dropColumn([
                'currency',
                'width_with_frame',
                'height_with_frame',
                'width_without_frame',
                'height_without_frame',
            ]);
        });
    }
};
