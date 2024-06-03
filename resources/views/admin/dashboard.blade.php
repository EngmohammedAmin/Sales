{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    الرئيسية
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الرئيسية
    
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')

<a href="{{ route('admin.dashboard') }}">الرئيسية</a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')

    <div class="row"
        style="background-image: url({{ asset('assets/admin/images/h1.png') }}); background-size:cover;background-repeat:no-repeat;min-height:470px;">
    </div>
@endsection
