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
            <h1 class="m-0 _page_name"><a  href="{{ route('supplier_payment.index') }}"> {!! $page_name ?? '' !!} </a>    
             
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
                 <a class="btn btn-sm btn-default" title="List" href="{{ route('supplier_payment.index') }}">{{$page_name}}</a>
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
                {!! Form::open(array('route' => 'supplier_payment.store','method'=>'POST','class'=>'voucher-form')) !!}
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

                       <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Voucher Type: <span class="_required">*</span></label>
                               <select class="form-control _voucher_type" name="_voucher_type" required="true">
                                  <option value="">--Voucher Type--</option>
                                  @forelse($voucher_types as $voucher_type )
                                  <option value="{{$voucher_type->_code}}" @if(isset($request->_voucher_type)) @if($request->_voucher_type == $voucher_type->_code) selected @endif   @endif>
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
                                <option value=""><----{{__('label._sales_man_id')}}----></option>
                              </select>
                             
                            </div>
                        </div>

<!-- <div class="col-xs-12 col-sm-12 col-md-3 ">
    <div class="form-group">
      <label class="mr-2" for="_sales_man">Emp Ref:</label>
      <input type="text" id="_search_main_sales_man" name="_search_main_sales_man" class="form-control _search_main_sales_man" value="{!! $_voucher_emp_ref->_name ?? '' !!}" placeholder="Emp Ref" >

    <input type="hidden" id="_sales_man_id" name="_sales_man_id" class="form-control _sales_man" value="{{$data->_sales_man_id ?? ''}}" placeholder="Sales Man" >
    <div class="search_box_sales_man"> </div>
    </div>
</div> -->


<div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Supplier:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="" placeholder="Supplier" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id')}}" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>  
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_code">{{__('label._code')}}:</label>
                              <input  readonly type="text" id="_code" name="_code" class="form-control _code" value="{{old('_code','')}}" placeholder="{{__('label._code')}}" >
                            </div>
                          </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone','N/A')}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address','N/A')}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        
                         
                           
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_alious">{{__('label._alious')}}:</label>
                              <input  readonly type="text" id="_alious" name="_alious" class="form-control _alious" value="{{old('_alious','')}}" placeholder="{{__('label._alious')}}" >
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_credit_limit">{{__('label._credit_limit')}}:</label>
                                <input readonly  type="text" id="_credit_limit" name="_credit_limit" class="form-control _credit_limit" value="{{old('_credit_limit',0)}}" placeholder="{{__('label._credit_limit')}}" >
                                  
                              </div>
                          </div>
                          
                          <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_balance">{{__('label._balance')}}:</label>
                                <input readonly  type="text" id="_balance" name="_balance" class="form-control _balance" value="{{old('_balance',0)}}" placeholder="{{__('label._balance')}}" >
                                  
                              </div>
                          </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_ref">Reference:</label>
                              <input type="text" id="_transection_ref" name="_transection_ref" class="form-control _transection_ref" value="{{old('_transection_ref')}}" placeholder="Reference" >
                                
                            </div>
                        </div>
                        <div class="invoiceDetailHistory"></div>
                         
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                            <div class="form-group">
                               
                                
                                <div class="row">
                                  <div class="col-md-1">
                                     <label class="mr-2" for="_note">Note:<span class="_required">*</span></label>
                                  </div>
                                  <div class="col-md-11">
                                    @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('voucher/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">
                                       <input type="hidden" class="number_of_row" name="number_of_row" value="1">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
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

