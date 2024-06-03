<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTreasuriesDelivaryRequest;
use App\Models\Admin;
use App\Models\Treasuries;
use App\Models\Treasuries_delivary;
use Illuminate\Http\Request;

class TreasuriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Treasuries::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        foreach ($data as $info) {

            $info->added_by = Admin::where('id', $info->added_by)->value('name');

            if ($info->updated_by > 0 and $info->updated_by != null) {
                $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

            }
        }

        return view('admin.treasuries.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.treasuries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $com_code = auth()->user()->com_code;
            $checkifexist = Treasuries::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkifexist != null) {
                return back()->with(['error' => 'عفوا الاسم '."::($request->name)::".'  موجود '])->withInput();
            } else {

                if ($request->is_master == 1) {

                    $checkifexist_is_master = Treasuries::where(['is_master' => $request->is_master, 'com_code' => $com_code])->first();
                    if ($checkifexist_is_master != null) {

                        return redirect()->back()->with(['error' => 'عفوا الخزنة الرئيسية موجودة بالفعل !! '])->withInput();

                    }

                }

                Treasuries::create([
                    'name' => $request->name,
                    'com_code' => $com_code,
                    'is_master' => $request->is_master,
                    'last_isal_exchange' => $request->last_isal_exchange,
                    'last_isal_collect' => $request->last_isal_collect,
                    'added_by' => auth()->user()->id,
                    'date' => date('Y-m-d H:i:s'),
                    'active' => $request->active,

                ]
                );

                return redirect()->route('admin.treasuries.index')->with('success', 'تم اضافة الخزنة  بنجاح')->withInput();

            }
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Treasuries $treasuries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Treasuries::findOrFail($id);

        return view('admin.treasuries.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->com_code == auth()->user()->com_code) {
            $tr = Treasuries::find($request->id);
            if (empty($tr)) {
                return back()->with(['error' => '  الخزاتة المطلوبة غير موجودة  ']);

            }

            // $com_code = auth()->user()->com_code;
            if ($request->is_master == 1) {
                $W = Treasuries::where('is_master', '=', 1)->first();
                if (isset($W)) {
                    if ($W->id == $request->id) {
                        $W->name = $request->name;
                        $W->com_code = auth()->user()->com_code;
                        $W->is_master = $request->is_master;
                        $W->last_isal_exchange = $request->last_isal_exchange;
                        $W->last_isal_collect = $request->last_isal_collect;
                        $W->updated_by = auth()->user()->id;
                        $W->date = date('Y-m-d H:i:s');
                        $W->active = $request->active;
                        $W->update();

                        return redirect()->route('admin.treasuries.index')->with('success', 'تم تعديل الخزنة الرئيسية  بنجاح')->withInput();

                    } else {
                        return redirect()->back()->with(['error' => 'عفوا الخزنة الرئيسية موجودة بالفعل !! '])->withInput();

                    }
                } else {
                    //if is_master not found and we want to change one of other into main(is_master=1)
                    $com_code = auth()->user()->com_code;
                    $NewMaster_If_notfound = Treasuries::where(['id' => $request->id, 'com_code' => $com_code])->first();
                    $NewMaster_If_notfound->name = $request->name;
                    $NewMaster_If_notfound->active = $request->input('active');
                    $NewMaster_If_notfound->is_master = $request->input('is_master');
                    $NewMaster_If_notfound->com_code = auth()->user()->com_code;
                    $NewMaster_If_notfound->last_isal_exchange = $request->input('last_isal_exchange');
                    $NewMaster_If_notfound->last_isal_collect = $request->input('last_isal_collect');
                    $NewMaster_If_notfound->date = now();
                    $NewMaster_If_notfound->updated_by = auth()->user()->id;
                    // $tr->updated_at= now();

                    $NewMaster_If_notfound->update();

                    return redirect()->route('admin.treasuries.index')->with(['success' => ' تم تعديلها الى خزنة رئيسية لعدم وجود خزنة رئيسية؟؟'])->withInput();
                }

            }
            $com_code = auth()->user()->com_code;
            $checkifexist = Treasuries::where(['id' => $request->id, 'com_code' => $com_code])->first();
            if (isset($checkifexist)) {
                $AR = Treasuries::where('name', $request->name)->first();
                if (isset($AR)) {
                    if ($checkifexist->id == $AR->id) {
                        $AR->name = $request->name;
                        $AR->active = $request->input('active');
                        $AR->is_master = $request->input('is_master');
                        $AR->com_code = auth()->user()->com_code;
                        $AR->last_isal_exchange = $request->input('last_isal_exchange');
                        $AR->last_isal_collect = $request->input('last_isal_collect');
                        $AR->date = now();
                        $AR->updated_by = auth()->user()->id;
                        // $tr->updated_at= now();

                        $AR->update();

                        return redirect()->route('admin.treasuries.index')->with('success', ' تم تعديل الخزانةالفرعية بنجاح ');
                    } else {
                        return redirect()->back()->with(['error' => 'عفوا اسم الخزنة موجودة بالفعل !! '])->withInput();

                    }
                } else {

                    $checkifexist->name = $request->name;
                    $checkifexist->active = $request->input('active');
                    $checkifexist->is_master = $request->input('is_master');
                    $checkifexist->com_code = auth()->user()->com_code;
                    $checkifexist->last_isal_exchange = $request->input('last_isal_exchange');
                    $checkifexist->last_isal_collect = $request->input('last_isal_collect');
                    $checkifexist->date = now();
                    $checkifexist->updated_by = auth()->user()->id;
                    // $tr->updated_at= now();

                    $checkifexist->update();

                    return redirect()->route('admin.treasuries.index')->with('success', ' تم تعديل الخزانةالفرعية بنجاح ');
                }

            }
        } else {
            return back()->with(['error' => 'هذه ليست شركتك']);
        }

    }

    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {

            $search_by_text = $request->search_by_text;
            $data = Treasuries::where('name', 'LIKE', "%{$search_by_text}%")->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);

            foreach ($data as $info) {

                $info->added_by = Admin::where('id', $info->added_by)->value('name');

                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by = Admin::where('id', $info->updated_by)->value('name');

                }
            }

            return view('admin.treasuries.ajax_search', compact('data'));
        }

    }

    public function details($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasuries::find($id);
            if (empty($data)) {
                return back()->with(['error' => '  الخزاتة المطلوبة غير موجودة  ']);

            } else {

                $treasuries_delivary = Treasuries_delivary::select()->where(['treasuries_id' => $id, 'com_code' => $com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_CONST);
                if (empty($treasuries_delivary)) {
                    return back()->with(['error' => ' تفاصيل الخزاتة المطلوبة غير موجودة  ']);

                }
                $data->added_by = Admin::where('id', $data->added_by)->value('name');
                if ($data->updated_by > 0 and $data->updated_by != null) {
                    $data->updated_by = Admin::where('id', $data->updated_by)->value('name');

                }
                $treasuries = Treasuries::all();

                return view('admin.treasuries.treasuriesDetails', compact('data', 'treasuries_delivary', 'treasuries'));
            }

        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }

    }

    public function addDelivary($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasuries::select('id', 'name')->find($id);
            if (empty($data)) {
                return back()->with(['error' => '  الخزاتة المطلوبة غير موجودة  ']);

            }

            $treasuries = Treasuries::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();

            return view('admin.treasuries.add_treasuries_delivary', compact('data', 'treasuries'));
            // return json_encode($treasuri);
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }

    }

    public function storeDelivary($id, AddTreasuriesDelivaryRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasuries::find($id);
            if (empty($data)) {
                return back()->with(['error' => '  الخزاتة المطلوبة غير موجودة  ']);

            }

            $treasuriesdelivary = Treasuries_delivary::where(['treasuries_id' => $id, 'treasuries_can_delivary_id' => $request->treasuries_can_delivary_id])->first();
            if (! empty($treasuriesdelivary)) {
                return back()->with(['error' => '   الخزاتة المطلوبة  موجودة بالفعل  '])->withInput();

            }

            Treasuries_delivary::create([
                'treasuries_id' => $id,
                'com_code' => $com_code,
                'treasuries_can_delivary_id' => $request->treasuries_can_delivary_id,
                'added_by' => auth()->user()->id,
            ]
            );

            return redirect()->route('admin.treasuries.details', $id)->with('success', '  تم إضافة الخزانة الفرعية إلى الخزانة'.$data->name.' بنجاح ');
            // return json_encode($treasuri);
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_treasuries_delivary(Request $request)
    {

        try {
            $com_code = auth()->user()->com_code;
            $data = Treasuries_delivary::where(['id' => $request->treasur_delivary_id, 'com_code' => $com_code])->get();
            if (empty($data)) {
                return back()->with(['error' => '  الخزاتة المطلوبة للحذف غير موجودة  ']);

            }
            Treasuries_delivary::where(['id' => $request->treasur_delivary_id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف الخزانة الفرعية من الخزانة الأم بنجاح ');
            // return json_encode($treasuri);
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }

    public function delete_treasuries($id)
    {

        try {
            $com_code = auth()->user()->com_code;
            $data = Treasuries::where(['id' => $id, 'com_code' => $com_code])->get();

            if (empty($data)) {
                return back()->with(['error' => '  الخزاتة المطلوبة للحذف غير موجودة  ']);

            }
            Treasuries_delivary::where(['treasuries_id' => $id, 'com_code' => $com_code])->delete();
            Treasuries::where(['id' => $id, 'com_code' => $com_code])->delete();

            return back()->with('success', '   تم حذف الخزانة الاصلية مع الخزانات الفرعية تبعها بنجاح ');
        } catch (\Exception $ex) {
            return back()->with(['error' => 'عفوا حدث خطأ ما '.$ex->getMessage()])->withInput();

        }
    }
}
