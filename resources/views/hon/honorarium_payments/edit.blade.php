@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{route('honorarium_payments.index')}}">{!! $page_name ?? '' !!} </a>
           
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php

$organization_id = $data->organization_id ?? '';
$_branch_id = $data->_branch_id ?? '';
$_cost_center_id = $data->_cost_center_id ?? '';
$_honorarium_ledger_id = $data->_honorarium_ledger_id ?? '';



$_month = $data->_month ?? '';
$_year = $data->_year ?? '';
$_note = $data->_note ?? '';
$_date = $data->_date;


@endphp


    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
            
              
                   
    @if(sizeof($datas) > 0)
              <div class="card-body">
                <div class="">
                  {!! Form::open(array('route' => 'honorarium_payments.store','method'=>'POST')) !!}
                  <div class="row p-2">
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                       <div class="form-group ">
                           <label>{{__('label._date')}}:</label>
                            <input type="date" class="form-control _date" name="_date" value="{{ $_date ?? ''}}" >
                            <input type="hidden" class="form-control _month" name="_month" value="{{ $_month ?? ''}}" >
                            <input type="hidden" class="form-control _year" name="_year" value="{{ $_year ?? ''}}" >
                            <input type="hidden" class="form-control honorarium_payments_id" name="honorarium_payments_id" value="{{ $data->id ?? ''}}" >
                       </div>
                      </div>
                       <div class="col-xs-12 col-sm-12 col-md-2  @if(sizeof($permited_organizations) == 1) display_none @endif ">
               <div class="form-group ">
                   <label>{!! __('label.organization') !!}:</label>
                  <select class="form-control _master_organization_id" name="organization_id" required >
              @if(sizeof($permited_organizations) > 1)
              <option value=""><---Select---></option>
              @endif
                     
                     @forelse($permited_organizations as $val )
                     <option value="{{$val->id}}"  @if($organization_id == $val->id) selected @endif >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._branch_id')}}:</label>
                  <select class="form-control _master_branch_id" name="_branch_id"  >
                    
              <option value=""><---Select {{__('label._branch_id')}}---></option>

                     @forelse($permited_branch as $branch )
                     <option value="{{$branch->id}}"  @if($_branch_id == $branch->id) selected @endif >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
               <div class="form-group ">
                   <label>{{__('label._cost_center_id')}}:</label>
                  <select class="form-control _master_cost_center_id" name="_cost_center_id"  >
                    
              <option value=""><---Select {{__('label._cost_center_id')}}---></option>

                     @forelse($permited_costcenters as $cost_center )
                     <option value="{{$cost_center->id}}"  @if($_cost_center_id == $cost_center->id) selected @endif >{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 ">
                       <div class="form-group ">
                           <label>{{__('label._code')}}:<span class="_required">*</span></label>
                            

                            <input type="text" class="form-control _honorarium_ledger_code" name="_honorarium_ledger_code" value="{{ $ledger_info->_code ?? ''}}" readonly>

                       </div>
                      </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 ">
                       <div class="form-group ">
                           <label>{{__('label._ledger_id')}}:<span class="_required">*</span></label>
                            <input type="hidden" class="form-control _honorarium_ledger_id" name="_honorarium_ledger_id" value="{{ $_honorarium_ledger_id ?? ''}}" required>

                            <input type="text" class="form-control _honorarium_ledger_name" name="_honorarium_ledger_name" value="{{ _ledger_name($_honorarium_ledger_id ?? '')}}" readonly>

                       </div>
                      </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                       <div class="form-group ">
                           <label>{{__('label._sales_man_id')}}:</label>
                           <select class="form-control _sales_man_id" name="_sales_man_id">
                            @forelse($emplyee_ledgers as $emplyee)
                             <option value="{{$emplyee->id}}">{!! $emplyee->_name ?? '' !!}</option>
                            @empty
                            @endforelse
                           </select>
                            
                       </div>
                      </div>

                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_bank_name">{{__('label._bank_name')}}:</label>
                        <input type="text" id="_bank_name" name="_bank_name" class="form-control _bank_name" value="{{old('_bank_name',$check_info->_bank_name ?? '')}}" placeholder="{{__('label._bank_name')}}" >
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_branch_name">{{__('label._branch_name')}}:</label>
                        <input type="text" id="_branch_name" name="_branch_name" class="form-control _branch_name" value="{{old('_branch_name',$check_info->_branch_name ?? '')}}" placeholder="{{__('label._branch_name')}}" >
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_bank_account">{{__('label._bank_account')}}:</label>
                        <input type="text" id="_bank_account" name="_bank_account" class="form-control _bank_account" value="{{old('_bank_account',$check_info->_bank_account ?? '')}}" placeholder="{{__('label._bank_account')}}" >
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_check_no">{{__('Bank CHEQUE Number')}}:</label>
                        <input type="text" id="_check_no" name="_check_no" class="form-control _check_no" value="{{old('_check_no',$check_info->_check_no ?? '')}}" placeholder="{{__('Bank Check Number')}}" >
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_issue_date">{{__('CHEQUE Issue Date')}}:</label>
                        <input type="date" id="_issue_date" name="_issue_date" class="form-control _issue_date" value="{{old('_issue_date',$check_info->_issue_date ?? '')}}"  >
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                      <div class="form-group">
                        <label class="mr-2" for="_cash_date">{{__('CHEQUE Cash Date')}}:</label>
                        <input type="date" id="_cash_date" name="_cash_date" class="form-control _cash_date" value="{{old('_cash_date',$check_info->_cash_date ?? '')}}"  >
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-6 ">
                       <div class="form-group ">
                           <label>{{__('label._note')}}:<span class="_required">*</span></label>
                          

                            
                            <input type="text" class="form-control _note" name="_note" value="{{ $_note ?? ''}}" required>
                       </div>
                      </div>


                  </div>

                 <div class="table-responsive">
                  <table class="table table-bordered ">
                      <thead>
                        <tr>
                         
                         <th style="width: 5%;"><b>{{__('label.sl')}}</b></th>
                          @if(sizeof($permited_organizations) > 1)
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label.organization')}}</b></th>
                         @endif
                          @if(sizeof($permited_branch) > 1)
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._branch_id')}}</b></th>
                         @endif
                          @if(sizeof($permited_costcenters) > 1)
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._cost_center_id')}}</b></th>
                         @endif
                         <th style="width: 5%;"><b>{{__('label.id')}}</b></th>
                         <th style="width: 7%;white-space: nowrap;"><b>{{__('label._month')}}</b></th>
                         <th style="width: 20%;white-space: nowrap;"><b>{{__('label._year')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._bill_amount')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._previous_paid_amount')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._due_amount')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._due_amount')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._paid_amount')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._current_due')}}</b></th>
                         <th style="width: 10%;white-space: nowrap;"><b>{{__('label._short_narr')}}</b></th>
                         <th style="width: 5%;white-space: nowrap;"><b>{{__('label._is_close')}}</b></th>
                         <th style="width: 5%;white-space: nowrap;"><b>{{__('label._is_effect')}}</b></th>


                      </tr>
                      </thead>
                      <tbody>

                      
                      @forelse($datas as  $d_key=>$h_data)

                      @php

                      @endphp
                      <tr class="">
                        <td>{!! ($d_key+1) !!}</td>
                         @if(sizeof($permited_organizations) > 1)
                        <td class="white_space">{!! $h_data->_organization->_name ?? '' !!}</td>
                        @endif
                         @if(sizeof($permited_branch) > 1)
                        <td class="white_space">{!! $h_data->_branch->_name ?? '' !!}</td>
                        @endif
                         @if(sizeof($permited_costcenters) > 1)
                        <td class="white_space">{!! $h_data->_cost_center->_name ?? '' !!}</td>
                        @endif
                        <td class="white_space">{!! $h_data->id ?? '' !!}</td>
                        <td class="white_space">{!! _number_to_month($h_data->_month ?? '') !!}</td>
                        <td class="white_space">{!! $h_data->_year ?? '' !!}</td>
                        <td>
                        <input type="hidden" name="_month[]" value="{{$h_data->_month ?? 0}}">
                        <input type="hidden" name="_year[]" value="{{$h_data->_year ?? 0}}">
                        <input type="hidden" name="_bill_detail_id[]" value="{{$h_data->_honorarium_bill->id ?? 0}}">
                        <input type="hidden" name="_payment_detail_id[]" value="{{$$h_data->id ?? 0}}">

                          <input type="number" min="0" step="any" name="_bill_amount[]" class="form-control _bill_amount" value="{{$h_data->_honorarium_bill->_amount ?? 0}}" readonly>
                        </td>
                        <td>
                          <input type="number" min="0" step="any" name="_paid_amount[]" class="form-control _paid_amount" value="{{$h_data->_previous_receive ?? 0}}" readonly>
                        </td>
                        @php
$_ledger_id   = $h_data->_ledger_id ?? 0;
                        @endphp
                        <td> 
                            <select class="form-control _collection_ledger_id width_250_px" name="_collection_ledger_id[]" >
                            @forelse($collection_ledgers as $c_ledger)
                             <option value="{{$c_ledger->id ?? 0}}" @if($_ledger_id==$c_ledger->id) selected @endif>{{$c_ledger->_code ?? ''}}-{{$c_ledger->_name ?? 0}}</option>
                             @empty
                             @endforelse
                            </select>
                       </td>

                        <td>
                          <input type="number" min="0" step="any" name="_due_amount[]" class="form-control _due_amount" value="{{ ($h_data->_due_amount ?? 0)+($h_data->_amount ?? 0) }}" readonly>
                        </td>
                        <td>
                          <input type="number" min="0" step="any" name="_pay_amount[]" class="form-control _pay_amount" value="{{$h_data->_amount ?? 0}}" >
                        </td>

                        <td>
                          <input readonly type="number" min="0" step="any" name="_due_balance[]" class="form-control _due_balance" value="{{$h_data->_due_amount ?? 0}}" >
                        </td>
                        
                        <td>
                          <input type="text" name="_short_narr[]" class="form-control _short_narr width_280_px" value="{{$h_data->_short_narr ?? ''}}">
                        </td>
                       @php
