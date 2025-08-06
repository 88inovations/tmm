<?php

namespace App\Http\Controllers\AssetManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetManagement\AssetsCategory;

class AssetsCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-category-list|asset-category-create|asset-category-edit|asset-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-category-delete', ['only' => ['destroy']]);
         $this->page_name = __('label.asset-category');
        $this->new_page_name = __('label.new_asset-category');
        $this->edit_page_name = __('label.edit_asset-category');
    }




    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_name = $this->page_name;
            $datas = AssetsCategory::with(['category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->where('is_delete',0)->orderBy('_name','ASC')->get();
         $data = [];
         foreach($datas as $value){
            $data[] = $value;
         }
         //return $data;
        return view('apps.asset-management.asset-category.index', compact('data','page_name','datas'));
    }


    public function category_detail(Request $request){
        $category_id = $request->category_id ?? '';
       return  $data = \App\Models\ItemCategory::with(['category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->find($category_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = $this->page_name;
        $datas = AssetsCategory::where('is_delete',0)->orderBy('_name','ASC')->get();
         $data = [];
         foreach($datas as $value){
            $data[] = $value;
         }
        return view('apps.asset-management.asset-category.create', compact('page_name','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       // return $request->all();
        $request->validate([
            'name'=>'required|unique:assets_categories,name',
            'status' => 'required|max:20',
        ]);



        try {
            $data = new AssetsCategory();
            $data->name= $request->name;
            $data->parent_id= $request->parent_id ?? 0;
            $data->description= $request->description ?? '';
            $data->asset_ledger_id= $request->asset_ledger_id ?? 0;
            $data->asset_dep_ledger_id= $request->asset_dep_ledger_id ?? 0;
            $data->asset_dep_exp_ledger_id= $request->asset_dep_exp_ledger_id ?? 0;
            $data->dep_rate= $request->dep_rate ?? 0;

            $data->status= $request->status ?? 0;
            $data->code= $request->code ?? takeFirstLetter($request->name);
            if($request->has('image')){
               $data->image = _imageUploader($request->image); 
            }
            $data->order= $request->order ?? 0;
            $data->is_featured= $request->is_featured ?? 0;
            $data->save();

            //After add Account moudle Ledger Id Coloumn Data will be updated



            return redirect()->route('asset-category.index')
            ->with('success', __('label.info_created'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $id = $id;
         $_lang_ref = $_GET["_lang_ref"] ?? 'en_US';
         $page_name = $this->page_name;
         $info = AssetsCategory::with(['children','category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->where('is_delete',0)->find($id);
        
        $datas = AssetsCategory::with(['category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])->where('is_delete',0)->orderBy('_name','ASC')->get();
         $data = [];
         foreach($datas as $value){
            $data[] = $value;
         }
        
        return view('apps.asset-management.asset-category.edit', compact('page_name','data','info'));
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
         // dump($request->all());
         // die();
        $request->validate([
            'id' => 'required',
            'name'=>'required|unique:assets_categories,name,'.$id,
            'status' => 'required|max:20',
        ]);

        $default_lan = _default_language();

        try {

            $lang_code = $request->lang_code ?? 'en_US';
            $data = AssetsCategory::find($id);
            $data->asset_ledger_id= $request->asset_ledger_id ?? 0;
            $data->asset_dep_ledger_id= $request->asset_dep_ledger_id ?? 0;
            $data->asset_dep_exp_ledger_id= $request->asset_dep_exp_ledger_id ?? 0;
            $data->dep_rate= $request->dep_rate ?? 0;
            $data->name= $request->name;
            $data->code= $request->code ?? takeFirstLetter($request->name);
            $data->description= $request->description ?? ''; 

           
            $data->status= $request->status ?? 0;
            if($request->has('image')){
               $data->image = _imageUploader($request->image); 
            }
            //$data->order= $request->order ?? 0;
            //$data->is_featured= $request->is_featured ?? 0;
            $data->save();
            
           



            return redirect()->route('asset-category.index')
            ->with('success', __('label.info_updated'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try {
            AssetsCategory::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('asset-category.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
