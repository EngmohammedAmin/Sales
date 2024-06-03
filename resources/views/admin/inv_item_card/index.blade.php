{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    ضبط الأصناف
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الأصناف
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('inv_item_card.index') }}"> الأصناف </a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> بيانات الأصناف </h3>

                    <input type="hidden" id="token_inv_item_card_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_inv_item_card_search_url"
                        value="{{ route('inv_item_card.ajax_inv_item_card_search') }}">

                    <div class="col-sm-6 col-md-4 col-xl-3">
                        {{--  @can('اضافة خزنة')  --}}
                        <a class=" btn btn-sm btn-success " href="{{ route('inv_item_card.create') }}">إضـــــــافة
                            صـــــنف
                        </a>
                        {{--  @endcan  --}}

                        @can('تصدير EXCEL')
                            <a class="modal-effect btn btn-outline-primary" href="{{ url('e/export_invoices') }}"><i
                                    class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
                        @endcan
                    </div>

                </div>
                <div class="card-body " style="overflow-x:auto;">
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 10px">
                            <label for="search_inv_item_card_by_text" class="control-label "> بحث بــ : </label>
                            <input checked type="radio" name="searchradio" id="searchradio" value="searchby_name"> الاسم
                            <input type="radio" name="searchradio" value="searchby_barcode"> الباركود
                            <input type="radio" name="searchradio" value="searchby_itemcode"> كود الصنف

                            <input type="text"class="form-control" id="search_inv_item_card_by_text"
                                placeholder="بحث بالاسم او باركود او كود ">
                        </div>

                        <div class="col-md-4">
                            <label for="item_type_search" class="control-label "> بحث بنوع الصنف : </label>
                            <select name="item_type_search" id="item_type_search" class="form-control">
                                <option selected style="text-align: center" value="0"> --بحث بالكل
                                    -- </option>
                                <option value="1">
                                    مخزني </option>

                                <option value="2">
                                    استهلاكي بتاريخ صلاحية </option>
                                <option value="3">
                                    عهدة </option>

                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="item_card_categories_search" class="control-label">بحث بفئة الصنف :</label>
                            <select name="item_card_categories_search" id="item_card_categories_search"
                                class="form-control bd-primary rounded-20 SlectBox"
                                onchange="console.log('change is firing')">
                                <option selected style="text-align: center" value="0">--بحث بالكل

                                    --</option>
                                @if (isset($item_card_categories) && !@empty($item_card_categories))
                                    @foreach ($item_card_categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                    </div>

                    <div id="ajax_inv_item_card_searchDiv" style="width: 100%">
                        @if (@isset($data) && !@empty($data) && count($data) > 0)
                            <table id="example2" class="table table-bordered table-hover ">
                                <thead class=""
                                    style="text-align: center;background:rgb(46, 4, 4);color:white;width:100%">

                                    <th> مسلسل </th>
                                    <th> الاسم </th>
                                    <th> النوع </th>
                                    <th>الفئة</th>
                                    <th>الصنف الأب</th>
                                    <th>الوحدة الأب</th>
                                    <th>الوحدة التجزئة</th>
                                    <th> حالة التفعيل</th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">
                                    <?php $i = 0; ?>
                                    @foreach ($data as $d)
                                        <?php $i++; ?>
                                        <tr>
                                            <td> {{ $i }}</td>
                                            <td> {{ $d->name }}</td>
                                            <td>
                                                @if ($d->item_type == 1)
                                                    <div class="bg-primary"> مخزني </div>
                                                @elseif ($d->item_type == 2)
                                                    <div class="bg-warning"> استهلاكي بصلاحية </div>
                                                @elseif ($d->item_type == 3)
                                                    <div class="bg-teal"style="  box-sizing: border-box; "> عهدة
                                                    </div>
                                                @else
                                                    <div class="bg-danger"> غير محدد </div>
                                                @endif
                                            </td>
                                            <td> {{ $d->item_card_categories_name }}</td>
                                            <td> {{ $d->parent_inv_item_card_name }}</td>
                                            <td> {{ $d->uom_name }}</td>
                                            <td> {{ $d->retail_uom_name }}</td>

                                            <td>
                                                @if ($d->active == 1)
                                                    <div class="bg-success"> مفعل </div>
                                                @else
                                                    <div class="bg-danger"style="  box-sizing: border-box; "> غير مفعل
                                                    </div>
                                                @endif
                                            </td>
                                            <td style=""class="control">
                                                <div style="display:flex;margin:5px;">

                                                    <a href="{{ route('inv_item_card.edit', [$d->id]) }}"
                                                        class="btn btn-sm btn-primary" style="margin-left: 5px"> تعديل
                                                    </a>
                                                    <a href="{{ route('inv_item_card.show', [$d->id]) }}"
                                                        class="btn btn-sm btn-secondary" style="margin-left: 5px"> التفاصيل
                                                    </a>
                                                    <form action="{{ route('inv_item_card.destroy', [$d->id]) }}"
                                                        method="post">
                                                        {{--  {{ method_field('delete') }}  --}}
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger are_you_sure">
                                                            حذف </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div>
                                {{ $data->links() }}</div>
                        @else
                            <div class="alert alert-danger">
                                عفوا لاتوجد بيانات !!

                            </div>
                        @endif
                    </div>
                    <br>


                    <div class="d-flex justify-content-center">
                        <a href="{{ route('admin.dashboard') }}"class="btn btn-sm  btn-primary"style="margin: 10px">
                            الرجوع للرئيسية
                        </a>



                    </div>
                </div>
            </div>
        </div>
    </div>





@section('script')
    <script src="{{ asset('assets/admin/js/general.js') }}"></script>
    <script src="{{ asset('assets/admin/js/inv_item_card.js') }}"></script>


    <!-- سكريبت حذف الفئة  -->
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف قد يكون هناك  متعلقات بهذا الصنف ")

            if (!res) {
                return false

            }

        })
    </script>
@endsection
@endsection
