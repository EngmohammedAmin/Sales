{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الضبط
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الخزانات
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزانةالفرعية للاستلام </a>
@endsection

@section('contentheaderactive')
    إضافة خزنة فرعية للخزنة : {{ $data->name }}
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> إضافة خزنة للاستلام منها إلى
                        الخزنة:{{ $data->name }} </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(129, 144, 146)">
                    <form action="{{ route('admin.treasuries.store_treasuries_delivary', [$data->id]) }}" method="post"
                        autocomplete="off" style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col">
                                <label> تاريخ الاضافة </label>
                                <input type="date" class="form-control " id="date" name="date"
                                    value="{{ date('Y-m-d') }}" required readonly>

                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <br>
                        <div class="row" style="display: flex">
                            <div class="col-5">
                                <label for="name" class="control-label"> إسم الخزانة المستلمة </label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ $data->name }}" required readonly>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="name" class="control-label"> إسم الخزانة المراد إضافتها </label>
                                <select name="treasuries_can_delivary_id" id="treasuries_can_delivary_id"
                                    class="form-control">
                                    <option selected disabled>-- حدد الخزانة المراد إضافتها إلى الخزنة :{{ $data->name }}
                                        --</option>

                                    @if (@isset($treasuries) && !@empty($treasuries))
                                        @foreach ($treasuries as $s)
                                            <option @if (old('treasuries_can_delivary_id' == $s->id)) selected="selected" @endif
                                                value="{{ $s->id }}">{{ $s->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                    @error('treasuries_can_delivary_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </select>
                            </div>
                        </div>


                        <br>


                        <div class="d-flex justify-content-center">
                            <tr>
                                <td>
                                    <button type="submit" class="btn btn-sm  btn-primary"style="margin: 10px">حفظ
                                        البيانات</button>
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
