@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="container-fluid">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_depreciation-list')
            <li class="breadcrumb-item"><a href="{{route('asset_depreciation.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="GET" action="{{ route('asset_depreciation.create') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
@php

$_date  = $main_data->_date ?? date('Y-m-d');
$_dep_month  = $main_data->_dep_month ?? '';
$_dep_year  = $main_data->_dep_year ?? '';
$filter  ='filter';

@endphp


<div class="row">
          
            <div class="col-12 col-xl-3">
             
              <input type="hidden" name="filter" value="{{$filter}}">
              <h4 class="mb-1">{{__('label._date')}}<span class="_required">*</span></h4>
              <input required class="form-control mb-2 @error('_date') is-invalid @enderror" name="_date" type="date" placeholder="{{__('label._date')}}" value="{!! $_date !!}" style="width: 250px;" />
            </div>
            <div class="col-12 col-xl-3">
              <h4 class="mb-1">{{__('label._dep_month')}}</h4>
              <select class="form-control" name="_dep_month" required style="width: 250px;">
                @forelse(_month_names() as $month_id=> $month)
                <option value="{{$month_id}}" @if($_dep_month ==$month_id) selected @endif >{!! $month ?? '' !!}</option>
                @empty
                @endforelse
              </select>
            </div>
<div class="col-12 col-xl-3">
@php
$startYear = date("Y") - 7; // Get the current year and subtract 5 for the starting year
$currentYear = date("Y"); // Get the current year
@endphp


              <h4 class="mb-1">{{__('label._dep_year')}}</h4>
              <select class="form-control _dep_year" name="_dep_year" id="_dep_year" style="width: 250px;">
                @for ($year = $currentYear; $year >= $startYear; $year--)
                    <option value="{{$year}}" @if($year ==$_dep_year) selected @endif>{{$year}}</option>
                @endfor
            </select>
          </div>
          <div class="col-12 col-xl-3">
             <div class="row  justify-content-left" style="margin-top: 20px;">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >Filter</button></div>
                </div>
              </div>

            </div>
              </form>
</div>
<div class="container-fluid">


             @if(sizeof($datas ) > 0 )
          <div class="col-12 ">
           
            <form class="mb-9 asset_depreciation_form" method="POST" action="{{ route('asset_depreciation.store') }}" enctype='multipart/form-data'>
              @csrf
              <div class="row">
                <div class="table-responsive">
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>SL
<input class="form-control id" type="hidden" name="id" value="{{$main_data->id ?? ''}}" >
                      </th>
                      <th>{{__('label.asset_ledger_id')}}</th>
                      <th>{{__('label.asset_dep_ledger_id')}}</th>
                      <th>{{__('label.asset_dep_exp_ledger_id')}}</th>
                      <th>{{__('label.name')}}</th>
                      <th>{{__('label.asset_code')}}</th>
                      <th>{{__('label.purchase_date')}}</th>
                      <th>{{__('label.dep_date')}}</th>
                      <th>{{__('label.evaluated_price')}}</th>
                      <th class="display_none">{{__('label.dep_type')}}</th>
                      <th>{{__('label.dep_date_number')}}</th>
                      <th>{{__('label.dep_rate')}}</th>
                      <th>{{__('label.dep_value')}}</th>
                      <th>{{__('label.accumulated_dep_val')}}</th>
                      <th>{{__('label.book_value')}}</th>
                    </tr>
                  </thead>
                  <tbody>
@php

$total_evaluated_price  =0;
$total_dep_value  =0;
$total_accumulated_dep_val  =0;
$total_book_value  =0;

$_date = $main_data->_date ?? date('Y-m-d');
$_dep_month = $main_data->_dep_month;
@endphp
                 
@forelse($datas as $key=> $data)


@php

$total_evaluated_price  +=$data->evaluated_price ?? 0;



 $dep_date_number = 0;
$dep_date = change_date_format($data->dep_date);
if( $_date > $data->dep_date ){
   $dep_date_number = _date_diff($data->dep_date,$_date);
     if($dep_date_number > 30 ){
      $dep_date_number = 30;
    } 
}


$depreciation_amount = 0;
$line_accum_depreciation_amount = 0;
if($data->evaluated_price - $data->accumulated_dep_val > 0){
  $dep_amount = (((($data->evaluated_price*$data->dep_rate)/100)/360)*$dep_date_number);
  $depreciation_amount = ($dep_amount);
  $line_accum_depreciation_amount = ($data->accumulated_dep_val+ $depreciation_amount);
  $total_accumulated_dep_val += $line_accum_depreciation_amount;
}else{
  $total_accumulated_dep_val  +=$data->accumulated_dep_val ?? 0;
  $line_accum_depreciation_amount = $data->accumulated_dep_val ?? 0;
}

$total_dep_value  +=$depreciation_amount ?? 0;

$book_value = ($data->evaluated_price-$line_accum_depreciation_amount);

$total_book_value  +=$book_value;


@endphp


                    <tr class="@if($book_value==0) zero_book_value @endif">
                      <td>
                        <input class="form-control sl" type="number" name="sl[]" value="{{($key+1)}}" readonly>
                        <input class="form-control row_id" type="hidden" name="row_id[]" value="0" >
                        <input class="form-control main_date" type="hidden" name="main_date" value="{{$_date}}" >
                        <input class="form-control _dep_month" type="hidden" name="_dep_month" value="{{$_dep_month}}" >
                        <input class="form-control _dep_year" type="hidden" name="_dep_year" value="{{$_dep_year}}" >
                        <input class="form-control organization_id" type="hidden" name="organization_id[]" value="{{$data->organization_id ?? 1}}" >
                        <input class="form-control branch_id" type="hidden" name="branch_id[]" value="{{$data->branch_id ?? 1}}" >
                        <input class="form-control project_id" type="hidden" name="project_id[]" value="{{$data->project_id ?? 1}}" >
                        <input class="form-control _budget_id" type="hidden" name="_budget_id[]" value="{{$data->_budget_id ?? 1}}" >





                      </td>
                      <td>
                      <input class="form-control asset_ledger_id" type="hidden" name="asset_ledger_id[]" value="{{$data->asset_ledger_id ?? ''}}" required>
                      <input class="form-control asset_ledger_name" type="text" name="asset_ledger_name[]" value="{{$data->category_ledger->_name ?? ''}}"  title="{{$data->category_ledger->_name ?? ''}}" readonly>
                    </td>
                      <td>
                        <input class="form-control asset_dep_ledger_id" type="hidden" name="asset_dep_ledger_id[]" value="{{$data->asset_dep_ledger_id ?? ''}}" required>
                      <input class="form-control asset_dep_ledger_name" type="text" name="asset_dep_ledger_name[]" value="{{$data->dep_exp_category_ledger->_name ?? ''}}" title="{{$data->dep_exp_category_ledger->_name ?? ''}}" readonly>
                      
                    </td>
                      <td>
                        <input class="form-control asset_dep_exp_ledger_id" type="hidden" name="asset_dep_exp_ledger_id[]" value="{{$data->asset_dep_exp_ledger_id ?? ''}}" required>
                      <input class="form-control asset_dep_exp_ledger_name" type="text" name="asset_dep_exp_ledger_name[]" value="{{$data->acc_dep_category_ledger->_name ?? ''}}" title="{{$data->acc_dep_category_ledger->_name ?? ''}}" readonly>
                      
                    </td>
                      <td>
                      <input class="form-control _asset_id" type="hidden" name="_asset_id[]" value="{{$data->id ?? ''}}">
                      <input class="form-control _asset_name" type="text" name="_asset_name[]" value="{{$data->name ?? ''}}"  title="{{$data->name ?? ''}}" readonly>

                      
                    </td>
                      <td>
                        <input class="form-control asset_code" type="text" name="asset_code[]" value="{{$data->asset_code ?? ''}}" readonly>

                     </td>
                      <td>
                         <input class="form-control purchase_date" type="date" name="purchase_date[]" value="{{$data->purchase_date ?? ''}}" readonly>
                     </td>
                      <td>
                         <input class="form-control dep_date" type="date" name="dep_date[]" value="{{$data->dep_date ?? ''}}" readonly>
                     </td>
                      <td>
                         <input class="form-control evaluated_price" type="number" min="0" step="any" name="evaluated_price[]" value="{{$data->evaluated_price}}" readonly>
                     </td>
                      <td class="display_none">
                         <input class="form-control dep_type" type="number" min="0" step="any" name="dep_type[]" value="{{$data->dep_type ?? 0}}" readonly>
                     </td>
                      <td>
                         <input class="form-control dep_date_number" type="text"  name="dep_date_number[]" value="{{$dep_date_number ?? 0}}" readonly>
                     </td>

                      <td>
                         <input class="form-control dep_rate" type="number" min="0" step="any" name="dep_rate[]" value="{{_php_round($data->dep_rate ?? 0)}}">
                     </td>
                      <td>
                         <input class="form-control dep_value" type="number" min="0" step="any" name="dep_value[]" value="{{_php_round($depreciation_amount ?? 0)}}">
                     </td>
                      <td>
                         <input class="form-control accumulated_dep_val" type="number" min="0" step="any" name="accumulated_dep_val[]" value="{{_php_round($line_accum_depreciation_amount ?? 0)}}" readonly>
                         <input class="form-control old_accumulated_dep_val" type="hidden" min="0" step="any" name="old_accumulated_dep_val[]" value="{{_php_round($data->accumulated_dep_val ?? 0)}}" readonly>
                     </td>
                      <td>
                         <input class="form-control book_value" type="number" min="0" step="any" name="book_value[]" value="{{_php_round($book_value ?? 0)}}" readonly>
                     </td>
                      
                     
                    </tr>
@empty
@endforelse                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="8">Grand Total</th>
                      <th>
<input class="form-control total_evaluated_price" type="number" min="0" step="any" name="total_evaluated_price" value="{{$total_evaluated_price}}" readonly>
                      </th>
                      <th></th>
                      <th></th>
                      <th class="display_none"></th>
                      <th>
                        <input class="form-control total_dep_value" type="number" min="0" step="any" name="total_dep_value" value="{{$total_dep_value}}" readonly>
                     </th>
                      <th>
                        <input class="form-control total_accumulated_dep_val" type="number" min="0" step="any" name="total_accumulated_dep_val" value="{{$total_accumulated_dep_val}}" readonly>
                     </th>
                      <th>
                        <input class="form-control total_book_value" type="number" min="0" step="any" name="total_book_value" value="{{$total_book_value}}" readonly>
                     </th>
                    </tr>
                  </tfoot>
                </table>
                </div>
              </div>



              <div class="row  justify-content-left mb-5 mt-5" >
                  
                  <div class="col-auto">
                    <button class="btn btn-info px-5 px-sm-15 submit-button" type="submit" >submit</button></div>
                </div>

            </form>
                
        
          </div> <!-- ENd of Item LIST -->
          @endif
       </div>


 @endsection

@section('script')
  <script>
   
$(document).on('keyup','.dep_rate',function(){
  var evaluated_price                = parseFloat($(this).closest('tr').find('.evaluated_price').val());
  if(isNaN(evaluated_price)){ evaluated_price=0 }
  var dep_rate                = parseFloat($(this).closest('tr').find('.dep_rate').val());
  if(isNaN(dep_rate)){ dep_rate=0 }
  var dep_date_number         = parseFloat($(this).closest('tr').find('.dep_date_number').val());
  if(isNaN(dep_date_number)){ dep_date_number=0 }
  var dep_value  =parseFloat((((parseFloat(evaluated_price)*parseFloat(dep_rate))/100)/360)*parseFloat(dep_date_number)).toFixed(2);
  if(isNaN(dep_value)){ dep_value=0 }

  $(this).closest('tr').find('.dep_value').val(dep_value);
   var old_accumulated_dep_val = parseFloat($(this).closest('tr').find('.old_accumulated_dep_val').val());
  if(isNaN(old_accumulated_dep_val)){ old_accumulated_dep_val=0 }

     var accumulated_dep_val = parseFloat(parseFloat(old_accumulated_dep_val)+parseFloat(dep_value)).toFixed(2);
    if(isNaN(accumulated_dep_val)){ accumulated_dep_val=0 }
  
     $(this).closest('tr').find('.accumulated_dep_val').val(accumulated_dep_val);
    var total_book_value        =parseFloat(parseFloat(evaluated_price)-parseFloat(accumulated_dep_val)).toFixed(2);
    if(isNaN(total_book_value)){ total_book_value=0 }
   $(this).closest('tr').find('.total_book_value').val(total_book_value);
  
  total_calculation_dep();
});

$(document).on('keyup','.dep_value',function(){
  var evaluated_price                = parseFloat($(this).closest('tr').find('.evaluated_price').val());
  if(isNaN(evaluated_price)){ evaluated_price=0 }
  var dep_rate                = parseFloat($(this).closest('tr').find('.dep_rate').val());
  // if(isNaN(dep_rate)){ dep_rate=0 }
  // var dep_date_number         = parseFloat($(this).closest('tr').find('.dep_date_number').val());
  // if(isNaN(dep_date_number)){ dep_date_number=0 }
  // var dep_value  =parseFloat((((parseFloat(evaluated_price)*parseFloat(dep_rate))/100)/360)*parseFloat(dep_date_number)).toFixed(2);
  // if(isNaN(dep_value)){ dep_value=0 }

var dep_value =   $(this).closest('tr').find('.dep_value').val();
if(isNaN(dep_value)){ dep_value=0 }
   var old_accumulated_dep_val = parseFloat($(this).closest('tr').find('.old_accumulated_dep_val').val());
  if(isNaN(old_accumulated_dep_val)){ old_accumulated_dep_val=0 }

     var accumulated_dep_val = parseFloat(parseFloat(old_accumulated_dep_val)+parseFloat(dep_value)).toFixed(2);
    if(isNaN(accumulated_dep_val)){ accumulated_dep_val=0 }
  
     $(this).closest('tr').find('.accumulated_dep_val').val(accumulated_dep_val);
    var total_book_value        =parseFloat(parseFloat(evaluated_price)-parseFloat(accumulated_dep_val)).toFixed(2);
    if(isNaN(total_book_value)){ total_book_value=0 }
   $(this).closest('tr').find('.total_book_value').val(total_book_value);
  
  total_calculation_dep();
})

function total_calculation_dep(){
  var total_dep_value=0;
 
    $('.dep_value').each(function() {
    var dep_value = $(this).val();
     if(isNaN(dep_value)){ dep_value=0 }
    total_dep_value +=parseFloat(dep_value);
  })

  var total_accumulated_dep_val=0;

 $('.accumulated_dep_val').each(function() {
    var accumulated_dep_val = $(this).val();
    if(isNaN(accumulated_dep_val)){ accumulated_dep_val=0 }
    total_accumulated_dep_val +=parseFloat(accumulated_dep_val);
  })

  var total_book_value=0;
 
   $('.book_value').each(function() {
    var book_value = $(this).val();
    if(isNaN(book_value)){ book_value=0 }
    total_book_value +=parseFloat(book_value);
  })

  $(document).find('.total_dep_value').val(parseFloat(total_dep_value).toFixed(2));
  $(document).find('.total_accumulated_dep_val').val(parseFloat(total_accumulated_dep_val).toFixed(2));
  $(document).find('.total_book_value').val(parseFloat(total_book_value).toFixed(2));



}

$(document).on('click','.submit-button',function(){
   $('.submit-button').attr('disabled','true');
   $(document).find(".asset_depreciation_form").submit();
})
  
    
  </script>
@endsection