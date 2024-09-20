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
        Schema::create('interfaces', function (Blueprint $table) {
            $table->id('interfaceid');
            $table->bigInteger('hostid');
            $table->string('interface_name', 100);
            $table->string('description', 100);
            $table->bigInteger('capacity');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('interfaces');
    }
};
