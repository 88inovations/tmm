@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<style type="text/css">
  
  .col-md-3{
    margin-top: 5px !important;
  }
  .col-md-4{
    margin-top: 5px !important;
  }
  .col-md-6{
    margin-top: 5px !important;
  }
  .col-md-8{
    margin-top: 5px !important;
  }
  .col-md-12{
    margin-top: 5px !important;
  }
</style>
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
             @can('asset_maintainces_list')
            <li class="breadcrumb-item"><a href="{{route('asset_maintainces.index')}}">{{__('label.asset_maintainces')}}</a></li>
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
          
           {!! $data->branch->_name ?? '' !!}<br>
           {!! $data->cost_center->_name ?? '' !!}<br>
           <b>{{__('label.asset_maintainces')}}</b><br>
           
           
           
        </address>
  </div>
  
    <table class="table table-bordered table-sm fs--1 mb-0"  style="width:100%;">
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">ID</td>
        <td colspan="11" style="border:none;"> : {!! $data->id ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._date')}}</td>
        <td colspan="11" style="border:none;"> : {!! _view_date_formate($data->_date ?? '') !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._asset_id')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_asset_item->name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.asset_code')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_asset_item->asset_code ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.asset_tag')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_asset_item->asset_tag ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.energy_used')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->energy_used ?? 0 !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.cost')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->cost ?? 0!!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.operating_hours')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->operating_hours ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.fuel_used_liters')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->fuel_used_liters ?? 0 !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.electricity_used_kwh')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->electricity_used_kwh ?? 0 !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._note')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_note ?? 0 !!}</td>
      </tr>
   
      
<tr style="border:none;">
  <td colspan="13" style="border:none;">{{__('label._note')}}:{!! $data->_note ?? '' !!}</td>
</tr>
<tfoot>
  <tr style="border:none;">
    <td style="border:none;" colspan="13">
      <table style="width:100%;border-collapse:collapse;border:0px solid #fff;">
        <tr>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
          <td style="height:60px;border:0px solid #fff;"></td>
        </tr>
        <tr>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Prepared By</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Checked by</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          <td style="border:0px solid #fff;">
            <div style="text-align:center;">
              <b> Approved by</b><br>
              <small style="font-size:12px;"></small>
            </div>
          </td>
          
        </tr>
      </table>
    </td>
  </tr>
  


</tfoot>
</table>
  
  
       
                        

                     
 </section>
          
        
            
</div>


        @endsection

@section('script')
  <script>
   

  </script>
@endsection