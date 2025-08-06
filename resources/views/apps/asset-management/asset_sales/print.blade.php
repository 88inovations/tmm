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
             @can('asset_sales_list')
            <li class="breadcrumb-item"><a href="{{route('asset_sales_list')}}">{{__('label.asset_sales_list')}}</a></li>
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
          
           {!! $data->_master_branch->_name ?? '' !!}<br>
           {!! $data->_master_cost_center->_name ?? '' !!}<br>
           <b>{{ $page_name ?? '' }}</b><br>
           
           
           
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
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.organization_id')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_organization->_name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._branch_id')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_master_branch->_name ?? '' !!} </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._cost_center_id')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_master_cost_center->_name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._budget_id')}}</td>
        <td colspan="11" style="border:none;"> : {!! _id_to_name($data->_budget_id,'_name','budgets') !!} </td>
      </tr>

      
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.voucher_code')}}</td>
        <td colspan="11" style="border:none;"> : <a target="__blank" href="{{url('voucher')}}/{!! $data->voucher_id ?? '' !!}"> {!! $data->voucher_code ?? '' !!}</a></td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._name')}}</td>
        <td colspan="11" style="border:none;"> :  {!! $data->_asset->name ?? '' !!}</td>
      </tr>

      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.asset_code')}}</td>
        <td colspan="11" style="border:none;"> :  {!! $data->_asset->asset_code ?? '' !!}</td>
      </tr>
      
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.customer_name')}}</td>
        <td colspan="11" style="border:none;"> :  {!! $data->_asset_customer->_name ?? '' !!}</td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">Asset Ledger Name</td>
        <td colspan="11" style="border:none;"> :  {!! $data->asset_ledger->_name ?? '' !!} </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">Cash/Bank Account</td>
        <td colspan="11" style="border:none;"> :  {!! $data->_payment_receive->_name ?? '' !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.original_cost')}}</td>
        <td colspan="11" style="border:none;"> :  {!! _report_amount($data->original_cost ?? 0) !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.accumulated_depreciation')}}</td>
        <td colspan="11" style="border:none;"> :  {!! _report_amount($data->accumulated_depreciation ?? 0) !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.book_value')}}</td>
        <td colspan="11" style="border:none;"> :  {!! _report_amount($data->book_value ?? 0) !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.sale_price')}}</td>
        <td colspan="11" style="border:none;"> :  {!! _report_amount($data->sale_price ?? 0) !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.gain_loss')}}</td>
        <td colspan="11" style="border:none;"> :  {!! _report_amount($data->gain_loss ?? 0) !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.created_by')}}</td>
        <td colspan="11" style="border:none;"> : {!! _id_to_name($data->created_by,'name','users') !!}    </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.updated_by')}}</td>
        <td colspan="11" style="border:none;"> : {!! _id_to_name($data->updated_by,'name','users') !!}   </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.created_at')}}</td>
        <td colspan="11" style="border:none;"> :  {!! ($data->created_at ?? '') !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label.updated_at')}}</td>
        <td colspan="11" style="border:none;"> :  {!! ($data->updated_at ?? '') !!}  </td>
      </tr>
      <tr style="border:none;">
        <td colspan="2" style="border:none;font-weight: 600;">{{__('label._note')}}</td>
        <td colspan="11" style="border:none;"> : {!! $data->_note ?? '' !!} </td>
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