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
     @php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_resedential_type =  $request->_resedential_type ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_roll_no =  $request->_roll_no ?? '';
$_student_name =  $request->_student_name ?? '';
$_student_id =  $request->_student_id ?? '';
@endphp
    
          <div class="message-area">
    @include('backend.message.message')
    </div>
            
           <form class="mb-2" action="{{route('stm_collection.create')}}" method="GET">
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
                                        
                                         <select class="_student_id form-control  select2" name="_student_id">
                                                <option value="">Select Student</option>
                                            </select>
                                    </div>
                                   
                                </div>
                            </div>
                            @php                     
                        $bill_types =_fees_types();
                        @endphp
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_bill_type">{{ __('label._bill_type') }}<span class="_required">*</span></label>
                          <select name="_bill_type" class="form-control _bill_type" required>
                              @forelse($bill_types as $bill_key=>$lebel)
                                  <option value="{{ $bill_key }}" >{{ $lebel }}</option>
                              @empty
                              @endforelse
                          </select>
                        </div>
                             
                            
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="button" class="btn btn-primary due_bill_search_button" attr_url="{{route('student_due_bill_search')}}"><i class="fa fa-search "></i> Search</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>


<div class="DueBillDisplayArea"></div>


</div>


@endsection

@section('script')
<script type="text/javascript">
    

// $(document).on('keyup','._collection_discount_amount',function(){

//   var line_this = $(this);
//   var _total = parseFloat(line_this.closest('tr').find('._total').val());
//   if(isNaN(_total)){_total=0}
//   var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
//   if(isNaN(_due_amount)){_due_amount=0}

//     console.log('_due_amount '+_due_amount);
//   var _receive_amount = 0;
//   var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
//   if(isNaN(_collection_amount)){_collection_amount=0}

//     console.log('_collection_amount '+_collection_amount);

//   var _discount_amount = parseFloat(line_this.closest('tr').find('._discount_amount').val());
//   if(isNaN(_discount_amount)){_discount_amount=0}

//      console.log('_discount_amount '+_discount_amount);

//   var _due_balance = parseFloat(parseFloat(_due_amount)-(parseFloat(_collection_amount)-parseFloat(_discount_amount))).toFixed(2);

// if(_due_balance < 0 ){
//   _due_balance = 0;
//   line_this.closest('tr').find('._collection_amount').val(_due_amount);
//    var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
//   if(isNaN(_collection_amount)){_collection_amount=0}
// line_this.closest('tr').find('._discount_amount').val(0);
//   var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);

// }
// line_this.closest('tr').find('._due_balance').val(_due_balance);



//  // Check if the _is_close value is already the same to prevent triggering the change event again
//     var $isCloseField = line_this.closest('tr').find('._is_close');
//     var currentCloseValue = $isCloseField.val();
    
//     if (_due_balance == 0) {
//         // Set value to 1 only if it's not already 1
//         if (currentCloseValue != 1) {
//             $isCloseField.val(1).change();
//         }
//     } else {
//         // Set value to 0 only if it's not already 0
//         if (currentCloseValue != 0) {
//             $isCloseField.val(0).change();
//         }
//     }

 

// payment_total_calculatins();

// })


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

