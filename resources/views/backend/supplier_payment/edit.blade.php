@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-8 ">
            <h1 class="m-0 _page_name"><a  href="{{ route('customer_payment.index') }}"> {!! $page_name ?? '' !!} </a>    
             
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
                 <a class="btn btn-sm btn-default" title="List" href="{{ route('customer_payment.index') }}">Voucher List</a>
               </li>
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
     @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
@php
  
@endphp
              <div class="card-body">
                <form class="voucher-form" method="POST"  action="{{ route('customer_payment.update', $data->id) }}" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
                    <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name" value="supplier_payments">
                        <input type="hidden" name="_form_type" class="_form_type" value="entry_form">
                        <input type="hidden" name="_master_id" class="form-control _master_id" value="{{ $data->id ?? '' }}" >
                        <input type="hidden" name="find_supplier_due_history" class="form-control find_supplier_due_history" value="{{ url('find_supplier_due_history') }}" >
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
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_number">{{__('label._transection_number')}}:</label>
                              <input  readonly type="text" id="_transection_number" name="_transection_number" class="form-control _transection_number" value="{{old('_code',$data->_order_number ?? '' )}}" placeholder="{{__('label._order_number')}}" >
                            </div>
                          </div>

                       <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Voucher Type: <span class="_required">*</span></label>
                               <select class="form-control _voucher_type" name="_voucher_type" required="true">
                                  <option value="">--Voucher Type--</option>
                                  @forelse($voucher_types as $voucher_type )
                                  <option value="{{$voucher_type->_code}}" @if(isset($data->_voucher_type)) @if($data->_voucher_type == $voucher_type->_code) selected @endif   @endif>
                                    {{ $voucher_type->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        @include("backend.widgets.budget_select")


                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                              <select class="form-control _sales_man" name="_sales_man_id">
                                <option value="{{$data->_sales_man_id}}">{!! $data->_voucher_emp_ref->_name ?? '' !!}</option>
                              </select>
                             
                            </div>
                        </div>



<div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{!! $data->_sup_cus->_name ?? '' !!}" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Customer" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>  
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_code">{{__('label._code')}}:</label>
                              <input  readonly type="text" id="_code" name="_code" class="form-control _code" value="{{old('_code',$data->_sup_cus->_code ?? '' )}}" placeholder="{{__('label._code')}}" >
                            </div>
                          </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone ?? '' )}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address ?? '')}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        
                         
                           
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_alious">{{__('label._alious')}}:</label>
                              <input  readonly type="text" id="_alious" name="_alious" class="form-control _alious" value="{{old('_alious',$data->_alious ?? '')}}" placeholder="{{__('label._alious')}}" >
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_credit_limit">{{__('label._credit_limit')}}:</label>
                                <input readonly  type="text" id="_credit_limit" name="_credit_limit" class="form-control _credit_limit" value="{{old('_credit_limit',$data->_sup_cus->_credit_limit ?? 0)}}" placeholder="{{__('label._credit_limit')}}" >
                                  
                              </div>
                          </div>
                          
                          <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_balance">{{__('label._balance')}}:</label>
                                <input readonly  type="text" id="_balance" name="_balance" class="form-control _balance" value="{{old('_balance',$data->_sup_cus->_balance ?? 0)}}" placeholder="{{__('label._balance')}}" >
                                  
                              </div>
                          </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_ref">Reference:</label>
                              <input type="text" id="_transection_ref" name="_transection_ref" class="form-control _transection_ref" value="{{old('_transection_ref',$data->_transection_ref ?? '' )}}" placeholder="Reference" >
                                
                            </div>
                        </div>
                        <div class="invoiceDetailHistory">
                           <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header"></div>
                              <div class="card-body">
                                <div >
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>{{__('label.sl')}}</th>
                                            <th>{{__('label._date')}}</th>
                                            <th>{{__('label._order_number')}}</th>
                                            <th>Sales Amount</th>
                                            <th>Pre.{{__('label._receive_amount')}}</th>
                                            <th>Pre.{{__('label._due_amount')}}</th>
                                            <th>{{__('label._collection_ledger')}}</th>
                                            <th>{{__('label.collect_amount')}}</th>
                                            <th>{{__('label.current_due')}}</th>
                                            <th>{{__('label._is_close')}}</th>
                                            <th>{{__('label.effect')}}</th>
                                          </thead>
                                          <tbody>
