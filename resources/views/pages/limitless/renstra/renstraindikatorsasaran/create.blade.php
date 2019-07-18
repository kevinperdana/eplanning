@extends('layouts.limitless.l_main')
@section('page_title')
    RENSTRA INDIKATOR SASARAN  {{config('eplanning.renstra_tahun_mulai')}} - {{config('eplanning.renstra_tahun_akhir')}}
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold"> 
        RENSTRA INDIKATOR SASARAN TAHUN {{config('eplanning.renstra_tahun_mulai')}} - {{config('eplanning.renstra_tahun_akhir')}}  
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.renstra.renstraindikatorsasaran.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">PERENCANAAN</a></li>
    <li><a href="#">RENSTRA</a></li>
    <li><a href="{!!route('renstraindikatorsasaran.index')!!}">INDIKATOR SASARAN</a></li>
    <li class="active">TAMBAH DATA</li>
@endsection
@section('page_content')
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <i class="icon-pencil7 position-left"></i> 
                TAMBAH DATA
            </h5>
            <div class="heading-elements">
                <ul class="icons-list">                    
                    <li>               
                        <a href="{!!route('renstraindikatorsasaran.index')!!}" data-action="closeredirect" title="keluar"></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['action'=>'RENSTRA\RENSTRAIndikatorSasaranController@store','method'=>'post','class'=>'form-horizontal','id'=>'frmdata','name'=>'frmdata'])!!}                                            
                <div class="form-group">
                    {{Form::label('UrsID','NAMA URUSAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <select name="UrsID" id="UrsID" class="select">
                            <option></option>
                            @foreach ($daftar_urusan as $k=>$item)
                                <option value="{{$k}}" {{$UrsID_selected == $k?' selected':''}}>{{$item}}</option>
                            @endforeach
                        </select>                        
                    </div>
                </div>         
                <div class="form-group">
                    {{Form::label('PrgID','NAMA PROGRAM',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <select name="PrgID" id="PrgID" class="select">
                            <option></option>
                            @foreach ($daftar_program as $k=>$item)
                                <option value="{{$k}}"}}>{{$item}}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>       
                <div class="form-group">
                    <label class="col-md-2 control-label">ARAH KEBIJAKAN:</label> 
                    <div class="col-md-10">
                        <select name="RenstraKebijakanID" id="RenstraKebijakanID" class="select">
                            <option></option>
                            @foreach ($daftar_kebijakan as $k=>$item)
                                <option value="{{$k}}"">{{$item}}</option>
                            @endforeach
                        </select>                                
                    </div>
                </div>   
                <div class="form-group">
                    {{Form::label('NamaIndikator','NAMA INDIKATOR',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::text('NamaIndikator','',['class'=>'form-control','placeholder'=>'Nama Indikator'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('Descr','KETERANGAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::textarea('Descr','',['class'=>'form-control','placeholder'=>'KETERANGAN','rows' => 2, 'cols' => 40])}}
                    </div>
                </div>
                <div class="form-group">            
                    <div class="col-md-10 col-md-offset-2">                        
                        {{ Form::button('<b><i class="icon-floppy-disk "></i></b> SIMPAN', ['type' => 'submit', 'class' => 'btn btn-info btn-labeled btn-xs'] ) }}
                    </div>
                </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>   
@endsection
@section('page_asset_js')
<script src="{!!asset('themes/limitless/assets/js/jquery-validation/jquery.validate.min.js')!!}"></script>
<script src="{!!asset('themes/limitless/assets/js/jquery-validation/additional-methods.min.js')!!}"></script>
<script src="{!!asset('themes/limitless/assets/js/select2.min.js')!!}"></script>
@endsection
@section('page_custom_js')
<script type="text/javascript">
$(document).ready(function () {
    //styling select
    $('#UrsID.select').select2({
        placeholder: "PILIH NAMA URUSAN",
        allowClear:true
    });
    $('#PrgID.select').select2({
        placeholder: "PILIH NAMA PROGRAM",
        allowClear:true
    });    
    $('#RenstraKebijakanID.select').select2({
        placeholder: "PILIH ARAH KEBIJAKAN",
        allowClear:true
    });
    $('#frmdata').validate({
        ignore: [],
        rules: {
            RenstraKebijakanID : {
                required: true,
                valueNotEquals: 'none'
            },
            NamaIndikator : {
                required: true,
                minlength: 2
            }
        },
        messages : {
            RenstraKebijakanID : {
                required: "Mohon untuk di pilih karena ini diperlukan.",
                valueNotEquals: "Mohon untuk di pilih karena ini diperlukan.",      
            },
            NamaIndikator : {
                required: "Mohon untuk di isi karena ini diperlukan.",
                minlength: "Mohon di isi minimal 2 karakter atau lebih."
            }
        }      
    });   
});
</script>
@endsection