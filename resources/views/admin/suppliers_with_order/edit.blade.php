{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    المشتريات /تعديل
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    {{--  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">  --}}
    {{--  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">  --}}
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    حركات مخزنية / المشتريات / تعديل
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers_with_order.index') }}"> فواتير المشتريات </a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(12, 123, 138);color:aliceblue">
                @if (@isset($data) && !@empty($data))
                    @if ($data->is_provide == 0)
                        <div class="card-header" style="background:rgb(247, 247, 250);">
                            <h3 class="card-title card_title_center"
                                style="font-size: 30px;font-family: ;color:rgb(30, 15, 248)">
                                تعديل فاتورة مشتريات رقم :({{ $data->DOC_NO }})
                            </h3>
                        </div>
                        <div class="card-body" style="overflow-x:auto;background:rgb(3, 47, 53)">
                            <form action="{{ route('admin.suppliers_with_order.update', [$data->id]) }}" method="post"
                                autocomplete="off">
                                {{--  {{ method_field('patch') }}  --}}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="DOC_NO" class="control-label"> رقم الفاتورة المسجل بأصل المشتريات
                                            :</label>
                                        <input type="number" class="form-control " id="DOC_NO" name="DOC_NO"
                                            value="{{ old('DOC_NO', $data->DOC_NO) }}" placeholder="رقم الفاتورة ">
                                        @error('DOC_NO')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="order_date" class="control-label"> تاريخ الفاتورة :</label>
                                        <input type="date" value="{{ old('date', $data->order_date) }}" class="form-control "
                                            id="order_date" name="order_date" placeholder="تاريخ الفاتورة   ">
                                        @error('order_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="supplier_code" class="control-label">بيانات الموردين :</label>
                                        <select name="supplier_code" id="supplier_code" class="form-control select2 ">
                                            <option disabled selected style="text-align: center" value="">-- حــــــدد
                                                اسم
                                                المورد
                                                --</option>
                                            @if (isset($suppliers) && !@empty($suppliers))
                                                @foreach ($suppliers as $sup)
                                                    <option @if (old('supplier_code', $data->supplier_code) == $sup->supplier_code) selected="selected" @endif
                                                        value="{{ $sup->supplier_code }}">{{ $sup->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('supplier_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="store_id" class="control-label">بيانات المخازن :</label>
                                            <select name="store_id" id="store_id" class="form-control select2 ">
                                                <option disabled selected style="text-align: center" value="">--
                                                    حــــــدد
                                                    اسم المخزن
                                                    المستلم للفاتورة
                                                    --</option>
                                                @if (isset($stores) && !@empty($stores))
                                                    @foreach ($stores as $str)
                                                        <option @if (old('store_id', $data->store_id) == $str->id) selected="selected" @endif
                                                            value="{{ $str->id }}">{{ $str->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('store_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="bill_type" class="control-label"> نوع الفاتورة </label>
                                        <select name="bill_type" id="bill_type" class="form-control">
                                            <option disabled selected style="text-align: center" value="">
                                                --اختــــــر
                                                نـــــوع
                                                الفاتورة-- </option>
                                            <option class="bg-primary"
                                                @if (old('bill_type', $data->bill_type) == 1) selected="selected" @endif value="1">
                                                كــــاش </option>
                                            <option class="bg-warning"
                                                @if (old('bill_type', $data->bill_type) == 2) selected="selected" @endif value="2">
                                                آجــــل </option>

                                        </select>
                                        @error('bill_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="is_provide" class="control-label "> هل الفاتورة معتمدة ؟ </label>
                                        <select name="is_provide" id="is_provide" class="form-control">
                                            <option disabled  style="text-align: center" value="">
                                                --اختــــــــر
                                                حـــــــــالة
                                                الاعتماد-- </option>
                                            <option @if (old('is_provide', $data->is_provide) == 0 and old('is_provide') != '') selected="selected" @endif
                                                value="0">
                                                لا </option>
                                            <option @if (old('is_provide', $data->is_provide) == 1) selected="selected" @endif
                                                value="1">
                                                نعم </option>
                                        </select>
                                        @error('is_provide')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="notes" class="control-label"> ملاحظات :</label>
                                        <input type="text" class="form-control " id="notes" name="notes"
                                            value="{{ old('notes', $data->notes) }}" placeholder="ملاحظات   ">
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center">
                                    <tr>
                                        <td>
                                            <button type="submit" class="btn btn-sm  btn-primary"style="margin: 10px">
                                                تـعــديل</button>
                                        </td>
                                        <td> <a href="{{ route('admin.suppliers_with_order.index') }}"
                                                class="btn btn-sm btn-danger"style="margin: 10px"> إلغاء
                                            </a>
                                        </td>

                                    </tr>
                                </div>
                            </form>

                        </div>
                    @else
                        <div class="text-center alert alert-danger">
                            عفوا غير مسموح بتعديل بيانات هذه الفاتورة !!
                        </div>
                        <div class="text-center"> <a href="{{ route('admin.suppliers_with_order.index') }}"
                                class="btn btn-sm btn-dark align-center"style="margin: 10px"> رجوع
                            </a>
                        </div>

                    @endif
                @else
                    <div class="text-center alert alert-danger">
                        عفوا لاتوجد بيانات لتعديلها !!

                    </div>
                    <div class="text-center"> <a href="{{ route('admin.suppliers_with_order.index') }}"
                            class="btn btn-sm btn-dark"style="margin: 10px"> رجوع
                        </a>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
@endsection