@php

$_grand_total             =0;
$_grand_receive_amount    =0;
$_grand_due_amount        =0;
$_grand_collection_amount =0;
$_grand_due_balance       =0;

@endphp

@forelse($_master_details as $key=>$detail)


@php

$_grand_total             +=$detail->_total ?? 0;
$_grand_receive_amount    +=$detail->_receive_amount ?? 0;
$_grand_due_amount        +=$detail->_due_amount ?? 0;
$_grand_collection_amount +=$detail->_collection_amount ?? 0;
$_grand_due_balance       +=$detail->_due_balance ?? 0;

@endphp

                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm  btn-danger due_invoice_row" onclick="return confirm('Are you sure!')"><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;"> {!! _view_date_formate($data->_date ?? '') !!}
                                                <input type="hidden" name="sales_id[]" value="{{$detail->_invoice_id ?? 0 }}">
                                                <input type="hidden" name="_order_number[]" value="{{$detail->_invoice_number ?? ''}}">
                                              </td>
                                              <td style="white-space: nowrap;"> {!! $detail->_invoice_number ?? '' !!}</td>
                                               <td>
                                                <input type="number" min="0" step="any" name="_total[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$detail->_total ?? 0)}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="{{__('label._receive_amount')}}" value="{{old('_receive_amount',$detail->_receive_amount ?? 0)}}" readonly>
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="{{__('label._due_amount')}}" value="{{old('_due_amount',$detail->_due_amount ?? 0)}}" readonly>
                                              </td>
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    @forelse($collection_ledgers as $c_ledger)
                                                     <option value="{{$c_ledger->id ?? 0}}" @if($detail->_collection_ledger_id==$c_ledger->id) selected @endif>{{$c_ledger->_code ?? ''}}-{{$c_ledger->_name ?? 0}}</option>
                                                     @empty
                                                     @endforelse
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" max="{{$detail->_due_amount ?? 0}}" step="any" name="_collection_amount[]" class="form-control  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$detail->_collection_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="{{__('label._due_balance')}}" value="{{old('_due_balance',$detail->_due_balance ?? 0)}}" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0" @if($detail->_is_close==0) selected @endif >Open</option>
                                                  <option value="1" @if($detail->_is_close==1) selected @endif >Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1" @if($detail->_is_effect==1) selected @endif>Yes</option>
                                                  <option value="0" @if($detail->_is_effect==0) selected @endif>No</option>
                                                </select>
                                               </td>
                                            </tr>
                                @empty
                                @endforelse
                                          </tbody>
                                          <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="4">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total ?? 0}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="{{$_grand_receive_amount}}" readonly="">
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="{{$_grand_due_amount}}" readonly="">
                                              </td>
                                               <td> 
                                                   </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="Collection Amount" value="{{$_grand_collection_amount}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_balance" class="form-control  _grand_due_balance" placeholder="label._due_balance" value="{{$_grand_due_balance}}" readonly="">
                                              </td>
                                             
                                             
                                              <td> </td>
                                               <td></td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                               
                            </div>
                          </div>
                        </div>
                        </div>
                         
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                            <div class="form-group">
                               
                                
                                <div class="row">
                                  <div class="col-md-1">
                                     <label class="mr-2" for="_note">Note:<span class="_required">*</span></label>
                                  </div>
                                  <div class="col-md-11">
                                   
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">
                                       <input type="hidden" class="number_of_row" name="number_of_row" value="1">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '')}}" placeholder="Note" required >
                                  </div>
                                </div>
                                 @include('backend.message.send_sms')
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
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

@include('backend.voucher.script')

<script type="text/javascript">
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
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




  function voucher_row_add(event) {
    var number_of_row = $(document).find(".number_of_row").val();
    var new_row_number = (number_of_row+1);
      event.preventDefault();
      $("#area__voucher_details").append(`<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      <td class="@if(sizeof($permited_organizations)==1) display_none @endif">
                      <select class="form-control width_150_px organization_details_id organization_details_id__${new_row_number}" name="organization_details_id[]"  required >
                        @forelse($permited_organizations as $org )
                            <option value="{{$org->id}}" >{{ $org->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                      <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                      <select class="form-control width_150_px _branch_id_detail _branch_id_detail__${new_row_number}" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" >{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                          <select class="form-control width_150_px _cost_center _cost_center__${new_row_number}" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                      </td>
                        <td class="@if(sizeof($permited_budgets)==1) display_none @endif">
                          <select class="form-control _budget_details_id _budget_details_id__${new_row_number}" name="_budget_details_id[]"  >
                            @forelse($permited_budgets as $b_val )
                                           <option value="{{$b_val->id}}" > {{ $b_val->_name ?? '' }}</option>
                             @empty
                             @endforelse
                         </select>
                      </td>
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                              <td>
                                <input type="number" name="_foreign_amount[]" class="form-control  _foreign_amount" placeholder="{{__('label._foreign_amount')}}" value="{{old('_foreign_amount',0)}}">
                              </td>
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`);

      $(document).find('.number_of_row').val(new_row_number);

var _master_organization_id = $(document).find("._master_organization_id").val();
var _master_branch_id = $(document).find('._master_branch_id').val();
var _master_cost_center_id = $(document).find("._master_cost_center_id").val();
var _master_budget_id = $(document).find('._master_budget_id').val();

$(document).find(".organization_details_id__"+new_row_number).val(_master_organization_id).change();
$(document).find("._branch_id_detail__"+new_row_number).val(_master_branch_id).change();
$(document).find("._cost_center__"+new_row_number).val(_master_cost_center_id).change();
$(document).find("._budget_details_id__"+new_row_number).val(_master_budget_id).change();

      
  }

  

  $(document).on('click','._voucher_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._ledger_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _voucher_total_calculation();
  })

  // function _voucher_total_calculation(){
  //   var _total_dr_amount = 0;
  //   var _total_cr_amount = 0;
  //     $(document).find("._cr_amount").each(function() {
  //         _total_cr_amount +=parseFloat($(this).val());
  //     });
  //     $(document).find("._dr_amount").each(function() {
  //         _total_dr_amount +=parseFloat($(this).val());
  //     });
  //     $("._total_dr_amount").val(Math.round(_total_dr_amount));
  //     $("._total_cr_amount").val(Math.round(_total_cr_amount));
  // }


  $(document).on('keyup','._dr_amount',function(){
    $(this).parent().parent('tr').find('._cr_amount').val(0);
    $(document).find("._total_dr_amount").removeClass('required_border');
    $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })



  $(document).on('keyup','._cr_amount',function(){
     $(this).parent().parent('tr').find('._dr_amount').val(0);
     $(document).find("._total_dr_amount").removeClass('required_border');
      $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })

  $(document).on('change','._voucher_type',function(){
    $(document).find('._voucher_type').removeClass('required_border');
  })

  $(document).on('keyup','._note',function(){
    $(document).find('._note').removeClass('required_border');
  })

  $(document).on('click','._save_and_print',function(){
    $(document).find('._save_and_print_value').val(1);
  })


 //  $(document).on('click','.submit-button',function(event){
 //    event.preventDefault();
 //    var _total_dr_amount = $(document).find("._total_dr_amount").val();
 //    var _total_cr_amount = $(document).find("._total_cr_amount").val();
 //    var _voucher_type = $(document).find('._voucher_type').val();

 //    var _master_organization_id  = $(document).find('._master_organization_id').val();
 //    var _master_branch_id        = $(document).find('._master_branch_id').val();
 //    var _master_cost_center_id    = $(document).find('._master_cost_center_id').val();

 //    if(_master_organization_id ==''){
 //      $(document).find('._master_organization_id').focus().addClass('required_border');
 //      alert("Please Select Organization");
 //      return false;
 //    }
 //    if(_master_branch_id ==''){
 //      $(document).find('._master_branch_id').focus().addClass('required_border');
 //      alert("Please Select Branch");
 //      return false;
 //    }
 //    if(_master_cost_center_id ==''){
 //       $(document).find('._master_cost_center_id').focus().addClass('required_border');
 //      alert("Please Select Cost Center");
 //      return false;
 //    }

 //    var _note = $(document).find('._note').val();
 //    var _search_ledger_id = $(document).find('._search_ledger_id').val();


 //    var empty_ledger = [];
 //    $(document).find("._ledger_id").each(function(){
 //        if($(this).val() ==""){
 //          alert(" Please Add Ledger  ");
 //          $(document).find('._search_ledger_id').focus().addClass('required_border');
 //          empty_ledger.push(1);
 //        }  
 //    })

 //    if(empty_ledger.length > 0){
 //      return false;
 //    }


 // if(_voucher_type ==""){
 //       $(document).find('._voucher_type').focus().addClass('required_border');
 //       alert('Please Select Voucher Type.');
 //      return false;
 //    }else if(_note ==""){
       
 //       $(document).find('._note').focus().addClass('required_border');
 //      return false;
 //    }else if(_search_ledger_id ==""){
       
 //      $(document).find('._search_ledger_id').focus().addClass('required_border');
 //      return false;
 //    }else{
 //       $('.submit-button').attr('disabled','true');
 //      $(document).find('.voucher-form').submit();
 //    }
 //  })




