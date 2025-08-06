@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
<style type="text/css">
    .width_150_px{
        width: 150px !important;
    }
    .width_250_px{
        width: 250px !important;
    }
</style>
@endsection
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('stm_collection.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_students_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('stm_collection.create') }}">
                   <i class="nav-icon fas fa-plus"></i> {{__('label.create_new')}}
                </a>

               </li>
              @endcan

              
                 <div class="col-md-3">

            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


<div class="container">
<div class="container">
  
    
          <div class="message-area">
    @include('backend.message.message')
    </div>
            
           
</div>


<div class="DueBillDisplayArea">
    @php
$_student_table_id  = $student_info->id;
$_user_table_id  = $student_info->_user_table_id;
$_admission_session_id = $student_info->_admission_session_id ?? 0;
$_stm_division_id = $student_info->_education_type ?? 0;
$_admission_class_id = $data->_class_id ?? 0;
 $_bill_type          = $data->_bill_type;


 $_detail  = $data->_detail ?? [];

 $asc_cloumn =  $request->asc_cloumn ?? '';
$_asc_desc =  $request->_asc_desc ?? '';
 $row_numbers = filter_page_numbers();

@endphp


<div  class="p-2 purple_bg">
@if(sizeof($_detail) > 0)
    <form action="{{ route('stm_collection.store') }}" method="POST">
        @csrf
        <div class="card p-2 purple_bg" >
        <div class="row">
        <div class="form-group col-md-3">
            <label for="_date">Date</label>
            <div class="width_250_px">
            <input type="date" name="_date" class="form-control " value="{{$data->_date}}" required>
            
            <input type="hidden" name="_student_table_id" value="{{$_student_table_id ?? 0}}">
            <input type="hidden" name="_user_table_id" value="{{$_user_table_id ?? 0}}">
           
            <input type="hidden" name="_admission_class_id" value="{{$_admission_class_id ?? 0}}">
            <input type="hidden" name="_form_name" value="stm_collection_masters">
            <input type="hidden" name="stm_collection_id" value="{!! $data->id ?? '' !!}">
                
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_order_number">{{__('label._order_number')}}</label>
            <input type="text" name="_order_number" class="form-control _order_number" value="{!! $data->_order_number ?? '' !!}" readonly>
            
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id">{{__('label._admission_session_id')}}</label>
            <select class="form-control _admission_session_id" name="_admission_session_id">
                <option value="{{$_admission_session_id}}">
                {!! _id_to_name($_admission_session_id,'_name','stm_education_sessions') !!}</option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id">{{__('label._stm_division_id')}}</label>
            <select class="form-control _stm_division_id" name="_stm_division_id">
                <option value="{{$_stm_division_id}}">
                {!! _id_to_name($_stm_division_id,'_name','stm_divisions') !!}</option>
            </select>
            
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_admission_class_id">{{__('label._admission_class_id')}}</label>
            <select class="form-control _admission_class_id" name="_admission_class_id">
                <option value="{{$_admission_class_id}}">
                {!! _id_to_name($_admission_class_id,'_name','stm_classes') !!}</option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_student_id">{{__('label._student_id')}}</label>
            <input type="text" name="_student_id" class="form-control _student_id" value="{!! $student_info->_student_id ?? '' !!}" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_name_in_english">{{__('label._name_in_english')}}</label>
            <input type="text" name="_name_in_english" class="form-control _name_in_english" value="{!! $student_info->_name_in_english ?? '' !!}" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_father_name_english">{{__('label._father_name_english')}}</label>
            <input type="text" name="_father_name_english" class="form-control _father_name_english" value="{!! $student_info->_father_name_english ?? '' !!}" readonly>
            
        </div>

        <div class="form-group @if(sizeof($permited_organizations) == 1) display_none @endif col-md-3">
            <label for="organization_id">{{__('label.organization_id')}}</label>
            <div class="">
                <select name="organization_id" class="form-control " required>
                @forelse($permited_organizations as $org)
                    <option value="{{ $org->id }}">{{ $org->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
            </div>
            
        </div>

        <div class="form-group @if(sizeof($permited_branch) == 1) display_none @endif col-md-3">
            <label for="_branch_id">{{__('label._branch_id')}}</label>
            <select name="_branch_id" class="form-control " required>
                @forelse($permited_branch as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="form-group  @if(sizeof($permited_costcenters) == 1) display_none @endif col-md-3">
            <label for="_cost_center_id">{{__('label._cost_center_id')}}</label>
            <select name="_cost_center_id" class="form-control ">
                @forelse($permited_costcenters as $center)
                    <option value="{{ $center->id }}">{{ $center->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>

@php
$bill_types =_fees_types();
$_bill_type  = $data->_bill_type ?? '_admission_fee';
$_make_ledger_coloumn_name = $_bill_type.'_ledger';
@endphp
       <div class="form-group col-md-3">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="{{$_bill_type}}">{{$bill_types[$_bill_type] ?? ''}}</option>
            </select>
        </div>

       
        <div class="form-group col-md-3">
            <label for="_roshid_book_no">{{__('label._roshid_book_no')}}</label>
            <input type="text" name="_roshid_book_no" class="form-control _roshid_book_no " value="{{old('_roshid_book_no',$data->_roshid_book_no ?? '')}}">
        </div>
        <div class="form-group col-md-3">
            <label for="_roshid_no">{{__('label._roshid_no')}}</label>
            <input type="text" name="_roshid_no" class="form-control _roshid_no " value="{{old('_roshid_no',$data->_roshid_no ?? '')}}">
        </div>
</div>
</div>
      <div class="col-md-12">
          <div class="card">
              <table class="table table-bordered">
                   <thead>
                        <tr>
                        <th>&nbsp;</th>
                        <th>{{__('label.sl')}}</th>
                        <th>Month </th>
                        <th>Year </th>
                        <th>Fee </th>
                        <th>Pre. Receive </th>
                        <th>Pre. Due Amount </th>
                        <th>{{__('label._collection_ledger')}}</th>
                        <th>{{__('label.collect_amount')}}</th>
                        <th>{{__('label._discount_amount')}}</th>
                        <th>{{__('label.current_due')}}</th>
                        <th>{{__('label._is_close')}}</th>
                        <th>{{__('label.effect')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php

$datas  = $data->_detail ?? [];
$_grand_total   = 0;
$_grand_receive_amount   = 0;
$_grand_due_amount   = 0;
$_grand_collection_amount   = 0;
$_grand_discount_amount   = 0;
$_grand_due_balance   = 0;
@endphp
                          @forelse($datas as $key=> $d_data)
@php
$_grand_total                   +=$d_data->_fee_amount ??  0;
$_grand_due_balance             +=$d_data->_due_amount ??  0;
$_grand_receive_amount          +=$d_data->_receive_amount ??  0;
$_grand_due_amount              +=$d_data->_due_amount ??  0;
$_grand_discount_amount         +=$d_data->_discount_amount ??  0;
$_grand_collection_amount         +=$d_data->_collection_amount ??  0;


$_is_close    = $d_data->_is_close ?? 0;
$_is_effect    = $d_data->_is_effect ?? 0;



@endphp
                          <tr class="_voucher_row">
                                              <td>
                                                

                                                <input type="hidden" name="_session_id[]" value="{{$d_data->_session_id ?? 0}}">
                                                <input type="hidden" name="_month_id[]" value="{{$d_data->_month_id ?? 0}}">
                                                <input type="hidden" name="_year[]" value="{{$d_data->_year ?? 0}}">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="{{$d_data->_bill_detail_id ?? 0}}">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="{{$d_data->id ?? 0}}">
                                                
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;">{!! _number_to_month($d_data->_month_id ?? '' ) !!}  </td>
                                              <td style="white-space: nowrap;">{!! $d_data->_year ?? '' !!}  </td>
                                               <td>
                                                <input type="number" min="0" step="any" name="_fee_amount[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$d_data->_fee_amount ?? 0)}}" readonly>
                                              </td>

                                              <td>
                                                <input type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="Receive Amount" value="{{$d_data->_receive_amount ?? 0}}" readonly="">
                                              </td>

                                              <td>
                                                <input type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="Due Amount" value="{{$d_data->_due_amount ?? 0}}" readonly="">
                                              </td>
                                               
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    @forelse($collection_ledgers as $c_ledger)
                                                     <option value="{{$c_ledger->id ?? 0}}">{{$c_ledger->_code ?? ''}}-{{$c_ledger->_name ?? 0}}</option>
                                                     @empty
                                                     @endforelse
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" max="{{$d_data->_fee_amount ?? 0}}" step="any" name="_collection_amount[]" class="form-control _collection_discount_amount  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$d_data->_collection_amount ?? 0)}}" >
                                              </td>

                                               <td>
                                                <input type="number"  type="number" min="0"  step="any" name="_discount_amount[]" class="form-control _collection_discount_amount  _discount_amount" placeholder="{{__('label._discount_amount')}}" value="{{old('_discount_amount',$d_data->_discount_amount ?? 0)}}" >
                                              </td>

                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="{{__('label._due_balance')}}" value="{{old('_due_balance',$d_data->_due_balance ?? 0)}}" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0" @if($_is_close==0) selected @endif >Open</option>
                                                  <option value="1" @if($_is_close==1) selected @endif >Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1" @if($_is_effect==1) selected @endif>Yes</option>
                                                  <option value="0" @if($_is_effect==0) selected @endif>No</option>
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
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="{{$_grand_receive_amount ?? 0}}" readonly="">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="{{$_grand_due_amount ?? 0}}" readonly="">
                                              </td>
                                              <td></td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{$_grand_collection_amount}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_discount_amount" class="form-control  _grand_discount_amount" placeholder="{{__('label._discount_amount')}}" value="{{$_grand_discount_amount}}" readonly>
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
      

        <div class="form-group">
            <label for="_note">Note <span class="_required">*</span></label>
            <textarea name="_note" rows="3" class="form-control" required>{!! old('_note',$data->_note ?? '') !!}</textarea>
        </div>

       
        <div class="text-center p-4">
        <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </form>
@else

<h3 class="text-center">No Data Found</h3>
@endif

</div>
</div>


</div>


@endsection

@section('script')
<script type="text/javascript">


    // Recalculate due balance when amount/discount is changed
    $('body').on('input', '._collection_amount', function() {
        const $row = $(this).closest('tr');
        
        const total = parseFloat($row.find('._fee_amount').val()) || 0;
        const received = parseFloat($row.find('._receive_amount').val()) || 0;
        const _due_amount = parseFloat($row.find('._due_amount').val()) || 0;
        const collection = parseFloat($row.find('._collection_amount').val()) || 0;
        const discount = parseFloat($row.find('._discount_amount').val()) || 0;

        let dueBalance = _due_amount - collection - discount;

        dueBalance = dueBalance < 0 ? 0 : dueBalance;

        $row.find('._due_balance').val(dueBalance.toFixed(2));

        if(dueBalance ==0 ){
            if(isNaN(collection)){collection=0}
            if(collection !=0){
                $row.find('._collection_amount').val(parseFloat(_due_amount)-parseFloat(discount));
            }

        }

        if(dueBalance ==0){
            $row.find('._is_close').val(1).change();
        }else{
            $row.find('._is_close').val(0).change();
        }

        payment_total_calculatins();
            
    });

    // Recalculate due balance when amount/discount is changed
    $('body').on('input', '._discount_amount', function() {
        const $row = $(this).closest('tr');
        
        const total = parseFloat($row.find('._fee_amount').val()) || 0;
        const received = parseFloat($row.find('._receive_amount').val()) || 0;
        const _due_amount = parseFloat($row.find('._due_amount').val()) || 0;
        const collection = parseFloat($row.find('._collection_amount').val()) || 0;
        const discount = parseFloat($row.find('._discount_amount').val()) || 0;

        let dueBalance = _due_amount - collection - discount;

        dueBalance = dueBalance < 0 ? 0 : dueBalance;

        $row.find('._due_balance').val(dueBalance.toFixed(2));

        if(dueBalance ==0 ){
            if(isNaN(discount)){discount=0}
            if(discount !=0){
                $row.find('._discount_amount').val(parseFloat(_due_amount)-parseFloat(collection));
            }

        }


        if(dueBalance ==0){
            $row.find('._is_close').val(1).change();
        }else{
            $row.find('._is_close').val(0).change();
        }

        payment_total_calculatins();
    });


 




// $(document).on('change','._is_close',function(){
//   var _is_close  = $(this).closest('tr').find('._is_close').val();
//   var _due_balance  = $(this).closest('tr').find('._due_balance').val();
//    if(isNaN(_due_balance)){_due_balance=0}
//   if(_due_balance !=0){
//    // alert('Due Amount Must be Zero to Close this Invoice');
//     $(this).closest('tr').find('._is_close').val(0).change();
//   }


// });

function payment_total_calculatins(){
  var _grand_total          = 0;
  var _grand_receive_amount = 0;
  var _grand_due_amount       = 0;
  var _grand_collection_amount = 0;
  var _grand_discount_amount = 0;
  var _grand_due_balance = 0;
 $(document).find('._total').each(function(index){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;



  // var line_total             = parseFloat($(document).find("._total").eq(index).val());
  // if(isNaN(line_total)){line_total=0}
  // var line_receive_amount    = parseFloat($(document).find("._receive_amount").eq(index).val());
  // if(isNaN(line_receive_amount)){line_receive_amount=0}
  // var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  // if(isNaN(line_due_amount)){line_due_amount=0}
  // var line_collection_amount = parseFloat($(document).find("._collection_amount").eq(index).val());
  // if(isNaN(line_collection_amount)){line_collection_amount=0}


  // var line_discount_amount = parseFloat($(document).find("._discount_amount").eq(index).val());
  // if(isNaN(line_discount_amount)){line_discount_amount=0}

  // var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_collection_amount)-parseFloat(line_discount_amount)).toFixed(2);
  // $(document).find("._due_balance").eq(index).val(_due_balance);




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

 $(document).find('._discount_amount').each(function(){
     var _discount_amount =parseFloat($(this).val());
     if(isNaN(_discount_amount)){_discount_amount=0}
      _grand_discount_amount +=_discount_amount;
 })

 $(document).find('._due_balance').each(function(){
     var _due_balance =parseFloat($(this).val());
     if(isNaN(_due_balance)){_due_balance=0}
      _grand_due_balance +=_due_balance;
 })

 $(document).find("._grand_total").val(_grand_total);
 $(document).find("._grand_receive_amount").val(_grand_receive_amount);
 $(document).find("._grand_collection_amount").val(_grand_collection_amount);
 $(document).find("._grand_discount_amount").val(_grand_discount_amount);
 $(document).find("._grand_due_amount").val(_grand_due_amount);
 



}


 $(document).on('change','.stduent_seach',function(){
  
   var _admission_session_id = $(document).find('._search_admission_session_id').val();
    var _education_type = $(document).find('._search_education_type').val();
    var _admission_class_id = $(document).find('._search_admission_class_id').val();

    var  page_url = $(this).attr('attr_url');
    var display_area = "._search_stduent_list";
    var data ={ _admission_session_id,_education_type,_admission_class_id }
    console.log(page_url)
    if(_admission_session_id !='' && _education_type !='' && _admission_class_id !=''){
         fetch_list_data_without_paginate(page_url,display_area,data);

    }

  })



$(document).on('click','.due_bill_search_button',function(){

    var _admission_session_id = $(document).find('._search_admission_session_id').val();
    var _education_type = $(document).find('._search_education_type').val();
    var _admission_class_id = $(document).find('._search_admission_class_id').val();
    var _student_id = $(document).find('._student_id').val();
    var _bill_type = $(document).find('._bill_type').val();

    var  page_url = $(this).attr('attr_url');
    var display_area = ".DueBillDisplayArea";
    var data ={ _admission_session_id,_education_type,_admission_class_id,_student_id,_bill_type }
    console.log(page_url)
    if(_admission_session_id !='' && _education_type !='' && _admission_class_id !='' && _student_id !=''){
         fetch_list_data_without_paginate(page_url,display_area,data);

    }

})


 
</script>

@endsection

