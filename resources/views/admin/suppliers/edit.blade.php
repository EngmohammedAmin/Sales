{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الموردين / تعديل
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحسابات / الموردين / تعديل
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.account.index') }}"> بيانات الموردين </a>
@endsection


@section('contentheaderactive')
    تعديل مورد
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

{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(6, 70, 78)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">تعديل بيانات مورد :
                        ( {{ $data->name }}) </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(15, 86, 94);color:white">
                    <form action="{{ route('admin.suppliers.update', [$data->id]) }}" method="post" autocomplete="off"
                        style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        @if (@isset($data) && !@empty($data))
                            {{--  row1  --}}
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="control-label">إسم المورد </label>
                                    <input type="text" class="form-control " id="name"
                                        name="name"value="{{ old('name', $data->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="suppliers_categories_id" class="control-label"> فـــئة المـــوردين :</label>
                                    <select name="suppliers_categories_id" id="suppliers_categories_id"
                                        class="form-control ">
                                        <option selected style="text-align: center" value="">-- اختر
                                            فئة المورد

                                            --</option>
                                        @if (isset($suppliers_categories) && !@empty($suppliers_categories))
                                            @foreach ($suppliers_categories as $par)
                                                <option @if (old('suppliers_categories_id', $data->suppliers_categories_id) == $par->id) selected="selected" @endif
                                                    value="{{ $par->id }}">{{ $par->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('suppliers_categories_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="address" class="control-label"> العنوان :</label>
                                    <input type="textarea" class="form-control " id="address" name="address"
                                        value="{{ old('address', $data->address) }}" placeholder="ملاحظات   ">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">
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
                                <div class="col">
                                    <label for="notes" class="control-label"> ملاحظات :</label>
                                    <input type="textarea" class="form-control " id="notes" name="notes"
                                        value="{{ old('notes', $data->notes) }}" placeholder="ملاحظات   ">
                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <tr>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-primary"style="margin: 10px">حفظ
                                            التعديل</button>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.suppliers.index') }}"
                                            class="btn btn-sm btn-danger "style="margin: 10px">
                                            إلغاء </a>
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
@section('script')
    <script src="{{ asset('assets/admin/js/suppliers.js') }}"></script>
@endsection