$(document).on('keyup','._collection_amount',function(){
  var line_this = $(this);
  var _total = parseFloat(line_this.closest('tr').find('._total').val());
  if(isNaN(_total)){_total=0}
  var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
  if(isNaN(_due_amount)){_due_amount=0}
  var _receive_amount = parseFloat(line_this.closest('tr').find('._receive_amount').val());
  if(isNaN(_receive_amount)){_receive_amount=0}

  var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}

  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);
  line_this.closest('tr').find('._due_balance').val(_due_balance);

  if(_due_balance ==0){
    line_this.closest('tr').find('._is_close').val(1).change();
  }else{
    line_this.closest('tr').find('._is_close').val(0).change();
  }

payment_total_calculatins();

})

function payment_total_calculatins(){
  var _grand_total          = 0;
  var _grand_receive_amount = 0;
  var _grand_due_amount       = 0;
  var _grand_collection_amount = 0;
  var _grand_due_balance = 0;
 $(document).find('._total').each(function(index){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;



  var line_total             = parseFloat($(document).find("._total").eq(index).val());
  if(isNaN(line_total)){line_total=0}
  var line_receive_amount    = parseFloat($(document).find("._receive_amount").eq(index).val());
  if(isNaN(line_receive_amount)){line_receive_amount=0}
  var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  if(isNaN(line_due_amount)){line_due_amount=0}
  var line_collection_amount = parseFloat($(document).find("._collection_amount").eq(index).val());
  if(isNaN(line_collection_amount)){line_collection_amount=0}
  var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_collection_amount)).toFixed(2);
  $(document).find("._due_balance").eq(index).val(_due_balance);




 })
 $(document).find('._receive_amount').each(function(){
     var _receive_amount =parseFloat($(this).val());
     if(isNaN(_receive_amount)){_receive_amount=0}
      _grand_receive_amount +=_receive_amount;
 })
 $(document).find('._due_amount').each(function(){
     var _due_amount =parseFloat($(this).val());
     if(isNaN(_due_amount)){_due_amount=0}
      _grand_due_amount +=_due_amount;
 })

 $(document).find('._collection_amount').each(function(){
     var _collection_amount =parseFloat($(this).val());
     if(isNaN(_collection_amount)){_collection_amount=0}
      _grand_collection_amount +=_collection_amount;
 })

 $(document).find('._due_balance').each(function(){
     var _due_balance =parseFloat($(this).val());
     if(isNaN(_due_balance)){_due_balance=0}
      _grand_due_balance +=_due_balance;
 })

 $(document).find("._grand_total").val(_grand_total);
 $(document).find("._grand_receive_amount").val(_grand_receive_amount);
 $(document).find("._grand_collection_amount").val(_grand_collection_amount);
 $(document).find("._grand_due_amount").val(_grand_due_amount);
 $(document).find("._grand_due_balance").val(_grand_due_balance);



}
 

 $(document).on('click',".due_invoice_row",function(){
      var line_this = $(this);
      line_this.closest('tr').remove();
      payment_total_calculatins();
 })

$(".datetimepicker-input").val(date__today())

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

