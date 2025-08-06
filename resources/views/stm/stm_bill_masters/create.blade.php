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
            <a class="m-0 _page_name" href="{{ route('stm_bill_masters.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('stm_students_create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('stm_bill_masters.create') }}">
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
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_bill_type =  $request->_bill_type ?? '';
$_month =  $request->_month ?? '';
$_year =  $request->_year ?? '';







@endphp
    
          <div class="message-area">
    @include('backend.message.message')
    </div>
            
           <form class="mb-2" action="{{route('stm_bill_masters.create')}}" method="GET">
            @csrf
                
                      <div class="report_box">
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:<span class="_required">*</span></label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id" required>
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
                                    <select class="form-control _education_type" name="_education_type" required>
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
                                    <select class="form-control _admission_class_id" name="_admission_class_id" required>
                                      <option value="">Select Class</option>
                                      @forelse($edu_class as $class)
                                        <option value="{{$class->id }}"
                                         @if($_admission_class_id ==$class->id) selected @endif > {!! $class->_name ?? '' !!} </option>
                                      @empty
                                      @endforelse
                                      
                                    </select>
                                </div>
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
@php                     
$bill_types =_fees_types();
@endphp
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <label class="mr-2" for="_bill_type">{{ __('label._bill_type') }}<span class="_required">*</span></label>
                                  <select name="_bill_type" class="form-control" required>
                                      @forelse($bill_types as $bill_key=>$lebel)
                                          <option value="{{ $bill_key }}" @if ($bill_key == $_bill_type) selected @endif>{{ $lebel }}</option>
                                      @empty
                                      @endforelse
                                  </select>
                              </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 mt-3 ">
                                   <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search "></i> Search</button>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>





@if(sizeof($datas) > 0)
    <form action="{{ route('stm_bill_masters.store') }}" method="POST">
        @csrf
        <div class="card p-2">
        <div class="row">
        <div class="form-group col-md-6">
            <label for="_date">Date</label>
            <div class="width_250_px">
            <input type="date" name="_date" class="form-control " value="{{date('Y-m-d')}}" required>
            <input type="hidden" name="_master__session_id" value="{{$_admission_session_id ?? 0}}">
            <input type="hidden" name="_stm_division_id" value="{{$_education_type ?? 0}}">
            <input type="hidden" name="_class_id" value="{{$_admission_class_id ?? 0}}">
            <input type="hidden" name="_bill_type" value="{{$_bill_type ?? 0}}">
            <input type="hidden" name="_month" value="{{$_month ?? 0}}">
            <input type="hidden" name="_year" value="{{$_year ?? 0}}">


                
            </div>
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

@php
$_make_ledger_coloumn_name = $_bill_type.'_ledger';
@endphp
        <div class="form-group col-md-6">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="{{$_bill_type}}">{{$bill_types[$_bill_type] ?? ''}}</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="_dr_ledger_id">BILL LEDGER</label>
            <select name="_dr_ledger_id" class="form-control ">
                <option value="{{$income_ledgers->$_make_ledger_coloumn_name ?? 0}}">{{_ledger_name($income_ledgers->$_make_ledger_coloumn_name ?? 0)}}</option>
            </select>


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
                        <th>Division</th>
                        <th>Class </th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Short Note</th>
                        <th>{{$bill_types[$_bill_type] ?? ''}}</th>
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
$fee_column = $_bill_type ?? '_tution_fee';
$_grand_total            +=$data->$fee_column ??  0;
$_grand_due_balance            +=$data->fee_column ??  0;
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
                                                 <input type="text" name="_short_narration[]" value="{{$bill_types[$_bill_type] ?? ''}}" class="form-control _short_narration">
                                             </td>
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_admission_fee[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$data->$fee_column)}}" >
                                                <input type="hidden" name="_bill_type_name[]" value="{{$_bill_type ?? ''}}">
                                              

                                              </td>
                                             

                          @empty
                          @endforelse
                      </tbody>
                      <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="7">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
                                              </td>
                                             
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
    

$(document).on('keyup','._total',function(){
    payment_total_calculatins();
})



function payment_total_calculatins(){
    var _grand_total=0;
  
 $(document).find('._total').each(function(){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;
 })

 $(document).find("._grand_total").val(_grand_total);



}
 
</script>

@endsection

