{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    إضافة فئة مخزن جديد
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    المخازن
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}"> المخازن </a>
@endsection

@section('contentheaderactive')
    إضافة مخزن
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">إضافة مخزن جديد </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(129, 144, 146)">
                    <form action="{{ route('admin.stores.store') }}" method="post" autocomplete="off" style=""
                        enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">اسم المخزن</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" placeholder="ادخل اسم المخزن" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="active" class="control-label "> الحالة </label>
                                <select name="active" id="active" class="form-control" required>
                                    <option selected disabled> --اختر حالة المخزن-- </option>
                                    <option
                                        @if (old('active') == 0) and old('active') !="" selected="selected" @endif
                                        value="0"> غير
                                        مفعلة </option>
                                    <option @if (old('active') == 1) selected="selected" @endif value="1">
                                        مفعلة </option>

                                </select>
                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="address" class="control-label">عنوان المخزن</label>
                                <input type="text" class="form-control " id="address" name="address"
                                    value="{{ old('address') }}" placeholder="ادخل عنوان المخزن" required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="phones" class="control-label">هاتف المخزن</label>
                                <input type="text" class="form-control " id="phones" name="phones"
                                    value="{{ old('phones') }}" placeholder="ادخل هاتف المخزن" required>
                                @error('phones')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>
            <br>

            <div class="d-flex justify-content-center">
                <tr>
                    <td>
                        <button type="submit" class="btn btn-sm  btn-primary"style="margin: 10px">
                            إضـــافة</button>
                    </td>
                    <td> <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-danger"style="margin: 10px">
                            إلغاء
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
