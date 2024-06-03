<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier_UpdateRequest;
use App\Http\Requests\SupplierRequest;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Admin_Panel_Setting;
use App\Models\Supplier;
use App\Models\Suppliers_Categorie;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->id;
        $data = Supplier::select()->where('com_code', $com_code)->orderby('id', 'DESC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {
            $info->added_by = Admin::where('id', $info->added_by)->value('name');
            $info->suppliers_categories_name = Suppliers_Categorie::where(['id' => $info->suppliers_categories_id, 'com_code' => $com_code])->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');
            }

        }

        return view('admin.suppliers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $com_code = auth()->user()->id;

        $suppliers_categories = Suppliers_Categorie::select('id', 'name')->where('com_code', $com_code)->orderby('id', 'ASC')->get();

        return view('admin.suppliers.create', compact('suppliers_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;

            $checkifexist = Supplier::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم المورد '."::($request->name)::".'  موجود '])->withInput();
            } else {

                // Supplier code
                $row = Supplier::select('supplier_code')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $data['supplier_code'] = $row['supplier_code'] + 1;
                } else {
                    $data['supplier_code'] = 1;

                }

                // supplier account_number
                $row = Account::select('account_number')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $data['account_number'] = $row['account_number'] + 1;
                } else {
                    $data['account_number'] = 1;

                }

                $start_balance_status = $request->start_balance_status;
                if ($start_balance_status == 1) {
                    // دائن
                    $data['start_balance'] = $request->start_balance * -1;
                } elseif ($start_balance_status == 2) {
                    //مدين
                    $data['start_balance'] = $request->start_balance;
                    if ($start_balance_status < 0) {
                        $data['start_balance'] = $request->start_balance * -1;

                    }

                } elseif ($start_balance_status == 3) {
                    //متزن
                    $data['start_balance'] = 0;

                } else {
                    $start_balance_status = 3;
                    $data['start_balance'] = 0;
                }

                $row = Account::select('account_number')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $data['account_number'] = $row['account_number'] + 1;
                } else {
                    $data['account_number'] = 1;

                }

                // return $data;
                $d = Supplier::create([
                    'name' => $request->name,
                    'account_number' => $data['account_number'],
                    'supplier_code' => $data['supplier_code'],
                    'suppliers_categories_id' => $request->suppliers_categories_id,
                    'active' => $request->active,
                    'start_balance_status' => $start_balance_status,
                    'start_balance' => $data['start_balance'],
                    'notes' => $request->notes,
                    'address' => $request->address,
                    'date' => date('Y-m-d H:i:s'),
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                ]
                );
                if ($d) {
                    $supplier_parent_account_number = Admin_Panel_Setting::select('supplier_parent_account_number')->where('com_code', $com_code)->value('supplier_parent_account_number');
                    Account::create([
                        'name' => $request->name,
                        'account_number' => $data['account_number'],
                        'is_archived' => $request->active,
                        'account_types_id' => 2,
                        'parent_account_number' => $supplier_parent_account_number,
                        'is_parent' => 0,
                        'start_balance_status' => $start_balance_status,
                        'start_balance' => $data['start_balance'],
                        'other_table_forignKey' => $d['supplier_code'],
                        'notes' => $request->notes,
                        'date' => date('Y-m-d H:i:s'),
                        'com_code' => $com_code,
                        'added_by' => auth()->user()->id,
                    ]
                    );
                }

                return redirect()->route('admin.suppliers.index')->with('success', 'تم إ ضافة مورد وحساب أيضا بإسم   '."::($request->name)::".'  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        view('welcome');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $com_code = auth()->user()->id;
        $data = Supplier::where(['id' => $id, 'com_code' => $com_code])->first();
        if (empty($data)) {

            return redirect()->route('admin.suppliers.index')->with(['error' => 'عفوا المورد المطلوب تعديله لا يوجد  ']);

        }
        $suppliers_categories = Suppliers_Categorie::select('id', 'name')->where(['com_code' => $com_code])->get();

        return view('admin.suppliers.edit', compact('suppliers_categories', 'data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Supplier_UpdateRequest $request)
    {

        try {
            $com_code = auth()->user()->com_code;
            // $account = Account::where(['id' => $id, 'com_code' => $com_code])->first();
            $supplier = get_id_row(new Supplier(), 'id', $id, 'com_code', $com_code); // دالة فعلتها داخل ملف الهيلبر helper.php

            if (empty($supplier)) {
                return redirect()->route('admin.suppliers.index')->with('error', '  المورد المراد تعديله غير موجود  ')->withInput();
            }
            $checkifexist = Supplier::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم المورد '."::($request->name)::".'  موجود '])->withInput();
            } else {

                $d = $supplier->update([
                    'name' => $request->name,
                    'suppliers_categories_id' => $request->suppliers_categories_id,
                    'active' => $request->active,
                    'address' => $request->address,
                    'notes' => $request->notes,
                    'date' => date('Y-m-d H:i:s'),
                    'com_code' => $com_code,
                    'updated_by' => auth()->user()->id,
                ]
                );
                if ($d) {
                    $account = Account::where(['account_number' => $supplier['account_number'], 'other_table_forignKey' => $supplier['supplier_code'], 'account_types_id' => 2, 'com_code' => $com_code])->first();
                    $account->update([
                        'name' => $request->name,
                        'is_archived' => $request->active,
                        'notes' => $request->notes,
                        'date' => date('Y-m-d H:i:s'),
                        'com_code' => $com_code,
                        'updated_by' => auth()->user()->id,
                    ]
                    );
                }

                return redirect()->route('admin.suppliers.index')->with('success', 'تم تعديل المورد   '."::($request->name)::".' مع الحساب المتعلق به بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $supplier = Supplier::where(['id' => $id, 'com_code' => $com_code])->first();
            $cus = $supplier->name;
            if (empty($supplier)) {
                return back()->with(['error' => '  المورد  المطلوب للحذف غير موجود  ']);

            }
            $account = Account::where(['account_number' => $supplier['account_number'], 'other_table_forignKey' => $supplier['supplier_code'], 'account_types_id' => 2, 'com_code' => $com_code])->first();
            if ($account) {

                Account::where(['account_number' => $supplier['account_number'], 'other_table_forignKey' => $supplier['supplier_code'], 'account_types_id' => 2, 'com_code' => $com_code])->delete();

            }
            Supplier::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف المورد '."::($cus)::".'   مع الحساب المالي المتعلق به بنجاح ');

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_suppliers_search(Request $request)
    {
        if ($request->ajax()) {
            $search_suppliers_text = $request->search_suppliers_tex;
            $search_radio = $request->search_radio;
            // exit($account_type_sear);

            if ($search_suppliers_text != '') {
                if ($search_radio == 'searchby_account_number') {
                    $tex1 = 'account_number';
                    $tex2 = '=';
                    $tex3 = $search_suppliers_text;
                } elseif ($search_radio == 'searchby_suppliers_code') {
                    $tex1 = 'supplier_code';
                    $tex2 = '=';
                    $tex3 = $search_suppliers_text;

                } else {
                    $tex1 = 'name';
                    $tex2 = 'LIKE';
                    $tex3 = "%{$search_suppliers_text}%";
                }
            } else {
                $tex1 = 'id';
                $tex2 = '>';
                $tex3 = '0';
            }
            $com_code = auth()->user()->come_code;
            $data = Supplier::where($tex1, $tex2, $tex3)->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);

            return view('admin.suppliers.ajax_suppliers_search', compact('data'));
        }
    }
}
