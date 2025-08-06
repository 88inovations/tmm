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
            <h1 class="m-0 _page_name"><a  href="{{ route('supplier_payment.index') }}"> {!! $page_name ?? '' !!} </a> 
      @can('supplier_payment_create') 
              <a href="{{ route('supplier_payment.create') }}" 
                class="btn btn-sm btn-info active " >
                <i class="nav-icon fas fa-plus"></i> Create New
              </a>
       @endcan
              </h1>

          </div><!-- /.col -->
          <div class=" col-sm-4 ">
            <ol class="breadcrumb float-sm-right">
                @can('account-ledger-create')
             <li class="breadcrumb-item active">
                 <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="{{url('account-type-for-new-ledger')}}" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button>
               </li>
               @endcan
              <li class="breadcrumb-item active">
                 <a class="btn btn-sm btn-default" title="List" href="{{ route('supplier_payment.index') }}">{{__('label.supplier_payment')}}</a>
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
                       @include('backend.supplier_payment.search')
                    </div>
                    <div class="col-md-8">
                      
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Code</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>{{__('label.supplier')}}</b></th>
                         <th class=""><b>Type</b></th>
                         <th class=" text-right"><b>Amount</b></th>
                         <th class=""><b>Refarance</b></th>
                         <th class=""><b>Note</b></th>
                         
                         <th class=""><b>Employee</b></th>
                         <th class=""><b>{{__('label.organization')}}</b></th>
                         <th class=""><b>Branch</b></th>
                         <th class=""><b>User</b></th>
                         <th>Lock</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Table</th>
                         <th>Ref Table</th>
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
                                     <a class="dropdown-item " href="{{ route('supplier_payment.show',$data->id) }}">
                                        View
                                      </a>
                                     <a target="__blank" class="dropdown-item " href="{{ url('supplier_payment/print',$data->id) }}">
                                        Print
                                      </a>
                                     @can('supplier_payment_edit')
                                        <a class="dropdown-item " href="{{ route('supplier_payment.edit',$data->id) }}">
                                         Edit
                                        </a>
                                    @endcan
                                   

                                     @can('supplier_payment_delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['supplier_payment.destroy', $data->id],'style'=>'display:inline']) !!}
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
                            <td>
                              <a target="__blank" title="Voucher Print"  href="{{ url('supplier_payment/print',$data->id) }}">
                                        {{ $data->_order_number ?? '' }}
                                      </a></td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} {{ $data->_time ?? '' }}</td>
                            <td>{{ $data->_sup_cus->_name ?? '' }}</td>
                            <td>{{ $data->_voucher_type ?? '' }}</td>
                            <td class="text-right">{{ _report_amount( $data->_amount ?? 0) }} </td>
                            <td>{{ $data->_transection_ref ?? '' }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_voucher_emp_ref->_name ?? '' }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
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
                            <td>{{ $data->created_at ?? ''  }}</td>
                            <td>{{ $data->updated_at ?? ''  }}</td>
                            <td>{{ $data->_form_name ?? ''  }}</td>
                            <td>{{ $data->_ref_table ?? ''  }}</td>
                            
                           
                        </tr>
                        <tr>
                          <td colspan="18" >
                           <div class="collapse" id="collapseExample__{{$key}}">
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>{{__('label._voucher_code')}}</th>
                                  <th>{{__('label._invoice_number')}}</th>
                                  <th>{{__('label._collection_ledger_id')}}</th>
                                  <th>Sales Amount</th>
                                  <th>Total Collection</th>
                                  <th>Pre. Due</th>
                                  <th>{{__('label._collection_amount')}}</th>
                                  <th>Current Due</th>
                                  <th>{{__('label._is_close')}}</th>
                                  <th>{{__('label._is_effect')}}</th>
                                  
                                </thead>
                                <tbody>
                                  @php
                                    $_master_details = $data->_master_details ?? [];
                                    $_total = 0;
                                    $_receive_amount = 0;
                                    $_due_amount = 0;
                                    $_collection_amount = 0;
                                    $_due_balance = 0;
                                  @endphp
                                  @forelse($_master_details AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_voucher_code ?? '' }}</td>
                                    <td>{{ $_master_val->_invoice_number ?? '' }}</td>
                                    <td>{{ $_master_val->_receive_ledger->_name ?? '' }}</td>
                  <td class="text-right">{{ _report_amount( $_master_val->_total ?? 0) }}</td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_receive_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_due_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_collection_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_due_balance ?? 0) }} </td>
                                    <td>{{ $_master_val->_is_close ?? '' }}</td>
                                    <td>{{ $_master_val->_is_effect ?? '' }}</td>
                                    @php 
                                    $_total += $_master_val->_total;   
                                    $_receive_amount += $_master_val->_receive_amount;  
                                    $_due_amount += $_master_val->_due_amount;  
                                    $_collection_amount += $_master_val->_collection_amount;  
                                    $_due_balance += $_master_val->_due_balance;  



                                    @endphp
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="4" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b>{{ _report_amount($_total ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_receive_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_due_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_collection_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_due_balance ?? 0 ) }} </b></td>
                                    <td  class="text-right"></td>
                                    <td  class="text-right"></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        @endforeach
                        
                        <tr>
                          <td colspan="15" class="text-center">
                            {!! $datas->render() !!}
                          </td>
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
    var _table_name ="supplier_payments";
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