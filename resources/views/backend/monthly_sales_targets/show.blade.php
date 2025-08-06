@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}
._report_header_tr{
  line-height: 16px !important;
}
  </style>
    <div class="_report_button_header">
      
         @can('monthly_sales_targets-edit')
      <a class="nav-link"  href="{{ route('monthly_sales_targets.edit',$data->id) }}" role="button"><i class="fa fa-pen "></i></a>
      @endcan
      <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
    
    </div>

<section class="invoice" id="printablediv">
    
   
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 20%;text-align: left;">
              
            </td>
            <td style="border:none;width: 60%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td style="border:none;">
                  <img src="{{asset($settings->logo ?? '')}}"  >
                </td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>Period :&nbsp;{{ $data->_year ?? '' }} </b></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 20%;text-align: right;">
              
            </td>
          </tr>
        </table>
        </div>
      </div>
    <!-- /.row -->
<table class="table">
          <thead>
          <tr>
            <th>{{__('label._code')}}</th>
            <th>{{$data->_ledger->_code ?? '' }}</th>
            <th>{{__('label._name')}}</th>
            <th>{{$data->_ledger->_name ?? '' }}</th>
          </tr>
          <tr>
            <th>{{__('label._email')}}</th>
            <th>{{$data->_ledger->_email ?? '' }}</th>
            <th>{{__('label._phone')}}</th>
            <th>{{$data->_ledger->_phone ?? '' }}</th>
          </tr>
          <tr>
            <th>{{__('label.organization_id')}}</th>
            <th>{{$data->_organization->_name ?? '' }}</th>
            <th>{{__('label._branch_id')}}</th>
            <th>{{$data->_master_branch->_name ?? '' }}</th>
          </tr>
          <tr>
            <th>{{__('label._cost_center_id')}}</th>
            <th>{{$data->_master_cost_center->_name ?? '' }}</th>
            <th>{{__('label._address')}}</th>
            <th>{{$data->_ledger->_name ?? '' }}</th>
          </tr>
          
          
          </thead>
  </table>
    <!-- Table row -->
   <table class="table table-borderd">
          <tr>
              <th class="white_space">{{__('label._year')}}</th>
              <th class="white_space">{{__('label._month_no')}}</th>
              <th class="white_space">{{__('label._period_start')}}</th>
              <th class="white_space">{{__('label._period_end')}}</th>
              <th class="white_space">{{__('label._target_amount')}}</th>
              <th class="white_space">{{__('label._sales_amount')}}</th>
              <th class="white_space">{{__('label._sales_return_amount')}}</th>
              <th class="white_space">{{__('label._collection_amount')}}</th>
              <th class="white_space">{{__('label._achivments')}}</th>
            </tr>
          
          
          </thead>
          <tbody>
            

            <tr>
              <td  class="white_space">{!! $data->_year ?? ''  !!}</td>
              <td  class="white_space">{!! _number_to_month($data->_month_no ?? '')  !!}</td>
              <td  class="white_space">{!! _view_date_formate($data->_period_start ?? '')  !!}</td>
              <td  class="white_space">{!! _view_date_formate($data->_period_end ?? '')  !!}</td>
              <td  class="white_space">{!! _report_amount($data->_target_amount ?? 0)  !!}</td>
              <td  class="white_space">{!! _report_amount($data->_sales_amount ?? 0)  !!}</td>
              <td  class="white_space">{!! _report_amount($data->_sales_return_amount ?? 0 ) !!}</td>
              <td  class="white_space">{!! _report_amount($data->_collection_amount ?? 0 ) !!}</td>
              <td  class="white_space"></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="9">
                <div class="row">
                   @include('backend.message.invoice_footer')
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
    


    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')


@endsection
