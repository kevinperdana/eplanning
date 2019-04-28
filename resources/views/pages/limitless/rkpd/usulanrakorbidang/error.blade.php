@extends('layouts.limitless.l_main')
@section('page_title')
    RAKORBIDANG
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        RAKORBIDANG TAHUN PERENCANAAN {{config('globalsettings.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.rkpd.rakorbidang.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rakorbidang.index')!!}">RAKORBIDANG</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('rakorbidang.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection