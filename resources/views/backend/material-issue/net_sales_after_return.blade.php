@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: silver;
    background-color: #fff; 
}
}
  </style>
  <style>
  
    thead {
      display: table-header-group;
    }
    tfoot {
      display: table-footer-group;
    }
    @media print {
      thead {
        display: table-header-group;
      }
      tfoot {
        display: table-footer-group;
      }
    }
  </style>
<div class="_report_button_header">
 <a class="nav-link"  href="{{url('material-issue')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('material-issue-edit')
    <a class="nav-link"  title="Edit" href="{{ route('material-issue.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

  @php
    $_is_header = $form_settings->_is_header ?? 0;
    $_is_footer = $form_settings->_is_footer ?? 0;
    $_margin_top = $form_settings->_margin_top ?? '0px';
    $_margin_bottom = $form_settings->_margin_bottom ?? '0px';
    $_margin_left = $form_settings->_margin_left ?? '0px';
    $_margin_right = $form_settings->_margin_right ?? '0px';
  @endphp
   <div  > 

     

       <table style="width: 100%;margin-bottom: {{$_margin_bottom}};margin-top: {{$_margin_top}};margin-left: {{$_margin_left}};margin-right: {{$_margin_right}}">
        <thead style="border:0px;background: #fff;">
             @if($_is_header ==1 )
            <tr style="border: 0px solid silver !important;">
                <th colspan="8" style="width: 100%;border: 0px solid silver !important;white-space: inherit;">
                   
     <div class="row">
      <div class="col-3">
            <h3><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 150px;width: 150px"  >  </h3>
        
        
      </div>
      <div class="col-6 " style="text-align: center;white-space: inherit;">
            <h2 style="text-align: center;">{{ $settings->name ?? '' }}</h2>
            <h5 style="text-align: center;">{{ $settings->keywords ?? '' }}</h5>
           <div>{{ $settings->_address ?? '' }}<br>
            Phone: {{$settings->_phone ?? '' }}<br>
            Email: {{$settings->_email ?? '' }}</div>
      </div>
      <div class="col-3 "></div>
      <div class="col-md-12" >
        <div style="text-align: center;">
          <span style="font-size: 30px;
    font-weight: bold;
    padding: 5px;
    border-radius: 5px;">Net Sales After Return</span> 
        </div>
        
      </div>
     </div>

                </th>
            </tr>
    @endif
    <tr>
        <th colspan="8" style="border: 0px solid silver;">
            <table style="width: 100%;"  > 

  
  
          <tr>
            <td rowspan="6" style="width: 60%;;border: 1px solid silver;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 20%;text-align: left;"><b>Customer ID</b></td>
                    
                    <td style="width: 80%;text-align: left;"><b>:{{$data->_ledger->id ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Customer Name</b></td>
                    <td><b>:{{$data->_ledger->_name ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Proprietor</b></td>
                    <td><b>:{{$data->_ledger->_alious ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Cell NO</b></td>
                    <td><b>:{{$data->_phone ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b>Address</b></td>
                    <td><b>:{{$data->_address ?? '' }}</b></td>
                  </tr>
                  <tr>
                    <td><b></b></td>
                    <td><b></b></td>
                  </tr>
                </table>
            </td>
            <td style="width: 15%;border: 1px solid silver;">Invoice No: </td>
            <td style="width: 25%;border: 1px solid silver;">
              {{ invoice_barcode($data->_order_number ?? '') }}
              {{ $data->_order_number ?? '' }} </td>
          </tr>
          
          <tr>
            <td style="width: 15%;border: 1px solid silver;">Invoice Date</td>
            <td style="width: 25%;border: 1px solid silver;">{!! _view_date_formate($data->_date ?? '') !!}</td>
          </tr>
          
          <tr>
            <td style="width: 15%;border: 1px solid silver;">Sales By</td>
            <td style="width: 15%;border: 1px solid silver;">{!! $data->_user_name ?? '' !!}</td>
          </tr>
        </table>
        </th>
    </tr>
         <tr>
           <th class="text-left" style="width: 5%;border: 1px solid silver;">SL</th>
          <th class="text-left" style="width: 53%;border: 1px solid silver;">Product Name</th>
          <th class="text-left" style="width: 7%;border: 1px solid silver;">Unit</th>
          <th class="text-right" style="width: 7%;border: 1px solid silver;">Qty</th>
          <th class="text-right" style="width: 8%;border: 1px solid silver;">Rate</th>
          <th class="text-right" style="width: 5%;border: 1px solid silver;">Discount</th>
          <th class="text-right" style="width: 5%;border: 1px solid silver;">VAT</th>
          <th class="text-right" style="width: 10%;border: 1px solid silver;">Amount</th>
         </tr>
        </thead>
        <tbody>
          
            @php
              $_value_total = 0;
              $_vat_total = 0;
              $_qty_total = 0;
              $_total_discount_amount = 0;
              $id=1;
            @endphp

            @forelse($after_sales_return as $key=>$val)

            @php
              $_value_total += $val->_value ?? 0;
              $_vat_total += $val->_vat_amount ?? 0;
              $_qty_total += $val->_qty ?? 0;
              $_total_discount_amount += $val->_discount_amount ?? 0;
              $id=1;
            @endphp
            <tr>
              <td style="border: 1px solid silver;">{{$id}}</td>
              <td style="vertical-align: text-top;border: 1px solid silver;">{{$val->_item_name ?? '' }}</td>
              <td style="vertical-align: text-top;border: 1px solid silver;">{{$val->_unit_name ?? '' }}</td>
              <td class="text-right"  style="vertical-align: text-top;border: 1px solid silver;">{{ _report_amount($val->_qty ?? 0) }}</td>
              <td class="text-right"  style="vertical-align: text-top;border: 1px solid silver;">{{ _report_amount($val->_sales_rate ?? 0) }}</td>
              <td class="text-right"  style="vertical-align: text-top;border: 1px solid silver;">{{ _report_amount($val->_discount_amount ?? 0) }}</td>
              <td class="text-right"  style="vertical-align: text-top;border: 1px solid silver;">{{ _report_amount($val->_vat_amount ?? 0) }}</td>
              <td  class="text-right" style="vertical-align: text-top;border: 1px solid silver;">{{ _report_amount($val->_value ?? 0) }}</td>
            </tr>


            @empty
            @endforelse


            
                                  
                            <tr>
                              <td colspan="3" class="text-right " style="border: 1px solid silver;"><b>Total</b></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="border: 1px solid silver;"></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_total_discount_amount ?? 0)}}</b> </td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_vat_total ?? 0)}}</b> </td>
                              <td class=" text-right" style="border: 1px solid silver;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            @php
            $return_total_vat=0;
            $retrun_total_discount=0;
            $return_total_amount=0;
            $return_subtotal=0;
            @endphp

            @forelse($sales_returns as $r_key=>$r_val)

            @php
            $return_total_vat +=$r_val->_total_vat ?? 0;
            $retrun_total_discount +=$r_val->_total_discount ?? 0;
            $return_subtotal +=$r_val->_sub_total ?? 0;
            $return_total_amount +=$r_val->_total ?? 0;
            @endphp

            @empty
            @endforelse
                            <tr>
                              <td colspan="4" class="text-left " style="width: 50%;">
                              <table style="width: 100%">
                                <tr>
                                  <td>

                                    {{$settings->_sales_note ?? '' }}
                                  </td>
                                </tr>
                                <tr>
                                  <td><p class="lead"> In Words:  {{ nv_number_to_text(($data->_total ?? 0)-$return_total_amount) }} </p></td>
                                </tr>
                                <tr>
                                  <td>
                                    @include("backend.sales.invoice_history")
                                  </td>
                                </tr>
                              </table>
                              </td>
            
                              <td colspan="4" class=" text-right"  style="width: 50%;">
                                  <table style="width: 100%">
                                     <tr>
                                      <th class="text-right" ><b>Sub Total</b></th>
                                      <th class="text-right">{!! _report_amount( ($data->_sub_total ?? 0)-$return_subtotal) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th class="text-right" ><b>Discount[-]</b></th>
                                      <th class="text-right">{!! _report_amount(($data->_total_discount ?? 0)-$retrun_total_discount) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-right" ><b>VAT[+]</b></th>
                                      <th class="text-right">{!! _report_amount(($data->_total_vat ?? 0)-$return_total_vat) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th class="text-right" ><b>Net Total</b></th>
                                      <th class="text-right">{!! _report_amount( ($data->_total ?? 0)-$return_total_amount) !!}</th>
                                    </tr>
                                   
                                  </table>

                              </td>
                            </tr>
        
        </tbody>
        <tfoot>
@if($_is_footer ==1)
               <tr>
                 <td colspan="8">
                    <div class="col-12 mt-5">
                  <div class="row">
                    <div class="col-4 text-left " style="margin-bottom: 50px;">
                      <span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;">Customer Signature</span>
                    </div>
                    <div class="col-4"></div>
                    
                    <div class="col-4 text-center " style="margin-bottom: 50px;">
                     <!-- <div style="height: 120px;width:auto; ">
                        <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$form_settings->_seal_image ?? ''}}"   />
                     </div> <br> -->
                      <span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;"> Authorised Signature</span>
                    </div>
                  </div>
                </div>
                 </td>
               </tr> 
@endif
        </tfoot>
       </table>
   
</div>
   

   @endsection

@section('script')

@endsection