<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Basic\CostCenter;

class CostCenterController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:cost-centers-list|cost-centers-create|cost-centers-edit|cost-centers-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cost-centers-create', ['only' => ['create','store']]);
         $this->middleware('permission:cost-centers-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cost-centers-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.cost-centers');
        $this->new_page_name = __('label.new_cost-centers');
        $this->edit_page_name = __('label.edit_cost-centers');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CostCenter::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('master.cost-centers.index',compact('data','page_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $page_name = $this->page_name;
        $new_page_name = $this->new_page_name;
        return view('master.cost-centers.create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //UserImageUpload

        //return $request->all();

        $request->validate([
            '_name'=>'required|unique:cost_centers,_name',
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=[
                '_name'=>$request->_name,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    '_start_date'=>$request->_start_date ?? '',
                    '_end_date'=>$request->_end_date ?? '',
                    '_detail'=>$request->_detail ?? '',
                    'status'=>$request->status,
                    '_status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = CostCenter::insertGetId($input);
            return redirect()->route('cost-centers.index')
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
        try {
            $_lang_ref =  $request->_lang_ref ?? 'en_US';
            $data = CostCenter::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            return view('master.cost-centers.edit',compact('page_name','edit_page_name','data'));
        } catch (Throwable $e) {
            report($e);
     
            return false;
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

       // return $request->all();

        $request->validate([
            '_name'=>'required|unique:cost_centers,_name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=[
                '_name'=>$request->_name,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    '_start_date'=>$request->_start_date ?? '',
                    '_end_date'=>$request->_end_date ?? '',
                    '_detail'=>$request->_detail ?? '',
                    'status'=>$request->status,
                    '_status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            CostCenter::where('id',$id)->update($input);
            return redirect()->route('cost-centers.index')
            ->with('success', __('label.info_created'));
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
            CostCenter::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('cost-centers.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
