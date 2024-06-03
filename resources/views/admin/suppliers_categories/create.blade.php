{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    فئات الموردين /إضافة
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحســـــابات/فئات الموردين / إضافة
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers_categories.index') }}">فئات الموردين</a>
@endsection

@section('contentheaderactive')
    إضافة فئة مورد جديدة
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">إضافة فئة مورد جديدة </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(9, 72, 80);color:aliceblue">
                    <form action="{{ route('admin.suppliers_categories.store') }}" method="post" autocomplete="off"
                        style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">اسم الفئة</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" placeholder="ادخل اسم الفئة">
                                @error('name')
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
                        </div>
                        <br>

                        <div class="d-flex justify-content-center">
                            <tr>
                                <td>
                                    <button type="submit" class="btn btn-sm  btn-primary"style="margin: 10px">
                                        إضـــافة</button>
                                </td>
                                <td> <a href="{{ route('admin.suppliers_categories.index') }}"
                                        class="btn btn-sm btn-danger"style="margin: 10px"> إلغاء
                                    </a>
                                </td>

                            </tr>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
