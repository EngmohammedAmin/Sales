{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    فئات الموردين / تعديل
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحســـــابات/فئات الموردين / تعديل
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers_categories.index') }}">فئات الموردين</a>
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
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> تعديل بيانات فئة المورد:
                        ( {{ $data->name }}) </h3>
                </div>
                <div class="card-body " style="overflow-x:auto;background:rgb(173, 238, 247)">
                    <form action="{{ route('admin.suppliers_categories.update', [$data->id]) }}" method="post" autocomplete="off"
                        style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        @if (@isset($data) && !@empty($data))
                            {{--  row1  --}}
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="control-label">إسم الحساب المالي</label>
                                    <input type="text" class="form-control " id="name"
                                        name="name"value="{{ old('name', $data->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="active" class="control-label "> حــــالة التفعيل: </label>
                                    <select name="active" id="active" class="form-control" style="color:blue">
                                        <option selected style="text-align: center" value="">-- اختر --
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
                            </div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-primary"style="margin: 10px">حفظ
                                            تعديل البيانات</button>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.suppliers_categories.index') }}"
                                            class="btn btn-sm btn-dark "style="margin: 10px">
                                            رجوع </a>
                                    </td>
                                </tr>
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
