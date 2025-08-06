
  <!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <!-- Site Title -->
  <title>{{$page_name ?? '' }}</title>
</head>
<style type="text/css">
 
 @page {
  size: A4;
  margin: 2mm 2mm 2mm 2mm;
}

@media print {
  

  .table {
    page-break-after: always;
  }

  html, body {
    width: 210mm;
    height: 297mm;
    overflow: initial;
  }

           
        
}
.lead{
  text-transform: capitalize;
}

.logo_araa{
  width: 20%;
    float: left;
}
.company_name_area{
      width: 40%;
    float: left;
}

.company_name_title{
   
    font-size: 20px;
    color: #00ff00;
    font-weight: 900;
    text-decoration: underline;

}
.company_sub_title{
  text-align: center;
    color: #ff0066;
    font-weight: bold;
}
.company_address_area{
  width: 40%;
    float: left;
}
.head_office{
  color: #ff0066;
    font-weight: bold;
    text-decoration: underline;
}
.invoice_title_area{
  text-align: right;
  margin-top: 70px;
  padding-right: 10px;

}
.invoice_title{
  font-size: 20px;
    padding: 10px;
    font-weight: bold;
    background: rebeccapurple;
    margin-top: 27px;
    color: yellow;
}
.page_copy_araa{
  text-align: center;
}
.page_copy_title {
    border: 1px solid #000;
    padding: 10px;
    border-radius: 5px;
    color: red;
    font-weight: 800;
}
.border_1px{
  border: 1px solid #000;
}
.ledger_info_header{
  font-weight: 700;
  text-decoration: underline;
}
.inv_footer_arrea_left{
  text-align: left;
}
.inv_footer_arrea_right{
  text-align: right;
}
.inv_footer_arrea_center{
  text-align: center;
}
.sing_section{
  border-top: 1px solid #000;
}
.padding_5px{
  padding:5px;
}
.background-image {
  padding-top:50px ;
   width: 400px; /* Adjust max-width as needed */
    display: block;
    margin: 0 auto;
    filter: brightness(70%); /* Adjust brightness level (0% to 100%) */
    position: absolute;
    opacity: 0.2;
    background-size: cover; /* Adjust as needed */
  background-position: center center; /* Center the background image */
}
  </style>

<body >

     
@forelse($datas as $data)




  @for($i=0; $i<2; $i++)

 <div style="min-height: 600px;page-break-after: always;">
  <table class="table" style="width:100%;border-collapse: collapse;">
    <thead>
      <tr>
        <td colspan="10">
          <div style="width: 100%;position: relative;">
            <div class="logo_araa">
               <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px"  >
            </div>
            <div class="company_name_area">
               <div class="company_name_title">{{$settings->title ?? '' }}</div>
               <div class="company_sub_title">{{$settings->keywords ?? '' }}</div><br>
               <div class="invoice_title_area">
                 <span class="invoice_title">{{$page_name ?? 'Delivery Challan'}}</span>
               </div>
            </div>
            <div class="company_address_area">
               <div class="head_office">Head Office</div>
               <address>
                 {{$settings->_address ?? '' }}
                  {{$settings->_phone ?? '' }}
                  {{$settings->_email ?? '' }}  
               </address><br>

               <div class="page_copy_araa">
                 <span class="page_copy_title">
                  @if($i==0)
OFFICE COPY
                  @else
