{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الحسابات
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    أنواع الحسابات
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.account_type.index') }}"> أنواع الحسابات </a>
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
                        style="font-size: 30px;font-family:'Times New Roman', Times, serif"> أنــــــــــواع الحســــــــابات
                    </h3>


                </div>
                <div class="card-body " style="overflow-x:auto;">

                    <div id="ajax_m_responce_searchDiv">
                        @if (@isset($data) && !@empty($data))
                            <table id="example2"
                                class="table table-bordered table-hover table-striped  table-sm table-responsive-xl">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">

                                    <th style="width: 10px"> مسلسل </th>
                                    <th> اسم الحساب</th>
                                    <th title="هل يضاف من شاشة داخلية ؟"> هل يضاف من شاشة داخلية؟ </th>
                                    <th> حالة الحساب</th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">
                                    <?php $i = 0; ?>
                                    @foreach ($data as $d)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>
                                                <h5> {{ $i }}</h5>
                                            </td>
                                            <td>
                                                <h5> {{ $d->name }} </h5>
                                            </td>
                                            <td>
                                                @if ($d->related_internal_account == 1)
                                                    <h5> نعم . ويضاف من شاشته الخاصة </h5>
                                                @else
                                                    <h5> لا . ويضاف من شاشة الحسابات </h5>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($d->active == 1)
                                                    <span class="bg-success"style="padding-bottom: 5px"> مفعل </span>
                                                @else
                                                    <span class="bg-danger"style="padding-bottom: 5px"> غير مفعل
                                                    </span>
                                                @endif
                                            </td>
                                            <td style=""class="control">
                                                <div style="display:flex;margin:5px;">
                                                    <a href="#" class="btn btn-sm btn-success"
                                                        style="margin-left: 5px"> تعديل
                                                    </a>
                                                    {{--  <a href="#"
                                                        class="btn btn-sm btn-info" style="margin-left: 5px">
                                                        المزيد </a>  --}}


                                                    <a href="#" class="btn btn-sm btn-danger are_you_sure">
                                                        حذف </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div>
                                {{ $data->links() }}</div>
                        @else
                            <tbody>
                                <div class="alert alert-danger">
                                    عفوا لاتوجد بيانات !!

                                </div>
                            </tbody>
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
    <script src="{{ asset('assets/admin/js/materialtypes.js') }}"></script>


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
