@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

@php
$_type = $request->_type ?? 'customer';
@endphp

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('group_wise_list') }}?_type={{$_type}}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('account-ledger-create')
              <li class="breadcrumb-item active">
                  
   <a 
       class="btn btn-sm btn-info active "  
       href="{{ route('group_wise_create') }}?_type={{$_type}}">
        <i class="nav-icon fas fa-plus"></i> Create New
       </a>
                 


               </li>
              @endcan
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif






    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
        
              
                 

                  <div class="row">
                   @php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   @endphp
                    <div class="col-md-4">
                      @include('backend.account-ledger.customer_search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('voucher-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i> Print
                                </a>  
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
           
             
                <div class="">
                  <table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>SL</th>
                         <th class="">Action</th>
                        
                         <th>{{__('label._branch_id')}}</th>
                         <th>Ledger ID</th>
                         <th>Code</th>
                         <th>Ledger Name</th>
                         <th>{{__('label._alious')}}</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Address</th>
                         <th>Credit Limit</th>
                         <th>Balance</th>
                         <th>Note</th>
                         <th>Possition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                       $_new_datas=array();
                        foreach ($datas as $value) {
                            $_new_datas[$value->_account_head_id ?? ''."-".$value->account_type->_name ?? ''][$value->_account_group_id ?? ''."-".$value->account_group->_name ?? ''][]=$value;
                        }
                      @endphp
                        
                           @forelse($datas as $key3=>$data)

                        <tr>
                           <td>{{($key3+1)}}</td>
                           <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                     <button type="button" 
                                     class="btn btn-sm btn-info active attr_base_edit_url mr-2" 
                                     data-toggle="modal" data-target="#commonEntryModal_item" 
                                    attr_base_edit_url="{{ route('account-ledger.edit',$data->id) }}">
                                      <i class="fa fa-pen "></i>
                                     </button>
                                  @endcan
                                  @can('hrm-module')
                                  @if(in_array($data->_account_group_id,$_employee_group_array))
                                     <a class="btn btn-sm  mr-2" title="Copy To Employee" target="__blank" href="{{url('copy_to_employee')}}/{{$data->id}}"><i class="fa fa-copy"></i></a>
                                  @endif
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                          
                             
                           
                            <td>{{ $data->_entry_branch->id ?? '' }}-{{ $data->_entry_branch->_name ?? '' }}</td>
                            <td><a href="{{url('full_ledger_detail')}}?_ledger_id={{$data->id}}">{{ $data->id }}</a></td>
                            <td><a href="{{url('full_ledger_detail')}}?_ledger_id={{$data->id}}">{{ $data->_code ?? '' }}</a></td>
                            <td><a href="{{url('full_ledger_detail')}}?_ledger_id={{$data->id}}">{{ $data->_name }}</a></td>
                            <td><b>{{ $data->_alious ?? '' }}</b></td>
                            
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{!! $data->_address ?? '' !!}</td>
                            
                       
                           
                            <td>{{ _report_amount($data->_credit_limit)  }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @empty
                        @endforelse
                       
                        </tbody>
                    </table>
               

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
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