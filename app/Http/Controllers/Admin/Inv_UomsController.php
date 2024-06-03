<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Inv_Uoms;
use Illuminate\Http\Request;

class Inv_UomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Inv_Uoms::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.inv_uoms.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inv_uoms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Inv_Uoms::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا الاسم '."::($request->name)::".'  موجود '])->withInput();
            } else {
                Inv_Uoms::create([
                    'name' => $request->name,
                    'is_master' => $request->is_master,
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('admin.inv_uoms.index')->with('success', 'تم اضافة الوحدة '."::($request->name)::".'  بنجاح');

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inv_Uoms $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Inv_Uoms::findOrFail($id);

        return view('admin.inv_uoms.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {        

        try {
            if ($request->com_code == auth()->user()->com_code) {
                $W = Inv_Uoms::find($request->id);
                if (empty($W)) {
                    return back()->with(['error' => '  الصنف المراد تعديله غير موجود  '])->withInput();
                } else {

                    $name = Inv_Uoms::where(['name' => $request->name, 'com_code' => auth()->user()->com_code])->where('id', '!=', $request->id)->first();
                    if (empty($name)) {

                        $W->name = $request->name;
                        $W->is_master = $request->is_master;
                        $W->com_code = auth()->user()->com_code;
                        $W->updated_by = auth()->user()->id;
                        $W->date = date('Y-m-d H:i:s');
                        $W->active = $request->active;
                        $W->update();

                        return redirect()->route('admin.inv_uoms.index')->with('success', 'تم تعديل الصنف '."::($request->name)::".' بنجاح');

                    } else {

                        return redirect()->back()->with(['error' => 'عفوا ..!! الصنف '."::($request->name)::".' موجودة بالفعل !! '])->withInput();

                    }

                }

            } else {
                return back()->with(['error' => 'هذه ليست شركتك'])->withInput();
            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Inv_Uoms::where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '  الصنف المطلوب للحذف غير موجود  ']);

            }
            Inv_Uoms::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف الصنف '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_inv_uoms_search(Request $request)
    {
        if ($request->ajax()) {
            $search_inv_uoms_by_text = $request->search_inv_uoms_by_text;
            $is_master_search = $request->is_master_search;
            if ($search_inv_uoms_by_text =="") {
                $text1 = 'id';
                $text2 = '>';
                $text3= '0';
            } else {
                $text1 = 'name';
                $text2 = 'LIKE';
                $text3=  "%{$search_inv_uoms_by_text}%";

            }

            if ($is_master_search == 2) {
                $field1 = 'id';
                $field2 = '>';
                $field3 = '0';
            } else {
                $field1 = 'is_master';
                $field2 = '=';
                $field3 = $is_master_search;

            }

            $data = Inv_Uoms::where($text1, $text2, $text3)->where( $field1, $field2,  $field3)->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.inv_uoms.ajax_inv_uoms_search', compact('data'))->render();


        }
    }
}