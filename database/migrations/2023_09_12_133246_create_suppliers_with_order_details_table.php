<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. تفاصيل أصناف فاتورة المشتريات والمرتجعات
     */
    public function up(): void
    {
        Schema::create('suppliers_with_order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('suppliers_with_orders_auto_serial');
            $table->tinyInteger('order_type'); //1- bershase(مشتريات).....2- retuern on same bill(مرتجع على أصل فاتورة الشراء)....3- return on general(مرتجع عام دون تقييد باصل الفاتورة)
            $table->integer('com_code');
            $table->decimal('deliver_quantity', 10, 2); //كمية مستلمة
            $table->integer('uom_id'); // كود الوحدة
            $table->tinyInteger('isparentuom'); //  وحدة أب1 أو تجزئة0
            $table->decimal('unit_price', 10, 2); //سعر الوحدة
            $table->decimal('total_price', 10, 2); //الاجمالي
            $table->date('order_date'); //تاريخ الفاتورة
            $table->date('production_date')->nullable(); //تاريخ الانتاج
            $table->date('expire_date')->nullable(); //تاريخ الانتهاء

            $table->bigInteger('item_code'); //-- كود الصنف هذا اللي بنعتمد عليه في الشركة أفضل من الايدي
            $table->tinyInteger('item_card_type'); //--نوع الصنف .. هل مخزني1 أم استهلاكي2 أم عهدة3
            $table->bigInteger('batch_id')->nullable(); //-- لكل صنف عدة دفعات في المخزن مثلا في دفعة بتاريخ انتاج كذا وكمية كذا وفي دفعة جديدة
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
        Schema::dropIfExists('suppliers_with_order_details');
    }
};
