{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الضبط العام
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الخزانات
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزانات </a>
@endsection

@section('contentheaderactive')
    عرض التفاصيل
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')



    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تفاصيل الخزانة </h3>
                </div>
                <div class="card-body ">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2"
                            class="table table-bordered table-hover table-responsive"style="border-color:black;border-width:2px;">
                            <tr>
                                <th class="col-4"> اسم الخزنة</th>
                                <td> {{ $data['name'] }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> نوع الخزنة </th>
                                <td>
                                    @if ($data['is_master'] == 1)
                                        <div class="bg-success col-3"> رئيسية </div>
                                    @else
                                        <div class="bg-danger col-3"> ليست رئيسية </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4"> آخر إيصال صرف </th>
                                <td> {{ $data->last_isal_exchange }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> آخر إيصال تحصيل كلي </th>
                                <td> {{ $data->last_isal_collect }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> حالة تفعيل الخزنة </th>
                                <td>
                                    @if ($data['active'] == 1)
                                        <div class="bg-success col-3"> مفعل </div>
                                    @else
                                        <div class="bg-danger col-3"style="  box-sizing: border-box; "> غير مفعل </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4">كود الشركة </th>
                                <td> {{ $data['com_code'] }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> أضيفت بواسطة </th>
                                <td> {{ $data['added_by'] }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> تاريخ الاضافة </th>
                                <td>
                                    @php
                                        $dt = new DateTime($data->created_at);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i:s');
                                        $dateTime = date('A', strtotime($time));
                                        $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $dateTimtype }}

                                </td>
                            </tr>
                            <tr>
                                <th class="col-4"> تم التعديل بواسطة </th>
                                <td> {{ $data['updated_by'] }}</td>
                            </tr>
                            <tr>
                                <th class="col-4"> تاريخ التعديل </th>
                                <td>
                                    @php
                                        $dt = new DateTime($data->updated_at);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i:s');
                                        $dateTime = date('A', strtotime($time));
                                        $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                                        
                                    @endphp
                                    {{ $date }}
                                    {{ $time }}
                                    {{ $dateTimtype }}
                                </td>
                            </tr>
                            <tr>
                                <th class="col-4"> العمليات </th>
                                <td class="control">
                                    <div style="display:flex;margin:5px;">
                                        <a href="{{ route('admin.treasuries.edit', [$data->id]) }}"
                                            class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل </a>
                                        <a href="{{ route('admin.treasuries.index') }}"
                                            class="btn btn-sm btn-dark "style="margin-right: 100px">
                                            رجوع </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-danger">
                            عفوا لاتوجد بيانات !!

                        </div>
                    @endif


                    {{--  Treasuries Delivary  --}}

                    <div class="row">
                        <div class="col">
                            <h3 class="card-title card_title_center">الخزن الفرعية التي ستسلم عهدتها الى
                                الخزنة
                                :{{ $data->name }}
                                <a href="{{ route('admin.treasuries.addDelivary', [$data->id]) }}" class="btn btn-primary">
                                    إضافة جديدة </a>
                            </h3>
                        </div>
                    </div>


                    <div id="ajax_responce_searchDiv">
                        @if (@isset($treasuries_delivary) && !@empty($treasuries_delivary) && count($treasuries_delivary) > 0)
                            <table id="example2" class="table table-bordered table-hover table-responsive ">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
                                    <th> مسلسل </th>
                                    <th> اسم الخزنة</th>
                                    <th> أضيفت بواسطة </th>
                                    <th> تاريخ الاضافة </th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">
                                    <?php $i = 0; ?>
                                    @foreach ($treasuries_delivary as $T)
                                        <?php $i++; ?>
                                        <tr>
                                            <td> {{ $i }}</td>
                                            <td> {{ $T->name = \App\Models\Treasuries::where('id', $T->treasuries_can_delivary_id)->value('name') }}
                                            </td>
                                            <td> {{ $data['added_by'] }}</td>
                                            <td>
                                                @php
                                                    $dt = new DateTime($data->created_at);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h:i:s');
                                                    $dateTime = date('A', strtotime($time));
                                                    $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                                                @endphp
                                                {{ $date }}
                                                {{ $time }}
                                                {{ $dateTimtype }}
                                            </td>
                                            <td style=""class="control">
                                                <div style="display:flex;margin:5px;">
                                                    <a href="treasuries/edit/{{ $T->id }}"
                                                        class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                                                    </a>

                                                    <a href="#" class="btn btn-sm btn-danger"
                                                        data-treasur_delivary_id="{{ $T->id }}" data-toggle="modal"
                                                        data-target="#delete_treasur_delivary"> حذف
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{ $treasuries_delivary->links() }}
                            </div>
                        @else
                            <div class="alert alert-danger">
                                عفوا لاتوجد بيانات !!

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- مودل حذف الخزانة المعهودة -->
    <div class="modal fade" id="delete_treasur_delivary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الخزنة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('admin.treasuries.delete_treasuries_delivary', 'test') }}" method="post">

                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="treasur_delivary_id" id="treasur_delivary_id" value="">
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
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
    <script>
        $('#delete_treasur_delivary').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var treasur_delivary_id = button.data('treasur_delivary_id')
            var modal = $(this)
            modal.find('.modal-body #treasur_delivary_id').val(treasur_delivary_id);
        })
    </script>
    {{--  <script>
        $(document).ready(function() {
            $('select[name="Treasuries"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('admin/treasuries/addDelivary') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(treasuri) {

                            $("#delivary").val(treasuri);
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>  --}}
@endsection

@endsection
