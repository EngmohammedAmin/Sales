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
        Schema::create('inv_item_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_code'); //-- كود الصنف هذا اللي بنعتمد عليه في الشركة أفضل من الايدي
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->tinyInteger('item_type'); //-- مخزني1(دائم الصلاحية) ---استهلاكي2(له تاريخ صلاحية ) --عهدة3
            $table->integer('item_card_categories_id');
            $table->integer('parent_inv_item_card_id')->nullable(); //  --- كود الصنف الأب له من نفس هذا الجدول-----
            $table->tinyInteger('does_has_retailUnit'); // ----هل يمتلك وحدة تجزئة؟
            $table->integer('retail_uom_id')->nullable(); // --- كود وحدة قياس التجزئة --
            $table->integer('uom_id'); // ---كود وحدة قياس الأب -------
            $table->decimal('retail_uom_quentityToParent')->nullable(); // -- نسبة وحدة التجزئة بالنسبة للأب ---
            $table->decimal('price', 10, 2); //   السعر القطاعي للوحدة الأساسية الأب
            $table->decimal('half_gomla_price', 10, 2); //   سعر نصف جملة قطاعي للوحدة الأساسية الأب
            $table->decimal('gomla_price', 10, 2); //   سعر الجملة القطاعي للوحدة الأساسية الأب
            $table->decimal('price_retail', 10, 2)->nullable(); //   السعر القطاعي لوحدة التجزئة
            $table->decimal('half_gomla_price_retail', 10, 2)->nullable(); //   السعر القطاعي لنصف جملة مع التجزئة
            $table->decimal('gomla_price_retail', 10, 2)->nullable(); //   سعر الجملة بوحدة قياس التجزئة
            $table->decimal('cost_price', 10, 2); // شراء جملة الأب
            $table->decimal('cost_price_retail', 10, 2)->nullable(); //شراء التجزئة
            $table->tinyInteger('has_fixed_price'); // هل للصنف سعر ثابت للفواتير أم قابل للتغيير بالفواتير؟
            $table->decimal('QUENTITY', 10, 3)->nullable(); //الكمية بالوحدة الأب
            $table->decimal('QUENTITY_Retail', 10, 3)->nullable(); //كمية التجزئة المتبقية من الوحدة الأب في حالة وجود وحدة تجزئة للصنف
            $table->decimal('QUENTITY_All_Retail', 10, 3)->nullable(); //كل الكمية محولة بوحدة التجزئة

            $table->string('added_by');
            $table->string('updated_by')->nullable();
            $table->string('com_code');
            $table->date('date'); /*  من اجل البحث عن طريقه*/
            $table->tinyInteger('active')->default(1);
            $table->string('item_img')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_cards');
    }
};
