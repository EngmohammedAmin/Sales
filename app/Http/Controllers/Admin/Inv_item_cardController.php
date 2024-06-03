<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Inv_item_card;
use App\Models\Inv_Uoms;
use App\Models\Item_Card_Categories;
use Illuminate\Http\Request;

class Inv_item_cardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Inv_item_card::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);
        $item_card_categories = Item_Card_Categories::where(['com_code' => auth()->user()->com_code, 'active' => 1])->get();

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');
            $info->item_card_categories_name = Item_Card_Categories::where('id', $info->item_card_categories_id)->value('name');
            $info->parent_inv_item_card_name = Inv_item_card::where('id', $info->parent_inv_item_card_id)->value('name');
            $info->uom_name = Inv_Uoms::where('id', $info->uom_id)->value('name');
            $info->retail_uom_name = Inv_Uoms::where('id', $info->retail_uom_id)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.inv_item_card.index', compact('data', 'item_card_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item_card_categories = Item_Card_Categories::where(['com_code' => auth()->user()->com_code, 'active' => 1])->get();
        $inv_uoms_parent = Inv_Uoms::where(['com_code' => auth()->user()->com_code, 'active' => 1, 'is_master' => 1])->get();
        $inv_uoms_chield = Inv_Uoms::where(['com_code' => auth()->user()->com_code, 'active' => 1, 'is_master' => 0])->get();
        $inv_item_card_data = Inv_item_card::where(['com_code' => auth()->user()->com_code, 'active' => 1])->get();

        return view('admin.inv_item_card.create', compact('item_card_categories', 'inv_uoms_parent', 'inv_uoms_chield', 'inv_item_card_data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $com_code = auth()->user()->com_code;

        try {

            $row = Inv_item_card::select('item_code')->where('com_code', $com_code)->orderBy('id', 'DESC')->first();
            if (! empty($row)) {
                $row_insert['item_code'] = $row['item_code'] + 1;

            } else {
                $row_insert['item_code'] = 1;

            }
            if ($request->barcode != '') {
                // check if barcode exist
                $checkifexist_barcode = Inv_item_card::where(['barcode' => $request->barcode, 'com_code' => $com_code])->first();
                if (! empty($checkifexist_barcode)) {
                    return back()->with(['error' => 'عفوا الصنف الذي يحمل الباركود  '."::($request->barcode)::".'  موجود '])->withInput();

                } else {
                    $row_insert['barcode'] = $request->barcode;

                }

            } else {
                $row_insert['barcode'] = 'item'.$row_insert['item_code'];

            }

            // check if name exist
            $checkifexist_name = Inv_item_card::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if (! empty($checkifexist_name)) {
                return back()->with(['error' => 'عفوا اسم الصنف   '."::($request->name)::".'  موجود '])->withInput();

            }

            $row_insert['name'] = $request->name;
            $row_insert['com_code'] = $com_code;
            $row_insert['item_type'] = $request->item_type;
            $row_insert['item_card_categories_id'] = $request->item_card_categories_id;
            $row_insert['uom_id'] = $request->uom_id;
            $row_insert['parent_inv_item_card_id'] = $request->parent_inv_item_card_id;

            if ($request->parent_inv_item_card_id == '') {
                $row_insert['parent_inv_item_card_id'] = 0;

            } else {
                $row_insert['parent_inv_item_card_id'] = $request->parent_inv_item_card_id;
            }
            $row_insert['price'] = $request->price;
            $row_insert['half_gomla_price'] = $request->half_gomla_price;
            $row_insert['gomla_price'] = $request->gomla_price;
            $row_insert['cost_price'] = $request->cost_price;

            $row_insert['does_has_retailUnit'] = $request->does_has_retailUnit;

            if ($row_insert['does_has_retailUnit'] == 1) {

                $row_insert['retail_uom_id'] = $request->retail_uom_id;
                $row_insert['retail_uom_quentityToParent'] = $request->retail_uom_quentityToParent;
                $row_insert['price_retail'] = $request->price_retail;
                $row_insert['half_gomla_price_retail'] = $request->half_gomla_price_retail;
                $row_insert['gomla_price_retail'] = $request->gomla_price_retail;
                $row_insert['cost_price_retail'] = $request->cost_price_retail;
            }

            if ($request->has('item_img')) {
                $request->validate([
                    'item_img' => 'mimes:png,jpg,jpeg|max:2000',

                ]);

                $filePath = uploadImage('assets/admin/uploads/item_img', $request->item_img);
                $row_insert['item_img'] = $filePath;

            }

            $row_insert['QUENTITY'] = $request->QUENTITY;
            $row_insert['QUENTITY_Retail'] = $request->QUENTITY_Retail;
            $row_insert['QUENTITY_All_Retail'] = $request->QUENTITY_All_Retail;
            $row_insert['has_fixed_price'] = $request->has_fixed_price;

            $row_insert['added_by'] = auth()->user()->id;
            $row_insert['active'] = $request->active;
            $row_insert['date'] = date('Y-m-d H:i:s');
            Inv_item_card::create($row_insert);

            return redirect()->route('inv_item_card.index')->with('success', 'تم اضافة الصنف   '."::($request->name)::".'  بنجاح');

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $com_code = auth()->user()->com_code;
        $data = Inv_item_card::find($id);
        if (empty($data)) {
            return redirect()->route('inv_item_card.index')->with(['error' => '   الصنف المطلوب غير موجود لدينا  '])->withInput();
        }

        $data->added_by = Admin::where('id', $data->added_by)->value('name');
        $data->item_card_categories_name = Item_Card_Categories::where('id', $data->item_card_categories_id)->value('name');
        $data->parent_inv_item_card_name = Inv_item_card::where('id', $data->parent_inv_item_card_id)->value('name');
        $data->uom_name = Inv_Uoms::where('id', $data->uom_id)->value('name');
        if ($data->does_has_retailUnit == 1) {
            $data->retail_uom_name = Inv_Uoms::where('id', $data->retail_uom_id)->value('name');

        }

        if ($data->updated_by > 0 and $data->updated_by != null) {
            $data->updated_by = Admin::where('id', $data->updated_by)->value('name');

        }

        return view('admin.inv_item_card.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Inv_item_card::find($id);
        $item_card_categories = Item_Card_Categories::where(['com_code' => auth()->user()->com_code, 'active' => 1])->get();
        $inv_uoms_parent = Inv_Uoms::where(['com_code' => auth()->user()->com_code, 'active' => 1, 'is_master' => 1])->get();
        $inv_uoms_chield = Inv_Uoms::where(['com_code' => auth()->user()->com_code, 'active' => 1, 'is_master' => 0])->get();
        $inv_item_card_data = Inv_item_card::where(['active' => 1, 'com_code' => auth()->user()->com_code])->get();

        return view('admin.inv_item_card.edit', compact('item_card_categories', 'inv_uoms_parent', 'inv_uoms_chield', 'inv_item_card_data', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $com_code = auth()->user()->com_code;

        try {

            $W = Inv_item_card::find($id);

            if (empty($W)) {
                return redirect()->route('inv_item_card.index')->with(['error' => '   الصنف المراد تعديله غير موجود  '])->withInput();
            }

            if ($request->barcode != '') {
                // check if barcode exist
                $checkifexist_barcode = Inv_item_card::where(['barcode' => $request->barcode, 'com_code' => $com_code])->where('id', '!=', $id)->first();
                if (! empty($checkifexist_barcode)) {
                    return back()->with(['error' => 'عفوا الصنف الذي يحمل الباركود  '."::($request->barcode)::".'  موجود '])->withInput();

                } else {
                    $W->barcode = $request->barcode;

                }

            }
            $name = Inv_item_card::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if (! empty($name)) {
                return redirect()->back()->with(['error' => 'عفوا ..!! اسم الصنف '."::($request->name)::".' موجود بالفعل !! '])->withInput();
            }

            $W->name = $request->name;
            $W->item_type = $request->item_type;
            $W->uom_id = $request->uom_id;
            $W->item_card_categories_id = $request->item_card_categories_id;
            if ($request->parent_inv_item_card_id == '') {
                $W['parent_inv_item_card_id'] = 0;

            } else {
                $W['parent_inv_item_card_id'] = $request->parent_inv_item_card_id;
            }
            $W->price = $request->price;
            $W->half_gomla_price = $request->half_gomla_price;
            $W->gomla_price = $request->gomla_price;
            $W->cost_price = $request->cost_price;

            $W->does_has_retailUnit = $request->does_has_retailUnit;

            if ($W['does_has_retailUnit'] == 1) {

                $W['retail_uom_id'] = $request->retail_uom_id;
                $W['retail_uom_quentityToParent'] = $request->retail_uom_quentityToParent;
                $W['price_retail'] = $request->price_retail;
                $W['half_gomla_price_retail'] = $request->half_gomla_price_retail;
                $W['gomla_price_retail'] = $request->gomla_price_retail;
                $W['cost_price_retail'] = $request->cost_price_retail;
            } else {
                $W['retail_uom_id'] = null;
                $W['retail_uom_quentityToParent'] = null;
                $W['price_retail'] = null;
                $W['half_gomla_price_retail'] = null;
                $W['gomla_price_retail'] = null;
                $W['cost_price_retail'] = null;

            }

            $oldphoto = $W->item_img;
            if ($request->has('item_img')) {
                $request->validate([
                    'item_img' => 'mimes:png,jpg,jpeg|max:2000',

                ]);
                // $image = $request->file('photo');
                // $file_name = $image->getClientOriginalName();
                // $extention = $image->guessClientExtension();
                // $file_name = time().rand(100, 999).'.'.$extention;
                // $data->photo = $file_name;
                // $request->photo->move('assets/admin/uploads', $file_name);
                //------------بنيناها في ملف هيلبر داخل ملف اب uploadImage  طريقة اخرى استدعاء دالة  --------------------------------------

                $filePath = uploadImage('assets/admin/uploads/item_img', $request->item_img);
                $W->item_img = $filePath;
                if (file_exists('assets/admin/uploads/item_img/'.$oldphoto)) {
                    unlink('assets/admin/uploads/item_img/'.$oldphoto);
                }

            }
            // الأسعار

            $W->com_code = auth()->user()->com_code;
            $W->updated_by = auth()->user()->id;
            $W->has_fixed_price = $request->has_fixed_price;
            $W->active = $request->active;
            $W->date = date('Y-m-d H:i:s');
            $W->update();

            return redirect()->route('inv_item_card.index')->with('success', 'تم تعديل فئة الصنف '."::($request->name)::".' بنجاح');

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
            $data = Inv_item_card::where(['id' => $id, 'com_code' => $com_code])->first();

            if (empty($data)) {
                return back()->with(['error' => '   الصنف المطلوب للحذف غير موجود  ']);

            }
            Inv_item_card::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف  الصنف '."::($data->name)::".'  بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function ajax_inv_item_card_search(Request $request)
    {
        if ($request->ajax()) {
            $search_inv_item_card_by_text = $request->search_inv_item_card_by_text;
            $item_type_search = $request->item_type_sear;
            $item_card_categories_search = $request->item_card_categories_sear;
            $radiosearchcheck = $request->radiosearchcheck;
            // exit($item_type_search);

            if ($search_inv_item_card_by_text == '') {
                $text1 = 'id';
                $text2 = '>';
                $text3 = '0';
            } elseif ($radiosearchcheck == 'searchby_barcode') {
                $text1 = 'barcode';
                $text2 = '=';
                $text3 = $search_inv_item_card_by_text;
            } elseif ($radiosearchcheck == 'searchby_itemcode') {
                $text1 = 'item_code';
                $text2 = '=';
                $text3 = $search_inv_item_card_by_text;

            } else {
                $text1 = 'name';
                $text2 = 'LIKE';
                $text3 = "%{$search_inv_item_card_by_text}%";

            }

            if ($item_type_search == 0) {
                $type1 = 'id';
                $type2 = '>';
                $type3 = '0';
            } else {
                $type1 = 'item_type';
                $type2 = '=';
                $type3 = $item_type_search;

            }
            if ($item_card_categories_search == 0) {
                $cat1 = 'id';
                $cat2 = '>';
                $cat3 = '0';
            } else {
                $cat1 = 'item_card_categories_id';
                $cat2 = '=';
                $cat3 = $item_card_categories_search;

            }

            $data = Inv_item_card::where($type1, $type2, $type3)->where($cat1, $cat2, $cat3)->where($text1, $text2, $text3)->orderBy('id', 'ASC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');
                $info->item_card_categories_name = Item_Card_Categories::where('id', $info->item_card_categories_id)->value('name');
                $info->parent_inv_item_card_name = Inv_item_card::where('id', $info->parent_inv_item_card_id)->value('name');
                $info->uom_name = Inv_Uoms::where('id', $info->uom_id)->value('name');
                $info->retail_uom_name = Inv_Uoms::where('id', $info->retail_uom_id)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.inv_item_card.ajax_inv_item_card_search', compact('data'));
        }

    }
}