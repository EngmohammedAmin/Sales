{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    عرض تفاصيل العملاء
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحسابات / تفاصيل / العملاء
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.customers.index') }}">  العملاء </a>
@endsection

@section('contentheaderactive')
    عرض التفاصيل
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <style>
        label {
            color: #0d032b;
            /* Text color */
            font-size: 16px;
            /* Font size */
            font-weight: bold;
            /* Font weight */
            margin-bottom: 5px;
            text-decoration-line: underline;
            /* Bottom margin */
            /* Additional styles */
        }
    </style>
    <style>
        .row {
            color: #490bf1;
            font-weight: bold;

        }

        .row {
            border: 1px solid #000;
            /* Border style */
            padding: 20px;
            /* Optional padding */
        }
    </style>
    <div class="r">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class=" card_title_center">عرض بيانات الصنف : (<span
                            style="color:white;  background: rgb(40, 10, 209)">{{ $data->name }}</span>)</h3>
                </div>
                <div class="card-body " style="overflow-x:auto;">
                    @if (@isset($data) && !@empty($data))
                        <div class="row ">
                            <div class="col">
                                <label>كود الصنف الثابت من النظام </label><br>
                                {{ $data['item_code'] }}
                            </div>
                            <div class="col">
                                <label> كود الشركة </label> <br>
                                {{ $data['com_code'] }}
                            </div>

                            <div class="col">
                                <label> اسم الصنف</label><br>
                                {{ $data['name'] }}
                            </div>

                            <div class="col">
                                <label>باركود الصنف </label><br>
                                {{ $data['barcode'] }}
                            </div>


                        </div>

                        <div class="row">
                            <div class="col">
                                <label>نوع الصنف </label><br>

                                @if ($data->item_type == 1)
                                    <span class="bg-primary"> مخزني </span>
                                @elseif ($data->item_type == 2)
                                    <span class="bg-warning"> استهلاكي بصلاحية </span>
                                @elseif ($data->item_type == 3)
                                    <span class="bg-teal"style="  box-sizing: border-box; "> عهدة
                                    </span>
                                @else
                                    <div class="bg-danger"> غير محدد </div>
                                @endif

                            </div>
                            <div class="col">
                                <label> فئة الصنف </label><br>
                                {{ $data['item_card_categories_name'] }}
                            </div>
                            <div class="col">
                                <label> الصنف الأب له </label><br>
                                {{ $data['parent_inv_item_card_name'] }}
                            </div>
                            <div class="col">
                                <label> الوحدة الأب له </label><br>
                                {{ $data['uom_name'] }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>السعر القطاعي لوحدة الأب:(<span
                                        style="background: rgb(23, 228, 23)">{{ $data->uom_name }}</span>) </label><br>
                                {{ $data['price'] * 1 }}
                            </div>
                            <div class="col">
                                <label> سعر جملة بوحدة الأب:(<span
                                        style="background: rgb(23, 228, 23)">{{ $data->uom_name }}</span>)
                                </label><br>
                                {{ $data['gomla_price'] * 1 }}
                            </div>
                            <div class="col">
                                <label> سعر النصف جملة بوحدة:(<span
                                        style="background: rgb(23, 228, 23)">{{ $data->uom_name }}</span>) </label><br>
                                {{ $data['half_gomla_price'] * 1 }}
                            </div>
                            <div class="col">
                                <label> سعر الشراء لوحدة الأب:(<span
                                        style="background: rgb(23, 228, 23)">{{ $data->uom_name }}</span>) </label><br>
                                {{ $data['cost_price'] * 1 }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label> هل له وحدة تجزئة؟ </label><br>

                                @if ($data['does_has_retailUnit'] == 1)
                                    <span class="bg-success"> نعم </span>
                                @else
                                    <span class="bg-danger"style="  box-sizing: border-box; "> لا </span>
                                @endif

                            </div>
                            <div class="col"@if ($data['does_has_retailUnit'] != 1) style="display: none" @endif>
                                <label> وحـــــــــــدات القياس التجزئة الأبن بالنسبة للأب :(<span
                                        style="background:rgb(23, 228, 23)">{{ $data->uom_name }}</span>) </label><br>
                                <td> {{ $data['retail_uom_name'] }}</th>

                            </div>
                            <div class="col"@if ($data['does_has_retailUnit'] != 1) style="display: none" @endif>
                                <label> عدد وحدات التجزئة :(<span
                                        style="background: yellow">{{ $data->retail_uom_name }}</span>) بالنسبة للأب
                                    :(<span style="background: rgb(23, 228, 23)">{{ $data->uom_name }}</span>) </label><br>
                                {{ $data['retail_uom_quentityToParent'] * 1 }}
                            </div>
                        </div>
                        <div @if ($data['does_has_retailUnit'] != 1) style="display: none" @endif>


                            <div class="row">
                                <div class="col">
                                    <label> سعر القطاعي بوحدة قياس التجزئة:(<span
                                            style="background: yellow">{{ $data->retail_uom_name }}</span>) </label><br>
                                    {{ $data['price_retail'] * 1 }}</td>
                                </div>
                                <div class="col">
                                    <label> سعر النص جملة قطاعي بوحدة التجزئة:(<span
                                            style="background: yellow">{{ $data->retail_uom_name }}</span>) </label><br>
                                    {{ $data['half_gomla_price_retail'] * 1 }}
                                </div>

                                <div class="col">
                                    <label> سعر الجملة بوحدة التجزئة:(<span
                                            style="background: yellow">{{ $data->retail_uom_name }}</span>) </label><br>
                                    {{ $data['gomla_price_retail'] * 1 }}
                                </div>
                                <div class="col">
                                    <label> سعر الشراء بوحدة التجزئة:(<span
                                            style="background: yellow">{{ $data->retail_uom_name }}</span>) </label><br>
                                    {{ $data['cost_price_retail'] * 1 }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label> هل للصنف سعر ثابت للفواتيير؟ : </label><br>


                                @if ($data['has_fixed_price'] == 1)
                                    <span class="bg-success"> نعم </span>
                                @else
                                    <span class="bg-danger"style="  box-sizing: border-box; "> لا </span>
                                @endif


                            </div>
                            <div class="col">
                                <label> حــــــــــالة التفعيل : </label><br>

                                @if ($data['active'] == 1)
                                    <span class="bg-success"> مفعل </span>
                                @else
                                    <span class="bg-danger"style="  box-sizing: border-box; "> غير مفعل </span>
                                @endif
                            </div>
                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col">
                                <label> أضيف بواسطة </label><br>
                                {{ $data['added_by'] }}
                            </div>
                            <div class="col">
                                <label> تاريخ الاضافة </label><br>
                                @php
                                    $dt = new DateTime($data->created_at);
                                    $date = $dt->format('Y-m-d');
                                    $time = $dt->format('h:i:s');
                                    $dateTime = date('A', strtotime($time));
                                    $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';

                                @endphp
                                {{ $date }}<br>
                                {{ $time }}<br>
                                {{ $dateTimtype }}
                            </div>
                            <div class="col">
                                <label> تم التعديل بواسطة </label><br>
                                {{ $data['updated_by'] }}
                            </div>
                            <div class="col">
                                <label> تاريخ التعديل </label><br>
                                @if ($data->updated_by > 0 and $data->updated_by != null)
                                    @php
                                        $dt = new DateTime($data->updated_at);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('h:i:s');
                                        $dateTime = date('A', strtotime($time));
                                        $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';

                                    @endphp
                                    {{ $date }}<br>
                                    {{ $time }}<br>
                                    {{ $dateTimtype }}
                                @else
                                    لايوجد تحديث
                                @endif
                            </div>
                        </div>
                        <br><br>
                        {{--  <div class="" >  --}}
                        <div class="image card " style="align-items: center">
                            <label> صورة الصنف </label>

                            <img class="custom_img"style=""
                                src="{{ asset('assets/admin/uploads/item_img') . '/' . $data['item_img'] }}"
                                alt=" صورة الصنف" style="width:50;hieght:50">
                        </div>
                        {{--  </div>  --}}

                        <div style=""class="">
                            <div style="display:flex;margin-right:500px;margin-top:5px;">
                                <a href="{{ route('inv_item_card.index') }}" class="btn btn-sm btn-dark"
                                    style="margin-left: 5px"> رجــــــــوع </a>
                                <a href="{{ route('inv_item_card.edit', [$data->id]) }}" class="btn btn-sm btn-primary"
                                    style="margin-right: 5px"> تعــــديل
                                </a>
                            </div>


                        </div>



                        <br>
                    @else
                        <div class="alert alert-danger">
                            عفوا لاتوجد بيانات !!

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>




@section('script')
    <script></script>
@endsection


@endsection
