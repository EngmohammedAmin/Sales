{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    test view title
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    test view header
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="#"> test view header link</a>
@endsection

@section('contentheaderactive')
    test view header active
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    test view content
@endsection
