<?php

use App\Http\Controllers\Admin\Account_typeController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminPanelSettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Inv_item_cardController;
use App\Http\Controllers\Admin\Inv_UomsController;
use App\Http\Controllers\Admin\Item_Card_CategoriesController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Sales_material_typesController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\Suppliers_CategorieController;
use App\Http\Controllers\Admin\Suppliers_with_orderController;
use App\Http\Controllers\Admin\TreasuriesController;
use App\Models\Suppliers_with_order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth::routes();

Route::get('/', function () {
    return redirect()->route('admin.login');
});
define('PAGINATION_CONST', 5);
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', [LoginController::class, 'show_login_view'])->name('show_login_view');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');

});


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    /*  روابط الضبط العام */
    Route::get('/adminpanelsetting/index', [AdminPanelSettingController::class, 'index'])->name('admin.adminpanelsetting.index');
    Route::get('/adminpanelsetting/edit', [AdminPanelSettingController::class, 'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('/adminpanelsetting/update', [AdminPanelSettingController::class, 'update'])->name('admin.adminpanelsetting.update');
    Route::post('/adminpanelsetting/destroy', [AdminPanelSettingController::class, 'destroy'])->name('admin.adminpanelsetting.destroy');

    /*  روابط الخزانة  */
    Route::get('/treasuries/index', [TreasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/treasuries/edit/{id}', [TreasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update', [TreasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::get('/treasuries/create', [TreasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store', [TreasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::post('/treasuries/delete_treasuries_delivary', [TreasuriesController::class, 'delete_treasuries_delivary'])->name('admin.treasuries.delete_treasuries_delivary');
    Route::post('/treasuries/ajax_search', [TreasuriesController::class, 'ajax_search'])->name('admin.treasuries.ajax_search');
    Route::get('/treasuries/details/{id}', [TreasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::GET('/treasuries/addDelivary/{id}', [TreasuriesController::class, 'addDelivary'])->name('admin.treasuries.addDelivary');
    Route::post('/treasuries/storeDelivary/{id}', [TreasuriesController::class, 'storeDelivary'])->name('admin.treasuries.store_treasuries_delivary');
    Route::get('/treasuries/delete_treasuries/{id}', [TreasuriesController::class, 'delete_treasuries'])->name('admin.treasuries.delete_treasuries');

    /*  روابط فئات الفواتير Sales_material_types*/

    Route::get('/Sales_material_types/index', [Sales_material_typesController::class, 'index'])->name('admin.Sales_material_types.index');
    Route::get('/Sales_material_types/edit/{id}', [Sales_material_typesController::class, 'edit'])->name('admin.Sales_material_types.edit');
    Route::post('/Sales_material_types/update', [Sales_material_typesController::class, 'update'])->name('admin.Sales_material_types.update');
    Route::get('/Sales_material_types/create', [Sales_material_typesController::class, 'create'])->name('admin.Sales_material_types.create');
    Route::post('/Sales_material_types/store', [Sales_material_typesController::class, 'store'])->name('admin.Sales_material_types.store');
    Route::post('/Sales_material_types/ajax_m_search', [Sales_material_typesController::class, 'ajax_m_search'])->name('admin.Sales_material_types.ajax_m_search');
    Route::post('/Sales_material_types/delete/{id}', [Sales_material_typesController::class, 'delete'])->name('admin.Sales_material_types.delete');

    /*  روابط  المخازن Stores*/

    Route::get('/stores/index', [StoresController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/edit/{id}', [StoresController::class, 'edit'])->name('admin.stores.edit');
    Route::post('/stores/update', [StoresController::class, 'update'])->name('admin.stores.update');
    Route::get('/stores/create', [StoresController::class, 'create'])->name('admin.stores.create');
    Route::post('/stores/store', [StoresController::class, 'store'])->name('admin.stores.store');
    Route::post('/stores/ajax_stores_search', [StoresController::class, 'ajax_stores_search'])->name('admin.stores.ajax_stores_search');
    Route::post('/stores/delete/{id}', [StoresController::class, 'delete'])->name('admin.stores.delete');

    /*  روابط  الاصناف (الوحدات) جملة وتجزئة inv_uoms*/

    Route::get('/inv_uoms/index', [Inv_UomsController::class, 'index'])->name('admin.inv_uoms.index');
    Route::get('/inv_uoms/edit/{id}', [Inv_UomsController::class, 'edit'])->name('admin.inv_uoms.edit');
    Route::post('/inv_uoms/update', [Inv_UomsController::class, 'update'])->name('admin.inv_uoms.update');
    Route::get('/inv_uoms/create', [Inv_UomsController::class, 'create'])->name('admin.inv_uoms.create');
    Route::post('/inv_uoms/store', [Inv_UomsController::class, 'store'])->name('admin.inv_uoms.store');
    Route::post('/inv_uoms/delete/{id}', [Inv_UomsController::class, 'delete'])->name('admin.inv_uoms.delete');
    Route::post('/inv_uoms/ajax_inv_uoms_search', [Inv_UomsController::class, 'ajax_inv_uoms_search'])->name('admin.inv_uoms.ajax_inv_uoms_search');

    /*  روابط  فئات الأصناف   inv_uoms*/

    Route::resource('/item_card_cats', Item_Card_CategoriesController::class)->withTrashed();

    Route::post('/item_card_cats/ajax_item_card_cats_search', [Item_Card_CategoriesController::class, 'ajax_item_card_cats_search'])->name('item_card_cats.ajax_item_card_cats_search');

    /*  روابط بيانات الاصناف (الوحدات) جملة وتجزئة وغيرها Item_Card*/

    Route::get('/inv_item_card/index', [Inv_item_cardController::class, 'index'])->name('inv_item_card.index');
    Route::get('/inv_item_card/edit/{id}', [Inv_item_cardController::class, 'edit'])->name('inv_item_card.edit');
    Route::post('/inv_item_card/update/{id}', [Inv_item_cardController::class, 'update'])->name('inv_item_card.update');
    Route::get('/inv_item_card/create', [Inv_item_cardController::class, 'create'])->name('inv_item_card.create');
    Route::post('/inv_item_card/store', [Inv_item_cardController::class, 'store'])->name('inv_item_card.store');
    Route::post('/inv_item_card/destroy/{id}', [Inv_item_cardController::class, 'destroy'])->name('inv_item_card.destroy');
    Route::post('/inv_item_card/ajax_inv_item_card_search', [Inv_item_cardController::class, 'ajax_inv_item_card_search'])->name('inv_item_card.ajax_inv_item_card_search');
    Route::get('/inv_item_card/show/{id}', [Inv_item_cardController::class, 'show'])->name('inv_item_card.show');

    /*  جدول أنواع الحسابات Account_types*/
    Route::get('/account_type/index', [Account_typeController::class, 'index'])->name('admin.account_type.index');
    Route::get('/account_type/edit/{id}', [Account_typeController::class, 'edit'])->name('admin.account_type.edit');
    Route::post('/account_type/update/{id}', [Account_typeController::class, 'update'])->name('admin.account_type.update');
    Route::get('/account_type/create', [Account_typeController::class, 'create'])->name('admin.account_type.create');
    Route::post('/account_type/store', [Account_typeController::class, 'store'])->name('admin.account_type.store');
    Route::post('/account_type/destroy/{id}', [Account_typeController::class, 'destroy'])->name('admin.account_type.destroy');
    Route::post('/account_type/ajax_acc_type_search', [Account_typeController::class, 'ajax_acc_type_search'])->name('admin.account_type.ajax_acc_type_search');
    Route::get('/account_type/show/{id}', [Account_typeController::class, 'show'])->name('admin.account_type.show');

    /*  جدول  الحسابات Account*/
    Route::get('/accounts/index', [AccountController::class, 'index'])->name('admin.account.index');
    Route::get('/accounts/edit/{id}', [AccountController::class, 'edit'])->name('admin.account.edit');
    Route::post('/accounts/update/{id}', [AccountController::class, 'update'])->name('admin.account.update');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('admin.account.create');
    Route::post('/accounts/store', [AccountController::class, 'store'])->name('admin.account.store');
    Route::get('/accounts/destroy/{id}', [AccountController::class, 'destroy'])->name('admin.account.destroy');
    Route::post('/accounts/ajax_account_search', [AccountController::class, 'ajax_account_search'])->name('admin.account.ajax_account_search');
    Route::get('/accounts/show/{id}', [AccountController::class, 'show'])->name('admin.account.show');

    /*  جدول  العملاء Customers*/
    Route::get('/customers/index', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/edit/{id}', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::post('/customers/update/{id}', [CustomerController::class, 'update'])->name('admin.customers.update');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/customers/store', [CustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    Route::post('/customers/ajax_customers_search', [CustomerController::class, 'ajax_customers_search'])->name('admin.customers.ajax_customers_search');
    Route::get('/customers/show/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');

    /*  روابط فئات الموردين Suppliers_Categories*/

    Route::get('/suppliers_categories/index', [Suppliers_CategorieController::class, 'index'])->name('admin.suppliers_categories.index');
    Route::get('/suppliers_categories/edit/{id}', [Suppliers_CategorieController::class, 'edit'])->name('admin.suppliers_categories.edit');
    Route::post('/suppliers_categories/update/{id}', [Suppliers_CategorieController::class, 'update'])->name('admin.suppliers_categories.update');
    Route::get('/suppliers_categories/create', [Suppliers_CategorieController::class, 'create'])->name('admin.suppliers_categories.create');
    Route::post('/suppliers_categories/store', [Suppliers_CategorieController::class, 'store'])->name('admin.suppliers_categories.store');
    Route::post('/suppliers_categories/ajax_m_search', [Suppliers_CategorieController::class, 'ajax_m_search'])->name('admin.suppliers_categories.ajax_m_search');
    Route::post('/suppliers_categories/delete/{id}', [Suppliers_CategorieController::class, 'delete'])->name('admin.suppliers_categories.delete');

    /*  جدول  الموردين supliers*/
    Route::get('/suppliers/index', [SupplierController::class, 'index'])->name('admin.suppliers.index');
    Route::get('/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('admin.suppliers.edit');
    Route::post('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('admin.suppliers.update');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('admin.suppliers.create');
    Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('admin.suppliers.store');
    Route::get('/suppliers/destroy/{id}', [SupplierController::class, 'destroy'])->name('admin.suppliers.destroy');
    Route::post('/suppliers/ajax_supliers_search', [SupplierController::class, 'ajax_suppliers_search'])->name('admin.suppliers.ajax_suppliers_search');
    Route::get('/suppliers/show/', [SupplierController::class, 'show'])->name('admin.suppliers.show');

    /*  روابط الفواتير      مشتريات ومرتجعات (suppliers_with_order)*/

    Route::get('/supliers_with_order/index', [Suppliers_with_orderController::class, 'index'])->name('admin.suppliers_with_order.index');
    Route::get('/supliers_with_order/edit/{id}', [Suppliers_with_orderController::class, 'edit'])->name('admin.suppliers_with_order.edit');
    Route::post('/supliers_with_order/update/{id}', [Suppliers_with_orderController::class, 'update'])->name('admin.suppliers_with_order.update');
    Route::get('/supliers_with_order/create', [Suppliers_with_orderController::class, 'create'])->name('admin.suppliers_with_order.create');
    Route::post('/supliers_with_order/store', [Suppliers_with_orderController::class, 'store'])->name('admin.suppliers_with_order.store');
    Route::get('/supliers_with_order/destroy/{id}', [Suppliers_with_orderController::class, 'destroy'])->name('admin.suppliers_with_order.destroy');
    Route::post('/supliers_with_order/ajax_suppliers_with_order_search', [Suppliers_with_orderController::class, 'ajax_suppliers_with_order_search'])->name('admin.suppliers_with_order.ajax_suppliers_with_order_search');
    Route::get('/supliers_with_order/details/{id}', [Suppliers_with_orderController::class, 'details'])->name('admin.suppliers_with_order.details');
    Route::get('/supliers_with_order/show/{id}', [Suppliers_with_orderController::class, 'show'])->name('admin.suppliers_with_order.show');

    Route::post('/ajax_get_uom', [Suppliers_with_orderController::class, 'ajax_get_uom'])->name('ajax_get_uom');
    Route::post('/supliers_with_order/ajax_add_details_url', [Suppliers_with_orderController::class, 'ajax_add_details_url'])->name('ajax_add_details_url');
    Route::post('/supliers_with_order/reload_details_with_Ajax', [Suppliers_with_orderController::class, 'reload_details_with_Ajax'])->name('reload_details_with_Ajax');
    Route::post('/supliers_with_order/reload_parent_bill_Ajax', [Suppliers_with_orderController::class, 'reload_parent_bill_Ajax'])->name('reload_parent_bill_Ajax');
    Route::post('/supliers_with_order/ajax_Edit_details_url', [Suppliers_with_orderController::class, 'ajax_Edit_details_url'])->name('ajax_Edit_details_url');

    Route::post('/supliers_with_order/ajax_suppliers_with_order_Etmd_url', [Suppliers_with_orderController::class, 'ajax_suppliers_with_order_Etmd_url'])->name('ajax_supplierswithorder_Etmd_url');

});