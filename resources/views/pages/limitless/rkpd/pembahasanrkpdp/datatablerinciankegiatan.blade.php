<div class="panel-heading">
    <div class="panel-title">
        <h5>DAFTAR RINCIAN KEGIATAN</h5>
    </div>
    <div class="heading-elements">    
        @if ($rkpd->Privilege==0)
        <div class="heading-btn">
            <a href="{!!route(Helper::getNameOfPage('create3'),['id'=>$rkpd->RKPDID])!!}" class="btn btn-success btn-xs" title="Tambah Rincian Kegiatan dari POKIR">
                <i class="icon-googleplus5"></i>
            </a>
            <a href="{!!route(Helper::getNameOfPage('create4'),['id'=>$rkpd->RKPDID])!!}" class="btn btn-primary btn-xs" title="Tambah Rincian Kegiatan">
                <i class="icon-googleplus5"></i>
            </a>
        </div>  
        @endif        
    </div>
</div>
@if (count($datarinciankegiatan) > 0)
<div class="table-responsive"> 
    <table id="data" class="table table-striped table-hover" style="font-size:11px">
        <thead>
            <tr class="bg-teal-700">
                <th width="55">NO</th>     
                <th>NAMA URAIAN</th>                
                <th>SASARAN URAIAN</th>  
                <th>TARGET (%)</th> 
                <th class="text-right">NILAI USULAN<br>RKPDP</th>                
                <th class="text-right">NILAI USULAN<br>RKPDP PEMBAHASAN</th>                
                <th width="80">STATUS</th>                                       
                <th width="80">VERIFIKASI</th>                                       
                <th width="120">AKSI</th>
            </tr>
        </thead>
        <tbody>                    
        @foreach ($datarinciankegiatan as $key=>$item)
            <tr>
                <td>
                    {{$item->No}}
                </td>
                <td>
                    {{ucwords($item->Uraian)}}
                   @if ($item->isSKPD)
                        <br />
                        <span class="label label-flat border-grey text-grey-600">                        
                            <a href="#">
                                <strong>Usulan dari: </strong>OPD / SKPD
                            </a> 
                        </span>
                    @elseif($item->isReses)
                        <br />
                        <span class="label label-flat border-grey text-grey-600">                        
                            <a href="#">
                                <strong>Usulan dari: </strong>POKIR [{{$item->isReses_Uraian}}]
                            </a>
                        </span>
                    @elseif(!empty($item->UsulanKecID))
                        <br />
                        <span class="label label-flat border-grey text-grey-600">                        
                            <a href="{{route('aspirasimusrenkecamatan.show',['id'=>$item->UsulanKecID])}}">
                                <strong>Usulan dari: MUSREN. KEC. {{$item->Nm_Kecamatan}}
                            </a>
                        </span>
                    @endif
                </td>                
                <td>{{Helper::formatAngka($item->Sasaran_Angka)}} {{ucwords($item->Sasaran_Uraian)}}</td>
                <td>{{$item->Target}}</td>               
                <td class="text-right">
                    <span class="text-success">{{Helper::formatuang($item->Jumlah2)}}</span><br>                
                </td>  
                <td class="text-right">                    
                    <span class="text-danger">{{Helper::formatuang($item->Jumlah3)}}</span>
                </td>  
                <td>
                    @include('layouts.limitless.l_status_rkpd')
                </td>
                <td>
                    @if ($item->Privilege==0)
                    <span class="label label-flat border-grey text-grey-600 label-icon">
                        <i class="icon-cross2"></i>
                    </span>
                    @else
                    <span class="label label-flat border-success text-success-600 label-icon">
                        <i class="icon-checkmark"></i>
                    </span>                            
                    @endif     
                </td>
                <td>                   
                    <ul class="icons-list"> 
                        <li class="text-primary-600">
                            <a class="btnShow" href="{{route(Helper::getNameOfPage('showrincian'),['id'=>$item->RKPDRincID])}}" title="Detail Data Usulan Musren Kabupaten">
                                <i class='icon-eye'></i>
                            </a>  
                        </li>
                        @if ($item->Privilege==0)                   
                        <li class="text-primary-600">
                            @if ($item->isSKPD)
                                <a class="btnEdit" href="{{route(Helper::getNameOfPage('edit4'),['id'=>$item->RKPDRincID])}}" title="Ubah Data Usulan {{$page_title}}">
                                    <i class='icon-pencil7'></i>
                                </a> 
                            @elseif($item->isReses)
                                <a class="btnEdit" href="{{route(Helper::getNameOfPage('edit3'),['id'=>$item->RKPDRincID])}}" title="Ubah Data Usulan {{$page_title}}">
                                    <i class='icon-pencil7'></i>
                                </a>
                            @elseif(!empty($item->UsulanKecID))
                                <a class="btnEdit" href="{{route(Helper::getNameOfPage('edit2'),['id'=>$item->RKPDRincID])}}" title="Ubah Data Usulan {{$page_title}}">
                                    <i class='icon-pencil7'></i>
                                </a>
                            @else
                                <a class="btnEdit" href="{{route(Helper::getNameOfPage('edit4'),['id'=>$item->RKPDRincID])}}" title="Ubah Data Usulan {{$page_title}}">
                                    <i class='icon-pencil7'></i>
                                </a>
                            @endif
                        </li>
                        @if ($item->EntryLvl==6 && $item->Status==6)                   
                        <li class="text-danger-600">
                            <a class="btnDelete" href="javascript:;" title="Hapus Data Rincian Kegiatan" data-id="{{$item->RKPDRincID}}" data-url="{{route(Helper::getNameOfPage('index'))}}">
                                <i class='icon-trash'></i>
                            </a> 
                        </li>             
                        @endif
                        @endif
                    </ul>
                </td>
            </tr>
            <tr class="text-center info">
                <td colspan="10">                   
                    <span class="label label-warning label-rounded" style="text-transform: none">
                        <strong>RKPDRINCID:</strong>
                        {{$item->RKPDRincID}}
                    </span>
                    <span class="label label-warning label-rounded">
                        <strong>KET:</strong>
                        {{empty($item->Descr)?'-':$item->Descr}}
                    </span>
                </td>
            </tr>
        @endforeach                    
        </tbody>
        <tfoot>
            @php
                $jumlah=$datarinciankegiatan->sum('Jumlah2');
                $jumlah2=$datarinciankegiatan->sum('Jumlah3');
            @endphp
            <tr class="bg-grey-300" style="font-weight:bold">
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right">{{Helper::formatUang($jumlah)}}</td> 
                <td class="text-right">{{Helper::formatUang($jumlah2)}}</td> 
                <td colspan="3"></td>
            </tr>
            <tr class="bg-grey-300" style="font-weight:bold">
                <td colspan="4" class="text-right">SELISIH</td>
                <td class="text-right">{{Helper::formatUang($jumlah2-$jumlah)}}</td> 
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>       
</div>       
@else
<div class="panel-body">
    <div class="alert alert-info alert-styled-left alert-bordered">
        <span class="text-semibold">Info!</span>
        Belum ada data yang bisa ditampilkan.
    </div>
</div>   
@endif               