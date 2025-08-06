<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;

class DocumentController extends Controller
{


  function __construct()
    {
        
         $this->middleware('permission:documents-create', ['only' => ['create','store']]);
         $this->middleware('permission:documents-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:documents-list', ['only' => ['index']]);
         $this->middleware('permission:documents-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.documents');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = \Auth::user();
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_document_list', $request->limit);
        }else{
             $limit= Session::get('_document_list') ??  default_pagination();
            
        }
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $page_name = $this->page_name;

        $datas = DB::table('documents')
        ->select('documents.*','companies._name as company_name','branches._name as _branch_name','cost_centers._name as cost_center_name')
        ->join('companies','companies.id','documents.organization_id')
        ->join('branches','branches.id','documents._branch_id')
        ->join('cost_centers','cost_centers.id','documents._cost_center_id')
        ->where('documents._is_delete',0);

        $all_row = $datas->count();

        if($request->has('organization_id') && $request->organization_id !=''){
            $datas = $datas->where('documents.organization_id',$request->organization_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('documents._branch_id',$request->_branch_id);
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('documents._cost_center_id',$request->_cost_center_id);
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('documents._status',$request->_status);
        }
        if($request->has('document_title') && $request->document_title !=''){
            $datas = $datas->where('documents.document_title','like',"%trim($request->document_title)%");
        }

         $datas = $datas->orderBy($asc_cloumn,$_asc_desc);
         if($limit =='all'){
            $datas = $datas->paginate($all_row);
         }else{
            $datas = $datas->paginate($limit);
         }



         if($request->has('print')){
            if($request->print =="detail"){
                return view('backend.documents.show',compact('datas','page_name','request'));
            }
         }
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));

         return view('backend.documents.index',compact('datas','page_name','limit','request','permited_branch','permited_costcenters','permited_organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $page_name = $this->page_name;

         return view('backend.documents.create',compact('page_name','permited_branch','permited_costcenters','permited_organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id ==''){
            $Document = new Document();
            $Document->_created_by = \Auth::user()->id;
        }else{
            $Document = Document::find($request->id);
            $Document->_updated_by = \Auth::user()->id;
        }
        $Document->organization_id = $request->organization_id ?? 1;
        $Document->_branch_id = $request->_branch_id ?? 1;
        $Document->_cost_center_id = $request->_cost_center_id ?? 1;
        $Document->document_title = $request->document_title ?? '';
        $Document->_status = $request->_status ?? 0;
        if($request->hasFile('_documents')){ 
                $_documents = UserImageUpload($request->_documents); 
                $Document->_documents = $_documents;
        }
        $Document->save();
        return redirect()->back()
                        ->with('success','Information Save successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $page_name = $this->page_name;
        $data = DB::table('documents')
        ->select('documents.*','companies._name as company_name','branches._name as _branch_name','cost_centers._name as cost_center_name')
        ->join('companies','companies.id','documents.organization_id')
        ->join('branches','branches.id','documents._branch_id')
        ->join('cost_centers','cost_centers.id','documents._cost_center_id')->where('documents.id',$id)->first();

         return view('backend.documents.show',compact('page_name','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = \Auth::user();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $page_name = $this->page_name;
        $data= Document::find($id);

         return view('backend.documents.create',compact('page_name','permited_branch','permited_costcenters','permited_organizations','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::where('id',$id)->update(['_is_delete'=>1]);
        return redirect()->back()
                        ->with('success','Information Deleted successfully');
    }
}
