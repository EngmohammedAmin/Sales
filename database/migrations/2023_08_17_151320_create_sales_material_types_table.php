<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. ------  جدول  المبيعات -------
     */
    public function up(): void
    {
        Schema::create('sales_material_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('added_by');
            $table->string('updated_by')->nullable();
            $table->string('com_code');
            $table->date('date'); /*  من اجل البحث عن طريقه*/
            $table->integer('active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_material_types');
    }
};