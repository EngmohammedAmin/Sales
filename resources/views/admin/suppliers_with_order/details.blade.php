{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    المشتريات
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
@endsection
{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    حركات مخزنية / المشتريات /تفاصيل الفاتورة
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers_with_order.index') }}"> فواتير المشتريات </a>
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
                    <h3 class="card-title card_title_center"> تفاصيل فاتورة المشتريات رقم :{{ $data['auto_serial'] }} </h3>
                </div>
                <input type="hidden" name="item_token" id="item_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ajax_get_uom_url" id="ajax_get_uom_url" value="{{ route('ajax_get_uom') }}">
                <input type="hidden" name="ajax_add_details_url" id="ajax_add_details_url"
                    value="{{ route('ajax_add_details_url') }}">


                <input type="hidden" name="autoserialParent" id="autoserialParent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" name="Parent_id" id="Parent_id" value="{{ $data['id'] }}">

                <input type="hidden" name="reload_parent_bill_Ajax_url" id="reload_parent_bill_Ajax_url"
                    value="{{ route('reload_parent_bill_Ajax') }}">

                <input type="hidden" name="reload_details_with_Ajax_url" id="reload_details_with_Ajax_url"
                    value="{{ route('reload_details_with_Ajax') }}">

                <input type="hidden" name="ajax_Edit_details_url" id="ajax_Edit_details_url"
                    value="{{ route('ajax_Edit_details_url') }}">

                <div class="card-body ">
                    <div id="reload_parent_bill_Ajax_Div">
                        @if (@isset($data) && !@empty($data))
                            <table id="example2"
                                class="table table-bordered table-hover"style="border-color:black;border-width:2px;">
                                <tr>
                                    <th class="col-4"> كود الفاتورة الالي</th>
                                    <td> {{ $data['auto_serial'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-4"> كود الفاتورة بأصل فاتورة المشتريات </th>
                                    <td> {{ $data['DOC_NO'] }}</td>
                                </tr>
                                <tr>
                                    <th class="col-4"> تاريخ الفاتورة </th>
                                    <td> {{ $data->order_date }}</td>
                                </tr>
                                <tr>
                                    <th class="col-4"> اسم المورد </th>
                                    <td> {{ $data->supplier_name }}</td>
                                </tr>
                                <tr>
                                    <th class="col-4"> نوع الدفع في الفاتورة </th>
                                    <td>
                                        @if ($data['bill_type'] == 1)
                                            <div class="bg-primary"> كاش </div>
                                        @elseif ($data['bill_type'] == 2)
                                            <div class="bg-warning"style="  box-sizing: border-box; ">
                                                آجل
                                            </div>
                                        @else
                                            غير محدد
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="col-4"> المخزن المستلم للبضاعة </th>
                                    <td> {{ $data->store_name }}</td>
                                </tr>
                                <tr>
                                    <input type="hidden" value="{{ $data->total_cost_befor_Descount }}"
                                        id="total_cost_befor">
                                    <th class="col-4"> إجمالي الفاتورة </th>
                                    <td id="ttotal">{{ $data->total_cost_befor_Descount * 1 }}</td>
                                </tr>
                                @if ($data['discount_type'] != null)
                                    <tr>
                                        <th class="col-4"> الخصم على الفاتورة </th>

                                        @if ($data['discount_type'] == 1)
                                            <td> خصم نسبة بمقدار:{{ $data->discount_percent * 1 }}% وقيمته
                                                :{{ $data->discount_value * 1 }}.YR </td>
                                        @elseif ($data['discount_type'] == 2)
                                            <td> خصم يدوي بقيمة : {{ $data->discount_value * 1 }}.YR</td>
                                        @endif
                                    </tr>
                                @else
                                    <tr>
                                        <th class="col-4"> الخصم على الفاتورة </th>
                                        <td> لا يوجد </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="col-4">نسبة القيمة المضافة </th>
                                    <td>
                                        @if ($data['tax_percent'] <= 0)
                                            لا يوجد
                                        @else
                                            بنسبة :{{ $data->tax_percent * 1 }}% وقيمتها
                                            :{{ $data->tax_value * 1 }}.YR
                                        @endif
                                    </td>
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
                                        @if ($data['updated_by'] != null)
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
                                        @else
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="col-4"> حالة الفاتورة </th>
                                    @if ($data->is_provide == 0)
                                        <td> (مفتوحة) </td>
                                    @else
                                        <td>مغلق ومؤرشفة </td>
                                    @endif
                                </tr>


                                <tr>
                                    <th class="col-4"> العمليات </th>
                                    <td class="control">
                                        <div style="display:flex;margin:5px;">
                                            @if ($data->is_provide == 0)
                                                <a href="{{ route('admin.suppliers_with_order.edit', [$data->id]) }}"
                                                    class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل </a>
                                            @endif
                                            <a href="{{ route('admin.suppliers_with_order.index') }}"
                                                class="btn btn-sm btn-dark "style="margin-right: 100px">
                                                رجوع </a>
                                        </div>
                                    </td>
                                </tr>
                            </table> <br>
                        @else
                            <div class="alert alert-danger">
                                عفوا لاتوجد تفاصيل !!
                            </div>
                        @endif
                    </div>
                    {{--  إضافة أصناف جديدة للفاتورة --}}
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="card-title card_title_center"> الأصناف المضافة للفاتورة
                                    رقم({{ $data->auto_serial }}) تبع المورد
                                    :{{ $data->supplier_name }}
                                    @if ($data->is_provide == 0)
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#add_item_modal">
                                            إضـــــافة صنف للفاتورة
                                        </button>
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div id="ajax_suppliers_Div_Details">
                        @if (@isset($details) && !@empty($details) && count($details) > 0)
                            <table id="example2" class="table table-bordered table-hover table-responsive">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
                                    <th> مسلسل </th>
                                    <th> الصنف</th>
                                    <th> الوحدة </th>
                                    <th> سعر الوحدة </th>
                                    <th> الكمية </th>
                                    <th> الإجمالي </th>
                                    <th> أضيفت بواسطة </th>
                                    <th> تاريخ الاضافة </th>
                                    <th> العمليات </th>
                                </thead>
                                <tbody style="text-align: center;">
                                    <?php $i = 0; ?>
                                    @foreach ($details as $T)
                                        <?php $i++; ?>
                                        <tr>
                                            <td> {{ $i }}</td>
                                            <td> {{ $T->item_card_name }}

                                                @if ($T->item_card_type == 2)
                                                    <br>
                                                    تاريخ الانتاج:{{ $T->production_date }}<br>
                                                    تاريخ الانتهاء:{{ $T->expire_date }}<br>
                                                @endif
                                            </td>
                                            <td> {{ $T->uom_name }}</td>
                                            <td> {{ $T->unit_price * 1 }}</td>
                                            <td> {{ $T->deliver_quantity * 1 }}</td>
                                            <td> {{ $T->total_price * 1 }}</td>
                                            <td> {{ $T->added_by }}</td>
                                            <td>
                                                @php
                                                    $dt = new DateTime($T->created_at);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h:i:s');
                                                    $dateTime = date('A', strtotime($time));
                                                    $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                                                @endphp
                                                {{ $date }}
                                                {{ $time }}
                                                {{ $dateTimtype }}
                                            </td>
                                            @if ($data->is_provide == 0)
                                                <td style=""class="control">
                                                    <div style="display:flex;margin:5px;">
                                                        <a href="#update_item_modal" style="margin-left: 5px" id="botn"
                                                            data-toggle="modal"
                                                            class="modal-effect btn btn-sm btn-info botn"
                                                            data-effect="effect-scale" data-id="{{ $T->id }}"
                                                            data-item_card_type="{{ $T->item_card_type }}"
                                                            data-item_card_name="{{ $T->item_card_name }}"
                                                            data-item_code="{{ $T->item_code }}"
                                                            data-uom_id="{{ $T->uom_id }}"
                                                            data-isparentuom="{{ $T->isparentuom }}"
                                                            data-uom_name="{{ $T->uom_name }}"
                                                            data-unit_price="{{ $T->unit_price * 1 }}"
                                                            data-expire_date="{{ $T->expire_date }}"
                                                            data-production_date="{{ $T->production_date }}"
                                                            data-total_price="{{ $T->total_price * 1 }}"
                                                            data-deliver_quantity="{{ $T->deliver_quantity * 1 }}"
                                                            title="تعديل">
                                                            تعديل صنف للفاتورة </a>

                                                        <button class="xxx">عرض مودل </button>
                                                        {{--  <a href="{{ route('admin.suppliers_with_order.edit', [$T->id]) }}"
                                                            class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                                                        </a>  --}}
                                                        <a href="#" class="btn btn-sm btn-danger are_you_sure"
                                                            data-toggle="modal">
                                                            حذف </a>
                                                    </div>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                عفوا لاتوجد بيانات !!
                            </div>
                        @endif

                        <div id="delivary"></div>
                        <div>
                            {{ $details->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rrr">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة صنف للفاتورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
            </div>
        </div>
    </div>

    {{--  ------ إضافة صنف للفاتورة -------  --}}
    <div class="modal fade" id="add_item_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة صنف للفاتورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body"id="add_item_modal_body" style="background: white !important;color:black">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                                <label for="item_code_Add">بيانات الأصناف :</label>
                                <select name="item_code_Add" id="item_code_Add" class="form-control select2  "
                                    data-placeholder=" اختر الصنف "style="width: 100%;">
                                    <option value=""> -- اختر الصنف -- </option>
                                    @if (isset($item_cards) && !@empty($item_cards))
                                        @foreach ($item_cards as $item)
                                            <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 related_to_itemCard" style="display:none" id="Get_Uoms">

                        </div>
                        <div class="col-md-4 related_to_itemCard "style="display:none">
                            <div class="form-group ">
                                <label for="quentity_ADD" class="control-label"> الكمية المستلمة
                                </label>
                                <input type="text" value="" class="form-control"
                                    oninput="this.value=this.value.replace(/[^'0-9']/g,'');" id="quentity_ADD"
                                    name="quentity_ADD" title=" ادخل الكمية المستلمة "
                                    placeholder="ادخل الكمية المستلمة ">
                            </div>
                        </div>
                        <div class="col-md-4 related_to_itemCard "style="display:none">
                            <div class="form-group ">
                                <label for="price_ADD" class="control-label"> سعر الوحدة
                                </label>
                                <input type="text" value="" class="form-control"
                                    oninput="this.value=this.value.replace(/[^'0-9.']/g,'');" id="price_ADD"
                                    name="price_ADD" title=" ادخل سعر الوحدة " placeholder="ادخل سعر الوحدة ">
                            </div>
                        </div>
                        <div class="col-md-4 related_to_date "style="display:none">
                            <div class="form-group ">
                                <label for="production_date" class="control-label"> تاريخ الإنتاج
                                </label>
                                <input type="date" style=" " value="" class="form-control"
                                    id="production_date" name="production_date" placeholder=" تاريخ الإنتاج ">
                            </div>
                        </div>
                        <div class="col-md-4 related_to_date "style="display:none">
                            <div class="form-group ">
                                <label for="expire_date" class="control-label"> تاريخ الإنتهاء
                                </label>
                                <input type="date" value="" class="form-control" id="expire_date"
                                    name="expire_date" placeholder=" تاريخ الإنتهاء ">
                            </div>
                        </div>
                        <div class="col-md-4 related_to_itemCard "style="display:none">
                            <div class="form-group ">
                                <label for="Total_Add" class="control-label"> الإجمالي
                                </label>
                                <input type="text" value="" class="form-control"
                                    oninput="this.value=this.value.replace(/[^'0-9.']/g,'');" id="Total_Add"
                                    name="Total_Add" placeholder=" الإجمالي " readonly>
                            </div>

                        </div>
                    </div>
                    <div class="col text-center">
                        <a type="button" class="btn  bg-success" id="addTobill">أضف للفاتورة</a>
                    </div>

                    <div class="col text-center ">
                        <div id="flag" class="flag"></div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">

                    <button type="button" class="btn btn-outline-light btn-danger" data-dismiss="modal">إغلاق</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--  ----- تعديل صنف في الفاتورة  --}}
    <div class="modal fade update_item_modal" id="update_item_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات الصنف</h5>
                    <button type="button" aria-label="Close" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="background-color: rgb(42, 199, 238)">


                    <input type="text" id="ttype" name="ttype" value="">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="" for="item_code_edit"> الصنف </label>
                            <select name="item_code_edit" id="item_code_edit" class="form-control ">
                                @if (isset($item_cards) && !@empty($item_cards) && count($item_cards) > 0 && count($details) > 0)
                                    @foreach ($item_cards as $item)
                                        <option  data-type="{{ $item->item_type }}"
                                            @if ($T->item_code == $item->item_code)class="item_card_name" id="item_card_name" selected="selected" @endif
                                            value="{{ $item->item_code }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('item_code_edit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4 get_uom_edit" id="get_uom_edit">
                            <div class="form-group">
                                <label for="uom_id"> وحدات الصنف:</label>
                                <select name="uom_id" id="uom_id" class="form-control">
                                    {{--  <option selected style="text-align: center" value="">-- حــــــدد اسم الصنف
                                        --</option>  --}}
                                    <option class="uom_name" name="" data-isparentuom="" id="uom_name"
                                        value="">
                                    </option>

                                </select>
                                @error('uom_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 get_uom_edit">
                            <div class="form-group">
                                <label for="deliver_quantity" class="">الكمية المستلمة </label>
                                <input class="form-control" id="deliver_quantity" name="deliver_quantity">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group get_uom_edit">
                                <label for="unit_price" class="">سعر الوحدة </label>
                                <input class="form-control" id="unit_price" name="unit_price">
                            </div>
                        </div>
                        <div class="col-4" id="production_dat">
                            <div class="form-group">
                                <label for="production_date_edit" class="">تاريخ الإنتاج </label>
                                <input type="date" class="form-control" id="production_date_edit"
                                    name="production_date_edit">
                            </div>
                        </div>
                        <div class="col-4" id="expire_dat">
                            <div class="form-group">
                                <label for="expire_date_edit" class="">تاريخ الانتهاء </label>
                                <input type="date" class="form-control" id="expire_date_edit"
                                    name="expire_date_edit">
                            </div>
                        </div>
                        <div class="col-4 get_uom_edit">
                            <div class="form-group">
                                <label for="total_price" class=""> الإجمالي </label>
                                <input class="form-control" id="total_price" name="total_price" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button id="Edit_To_bill" class="btn  btn-success" type="submit">تعديل </button>
                    <div id="flagg" class="flag"></div>
                    <button class="btn ripple btn-secondary" style="background:rgb(236, 13, 31)" data-dismiss="modal"
                        type="button">إغلاق</button>
                </div>
            </div>
        </div>
        <style>
            .flag {
                display: none;
                /* Add other common styles for the flag element */
            }

            .flag-success {
                display: block;
                background-color: #1e5807;
                color: #fff;
                animation: statusPulse 2s 1;
                display: none;
            }

            .flag-error {
                display: block;
                background-color: #f10404;
                color: #fff;
                animation: statusPulse 1s 1;

            }

            @keyframes statusPulse {
                0% {
                    transform: translate(0%, 0%) scale(.1);
                    opacity: .1;
                }

                100% {
                    transform: translate(0%, 0%) scale(2);
                    opacity: 2;
                }
            }
        </style>
    </div>




@section('script')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/suppliers_with_order.js') }}"></script>
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف        ")

            if (!res) {
                return false

            }

        })
    </script>
    <script>
        $('.select2').select2();
    </script>

    <script></script>
    <script>
        var $flagElement = $(".flag");

        function showSuccessFlag(message) {
            $flagElement.text(message);
            $flagElement.removeClass().addClass("flag flag-success").show();
            setTimeout(function() {
                $flagElement.hide();
            }, 2000);
        }

        function showErrorFlag(message) {
            $flagElement.text(message);
            $flagElement.removeClass().addClass("flag flag-error").show();
            setTimeout(function() {
                $flagElement.hide();
            }, 2000);
        }
    </script>
@endsection

@endsection
