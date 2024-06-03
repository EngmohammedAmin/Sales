<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin_Panel_Setting_Request;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Admin_Panel_Setting;

class AdminPanelSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Admin_Panel_Setting::where('com_code', auth()->user()->com_code)->first();
        if (! empty($data)) {
            if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
                $data['updated_by_Admin'] = Admin::where('id', $data['updated_by'])->value('name');
                $data['customer_parent_account_name'] = Account::where('account_number', $data['customer_parent_account_number'])->value('name');
                $data['supplier_parent_account_name'] = Account::where('account_number', $data['supplier_parent_account_number'])->value('name');

            }

        }

        return view('admin.admin_panel_setting.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Admin_Panel_Setting_Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin_Panel_Setting $admin_Panel_Setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $data = Admin_Panel_Setting::where('com_code', auth()->user()->com_code)->first();
        $parent_accounts = Account::select('account_number', 'name')->where(['is_parent' => 1, 'com_code' => auth()->user()->com_code])->orderBy('id', 'ASC')->get();

        return view('admin.admin_panel_setting.edit', compact('data', 'parent_accounts'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Admin_Panel_Setting_Request $request)
    {
        // $data = Admin_Panel_Setting::where( auth()->user()->com_code, '=', auth()->user()->com_code)->first();
        // dd($data);

        // return auth()->user()->com_code;
        try {
            $data = Admin_Panel_Setting::where('com_code', auth()->user()->com_code)->first();
            $data->system_name = $request->system_name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->general_alert = $request->general_alert;
            $data->customer_parent_account_number = $request->customer_parent_account_number;
            $data->supplier_parent_account_number = $request->supplier_parent_account_number;
            $data->updated_by = auth()->user()->name;
            $data->updated_at = now();
            $data->active = $request->active;
            $oldphoto = $data->photo;
            if ($request->has('photo')) {
                $request->validate([
                    'photo' => 'required|mimes:png,jpg,jpeg|max:2000',

                ]);
                // $image = $request->file('photo');
                // $file_name = $image->getClientOriginalName();
                // $extention = $image->guessClientExtension();
                // $file_name = time().rand(100, 999).'.'.$extention;
                // $data->photo = $file_name;
                // $request->photo->move('assets/admin/uploads', $file_name);
                //------------بنيناها في ملف هيلبر داخل ملف اب uploadImage  طريقة اخرى استدعاء دالة  --------------------------------------

                $filePath = uploadImage('assets/admin/uploads', $request->photo);
                $data->photo = $filePath;
                if (file_exists('assets/admin/uploads/'.$oldphoto)) {
                    unlink('assets/admin/uploads/'.$oldphoto);
                }

            }

            $data->save();

            return redirect()->route('admin.adminpanelsetting.index')->with(['success' => ' تم تحديث البيانات بنجاح ']);

        } catch (\Exception $ex) {
            //throw $th;
            // session()->flash('error', 'عفوا حدث خطأ ما');

            // return redirect()->route('admin.adminpanelsetting.index');
            return redirect()->route('admin.adminpanelsetting.index')->with(['error' => 'عفوا حدث خطأ ما'.$ex->getMessage()]);
        }
        // return $request;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin_Panel_Setting $admin_Panel_Setting)
    {
        //

    }
}
