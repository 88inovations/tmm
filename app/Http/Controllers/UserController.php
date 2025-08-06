<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use App\Models\CostCenter;
use App\Models\HRM\Company;
use App\Models\StoreHouse;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Auth;
    
class UserController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index(Request $request)
    {
        
        $limit = $request->limit ?? default_pagination();
        $data = User::where('name','!=','');
        if($request->has('name') && $request->name !=''){
            $data = $data->where('name','like',"%$request->name%");
        }
        if($request->has('email ') && $request->email  !=''){
            $data = $data->where('email ','like',"%$request->email %");
        }
        if($request->has('user_name ') && $request->user_name  !=''){
            $data = $data->where('user_name ',$request->user_name );
        }
        if($request->has('branch_ids') && $request->branch_ids !=''){
            $data = $data->where('branch_ids','like',"%$request->branch_ids%");
        }

        $data = $data->orderBy('id','asc')->paginate($limit);

        $branchs = Branch::select('id','_name')->orderBy('_name','asc')->get();
        $cost_centers = CostCenter::select('id','_name')->orderBy('_name','ASC')->get();
        $organizations = Company::select('id','_name')->where('_status',1)->orderBy('_name','ASC')->get();
        $stores = StoreHouse::select('id','_name')->where('_status',1)->orderBy('_name','ASC')->get();
        return view('users.index',compact('data','branchs','request','cost_centers','organizations','stores'));
    }


//own user name and password Update

    public function userProfile(){
         $user = Auth::user();
        return view('users.profile',compact('user'));
    }
    public function profileUpdate(Request $request){
        $id = $request->id;
         $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            
        ]);
        
        
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        if($request->hasFile('image')){ 
            $_image = UserImageUpload($request->image); 
            $input['image'] = $_image;
        }
        
        $user = User::find($id);
        $user->update($input);
        

        return redirect()->back()->with('success','Profile updated successfully');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
         $branchs = Branch::orderBy('_name','asc')->get();
         $cost_centers = CostCenter::select('id','_name')->orderBy('_name','ASC')->get();
        return view('users.create',compact('roles','branchs','cost_centers'));
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
            'name' => 'required',
            'branch_ids' => 'required|array',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            '_ac_type' => 'required',
            'cost_center_ids' => 'required',
            'ref_id' => 'required',
        ]);
    
        $input = $request->all();
       if(isset($request->branch_ids)){
            $branch_ids = implode(",",$request->branch_ids);
            $input['branch_ids'] = $branch_ids;
        }else{
            $input['branch_ids'] = 1;
        }

       if(isset($request->organization_ids)){
            $organization_ids = implode(",",$request->organization_ids);
            $input['organization_ids'] = $organization_ids;
        }else{
            $input['organization_ids'] = 1;
        }
        
        
         if(isset($request->cost_center_ids) ){
            $cost_center_ids = implode(",",$request->cost_center_ids);
            $input['cost_center_ids'] = $cost_center_ids;
        }else{
            $input['cost_center_ids'] = 1;
        }
        if(isset($request->store_ids)){
            $store_ids = implode(",",$request->store_ids);
            $input['store_ids'] = $store_ids;
        }else{
            $input['store_ids'] = 1;
        }


        $input['_ac_type'] = $request->_ac_type;
        // if($request->_ac_type==1){
        //     if(sizeof($request->branch_ids) > 1){
        //         $input['_ac_type'] = 0;
        //     }
        //     if(sizeof($request->cost_center_ids) > 1){
        //         $input['_ac_type'] = 0;
        //     }
        // }

        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
         $branchs = Branch::orderBy('_name','asc')->get();
          $cost_centers = CostCenter::select('id','_name')->orderBy('_name','ASC')->get();
    
        return view('users.edit',compact('user','roles','userRole','branchs','cost_centers'));
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
        
        //return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'branch_ids' => 'required|array',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            '_ac_type' => 'required',
            'cost_center_ids' => 'required',
            'ref_id' => 'required',
        ]);
        
    
        $input = $request->all();
        if(isset($request->branch_ids)){
            $branch_ids = implode(",",$request->branch_ids);
            $input['branch_ids'] = $branch_ids;
        }else{
            $input['branch_ids'] = 1;
        }

        if(isset($request->organization_ids)){
            $organization_ids = implode(",",$request->organization_ids);
            $input['organization_ids'] = $organization_ids;
        }else{
            $input['organization_ids'] = 1;
        }
        if(isset($request->store_ids)){
            $store_ids = implode(",",$request->store_ids);
            $input['store_ids'] = $store_ids;
        }else{
            $input['store_ids'] = 1;
        }
        
        
         if(isset($request->cost_center_ids) ){
            $cost_center_ids = implode(",",$request->cost_center_ids);
            $input['cost_center_ids'] = $cost_center_ids;
        }else{
            $input['cost_center_ids'] =1;
        }
        

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        $input['_ac_type'] = $request->_ac_type;
        // if($request->_ac_type==1){
        //     if(sizeof($request->branch_ids) > 1){
        //         $input['_ac_type'] = 0;
        //     }
        //     if(sizeof($request->cost_center_ids) > 1){
        //         $input['_ac_type'] = 0;
        //     }
        // }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('success','User deleted successfully');
    }
}