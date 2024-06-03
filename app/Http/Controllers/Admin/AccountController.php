<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account_UpdateRequest;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\Account_type;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Suppliers_Categorie;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $com_code = auth()->user()->id;
        $data = Account::select()->where('com_code', $com_code)->orderby('id', 'DESC')->paginate(PAGINATION_CONST);
        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');
            $info->account_type_name = Account_type::where('id', $info->account_types_id)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
            if ($info->is_parent == 0) {
                $info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
            } else {
                $info->parent_account_name = 'لايوجد';
            }
        }
        $account_types = Account_type::select('id', 'name')->where('active', 1)->orderBy('id', 'ASC')->get();

        return view('admin.account.index', compact('data', 'account_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $com_code = auth()->user()->id;
        $account_types = Account_type::select('id', 'name')->where(['active' => 1, 'related_internal_account' => 0])->orderBy('id', 'ASC')->get();
        $parent_accounts = Account::select('account_number', 'name')->where(['is_parent' => 1, 'com_code' => $com_code])->orderBy('id', 'ASC')->get();

        return view('admin.account.create', compact('account_types', 'parent_accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        try {

            $data = Account::all();
            $com_code = auth()->user()->com_code;
            $checkifexist = Account::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم الحساب '."::($request->name)::".'  موجود '])->withInput();
            } else {

                $row = Account::select('account_number')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
                if (! empty($row)) {
                    $data['account_number'] = $row['account_number'] + 1;
                } else {
                    $data['account_number'] = 1;

                }
                $is_parent = $request->is_parent;
                if ($is_parent == 0) {
                    $data['parent_account_number'] = $request->parent_account_number;

                } elseif ($is_parent == 1) {
                    $data['parent_account_number'] = 0;
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

                Account::create([
                    'name' => $request->name,
                    'account_number' => $data['account_number'],
                    'is_parent' => $request->is_parent,
                    'parent_account_number' => $data['parent_account_number'],
                    'is_archived' => $request->is_archived,
                    'account_types_id' => $request->account_types_id,
                    'start_balance_status' => $start_balance_status,
                    'start_balance' => $data['start_balance'],
                    'notes' => $request->notes,
                    'date' => date('Y-m-d H:i:s'),
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                ]
                );

                return redirect()->route('admin.account.index')->with('success', 'تم اضافة حساب  '."::($request->name)::".'  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $com_code = auth()->user()->id;
        $data = Account::where(['id' => $id, 'com_code' => $com_code])->first();
        if (empty($data)) {

            return redirect()->route('admin.account.index')->with(['error' => 'عفوا الحساب المطلوب تعديله لا يوجد  ']);

        }

        $account_types = Account_type::select('id', 'name')->where(['active' => 1])->get();
        $parent_accounts = Account::select('account_number', 'name')->where(['is_parent' => 1, 'com_code' => $com_code])->get();
        $suppliers_categories = Suppliers_Categorie::select('id', 'name')->where(['active' => 1])->get();

        if ($data['account_types_id'] == 2) {
            $data->suppliers_categories_id = Supplier::select('suppliers_categories_id')->where(['account_number' => $data['account_number'], 'com_code' => $com_code])->first();
        }

        return view('admin.account.edit', compact('account_types', 'parent_accounts', 'data', 'suppliers_categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Account_UpdateRequest $request)
    {

        try {
            $com_code = auth()->user()->com_code;
            // $account = Account::where(['id' => $id, 'com_code' => $com_code])->first();
            $account = get_id_row(new Account(), 'id', $id, 'com_code', $com_code); // دالة فعلتها داخل ملف الهيلبر helper.php

            if (empty($account)) {
                return redirect()->route('admin.account.index')->with('error', '  الحساب المراد تعديله غير موجود  ')->withInput();
            }
            $checkifexist = Account::select('id')->where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا اسم الحساب '."::($request->name)::".'  موجود '])->withInput();
            } else {
                $is_parent = $request->is_parent;
                if ($is_parent == 0) {
                    $account['parent_account_number'] = $request->parent_account_number;

                } elseif ($is_parent == 1) {
                    $account['parent_account_number'] = 0;
                }

                $d = $account->update([
                    'name' => $request->name,
                    'is_parent' => $request->is_parent,
                    'parent_account_number' => $account['parent_account_number'],
                    'is_archived' => $request->is_archived,
                    'account_types_id' => $request->account_types_id,
                    'notes' => $request->notes,
                    'date' => date('Y-m-d H:i:s'),
                    'com_code' => $com_code,
                    'updated_by' => auth()->user()->id,
                ]
                );

                if ($d) {
                    if ($account['account_types_id' == 3]) {//إذا كان نوعه عميل
                        $customer = Customer::where(['account_number' => $account['account_number'], 'customer_code' => $account['other_table_forignKey'], 'com_code' => $com_code])->first();
                        if ($customer) {
                            $customer->update([
                                'name' => $request->name,
                                'active' => $request->is_archived,
                                'notes' => $request->notes,
                                'date' => date('Y-m-d H:i:s'),
                                'com_code' => $com_code,
                                'updated_by' => auth()->user()->id,
                            ]
                            );
                        }
                    }
                }

                if ($d) {
                    if ($account['account_types_id'] == 2) {// إذا كان نوعه مورد
                        $sup_cats = $request->suppliers_categories_id;
                        // if ($s == 9) {
                        //     $sup_cats = $s;
                        // } else {
                        //     $sup_cats = 0;
                        // }
                        $supplier = Supplier::where(['account_number' => $account['account_number'], 'supplier_code' => $account['other_table_forignKey'], 'com_code' => $com_code])->first();
                        if ($supplier) {
                            $supplier->update([
                                'name' => $request->name,
                                'active' => $request->is_archived,
                                'suppliers_categories_id' => $sup_cats,
                                'notes' => $request->notes,
                                'date' => date('Y-m-d H:i:s'),
                                'com_code' => $com_code,
                                'updated_by' => auth()->user()->id,
                            ]
                            );
                        }
                    }
                }

                return redirect()->route('admin.account.index')->with('success', 'تم تعديل الحساب  '."::($request->name)::".'  بنجاح')->withInput();

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
            $data = Account::select('id', 'name')->where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '  الحساب المالي المطلوب للحذف غير موجود  ']);

            }
            Account::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف الحساب '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_account_search(Request $request)
    {
        if ($request->ajax()) {
            $search_account_by_text = $request->search_account_text;
            $is_parent_searc = $request->is_parent_s;
            $account_type_sear = $request->account_type_s;
            $search_radio = $request->search_radio;
            // exit($account_type_sear);

            if ($search_account_by_text == '') {
                $tex1 = 'id';
                $tex2 = '>';
                $tex3 = '0';
            } elseif ($search_radio == 'searchby_acc_number') {
                $tex1 = 'account_number';
                $tex2 = 'LIKE';
                $tex3 = "%{$search_account_by_text}%";
            } else {
                $tex1 = 'name';
                $tex2 = 'LIKE';
                $tex3 = "%{$search_account_by_text}%";

            }

            if ($account_type_sear == '0') {
                $typ1 = 'id';
                $typ2 = '>';
                $typ3 = '0';
            } else {
                $typ1 = 'account_types_id';
                $typ2 = '=';
                $typ3 = $account_type_sear;

            }

            if ($is_parent_searc == '3') {
                $par1 = 'id';
                $par2 = '>';
                $par3 = '0';
            } else {
                $par1 = 'is_parent';
                $par2 = '=';
                $par3 = $is_parent_searc;

            }
            $data = Account::where($tex1, $tex2, $tex3)->where($typ1, $typ2, $typ3)->where($par1, $par2, $par3)->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->account_type_name = Account_type::where('id', $info->account_types_id)->value('name');

                if ($info->is_parent == 0) {
                    $info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
                } else {
                    $info->parent_account_name = 'لايوجد';
                }
            }

            return view('admin.account.ajax_account_search', compact('data'));
        }

    }
}