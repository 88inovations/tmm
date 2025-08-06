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
           Date: {{date('d-m-Y')}}<br>
           <b>Asset Details</b>
        </address>
  </div>


       <table class="table table-bordered table-sm fs--1 mb-0">
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->id ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.name')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->name ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset-category')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->category->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label._ledger_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->category_ledger->_name ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset_dep_ledger_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->_asset_dep_ledger->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.asset_dep_exp_ledger_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->_asset_dep_exp_ledger->_name ?? '' !!}</td>
        </tr>




        <tr>
          <td style="width:25%;text-align: right;">{{__('label._brand_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->brand->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.vendor_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->vendor->_name ?? '' !!}</td>
        </tr>

     
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset_condition_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->condition->name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.assign_status_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->assign_status->name ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.organization_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->organization->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label._branch_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->branch->_name ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.project_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->cost_center->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.asset_location_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->building->name ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset_room_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->room->name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.asset_code')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->asset_code ?? '' !!}</td>
        </tr>
       
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.model_no')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->model_no ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.serial_no')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->serial_no ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.group_serial_no')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->group_serial_no ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.domain_intune')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->domain_intune ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.warranty_start_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->warranty_start_date ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.warranty_end_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->warranty_end_date ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.warranty_status')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! select_warranty_status($data->warranty_status ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.os_type')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->os_type ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.purchase_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->purchase_date ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label._date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->_date ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.year_manufacture')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->year_manufacture ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.origin')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->origin ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.purchase_voucher_no')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->purchase_voucher_no ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.voucher_id')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->voucher_id ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.dep_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->dep_date ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.purchase_price')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->purchase_price ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.extra_cost')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->extra_cost ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.entry_price')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->entry_price ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.evaluated_price')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->evaluated_price ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.dep_type')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">
            @if($data->dep_type ==1)
              Percentage
            @else
            Fixed
            @endif
          </td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.dep_rate')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->dep_rate ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.dep_value')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->dep_value ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.accumulated_dep_val')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->accumulated_dep_val ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.book_value')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->book_value ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label._selling_value')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->_selling_value ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label._pl_amount')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _report_amount($data->_pl_amount ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label._sale_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! _view_date_formate($data->_sale_date ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.estimated_life')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->estimated_life ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset_tag')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->asset_tag ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.description')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->description ?? '' !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.remarks')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->remarks ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.status')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! selected_status($data->status ?? '') !!}</td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label._is_sold')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! selected_yes_no($data->_is_sold ?? '') !!}</td>
          
          <td style="width:25%;text-align: right;"></td>
          <td style="width:25%;text-align: left;font-weight: bold;"></td>
        </tr>
        





       
        
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.assign_date')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->assign_date ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;">{{__('label.assign_users')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->_user->_name ?? '' !!}</td>
        </tr>
      
        
       
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.branch')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->branch->_name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;"></td>
          <td style="width:25%;text-align: left;"></td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset-location')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->building->name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;"></td>
          <td style="width:25%;text-align: left;"></td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset-actual-location')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">{!! $data->current_user->room->name ?? '' !!}</td>
          
          <td style="width:25%;text-align: right;"></td>
          <td style="width:25%;text-align: left;font-weight: bold;"></td>
        </tr>
        <tr>
          <td style="width:25%;text-align: right;">{{__('label.asset_image_1')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">
            <img src="{{asset($data->asset_image_1 ?? '')}}" style="width:150px;height: 150px;">
          </td>
          <td style="width:25%;text-align: right;">{{__('label.asset_image_2')}}</td>
          <td style="width:25%;text-align: left;font-weight: bold;">
            <img src="{{asset($data->asset_image_2 ?? '')}}" style="width:150px;height: 150px;">
          </td>
        </tr>
       
      </table>
 </section>
          
        
            
</div>
</div>
</div>
</div>



@endsection

@section('script')
@endsection