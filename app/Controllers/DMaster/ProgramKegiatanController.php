<?php

namespace App\Controllers\DMaster;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\DMaster\ProgramModel;
use App\Models\DMaster\ProgramKegiatanModel;
use App\Rules\CheckRecordIsExistValidation;
use App\Rules\IgnoreIfDataIsEqualValidation;

class ProgramKegiatanController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin|bapelitbang']);
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        $columns=['*'];       
        if (!$this->checkStateIsExistSession('programkegiatan','orderby')) 
        {            
           $this->putControllerStateSession('programkegiatan','orderby',['column_name'=>'kode_kegiatan','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('programkegiatan.orderby','column_name'); 
        $direction=$this->getControllerStateSession('programkegiatan.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        

        //filter
        if (!$this->checkStateIsExistSession('programkegiatan','filters')) 
        {            
            $this->putControllerStateSession('programkegiatan','filters',['PrgID'=>'none']);
        }
        $filter_prgid=$this->getControllerStateSession('programkegiatan.filters','PrgID'); 
        if ($this->checkStateIsExistSession('programkegiatan','search')) 
        {
            $search=$this->getControllerStateSession('programkegiatan','search');
            switch ($search['kriteria']) 
            {
                case 'kode_kegiatan' :
                    $data = \DB::table('v_program_kegiatan')
                            ->where('TA',\HelperKegiatan::getTahunPerencanaan())
                            ->where(['kode_kegiatan'=>$search['isikriteria']])
                            ->orderBy($column_order,$direction); 
                break;
                case 'KgtNm' :
                    $data = \DB::table('v_program_kegiatan')
                            ->where('TA',\HelperKegiatan::getTahunPerencanaan())
                            ->where('KgtNm', 'ilike', '%' . $search['isikriteria'] . '%')
                            ->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data =$filter_prgid == 'none' ? 
                                            \DB::table('tmKgt')
                                                    ->select(\DB::raw('"tmKgt"."KgtID","v_program_kegiatan"."kode_kegiatan","tmKgt"."Kd_Keg","tmKgt"."KgtNm","v_program_kegiatan"."Kd_Prog","v_program_kegiatan"."PrgNm","tmKgt"."TA","v_program_kegiatan"."Jns"'))
                                                    ->join('v_program_kegiatan','v_program_kegiatan.KgtID','tmKgt.KgtID')
                                                    ->orderBy($column_order,$direction)
                                                    ->where('tmKgt.TA',\HelperKegiatan::getTahunPerencanaan())
                                                    ->paginate($numberRecordPerPage, $columns, 'page', $currentpage)
                                            :
                                            \DB::table('tmKgt')
                                            ->select(\DB::raw('"tmKgt"."KgtID","v_program_kegiatan"."kode_kegiatan","tmKgt"."Kd_Keg","tmKgt"."KgtNm","v_program_kegiatan"."Kd_Prog","v_program_kegiatan"."PrgNm","tmKgt"."TA","v_program_kegiatan"."Jns"'))
                                                    ->join('v_program_kegiatan','v_program_kegiatan.KgtID','tmKgt.KgtID')
                                                    ->orderBy($column_order,$direction)
                                                    ->where('tmKgt.TA',\HelperKegiatan::getTahunPerencanaan())
                                                    ->where('tmKgt.PrgID',$filter_prgid)                                                
                                                    ->paginate($numberRecordPerPage, $columns, 'page', $currentpage);
        }        
        
        $data->setPath(route('programkegiatan.index'));
        return $data;
    }
    /**
     * digunakan untuk mengganti jumlah record per halaman
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changenumberrecordperpage (Request $request) 
    {
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getTahunPerencanaan());
        $daftar_program['none']='SELURUH PROGRAM';
        $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));
        
        $numberRecordPerPage = $request->input('numberRecordPerPage');
        $this->putControllerStateSession('global_controller','numberRecordPerPage',$numberRecordPerPage);
        
        $this->setCurrentPageInsideSession('programkegiatan',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',
                                                                                'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                                'daftar_program'=>$daftar_program,
                                                                                'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                                'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                                'data'=>$data])->render();      
        return response()->json(['success'=>true,'datatable'=>$datatable],200);
    }
    /**
     * digunakan untuk mengurutkan record 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderby (Request $request) 
    {
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getTahunPerencanaan());
        $daftar_program['none']='SELURUH PROGRAM';
        $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));

        $orderby = $request->input('orderby') == 'asc'?'desc':'asc';
        $column=$request->input('column_name');
        switch($column) 
        {
            case 'col-Kd_Keg' :
                $column_name = 'tmKgt.Kd_Keg';
            break; 
            case 'col-KgtNm' :
                $column_name = 'tmKgt.KgtNm';
            break;
            case 'col-PrgNm' :
                $column_name = 'v_program_kegiatan.PrgNm';
            break;          
            default :
                $column_name = 'tmKgt.Kd_Keg';
        }
        $this->putControllerStateSession('programkegiatan','orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $data=$this->populateData();

        $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',
                                                                                    'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                                    'daftar_program'=>$daftar_program,
                                                                                    'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                                    'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                                    'data'=>$data])->render();     

        return response()->json(['success'=>true,'datatable'=>$datatable],200);
    }
    /**
     * paginate resource in storage called by ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate ($id) 
    {
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getTahunPerencanaan());
        $daftar_program['none']='SELURUH PROGRAM';
        $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));

        $this->setCurrentPageInsideSession('programkegiatan',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',
                                                                            'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                            'daftar_program'=>$daftar_program,
                                                                            'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                            'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                            'data'=>$data])->render(); 

        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * search resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search (Request $request) 
    {
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getTahunPerencanaan());
        $daftar_program['none']='SELURUH PROGRAM';
        $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));

        $action = $request->input('action');
        if ($action == 'reset') 
        {
            $this->destroyControllerStateSession('programkegiatan','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('programkegiatan','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('programkegiatan',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',                                                            
                                                                                    'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                                    'daftar_program'=>$daftar_program,
                                                                                    'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                                    'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                                    'data'=>$data])->render();      
        
        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * filter resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request) 
    {
        $auth = \Auth::user();    
        $theme = $auth->theme;

        $json_data = [];
        
        //index
        if ($request->exists('PrgID'))
        {
            $PrgID = $request->input('PrgID')==''?'none':$request->input('PrgID');
            $filters['PrgID']=$PrgID;
            $this->putControllerStateSession('programkegiatan','filters',$filters);
            $this->setCurrentPageInsideSession('programkegiatan',1);

            $data = $this->populateData();            
            $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));
            $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',   
                                                                                'search'=>$this->getControllerStateSession('programkegiatan','search'),                                                                                
                                                                                'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                                'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                                'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                                'data'=>$data])->render();                                                                                       
                        
            
            $json_data = ['success'=>true,'datatable'=>$datatable];            
        }
        return response()->json($json_data,200);  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getRPJMDTahunMulai());
        $daftar_program['none']='SELURUH PROGRAM';

        $search=$this->getControllerStateSession('programkegiatan','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('programkegiatan'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('programkegiatan',$data->currentPage());
        $filter_kode_program_selected=ProgramModel::getKodeProgramByPrgID($this->getControllerStateSession('programkegiatan.filters','PrgID'));

        return view("pages.$theme.dmaster.programkegiatan.index")->with(['page_active'=>'programkegiatan',
                                                                        'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                        'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                        'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                        'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                        'daftar_program'=>$daftar_program,
                                                                        'filter_prgid_selected'=>$this->getControllerStateSession('programkegiatan.filters','PrgID'), 
                                                                        'filter_kode_program_selected'=>$filter_kode_program_selected,
                                                                        'data'=>$data]);               
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $theme = \Auth::user()->theme;
        $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getRPJMDTahunMulai(),false);
        return view("pages.$theme.dmaster.programkegiatan.create")->with(['page_active'=>'programkegiatan',
                                                                          'daftar_program'=>$daftar_program
                                                                        ]);  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [      
            'Kd_Keg'=>[new CheckRecordIsExistValidation('tmKgt',['where'=>['PrgID','=',$request->input('PrgID')]]),
                            'required',
                            'min:1',
                            'max:4',
                            'regex:/^[0-9]+$/'
                        ],         
            'PrgID'=>'required',
            'KgtNm'=>'required|min:5',
        ]);
        
        $programkegiatan = ProgramKegiatanModel::create([
            'KgtID'=> uniqid ('uid'),
            'PrgID' => $request->input('PrgID'),
            'Kd_Keg' => $request->input('Kd_Keg'),
            'KgtNm' => $request->input('KgtNm'),
            'Descr' => $request->input('Descr'),
            'TA'=>\HelperKegiatan::getTahunPerencanaan(),
        ]);        
        
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route('programkegiatan.show',['id'=>$programkegiatan->KgtID]))->with('success','Data ini telah berhasil disimpan.');
        }

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $theme = \Auth::user()->theme;
        $data = ProgramKegiatanModel::select(\DB::raw('"v_program_kegiatan"."Kd_Urusan","v_program_kegiatan"."Nm_Urusan","v_program_kegiatan"."Kd_Bidang","v_program_kegiatan"."Nm_Bidang","tmKgt"."KgtID","v_program_kegiatan"."Kd_Prog","tmKgt"."Kd_Keg","tmKgt"."KgtNm","v_program_kegiatan"."kode_kegiatan","v_program_kegiatan"."PrgNm","tmKgt"."Descr","tmKgt"."TA","tmKgt"."created_at","tmKgt"."updated_at"'))
                                    ->leftJoin('v_program_kegiatan','v_program_kegiatan.KgtID','tmKgt.KgtID')
                                    ->where('tmKgt.KgtID',$id)
                                    ->firstOrFail();        
        if (!is_null($data) )  
        {
            return view("pages.$theme.dmaster.programkegiatan.show")->with(['page_active'=>'programkegiatan',
                                                    'data'=>$data
                                                    ]);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $theme = \Auth::user()->theme;
        
        $data = ProgramKegiatanModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            $daftar_program=ProgramModel::getDaftarProgram(\HelperKegiatan::getRPJMDTahunMulai(),false);
            return view("pages.$theme.dmaster.programkegiatan.edit")->with(['page_active'=>'programkegiatan',
                                                                                'daftar_program'=>$daftar_program,
                                                                                'data'=>$data
                                                                            ]);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $programkegiatan = ProgramKegiatanModel::find($id);

        $this->validate($request, [            
            'Kd_Keg'=>[new IgnoreIfDataIsEqualValidation('tmKgt',$programkegiatan->Kd_Keg,['where'=>['PrgID','=',$programkegiatan->PrgID]]),
                            'required',
                            'min:1',
                            'max:4',
                            'regex:/^[0-9]+$/'
                        ],   
            'PrgID'=>'required',
            'KgtNm'=>'required|min:5',
        ]);        
        
        $programkegiatan->PrgID = $request->input('PrgID');
        $programkegiatan->Kd_Keg = $request->input('Kd_Keg');
        $programkegiatan->KgtNm = $request->input('KgtNm');
        $programkegiatan->Descr = $request->input('Descr');
        $programkegiatan->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('programkegiatan.show',['id'=>$programkegiatan->KgtID]))->with('success',"Data dengan id ($id) telah berhasil diubah.");
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $theme = \Auth::user()->theme;
        
        $programkegiatan = ProgramKegiatanModel::find($id);
        $result=$programkegiatan->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('programkegiatan'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.dmaster.programkegiatan.datatable")->with(['page_active'=>'programkegiatan',
                                                                                        'search'=>$this->getControllerStateSession('programkegiatan','search'),
                                                                                        'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                                        'column_order'=>$this->getControllerStateSession('programkegiatan.orderby','column_name'),
                                                                                        'direction'=>$this->getControllerStateSession('programkegiatan.orderby','order'),
                                                                                        'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('programkegiatan.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}