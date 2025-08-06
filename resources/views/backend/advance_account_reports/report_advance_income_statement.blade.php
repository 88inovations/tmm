@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('advance_income_statement')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
  <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                 {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        </div>
      </div>

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
            <th style="width: 15%;">Group</th>
            <th style="width: 40%;">Ledger</th>
            <th style="width: 15%;" class="text-right">Upto Previous </th>
            <th style="width: 15%;" class="text-right">Current Period</th>
            <th style="width: 15%;" class="text-right" >Amount</th>
          </tr>
          
          
          </thead>
          <tbody>
           
            <tr>
              <td></td>
            </tr>
                  


          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
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
