<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. ------  جدول الخزنات المتعلقة بخزنات أخرى -------
     */
    public function up(): void
    {
        Schema::create('treasuries_delivaries', function (Blueprint $table) {
            $table->id();
            $table->integer('treasuries_id'); /*الخزنة التي سوف تستلم   */
            $table->integer('treasuries_can_delivary_id'); /* الخزنة التي سيتم تسليمها*/
            $table->string('added_by');
            $table->string('updated_by')->nullable();
            $table->string('com_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries_delivaries');
    }
};