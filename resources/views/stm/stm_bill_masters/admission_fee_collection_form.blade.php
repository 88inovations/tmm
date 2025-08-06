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
            <a class="m-0 _page_name" href="{{ route('admission_fee_collection_list') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_students_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('admission_fee_collection') }}">
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


<div class="container report_box">
<div class="container">
     @php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
$_month  =  $request->_month  ?? 1;
$_year  =  $request->_year  ?? date('Y');
@endphp
    
          <div class="message-area">
    @include('backend.message.message')
    </div>
            
           <form class="mb-2" action="{{route('admission_fee_collection')}}" method="GET">
            @csrf
                
                      <div class="report_box">
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _admission_session_id _search_admission_session_id" name="_admission_session_id" required attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select Session</option>
                                      @forelse($stm_education_sessions as $session)
                                        <option value="{{$session->id }}"
                                         @if($_admission_session_id ==$session->id) selected @endif > {!! $session->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                                <input type="hidden" name="search" value="search">
                            </div>
                        
                   
                             <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._education_type')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _education_type _search_education_type" name="_education_type" required attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select {{__('label._education_type')}}</option>
                                      @forelse($edu_types as $type)
                                        <option value="{{$type->id }}"
                                         @if($_education_type ==$type->id) selected @endif > {!! $type->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_class_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control stduent_seach _admission_class_id _search_admission_class_id" name="_admission_class_id" required attr_url="{{route('session_class_div_wise_student')}}">
                                      <option value="">Select Class</option>
                                      @forelse($edu_class as $class)
                                        <option value="{{$class->id }}"
                                         @if($_admission_class_id ==$class->id) selected @endif > {!! $class->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._student_id')}}:<span class="_required">*</span></label>
                                    <div class="_search_stduent_list">
                                        
                                         <select class="_student_id form-control  select2" name="_student_id" required>
                                                <option value="">Select Student</option>
                                            </select>
                                    </div>
                                   
                                </div>
                            </div>
                           
                             
                            
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="submit" class="btn btn-primary " ><i class="fa fa-search "></i> Search</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>





@if(sizeof($datas) > 0)
    <form action="{{ route('admission_fee_collection_store') }}" method="POST">
        @csrf
        <div class="card p-2 report_box">
        <div class="row">
        <div class="form-group col-md-2">
            <label for="_date">Date</label>
           
            <input type="date" name="_date" class="form-control " value="{{date('Y-m-d')}}" required>
            <input type="hidden" name="_stm_division_id" value="{{ $request->_education_type ?? 0}}">
            <input type="hidden" name="_class_id" value="{{$request->_admission_class_id ?? 0}}">
            <input type="hidden" name="_master__session_id" value="{{$request->_admission_session_id ?? 0}}">
            <input type="hidden" name="_student_table_id" value="{{$student_ids ?? 0}}">
                
           
        </div>
        <div class="form-group col-md-2">
            <label>{{__('label._stm_division_id')}}</label>
            <input type="text" name="_stm_division_id_name" class="form-control " readonly value="{!! _id_to_name($request->_education_type,'_name','stm_divisions') !!}">
        </div>
        <div class="form-group col-md-2">
            <label>{{__('label._admission_class_id')}}</label>
            <input type="text" name="_admission_class_id_name" class="form-control " readonly value="{!! _id_to_name($request->_admission_class_id,'_name','stm_classes') !!}">
        </div>


        <div class="form-group @if(sizeof($permited_organizations) == 1) display_none @endif col-md-6">
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

        <div class="form-group @if(sizeof($permited_branch) == 1) display_none @endif col-md-6">
            <label for="_branch_id">{{__('label._branch_id')}}</label>
            <select name="_branch_id" class="form-control " required>
                @forelse($permited_branch as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="form-group  @if(sizeof($permited_costcenters) == 1) display_none @endif col-md-6">
            <label for="_cost_center_id">{{__('label._cost_center_id')}}</label>
            <select name="_cost_center_id" class="form-control ">
                @forelse($permited_costcenters as $center)
                    <option value="{{ $center->id }}">{{ $center->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="col-md-2">
         <label class="mr-2" for="_month">{{ __('label._month') }}<span class="_required">*</span></label>
        <select class="form-control _month" name="_month" required>
            <option value="">{{__('label.select')}}</option>
            @forelse(_month_names() as $month_key=>$month)
            <option value="{{$month_key}}" @if($month_key==$_month) selected @endif >{{$month ?? '' }}</option>
            @empty
            @endforelse
        </select>
    </div>
      @php
          $currentYear = date('Y');
          $_year = $request->_year ?? $currentYear;
          $year_start = ($currentYear - 10);
      @endphp

      <div class="col-xs-12 col-sm-12 col-md-2">
          <label class="mr-2" for="_year">{{ __('label._year') }}<span class="_required">*</span></label>
          <select name="_year" class="form-control" required>
              @for ($i = $year_start; $i <= $currentYear; $i++)
                  <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
              @endfor
          </select>
      </div>


        <div class="form-group col-md-3">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="_admission_fee">Admission Fee</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="_dr_ledger_id">BILL RECEIVE LEDGER</label>
            <select name="_dr_ledger_id" class="form-control ">
                <option value="{{$income_ledgers->_admission_fee_ledger ?? 0}}">{{_ledger_name($income_ledgers->_admission_fee_ledger ?? 0)}}</option>
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
      <div class="col-md-12 ">
          <div class="card">
              <table class="table table-bordered">
                   <thead>
                        <tr>
                        <th>&nbsp;</th>
                        <th>{{__('label.sl')}}</th>
                        <th>Division</th>
                        <th>Class </th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Admission Fee</th>
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
$_grand_total   = 0;
$_grand_receive_amount   = 0;
$_grand_due_amount   = 0;
$_grand_collection_amount   = 0;
$_grand_discount_amount   = 0;
$_grand_due_balance   = 0;
@endphp
                          @forelse($datas as $key=> $data)
@php
$_grand_total            +=$data->_admission_fee ??  0;
$_grand_due_balance            +=$data->_admission_fee ??  0;
$_grand_discount_amount            +=$data->_discount_amount ??  0;
@endphp
                          <tr class="_voucher_row">
                                              <td>
                                                

                                                <input type="hidden" name="_student_id[]" value="{{$data->_student_id}}">
                                                <input type="hidden" name="_session_id[]" value="{{$data->_session ?? 0}}">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="0">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="0">
                                                
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;">{!! $data->_division->_name ?? '' !!}  </td>
                                              <td style="white-space: nowrap;">{!! $data->_class_info->_name ?? '' !!}  </td>
                                              
                                              <td style="white-space: nowrap;">{!! $data->_student->_name_in_english ?? '' !!}  </td>
                                              <td style="white-space: nowrap;">{!! $data->_roll_no ?? '' !!}  </td>
                                            
                                              
                                              
                                             
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_admission_fee[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$data->_admission_fee ?? 0)}}" readonly>

                                                <input type="hidden"  type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="{{__('label._due_amount')}}" value="{{old('_due_amount',$data->_admission_fee ?? 0)}}" readonly>
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
                                                <input type="number"  type="number" min="0" max="{{$data->_admission_fee ?? 0}}" step="any" name="_collection_amount[]" class="form-control _collection_discount_amount  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$data->_collection_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0"  step="any" name="_discount_amount[]" class="form-control _collection_discount_amount  _discount_amount" placeholder="{{__('label._discount_amount')}}" value="{{old('_discount_amount',$data->_discount_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="{{__('label._due_balance')}}" value="{{old('_due_balance',$data->_admission_fee ?? 0)}}" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0">Open</option>
                                                  <option value="1">Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                                </select>
                                               </td>
                                            </tr>

                          @empty
                          @endforelse
                      </tbody>
                      <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="6">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
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
            <textarea name="_note" rows="3" class="form-control" required>{!! old('_note') !!}</textarea>
        </div>

       
        <div class="text-center p-4">
        <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </form>
@endif
</div>


@endsection

@section('script')
<script type="text/javascript">
    

$(document).on('keyup','._collection_discount_amount',function(){
  var line_this = $(this);
  var _total = parseFloat(line_this.closest('tr').find('._total').val());
  if(isNaN(_total)){_total=0}
  var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
  if(isNaN(_due_amount)){_due_amount=0}
  var _receive_amount = 0;

  var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}

  var _discount_amount = parseFloat(line_this.closest('tr').find('._discount_amount').val());
  if(isNaN(_discount_amount)){_discount_amount=0}

  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)-parseFloat(_discount_amount)).toFixed(2);

if(_due_balance < 0 ){
  _due_balance = 0;
  line_this.closest('tr').find('._collection_amount').val(_due_amount);
   var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}
line_this.closest('tr').find('._discount_amount').val(0);
  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);

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

 

payment_total_calculatins();

})

$(document).on('keyup','._discount_amount',function(){
    
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



  var line_total             = parseFloat($(document).find("._total").eq(index).val());
  if(isNaN(line_total)){line_total=0}
  var line_receive_amount    = parseFloat($(document).find("._receive_amount").eq(index).val());
  if(isNaN(line_receive_amount)){line_receive_amount=0}
  var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  if(isNaN(line_due_amount)){line_due_amount=0}
  var line_collection_amount = parseFloat($(document).find("._collection_amount").eq(index).val());
  if(isNaN(line_collection_amount)){line_collection_amount=0}


  var line_discount_amount = parseFloat($(document).find("._discount_amount").eq(index).val());
  if(isNaN(line_discount_amount)){line_discount_amount=0}

  var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_collection_amount)-parseFloat(line_discount_amount)).toFixed(2);
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
 $(document).find("._grand_due_balance").val(_grand_due_balance);



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
 
</script>

@endsection

