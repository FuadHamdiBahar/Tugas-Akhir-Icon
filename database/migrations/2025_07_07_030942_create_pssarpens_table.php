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
        Schema::create('pssarpens', function (Blueprint $table) {
            $table->uuid('psid');
            $table->string('pop_id');
            $table->string('perangkat');
            $table->year('tahun');
            $table->string('mitra_pelaksana');
            $table->integer('jumlah');

            // default field
            $table->string('created_by')->default('admin@admin.com');
            $table->string('updated_by')->default('admin@admin.com');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pssarpens');
    }
};
