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
    <a class="nav-link"  href="{{url('transection_terms_wise_sales')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date: {{ _view_date_formate($request->_datex ?? '') }} To {{ _view_date_formate($request->_datey ?? '') }} </strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <br>
                  <b>@foreach($permited_branch as $p_branch)
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach </b></td> </tr>
              </table>
            </td>
           
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           <th style="border:1px solid silver;width: 7%;" class="text-left" >Date</th>
            <th style="border:1px solid silver;width: 7%;" class="text-left" >Name of Customer</th>
            <th style="border:1px solid silver;width: 30%;" class="text-left" >Customer ID </th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Address</th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Phone</th>
            <th style="border:1px solid silver;width: 20%;" class="text-left" >Particulars</th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Invoice No </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Sales Amount </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Discount </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Total Discount Amount </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >Total Sales Amount </th>
          </tr>
          
          
          </thead>
          <tbody>
@php
$sales_amount         =0;
$discount_amount      =0;
$_total_vat      =0;
$net_sales   =0;
@endphp
          @forelse($datas as $key=>$data)


          @php
$sales_amount         +=$data->_sub_total ?? 0;
$discount_amount      +=$data->_total_discount ?? 0;
$net_sales            +=$data->_total ?? 0;
$_total_vat           +=$data->_total_vat ?? 0;
@endphp
            <tr>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-left" >{!! _view_date_formate($data->_date) !!}</td>
            <td style="border:1px solid silver;width: 7%;" class="text-left" >{!! $data->_name ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-left" >{!! $data->_code ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;" class="text-left" >{!! $data->_address ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-left" >{!! $data->_phone ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;" class="text-left" >{!! $data->_note ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-left" >{!! $data->_order_number ?? '' !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-right" >{!! _report_amount($data->_sub_total ?? 0) !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-right" >{!! _report_amount($data->_discount_input ?? 0) !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-right" >{!! _report_amount($data->_total_discount ?? 0) !!}</td>
            <td style="border:1px solid silver;width: 7%;white-space: nowrap;" class="text-right" >{!! _report_amount($data->_total ?? 0) !!}</td>
           
          </tr>
           @empty
           @endforelse
           
          
          </tbody>
          <tfoot>
             <tr>
           <th colspan="7">Grand Total</th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >{!! _report_amount($sales_amount ?? 0) !!} </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" ></th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >{!! _report_amount($discount_amount ?? 0) !!} </th>
            <th style="border:1px solid silver;width: 8%;" class="text-right" >{!! _report_amount($net_sales ?? 0) !!} </th>
            
          </tr>
          </tfoot>
          
        </table>

      

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
