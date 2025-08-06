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
                         
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>SL</th>
                         <th class="">Action</th>
                         <th>Type</th>
                         <th>Group</th>
                         <th>Ledger ID</th>
                         <th>Code</th>
                         <th>Ledger Name</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Balance</th>
                         <th>Note</th>
                         <th>Possition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                      
                        
    @forelse($datas as $key=>$data)




                      @php
                      $second_heads=$data->_child_group ?? [];
                      @endphp
                        <tr>
                           <td  class="text-bold">{{($key+1)}}</td>
                            <td  class="text-bold">{{ $data->_code ?? '' }}</td>
                            <td  class="text-bold" colspan="10">{{ $data->_name ?? '' }}</td>
                           
                        </tr>

  @php
$first_step__list_account_group = $data->_list_account_group ?? [];
  @endphp

    @forelse($first_step__list_account_group as $first_step_key=>$first_step_val)
                          <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td class="text-bold">{{ $first_step_val->_code ?? '' }}</td>
                            <td class="text-bold" colspan="9">{{ $first_step_val->_name ?? '' }}</td>
                           
                        </tr>

                        <!-- 2nd head wise group wise Ledger Information start -->
                        @php
                        $_group_wise_ledgers = $first_step_val->_group_wise_ledger ?? [];
                        @endphp
                        @if(sizeof( $_group_wise_ledgers) > 0)
                        @forelse($_group_wise_ledgers as $led_1=>$led_1val)
                           <tr>
                            <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $led_1val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td >{{ $led_1val->_code ?? '' }}</td>
                            <td>{{ $led_1val->_name ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>

                        @empty
                        @endforelse

                        @endif

                        <!-- 2nd head wise group wise Ledger Information End -->


    @empty
    @endforelse <!-- ENd of  $first_step__list_account_group Loop-->

                        <!-- 2nd Head/ Type Start -->
                        @forelse($second_heads as $sen_key=>$seh_val)
                          <tr>
                           <td></td>
                           <td></td>
                            <td class="text-bold">{{ $seh_val->_code ?? '' }}</td>
                            <td class="text-bold" colspan="9">{{ $seh_val->_name ?? '' }}</td>
                           
                        </tr>

                        <!-- 3rd Head Under 2nd Head start -->
@php
$third_heads=$seh_val->_child_group ?? [];

@endphp
@if(sizeof($third_heads) > 0)
@forelse($third_heads as $thired_key=>$thrid_val)
  <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td  class="text-bold">{{ $thrid_val->_code ?? '' }}</td>
                            <td  class="text-bold" colspan="8">{{ $thrid_val->_name ?? '' }}</td>
                           
                        </tr>
@php
   $thrid_val_list_account_groups = $thrid_val->_list_account_group ?? []; 
@endphp

 @if(sizeof($thrid_val_list_account_groups) > 0)
      @forelse($thrid_val_list_account_groups as $th_group_key=>$th_group_val)
                           <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td  class="text-bold">{{ $th_group_val->_code ?? '' }}</td>
                            <td  class="text-bold" colspan="8">{{ $th_group_val->_name ?? '' }}</td>
                           
                        </tr>
                        <!-- 2nd head wise group wise Ledger Information start -->
                        @php
                        $_group_wise_ledgers = $th_group_val->_group_wise_ledger ?? [];
                        @endphp
                        @if(sizeof( $_group_wise_ledgers) > 0)
                        @forelse($_group_wise_ledgers as $led_1=>$led_1val)
                           <tr>
                            <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $led_1val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td >{{ $led_1val->_code ?? '' }}</td>
                            <td>{{ $led_1val->_name ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>

                        @empty
                        @endforelse

                        @endif

                        <!-- 2nd head wise group wise Ledger Information End -->


                        
      @empty
      @endforelse
@endif      

@empty
@endforelse

@endif

                        <!-- 3rd Head Under 2nd Head end -->

                        <!-- 2nd head Group start -->
                        @php
                        $_list_account_groups = $seh_val->_list_account_group ?? []; 

                        @endphp
                        @if(sizeof($_list_account_groups) > 0)
                        @forelse($_list_account_groups as $secg_key=>$secg_val)
                           <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td  class="text-bold">{{ $secg_val->_code ?? '' }}</td>
                            <td  class="text-bold" colspan="8">{{ $secg_val->_name ?? '' }}</td>
                           
                        </tr>

                        <!-- 2nd head wise group wise Ledger Information start -->
                        @php
                        $_group_wise_ledgers = $secg_val->_group_wise_ledger ?? [];
                        @endphp
                        @if(sizeof( $_group_wise_ledgers) > 0)
                        @forelse($_group_wise_ledgers as $led_1=>$led_1val)
                           <tr>
                            <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('account-ledger.show',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-ledger-edit')
                                  <a 
                                  href="{{ route('account-ledger.edit',$led_1val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                                @can('account-ledger-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['account-ledger.destroy', $led_1val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>
                           <td></td>
                           <td></td>
                           <td></td>
                            <td >{{ $led_1val->_code ?? '' }}</td>
                            <td>{{ $led_1val->_name ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                            <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>

                        @empty
                        @endforelse

                        @endif

                        <!-- 2nd head wise group wise Ledger Information End -->

                        @empty
                        @endforelse

                        @endif

                        <!-- 2nd head Group END -->

                        @empty
                        @endforelse
                        <!-- ENd of 2nd Heads -->

                        @empty
                        @endforelse
                       
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                
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