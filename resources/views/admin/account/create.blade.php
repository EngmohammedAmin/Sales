{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    إضافة حساب مالي
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
    إضافة حساب
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
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> إضافة حساب مالي جديد </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(12, 2, 53);color:white">
                    <form action="{{ route('admin.account.store') }}" method="post" autocomplete="off" style=""
                        enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col">
                                <label for="name" class="control-label">اسم الحساب المالي :</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" placeholder="ادخل اسم الحساب المالي">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="account_types_id" class="control-label "> نوع الحساب : </label>
                                <select name="account_types_id" id="account_types_id" class="form-control  "
                                    onchange="console.log('change is firing')">
                                    <option selected style="text-align: center" value="">-- حــــــدد نـــوع
                                        الحســـــاب

                                        --</option>
                                    @if (isset($account_types) && !@empty($account_types))
                                        @foreach ($account_types as $acc)
                                            <option @if (old('account_types_id') == $acc->id) selected="selected" @endif
                                                value="{{ $acc->id }}">{{ $acc->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('account_types_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="is_parent"> هل الحساب أب ؟ :</label>
                                <select name="is_parent" id="is_parent" class="form-control" style="color:blue">
                                    <option selected style="text-align: center" value="">-- اختــــــــر --

                                    </option>
                                    <option {{ old('is_parent') == 1 ? 'selected' : '' }} value="1">
                                        نعم
                                    </option>
                                    <option {{ old('is_parent') == 0 && old('is_parent') != '' ? 'selected' : '' }}
                                        value="0">
                                        لا

                                    </option>
                                </select>
                                @error('is_parent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div><br>
                        <div class="row">

                            <div class="col" id="parentDiv"
                                @if (old('is_parent') == 1 || old('is_parent') == '') style="display: none" @endif>
                                <label for="parent_account_number" class="control-label "> الحسابات المالية الأب : </label>
                                <select name="parent_account_number" id="parent_account_number" class="form-control ">
                                    <option selected style="text-align: center" value="">-- اختر
                                        الحســـــاب الأب

                                        --</option>
                                    @if (isset($parent_accounts) && !@empty($parent_accounts))
                                        @foreach ($parent_accounts as $acc)
                                            <option @if (old('parent_account_number') == $acc->account_number) selected="selected" @endif
                                                value="{{ $acc->account_number }}">{{ $acc->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('parent_account_number')
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
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="is_archived" class="control-label "> هل مؤرشفة ؟ : </label>

                                <select name="is_archived" id="is_archived" class="form-control" style="color:blue">
                                    <option selected style="text-align: center" value="">-- اختر --

                                    </option>
                                    <option {{ old('is_archived') == 0 && old('is_archived') != '' ? 'selected' : '' }}
                                        value="0">
                                        مؤرشف
                                    </option>
                                    <option {{ old('is_archived') == 1 ? 'selected' : '' }} value="1">
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
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'');" value="{{ old('notes') }}"
                                    placeholder="ملاحظات   ">
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
                        <td> <a href="{{ route('admin.account.index') }}"
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
