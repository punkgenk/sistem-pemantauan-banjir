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
        Schema::table('reports', function (Blueprint $table) {
        $table->enum('category', ['genangan', 'banjir_sedang', 'banjir_parah'])->default('genangan')->after('title');
        $table->decimal('water_height', 8, 2)->nullable()->after('category')->comment('tinggi air dalam cm');
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
        $table->dropColumn(['category', 'water_height']);
    });
    }
};
