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
                    <a href="{!!route('pemilikpokokpikiran.create')!!}" class="btn btn-info btn-xs" title="Tambah Pemilik POKIR">
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
                    <th width="100">
                        <a class="column-sort text-white" id="col-Kd_PK" data-order="{{$direction}}" href="#">
                            KODE  
                        </a>                                             
                    </th> 
                    <th>
                        <a class="column-sort text-white" id="col-NmPk" data-order="{{$direction}}" href="#">
                            NAMA  
                        </a>                                             
                    </th>
                    <th>                       
                        KET.  
                    </th> 
                    <th width="100">AKSI</th>
                </tr>
            </thead>
            <tbody>                    
            @foreach ($data as $key=>$item)
                <tr>
                    <td>
                        {{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}    
                    </td>                  
                    <td>{{$item->Kd_PK}}</td>
                    <td>{{$item->NmPk}}</td>                   
                    <td>{{$item->Descr}}</td>
                    <td>
                        <ul class="icons-list">
                            <li class="text-primary-600">
                                <a class="btnShow" href="{{route('pemilikpokokpikiran.show',['id'=>$item->PemilikPokokID])}}" title="Detail Data Pemilik Pokok Pikiran">
                                    <i class='icon-eye'></i>
                                </a>  
                            </li>
                            <li class="text-primary-600">
                                <a class="btnEdit" href="{{route('pemilikpokokpikiran.edit',['id'=>$item->PemilikPokokID])}}" title="Ubah Data Pemilik Pokok Pikiran">
                                    <i class='icon-pencil7'></i>
                                </a>  
                            </li>
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data Pemilik Pokok Pikiran" data-id="{{$item->PemilikPokokID}}" data-url="{{route('pemilikpokokpikiran.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
                        </ul>
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
