<div class="panel panel-flat border-top-lg border-top-info border-bottom-info">
    <div class="panel-heading">
        <div class="panel-title">
            <h6 class="panel-title">&nbsp;</h6>
        </div>
        <div class="heading-elements">
            {!! Form::open(['url'=>'#','method'=>'post','class'=>'heading-form','id'=>'frmheading','name'=>'frmheading'])!!} 
                <div class="form-group">
                    {!!Form::select('numberRecordPerPage',['1'=>1,'5'=>5,'10'=>10,'15'=>15,'30'=>30,'50'=>50],$numberRecordPerPage,['id'=>'numberRecordPerPage','class'=>'form-control','style'=>'width:70px'])!!}                        
                </div> 
                <div class="form-group">
                    <a href="{!!route('rpjmdmisi.create')!!}" class="btn btn-info btn-xs" title="Tambah RPJMD Misi">
                        <i class="icon-googleplus5"></i>
                    </a>
                </div> 
            {!! Form::close()!!}
        </div>       
    </div>
    @if (count($data) > 0)
    <div class="table-responsive"> 
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr class="bg-teal-700">
                    <th width="55">NO</th>
                    <th width="120">
                        <a class="column-sort text-white" id="col-Kd_PrioritasKab" data-order="{{$direction}}" href="#">
                            KODE MISI 
                        </a>                                             
                    </th> 
                    <th>
                        <a class="column-sort text-white" id="col-Nm_PrioritasKab" data-order="{{$direction}}" href="#">
                            NAMA MISI  
                        </a>                                             
                    </th> 
                    <th width="100">TA</th>
                    <th width="100">AKSI</th>
                </tr>
            </thead>
            <tbody>                    
            @foreach ($data as $key=>$item)
                <tr>
                    <td>
                        {{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}    
                    </td>                  
                    <td>{{$item->Kd_PrioritasKab}}</td>
                    <td>{{$item->Nm_PrioritasKab}}</td>
                    <td>{{$item->TA}}</td>
                    <td>
                        <ul class="icons-list">
                            <li class="text-primary-600">
                                <a class="btnShow" href="{{route('rpjmdmisi.show',['id'=>$item->PrioritasKabID])}}" title="Detail Data RPJMD Misi">
                                    <i class='icon-eye'></i>
                                </a>  
                            </li>
                            <li class="text-primary-600">
                                <a class="btnEdit" href="{{route('rpjmdmisi.edit',['id'=>$item->PrioritasKabID])}}" title="Ubah Data RPJMD Misi">
                                    <i class='icon-pencil7'></i>
                                </a>  
                            </li>
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data RPJMD Misi" data-id="{{$item->PrioritasKabID}}" data-url="{{route('rpjmdmisi.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr class="text-center info">
                    <td colspan="11">
                        <span class="label label-warning label-rounded" style="text-transform: none">
                            <strong>PRIORITASKABID:</strong>
                            {{$item->PrioritasKabID}}
                        </span>                        
                        <span class="label label-warning label-rounded" style="text-transform: none">
                            <strong>RPJMDVISIID:</strong>
                            {{$item->RpjmdVisiID}}
                        </span>                       
                        <span class="label label-warning label-rounded" style="text-transform: none">
                            <strong>CREATED:</strong>
                            {{Helper::tanggal('d/m/Y H:m',$item->created_at)}}
                        </span>
                        <span class="label label-warning label-rounded" style="text-transform: none">
                            <strong>UPDATED:</strong>
                            {{Helper::tanggal('d/m/Y H:m',$item->updated_at)}}
                        </span>
                    </td>
                </tr>
            @endforeach                    
            </tbody>
        </table>               
    </div>
    <div class="panel-body border-top-info text-center" id="paginations">
        {{$data->links('layouts.limitless.l_pagination')}}               
    </div>
    @else
    <div class="panel-body">
        <div class="alert alert-info alert-styled-left alert-bordered">
            <span class="text-semibold">Info!</span>
            Belum ada data yang bisa ditampilkan.
        </div>
    </div>   
    @endif            
</div>
