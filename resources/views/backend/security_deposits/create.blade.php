@extends('backend.layouts.app')
@section('title',$page_name)

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
              <a class="m-0 _page_name" href="{{ route('security_deposits.index') }}">{!! $page_name ?? '' !!} </a>
           
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>
               </li>
               @endcan
               @can('account-ledger-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="{{url('account-type-for-new-ledger')}}" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> 
                </button>
               </li>
               @endcan
               
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('security_deposits.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 
                   @include('backend.message.message')
                    
              </div>
           
              <div class="card-body">
               <form action="{{route('security_deposits.store')}}" method="POST" class="purchase_form" >
                @csrf
                <div class="row ">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name" value="security_deposits">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              
                        </div>

                        
                        
                        @include('basic.org_create')
                        

                       
<div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Invoice No:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number')}}" placeholder="Invoice No" readonly >
                              <input type="hidden" name="_search_form_value" class="_search_form_value" value="2">
                                
                            </div>
                        </div>
                         <div class="col-md-3">
                           <div class="form-group">
                              <label class="mr-2" for="_type">{{__('label._type')}}:<span class="_required">*</span></label>
                           
                              <select class="form-control" name="_type" required>
                                <option value=""><--Select--></option>
                                <option value="Receive">Receive</option>
                                <option value="Return">Return</option>
                              </select>
                                
                            </div>
                         </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id')}}" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id')}}" placeholder="Customer" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_bank_name">{{__('label._bank_name')}}:</label>
                              <input type="text" id="_bank_name" name="_bank_name" class="form-control _bank_name" value="{{old('_bank_name')}}" placeholder="{{__('label._bank_name')}}" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_bank_branch_name">{{__('label._bank_branch_name')}}:</label>
                              <input type="text" id="_bank_branch_name" name="_bank_branch_name" class="form-control _bank_branch_name" value="{{old('_bank_branch_name')}}" placeholder="{{__('label._bank_branch_name')}}" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_cheque_no">{{__('label._cheque_no')}}:</label>
                              <input type="text" id="_cheque_no" name="_cheque_no" class="form-control _cheque_no" value="{{old('_cheque_no')}}" placeholder="{{__('label._cheque_no')}}" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_cheque_date">{{__('label._cheque_date')}}:</label>
                              <input type="date" id="_cheque_date" name="_cheque_date" class="form-control _cheque_date" value="{{old('_cheque_date')}}" placeholder="{{__('label._cheque_date')}}" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_voucher_no">{{__('label._voucher_no')}}:</label>
                              <input type="text" id="_voucher_no" name="_voucher_no" class="form-control _voucher_no" value="{{old('_voucher_no')}}" placeholder="{{__('label._voucher_no')}}" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_amount">{{__('label._amount')}}:</label>
                              <input type="number" min="0" step="any" id="_amount" name="_amount" class="form-control _amount" value="{{old('_amount')}}" placeholder="{{__('label._amount')}}" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-group">
                              <label class="mr-2" for="_remarks">{{__('label._remarks')}}:</label>
                              <input type="text" id="_remarks" name="_remarks" class="form-control _remarks" value="{{old('_remarks')}}" placeholder="{{__('label._remarks')}}" >
                                
                            </div>
                        </div>
                        
                      </div>
                      <div class="row ">
                        
                      
                       
                          

                        

                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
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

  @if(empty($form_settings))
    $(document).find("#form_settings").click();
  @endif
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  var _item_row_count =1;
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }


var duplicate_barcode_status=0;
  

 
 

$(document).find(".datetimepicker-input").val(date__today())

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

</script>

@endsection