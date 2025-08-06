<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
  <link rel="stylesheet" href="{{asset('css/print_css.css')}}">
  <!-- Site Title -->
  <title>{{$page_name ?? '' }}</title>
</head>


<body >


 

 <div style="page-break-after: always;">
  <table class="table" style="width:100%;border-collapse: collapse;">
   <thead>
      <tr>
        <td colspan="8" style="padding-bottom: 10px;">
          <div style="width: 100%;position: relative;">
            <div class="logo_araa">
               <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px"  >
            </div>
            <div class="company_name_area">
               <div style="padding-right: 10px;">
                 <div class="company_name_title">{{$settings->title ?? '' }}</div>
               <div class="company_sub_title">{{$settings->keywords ?? '' }}</div><br>
               <div class="invoice_title_area" style="text-align: right;">
                 <span class="invoice_title">{{$page_name ?? '' }}</span>
               </div>
               </div>
            </div>
            <div class="company_address_area">
              <div style="padding-left: 20px;">
                 
               <div>
                 {{$settings->_address ?? '' }}
                  {{$settings->_phone ?? '' }}
                  {{$settings->_email ?? '' }}  
               </div><br>

               <div class="page_copy_araa">
               </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
       
      <tr>
        <td colspan="4"  style="border: 1px solid silver;">
          
         <table style="width:100%;border-collapse:collapse;">
            <tr>
              <td colspan="2" style="width:100%;"> <span class="ledger_info_header">Supplier Information</span></td>
            </tr>
            
            <tr>
              <td style="width:30%;">{{__('label._supplier_id')}}</td>
              <td style="width:70%;">:{{$data->_ledger->_code ?? $data->_ledger->id }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label._supplier_name')}}  </td>
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
        </td>
        <td colspan="4" style="border: 1px solid silver;">
          <table style="width:100%;border-collapse:collapse;">
            <tr>
              <td style="width:50%;">Purchase Order No</td>
              <td style="width:50%;">:{{ $data->_purchase_order_display->_order_number ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">Purchase Order Date</td>
              <td style="width:50%;">:{!! _view_date_formate($data->_purchase_order_display->_date ?? '') !!}</td>
            </tr>
            <tr>
              <td style="width:50%;">Purchase Invoice No</td>
              <td style="width:50%;">:{{ $data->_order_number ?? '' }}</td>
            </tr>
            
            <tr>
              <td style="width:50%;">Purchase Invoice Date</td>
              <td style="width:50%;">:{!! _view_date_formate($data->_date ?? '') !!}</td>
            </tr>
            <tr>
              <td style="width:50%;">REF</td>
              <td style="width:50%;">:{{ $data->_referance ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:30%;">{{__('label._branch_id')}}</td>
              <td style="width:70%;">:{!! $data->_master_branch->_name ?? ''  !!}</td>
            </tr>
          </table>
        </td>
      </tr>
    </thead>

    <tbody>
       
    <tr>
        
        <td colspan="8" >
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
      
      </tr>
     
       <tr>
         <th style="width: 5%;border:1px solid silver;">SL</th>
         <th style="width: 25%;border:1px solid silver;text-align: left;">Name of Product</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Pack Size</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Unit</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Quantity</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Unit Price</th>
         <th style="width: 15%;border:1px solid silver;white-space: nowrap;">Discount</th>
         <th style="width: 15%;border:1px solid silver;white-space: nowrap;">Total Amount</th>
       </tr>

       @php
      $_master_details = $data->_master_details ?? [];
      $_value_total=0;
      $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
      
       @endphp

       @forelse($_master_details as $key=>$val)

       @php
                                      $_value_total +=$val->_value ?? 0;
                                      $_vat_total += $val->_vat_amount ?? 0;
                                      $_qty_total += $val->_qty ?? 0;
                                      $_total_discount_amount += $val->_discount_amount ?? 0;
                                     @endphp
       <tr>
         <td style="width: 5%;border:1px solid silver;">{{($key+1)}}</td>
         <td style="width: 35%;border:1px solid silver;text-align: left;">{!! $val->_items->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;">{!! $val->_items->_pack_size->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;">{!! $val->_trans_unit->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_qty ?? 0) !!}</td>
         <td style="width: 10%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_rate ?? 0) !!}</td>
         <td style="width: 15%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_discount_amount ?? 0) !!}</td>
         <td style="width: 15%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_value ?? 0) !!}</td>
         
       </tr>

       @empty
       @endforelse
         <tr>
                              <td colspan="4" class="text-right " style="border:1px solid silver;text-align: right;"><b>Total</b></td>
                              <td class="text-right " style="border:1px solid silver;text-align: right;"> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
                              <td style="border:1px solid silver;text-align: right;"></td>
                              <td class="text-right " style="border:1px solid silver;text-align: right;"> <b>{{ _report_amount($_total_discount_amount ?? 0) }}</b> </td>
                              <td class=" text-right" style="border:1px solid silver;text-align: right;"><b> {{ _report_amount($_value_total ?? 0) }}</b>
                              </td>
                            </tr>
       <tr>
         <td colspan="4" style="padding-top:10px;">
           In Word: {{ nv_number_to_text( $data->_total ?? 0) }}
         </td>
         <td colspan="4" style="padding-top:10px;text-align: right;">
              <table style="width: 100%;border-collapse:collapse;">
                                     <tr>
                                      <th class="text-right" style="border:1px solid silver;text-align: right;"><b>Sub Total</b></th>
                                      <th class="text-right"  style="border:1px solid silver;text-align: right;">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
                                    </tr>
                                   
                                    <tr>
                                      <th class="text-right"  style="border:1px solid silver;text-align: right;"><b>Discount</b></th>
                                      <th class="text-right"  style="border:1px solid silver;text-align: right;">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
                                    </tr>
                                   
                                    @if($form_settings->_show_vat==1)
                                    <tr>
                                      <th class="text-right"  style="border:1px solid silver;text-align: right;"><b>VAT</b></th>
                                      <th class="text-right"  style="border:1px solid silver;text-align: right;">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
                                    </tr>
                                    @endif
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b>Net Total</b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _report_amount($data->_total ?? 0) !!}</th>
                                    </tr>
                                     @php
                                    $accounts = $data->purchase_account ?? [];
                                    $_due_amount =$data->_total ?? 0;
                                    @endphp
                                    @if(sizeof($accounts) > 0)
                                    @foreach($accounts as $ac_val)
                                    @if($ac_val->_ledger->id !=$data->_ledger_id)
                                     @if($ac_val->_cr_amount > 0)
                                     @php
                                      $_due_amount -=$ac_val->_cr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b> Less:{!! $ac_val->_ledger->_name ?? '' !!}
                                        </b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _report_amount( $ac_val->_cr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif
                                    @if($ac_val->_dr_amount > 0)
                                     @php
                                      $_due_amount +=$ac_val->_dr_amount ?? 0;
                                     @endphp
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b> Add:{!! $ac_val->_ledger->_name ?? '' !!}
                                        </b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _report_amount( $ac_val->_dr_amount ?? 0 ) !!}</th>
                                    </tr>
                                    @endif

                                    @endif
                                    @endforeach
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b>Invoice Balance </b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _report_amount( $_due_amount) !!}</th>
                                    </tr>

                                    @endif
                                    @if($form_settings->_show_p_balance==1)
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b>Previous Balance</b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0))  !!}</th>
                                    </tr>
                                    <tr>
                                      <th  style="border:1px solid silver;text-align: right;" ><b>Current Balance</b></th>
                                      <th  style="border:1px solid silver;text-align: right;">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0) ) !!}</th>
                                    </tr>
                                    @endif
                                  </table>
         </td>
       </tr>
       
                
    </tbody>



    <tfoot class="inv_template_footer">
     <tr>
        <td colspan="2">
          <div class="inv_footer_arrea_left">
            <span class="sing_section">Received By  </span>
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
        <td colspan="2">
          <div class="inv_footer_arrea_right" style="white-space:nowrap;">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="8">
          <table style="width:100%;">
            <td style="text-align: left;"><span style="color:#baa5c9">Print Date: {{date('d M Y') }}</span></td>
            <td style="text-align:center;padding-left: 30px;"><span style="font-size:24px;color: #B18B07;font-weight: bold;font-family: cursive;">Thank You for your Business</span></td>
            <td style="text-align:right;padding-left: 50px;">Print Time: {{ date('h:i:s a') }}</td>
          </table>
          
        </td>
        
      </tr>
      
    </tfoot>
  </table>
</div>


<script type="text/javascript">
  window.print();
</script>
</body>


</html>

     

    


     

   

  


