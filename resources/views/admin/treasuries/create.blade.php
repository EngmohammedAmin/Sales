{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    إضافة خزنة جديدة
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الخزانات
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزانة</a>
@endsection

@section('contentheaderactive')
    إضافة خزنة
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif">إضافة خزنة جديدة </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(129, 144, 146)">
                    <form action="{{ route('admin.treasuries.store') }}" method="post" autocomplete="off" style=""
                        enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col">
                                <label>تاريخ إنشاء الخزنة  </label>
                                <input type="date" class="form-control " id="date" name="date"
                                    value="{{ date('Y-m-d') }}" required readonly>

                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="active" class="control-label "> الحالة </label>
                                <select name="active" id="active" class="form-control" required>
                                    <option selected disabled> --اختر حالة الخزنة-- </option>
                                    <option @if (old('active') == 0) and old('active') !="" selected="selected" @endif value="0"> غير
                                        مفعلة </option>
                                    <option @if (old('active') == 1) selected="selected" @endif value="1">
                                        مفعلة </option>

                                </select>
                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="name" class="control-label">إسم الخزانة</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="is_master" class="control-label"> نوع الخزانة </label>
                                <select name="is_master" id="is_master" class="form-control" required>
                                    <option selected disabled> --اختر نوع الخزنة-- </option>
                                    <option @if (old('is_master') == 1) selected="selected" @endif value="1">
                                        رئيسية </option>
                                    <option @if (old('is_master') == 0) and old('is_master') !="" selected="selected" @endif value="0">
                                        فرعية </option>

                                </select>
                                @error('is_master')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="last_isal_exchange" class="control-label"> اخر رقم ايصال صرف نقدي لهذه الخزنة
                                </label>
                                <input type="text" value="{{ old('last_isal_exchange') }}"
                                    class="form-control" oninput="this.value=this.value.replace(/[^'0-9']/g,'');"
                                    id="last_isal_exchange" name="last_isal_exchange" title="يرجى ادخال المبلغ" required>
                                @error('last_isal_exchange')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="last_isal_collect" class="control-label"> اخر رقم ايصال تحصيل نقدي لهذه الخزنة
                                </label>
                                <input type="text" class="form-control" value="{{ old('last_isal_collect') }}"
                                    oninput="this.value=this.value.replace(/[^'0-9']/g,'');" id="last_isal_collect"
                                    name="last_isal_collect" title="يرجى ادخال التحصيل" required>
                                @error('last_isal_collect')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="d-flex justify-content-center">
                            <tr>
                                <td>
                                    <button type="submit" class="btn btn-sm  btn-primary"style="margin: 10px">
                                        إضـــافة  </button>
                                </td>
                                <td> <a href="{{ route('admin.treasuries.index') }}"
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
