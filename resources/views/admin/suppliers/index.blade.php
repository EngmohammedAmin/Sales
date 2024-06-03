{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الموردين
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحســابات / الموردين
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers.index') }}"> بيانات الموردين </a>
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
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> بيانات الموردين </h3>

                    <input type="hidden" id="token_suppliers_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_suppliers_search_url"
                        value="{{ route('admin.suppliers.ajax_suppliers_search') }}">

                    <div class="col-sm-6 col-md-4 col-xl-3">
                        {{--  @can('اضافة خزنة')  --}}
                        <a class=" btn btn-sm btn-outline-primary " href="{{ route('admin.suppliers.create') }}">اضافة مورد
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
                            <label class="control-label "> بحث بــ : </label>
                            <input checked type="radio" name="search_radio" id="search_radio" value="searchby_name"> الاسم
                            <input type="radio" name="search_radio" value="searchby_account_number"> رقم الحساب
                            <input type="radio" name="search_radio" value="searchby_suppliers_code"> رقم كود المورد

                            <input autofocus type="text"class="form-control" id="search_suppliers_text"
                                placeholder="بحث بالاسم او رقم الحساب أو رقم المورد  ">
                        </div>

                    </div>
                    <div id="ajax_suppliers_searchDiv">
                        @if (@isset($data) && !@empty($data) && count($data) > 0)
                            <table id="example2" class="table table-bordered table-hover" style="">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
                                    <th> الاسم </th>
                                    <th> كود المورد </th>
                                    <th> فئة المورد </th>
                                    <th> رقم الحساب </th>
                                    <th> الرصيد </th>
                                    <th> حالة التفعيل </th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">

                                    @foreach ($data as $d)
                                        <tr>
                                            <td> {{ $d->name }}</td>
                                            <td> {{ $d->supplier_code }}</td>
                                            <td> {{ $d->suppliers_categories_name }}</td>
                                            <td> {{ $d->account_number }}</td>
                                            <td> {{ $d->start_balance * 1 }}</td>
                                            <td>
                                                @if ($d->active == 1)
                                                    <div class="bg-success"> مفعل </div>
                                                @else
                                                    <div class="bg-danger"style="  box-sizing: border-box; "> غير مفعل
                                                    </div>
                                                @endif
                                            </td>
                                            <td style=""class="control">
                                                <div style="">
                                                    <a href="#" id="" class="btn btn-sm btn-primary "
                                                        style="margin-left: 5px">عرض
                                                        التفاصيل</a>

                                                    <a href="{{ route('admin.suppliers.edit', [$d->id]) }}"
                                                        class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                                                    </a>

                                                    <a href="{{ route('admin.suppliers.destroy', [$d->id]) }}"
                                                        id="are_you_sure" class="btn btn-sm btn-danger are_you_sure">حذف</a>

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
    <script src="{{ asset('assets/admin/js/suppliers.js') }}"></script>


    <!-- مودل حذف العميل  -->
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف قد يكون هناك متعلقات فرعية  بهذا العميل ")

            if (!res) {
                return false

            }

        })
    </script>
@endsection
@endsection
