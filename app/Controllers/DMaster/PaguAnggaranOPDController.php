<?php

namespace App\Controllers\DMaster;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Rules\CheckRecordIsExistValidation;
use App\Rules\IgnoreIfDataIsEqualValidation;
use App\Models\DMaster\PaguAnggaranOPDModel;
use App\Models\DMaster\OrganisasiModel;

class PaguAnggaranOPDController extends Controller {
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
        if (!$this->checkStateIsExistSession('paguanggaranopd','orderby')) 
        {            
           $this->putControllerStateSession('paguanggaranopd','orderby',['column_name'=>'v_urusan_organisasi.kode_organisasi','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('paguanggaranopd.orderby','column_name'); 
        $direction=$this->getControllerStateSession('paguanggaranopd.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        
        if ($this->checkStateIsExistSession('paguanggaranopd','search')) 
        {
            $search=$this->getControllerStateSession('paguanggaranopd','search');
            switch ($search['kriteria']) 
            {
                case 'OrgNm' :
                    $data = PaguAnggaranOPDModel::join('v_urusan_organisasi','tmPaguAnggaranOPD.OrgID','v_urusan_organisasi.OrgID')
                                                ->where('OrgNm', 'ilike', '%' . $search['isikriteria'] . '%')
                                                ->where('tmPaguAnggaranOPD.TA',\HelperKegiatan::getTahunPerencanaan())
                                                ->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = PaguAnggaranOPDModel::join('v_urusan_organisasi','tmPaguAnggaranOPD.OrgID','v_urusan_organisasi.OrgID')
                                        ->where('tmPaguAnggaranOPD.TA',\HelperKegiatan::getTahunPerencanaan())
                                        ->orderBy($column_order,$direction)
                                        ->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('paguanggaranopd.index'));
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
        
        $this->setCurrentPageInsideSession('paguanggaranopd',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.dmaster.paguanggaranopd.datatable")->with(['page_active'=>'paguanggaranopd',
                                                                                'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
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
            case 'col-kode_organisasi' :
                $column_name = 'v_urusan_organisasi.kode_organisasi';
            break; 
            case 'col-OrgNm' :
                $column_name = 'v_urusan_organisasi.OrgNm';
            break;  
            case 'col-Jumlah1' :
                $column_name = 'tmPaguAnggaranOPD.Jumlah1';
            break; 
            case 'col-Jumlah2' :
                $column_name = 'tmPaguAnggaranOPD.Jumlah2';
            break;          
            default :
                $column_name = 'v_urusan_organisasi.kode_organisasi';
        }
        $this->putControllerStateSession('paguanggaranopd','orderby',['column_name'=>$column_name,'order'=>$orderby]);      

        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('paguanggaranopd');         
        $data=$this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        
        $datatable = view("pages.$theme.dmaster.paguanggaranopd.datatable")->with(['page_active'=>'paguanggaranopd',
                                                            'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
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

        $this->setCurrentPageInsideSession('paguanggaranopd',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.dmaster.paguanggaranopd.datatable")->with(['page_active'=>'paguanggaranopd',
                                                                            'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
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
            $this->destroyControllerStateSession('paguanggaranopd','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('paguanggaranopd','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('paguanggaranopd',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.dmaster.paguanggaranopd.datatable")->with(['page_active'=>'paguanggaranopd',                                                            
                                                            'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
                                                            'data'=>$data])->render();      
        
        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $theme = \Auth::user()->theme;

        $search=$this->getControllerStateSession('paguanggaranopd','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('paguanggaranopd'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('paguanggaranopd',$data->currentPage());
        
        return view("pages.$theme.dmaster.paguanggaranopd.index")->with(['page_active'=>'paguanggaranopd',
                                                'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
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
        $q=\DB::table('v_urusan_organisasi')
                                ->select(\DB::raw('"v_urusan_organisasi"."OrgID","v_urusan_organisasi"."kode_organisasi","v_urusan_organisasi"."OrgNm"'))
                                ->leftJoin('tmPaguAnggaranOPD','tmPaguAnggaranOPD.OrgID','v_urusan_organisasi.OrgID')
                                ->whereNull('tmPaguAnggaranOPD.OrgID')
                                ->where('v_urusan_organisasi.TA',\HelperKegiatan::getTahunPerencanaan())
                                ->orderBy('kode_organisasi')
                                ->get();
        $daftar_organisasi=[];        
        foreach ($q as $k=>$v)
        {
            $daftar_organisasi[$v->OrgID]=$v->kode_organisasi.'. '.$v->OrgNm;
        } 
        return view("pages.$theme.dmaster.paguanggaranopd.create")->with(['page_active'=>'paguanggaranopd',
                                                                        'daftar_opd'=>$daftar_organisasi
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
            'OrgID'=> [new CheckRecordIsExistValidation('tmPaguAnggaranOPD',['where'=>['TA','=',\HelperKegiatan::getTahunPerencanaan()]]),
                        'required'],
            'Jumlah1'=>'required|numeric',
            'Jumlah2'=>'required|numeric',
        ]);
        
        $paguanggaranopd = PaguAnggaranOPDModel::create([
            'PaguAnggaranOPDID' => uniqid ('uid'),
            'OrgID' => $request->input('OrgID'),
            'Jumlah1' => $request->input('Jumlah1'),
            'Jumlah2' => $request->input('Jumlah2'),
            'Descr' => $request->input('Descr'),
            'TA' => \HelperKegiatan::getTahunPerencanaan()
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
            return redirect(route('paguanggaranopd.show',['id'=>$paguanggaranopd->PaguAnggaranOPDID]))->with('success','Data ini telah berhasil disimpan.');
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

        $data = PaguAnggaranOPDModel::join('v_urusan_organisasi','tmPaguAnggaranOPD.OrgID','v_urusan_organisasi.OrgID')
                                    ->where('tmPaguAnggaranOPD.TA',\HelperKegiatan::getTahunPerencanaan())
                                    ->findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.dmaster.paguanggaranopd.show")->with(['page_active'=>'paguanggaranopd',
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
        
        $data = PaguAnggaranOPDModel::where('TA',\HelperKegiatan::getTahunPerencanaan())
                                    ->findOrFail($id);
        if (!is_null($data) ) 
        {
            $daftar_opd=OrganisasiModel::getDaftarOPD(\HelperKegiatan::getTahunPerencanaan(),false,NULL,$data->OrgID);
            return view("pages.$theme.dmaster.paguanggaranopd.edit")->with(['page_active'=>'paguanggaranopd',
                                                                                'data'=>$data,
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
        $paguanggaranopd = PaguAnggaranOPDModel::find($id);
        
        $this->validate($request, [
            'OrgID'=> [new IgnoreIfDataIsEqualValidation('tmPaguAnggaranOPD',$paguanggaranopd->OrgID,['where'=>['TA','=',\HelperKegiatan::getTahunPerencanaan()]]),
                        'required'],
            'Jumlah1'=>'required|numeric',
            'Jumlah2'=>'required|numeric',
        ]);
        
        $paguanggaranopd->OrgID = $request->input('OrgID');
        $paguanggaranopd->Jumlah1 = $request->input('Jumlah1');
        $paguanggaranopd->Jumlah2 = $request->input('Jumlah2');
        $paguanggaranopd->Descr = $request->input('Descr');       
        
        $paguanggaranopd->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('paguanggaranopd.show',['id'=>$paguanggaranopd->PaguAnggaranOPDID]))->with('success','Data ini telah berhasil disimpan.');
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
        
        $paguanggaranopd = PaguAnggaranOPDModel::where('TA',\HelperKegiatan::getTahunPerencanaan())
                                                ->find($id);
        $result=$paguanggaranopd->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('paguanggaranopd'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.dmaster.paguanggaranopd.datatable")->with(['page_active'=>'paguanggaranopd',
                                                            'search'=>$this->getControllerStateSession('paguanggaranopd','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('paguanggaranopd.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('paguanggaranopd.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('paguanggaranopd.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}