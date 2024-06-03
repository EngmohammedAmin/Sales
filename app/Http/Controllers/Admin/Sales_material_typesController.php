<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Sales_material_types;
use App\Models\Treasuries_delivary;
use Illuminate\Http\Request;

class Sales_material_typesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Sales_material_types::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.Sales_material_types.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Sales_material_types.create'); //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Sales_material_types::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا هذه الفئة موجودة من قبل '])->withInput();
            } else {

                Sales_material_types::create([
                    'name' => $request->name,
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('admin.Sales_material_types.index')->with('success', 'تم اضافة الفئة  بنجاح');

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Sales_material_types $sales_material_types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Sales_material_types::findOrFail($id);

        return view('admin.Sales_material_types.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->com_code == auth()->user()->com_code) {
                $W = Sales_material_types::find($request->id);
                if (empty($W)) {
                    return back()->with(['error' => '  الفئة المراد تعديلها غير موجودة  '])->withInput();
                } else {
                    $name = Sales_material_types::where(['name'=> $request->name,'com_code'=>auth()->user()->com_code])->where('id', '!=', $request->id)->first();
                    if (empty($name)) {

                        $W->name = $request->name;
                        $W->com_code = auth()->user()->com_code;
                        $W->updated_by = auth()->user()->id;
                        $W->date = date('Y-m-d H:i:s');
                        $W->active = $request->active;
                        $W->update();

                        return redirect()->route('admin.Sales_material_types.index')->with('success', 'تم تعديل الفئة بنجاح');

                    } else {

                        return redirect()->back()->with(['error' => 'عفوا ..!! الفئة '."::($request->name)::".' موجودة بالفعل !! '])->withInput();

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
            $data = Sales_material_types::where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '  الفئة المطلوبة للحذف غير موجودة  ']);

            }
            Sales_material_types::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف الفئة '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_m_search(Request $request)
    {
        if ($request->ajax()) {

            $search_m_by_text = $request->search_m_by_text;
            $data = Sales_material_types::where('name', 'LIKE', "%{$search_m_by_text}%")->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.Sales_material_types.ajax_m_search', compact('data'));
        }

    }
}