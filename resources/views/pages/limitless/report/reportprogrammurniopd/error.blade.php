@extends('layouts.limitless.l_main')
@section('page_title')
    LAPORAN PROGRAM RKPD PER. OPD DAN UNIT KERJA
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('reportprogrammurniopd.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection