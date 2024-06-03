<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Suppliers_with_ordeRequest;
use App\Models\Admin;
use App\Models\Inv_item_card;
use App\Models\Inv_Uoms;
use App\Models\Stores;
use App\Models\Supplier;
use App\Models\Suppliers_with_order;
use App\Models\Suppliers_with_order_details;
use Illuminate\Http\Request;

class Suppliers_with_orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Suppliers_with_order::select()->where('com_code', $com_code)->orderby('id', 'DESC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');
            $info->supplier_name = Supplier::where(['supplier_code' => $info->supplier_code, 'com_code' => $com_code])->value('name');
            $info['store_name'] = Stores::where(['id' => $info['store_id'], 'com_code' => $com_code])->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.suppliers_with_order.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $suppliers = Supplier::select('name', 'supplier_code')->where(['com_code' => $com_code, 'active' => 1])->get();
        $stores = Stores::select('name', 'id')->where(['com_code' => $com_code, 'active' => 1])->get();

        return view('admin.suppliers_with_order.create', compact('suppliers', 'stores'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Suppliers_with_ordeRequest $request)
    {
        $com_code = auth()->user()->com_code;

        try {
            $supplier_account_number = Supplier::select('account_number', 'name')->where(['supplier_code' => $request->supplier_code, 'com_code' => $com_code])->first();

            if (empty($supplier_account_number)) {
                return back()->with(['error' => 'عفوا لايوجد رقم حساب لهذا المورد  '])->withInput();

            } else {

                $row = Suppliers_with_order::select('auto_serial')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $row_insert['auto_serial'] = $row['auto_serial'] + 1;

                } else {
                    $row_insert['auto_serial'] = 1;

                }

                $DOC_num = Suppliers_with_order::select('id')->where(['DOC_NO' => $request->DOC_NO, 'account_number' => $supplier_account_number['account_number'], 'com_code' => $com_code])->orderBy('id', 'DESC')->first();
                if (! empty($DOC_num)) {
                    return back()->with(['error' => '  رقم الفاتورة هذا موجود لدى نفس المورد  '])->withInput();

                } else {
                    $row_insert['DOC_NO'] = $request->DOC_NO;

                }

                $row_insert['order_date'] = $request->order_date;
                $row_insert['supplier_code'] = $request->supplier_code;
                $row_insert['order_type'] = 1;

                $row_insert['bill_type'] = $request->bill_type;
                $row_insert['account_number'] = $supplier_account_number['account_number'];
                $row_insert['is_provide'] = $request->is_provide;
                $row_insert['store_id'] = $request->store_id;

                $row_insert['com_code'] = auth()->user()->com_code;
                $row_insert['added_by'] = auth()->user()->id;
                Suppliers_with_order::create($row_insert);

                return redirect()->route('admin.suppliers_with_order.index')->with('success', 'تم اضافة الفاتورة رقم   '."::($request->DOC_NO)::".'   للمورد '."::($supplier_account_number[name])::".' بنجاح');

            }

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {//تعديل الفاتورة الأب
        $com_code = auth()->user()->com_code;

        $data = Suppliers_with_order::where(['id' => $id, 'com_code' => $com_code])->first();
        if (empty($data)) {
            return redirect(route('admin.suppliers_with_order.index'))->with(['error' => 'عفوا لاتوجد بيانات فاتورة بهذا الرقم لتعديلها  '])->withInput();

        } else {
            if ($data['is_provide'] == 1) {
                return redirect(route('admin.suppliers_with_order.index'))->with(['error' => 'عفوا غير مسموح بتعديل فاتورة معتمدة(مؤرشفة)   '])->withInput();

            } else {

                $suppliers = Supplier::select('name', 'supplier_code')->where(['com_code' => $com_code, 'active' => 1])->get();
                $stores = Stores::select('name', 'id')->where(['com_code' => $com_code, 'active' => 1])->get();

                return view('admin.suppliers_with_order.edit', compact('data', 'stores', 'suppliers'));

            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Suppliers_with_ordeRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Suppliers_with_order::select('*')->where(['id' => $id, 'order_type' => 1, 'com_code' => $com_code])->first();
            if (empty($data)) {
                return back()->with(['error' => 'عفوا لاتوجد بيانات فاتورة بهذا الرقم لتعديلها  '])->withInput();
            } else {

                $supplier_account_number = Supplier::select('account_number', 'name')->where(['supplier_code' => $request->supplier_code, 'com_code' => $com_code])->first();

                if (empty($supplier_account_number)) {
                    return back()->with(['error' => 'عفوا لايوجد رقم حساب لهذا المورد  '])->withInput();

                } else {

                    $DOC_num = Suppliers_with_order::where(['DOC_NO' => $request->DOC_NO, 'supplier_code' => $request->supplier_code, 'com_code' => $com_code])->where('id', '!=', $id)->first();
                    if (! empty($DOC_num)) {
                        return back()->with(['error' => '  رقم الفاتورة هذا موجود لدى نفس المورد  '])->withInput();

                    } else {
                        $row = Suppliers_with_order::select('auto_serial')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                        if (! empty($row)) {
                            $data['auto_serial'] = $row['auto_serial'] + 1;

                        } else {
                            $data['auto_serial'] = 1;

                        }
                        $data['DOC_NO'] = $request->DOC_NO;
                        $data['order_date'] = $request->order_date;
                        $data['supplier_code'] = $request->supplier_code;
                        $data['order_type'] = 1;

                        $data['bill_type'] = $request->bill_type;
                        $data['is_provide'] = $request->is_provide;
                        $data['store_id'] = $request->store_id;
                        $data['account_number'] = $supplier_account_number['account_number'];

                        $data['com_code'] = auth()->user()->com_code;
                        $data['updated_by'] = auth()->user()->id;
                        $done = $data->save();
                        if ($done) {

                            return redirect()->route('admin.suppliers_with_order.index')->with('success', 'تم تعديل الفاتورة رقم   '."::($id)::".' بنجاح');

                        } else {
                            return back()->with(['error' => 'عفوا لم يتم التعديل   '])->withInput();

                        }
                    }
                }

            }

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function details($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Suppliers_with_order::select()->where(['id' => $id, 'com_code' => $com_code, 'order_type' => 1])->first();
            if (empty($data)) {
                return back()->with(['error' => '  الفاتورة المطلوبة غير موجودة  ']);

            } else {
                $data['supplier_name'] = Supplier::where(['supplier_code' => $data['supplier_code'], 'com_code' => $com_code])->value('name');
                $data['store_name'] = Stores::where(['id' => $data['store_id'], 'com_code' => $com_code])->value('name');

                $data->added_by = Admin::where('id', $data->added_by)->value('name');
                if ($data->updated_by > 0 and $data->updated_by != null) {
                    $data->updated_by = Admin::where('id', $data->updated_by)->value('name');
                }
                $details = Suppliers_with_order_details::select()->where(['suppliers_with_orders_auto_serial' => $data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);
                if (empty($details)) {
                    return back()->with(['error' => ' تفاصيل الفاتورة المطلوبة غير موجودة  ']);
                    $details = [];
                }

                foreach ($details as $info) {

                    $info->added_by = Admin::where('id', $info->added_by)->value('name');
                    $info->item_card_name = Inv_item_card::where(['item_code' => $info->item_code, 'com_code' => $com_code])->value('name');
                    $info->uom_name = Inv_Uoms::where(['id' => $info->uom_id])->value('name');

                    if ($info->updated_by > 0 and $info->updated_by != null) {
                        $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                    }
                }
                // if bill still open
                if ($data['is_provide'] == 0) {
                    $item_cards = Inv_item_card::select('item_code', 'barcode', 'name', 'item_type', 'uom_id')->where(['active' => 1, 'com_code' => $com_code])->orderby('id', 'DESC')->get();
                    $inv_uoms = Inv_Uoms::select('id', 'name', 'is_master')->where(['active' => 1, 'com_code' => $com_code])->orderby('id', 'DESC')->get();

                } else {
                    $item_cards = [];
                    $inv_uoms = [];
                }

                return view('admin.suppliers_with_order.details', compact('data', 'details', 'item_cards', 'inv_uoms'));
            }

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }

    }

    public function ajax_get_uom(Request $request)
    {
        if ($request->ajax()) {

            $item_cod = $request->item_card_uoms;
            $com_code = auth()->user()->com_code;
            $get_item_cards = Inv_item_card::select('does_has_retailUnit', 'retail_uom_id', 'uom_id', 'item_code')->where(['item_code' => $item_cod, 'com_code' => $com_code])->first();

            if (! empty($get_item_cards)) {

                if ($get_item_cards['does_has_retailUnit'] == 1) {

                    $get_item_cards['parent_uomName'] = Inv_Uoms::where(['id' => $get_item_cards['uom_id']])->value('name');
                    $get_item_cards['Retail_uomName'] = Inv_Uoms::where(['id' => $get_item_cards['retail_uom_id']])->value('name');

                } else {
                    $get_item_cards['parent_uomName'] = Inv_Uoms::where(['id' => $get_item_cards['uom_id']])->value('name');
                    $get_item_cards['Retail_uomName'] = '';
                }
            } else {
                // $get_item_cards = [];
            }

            return view('admin.suppliers_with_order.get_item_uoms_Ajax', compact('get_item_cards'));

        }
    }

    public function ajax_add_details_url(Request $request)
    {

        if ($request->ajax()) {

            $com_code = auth()->user()->com_code;
            $suppliers_with_ordersData = Suppliers_with_order::select()->where(['auto_serial' => $request->autoserialParent, 'order_type' => 1, 'com_code' => $com_code])->first();

            if (! empty($suppliers_with_ordersData)) {

                if ($suppliers_with_ordersData['is_provide'] == 0) {
                    $data_insert['suppliers_with_orders_auto_serial'] = $request->autoserialParent;
                    $data_insert['order_type'] = 1;
                    $data_insert['item_code'] = $request->item_code_Add;
                    $data_insert['deliver_quantity'] = $request->quentity_ADD;
                    $data_insert['unit_price'] = $request->price_ADD;
                    $data_insert['uom_id'] = $request->uom_id_Add;
                    $data_insert['isparentuom'] = $request->isparentuom;

                    $data_insert['order_date'] = $suppliers_with_ordersData['order_date'];

                    if ($request->type == 2) {
                        $data_insert['production_date'] = $request->production_date;
                        $data_insert['expire_date'] = $request->expire_date;

                    }
                    $data_insert['item_card_type'] = $request->type;
                    $data_insert['total_price'] = $request->Total_Add;

                    $data_insert['com_code'] = auth()->user()->com_code;
                    $data_insert['added_by'] = auth()->user()->id;

                    $flag = Suppliers_with_order_details::create($data_insert);

                    if ($flag) {
                        $total_details_sum = Suppliers_with_order_details::where(['suppliers_with_orders_auto_serial' => $suppliers_with_ordersData['auto_serial'], 'order_type' => 1, 'com_code' => $com_code])->sum('total_price');
                        $suppliers_with_ordersData['total_cost_items'] = $total_details_sum;
                        $suppliers_with_ordersData['total_cost_befor_Descount'] = $total_details_sum + $suppliers_with_ordersData['tax_value'];
                        $suppliers_with_ordersData['total_cost'] = $suppliers_with_ordersData['total_cost_befor_Descount'] - $suppliers_with_ordersData['discount_value'];
                        $suppliers_with_ordersData['updated_by'] = auth()->user()->id;

                        $done = $suppliers_with_ordersData->save();
                        if (! $done) {
                            return json_encode(' عفوا لم يعدل الاجمالي في الفاتورةالأب  !!');
                        }

                        echo json_encode('تمت الإضافة بنحاح');
                    }
                }

            }
        }

    }

    public function reload_parent_bill_Ajax(Request $request)
    {
        if ($request->ajax()) {
            $Parent_id = $request->Parent_id;
            $autoserialParent = $request->autoserialParent;
            $com_code = auth()->user()->com_code;
            $data = Suppliers_with_order::select()->where(['id' => $Parent_id, 'com_code' => $com_code, 'order_type' => 1])->first();
            if (! empty($data)) {
                $data['supplier_name'] = Supplier::where(['supplier_code' => $data['supplier_code'], 'com_code' => $com_code])->value('name');
                $data->added_by = Admin::where('id', $data->added_by)->value('name');
                if ($data->updated_by > 0 and $data->updated_by != null) {
                    $data->updated_by = Admin::where('id', $data->updated_by)->value('name');
                }
            }

            return view('admin.suppliers_with_order.reload_parent_bill_Ajax', compact('data'));
        }
    }

    public function reload_details_with_Ajax(Request $request)
    {

        if ($request->ajax()) {

            $autoserialParent = $request->autoserialParent;
            $com_code = auth()->user()->com_code;
            $data = Suppliers_with_order::select('is_provide')->where(['auto_serial' => $autoserialParent, 'order_type' => 1, 'com_code' => $com_code])->first();
            if (! empty($data)) {
                $details = Suppliers_with_order_details::select()->where(['suppliers_with_orders_auto_serial' => $autoserialParent, 'order_type' => 1, 'com_code' => $com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);
                if (! empty($details)) {

                    foreach ($details as $info) {

                        $info->added_by = Admin::where('id', $info->added_by)->value('name');
                        $info->item_card_name = Inv_item_card::where(['item_code' => $info->item_code, 'com_code' => $com_code])->value('name');
                        $info->uom_name = Inv_Uoms::where(['id' => $info->uom_id])->value('name');

                        if ($info->updated_by > 0 and $info->updated_by != null) {
                            $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                        }
                    }
                }
            }

            return view('admin.suppliers_with_order.reload_details_with_Ajax', compact('data', 'details'));

        }

    }

    public function ajax_Edit_details_url(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $suppliers_with_orders_auto_serial = $request->autoserialParent;
            $com_code = auth()->user()->com_code;
            $details = Suppliers_with_order_details::select()->where(['id' => $id, 'suppliers_with_orders_auto_serial' => $suppliers_with_orders_auto_serial, 'order_type' => 1, 'com_code' => $com_code])->first();

            if (! empty($details)) {

                $details['deliver_quantity'] = $request->deliver_quantity;
                $details['deliver_quantity'] = $request->deliver_quantity;
                $details['uom_id'] = $request->uom_id;
                $details['isparentuom'] = $request->isparentuom;
                $details['unit_price'] = $request->unit_price;
                $details['total_price'] = $request->total_price;
                $details['order_date'] = date('Y-m-d');
                $details['item_code'] = $request->item_code_edit;
                $details['item_card_type'] = $request->type;
                if ($request->type == 2) {
                    $details['production_date'] = $request->production_date_edit;
                    $details['expire_date'] = $request->expire_date_edit;
                }

                $details['added_by'] = auth()->user()->id;
                $test = $details->save();

                $suppliers_with_ordersData = Suppliers_with_order::select()->where(['auto_serial' => $request->autoserialParent, 'order_type' => 1, 'com_code' => $com_code])->first();
                if ($test) {
                    $total_details_sum = Suppliers_with_order_details::where(['suppliers_with_orders_auto_serial' => $request->autoserialParent, 'order_type' => 1, 'com_code' => $com_code])->sum('total_price');
                    if ($suppliers_with_ordersData) {
                        $suppliers_with_ordersData['total_cost_items'] = $total_details_sum;
                        $suppliers_with_ordersData['total_cost_befor_Descount'] = $total_details_sum + $suppliers_with_ordersData['tax_value'];
                        $suppliers_with_ordersData['total_cost'] = $suppliers_with_ordersData['total_cost_befor_Descount'] - $suppliers_with_ordersData['discount_value'];
                        $suppliers_with_ordersData['updated_by'] = auth()->user()->id;

                        $done = $suppliers_with_ordersData->save();
                        if (! $done) {
                            return json_encode(' عفوا لم يعدل الاجمالي في الفاتورةالأب  !!');
                        }

                        echo json_encode('تم التعديل بنحاح');
                    } else {
                        return json_encode(' عفوا بيانات الفاتورة الأب غير موجودة  !!');
                    }

                } else {
                    return json_encode(' عفوا لم تعدل بيانات الصنف المطلوب    !!');
                }

            } else {
                return json_encode('No Item To Update');

            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers_with_order $suppliers_with_order)
    {
        //
    }

    public function ajax_suppliers_with_order_Etmd_url(Request $request)
    {
        if ($request->ajax()) {
            $Etmd_id = $request->etmd;

            // return $Etmd_id;
            $com_code = auth()->user()->com_code;
            $data = Suppliers_with_order::select('*')->where(['id' => $Etmd_id, 'order_type' => 1, 'com_code' => $com_code])->first();

            // return $data;
            if ($data->is_provide = 0) {
                $data->is_provide = 1;
            } else {
                $data->is_provide = 0;
            }
            $don = $data->save();
            if ($don) {
                return redirect()->route('admin.suppliers_with_order.index')->with('success', 'تم تعديل الفاتورة رقم '.($Etmd_id).' بنجاح');

            } else {
                return redirect()->route('admin.suppliers_with_order.index')->with(['error' => 'عفوا لم يتم التعديل   ']);

            }

            // echo json_encode($data);
        }
    }
}
