@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('account-ledger.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('account-ledger-create')
              <li class="breadcrumb-item active">
                  

                  <a  
               class="btn btn-sm btn-info active " 
               href="{{ route('account-ledger.create') }}">
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
            <div class="card">
              <div class="card-header border-0">
                 

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
                      @include('backend.account-ledger.search')
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
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>Action</th>
                         <th>Details</th>
                         <th>Code</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Balance</th>
                         <th>Note</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                     @forelse($datas as $main_key=>$main_val)
                     <tr>
                       <th colspan="8">{!! $main_val->id ?? '' !!}.{!! $main_val->_name ?? '' !!}</th>
                     </tr>
                     <!-- End of Main Account Head -->

                     

                     <!-- Start First GEN Account Head -->
                     @php
                     $first_account_heads = $main_val->_list_account_heads ?? [];
                     @endphp
                     @forelse($first_account_heads as $first_head_key=>$first_head_val)
                     <tr>
                      <td></td>
                       <th colspan="7">{!! $first_head_val->id ?? '' !!}.{!! $first_head_val->_name ?? '' !!}</th>
                     </tr>
                     <!--First GEN Account Group-->
                     
                     @php
                     
                     $_list_account_group = $first_head_val->_list_account_group ?? [];
                     @endphp
                     @if(sizeof($_list_account_group) > 0)
                        @forelse($_list_account_group as $ac_group_key=>$ac_group_val)
                       <tr>
                        <th></th>
                        <th colspan="7">&emsp;&emsp;&emsp;&emsp;{!! $ac_group_val->id ?? '' !!}.{!! $ac_group_val->_name ?? '' !!}</th>
                       </tr>
                       <!-- Start of Ledger Account  -->
                       @php
                       $_group_wise_ledgers = $ac_group_val->_group_wise_ledger ?? [];
                       @endphp

                      @forelse($_group_wise_ledgers as $led_key=>$data)
                       <tr>
                        
                          <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                             </td>
                         <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{!! $data->id ?? '' !!}.&emsp;{!! $data->_name ?? '' !!}</td>
                         <td>{{ $data->_code ?? '' }}</td>
                            
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td class="td_width_250">{{ $data->_note ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                       </tr>
                        @empty
                       @endforelse
                       <!-- End of Ledger Account  -->
                        @empty
                       @endforelse
                       <!-- End of Account Group  -->
                     @endif
                     

                     <!-- Start of Account Head 2nd GEN -->
                     @php
                     $_child_groups = $first_head_val->_child_group ?? [];
                     @endphp

                    @forelse($_child_groups as $ch_group_key=>$ch_group_val)
                     <tr>
                      <td></td>
                       <th colspan="7">&emsp;&emsp;{!! $ch_group_val->id ?? '' !!}.{!! $ch_group_val->_name ?? '' !!}</th>
                     </tr>

                       <!-- Start of Account Group  -->
                       @php
                       $_list_account_group = $ch_group_val->_list_account_group ?? [];
                       @endphp

                      @forelse($_list_account_group as $ac_group_key=>$ac_group_val)
                       <tr>
                        <th></th>
                        <th colspan="7">&emsp;&emsp;&emsp;&emsp;{!! $ac_group_val->id ?? '' !!}.{!! $ac_group_val->_name ?? '' !!}</th>
                       </tr>
                       <!-- Start of Ledger Account  -->
                       @php
                       $_group_wise_ledgers = $ac_group_val->_group_wise_ledger ?? [];
                       @endphp

                      @forelse($_group_wise_ledgers as $led_key=>$data)
                       <tr>
                        
                          <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                             </td>
                         <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{!! $data->id ?? '' !!}.&emsp;{!! $data->_name ?? '' !!}</td>
                         <td>{{ $data->_code ?? '' }}</td>
                            
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td class="td_width_250">{{ $data->_note ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                       </tr>
                        @empty
                       @endforelse
                       <!-- End of Ledger Account  -->
                        @empty
                       @endforelse
                       <!-- End of Account Group  -->
                       

                      @empty
                     @endforelse
                     <!-- End of Account Head 2nd GEN -->
                     @empty
                     @endforelse


                     <!-- End First GEN Account Head -->

                     @empty
                     @endforelse




                        
                          
                       
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
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