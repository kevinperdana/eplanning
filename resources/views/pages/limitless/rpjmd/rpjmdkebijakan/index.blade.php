@extends('layouts.limitless.l_main')
@section('page_title')
    RPJMD PRIORITAS / ARAH KEBIJAKAN TAHUN {{HelperKegiatan::getRPJMDTahunMulai()}} - {{HelperKegiatan::getRPJMDTahunAkhir()}}
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        RPJMD PRIORITAS / ARAH KEBIJAKAN TAHUN {{HelperKegiatan::getRPJMDTahunMulai()}} - {{HelperKegiatan::getRPJMDTahunAkhir()}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.rpjmd.rpjmdkebijakan.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">PERENCANAAN</a></li>
    <li><a href="#">RPJMD</a></li>
    <li><a href="{!!route('rpjmdkebijakan.index')!!}">PRIORITAS / ARAH KEBIJAKAN</a></li>
@endsection
@section('page_content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-flat border-top-lg border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <i class="icon-search4 position-left"></i>
                    Pencarian Data
                </h5>
            </div>
            <div class="panel-body">
                {!! Form::open(['action'=>'RPJMD\RPJMDKebijakanController@search','method'=>'post','class'=>'form-horizontal','id'=>'frmsearch','name'=>'frmsearch'])!!}                                
                    <div class="form-group">
                        <label class="col-md-2 control-label">Kriteria :</label> 
                        <div class="col-md-10">                            
                            {{Form::select('cmbKriteria', ['Kd_Kebijakan'=>'KODE','Nm_Kebijakan'=>'NAMA'], isset($search['kriteria'])?$search['kriteria']:'Kd_Kebijakan',['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group" id="divKriteria">
                        <label class="col-md-2 control-label">Isi Kriteria :</label>                                                    
                        <div class="col-md-10">                            
                            {{Form::text('txtKriteria',isset($search['isikriteria'])?$search['isikriteria']:'',['class'=>'form-control','placeholder'=>'Isi Kriteria Pencarian','id'=>'txtKriteria'])}}                                                                  
                        </div>
                    </div>                                                     
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            {{ Form::button('<b><i class="icon-search4"></i></b> Cari', ['type' => 'submit', 'class' => 'btn btn-info btn-labeled btn-xs', 'id'=>'btnSearch'] )  }}                            
                            <a id="btnReset" href="javascript:;" title="Reset Pencarian" class="btn btn-default btn-labeled btn-xs">
                                <b><i class="icon-reset"></i></b> Reset
                            </a>                           
                        </div>
                    </div>  
                {!! Form::close()!!}
            </div>
        </div>
    </div>       
    <div class="col-md-12" id="divdatatable">
        @include('pages.limitless.rpjmd.rpjmdkebijakan.datatable')
    </div>
</div>
@endsection
@section('page_custom_js')
<script type="text/javascript">
$(document).ready(function () {  
    $("#divdatatable").on("click",".btnDelete", function(){
        if (confirm('Apakah Anda ingin menghapus Data RPJMD Kebijakan ini ?')) {
            let url_ = $(this).attr("data-url");
            let id = $(this).attr("data-id");
            $.ajax({            
                type:'post',
                url:url_+'/'+id,
                dataType: 'json',
                data: {
                    "_method": 'DELETE',
                    "_token": token,
                    "id": id,
                },
                success:function(result){ 
                    if (result.success==1){
                        $('#divdatatable').html(result.datatable);                        
                    }else{
                        console.log("Gagal menghapus data RPJMD Kebijakan dengan id "+id);
                    }                    
                },
                error:function(xhr, status, error){
                    console.log('ERROR');
                    console.log(parseMessageAjaxEror(xhr, status, error));                           
                },
            });
        }        
    });
});
</script>
@endsection