Customer Copy
                  @endif
                   
                 </span>
               </div>
            </div>
          </div>
        </td>
      </tr>
       <tr>
        <td colspan="5"> Payment Terms: {!! $data->_terms_con->_name ?? '' !!}</td>
        <td colspan="5" style="text-align:right;">
          Vat Registration No.- {!! $settings->_bin ?? '' !!}
        </td>
      </tr>
      <tr>
        <td colspan="10"  style="width:100%;">
          <div class="border_1px " style="width:58%;float: left;margin-right: 1%;min-height: 190px;">
            <div class="padding_5px">
          <span class="ledger_info_header">Customer's Informations</span>
          <table style="width:100%;border-collapse:collapse;">
            <tr>
              <td style="width:30%;">{{__('label._branch_id')}}</td>
              <td style="width:70%;">:{!! $data->_master_branch->_name ?? ''  !!}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label._customer_id')}}</td>
              <td style="width:70%;">:{{$data->_ledger->_code ?? $data->_ledger->id }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label._customer_name')}}  </td>
              <td style="width:70%;">:{{$data->_ledger->_name ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label.Proprietor_Name')}}  </td>
              <td style="width:70%;">:{{$data->_ledger->_alious ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label.Cell_Phone_No')}}  </td>
              <td style="width:70%;">:{{$data->_phone ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label._address')}}   </td>
              <td style="width:70%;">:{{$data->_address ?? '' }}</td>
            </tr>
          </table>
        </div>
        </div>
        

        <div class="border_1px " style="width:38%;float: left;">
          <div class="padding_5px">
          <table style="width:100%">
            <tr>
              <td style="width:50%;">Sales Order No</td>
              <td style="width:50%;">:{{ $data->_order_ref_id ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Sales Invoice No</td>
              <td style="width:50%;">:{{ $data->_order_number ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Sales Invoice Type</td>
              <td style="width:50%;">:{{ $data->_terms_con->_name ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Sales Invoice Date</td>
              <td style="width:50%;">:{!! _view_date_formate($data->_date ?? '') !!}</td>
            </tr>
            <tr>
              <td style="width:50%;">Payment Date</td>
              <td style="width:50%;">:{{ _view_date_formate($data->payment_date ?? '') }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Sales Person</td>
              <td style="width:50%;">:{{ $data->_sales_man->_name ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Delivery Person</td>
              <td style="width:50%;">:{{ $data->_delivery_man->_name ?? '' }}</td>
            </tr>
            
            <tr>
              <td style="width:50%;">{{__('label.Delivery_Date')}}</td>
              <td style="width:50%;">:{{ _view_date_formate($data->_delivery_date ?? '') }}</td>
            </tr>
          </table>
        </div>
        </td>
      </tr>
    </thead>

    <tbody>
       
      <tr>
        <td colspan="2" style="height:30px;">
         
        </td>
        <td colspan="5" style="height:30px;">
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
        <td colspan="3" style="height:30px;">
          
        </td>
      </tr>
       <tr>
          <th style="border:1px solid silver;width: 5%;" class="text-left">SL</th>
          <th style="border:1px solid silver;width: 40%;text-align:left;" class="text-left">Name of Products</th>
          <th style="border:1px solid silver;width: 15%;" class="text-left">Pack Size </th>
          <th style="border:1px solid silver; width: 10%;" class="text-right">Quantity</th>
          <th style="border:1px solid silver; width: 10%;" class="text-right">{{__('label._is_free')}}</th>
          <th style="border:1px solid silver; width: 20%" class="text-right">TP. Price</th>
          <th style="border:1px solid silver; width: 20%" class="text-right">Total Amount</th>
          <th colspan="2" style="border:1px solid silver; width: 20%" class="text-right">Cash Discount</th>
          <th  style="border:1px solid silver; width: 20%" class="text-right">Net Amount</th>
         </tr>

          @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                    $_gross_net_total = 0;
                                  @endphp

           
         @php
$_master_details_news = $data->_master_details_new ?? [];
$qty_sum=0;
$number_of_items = sizeof($_master_details_news);
$add_new_row = 12-$number_of_items;
         @endphp
@forelse($_master_details_news  as $key=>$val)
 @php
                                      $_value_total +=$val->_value ?? 0;
                                      $_vat_total += $val->_vat_amount ?? 0;
                                      $_qty_total += $val->_qty ?? 0;
                                      $_total_discount_amount += $val->_discount_amount ?? 0;
                                      $_gross_net_total  += (($val->_value ?? 0)- ($val->_discount_amount ?? 0));
                                     @endphp
         <tr>
          <td style="border:1px solid silver;width: 5%;text-align: center;" class="text-center">{{($key+1)}}</td>
          <td style="border:1px solid silver;width: 40%;text-align: left;" class="text-left">{!! $val->_items_inv->_item ?? '' !!}</td>
          <td style="border:1px solid silver;width: 15%;text-align: center;" class="text-center">{!! $val->_items_inv->_pack_size->_name ?? '' !!}</td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">{{$val->_qty ?? 0 }} {{$val->_trans_unit->_name ?? '' }}</td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            @if($val->_is_free==1) FREE @endif
          </td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            {{_report_amount($val->_sales_rate ?? 0)}}
          </td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            {{_report_amount($val->_value ?? 0)}}
          </td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            {{_report_amount($val->_discount ?? 0)}}%
          </td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            {{_report_amount($val->_discount_amount ?? 0)}}
          </td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">
            {{_report_amount((($val->_value ?? 0)- ($val->_discount_amount ?? 0)))}}
          </td>
         </tr>
          @php
$qty_sum +=$val->_qty ?? 0;
         @endphp
      
@empty
@endforelse
@if($add_new_row > 0)
      @for($j=0; $j<=$add_new_row; $j++)
      <tr>
        <td style="height:20px;border-right:1px solid silver;border-left:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
        <td style="height:20px;border-right:1px solid silver;" ></td>
      </tr>

      @endfor

      @endif
<!--  <tr>
                              <td colspan="3" class="text-right " style="border:1px solid silver; text-align: center;"><b>Total</b></td>
                              <td class="text-right " style="border:1px solid silver; text-align: center;"> <b>{{_report_amount( $_qty_total ?? 0)}}</b> </td>
                              <td style="border:1px solid silver; text-align: center;"></td>
                              <td style="border:1px solid silver; text-align: center;"></td>
                              <td class=" text-right" style="border:1px solid silver; text-align: center;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              <td class=" text-right" style="border:1px solid silver; text-align: center;"></td>
                              <td class="text-right " style="border:1px solid silver; text-align: center;"> <b>{{_report_amount( $_total_discount_amount ?? 0) }}</b> </td>
                              <td class="text-right " style="border:1px solid silver; text-align: center;"> <b>{{ _report_amount($_gross_net_total ?? 0) }}</b> </td>
                              
                              </td>
                            </tr> -->
                            <tr>
                              <td colspan="5" class="text-left " style="width: 50%;border-top: 1px solid silver;">
                                <p class="lead"> In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </p>

                              </td>
                              
                              <td colspan="5" class=" text-right"  style="width: 50%;border-top: 1px solid silver;">
                                  <table style="width: 100%;border-collapse: collapse;">
                                     <tr>
                                      <th class="text-right"  style="border:1px solid silver;white-space: nowrap; "><b>Total Sales Amount =</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Total Cash Discount =</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>VAT[+]</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif

                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Total Payable Amount =</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount($data->_total ?? 0) !!}</th>
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
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b> {!! $ac_val->_ledger->_name ?? '' !!}[+]
                                        </b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b> {!! $ac_val->_ledger->_name ?? '' !!}[-]
                                        </b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                     @endif
                                   
                                  </table>

                              </td>
                            </tr>
                <tr>
                  <td colspan="6">
                    <table style="width: 100%">
                                <tr>
                                  <td>

                                    {{$settings->_sales_note ?? '' }} 
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                   @if($form_settings->_show_due_history==1)
@php

 $_l_balance_update = _l_balance_update($data->_ledger_id);

         $total_sales = \App\Models\Sales::where('_ledger_id', $data->_ledger_id)
                                                        ->where('_status',1)
                                                        ->sum('_total');
 
        $history_sales_invoices = [];
        $row_conter=0;
                if($total_sales >= $_l_balance_update ){
                    //return $_l_balance_update;
                //if($_l_balance_update > 0 ){
                 //if last balance gretter then 0 then go ahead
                        $_avoid_sales_ids =[];
                        $available_quantity =  0;
                         $_qty_less = $_l_balance_update;
                        do {

                            
                            if ($available_quantity < $_l_balance_update) {
                               // return $available_quantity;
                                 $due_sales_info = \App\Models\Sales::select('id','_date','_order_number','_total')
                                                    ->where('_ledger_id', $data->_ledger_id)
                                                    ->where('_total','>',0)
                                                    ->where('_status',1)
                                                    ->whereNotIn('id', $_avoid_sales_ids)
                                                    ->orderBy('id','DESC')
                                                    ->first();
                                if($due_sales_info){
                                      array_push($_avoid_sales_ids, $due_sales_info->id);

                                       $available_quantity +=$due_sales_info->_total ?? 0;

                                      if($available_quantity  >= $_l_balance_update  ){
                                        $_less_qty = ($due_sales_info->_total -( $available_quantity-$_l_balance_update )); //Last Need this qty
                                         $new_qty = $_less_qty;
                                         $due_sales_info->_due_amount = $new_qty;
                                         array_push($history_sales_invoices, $due_sales_info);
                                         
                                        }else{
                                            $due_sales_info->_due_amount = $due_sales_info->_total ?? 0;
                                            array_push($history_sales_invoices, $due_sales_info);
                                        }    
                                }
                                                            
                            }
                        } while ($available_quantity < $_l_balance_update);
                }

@endphp


@if(sizeof($history_sales_invoices) > 0) 
        <table class=" " style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="border:1px dotted grey;text-align: center;">Date</th>
              <th style="border:1px dotted grey;text-align: center;">Invoice No.</th>
              <th style="border:1px dotted grey;text-align: center;">Sales Amount</th>
              <th style="border:1px dotted grey;text-align: center;">Pending Amount</th>
              <th style="border:1px dotted grey;text-align: center;">O/D By Days</th>
            </tr>
          </thead>
          <tbody>
            @php
            $due_sales_amount=0;
            $due_due_amount =0;
            @endphp
            @forelse($history_sales_invoices as $his_val)
            @php
            $due_sales_amount +=$his_val->_total ?? 0;
            $due_due_amount +=$his_val->_due_amount ?? 0;
            @endphp
              <tr>
              <td style="border:1px dotted grey;text-align: center;">{{ _view_date_formate($his_val->_date ?? '') }}</td>
              <td style="border:1px dotted grey;text-align: center;">{{ $his_val->_order_number ?? '' }}</td>
              <td style="border:1px dotted grey;text-align: center;">{{ _report_amount($his_val->_total ?? 0) }}</td>
              <td style="border:1px dotted grey;text-align: center;">{{ _report_amount($his_val->_due_amount ?? 0) }}</td>
              <td style="border:1px dotted grey;text-align: center;">{{ _date_diff($his_val->_date,date('Y-m-d')) }}</td>
              
            </tr>
            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td style="border:1px dotted grey;text-align: center;" colspan="2"><b>Total</b></td>
              <td style="border:1px dotted grey;text-align: center;"><b>{{ _report_amount($due_sales_amount ?? 0) }}</b></td>
              <td style="border:1px dotted grey;text-align: center;"><b>{{ _report_amount($due_due_amount ?? 0) }}</b></td>
              <td style="border:1px dotted grey;text-align: center;"></td>
            </tr>
          </tfoot>
        </table>

@endif
@endif
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td></td>
                                </tr>
                              </table>
                  </td>
                  <td colspan="4">
                    <table style="width:100%;border-collapse:collapse;">
                      

                                   
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Previous Dues:</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
                                    </tr>
                                     <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Invoice Due :</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Current Dues:</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Credit Limit:</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount($data->_ledger->_credit_limit ?? 0) !!}</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; "><b>Payable Amount:</b></th>
                                      <th class="text-right" style="border:1px solid silver;white-space: nowrap; ">{!! _report_amount(($_due_amount)-($data->_ledger->_credit_limit ?? 0)) !!}</th>
                                    </tr>
                                    @endif
                    </table>
                  </td>
                </tr>
    </tbody>

    <tfoot>
      <tr>
        <td colspan="10" style="height:50px;"></td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="inv_footer_arrea_left">
            <span class="sing_section">Customer Signature with Seal  </span>
          </div>
        </td>
        <td colspan="2">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Delivered by</span>
          </div>
        </td>
        <td colspan="2">
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Accounts Signature</span>
          </div>
        </td>
        <td colspan="4">
          <div class="inv_footer_arrea_right">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="2"><span>Print Date: {{date('d M Y') }}</span></td>
        <td colspan="4" style="text-align:center;">
          <span style="font-size:24px;color: crimson;font-weight: bold;">Thank You for your Business</span>
        </td>
        <td colspan="3" style="text-align: center;"><span>Print Time: {{ date('h:i:s a') }}</td>
      </tr>
    </tfoot>
  </table>
</div>
@endfor

    
@empty
@endforelse

<script type="text/javascript">
  window.print();
</script>
</body>


</html>

   

  

