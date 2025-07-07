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
        Schema::create('pops', function (Blueprint $table) {
            $table->string('pop_id')->primary();
            $table->string('pop_name');
            $table->integer('sbu_id');
            $table->string('pop_type');
            $table->double('lat');
            $table->double('lng');


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
        Schema::dropIfExists('pops');
    }
};
