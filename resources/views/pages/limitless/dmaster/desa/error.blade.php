@extends('layouts.limitless.l_main')
@section('page_title')
    DESA
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        DESA TAHUN PERENCANAAN {{HelperKegiatan::getTahunPerencanaan()}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.dmaster.desa.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('desa.index')!!}">DESA</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection