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
        Schema::create('admin__panel__settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('photo');
            $table->integer('active')->default(0);
            $table->string('general_alert');
            $table->string('address');
            $table->string('phone');
            $table->bigInteger('customer_parent_account_number');
            $table->bigInteger('supplier_parent_account_number');
            $table->string('added_by');
            $table->string('updated_by');
            $table->string('com_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin__panel__settings');
    }
};
