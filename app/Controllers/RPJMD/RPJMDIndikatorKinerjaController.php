<?php

namespace App\Controllers\RPJMD;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RPJMD\RPJMDIndikatorKinerjaModel;
use App\Models\RPJMD\RPJMDKebijakanModel;
use App\Rules\CheckRecordIsExistValidation;
use App\Rules\IgnoreIfDataIsEqualValidation;

class RPJMDIndikatorKinerjaController extends Controller {
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
        if (!$this->checkStateIsExistSession('rpjmdindikatorkinerja','orderby')) 
        {            
           $this->putControllerStateSession('rpjmdindikatorkinerja','orderby',['column_name'=>'NamaIndikator','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'); 
        $direction=$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        
        if ($this->checkStateIsExistSession('rpjmdindikatorkinerja','search')) 
        {
            $search=$this->getControllerStateSession('rpjmdindikatorkinerja','search');
            switch ($search['kriteria']) 
            {                
                case 'NamaIndikator' :
                    $data = RPJMDIndikatorKinerjaModel::where('NamaIndikator', 'ilike', '%' . $search['isikriteria'] . '%')->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = RPJMDIndikatorKinerjaModel::where('TA_N',\HelperKegiatan::getRPJMDTahunMulai())
                                                ->orderBy($column_order,$direction)->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('rpjmdindikatorkinerja.index'));
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

        $numberRecordPerPage = $request->input('numberRecordPerPage');
        $this->putControllerStateSession('global_controller','numberRecordPerPage',$numberRecordPerPage);
        
        $this->setCurrentPageInsideSession('rpjmdindikatorkinerja',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rpjmd.rpjmdindikatorkinerja.datatable")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                                'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
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

        $orderby = $request->input('orderby') == 'asc'?'desc':'asc';
        $column=$request->input('column_name');
        switch($column) 
        {
            case 'col-NamaIndikator' :
                $column_name = 'NamaIndikator';
            break;           
            default :
                $column_name = 'NamaIndikator';
        }
        $this->putControllerStateSession('rpjmdindikatorkinerja','orderby',['column_name'=>$column_name,'order'=>$orderby]);      

        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('rpjmdindikatorkinerja');         
        $data=$this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        
        $datatable = view("pages.$theme.rpjmd.rpjmdindikatorkinerja.datatable")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                            'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
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

        $this->setCurrentPageInsideSession('rpjmdindikatorkinerja',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.rpjmd.rpjmdindikatorkinerja.datatable")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                            'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
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

        $action = $request->input('action');
        if ($action == 'reset') 
        {
            $this->destroyControllerStateSession('rpjmdindikatorkinerja','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('rpjmdindikatorkinerja','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('rpjmdindikatorkinerja',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rpjmd.rpjmdindikatorkinerja.datatable")->with(['page_active'=>'rpjmdindikatorkinerja',                                                            
                                                            'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
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
        $json_data = [];
        //create
        if ($request->exists('UrsID') && $request->exists('create') )
        {
            $UrsID = $request->input('UrsID')==''?'none':$request->input('UrsID');            
            $daftar_program=\App\Models\DMaster\ProgramModel::getDaftarProgram(\HelperKegiatan::getRPJMDTahunMulai(),false,$UrsID);
            $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(\HelperKegiatan::getRPJMDTahunMulai(),false,$UrsID);
            $json_data = ['success'=>true,'daftar_program'=>$daftar_program,'daftar_opd'=>$daftar_opd];
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

        $search=$this->getControllerStateSession('rpjmdindikatorkinerja','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('rpjmdindikatorkinerja'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('rpjmdindikatorkinerja',$data->currentPage());
        
        return view("pages.$theme.rpjmd.rpjmdindikatorkinerja.index")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
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
        $daftar_kebijakan = RPJMDKebijakanModel::getDaftarKebijakan(\HelperKegiatan::getRPJMDTahunMulai(),false);
        $daftar_urusan=\App\Models\DMaster\UrusanModel::getDaftarUrusan(\HelperKegiatan::getRPJMDTahunMulai(),false);
        return view("pages.$theme.rpjmd.rpjmdindikatorkinerja.create")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                                'daftar_kebijakan'=>$daftar_kebijakan,
                                                                                'daftar_urusan'=>$daftar_urusan
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
            'PrioritasKebijakanKabID'=>'required',
            'UrsID'=>'required',
            'PrgID'=>'required',
            'NamaIndikator'=>'required',
            'OrgID'=>'required',
            'OrgID2'=>'required',
            'TargetAwal'=>'required',
            'PaguDanaN1'=>'required',
            'PaguDanaN2'=>'required',
            'PaguDanaN3'=>'required',
            'PaguDanaN4'=>'required',
            'PaguDanaN5'=>'required',
            'TargetN1'=>'required',
            'TargetN2'=>'required',
            'TargetN3'=>'required',
            'TargetN4'=>'required',
            'TargetN5'=>'required'
        ]);
        
        $rpjmdindikatorkinerja = RPJMDIndikatorKinerjaModel::create([
            'IndikatorKinerjaID' => uniqid ('uid'),
            'PrioritasKebijakanKabID' => $request->input('PrioritasKebijakanKabID'),
            'UrsID' => $request->input('UrsID'),
            'PrgID' => $request->input('PrgID'),
            'NamaIndikator' => $request->input('NamaIndikator'),
            'TA_N'=>HelperKegiatan::getRPJMDTahunMulai(),
            'OrgID' => $request->input('OrgID'),
            'OrgID2' => $request->input('OrgID2'),            
            'PaguDanaN1' => $request->input('PaguDanaN1'),
            'PaguDanaN2' => $request->input('PaguDanaN2'),
            'PaguDanaN3' => $request->input('PaguDanaN3'),
            'PaguDanaN4' => $request->input('PaguDanaN4'),
            'PaguDanaN5' => $request->input('PaguDanaN5'),
            'TargetAwal' => $request->input('TargetAwal'),
            'TargetN1' => $request->input('TargetN1'),
            'TargetN2' => $request->input('TargetN2'),
            'TargetN3' => $request->input('TargetN3'),
            'TargetN4' => $request->input('TargetN4'),
            'TargetN5' => $request->input('TargetN5'),
            'Descr' => $request->input('Descr'),
            'TA' => \HelperKegiatan::getRPJMDTahunMulai()            
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
            return redirect(route('rpjmdindikatorkinerja.show',['id'=>$rpjmdindikatorkinerja->IndikatorKinerjaID]))->with('success','Data ini telah berhasil disimpan.');
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

        $data = \DB::table('v_indikator_kinerja2')
                    ->where('IndikatorKinerjaID',$id)
                    ->first();

        if (!is_null($data) )  
        {
            return view("pages.$theme.rpjmd.rpjmdindikatorkinerja.show")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                                'data'=>$data
                                                                                ]);
        }
        else
        {
            return view("pages.$theme.rpjmd.rpjmdindikatorkinerja.error")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                                'errormessage'=>"ID Indikator Kinerja ($id) tidak ditemukan."
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
        
        $data = RPJMDIndikatorKinerjaModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            $daftar_kebijakan = RPJMDKebijakanModel::getDaftarKebijakan($data->TA,false);
            $daftar_urusan=\App\Models\DMaster\UrusanModel::getDaftarUrusan($data->TA,false);
            $daftar_program=\App\Models\DMaster\ProgramModel::getDaftarProgram($data->TA,false,$data['UrsID']);
            $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD($data->TA,false,$data['UrsID']);
            return view("pages.$theme.rpjmd.rpjmdindikatorkinerja.edit")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                                                'data'=>$data,
                                                                                'daftar_kebijakan'=>$daftar_kebijakan,
                                                                                'daftar_urusan'=>$daftar_urusan,
                                                                                'daftar_program'=>$daftar_program,
                                                                                'daftar_opd'=>$daftar_opd
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
        $rpjmdindikatorkinerja = RPJMDIndikatorKinerjaModel::find($id);
        
        $this->validate($request, [
            'PrioritasKebijakanKabID'=>'required',
            'UrsID'=>'required',
            'PrgID'=>'required',
            'NamaIndikator'=>'required',
            'OrgID'=>'required',
            'OrgID2'=>'required',
            'TargetAwal'=>'required',
            'PaguDanaN1'=>'required',
            'PaguDanaN2'=>'required',
            'PaguDanaN3'=>'required',
            'PaguDanaN4'=>'required',
            'PaguDanaN5'=>'required',
            'TargetN1'=>'required',
            'TargetN2'=>'required',
            'TargetN3'=>'required',
            'TargetN4'=>'required',
            'TargetN5'=>'required'
        ]);
        
        $rpjmdindikatorkinerja->PrioritasKebijakanKabID = $request->input('PrioritasKebijakanKabID');
        $rpjmdindikatorkinerja->UrsID = $request->input('UrsID');
        $rpjmdindikatorkinerja->PrgID = $request->input('PrgID');
        $rpjmdindikatorkinerja->NamaIndikator = $request->input('NamaIndikator');
        $rpjmdindikatorkinerja->TargetAwal = $request->input('TargetAwal');
        $rpjmdindikatorkinerja->OrgID = $request->input('OrgID');
        $rpjmdindikatorkinerja->OrgID2 = $request->input('OrgID2');
        $rpjmdindikatorkinerja->PaguDanaN1 = $request->input('PaguDanaN1');
        $rpjmdindikatorkinerja->PaguDanaN2 = $request->input('PaguDanaN2');
        $rpjmdindikatorkinerja->PaguDanaN3 = $request->input('PaguDanaN3');
        $rpjmdindikatorkinerja->PaguDanaN4 = $request->input('PaguDanaN4');
        $rpjmdindikatorkinerja->PaguDanaN5 = $request->input('PaguDanaN5');
        $rpjmdindikatorkinerja->TargetN1 = $request->input('TargetN1');
        $rpjmdindikatorkinerja->TargetN2 = $request->input('TargetN2');
        $rpjmdindikatorkinerja->TargetN3 = $request->input('TargetN3');
        $rpjmdindikatorkinerja->TargetN4 = $request->input('TargetN4');
        $rpjmdindikatorkinerja->TargetN5 = $request->input('TargetN5');
        $rpjmdindikatorkinerja->Descr = $request->input('Descr');

        $rpjmdindikatorkinerja->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('rpjmdindikatorkinerja.show',['id'=>$id]))->with('success','Data ini telah berhasil disimpan.');
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
        
        $rpjmdindikatorkinerja = RPJMDIndikatorKinerjaModel::find($id);
        $result=$rpjmdindikatorkinerja->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('rpjmdindikatorkinerja'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.rpjmd.rpjmdindikatorkinerja.datatable")->with(['page_active'=>'rpjmdindikatorkinerja',
                                                            'search'=>$this->getControllerStateSession('rpjmdindikatorkinerja','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdindikatorkinerja.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('rpjmdindikatorkinerja.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}
