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
        Schema::table('antenas', function (Blueprint $table) {
            $table->index('uf');
        });
    }

    public function down(): void
    {
        Schema::table('antenas', function (Blueprint $table) {
            $table->dropIndex(['uf']); // usa array com colunas
        });
    }
};
