<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('paintings', function (Blueprint $table) {
            $table->enum('purchased_from_type', ['gallery', 'person'])->default('person')->after('purchased_by');
            $table->foreignId('gallery_id')->nullable()->after('purchased_from_type')->constrained()->nullOnDelete();
            $table->string('purchased_from_person')->nullable()->after('gallery_id');
        });

        foreach (DB::table('paintings')->get(['id', 'purchased_from']) as $painting) {
            DB::table('paintings')->where('id', $painting->id)->update([
                'purchased_from_type' => 'person',
                'purchased_from_person' => $painting->purchased_from,
            ]);
        }

        Schema::table('paintings', function (Blueprint $table) {
            $table->dropColumn('purchased_from');
        });
    }

    public function down(): void
    {
        Schema::table('paintings', function (Blueprint $table) {
            $table->string('purchased_from')->default('')->after('purchased_by');
        });

        foreach (DB::table('paintings')->get(['id', 'purchased_from_type', 'gallery_id', 'purchased_from_person']) as $painting) {
            $label = $painting->purchased_from_type === 'gallery' && $painting->gallery_id
                ? (DB::table('galleries')->where('id', $painting->gallery_id)->value('name') ?? '')
                : ($painting->purchased_from_person ?? '');

            DB::table('paintings')->where('id', $painting->id)->update([
                'purchased_from' => $label,
            ]);
        }

        Schema::table('paintings', function (Blueprint $table) {
            $table->dropForeign(['gallery_id']);
            $table->dropColumn(['purchased_from_type', 'gallery_id', 'purchased_from_person']);
        });

        Schema::dropIfExists('galleries');
    }
};