$_is_close   = $h_data->_is_close ?? 0;
$_is_effect   = $h_data->_is_effect ?? 0;
                       @endphp
                          <td>
                            <select class="form-control _is_close" name="_is_close[]">
                              <option value="0" @if($_is_close==0) selected @endif>Open</option>
                              <option value="1" @if($_is_close==1) selected @endif>Close</option>
                            </select>
                           </td>
                         <td>
                            <select class="form-control _is_effect" name="_is_effect[]">
                              <option value="1"  @if($_is_effect==1) selected @endif>Yes</option>
                              <option value="0" @if($_is_effect==0) selected @endif>No</option>
                            </select>
                           </td>
                      </tr>

                      @empty
                      @endforelse

                      <tr>
                        <td></td>
                         @if(sizeof($permited_organizations) > 1)
                        <td class="white_space"></td>
                        @endif
                         @if(sizeof($permited_branch) > 1)
                        <td class="white_space"></td>
                        @endif
                         @if(sizeof($permited_costcenters) > 1)
                        <td class="white_space"></td>
                        @endif

                        <td colspan="7">Total</td>
                        <td>
                          <input type="number" min="0" step="any" name="_grand_pay_amount" class="form-control _grand_pay_amount" readonly>
                        </td>
                        <td colspan="4"></td>
                      </tr>

                       

                        
                        
                       
                        </tbody>
                        <tbody>

                        </tbody>

                    </table>

                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-12  m-4">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                          </div>

                   {!! Form::close() !!}
                </div>
                <!-- /.d-flex -->
                
              </div>

@endif


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
  




$(document).on('keyup','._pay_amount',function(){
  var line_this = $(this);
  var _bill_amount = parseFloat(line_this.closest('tr').find('._bill_amount').val());
  if(isNaN(_bill_amount)){_bill_amount=0}
  var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
  if(isNaN(_due_amount)){_due_amount=0}
  var _paid_amount = parseFloat(line_this.closest('tr').find('._paid_amount').val());
  if(isNaN(_paid_amount)){_paid_amount=0}

  var _pay_amount = parseFloat(line_this.closest('tr').find('._pay_amount').val());
  if(isNaN(_pay_amount)){_pay_amount=0}

  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_pay_amount)).toFixed(2);

