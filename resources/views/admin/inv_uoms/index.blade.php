{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الضبط العام
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الأصناف (الوحدات)
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.inv_uoms.index') }}"> الأصناف (الوحدات) </a>
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
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> الأصناف (الوحدات)</h3>

                    <input type="hidden" id="token_inv_uoms_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_inv_uoms_search_url"
                        value="{{ route('admin.inv_uoms.ajax_inv_uoms_search') }}">
                    {{--  <input type="hidden" id="is_master_search_url" value="{{ route('admin.inv_uoms.is_master_search') }}">  --}}

                    <div class="col-sm-6 col-md-4 col-xl-3">
                        {{--  @can('اضافة خزنة')  --}}
                        <a class=" btn btn-sm btn-success " href="{{ route('admin.inv_uoms.create') }}">اضافة
                            وحدة (صنف)
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
                            <input type="text"class="form-control" id="search_inv_uoms_by_text"
                                placeholder="بحث بالاسم ">
                        </div>
                        <div class="col-md-4">

                            <select name="is_master_search" id="is_master_search" class="form-control"
                                onchange="console.log('change is firing')">
                                <option class="bg-info" value="2">
                                    بحث بالكل </option>
                                <option class="bg-primary" value="1">
                                    بحث بوحدات الجملة </option>
                                <option class="bg-warning" value="0">
                                    بحث بوحدات التجزئة </option>

                            </select>

                        </div>
                    </div>
                    <div id="ajax_inv_uoms_searchDiv">
                        @if (@isset($data) && !@empty($data))
                            <table id="example2" class="table table-bordered table-hover ">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">

                                    <th> مسلسل </th>
                                    <th> اسم الوحدة</th>
                                    <th> نوع الوحدة</th>
                                    <th>كود الشركة </th>
                                    <th>أضيف بواسطة:</th>
                                    <th> تاريخ الاضافة </th>
                                    <th> تم التعديل بواسطة : </th>
                                    <th> تاريخ التعديل </th>
                                    <th> التاريخ</th>
                                    <th> الحالة</th>
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
                                                @if ($d->is_master == 1)
                                                    <div class="bg-primary"> وحدات جملة </div>
                                                @else
                                                    <div class="bg-warning"style="  box-sizing: border-box; "> وحدات تجزئة
                                                    </div>
                                                @endif
                                            </td>
                                            <td> {{ $d->com_code }}</td>
                                            <td> {{ $d->added_by }}</td>
                                            <td> {{ $d->created_at }}</td>
                                            <td> {{ $d->updated_by }}</td>
                                            <td>
                                                @if ($d->updated_by > 0 and $d->updated_by != null)
                                                    @php
                                                        $dt = new DateTime($d->updated_at);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('h:i:s');
                                                        $dateTime = date('A', strtotime($time));
                                                        $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                                                        
                                                    @endphp
                                                    {{ $date }}
                                                    {{ $time }}
                                                    {{ $dateTimtype }}
                                                @else
                                                    لايوجد تحديث
                                                @endif


                                            </td>

                                            <td> {{ $d->date }}</td>

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
                                                    <a href="{{ route('admin.inv_uoms.edit', [$d->id]) }}"
                                                        class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                                                    </a>
                                                    {{--  <a href="{{ route('admin.inv_uoms.details', [$d->id]) }}"
                                                        class="btn btn-sm btn-info" style="margin-left: 5px">
                                                        المزيد </a>  --}}

                                                    <form action="{{ route('admin.inv_uoms.delete', [$d->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger are_you_sure">
                                                            حذف </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tbody>
                                    <div class="alert alert-danger">
                                        عفوا لاتوجد بيانات !!

                                    </div>
                                </tbody>
                        @endif
                        </table>
                        <div>
                            {{ $data->links() }}</div>

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
    <script src="{{ asset('assets/admin/js/inv_uoms.js') }}"></script>


    <!-- سكريبت حذف الفئة  -->
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف قد يكون هناك منتجات متعلقة بهذه الفئة ")

            if (!res) {
                return false

            }

        })
    </script>
@endsection
@endsection
