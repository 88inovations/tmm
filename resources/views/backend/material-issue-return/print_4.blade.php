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
      td,th{
            font-size:22px !important;
        }
    }
     td,th{
            font-size:22px;
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
 <div class="container-fluid">
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
        <thead style="border:0px;">
             
            <tr style="border: 0px solid silver !important;">
                <th colspan="8" style="width: 100%;border: 0px solid silver !important;white-space: inherit;">
                   
     <div class="row">
      <div class="col-3">
            <h3>  </h3>
        
        
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
    background: #34ce19;
    border-radius: 5px;">Material Issue</span> 
        </div>
        
      </div>
     </div>

                </th>
            </tr>
    
    <tr>
        <th colspan="8" style="border: 0px solid silver;">
            <table style="width: 100%;"  > 


  
          <tr>
            <td rowspan="6" style="width: 50%;;border: 1px solid silver;">
                <table style="width: 100%;">
                  <tr>
                    <td style="width: 20%;text-align: left;vertical-align:top;"><b>Ledger ID</b></td>
                    
                    <td style="width: 80%;text-align: left;white-space: break-spaces;font-weight:900;font-size:24px;vertical-align:top;">:{{$data->_ledger->id ?? '' }}</td>
                  </tr>
                  <tr>
                    <td style="width: 20%;text-align: left;vertical-align:top;"><strong>Ledger Name</strong></td>
                    <td style="width: 80%;text-align: left;font-weight:900;font-size:24px;vertical-align:top;">:@if($data->_referance !="")
                    {{$data->_referance ?? '' }}
                  @else
                    {{$data->_ledger->_name ?? '' }}
                  @endif</td>
                  </tr>
                  @php
                  $_alious = $data->_ledger->_alious ?? '';
                  @endphp
                  @if($_alious !='')
                  <tr>
                    <td style="width: 20%;text-align: left;vertical-align:top;">Proprietor</td>
                    <td  style="width: 80%;text-align: left;white-space: break-spaces;font-weight:400;vertical-align:top;">:{{$data->_ledger->_alious ?? '' }}</td>
                  </tr>
                  @endif
                  <tr>
                    <td style="width: 20%;text-align: left;vertical-align:top;">Cell NO</td>
                    <td  style="width: 80%;text-align: left;white-space: break-spaces;font-weight:400;vertical-align:top;">:{{$data->_phone ?? '' }}</td>
                  </tr>
                  <tr>
                    <td  style="width: 20%;text-align: left;vertical-align:top;" >Address</td>
                    <td  style="width: 80%;text-align: left;white-space: break-spaces;font-weight:400;vertical-align:top;">:{{$data->_address ?? '' }}</td>
                  </tr>
                  <tr>
                    <td><b></b></td>
                    <td><b></b></td>
                  </tr>
                </table>
            </td>
            <td style="width: 25%;border: 1px solid silver;">Invoice No: </td>
            <td style="width: 25%;border: 1px solid silver;">
              {{ invoice_barcode($data->_order_number ?? '') }}
              {{ $data->_order_number ?? '' }} </td>
          </tr>
         <tr>
            <td style="width: 25%;border: 1px solid silver;">Invoice Date</td>
            <td style="width: 25%;border: 1px solid silver;">{!! _view_date_formate($data->_date ?? '') !!}</td>
          </tr><tr>
            <td style="width: 25%;border: 1px solid silver;">Entry By</td>
            <td style="width: 15%;border: 1px solid silver;">{!! $data->_user_name ?? '' !!}</td>
          </tr>
         
        </table>
        </th>
    </tr>
         <tr>
           <th class="text-center" style="width: 5%;border: 1px solid silver;">SL</th>
          <th class="text-left" style="width: 53%;border: 1px solid silver;">Item</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Unit</th>
          <th class="text-center" style="width: 7%;border: 1px solid silver;">Qty</th>
          <th class="text-center" style="width: 8%;border: 1px solid silver;">Rate</th>
          <th class="text-center display_none" style="width: 5%;border: 1px solid silver;">Discount</th>
          <th class="text-center display_none" style="width: 5%;border: 1px solid silver;">VAT</th>
          <th class="text-center" style="width: 10%;border: 1px solid silver;">Amount</th>
         </tr>
        </thead>
        <tbody>
           @if(sizeof($_master_detail_reassign) > 0)
         @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                    $id=1;
                                  @endphp
                                  @forelse($_master_detail_reassign AS $item_key=>$_item )
                                  <tr>
                                     <td class="text-center" style="border: 1px solid silver;vertical-align:top;" >{{($id)}}.</td>

                                    

                              @if(sizeof($_item) > 0)
                                     
                                          <td class="  " style="word-break: break-all;vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                                            
                                           
                              @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                    @php
                                      $_value_total +=$in_itemVal_multi->_value ?? 0;
                                      $_vat_total += $in_itemVal_multi->_vat_amount ?? 0;
                                      $_qty_total += $in_itemVal_multi->_qty ?? 0;
                                      $_total_discount_amount += $in_itemVal_multi->_discount_amount ?? 0;
                                     @endphp
                                     @if($_in_item_key==0)
                                            {!! $in_itemVal_multi->_items->_name ?? '' !!} 
                                    @endif
                                          @empty
                                    @endforelse 



                                    @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                            @php 
                                                  $_barcodes_string = $in_itemVal_multi->_barcode ?? '';
                                                  $_barcodes_string_length = strlen($in_itemVal_multi->_barcode ?? '');
                                                  $_barcodes = explode(",",$_barcodes_string);
                                              @endphp
                                              @if($_barcodes_string_length > 0)
                                              
                                              @if($_in_item_key==0)<br> <b>SN:</b> @endif
                                                  @forelse($_barcodes as $barcode)
                                                    <small >{{$barcode ?? '' }},</small>
                                                  @empty
                                                  @endforelse
                                              @endif

                                  @empty
                                    @endforelse

                                      @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                                      @if($_in_item_key==0)
                                              @php
                                         $warenty_name= $in_itemVal_multi->_warrant->_name ?? '';
                                          @endphp

                                          @if($warenty_name !='')
                                          <br>
                                         <b>Warranty:</b>  {{ $in_itemVal_multi->_warrant->_name ?? '' }}
                                          @endif
                                    @endif

                                          @empty
                                    @endforelse
                                          </td>
                                          <td class="text-center  " style="white-space:nowrap;vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                             @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                  {!! $in_itemVal_multi->_items->_units->_name ?? '' !!}
                              @endif
                              @empty
                              @endforelse
                                        </td>
                                           
                                            
                                             <td class="text-center  " style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                          @php
                           $row_qty =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_qty +=($in_itemVal_multi->_qty ?? 0);
                             @endphp
                          @empty
                          @endforelse

                                   {!! _report_amount($row_qty ?? 0) !!}
                                            </td>
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                             @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                              @if($_in_item_key==0)
                                 {!! _report_amount($in_itemVal_multi->_sales_rate ?? 0) !!}
                              @endif
                              @empty
                              @endforelse
                                              
                                            </td>
                                            <td class="text-right  display_none" style="vertical-align: text-top;border: 1px solid silver;vertical-align:top;">
                            @php
                           $row_discount_amount =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_discount_amount +=($in_itemVal_multi->_discount_amount ?? 0);
                             @endphp
                          @empty
                          @endforelse

                                  {!! _report_amount($row_discount_amount ?? 0) !!}

                                            </td>
                                            <td class="text-right display_none " style="vertical-align: text-top;border: 1px solid silver;">
                            @php
                           $row_vat_amount =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row_vat_amount +=($in_itemVal_multi->_vat_amount ?? 0);
                             @endphp
                          @empty
                          @endforelse
                                              {!! _report_amount($row_vat_amount ?? 0) !!}

                                            </td>
                                            
                                            <td class="text-right  " style="vertical-align: text-top;border: 1px solid silver;">
                            @php
                           $row__value =0;
                          @endphp
                          @forelse($_item as $_in_item_key=>$in_itemVal_multi)
                            @php
                                 $row__value +=($in_itemVal_multi->_value ?? 0);
                             @endphp
                          @empty
                          @endforelse



                                              {!! _report_amount($row__value ?? 0) !!}</td>
                                            
                                            
                                    
                              @endif
                                         
                                  </tr>
                                  @php
                                  $id++;
                                  @endphp


                                  @empty
                                  @endforelse
                            <tr>
                              <td colspan="3" class="text-right " style="border: 1px solid silver;"><b>Total</b></td>
                              <td class="text-right " style="border: 1px solid silver;"> <b>{{ _report_amount($_qty_total ?? 0)}}</b> </td>
                              <td style="border: 1px solid silver;"></td>
                              <td class="text-right display_none" style="border: 1px solid silver;"> <b>{{ _report_amount($_total_discount_amount ?? 0)}}</b> </td>
                              <td class="text-right display_none" style="border: 1px solid silver;"> <b>{{ _report_amount($_vat_total ?? 0)}}</b> </td>
                              <td class=" text-right" style="border: 1px solid silver;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-left " style="width: 50%;border:1px solid silver;">
                              <table style="width: 100%">
                                <tr>
                                  <td>

                                    {{$settings->_sales_note ?? '' }}
                                  </td>
                                </tr>
                                <tr>
                                  <td><p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p></td>
                                </tr>
                                <tr>
                                  <td>
                                    @include("backend.sales.invoice_history")
                                  </td>
                                </tr>
                              </table>
                              </td>
                              
                              <td colspan="5" class=" text-right"  style="width: 50%;">
                                  <table style="width: 100%;">
                                     <tr >
                                      <th style="border:1px solid silver;" class="text-right" ><b>Sub Total</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Discount[-]</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>VAT[+]</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Net Total</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount($data->_total ?? 0) !!}</th>
                                    </tr>
                                    @php
                                    $accounts = $data->s_account ?? [];
                                    $_due_amount =$data->_total ?? 0;
                                    @endphp
                                    @if(sizeof($accounts) > 0)
                                    @foreach($accounts as $ac_val)
                                    @if($ac_val->_ledger->id !=$data->_ledger_id)
                                     @if($ac_val->_cr_amount > 0)
                                     @php
                                      $_due_amount +=$ac_val->_cr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Invoice Due </b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Previous Balance</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
                                    </tr>
                                    <tr>
                                      <th style="border:1px solid silver;" class="text-right" ><b>Current Balance</b></th>
                                      <th style="border:1px solid silver;" class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
                                    </tr>
                                    @endif
                                  </table>

                              </td>
                            </tr>
         @endif
        </tbody>
        <tfoot>
@if($_is_footer ==1)
               <tr>
                 <td colspan="8">
                    <div class="col-12 mt-5">
                  <div class="row">
                    <div class="col-4 text-left " >
                        <div style="height:120px;width:100%;"></div>
                      <span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;">Customer Signature</span>
                    </div>
                    <div class="col-4"></div>
                    
                    <div class="col-4 text-center " >
                     <div style="height: 120px;width:auto; ">
                        <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$form_settings->_seal_image ?? ''}}"   />
                     </div> 
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
  </div>
  </section>
   

   @endsection

@section('script')

@endsection