{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    تعديل حساب مالي
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الحسابات المالية
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.account.index') }}"> الحسابات المالية </a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(6, 70, 78)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">تعديل بيانات الحساب المالي :
                        {{ $data->name }} </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(15, 86, 94);color:white">
                    <form action="{{ route('admin.account.update', [$data->id]) }}" method="post" autocomplete="off"
                        style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        @if (@isset($data) && !@empty($data))
                            {{--  row1  --}}
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="control-label">إسم الحساب المالي</label>
                                    <input type="text" class="form-control " id="name"
                                        name="name"value="{{ $data->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="account_types_id" class="control-label "> نوع الحساب : </label>
                                    <select name="account_types_id" id="account_types_id" class="form-control"
                                        value="">
                                        <option selected style="text-align: center" value="">-- حــــــدد نـــــوع
                                            الحســـــــــاب
                                            --</option>
                                        @if (isset($account_types) && !@empty($account_types))
                                            @foreach ($account_types as $acc)
                                                <option @if (old('account_types_id', $data->account_types_id) == $acc->id) selected="selected" @endif
                                                    value="{{ $acc->id }}">{{ $acc->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('account_types_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="is_parent" class="control-label "> هل أب ؟ </label>
                                    <select name="is_parent" id="is_parent" class="form-control ">
                                        <option style="text-align: center" value="">-- اختـــــــــــر --
                                        </option>
                                        <option
                                            {{ old('is_parent', $data->is_parent) == 0 && old('is_parent', $data->is_parent) != '' ? 'selected' : '' }}
                                            value="0">
                                            لا </option>
                                        <option {{ old('is_parent', $data->is_parent) == 1 ? 'selected' : '' }}
                                            value="1">
                                            نعم </option>

                                    </select>
                                    @error('is_parent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col" id="parentDiv"
                                    @if (old('is_parent', $data->is_parent) == 1 || old('is_parent', $data->is_parent) == '') style="display: none" @else style="display:true" @endif>
                                    <label for="parent_account_number" class="control-label "> الحسابات المالية الأب :
                                    </label>
                                    <select name="parent_account_number" id="parent_account_number" class="form-control ">
                                        <option selected style="text-align: center" value="">-- اختر
                                            الحســـــاب الأب

                                            --</option>
                                        @if (isset($parent_accounts) && !@empty($parent_accounts))
                                            @foreach ($parent_accounts as $par)
                                                <option @if (old('parent_account_number', $data->parent_account_number) == $par->account_number) selected="selected" @endif
                                                    value="{{ $par->account_number }}">{{ $par->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('parent_account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col" id="supp_cats"
                                    @if (old('is_parent', $data->is_parent) == 1 ||
                                            old('is_parent', $data->is_parent) == '' ||
                                            (old('account_types_id', $data->account_types_id) != 2 and
                                                old('parent_account_number', $data->parent_account_number) != 9)) style="display: none" @endif>
                                    <label for="suppliers_categories_id" class="control-label "> فئات الموردين :
                                    </label>
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
                                    <label for="is_archived" class="control-label "> هل مؤرشفة ؟ : </label>

                                    <select name="is_archived" id="is_archived" class="form-control" style="color:blue">
                                        <option selected style="text-align: center" value="">-- اختر --

                                        </option>
                                        <option
                                            {{ old('is_archived', $data->is_archived) == 0 && old('is_archived', $data->is_archived) != '' ? 'selected' : '' }}
                                            value="0">
                                            مؤرشف
                                        </option>
                                        <option {{ old('is_archived', $data->is_archived) == 1 ? 'selected' : '' }}
                                            value="1">
                                            مفعل

                                        </option>
                                    </select>
                                    @error('is_archived')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="notes" class="control-label"> ملاحظات :</label>
                                    <input type="textarea" class="form-control " id="notes" name="notes"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
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
                                        <a href="{{ route('admin.account.index') }}"
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>


@endsection
