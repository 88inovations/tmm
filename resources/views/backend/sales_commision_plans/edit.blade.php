@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
              <a class="m-0 _page_name" href="{{ route('sales_commision_plans.index') }}">{!! $page_name ?? '' !!} </a>
           
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
              @include('backend.common-modal.item_ledger_sub_link')
                
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('sales_commision_plans.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
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
            @php
$_details  = $data->_detail ?? [];
$_fescal_year  = $data->_fescal_year ?? 0;
            @endphp
              <div class="card-body">
                {!! Form::model($data, ['method' => 'PATCH','route' => ['sales_commision_plans.update', $data->id]]) !!}
                @csrf
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <label class="mr-2" for="_date">{{__('label._date')}}:<span class="_required">*</span></label>
                            <input type="date" id="_date" name="_date" class="form-control _date " placeholder="{{__('label._date')}}" value="{{date('Y-m-d')}}">
                        </div>

                       <div class="col-xs-12 col-sm-12 col-md-2 ">
                        
                            <div class="form-group ">
                                   <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
                                  <select class="form-control _master_organization_id" name="organization_id" required >
                              @if(sizeof($permited_organizations) > 1)
                              <option value=""><---Select---></option>
                              @endif
                                     
                                     @forelse($permited_organizations as $val )
                                     <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                     @empty
                                     @endforelse
                                   </select>
                               </div>
                              <input type="hidden" name="_item_row_count" value="{{sizeof($_details)}}" class="_item_row_count">
                        </div>
                        
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-4 ">
                            <label class="mr-2" for="_name">Plan Name:<span class="_required">*</span></label>
                            <input type="text" id="_name" name="_name" class="form-control _name width_280_px" placeholder="Plan Name" value="{{old('_name',$data->_name ?? '')}}" required>
                        </div>
                    @php
    $currentYear = date('Y');
    $_fescal_year = $data->_fescal_year ?? $currentYear;
    $year_start = ($currentYear - 10);
@endphp

<div class="col-xs-12 col-sm-12 col-md-2">
    <label class="mr-2" for="_fescal_year">{{ __('label._fescal_year') }}</label>
    <select name="_fescal_year" class="form-control" required>
        @for ($i = $year_start; $i <= $currentYear; $i++)
            <option value="{{ $i }}" @if ($i == $_fescal_year) selected @endif>{{ $i }}</option>
        @endfor
    </select>
</div>
                        

                        
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_status">{{__('label._status')}}</label>
                              <select class="form-control" name="_main_status">
                                 <option value="1" @if($data->_status==1) selected @endif>Active</option>
                                  <option value="0" @if($data->_status==0) selected @endif>In Active</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-md-12">
                          <div class="form-group">
                              <label class="mr-2" for="_details">{{__('label._details')}}</label>
                             <textarea class="form-control" name="_details">{{old('_details',$data->_details ?? '')}}</textarea>
                            </div>
                           
                         </div>
                        
                        
@php

$_details = $data->_detail ?? [];
@endphp
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >{{__('label._target_min')}}</th>
                                            <th class="text-left" >{{__('label._target_max')}}</th>
                                            <th class="text-left" >{{__('label._credit_limit')}}</th>
                                            <th class="text-left" >{{__('label._terms_id')}}</th>
                                            <th class="text-left" >{{__('label._p_qty')}}</th>
                                            <th class="text-left" >{{__('label._bonus_qty')}}</th>
                                            <th class="text-left" >{{__('label._anual_discount')}}</th>
                                            <th class="text-left" >{{__('label._cash_discount_rate')}}</th>
                                            <th class="text-left" >{{__('label._gift_item')}}</th>
                                            <th class="text-left" >{{__('label._grade')}}</th>
                                            <th class="text-left" >{{__('label._status')}}</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                              @forelse($_details as $detail)
                                             <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                               <td>
                                                {{$detail->id ?? '' }}
                                                <input type="hidden" name="inputs_id[]" value="{{$detail->id ?? 0}}">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_target_min[]" class="form-control _target_min width_150_px" placeholder="{{__('label._target_min')}}" value="{{$detail->_target_min ?? 0}}" required>
                                                
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_target_max[]" class="form-control _target_max width_150_px" placeholder="{{__('label._target_max')}}" value="{{$detail->_target_max ?? 0}}" required>
                                                
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_credit_limit[]" class="form-control _credit_limit width_150_px" placeholder="{{__('label._credit_limit')}}" value="{{$detail->_credit_limit ?? 0}}" >
                                              </td>
                            @php
$_terms_id  = $detail->_terms_id ?? 0;
$_status  = $detail->_status ?? 0;
                            @endphp
                                              <td>
                                                <select class="form-control _terms_id" name="_terms_id[]">
                                                    <option value="">Select Terms</option>
                                                    @forelse($transection_terms as $terms)
                                                       <option value="{{ $terms->id ?? '' }}"  @if($terms->id==$_terms_id) selected @endif >{{ $terms->_name ?? '' }} | {{ $terms->_days ?? '' }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_p_qty[]" class="form-control _p_qty " value="{{$detail->_p_qty ?? 0}}">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_bonus_qty[]" class="form-control _bonus_qty " value="{{$detail->_bonus_qty ?? 0}}">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_discount_rate[]" class="form-control _discount_rate " value="{{$detail->_discount_rate ?? 0}}" >
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_cash_discount_rate[]" class="form-control _cash_discount_rate " value="{{$detail->_cash_discount_rate ?? 0}}" >
                                              </td>
                                              <td>
                                                <input type="text"  name="_gift_item[]" class="form-control _gift_item " value="{{$detail->_gift_item ?? ''}}"  placeholder="{{__('label._gift_item')}}">
                                              </td>
                                              <td>
                                                <input type="text"  name="_grade[]" class="form-control _grade " value="{{$detail->_grade ?? ''}}"  placeholder="{{__('label._grade')}}">
                                              </td>
                                              <td class="">
                                                <select class="form-control _status" name="_status[]">
                                                 
                                                  @forelse(common_status() as $key=>$val)
                                                    <option value="{{$key}}" @if($key==$_status) selected @endif >{{$val ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            </tr>
                                              @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                               <td colspan="12" class="text-right"></td>
                                            
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
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



</div>
@include('backend.common-modal.item_ledger_modal')

@endsection

@section('script')

<script type="text/javascript">

  var after_desimal=4;

 

function purchase_row_add(event){
   event.preventDefault();
      

       _item_row_count= $("._item_row_count").val();
      $("._item_row_count").val((parseFloat(_item_row_count)+1));
     var  _item_row_count = (parseFloat(_item_row_count)+1);
     $("#area__purchase_details").append(` <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                               <td>
                                                <input type="hidden" name="inputs_id[]" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_target_min[]" class="form-control _target_min width_150_px" placeholder="{{__('label._target_min')}}" required>
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_target_max[]" class="form-control _target_max width_150_px" placeholder="{{__('label._target_max')}}" required>
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_credit_limit[]" class="form-control _credit_limit width_150_px" placeholder="{{__('label._credit_limit')}}" >
                                              </td>
                                              
                                              <td>
                                                <select class="form-control _terms_id" name="_terms_id[]">
                                                    <option value="">Select Terms</option>
                                                    @forelse($transection_terms as $terms)
                                                       <option value="{{ $terms->id ?? '' }}">{{ $terms->_name ?? '' }} | {{ $terms->_days ?? '' }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_p_qty[]" class="form-control _p_qty " value="0">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_bonus_qty[]" class="form-control _bonus_qty " value="0">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_discount_rate[]" class="form-control _discount_rate " value="0" >
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_cash_discount_rate[]" class="form-control _cash_discount_rate " value="0" >
                                              </td>
                                              <td>
                                                <input type="text"  name="_gift_item[]" class="form-control _gift_item " value=""  placeholder="{{__('label._gift_item')}}">
                                              </td>
                                              <td>
                                                <input type="text"  name="_grade[]" class="form-control _grade " value=""  placeholder="{{__('label._grade')}}">
                                              </td>
                                              <td class="">
                                                <select class="form-control _status" name="_status[]">
                                                 
                                                  @forelse(common_status() as $key=>$val)
                                                    <option value="{{$key}}">{{$val ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            </tr>`);
     
      

}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
        
        $(this).parent().parent('tr').find('._ref_counter').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
           $(this).parent().parent('tr').find('._ref_counter').remove();
        } 
      }
      _purchase_total_calculation();
  })

 var _purchase_row_single_new =``;

  



  

//_new_barcode_function(_item_row_count);
  function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }


 

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

