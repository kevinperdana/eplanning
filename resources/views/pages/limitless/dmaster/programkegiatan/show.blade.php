@extends('layouts.limitless.l_main')
@section('page_title')
    KEGIATAN
@endsection
@section('page_header')
    <i class="icon-code position-left"></i>
    <span class="text-semibold"> 
        KEGIATAN TAHUN PERENCANAAN {{HelperKegiatan::getTahunPerencanaan()}}
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.dmaster.programkegiatan.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">MASTERS</a></li>
    <li><a href="#">DATA</a></li>
    <li><a href="{!!route('programkegiatan.index')!!}">KEGIATAN</a></li>
    <li class="active">DETAIL DATA</li>
@endsection
@section('page_content')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-flat border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title"> 
                    <i class="icon-eye"></i>  DATA KEGIATAN
                </h5>
                <div class="heading-elements"> 
                    <a href="{{route('programkegiatan.create')}}" class="btn btn-info btn-icon heading-btn btnTambah" title="Tambah Data Program Kegiatan">
                        <i class="icon-googleplus5"></i>
                    </a>  
                    <a href="{{route('programkegiatan.edit',['id'=>$data->KgtID])}}" class="btn btn-primary btn-icon heading-btn btnEdit" title="Ubah Data ProgramKegiatan">
                        <i class="icon-pencil7"></i>
                    </a>
                    <a href="javascript:;" title="Hapus Data ProgramKegiatan" data-id="{{$data->KgtID}}" data-url="{{route('programkegiatan.index')}}" class="btn btn-danger btn-icon heading-btn btnDelete">
                        <i class='icon-trash'></i>
                    </a>
                    <a href="{!!route('programkegiatan.index')!!}" class="btn btn-default btn-icon heading-btn" title="keluar">
                        <i class="icon-close2"></i>
                    </a>            
                </div>
            </div>
            <div class="panel-body">
                <div class="row">                                      
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>KELOMPOK URUSAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->Kd_Urusan==null?'SEMUA KELOMPOK URUSAN':'['.$data->Kd_Urusan.'] '.$data->Nm_Urusan}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>URUSAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->Kd_Bidang==null?'SEMUA URUSAN':'['.$data->Kd_Bidang.'] '.$data->Nm_Bidang}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>KODE PROGRAM: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->Kd_Prog}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>NAMA PROGRAM: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->PrgNm}}</p>
                                </div>                            
                            </div>                                                 
                            
                            
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">     
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>KODE KEGIATAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->kode_kegiatan==null?$data->Kd_Prog.'.'.$data->Kd_Keg:$data->kode_kegiatan}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>NAMA KEGIATAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->KgtNm}}</p>
                                </div>                            
                            </div>                             
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TA: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->TA}}</p>
                                </div>                            
                            </div>    
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. BUAT / UBAH: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$data->created_at)}} / {{Helper::tanggal('d/m/Y H:m',$data->updated_at)}}</p>
                                </div>                            
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_custom_js')
<script type="text/javascript">
$(document).ready(function () {
    $(".btnDelete").click(function(ev) {
        if (confirm('Apakah Anda ingin menghapus Data ProgramKegiatan ini ?')) {
            let url_ = $(this).attr("data-url");
            let id = $(this).attr("data-id");
            let token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({            
                type:'post',
                url:url_+'/'+id,
                dataType: 'json',
                data: {
                    "_method": 'DELETE',
                    "_token": token,
                    "id": id,
                },
                success:function(data){ 
                    window.location.replace(url_);                        
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