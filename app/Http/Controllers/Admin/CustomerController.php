<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer_UpdateRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Account;
use App\Models\Account_type;
use App\Models\Admin;
use App\Models\Admin_Panel_Setting;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->id;
        $data = Customer::select()->where('com_code', $com_code)->orderby('id', 'DESC')->paginate(PAGINATION_CONST);
        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }

        }

        $customers = Customer::select('id', 'name')->where('com_code', $com_code)->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        return view('admin.customers.index', compact('data', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Customer::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم العميل '."::($request->name)::".'  موجود '])->withInput();
            } else {

                // customer code
                $row = Customer::select('customer_code')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $data['customer_code'] = $row['customer_code'] + 1;
                } else {
                    $data['customer_code'] = 1;

                }

                // customer account_number
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

                $d = Customer::create([
                    'name' => $request->name,
                    'account_number' => $data['account_number'],
                    'customer_code' => $data['customer_code'],
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
                    $customer_parent_account_number = Admin_Panel_Setting::select('customer_parent_account_number')->where('com_code', $com_code)->value('customer_parent_account_number');
                    Account::create([
                        'name' => $request->name,
                        'account_number' => $data['account_number'],
                        'is_archived' => $request->active,
                        'account_types_id' => 3,
                        'parent_account_number' => $customer_parent_account_number,
                        'is_parent' => 0,
                        'start_balance_status' => $start_balance_status,
                        'start_balance' => $data['start_balance'],
                        'other_table_forignKey' => $d['customer_code'],
                        'notes' => $request->notes,
                        'date' => date('Y-m-d H:i:s'),
                        'com_code' => $com_code,
                        'added_by' => auth()->user()->id,
                    ]
                    );
                }

                return redirect()->route('admin.customers.index')->with('success', 'تم إ ضافة عميل وحساب أيضا بإسم   '."::($request->name)::".'  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $com_code = auth()->user()->id;
        $data = Customer::where(['id' => $id, 'com_code' => $com_code])->first();
        if (empty($data)) {

            return redirect()->route('admin.customers.index')->with(['error' => 'عفوا العميل المطلوب تعديله لا يوجد  ']);

        }
        
        return view('admin.customers.edit', compact( 'data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Customer_UpdateRequest $request)
    {

        try {
            $com_code = auth()->user()->com_code;
            // $account = Account::where(['id' => $id, 'com_code' => $com_code])->first();
            $customer = get_id_row(new Customer(), 'id', $id, 'com_code', $com_code); // دالة فعلتها داخل ملف الهيلبر helper.php

            if (empty($customer)) {
                return redirect()->route('admin.customers.index')->with('error', '  العميل المراد تعديله غير موجود  ')->withInput();
            }
            $checkifexist = Customer::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم العميل '."::($request->name)::".'  موجود '])->withInput();
            } else {

                $d = $customer->update([
                    'name' => $request->name,
                    'active' => $request->active,
                    'address' => $request->address,
                    'notes' => $request->notes,
                    'date' => date('Y-m-d H:i:s'),
                    'com_code' => $com_code,
                    'updated_by' => auth()->user()->id,
                ]
                );
                if ($d) {
                    $account = Account::where(['account_number' => $customer['account_number'], 'other_table_forignKey' => $customer['customer_code'], 'account_types_id' => 3, 'com_code' => $com_code])->first();
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

                return redirect()->route('admin.customers.index')->with('success', 'تم تعديل العميل  '."::($request->name)::".'  بنجاح')->withInput();

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
            $customer = Customer::where(['id' => $id, 'com_code' => $com_code])->first();
            $cus = $customer->name;
            $account = Account::where(['account_number' => $customer['account_number'], 'other_table_forignKey' => $customer['customer_code'], 'account_types_id' => 3, 'com_code' => $com_code])->first();
            if (empty($customer)) {
                return back()->with(['error' => '  العميل  المطلوب للحذف غير موجود  ']);

            }
            if ($account) {

                Account::where(['account_number' => $customer['account_number'], 'other_table_forignKey' => $customer['customer_code'], 'account_types_id' => 3, 'com_code' => $com_code])->delete();

            }
            Customer::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف العميل '."::($cus)::".'   مع الحساب المالي المتعلق به بنجاح ');

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_customers_search(Request $request)
    {
        if ($request->ajax()) {
            $search_customers_text = $request->search_customers_tex;
            $search_radio = $request->search_radio;
            // exit($account_type_sear);

            if ($search_customers_text != '') {
                if ($search_radio == 'searchby_account_number') {
                    $tex1 = 'account_number';
                    $tex2 = '=';
                    $tex3 = $search_customers_text;
                } elseif ($search_radio == 'searchby_customer_code') {
                    $tex1 = 'customer_code';
                    $tex2 = '=';
                    $tex3 = $search_customers_text;

                } else {
                    $tex1 = 'name';
                    $tex2 = 'LIKE';
                    $tex3 = "%{$search_customers_text}%";
                }
            } else {
                $tex1 = 'id';
                $tex2 = '>';
                $tex3 = '0';
            }
            $com_code = auth()->user()->come_code;
            $data = Customer::where($tex1, $tex2, $tex3)->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);

            return view('admin.customers.ajax_customers_search', compact('data'));
        }

    }
}