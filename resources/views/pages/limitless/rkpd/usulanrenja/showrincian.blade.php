@extends('layouts.limitless.l_main')
@section('page_title')
    {{$page_title}}
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">  
        {{$page_title}} TAHUN PERENCANAAN {{HelperKegiatan::getTahunPerencanaan()}}
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.rkpd.usulanrenja.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">WORKFLOW</a></li>
    <li><a href="{!!route(Helper::getNameOfPage('index'))!!}">{{$page_title}}</a></li>
    <li class="active">DETAIL DATA</li>
@endsection
@section('page_content')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-flat border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title"> 
                    <i class="icon-eye"></i>  
                    DETAIL RINCIAN RENCANA KEGIATAN 
                    @if ($renja->Privilege==1))
                        <span class="label label-success label-rounded">SUDAH DI TRANSFER</span>
                    @endif
                </h5>
                <div class="heading-elements">   
                 @if ($renja->Privilege==0))
                     @if ($renja->isSKPD)
                        <a href="{{route(Helper::getNameOfPage('edit4'),['id'=>$renja->RenjaRincID])}}" title="Ubah Data {{$page_title}}" class="btn btn-primary btn-icon heading-btn btnEdit">
                            <i class='icon-pencil7'></i>
                        </a> 
                    @elseif($renja->isReses)
                        <a href="{{route(Helper::getNameOfPage('edit3'),['id'=>$renja->RenjaRincID])}}" title="Ubah Data {{$page_title}}" class="btn btn-primary btn-icon heading-btn btnEdit">
                            <i class='icon-pencil7'></i>
                        </a>
                    @elseif(!empty($renja->UsulanKecID))
                        <a href="{{route(Helper::getNameOfPage('edit2'),['id'=>$renja->RenjaRincID])}}" title="Ubah Data {{$page_title}}" class="btn btn-primary btn-icon heading-btn btnEdit">
                            <i class='icon-pencil7'></i>
                        </a>
                    @else
                        <a href="{{route(Helper::getNameOfPage('edit4'),['id'=>$renja->RenjaRincID])}}" title="Ubah Data {{$page_title}}" class="btn btn-primary btn-icon heading-btn btnEdit">
                            <i class='icon-pencil7'></i>
                        </a>
                    @endif                    
                    @endif{{-- akhir privilege --}}
                    <a href="{!!route(Helper::getNameOfPage('show'),['id'=>$renja->RenjaID])!!}" class="btn btn-default btn-icon heading-btn" title="keluar">
                        <i class="icon-close2"></i>
                    </a>  
                </div>
            </div>
            <div class="panel-body">
                <div class="row">                                      
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>RENJA RINCIAN ID: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$renja->RenjaRincID}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>NO: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$renja->No}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>URAIAN : </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$renja->Uraian}}</p>
                                </div>                            
                            </div>  
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>NILAI PAGU: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::formatUang($renja->Jumlah)}}</p>                               
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>SASARAN KEGIATAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::formatAngka($renja->Sasaran_Angka)}} {{$renja->Sasaran_Uraian}}</p>
                                </div>                            
                            </div>                                
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal"> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TARGET (%): </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::formatAngka($renja->Target)}}</p>
                                </div>                            
                            </div>                             
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>STATUS: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">
                                        @include('layouts.limitless.l_status_kegiatan')
                                    </p>
                                </div>                            
                            </div>  
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>PRIORITAS: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">
                                        <span class="label label-flat border-pink text-pink-600">
                                            {{HelperKegiatan::getNamaPrioritas($item->Prioritas)}}
                                        </span>
                                    </p>
                                </div>                            
                            </div>  
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. BUAT: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$renja->created_at)}}</p>
                                </div>                            
                            </div>  
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. UBAH: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$renja->updated_at)}}</p>
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