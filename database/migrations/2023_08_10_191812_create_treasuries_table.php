<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. ------  جدول الخزنات -------
     */
    public function up(): void
    {
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('is_master')->default(0); /* هل خزنة رئيسية ام لا */
            $table->bigInteger('last_isal_exchange'); /* اخر ايصال صرف */
            $table->bigInteger('last_isal_collect'); /* اخرايصال تحصيل  */
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
        Schema::dropIfExists('treasuries');
    }
};
