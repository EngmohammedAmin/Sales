{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    العملاء / إضافة
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحسابات / العملاء / إضافة
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.account.index') }}"> بيانات العملاء </a>
@endsection


@section('contentheaderactive')
    إضافة عميل
@endsection
{{--  @section('css')  --}}
<style>
    input.form-control {
        background: #ced4da;
    }

    select.form-control {
        background: #ced4da;
    }
</style>

{{--  @endsection  --}}
{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row ">
        <div class="col-12 ">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> إضافة حساب عميل جديد </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(92, 8, 88);color:white">
                    <form action="{{ route('admin.customers.store') }}" method="post" autocomplete="off" style=""
                        enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">اسم العميل :</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" placeholder="ادخل اسم العميل ">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="start_balance_status" class="control-label">حالة رصيد اول المدة :</label>
                                <select name="start_balance_status" id="start_balance_status" class="form-control"
                                    style="color:blue">
                                    <option selected style="text-align: center" value="">-- اختــــــــر --
                                    </option>
                                    <option {{ old('start_balance_status') == 1 ? 'selected' : '' }} value="1">
                                        دائن
                                    </option>
                                    <option {{ old('start_balance_status') == 2 ? 'selected' : '' }} value="2">
                                        مدين
                                    </option>
                                    <option {{ old('start_balance_status') == 3 ? 'selected' : '' }} value="3">
                                        متزن
                                    </option>
                                </select>
                                @error('start_balance_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="start_balance" class="control-label"> رصيد أول المدة للحساب :</label>
                                <input type="text" class="form-control " id="start_balance" name="start_balance"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                    value="{{ old('start_balance') }}" placeholder="ادخل رصيد الحساب ">
                                @error('start_balance')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="address" class="control-label"> العنوان :</label>
                                <input type="text" class="form-control " id="address" name="address"
                                    value="{{ old('address') }}" placeholder="ادخل عنوان العميل ">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="active" class="control-label "> حالة التفعيل : </label>

                                <select name="active" id="active" class="form-control" style="color:blue">
                                    <option selected style="text-align: center" value="">-- اختر --

                                    </option>
                                    <option {{ old('active') == 0 && old('active') != '' ? 'selected' : '' }}
                                        value="0">
                                        غير مفعل
                                    </option>
                                    <option {{ old('active') == 1 ? 'selected' : '' }} value="1">
                                        مفعل

                                    </option>
                                </select>
                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="notes" class="control-label"> ملاحظات :</label>
                                <input type="textarea" class="form-control " id="notes" name="notes"
                                    value="{{ old('notes') }}" placeholder="ملاحظات   ">
                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                </div>
                <br>

                <div class="d-flex justify-content-center">
                    <tr>
                        <td>
                            <button id="do_Add_item_card" type="submit"
                                class="btn btn-sm  btn-primary"style="margin: 10px">
                                إضـــافة</button>
                        </td>
                        <td> <a href="{{ route('admin.customers.index') }}"
                                class="btn btn-sm btn-danger"style="margin: 10px">
                                إلغاء
                            </a>
                        </td>

                    </tr>
                </div>
                </form>
            </div>
        </div><br><br>


    </div>
    </div>
    <br>
@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
@endsection
