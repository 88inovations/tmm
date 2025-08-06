<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Basic\Store;

class StoreController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:store-house-list|store-house-create|store-house-edit|store-house-delete', ['only' => ['index','store']]);
         $this->middleware('permission:store-house-create', ['only' => ['create','store']]);
         $this->middleware('permission:store-house-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:store-house-delete', ['only' => ['destroy']]);
        $this->page_name = __('label.store-house');
        $this->new_page_name = __('label.new_store-house');
        $this->edit_page_name = __('label.edit_store-house');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Store::where('is_delete',0)->get();
        $page_name = $this->page_name;
        return view('backend.store-house.index',compact('data','page_name'));
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
         $branchs =[];
        return view('backend.store-house.create',compact('page_name','branchs'));
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

        $request->validate([
            '_name'=>'required|unique:store_houses,_name',
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['_name'=>$request->_name,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

        $id = Store::insertGetId($input);
            return redirect()->route('store-house.index')
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
            $data = Store::where('is_delete',0)->find($id);
            $page_name = $this->page_name;
            $edit_page_name = $this->edit_page_name;
            $branchs =[];
            return view('backend.store-house.edit',compact('page_name','edit_page_name','data','branchs'));
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
        $request->validate([
            '_name'=>'required|unique:store_houses,_name,'.$id,
            'status' => 'required|max:20',
        ]);

        try {
           

            $input=['_name'=>$request->_name,
                    '_code'=>$request->_code ??  takeFirstLetter($request->_name),
                    'description'=>$request->description,
                    'status'=>$request->status,
                    'is_delete'=>0,
                    'order'=>$request->order,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

            Store::where('id',$id)->update($input);
            return redirect()->route('store-house.index')
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
            Store::where('id',$id)->update(['is_delete'=>1]);
            return redirect()->route('store-house.index')
            ->with('success', __('label.info_deleted_successfully'));
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