if(_due_balance < 0 ){
  _due_balance = 0;
  line_this.closest('tr').find('._pay_amount').val(_due_amount);
   var _pay_amount = parseFloat(line_this.closest('tr').find('._pay_amount').val());
  if(isNaN(_pay_amount)){_pay_amount=0}
  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_pay_amount)).toFixed(2);

}
line_this.closest('tr').find('._due_balance').val(_due_balance);



 // Check if the _is_close value is already the same to prevent triggering the change event again
    var $isCloseField = line_this.closest('tr').find('._is_close');
    var currentCloseValue = $isCloseField.val();
    
    if (_due_balance == 0) {
        // Set value to 1 only if it's not already 1
        if (currentCloseValue != 1) {
            $isCloseField.val(1).change();
        }
    } else {
        // Set value to 0 only if it's not already 0
        if (currentCloseValue != 0) {
            $isCloseField.val(0).change();
        }
    }

 

payment_bill_amount_calculatins();

})


$(document).on('change','._is_close',function(){
  var _is_close  = $(this).closest('tr').find('._is_close').val();
  var _due_balance  = $(this).closest('tr').find('._due_balance').val();
   if(isNaN(_due_balance)){_due_balance=0}
  if(_due_balance !=0){
   // alert('Due Amount Must be Zero to Close this Invoice');
    $(this).closest('tr').find('._is_close').val(0).change();
  }


});

function payment_bill_amount_calculatins(){
  var _grand_bill_amount          = 0;
  var _grand_paid_amount = 0;
  var _grand_due_amount       = 0;
  var _grand_pay_amount = 0;
  var _grand_due_balance = 0;
 $(document).find('._bill_amount').each(function(index){
     var _bill_amount =parseFloat($(this).val());
     if(isNaN(_bill_amount)){_bill_amount=0}
      _grand_bill_amount +=_bill_amount;



  var line_bill_amount             = parseFloat($(document).find("._bill_amount").eq(index).val());
  if(isNaN(line_bill_amount)){line_bill_amount=0}
  var line_paid_amount    = parseFloat($(document).find("._paid_amount").eq(index).val());
  if(isNaN(line_paid_amount)){line_paid_amount=0}
  var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  if(isNaN(line_due_amount)){line_due_amount=0}
  var line_pay_amount = parseFloat($(document).find("._pay_amount").eq(index).val());
  if(isNaN(line_pay_amount)){line_pay_amount=0}
  var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_pay_amount)).toFixed(2);
  $(document).find("._due_balance").eq(index).val(_due_balance);




 })
 $(document).find('._paid_amount').each(function(){
     var _paid_amount =parseFloat($(this).val());
     if(isNaN(_paid_amount)){_paid_amount=0}
      _grand_paid_amount +=_paid_amount;
 })
 $(document).find('._due_amount').each(function(){
     var _due_amount =parseFloat($(this).val());
     if(isNaN(_due_amount)){_due_amount=0}
      _grand_due_amount +=_due_amount;
 })

 $(document).find('._pay_amount').each(function(){
     var _pay_amount =parseFloat($(this).val());
     if(isNaN(_pay_amount)){_pay_amount=0}
      _grand_pay_amount +=_pay_amount;
 })

 $(document).find('._due_balance').each(function(){
     var _due_balance =parseFloat($(this).val());
     if(isNaN(_due_balance)){_due_balance=0}
      _grand_due_balance +=_due_balance;
 })

 $(document).find("._grand_bill_amount").val(_grand_bill_amount);
 $(document).find("._grand_paid_amount").val(_grand_paid_amount);
 $(document).find("._grand_pay_amount").val(_grand_pay_amount);
 $(document).find("._grand_due_amount").val(_grand_due_amount);
 $(document).find("._grand_due_balance").val(_grand_due_balance);



}
 


</script>


@endsection