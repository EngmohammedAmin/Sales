{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الضبط العام
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الضبط
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsetting.index') }}">الضبط</a>
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
                    <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                </div>
                <div class="card-body " style="overflow-x:auto;">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class=" table-bordered table-hover table-responsive  ">
                            <thead class="" style="text-align: center;background:rgb(1, 5, 43);color:white;">
                                <tr>
                                    <td> اسم الشركة</td>
                                    <td>كود الشركة </td>
                                    <td> حالة نظام الشركة </td>
                                    <td>عنوان الشركة</td>
                                    <td> رقم تلفون الشركة </td>
                                    <td> اسم الحساب المالي للعملاء الأب </td>
                                    <td> اسم الحساب المالي للموردين الأب </td>

                                    <td> رسالة تنبيه </td>
                                    <td> شعار الشركة </td>
                                    <td> أضيفت بواسطة </td>
                                    <td> تم التعديل بواسطة </td>
                                    <td> تاريخ الاضافة </td>
                                    <td> تاريخ التعديل </td>
                                    <td> العمليات </td>


                                </tr>
                            </thead>
                            <tbody style="text-align: center;">

                                <tr>
                                    <td> {{ $data['system_name'] }}</td>
                                    <td> {{ $data['com_code'] }}</td>
                                    <td>
                                        @if ($data['active'] == 1)
                                            <div class="bg-success"> مفعل </div>
                                        @else
                                            <div class="bg-danger"style="  box-sizing: border-box; "> غير مفعل </div>
                                        @endif
                                    </td>
                                    <td> {{ $data['address'] }}</td>
                                    <td> {{ $data['phone'] }}</td>
                                    <td> <span class="bg-teal">{{ $data['customer_parent_account_name'] }} </span> :رقم حساب
                                        مالي
                                        ({{ $data['customer_parent_account_number'] }} )</td>
                                    <td> <span class="bg-primary">{{ $data['supplier_parent_account_name'] }} </span> :رقم حساب
                                        مالي
                                        ({{ $data['supplier_parent_account_number'] }} )</td>
                                    <td> {{ $data['general_alert'] }}</td>
                                    <td>
                                        <div class="image">
                                            <img class="custom_img"
                                                src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}"
                                                alt="شعار الشركة" style="width:50;hieght:50">
                                        </div>
                                    </td>

                                    <td> {{ $data['added_by'] }}</td>
                                    <td> {{ $data['updated_by'] }}</td>
                                    <td> {{ $data['created_at'] }}</td>
                                    <td> {{ $data['updated_at'] }}</td>
                                    <td style=""class="control">
                                        <div style="display:flex;margin:5px;">
                                            <a href="{{ route('admin.adminpanelsetting.edit') }}"
                                                class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل </a>
                                            <a href="#" class="btn btn-sm btn-danger"
                                                data-admin_panel_setting_id="{{ $data->id }}" data-toggle="modal"
                                                data-target="#delete_admin_panel_setting"> حذف </a>

                                        </div>

                                    </td>
                                </tr>

                            </tbody>

                        </table>
                        <br>
                    @else
                        <tbody>
                            <div class="alert alert-danger">
                                عفوا لاتوجد بيانات !!

                            </div>
                        </tbody>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- مودل حذف بيانات الضبط العام  -->
    <div class="modal fade" id="delete_admin_panel_setting" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الخزنة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('admin.adminpanelsetting.destroy', 'test') }}" method="post">

                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="text" name="admin_panel_setting_id" id="admin_panel_setting_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $('#delete_admin_panel_setting').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var admin_panel_setting_id = button.data('admin_panel_setting_id')
            var modal = $(this)
            modal.find('.modal-body #admin_panel_setting_id').val(admin_panel_setting_id);
        })
    </script>
@endsection


@endsection
