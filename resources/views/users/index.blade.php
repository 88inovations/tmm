@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('users.index') }}">User Management </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('user-create')
              <li class="breadcrumb-item active">
                <a 
               class="btn btn-sm btn-info active " 
               href="{{ route('users.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
                  
               </li>
              @endcan
            </ol>
          </div>

        
      </div><!-- /.container-fluid -->
    </div>
     @include('backend.message.message')
    <!-- /.content-header -->
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                @include('users.search')
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                     <thead>
                       <tr>
                       <th>No</th>
                       <th class="">Action</th>
                       <th>Name</th>
                       <th>EMP ID</th>
                       <th>Email</th>
                       <th>Ledger ID</th>
                       <th>Roles</th>
                       <th>Company</th>
                       <th>Branch</th>
                       <th>Cost Center</th>
                       <th>Store</th>
                       <th>Status</th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach ($data as $key => $user)
                      <tr>

                        <td>{{ $key+1 }}</td>
                         <td style="display: flex;">
                           
                                <a  
                                  href="{{ route('users.show',$user->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('user-edit')
                                  <a  
                                  href="{{ route('users.edit',$user->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('user-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                              
                        
                        <td>{{ $user->id }} - {{ $user->name }}</td>
                        <td>{{ $user->user_name ?? '' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->ref_id ?? '' }}</td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                               <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                          @endif
                        </td>
                         <td>
                         @php
                            $selected_organization_ids=[];
                            if($user->organization_ids !=0){
                                 $selected_organization_ids =  explode(",",$user->organization_ids);
                            }
                          @endphp
                          @forelse($organizations as $val)
                              @if(in_array($val->id,$selected_organization_ids)) <label class="badge badge-info">{{$val->_name}}</label> @endif
                              @empty
                              @endforelse


                        </td>
                        <td>
                         @php
                            $selected_branchs=[];
                            if($user->branch_ids !=0){
                                 $selected_branchs =  explode(",",$user->branch_ids);
                            }
                          @endphp
                          @forelse($branchs as $branch)
                              @if(in_array($branch->id,$selected_branchs)) <label class="badge badge-info">{{$branch->_name}}</label> @endif
                              @empty
                              @endforelse


                        </td>
                       
                        <td>
                         @php
                            $selected_costcenters=[];
                            if($user->cost_center_ids !=0){
                                 $selected_costcenters =  explode(",",$user->cost_center_ids);
                            }
                          @endphp
                          @forelse($cost_centers as $costcenter)
                              @if(in_array($costcenter->id,$selected_costcenters)) <label class="badge badge-info">{{$costcenter->_name}}</label> @endif
                              @empty
                              @endforelse
                        </td>
                         <td>
                         @php
                            $selected_store_ids=[];
                            if($user->store_ids !=0){
                                 $selected_store_ids =  explode(",",$user->store_ids);
                            }
                          @endphp
                          @forelse($stores as $val)
                              @if(in_array($val->id,$selected_store_ids)) <label class="badge badge-info">{{$val->_name}}</label> @endif
                              @empty
                              @endforelse


                        </td>
                        <td>
                          
                          {{ ($user->status==1) ? 'Active' : 'In Active' }}</td>
                       
                      </tr>
                     @endforeach
                     </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

 

                

                <div class="d-flex flex-row justify-content-end">
                  {!! $data->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>
@endsection