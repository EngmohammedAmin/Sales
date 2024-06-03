{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الحسابات
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحسابات المالية
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.account.index') }}"> الحسابات المالية </a>
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
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> بيانات الحسابات المالية </h3>

                    <input type="hidden" id="token_account_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_account_search_url"
                        value="{{ route('admin.account.ajax_account_search') }}">

                    <div class="col-sm-6 col-md-4 col-xl-3">
                        {{--  @can('اضافة خزنة')  --}}
                        <a class=" btn btn-sm btn-outline-primary " href="{{ route('admin.account.create') }}">اضافة حساب
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
                            <label for="search_account_by_text" class="control-label "> بحث بــ : </label>
                            <input checked type="radio" name="search_radio" id="search_radio" value="searchby_name"> الاسم
                            <input type="radio" name="search_radio" value="searchby_acc_number"> رقم الحساب
                            <input type="text"class="form-control" id="search_account_by_text"
                                placeholder="بحث بالاسم او رقم الحساب  ">
                        </div>


                        <div class="col-md-4">
                            <label class="control-label">بحث بنوع الحساب :</label>
                            <select name="account_type_search" id="account_type_search"
                                class="form-control bd-primary rounded-20 SlectBox">
                                <option selected style="text-align: center" value="0">--بحث بالكل

                                    --</option>
                                @if (isset($account_types) && !@empty($account_types))
                                    @foreach ($account_types as $ty)
                                        <option value="{{ $ty->id }}">{{ $ty->name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                        <div class="col-4">
                            <label> هل الحساب أب ؟ :</label>
                            <select name="is_parent_search" id="is_parent_search" class="form-control" style="color:blue">
                                <option selected style="text-align: center" value="3">-- بحث بالكل --
                                </option>
                                <option value="1">
                                    نعم
                                </option>
                                <option value="0">
                                    لا

                                </option>
                            </select>


                        </div>
                    </div>
                    <div id="ajax_account_searchDiv">
                        @if (@isset($data) && !@empty($data) && count($data) > 0)
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
                                    <th> اسم الحساب</th>
                                    <th> رقم الحساب </th>
                                    <th> النوع </th>
                                    <th> هل أب ؟ </th>
                                    <th> الحساب الأب </th>
                                    <th> الرصيد </th>
                                    <th> حالة التفعيل </th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">

                                    @foreach ($data as $d)
                                        <tr>

                                            <td> {{ $d->name }}</td>
                                            <td> {{ $d->account_number }}</td>
                                            <td> {{ $d->account_type_name }}</td>
                                            <td>
                                                @if ($d->is_parent == 1)
                                                    <div class="bg-primary"> نعم </div>
                                                @else
                                                    <div class="bg-dark"> لا </div>
                                                @endif
                                            </td>
                                            <td> {{ $d->parent_account_name }}</td>
                                            <td> </td>
                                            <td>
                                                @if ($d->is_archived == 1)
                                                    <div class="bg-success"> مفعل </div>
                                                @else
                                                    <div class="bg-danger"style="  box-sizing: border-box; "> مؤرشف
                                                    </div>
                                                @endif
                                            </td>

                                            <td style=""class="control">
                                                <div style="">
                                                    <a href="{{ route('admin.account.show', [$d->id]) }}" id=""
                                                        class="btn btn-sm btn-primary " style="margin-left: 5px">عرض
                                                        التفاصيل</a>

                                                    <a href="{{ route('admin.account.edit', [$d->id]) }}" id=""
                                                        class="btn btn-sm bg-success " style="margin-left: 5px"> تعديل</a>

                                                    <a href="{{ route('admin.account.destroy', [$d->id]) }}"
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>


    <!-- مودل حذف الحساب  -->
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف قد يكون هناك حسابات فرعية متعلقة بهذه الحساب ")

            if (!res) {
                return false

            }

        })
    </script>
@endsection
@endsection
