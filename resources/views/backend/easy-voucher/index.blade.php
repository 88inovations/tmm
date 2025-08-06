@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 _page_name"><a  href="{{ route('easy-voucher.index') }}"> {!! $page_name ?? '' !!} </a>  
           @can('easy-voucher-create')
            <a title="Add New" class="btn  btn-sm btn-info" href="{{ route('easy-voucher.create') }}"> <i class="nav-icon fas fa-plus"></i> {{ __('label.Add New') }} </a>
                        
                @endcan 
              </h1>
          </div><!-- /.col -->
           <div class=" col-sm-4 ">
            <ol class="breadcrumb float-sm-right">
                @can('account-ledger-create')
             <li class="breadcrumb-item active">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button>
               </li>
               @endcan
              <li class="breadcrumb-item active">
                 <a class="btn btn-sm btn-default" title="List" href="{{ route('easy-voucher.index') }}">Easy Voucher List</a>
               </li>
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
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
                       @include('backend.voucher.search')
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
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Code</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>Type</b></th>
                         <th class=" text-right"><b>Amount</b></th>
                         <th class=""><b>Refarance</b></th>
                         <th class=""><b>Note</b></th>
                         <th class=""><b>Branch</b></th>
                         <th class=""><b>User</b></th>
                         <th>Lock</th>
                      </tr>
                     </thead>
                     <tbody>
                      @php
                      $sum_of_amount=0;
                      @endphp
                        @foreach ($datas as $key => $data)
                        @php
                           $sum_of_amount += $data->_amount ?? 0;
                        @endphp
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item " href="{{ route('easy-voucher.show',$data->id) }}">
                                        View
                                      </a>
                                     @can('easy-voucher-edit')
                                        <a class="dropdown-item " href="{{ route('easy-voucher.edit',$data->id) }}">
                                         Edit
                                        </a>
                                    @endcan
                                    @php
                                      $_types =['CR','BR'];
                                    @endphp
                                     @can('money-receipt-print')
                                     @if(in_array($data->_voucher_type,$_types))
                                        <a class="dropdown-item " href="{{ url('money-receipt-print') }}/{{$data->id}}">
                                         Money Receipt
                                        </a>
                                      @endif
                                    @endcan

                                    @php
                                      $_p_types =['CP','BP'];
                                    @endphp
                                     @can('money-payment-receipt')
                                     @if(in_array($data->_voucher_type,$_p_types))
                                        <a class="dropdown-item " href="{{ url('money-payment-receipt') }}/{{$data->id}}">
                                         Payment Receipt
                                        </a>
                                      @endif
                                    @endcan

                                     @can('easy-voucher-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['easy-voucher.destroy', $data->id],'style'=>'display:inline']) !!}
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm ">
                                            <span class="_required">Delete</span>
                                        </button>
                                    {!! Form::close() !!}
                                @endcan
                                   
                                  </div>
                                </div>
                               
                               
                               
                                <a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} {{ $data->_time ?? '' }}</td>
                            <td>{{ $data->_voucher_type ?? '' }}</td>
                            <td class="text-right">{{ _report_amount( $data->_amount ?? 0) }} </td>
                            <td>{{ $data->_transection_ref ?? '' }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                           <td style="display: flex;">
                              @can('lock-permission')
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$data->id}}" value="{{$data->_lock}}" @if($data->_lock==1) checked @endif>
                              @endcan

                              @if($data->_lock==1)
                              <i class="fa fa-lock _green ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @else
                              <i class="fa fa-lock _required ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @endif

                            </td>
                            
                           
                        </tr>
                        <tr>
                          <td colspan="12" >
                           <div class="collapse" id="collapseExample__{{$key}}">
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Ledger</th>
                                  <th>Branch</th>
                                  <th>Cost Center</th>
                                  <th>Short Narr.</th>
                                  <th class="text-right" >Dr. Amount</th>
                                  <th class="text-right" >Cr. Amount</th>
                                </thead>
                                <tbody>
                                  @php
                                    $_dr_amount = 0;
                                    $_cr_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_voucher_ledger->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_branch->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_cost_center->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_short_narr ?? '' }}</td>
                  <td class="text-right">{{ _report_amount( $_master_val->_dr_amount ?? 0) }}</td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_cr_amount ?? 0) }} </td>
                                    @php 
                                    $_dr_amount += $_master_val->_dr_amount;   
                                    $_cr_amount += $_master_val->_cr_amount;  
                                    @endphp
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b>{{ _report_amount($_dr_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_cr_amount ?? 0 ) }} </b></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="5" class="text-center"><b>Total</b></td>
                          <td class="text-right"><b>{{ _report_amount($sum_of_amount) }} </b></td>
                          <td colspan="4"></td>
                          <td></td>
                        </tr>

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

@section('script')

<script type="text/javascript">
 $(function () {
   var default_date_formate = `{{default_date_formate()}}`
   var _datex = `{{$request->_datex ?? '' }}`
   var _datey = `{{$request->_datey ?? '' }}`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 

 

// if(_datex =='' && _datey =='' ){
//   $(".datetimepicker-input_datex").val(date__today());
//   $(".datetimepicker-input_datey").val(date__today());
//   console.log('Ok new Page')
// }else{
//   $(".datetimepicker-input_datex").val(after_request_date__today( `{{$request->_datex}}` ))
//   $(".datetimepicker-input_datey").val(after_request_date__today( `{{$request->_datey}}` ))
//   console.log('after search')
// }

function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }


  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});

  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="voucher_masters";
    if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })

</script>
@endsection