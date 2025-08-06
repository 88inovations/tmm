@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  

<div class="_report_button_header">
      <a class="nav-link"  href="{{url('date_to_date_sales_amount_report')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b>{{$settings->name ?? '' }}</b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
<?php
$sequence_to_remove = "––------------–--";
?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>

        @php
$_branch_id  = $previous_filter["_branch_id"];
        @endphp
        <table class="table" style="border:none;width: 100%;margin-bottom: 0px !important;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-bottom: 0px !important;">
        


                <tr style="border:none;">
                  <td style="border:none;">
                      <table class="table" >
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Date </th>
                          <td style="width:90%;text-align: left;border: none;">: {{date('d-m-Y h:s A')}} </td>
                        </tr>
@if($_branch_id !='' && $_branch_id !='all')
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label._branch_id')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">: {{ id_to_cloumn($_branch_id,'_name','branches') }}</td>
                        </tr>
@else
      <tr>
            <th style="width:10%;text-align: left;border: none;">{{__('label._branch_id')}}  </th>
            <td style="width:90%;text-align: left;border: none;">: ALL</td>
          </tr>              
@endif
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Subject </th>
                          <td style="width:90%;text-align: left;border: none;">: {{$page_name ?? ''}}</td>
                         
                        </tr>

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Business Period       </th>
                          <td style="width:90%;text-align: left;border: none;">: {{ _view_date_formate($_datex)}}  To  {{_view_date_formate($_datey)}} </td>
                         
                        </tr>
                      </table>
                  </td>
                </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width: 5%;">{{__('label.sl')}}</td>
            <td style="width: 5%;">{{__('label._code')}}</td>
            <td style="width: 5%;">{{__('label._ledger_id')}}</td>
            <td style="width: 5%;">{{__('label._phone')}}</td>
            <td style="width: 5%;">{{__('label._address')}}</td>
            <td style="width: 5%;">Sales Amount</td>
            <td style="width: 5%;">Return Amount</td>
            <td style="width: 5%;">Balance</td>
          </tr>
          
          
          </thead>
          <tbody>
@php
$gross_sales        = 0;
$gross_sales_return = 0; 
$sales_balance      = 0;

@endphp

@forelse($datas as $key=>$data)


@php
$gross_sales        +=$data->_sales_amount ?? 0;
$gross_sales_return +=$data->return_amount ??  0; 
$sales_balance      += ($data->_sales_amount-$data->return_amount);

@endphp


        <tr>
            <td style="width: 5%;">{{($key+1)}}</td>
            <td style="width: 10%;white-space: nowrap;">{{ $data->_code ?? '' }}</td>
            <td style="width: 10%;">{{ $data->_name ?? '' }}</td>
            <td style="width: 10%;">{{ $data->_phone ?? '' }}</td>
            <td style="width: 10%;">{{ $data->_address ?? '' }}</td>
            <td style="width: 10%;white-space: nowrap;">{{ _report_amount($data->_sales_amount ?? 0) }}</td>
            <td style="width: 10%;white-space: nowrap;">{{ _report_amount($data->return_amount ?? 0) }}</td>
            <td style="width: 10%;white-space: nowrap;">{{ _report_amount($sales_balance ?? 0) }}</td>
          </tr>
@empty
@endforelse

  <tr>
            <td colspan="5"><b>GRAND TOTAL</b></td>
            <td style="width: 10%;white-space: nowrap;font-weight: bold;">{{ _report_amount($gross_sales ?? 0) }}</td>
            <td style="width: 10%;white-space: nowrap;font-weight: bold;">{{ _report_amount($gross_sales_return ?? 0) }}</td>
            <td style="width: 10%;white-space: nowrap;font-weight: bold;">{{ _report_amount($sales_balance ?? 0) }}</td>
          </tr>
          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="8" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>
  </section>

@endsection

@section('script')

<script type="text/javascript">

</script>
@endsection

