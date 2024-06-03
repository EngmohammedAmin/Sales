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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_code');
            $table->integer('suppliers_categories_id');
            $table->string('name');
            $table->bigInteger('account_number'); // رقم الحساب المالي لايكرر على مستوى الشركة
            $table->tinyInteger('start_balance_status');
            $table->decimal('start_balance', 10, 2); // الحساب الابتدائي (الرصيد الافتتاحي للحساب) سواء كان دائن أو مدين أو متزن أول المدة لو سالب يعني دائن --لو موجب مدين -- لو 0 متزن
            $table->decimal('current_balance', 10, 2)->default(0); //الحساب الحالي
            $table->string('notes')->nullable();
            $table->string('added_by');
            $table->string('updated_by')->nullable();
            $table->integer('com_code');
            $table->tinyInteger('active')->default(0);
            $table->date('date');
            $table->integer('city_id')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};