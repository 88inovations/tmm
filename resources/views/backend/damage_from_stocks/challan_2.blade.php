<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="{{$settings->name ?? ''}}">
    <link rel="stylesheet" href="{{asset('css/print_css.css')}}">
  <!-- Site Title -->
  <title>CHALLAN</title>
</head>

<body >
  @for($i=0; $i<2; $i++)
 <div style="min-height: 600px;page-break-after: always;">
  <table style="width:100%;border-collapse: collapse;">
    <thead>
      <tr>
        <td colspan="5">
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
        <td colspan="5" style="height:30px;">
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
      </tr>
      <tr>
        <td colspan="2"  style="border: 1px solid silver;">
          
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
        </td>
        <td colspan="3" style="border: 1px solid silver;">
          <table style="width:100%">
            <tr>
              <td style="width:50%;">{{__('label.Challan_Number')}}</td>
              <td style="width:50%;">:{{ $data->_order_number ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">{{__('label.Challan_Date')}}</td>
              <td style="width:50%;">:{!! _view_date_formate($data->_date ?? '') !!}</td>
            </tr>
            <tr>
              <td style="width:50%;">{{__('label.Purchase_Order_No')}}</td>
              <td style="width:50%;">:{{ $data->_sales_order->_order_number ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">{{__('label.Purchase_Order_Date')}}</td>
              <td style="width:50%;">:{{ _view_date_formate($data->_sales_order->_date ?? '') }}</td>
            </tr>
            <tr>
              <td style="width:50%;">{{__('label.Mode_of_Delivery')}}</td>
              <td style="width:50%;">:{{ $data->_mode_of_delivery ?? '' }}</td>
            </tr>
            <tr>
              <td style="width:50%;">{{__('label.Delivery_Date')}}</td>
              <td style="width:50%;">:{{ _view_date_formate($data->_delivery_date ?? '') }}</td>
            </tr>
          </table>
       
        </td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td colspan="5" style="height:30px;"></td>
      </tr>
       <tr>
          <th style="border:1px solid silver;width: 5%;" class="text-left">SL</th>
          <th style="border:1px solid silver;width: 40%;text-align:left;" class="text-left">Name of Products</th>
          <th style="border:1px solid silver;width: 15%;" class="text-center">Pack Size </th>
          <th style="border:1px solid silver; width: 10%;" class="text-center">Quantity</th>
          <th style="border:1px solid silver; width: 20%" class="text-center">Remark’s</th>
         </tr>

         @php
$_master_details_news = $data->_master_details_new ?? [];
$qty_sum=0;
$number_of_items = sizeof($_master_details_news);
$add_new_row = 24-$number_of_items;

         @endphp
@forelse($_master_details_news  as $key=>$val)
         <tr>
          <td style="border:1px solid silver;width: 5%;text-align: center;" class="text-center">{{($key+1)}}</td>
          <td style="border:1px solid silver;width: 40%;text-align: left;" class="text-left">{!! $val->_items_inv->_item ?? '' !!}</td>
          <td style="border:1px solid silver;width: 15%;text-align: center;" class="text-center">{!! $val->_items_inv->_pack_size->_name ?? '' !!}</td>
          <td style="border:1px solid silver; width: 10%;text-align: center;" class="text-right">{{$val->_qty ?? 0 }} {{$val->_trans_unit->_name ?? '' }}</td>
          <td style="border:1px solid silver; width: 20%;text-align: center;" class="text-right">Remark’s</td>
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
      </tr>

      @endfor

      @endif
<tr>
  <td colspan="2" style="border-top: 1px solid silver;">
    Received the goods as per Order & good condition  <br>                                                                                   
       Without any shortage, leakage or damage

  </td>
  <td style="border:1px solid silver;"><b>TOTAL</b></td>
  <td  style="border:1px solid silver;text-align: center;"><b>{{$qty_sum ?? 0}}</b></td>
  <td style="border:1px solid silver;text-align: center;"></td>
  
</tr>
    </tbody>

    <tfoot>
      <tr>
        <td colspan="5" style="height:180px;"></td>
      </tr>
      <tr>
        <td colspan="2">
          <div class="inv_footer_arrea_left">
            <span class="sing_section">Customer Signature (Seal & Date) </span>
          </div>
        </td>
        <td >
          <div class="inv_footer_arrea_center">
            <span class="sing_section"> Accounts</span>
          </div>
        </td>
        <td colspan="2">
          <div class="inv_footer_arrea_right">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="5">
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
@endfor
</body>


</body>

     
<script type="text/javascript">
  window.print();
</script>
    
</html>

     

   

  