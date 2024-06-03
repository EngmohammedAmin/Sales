<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. جدول مشتريات ومرتجعات الموردين
     */
    public function up(): void
    {
        Schema::create('suppliers_with_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_type'); //1- bershase(مشتريات).....2- retuern on same bill(مرتجع على أصل فاتورة الشراء)....3- return on general(مرتجع عام دون تقييد باصل الفاتورة)
            $table->bigInteger('auto_serial');
            $table->bigInteger('DOC_NO'); // رقم الفاتورة اليدوي
            $table->date('order_date'); //تاريخ الفاتورة
            $table->bigInteger('supplier_code');
            $table->tinyInteger('is_provide')->default(0); // هل الفاتورة معتمدة أم لا ؟
            $table->bigInteger('store_id'); // المخزن المستلم للبضاعة

            $table->integer('com_code');
            $table->string('notes')->nullable();
            $table->decimal('total_cost_befor_Descount', 10, 2)->default(0); // إجمالي سعر الفاتورة قبل الخصم
            $table->tinyInteger('discount_type')->nullable(); // (1- خصم نسبة ....) (2- خصم قيمة )
            $table->decimal('discount_percent', 10, 2)->nullable()->default(0); // قيمة نسبة الخصم
            $table->decimal('discount_value', 10, 2)->default(0); // قيمة الخصم
            $table->decimal('tax_percent', 10, 2)->nullable()->default(0); // نسبة الضريبة
            $table->decimal('tax_value', 10, 2)->nullable()->default(0); // قيمة الضريبة
            $table->decimal('total_cost_items', 10, 2)->nullable()->default(0); // قيمة الضريبة
            $table->decimal('total_cost', 10, 2)->default(0); // إجمالي قيمة الفاتورة النهائية
            $table->bigInteger('account_number'); // رقم الحساب المالي لايكرر على مستوى الشركة
            $table->decimal('money_for_account', 10, 2)->default(0); // الحساب الابتدائي (الرصيد الافتتاحي للحساب) سواء كان دائن أو مدين أو متزن أول المدة لو سالب يعني دائن --لو موجب مدين -- لو 0 متزن
            $table->tinyInteger('bill_type'); // (1-كاش)(2-اجل) نوع الفاتورة
            $table->decimal('what_paid', 10, 2)->nullable()->default(0); // مثلا لو دفعت كاش فكم دفعت؟
            $table->decimal('what_remain', 10, 2)->nullable()->default(0); // مثلا لو دفعت اجل فكم المتبقي
            $table->bigInteger('treasuries_transection_id')->nullable(); // حركة الخزنة
            $table->decimal('supplier_balance_before_bill', 10, 2)->default(0); //رصيد المورد قبل الفاتورة
            $table->decimal('supplier_balance_after_bill', 10, 2)->default(0); //رصيد المورد بعد الفاتورة

            $table->string('added_by');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers_with_orders');
    }
};
