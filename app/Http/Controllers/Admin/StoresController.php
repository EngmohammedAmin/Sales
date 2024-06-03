<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Stores;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Stores::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.stores.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Stores::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا الاسم '."::($request->name)::".'  موجود '])->withInput();
            } else {

                Stores::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phones' => $request->phones,
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('admin.stores.index')->with('success', 'تم اضافة المخزن '."::($request->name)::".'  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Stores::findOrFail($id);

        return view('admin.stores.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->com_code == auth()->user()->com_code) {
                $W = Stores::find($request->id);
                if (empty($W)) {
                    return back()->with(['error' => '  المخزن المراد تعديله غير موجود  '])->withInput();
                } else {
                    $name = Stores::where('name', $request->name)->where('id', '!=', $request->id)->first();
                    if (empty($name)) {

                        $W->name = $request->name;
                        $W->address = $request->address;
                        $W->phones = $request->phones;
                        $W->com_code = auth()->user()->com_code;
                        $W->updated_by = auth()->user()->id;
                        $W->date = date('Y-m-d H:i:s');
                        $W->active = $request->active;
                        $W->update();

                        return redirect()->route('admin.stores.index')->with('success', 'تم تعديل المخزن '."::($request->name)::".' بنجاح');

                    } else {

                        return redirect()->back()->with(['error' => 'عفوا ..!! المخزن '."::($request->name)::".' موجودة بالفعل !! '])->withInput();

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
            $data = Stores::where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '  المخزن المطلوب للحذف غير موجود  ']);

            }
            Stores::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('error', '   تم حذف المخزن '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

      public function ajax_stores_search(Request $request)
    {
        if ($request->ajax()) {

            $search_stores_by_text = $request->search_stores_by_text;
            $data = Stores::where('name', 'LIKE', "%{$search_stores_by_text}%")->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.stores.ajax_stores_search', compact('data'));
        }

    }

}
