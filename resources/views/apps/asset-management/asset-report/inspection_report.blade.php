@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset_item_entry.index')}}">{{__('label.asset-entry-assign')}}</a></li>
            @endcan
           
            <li class="breadcrumb-item">
               <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
               </a>
            </li>
            <li class="breadcrumb-item">
                <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
            </li>
           
          </ol>
        </nav>
        <div class="mb-9">
       


<section class="invoice" id="printablediv">
   <div class="text-center">
      <address>
        <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
            {!! $settings->name ?? '' !!}<br>
            @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
           
           {{__('label.inspection_date')}}: {!! _view_date_formate($data->current_user->inspection_date ?? '') !!}<br>
           <b> {{__('label.EQUIPMENT_CONDITION_CHECKLIST')}}</b>
           <p> {{__('label.EQUIPMENT_CONDITION_CHECKLIST_DETAILS')}}</p>
           
        </address>
  </div>
  
    <table class="table table-bordered table-sm fs--1 mb-0"  style="width:100%;">
      <tr>
        <td style="width:20%;padding: 0px;"><b>{{__('label.device_name')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->name ?? '' !!}</td>
        <td style="width:20%;padding: 0px;"><b>{{__('label.asset_tag')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->asset_tag ?? '' !!}</td>
      </tr>
      <tr>
        <td style="width:20%;padding: 0px;"><b>{{__('label.asset_code')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->asset_code ?? '' !!}</td>
        <td style="width:20%;padding: 0px;"><b>{{__('label.model_no')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->model_no ?? '' !!}</td>
      </tr>
      <tr>
        <td style="width:20%;padding: 0px;"><b>{{__('label.serial_no')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->serial_no ?? '' !!}</td>
        <td style="width:20%;padding: 0px;"><b>{{__('label.description')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->description ?? '' !!}</td>
      </tr>
      <tr>
        <td style="width:20%;padding: 0px;"><b>{{__('label.category')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->category->_name ?? '' !!}</td>
        <td style="width:20%;padding: 0px;"><b>{{__('label.asset-brand')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->brand->_name ?? '' !!}</td>
      </tr>
      <tr>
        <td style="width:20%;padding: 0px;"><b>{{__('label.asset-condition')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->condition->name ?? '' !!}</td>
        <td style="width:20%;padding: 0px;"><b>{{__('label.assign_users')}}</b></td>
        <td style="width:30%;padding:0px;">{!! $data->current_user->_user->_code ?? '' !!} {!! $data->current_user->_user->_name ?? '' !!}</td>
      </tr>
      <!-- <tr>
        <td style="width:50%;">{{__('label.asset-condition')}}</td>
        <td style="width:50%;">{!! $data->current_user->_user->name ?? '' !!}</td>
      </tr> -->
@forelse($inspection_cats as $key=>$val)
  @php
  $check_list = $val->check_list ?? [];
  @endphp
  @forelse($check_list as $lkey=>$lval)
    @if($lkey==0)
      <tr>
        <td style="padding: 0px;" colspan="4"><b>{!! $val->name ?? '' !!}</b></td>
      </tr>
    @endif
    <tr style="padding: 0px;">
      
      <td style="padding: 0px;" colspan="2">{!! $lval->name ?? '' !!}</td>
      <td style="padding: 0px;">@if(inspection_checkOrNot($_inspections,$lval->id)=="checked")
      <span class="badge badge-phoenix fs--2 badge-phoenix-success">
            <span class="badge-label"></span><span class="ms-1" data-feather="check" style="height:7.8px;width:7.8px;"></span></span> 

      @endif</td>
      <td style="padding: 0px;">{{ inspection_remarks($_inspections,$lval->id) }}</td>
    </tr>
  @empty
  @endforelse
@empty
@endforelse
<tr>
  <td colspan="4">{{__('label.remarks')}}:{!! $data->current_user->inspection_remarks ?? '' !!}</td>
</tr>
<tfoot>
  <tr>
    <td colspan="2"><span style="border-bottom:1px solid #000;">{{__('label.inspector_information')}}</span><br>
      {!! $data->current_user->inspector_information ?? '' !!}
    </td>
    <td>{{__('label.date')}}:{!! date('d-m-Y') !!}</td>
    <td>{{__('label.sign')}}:__________________</td>
  </tr>
</tfoot>
    </table>
  
  
       
                        

                     
 </section>
          
        
            
</div>
</div>
</div>
</div>



@endsection

@section('script')
@endsection