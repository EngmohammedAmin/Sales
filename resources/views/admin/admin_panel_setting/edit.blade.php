{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    تعديل بيانات الضبط العام
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    تعديل
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsetting.edit') }}">الضبط</a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">تعديل بيانات الضبط العام لشركة : ({{ $data->system_name }}) </h3>
                </div>
                <div class="card-body " style="overflow-x:auto;background:rgb(20, 91, 100);color:aliceblue">
                    <form action="{{ route('admin.adminpanelsetting.update') }}" method="post" autocomplete="off"
                        style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        @if (@isset($data) && !@empty($data))
                            {{--  row1  --}}
                            <div class="row"style="margin-top: 10px">
                                <div class="col">
                                    <label class="form-label"><strong>اســــم الشركــــة :</strong></label>
                                    <input type="text" class="form-control" id="system_name" name="system_name"
                                        placeholder="اسم الشركة" style="color:blue;"
                                        oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}"
                                        value="{{ old('system_name', $data['system_name']) }}">
                                    @error('system_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col">
                                    <label class="form-label"><strong>كــــود الشركــــة :</strong></label>
                                    <input type="text" class="form-control" id="com_code"
                                        placeholder="كود الشركة"oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}" name="com_code"style="color:blue"
                                        value="{{ old('com_code', $data['com_code']) }}">
                                    @error('com_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label"><strong>حــــالة الشركــــة :</strong></label>

                                    <select name="active" id="active" class="form-control" style="color:blue">
                                        <option value="">-- اختر حالة التفعيل --

                                        </option>
                                        <option
                                            {{ old('active', $data->active) == 0 && old('active', $data->active) != '' ? 'selected' : '' }}
                                            value="0">
                                            غير مفعل
                                        </option>
                                        <option {{ old('active', $data->active) == 1 ? 'selected' : '' }} value="1">
                                            مفعل

                                        </option>
                                    </select>
                                    @error('active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><br>
                            {{--  row 2  --}}
                            <div class="row"style="margin-top: 10px">
                                <div class="col">
                                    <label class="form-label"><strong>عنــــوان الشركــــة :</strong></label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="عنوان الشركة"oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}" name="address"style="color:blue"
                                        value="{{ old('address', $data['address']) }}"required>

                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label"><strong>رقــــم الشركــــة :</strong></label>
                                    <input type="text" class="form-control" id="phone"
                                        placeholder="رقم الشركة"oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}" name="phone"style="color:blue"
                                        value="{{ old('phone', $data['phone']) }}"required>

                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label"><strong>إشعــــار عـــام الشركــــة :</strong></label>
                                    <input type="text" class="form-control"
                                        id="general_alert"oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}"
                                        name="general_alert"style="color:blue" placeholder="إشعار عام الشركة"
                                        value=" {{ old('general_alert', $data['general_alert']) }}"required>

                                    @error('general_alert')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><br>
                            {{--  row3  --}}
                            <div class="row"style="margin-top: 10px">
                                <div class="col" id="parentDiv">
                                    <label for="customer_parent_account_number" class="control-label "> الحسابات الأب
                                        للعملاء بالشجرة المحاسبية :
                                    </label>
                                    <select name="customer_parent_account_number" id="customer_parent_account_number"
                                        class="form-control "style="color:blue">
                                        <option selected style="text-align: center" value="">-- اختر
                                            الحســـــاب الأب للعملاء

                                            --</option>
                                        @if (isset($parent_accounts) && !@empty($parent_accounts))
                                            @foreach ($parent_accounts as $acc)
                                                <option @if (old('customer_parent_account_number', $data->customer_parent_account_number) == $acc->account_number) selected="selected" @endif
                                                    value="{{ $acc->account_number }}">{{ $acc->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('customer_parent_account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col" id="">
                                    <label for="supplier_parent_account_number" class="control-label "> الحسابات الأب
                                        للموردين بالشجرة المحاسبية :
                                    </label>
                                    <select name="supplier_parent_account_number" id="supplier_parent_account_number"
                                        class="form-control "style="color:blue">
                                        <option selected style="text-align: center" value="">-- اختر
                                            الحســـــاب الأب للموردين

                                            --</option>
                                        @if (isset($parent_accounts) && !@empty($parent_accounts))
                                            @foreach ($parent_accounts as $acc)
                                                <option @if (old('supplier_parent_account_number', $data->supplier_parent_account_number) == $acc->account_number) selected="selected" @endif
                                                    value="{{ $acc->account_number }}">{{ $acc->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('supplier_parent_account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <label class="form-label"><strong> اضيفت بواسطة :</strong></label>
                                    <input type="text" class="form-control" id="added_by"
                                        placeholder="أضيفت بواسطة "oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}" name="added_by"style="color:blue"
                                        value="{{ old('added_by', $data['added_by']) }}" readonly>
                                </div>
                                <div class="col">
                                    <label class="form-label"><strong> تاريخ الاضافة:</strong></label>
                                    <input type="text" class="form-control"
                                        id="created_at"oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')"
                                        onchange="try{setCustomValidity('')}catch(e){}" placeholder="تاريخ الانشاء"
                                        name="created_at"style="color:blue"
                                        value="{{ old('created_at', $data['created_at']) }}"@readonly(true)>
                                </div>
                            </div>
                            {{--  row 4  --}}
                            <div class="row">
                                <div class="col">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="form-group text-center" style="width: 100%">
                                    <label class="form-label"><strong>شعار الشركة :</strong></label>
                                    <div class="image">
                                        <img class="custom_img"
                                            src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}"
                                            alt="شعار الشركة" style="width:50;hieght:50">
                                        <button class="btn btn-sm btn-success" id="update_img"> تغيير الصورة </button>
                                        <button class="btn btn-sm btn-danger" id="cancel_update" style="display: none">
                                            إلغاء
                                        </button>
                                    </div>
                                    <div id="oldimage" style="margin-top:10px ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-sm btn-primary"style="margin: 10px">
                                    حفظ
                                    البيانات</button>

                                <a href="{{ route('admin.adminpanelsetting.index') }}"
                                    class="btn btn-sm btn-danger"style="margin: 10px">
                                    إلغاء
                                </a>

                            </div>
                    </form>
                @else
                    <div class="alert alert-danger">
                        عفوا لاتوجد بيانات !!

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
