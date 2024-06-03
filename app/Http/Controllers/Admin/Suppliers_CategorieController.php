<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Suppliers_CategorieRequest;
use App\Models\Admin;
use App\Models\Suppliers_Categorie;
use Illuminate\Http\Request;

class Suppliers_CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Suppliers_Categorie::select()->where('com_code', $com_code)->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.suppliers_categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers_categories.create'); //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Suppliers_CategorieRequest $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Suppliers_Categorie::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا فئة المورد '."::($request->name)::".' موجودة من قبل '])->withInput();
            } else {

                Suppliers_Categorie::create([
                    'name' => $request->name,
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('admin.suppliers_categories.index')->with('success', 'تم اضافة فئة المورد '."::($request->name)::".'  بنجاح');

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Suppliers_Categorie $suppliers_Categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Suppliers_Categorie::findOrFail($id);

        return view('admin.suppliers_categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Suppliers_CategorieRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $W = Suppliers_Categorie::where(['id' => $id, 'com_code' => $com_code])->first();
            if (empty($W)) {
                return back()->with(['error' => '  فئة المورد المراد تعديلها غير موجودة  '])->withInput();
            } else {
                $name = Suppliers_Categorie::where(['name' => $request->name, 'com_code' => auth()->user()->com_code])->where('id', '!=', $request->id)->first();
                if (empty($name)) {

                    $W->name = $request->name;
                    $W->com_code = $com_code;
                    $W->updated_by = auth()->user()->id;
                    $W->date = date('Y-m-d H:i:s');
                    $W->active = $request->active;
                    $W->update();

                    return redirect()->route('admin.suppliers_categories.index')->with('success', 'تم تعديل فئة المورد '."::($request->name)::".' بنجاح');
                } else {
                    return redirect()->back()->with(['error' => 'عفوا ..!! فئة المورد '."::($request->name)::".' موجودة بالفعل !! '])->withInput();

                }

            }

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function delete($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Suppliers_Categorie::where(['id' => $id, 'com_code' => $com_code])->first();
            $name = $data->name;
            if (empty($data)) {
                return back()->with(['error' => '  فئة المورد المطلوبة للحذف غير موجودة  ']);

            }
            Suppliers_Categorie::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف فئة المورد '."::($name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_m_search(Request $request)
    {
        if ($request->ajax()) {

            $search_m_by_text = $request->search_m_by_text;
            $data = Suppliers_Categorie::where('name', 'LIKE', "%{$search_m_by_text}%")->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.suppliers_categories.ajax_m_search', compact('data'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers_Categorie $suppliers_Categorie)
    {
        //
    }
}