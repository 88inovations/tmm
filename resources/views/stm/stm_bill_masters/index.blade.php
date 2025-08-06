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

     
   @php
$_admission_session_id =  $request->_admission_session_id ?? '';
$_education_type =  $request->_education_type ?? '';
$_admission_class_id =  $request->_admission_class_id ?? '';
$_bill_type =  $request->_bill_type ?? '';
$_month =  $request->_month ?? '';
$_year =  $request->_year ?? '';
$_order_number =  $request->_order_number ?? '';

$asc_cloumn =  $request->asc_cloumn ?? '';
$_asc_desc =  $request->_asc_desc ?? '';
 $row_numbers = filter_page_numbers();





@endphp


     @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                 <div class="row">


                   <form class="mb-2" action="{{route('stm_bill_masters.index')}}" method="GET">
            @csrf
                
                      <div>
                           
                         <div class="row">
                          
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._admission_session_id')}}:</label>
                                    <select class="form-control _admission_session_id" name="_admission_session_id" >
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
                                    <label class="form-control-label">{{__('label._education_type')}}:</label>
                                    <select class="form-control _education_type" name="_education_type" >
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
                                    <label class="form-control-label">{{__('label._admission_class_id')}}:</label>
                                    <select class="form-control _admission_class_id" name="_admission_class_id" >
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
                                 <label class="mr-2" for="_month">{{ __('label._month') }}</label>
                                <select class="form-control _month" name="_month" >
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
                                  <label class="mr-2" for="_year">{{ __('label._year') }}</label>
                                  <select name="_year" class="form-control" >
                                      @for ($i = $year_start; $i <= $currentYear; $i++)
                                          <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                                      @endfor
                                  </select>
                              </div>
                                    @php                     
                                    $bill_types =_fees_types();
                                    @endphp
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                  <label class="mr-2" for="_bill_type">{{ __('label._bill_type') }}</label>
                                  <select name="_bill_type" class="form-control" >
                                      @forelse($bill_types as $bill_key=>$lebel)
                                          <option value="{{ $bill_key }}" @if ($bill_key == $_bill_type) selected @endif>{{ $lebel }}</option>
                                      @empty
                                      @endforelse
                                  </select>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('label._order_number')}}:</label>
                                    <input type="text" name="_order_number" class="form-control _order_number" value="{{$_order_number}}" placeholder="{{__('label._order_number')}}">
                                </div>
                            </div>

                        @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date'];





                      @endphp
                        <div class="col-xs-12 col-sm-12 col-md-2">
                          <label class="mr-2" for="_order_number">Order By</label>
                         <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}"  @if($key==$asc_cloumn) selected @endif  >{{$val}}</option>
                        @endforeach
                        </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="_asc_desc">Sort Order</label>
                             <select class=" form-control" name="_asc_desc">
                            @foreach(asc_desc() AS $key=>$val)
                                <option value="{{$val}}"  @if($val==$_asc_desc) selected @endif  >{{$val}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                              <label class="mr-2" for="limit">Limit</label>
                            <select name="limit" class="form-control" >
                              @forelse($row_numbers as $row)
                               <option  @if($limit == $row) selected @endif   value="{{ $row }}">{{$row}}</option>
                              @empty
                              @endforelse
                      </select>
                        </div>




                            <div class="col-xs-12 col-sm-12 col-md-3 mt-3 ">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm mr-2"><i class="fa fa-search "></i> Search</button>
                                  <a href="{{route('stm_bill_masters.index')}}" class="btn btn btn-danger btn-sm">🔄 Reset</a>
                                </div>
                                   

                            </div>
                        </div>
                            
                          </div>
                    </form>
</div>


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
                    
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b>SL</b></th>
                         <th class=""><b>ID</b></th>
                         <th class=""><b>{{__('label._date')}}</b></th>
                         <th class=""><b>{{__('label._order_number')}}</b></th>
                         <th class=""><b>{{__('label._bill_type')}}</b></th>
                         <th class=""><b>{{__('label._stm_division_id')}}</b></th>
                         <th class=""><b>{{__('label._class_id')}}</b></th>
                         <th class=""><b>{{__('label._month_id')}}</b></th>
                         <th class=""><b>{{__('label._year')}}</b></th>
                         <th class=""><b>{{__('label._bill_amount')}}</b></th>
                         <th class=""><b>{{__('label._note')}}</b></th>
                         <th class=""><b>{{__('label._user_name')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label._lock')}}</b></th>
                         <th class=""><b>{{__('label._created_by')}}</b></th>
                         <th class=""><b>{{__('label._updated_by')}}</b></th>
                         <th class=""><b>{{__('label.created_at')}}</b></th>
                         <th class=""><b>{{__('label.updated_at')}}</b></th>
                      </tr>

                     
                     </thead>
                     <tbody>
                      
                        @forelse ($datas as $key => $data)
                        
                        <tr>
                            
                             <td style="display: flex;">
                              
                              <a  type="button" 
                                  href="{{ route('stm_bill_masters.show',$data->id) }}"
                                  class="btn btn-sm btn-info  mr-2">Print</a>

                            
                             @can('stm_bill_masters_delete')
                                 
                            
                              <form action="{{ route('stm_bill_masters.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="mr-2 btn btn-danger btn-sm" type="submit" onclick="return confirm('Do You Want to Delete!')" >Delete</button>
                                    </form>
                              @endcan  

                              <a class="btn btn-sm btn-default _action_button " attr_invoice_id="{{$data->id}}" _attr_key="{{$key}}" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>

                               
                            </td>
                            <td>{{($key+1)}}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }}</td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ _fee_lebel($data->_bill_type ?? '') }}</td>
                            <td>{{ $data->_edu_division->_name ?? '' }}</td>
                            <td>{{ $data->_edu_class->_name ?? '' }}</td>
                            <td>{{ _number_to_month($data->_month_id ?? '') }}</td>
                            <td>{{ $data->_year ?? '' }}</td>
                            <td>{{ $data->_total_amount ?? '' }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_user_name ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                          
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
                            <td>{{ $data->_created_by ?? '' }}</td>
                            <td>{{ $data->_updated_by ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            
                            
                        </tr>

                        <tr>
                            <td colspan="10"  class="collapse " id="collapseExample__{{$key}}">
                                 @php
                      
                        $___master_details = $data->_detail ?? [];
                        @endphp
 @if(sizeof($___master_details) > 0)
                          
                           <div >
                            <div class="card  " >
                              <table class="table">
                                <thead >
                                            <th class="text-middle" >SL</th>
                                            <th class="text-left" >{{__('label._student_id')}}</th>
                                            <th class="text-left" >{{__('label._name_in_english')}}</th>
                                            <th class="text-left" >{{__('label._father_name_english')}}</th>
                                            <th class="text-left" >{{__('label._roll_no')}}</th>
                                            <th class="text-left" >{{__('label._amount')}}</th>
                                           
                                           
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_gross_fee_amount = 0;
                                  @endphp
                                  @forelse($___master_details AS $item_key=>$_item )
                                  <tr>
                                   
                                     @php
                                     $_gross_fee_amount = $_item->_fee_amount ?? 0;
                                     @endphp
                                            <td class="" >{!!($item_key+1) !!}</td>
                                            <td class="" >{!! $_item->_student->_student_id ?? '' !!}</td>
                                            <td class="" >{!! $_item->_student->_name_in_english ?? '' !!}</td>
                                            <td class="" >{!! $_item->_student->_father_name_english ?? '' !!}</td>
                                            <td class="" >{!! $_item->_student->_roll_no ?? '' !!}</td>
                                            <td class="" >{!! _report_amount($_item->_fee_amount ?? 0) !!}</td>
                                           
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td>
                                                
                                              </td>
                                              <td colspan="4" class="text-right"><b>Total</b></td>
                                              <td  class="text-right"><b>{{_report_amount($_gross_fee_amount)}}</b></td>
                                             
                                              
                                            </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        
                        @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        

                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="9">  {!! $datas->render() !!}</td>
                          </tr>
                        </tfoot>
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
  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="stm_bill_masters";
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