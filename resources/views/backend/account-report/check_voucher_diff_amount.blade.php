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
      <a class="nav-link"  href="{{url('balance-sheet')}}" role="button"><i class="fas fa-search"></i></a>
      <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
    
    </div>

<section class="invoice" id="printablediv">
    
   
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 25%;text-align: left;">
              
            </td>
            <td style="border:none;width: 50%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                
              
                 
                      <tr>
                        <td class="_report_header_tr text-center" style="border:none;">Print: {{date('d-m-Y H:s:a')}}</td>
                      </tr>
              </table>
            </td>
            <td style="border:none;width: 25%;text-align: right;">
            </td>
          </tr>
        </table>
        </div>
      </div>
    <!-- /.row -->

    <!-- Table row -->
   <table class="cewReportTable">
  

   
      
            <thead>
                <tr>
                    <th>Voucher Code</th>
                    <th>Date</th>
                    <th>DR Amount</th>
                    <th>CR Amount</th>
                    <th>DIFF</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->_voucher_code }}</td>
                        <td>{!! _view_date_formate($voucher->_date ?? '' ) !!}</td>
                        <td>{{ _report_amount($voucher->total_dr_amount) }}</td>
                        <td>{{ _report_amount($voucher->total_cr_amount) }}</td>
                        <td>{{ _report_amount($voucher->total_dr_amount - $voucher->total_cr_amount) }}</td>
                       
                        
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
   
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')


@endsection
