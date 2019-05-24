@extends('layouts.limitless.l_main')
@section('page_title')
    RENSTRAMISI
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        RENSTRAMISI TAHUN PERENCANAAN {{config('eplanning.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.renstra.renstramisi.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('renstramisi.index')!!}">RENSTRAMISI</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection