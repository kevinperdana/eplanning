<?php

namespace App\Controllers\RENSTRA;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RENSTRA\RENSTRAIndikatorSasaranModel;
use App\Models\RENSTRA\RENSTRAKebijakanModel;
use App\Rules\CheckRecordIsExistValidation;
use App\Rules\IgnoreIfDataIsEqualValidation;

class RENSTRAIndikatorSasaranController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin|bapelitbang|opd']);
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        $columns=['*'];       
        if (!$this->checkStateIsExistSession('renstraindikatorsasaran','orderby')) 
        {            
           $this->putControllerStateSession('renstraindikatorsasaran','orderby',['column_name'=>'NamaIndikator','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'); 
        $direction=$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        
        if ($this->checkStateIsExistSession('renstraindikatorsasaran','search')) 
        {
            $search=$this->getControllerStateSession('renstraindikatorsasaran','search');
            switch ($search['kriteria']) 
            {                
                case 'NamaIndikator' :
                    $data = RENSTRAIndikatorSasaranModel::where('NamaIndikator', 'ilike', '%' . $search['isikriteria'] . '%')->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = RENSTRAIndikatorSasaranModel::select(\DB::raw('"RenstraIndikatorID","tmUrs"."Nm_Bidang","tmPrg"."PrgNm","tmOrg"."OrgNm","trIndikatorKinerja"."NamaIndikator" AS "IndikatorKinerja","tmRenstraKebijakan"."Nm_RenstraKebijakan","trRenstraIndikator"."NamaIndikator","trRenstraIndikator"."Descr","trRenstraIndikator"."TA","trRenstraIndikator"."created_at","trRenstraIndikator"."updated_at"'))
                                                ->join('tmUrs','tmUrs.UrsID','trRenstraIndikator.UrsID')
                                                ->join('tmPrg','tmPrg.PrgID','trRenstraIndikator.PrgID')
                                                ->join('tmOrg','tmOrg.OrgID','trRenstraIndikator.OrgID')
                                                ->join('trIndikatorKinerja','trIndikatorKinerja.IndikatorKinerjaID','trRenstraIndikator.IndikatorKinerjaID')
                                                ->join('tmRenstraKebijakan','tmRenstraKebijakan.RenstraKebijakanID','trRenstraIndikator.RenstraKebijakanID')
                                                ->where('trRenstraIndikator.TA',\HelperKegiatan::getRENSTRATahunMulai())
                                                ->orderBy($column_order,$direction)->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('renstraindikatorsasaran.index'));
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
        
        $this->setCurrentPageInsideSession('renstraindikatorsasaran',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',
                                                                                'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
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
        $this->putControllerStateSession('renstraindikatorsasaran','orderby',['column_name'=>$column_name,'order'=>$orderby]);      

        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('renstraindikatorsasaran');         
        $data=$this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        
        $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',
                                                            'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
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

        $this->setCurrentPageInsideSession('renstraindikatorsasaran',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',
                                                                            'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
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
            $this->destroyControllerStateSession('renstraindikatorsasaran','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('renstraindikatorsasaran','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('renstraindikatorsasaran',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',                                                            
                                                            'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
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

        $filters=$this->getControllerStateSession('renstraindikatorsasaran','filters');       
        $json_data = [];

        //index
        if ($request->exists('OrgID'))
        {
            $OrgID = $request->input('OrgID')==''?'none':$request->input('OrgID');
            $filters['OrgID']=$OrgID;            
            $this->putControllerStateSession('renstraindikatorsasaran','filters',$filters);
            
            $data = $this->populateData();

            $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',                                                                               
                                                                            'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                            'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                            'data'=>$data])->render();

            
            $json_data = ['success'=>true,'datatable'=>$datatable];
        } 
        return response()->json($json_data,200);
    }
    public function pilihindikatorsasaran(Request $request)
    {
        $json_data=[];
        if ($request->exists('UrsID'))
        {
            $UrsID = $request->input('UrsID')==''?'none':$request->input('UrsID');
            $daftar_program = \App\Models\DMaster\ProgramModel::getDaftarProgram(\HelperKegiatan::getRENSTRATahunMulai(),false,$UrsID);
            $json_data['success']=true;
            $json_data['UrsID']=$UrsID;
            $json_data['daftar_program']=$daftar_program;
        }
        if ($request->exists('PrgID'))
        {
            $PrgID = $request->input('PrgID')==''?'none':$request->input('PrgID');
            $r=\DB::table('trIndikatorKinerja')
                    ->select(\DB::raw('"IndikatorKinerjaID","NamaIndikator"'))
                    ->where('TA',\HelperKegiatan::getRENSTRATahunMulai())
                    ->where('PrgID',$PrgID)                    
                    ->orderBy('NamaIndikator')
                    ->get();
            $daftar_indikator=[];        
            foreach ($r as $k=>$v)
            { 
                $daftar_indikator[$v->IndikatorKinerjaID]=$v->NamaIndikator;
            }            
            $json_data['success']=true;
            $json_data['PrgID']=$PrgID;
            $json_data['daftar_indikator']=$daftar_indikator;
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
        $auth = \Auth::user();    
        $theme = $auth->theme;

        $filters=$this->getControllerStateSession('renstraindikatorsasaran','filters');
        $roles=$auth->getRoleNames();   
        switch ($roles[0])
        {
            case 'superadmin' :     
            case 'bapelitbang' :     
            case 'tapd' :     
                $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(\HelperKegiatan::getTahunPerencanaan(),false);   
            break;
            case 'opd' :               
                $daftar_opd=\App\Models\UserOPD::getOPD();                      
                if (!(count($daftar_opd) > 0))
                {  
                    return view("pages.$theme.renstra.renstraindikatorsasaran.error")->with(['page_active'=>'renstraindikatorsasaran', 
                                                                                    'page_title'=>\HelperKegiatan::getPageTitle('renstraindikatorsasaran'),
                                                                                    'errormessage'=>'Anda Tidak Diperkenankan Mengakses Halaman ini, karena Sudah dikunci oleh BAPELITBANG',
                                                                                    ]);
                }          
            break;
        }

        $search=$this->getControllerStateSession('renstraindikatorsasaran','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('renstraindikatorsasaran'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('renstraindikatorsasaran',$data->currentPage());
        
        return view("pages.$theme.renstra.renstraindikatorsasaran.index")->with(['page_active'=>'renstraindikatorsasaran',
                                                                                    'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                                                    'filters'=>$filters,
                                                                                    'daftar_opd'=>$daftar_opd,
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                                    'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
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
        $filters=$this->getControllerStateSession('renstraindikatorsasaran','filters');  
        if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
        {   
            $daftar_urusan=\App\Models\DMaster\UrusanModel::getDaftarUrusanByOPD(\HelperKegiatan::getRENSTRATahunMulai(),$filters['OrgID'],false);   
            $daftar_urusan['all']='SEMUA URUSAN';            
            $organisasi=\App\Models\DMaster\OrganisasiModel::find($filters['OrgID']);                        
            $UrsID=$organisasi->UrsID;
            $daftar_program=[];
            if (isset($daftar_urusan[$UrsID]))
            {
                $daftar_program = \App\Models\DMaster\ProgramModel::getDaftarProgram(\HelperKegiatan::getRENSTRATahunMulai(),false,$UrsID);
            }            

            $daftar_kebijakan=\App\Models\RENSTRA\RENSTRAKebijakanModel::select(\DB::raw('"RenstraKebijakanID",CONCAT(\'[\',"Kd_RenstraKebijakan",\']. \',"Nm_RenstraKebijakan") AS "Nm_RenstraKebijakan"'))
                                                                        ->where('TA',\HelperKegiatan::getRENSTRATahunMulai())
                                                                        ->orderBy('Kd_RenstraKebijakan','ASC')
                                                                        ->get()
                                                                        ->pluck('Nm_RenstraKebijakan','RenstraKebijakanID')
                                                                        ->toArray();
                    

            return view("pages.$theme.renstra.renstraindikatorsasaran.create")->with(['page_active'=>'renstraindikatorsasaran',
                                                                                    'organisasi'=>$organisasi,
                                                                                    'daftar_urusan'=>$daftar_urusan,
                                                                                    'daftar_kebijakan'=>$daftar_kebijakan,
                                                                                    'daftar_program'=>$daftar_program,
                                                                                    'UrsID_selected'=>$UrsID,
                                                                                ]);  
        }
        else
        {
            return view("pages.$theme.renstra.renstraindikatorsasaran.error")->with(['page_active'=>'renstraindikatorsasaran',
                                                                        'errormessage'=>'Mohon OPD / SKPD untuk di pilih terlebih dahulu.'
                                                                    ]);  
        }
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
            'RenstraKebijakanID'=>'required',
            'IndikatorKinerjaID'=>'required',
            'UrsID'=>'required',
            'PrgID'=>'required',          
            'NamaIndikator'=>'required',                       
        ]);
        
        $renstraindikatorsasaran = RENSTRAIndikatorSasaranModel::create([
            'RenstraIndikatorID' => uniqid ('uid'),
            'RenstraKebijakanID' => $request->input('RenstraKebijakanID'),
            'IndikatorKinerjaID' => $request->input('IndikatorKinerjaID'),
            'UrsID' => $request->input('UrsID'),
            'PrgID' => $request->input('PrgID'),
            'OrgID' => $request->input('OrgID'), 
            'NamaIndikator' => $request->input('NamaIndikator'),                      
            'Descr' => $request->input('Descr'),
            'TA' => \HelperKegiatan::getRENSTRATahunMulai()            
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
            return redirect(route('renstraindikatorsasaran.show',['id'=>$renstraindikatorsasaran->RenstraIndikatorID]))->with('success','Data ini telah berhasil disimpan.');
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

        $data = \DB::table('trRenstraIndikator')
                    ->select(\DB::raw('"RenstraIndikatorID","tmUrs"."Nm_Bidang","tmPrg"."PrgNm","tmOrg"."OrgNm","trIndikatorKinerja"."NamaIndikator" AS "IndikatorKinerja","tmRenstraKebijakan"."Nm_RenstraKebijakan","trRenstraIndikator"."NamaIndikator","trRenstraIndikator"."Descr","trRenstraIndikator"."TA","trRenstraIndikator"."created_at","trRenstraIndikator"."updated_at"'))
                    ->join('tmUrs','tmUrs.UrsID','trRenstraIndikator.UrsID')
                    ->join('tmPrg','tmPrg.PrgID','trRenstraIndikator.PrgID')
                    ->join('tmOrg','tmOrg.OrgID','trRenstraIndikator.OrgID')
                    ->join('trIndikatorKinerja','trIndikatorKinerja.IndikatorKinerjaID','trRenstraIndikator.IndikatorKinerjaID')
                    ->join('tmRenstraKebijakan','tmRenstraKebijakan.RenstraKebijakanID','trRenstraIndikator.RenstraKebijakanID')
                    ->where('RenstraIndikatorID',$id)
                    ->first();
        
        if (!is_null($data) )  
        {
            return view("pages.$theme.renstra.renstraindikatorsasaran.show")->with(['page_active'=>'renstraindikatorsasaran',
                                                                                    'data'=>$data
                                                                                ]);
        }
        else
        {
            return view("pages.$theme.renstra.renstraindikatorsasaran.error")->with(['page_active'=>'renstraindikatorsasaran',
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
        
        $data = RENSTRAIndikatorSasaranModel::select(\DB::raw('"RenstraIndikatorID","RenstraKebijakanID","IndikatorKinerjaID","trRenstraIndikator"."UrsID","PrgID","trRenstraIndikator"."OrgID","OrgNm","trRenstraIndikator"."NamaIndikator","trRenstraIndikator"."Descr"'))
                                            ->join('tmOrg','tmOrg.OrgID','trRenstraIndikator.OrgID')
                                            ->findOrFail($id);
        if (!is_null($data) ) 
        {
            $daftar_urusan=\App\Models\DMaster\UrusanModel::getDaftarUrusanByOPD(\HelperKegiatan::getRENSTRATahunMulai(),$data->OrgID,false);   
            $daftar_urusan['all']='SEMUA URUSAN';                                                        
            $daftar_program=[];
            if (isset($daftar_urusan[$data->UrsID]))
            {
                $daftar_program = \App\Models\DMaster\ProgramModel::getDaftarProgram(\HelperKegiatan::getRENSTRATahunMulai(),false,$data->UrsID);
            }            

            $daftar_indikator=\App\Models\RPJMD\RPJMDIndikatorKinerjaModel::select(\DB::raw('"IndikatorKinerjaID","NamaIndikator"'))
                                                                        ->where('TA',\HelperKegiatan::getRENSTRATahunMulai())
                                                                        ->where('PrgID',$data->PrgID)                    
                                                                        ->orderBy('NamaIndikator')
                                                                        ->get()
                                                                        ->pluck('NamaIndikator','IndikatorKinerjaID')
                                                                        ->toArray();

            $daftar_kebijakan=\App\Models\RENSTRA\RENSTRAKebijakanModel::select(\DB::raw('"RenstraKebijakanID",CONCAT(\'[\',"Kd_RenstraKebijakan",\']. \',"Nm_RenstraKebijakan") AS "Nm_RenstraKebijakan"'))
                                                                        ->where('TA',\HelperKegiatan::getRENSTRATahunMulai())
                                                                        ->orderBy('Kd_RenstraKebijakan','ASC')
                                                                        ->get()
                                                                        ->pluck('Nm_RenstraKebijakan','RenstraKebijakanID')
                                                                        ->toArray();

            return view("pages.$theme.renstra.renstraindikatorsasaran.edit")->with(['page_active'=>'renstraindikatorsasaran',
                                                                                    'data'=>$data,
                                                                                    'daftar_urusan'=>$daftar_urusan,
                                                                                    'daftar_kebijakan'=>$daftar_kebijakan,
                                                                                    'daftar_program'=>$daftar_program,
                                                                                    'daftar_indikator'=>$daftar_indikator,
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
        $renstraindikatorsasaran = RENSTRAIndikatorSasaranModel::find($id);
        
        $this->validate($request, [
            'RenstraKebijakanID'=>'required',
            'IndikatorKinerjaID'=>'required',
            'UrsID'=>'required',
            'PrgID'=>'required',          
            'NamaIndikator'=>'required', 
        ]);
        $renstraindikatorsasaran->RenstraKebijakanID = $request->input('RenstraKebijakanID');
        $renstraindikatorsasaran->IndikatorKinerjaID = $request->input('IndikatorKinerjaID');
        $renstraindikatorsasaran->UrsID = $request->input('UrsID');
        $renstraindikatorsasaran->PrgID = $request->input('PrgID');
        $renstraindikatorsasaran->NamaIndikator = $request->input('NamaIndikator');
        $renstraindikatorsasaran->Descr = $request->input('Descr');

        $renstraindikatorsasaran->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('renstraindikatorsasaran.show',['id'=>$id]))->with('success','Data ini telah berhasil disimpan.');
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
        
        $renstraindikatorsasaran = RENSTRAIndikatorSasaranModel::find($id);
        $result=$renstraindikatorsasaran->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('renstraindikatorsasaran'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.renstra.renstraindikatorsasaran.datatable")->with(['page_active'=>'renstraindikatorsasaran',
                                                            'search'=>$this->getControllerStateSession('renstraindikatorsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstraindikatorsasaran.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('renstraindikatorsasaran.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}
