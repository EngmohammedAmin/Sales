<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Item_Card_Categories;
use Illuminate\Http\Request;

class Item_Card_CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Item_Card_Categories::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.item_card_categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.item_card_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Item_Card_Categories::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا الاسم '."::($request->name)::".'  موجود '])->withInput();
            } else {

                Item_Card_Categories::create([
                    'name' => $request->name,
                    'com_code' => $com_code,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('item_card_cats.index')->with('success', 'تم اضافة فئة الصنف '."::($request->name)::".'  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item_Card_Categories $item_Card_Categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Item_Card_Categories::findOrFail($id);

        return view('admin.item_card_categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->com_code == auth()->user()->com_code) {
                $W = Item_Card_Categories::find($request->id);
                if (empty($W)) {
                    return back()->with(['error' => '  فئة الصنف المراد تعديلها غير موجودة  '])->withInput();
                } else {
                    $name = Item_Card_Categories::where('name', $request->name)->where('id', '!=', $request->id)->first();
                    if (empty($name)) {

                        $W->name = $request->name;
                        $W->com_code = auth()->user()->com_code;
                        $W->updated_by = auth()->user()->id;
                        $W->date = date('Y-m-d H:i:s');
                        $W->active = $request->active;
                        $W->update();

                        return redirect()->route('item_card_cats.index')->with('success', 'تم تعديل فئة الصنف '."::($request->name)::".' بنجاح');

                    } else {

                        return redirect()->back()->with(['error' => 'عفوا ..!! فئة الصنف '."::($request->name)::".' موجودة بالفعل !! '])->withInput();

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
    public function destroy($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Item_Card_Categories::where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '  فئة الصنف المطلوبة للحذف غير موجودة  ']);

            }
            Item_Card_Categories::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف فئة الصنف '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }


    public function ajax_item_card_cats_search(Request $request)
    {
        if ($request->ajax()) {

            $search_item_cats_by_text = $request->search_item_cats_by_text;
            $data = Item_Card_Categories::where('name', 'LIKE', "%{$search_item_cats_by_text}%")->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.item_card_categories.ajax_item_card_cats_search', compact('data'));
        }

    }

}