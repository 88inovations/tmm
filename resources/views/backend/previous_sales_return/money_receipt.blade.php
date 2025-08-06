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
                <span class="page_copy_title">Office Copy</span>
               </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
       
      
    </thead>

    <tbody>
       
    <tr>
        
        <td colspan="8" >
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
      
      </tr>    
    </tbody>
<tr>
  <tr style="border: 1px solid silver;">
              <td colspan="2" style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td><b>Paid To:</b>{{ $data->_ledger->_name ?? '' }}</td> </tr>
                  <tr><td><b>Address:</b>{{ $data->_address ?? '' }}</td> </tr>
                  <tr><td><b>Phone:</b>{{ $data->_phone ?? '' }}</td> </tr>
                </table>
              </td>
              <td style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td>
                    <b>Invoice No: {{ $data->_order_number ?? '' }}</b><br>
                    <b>Date:</b>  {{ _view_date_formate($data->_date ?? '') }}  {{$data->_time ?? ''}}<br>
                    <b>Created By:</b> {{$data->_user_name ?? ''}}<br>
                    <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
                  </td></tr>
                </table>
              </td>
            </tr>
</tr>
<tr style="border: 1px solid silver;">
            <td style="border: 1px solid silver;font-weight: bold;">Payment Type</td>
            <td style="border: 1px solid silver;font-weight: bold;">Narration</td>
            <td style="border: 1px solid silver;font-weight: bold;" class="text-right">Amount</td>
          </tr>
 @php
          $_total_amount=0;
          @endphp
           @forelse($data->purchase_account as $detail_key=>$detail)
          
            @if($detail->_cr_amount > 0)
             @php
          $_total_amount +=$detail->_cr_amount ?? 0;
          @endphp
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail->_ledger->_name ?? '' !!}</td>
            
            <td style="border: 1px solid silver;">{!! $detail->_short_narr ?? '' !!}</td>
            <td style="border: 1px solid silver;" class="text-right" >{!! _report_amount( $detail->_cr_amount ?? 0 ) !!}</td>
             
          </tr>
          @endif

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;" colspan="2" class="text-right"><b>Total</b></td>
              <th  style="border: 1px solid silver;"  class="text-right" ><b>{!! _report_amount($_total_amount ?? 0) !!}</b></th>
            </tr>

            <tr>
              <td colspan="3" class="text-left"><b>In Words: </b>{{ nv_number_to_text( $_total_amount ?? 0) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-left"><b>Narration:</b> {{ $data->_note ?? '' }}</td>
            </tr>

<tr>
        <td >
          <div class="inv_footer_arrea_left" style="padding-top:50px;">
            <span class="sing_section">Received By  </span>
          </div>
        </td>
        <td >
          <div class="inv_footer_arrea_center" style="padding-top:50px;">
            <span class="sing_section"> Checked by</span>
          </div>
        </td>
        
        <td >
          <div class="inv_footer_arrea_right" style="white-space:nowrap;padding-top:50px;">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="3" style="padding-bottom:60px;">
          <table style="width:100%;">
            <td style="text-align: left;"><span style="color:#baa5c9">Print Date: {{date('d M Y') }}</span></td>
            <td style="text-align:center;padding-left: 30px;"><span style="font-size:24px;color: #B18B07;font-weight: bold;font-family: cursive;">Thank You for your Business</span></td>
            <td style="text-align:right;padding-left: 50px;">Print Time: {{ date('h:i:s a') }}</td>
          </table>
          
        </td>
        
      </tr>
   </tbody>

    <!-- Customer Copy and Office Copy -->
    <thead  style="width: 100%;border-top: 2px dotted #000;padding-top: 40px;">
      <tr>
        <td colspan="3" style="padding-bottom: 10px;">
          <div style="width: 100%;position: relative;">
            <div class="logo_araa">
               <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px"  >
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
                <span class="page_copy_title">Supplier Copy
                   
                 </span>
               </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
       
      
    </thead>

    <tbody>
       
    <tr>
        
        <td colspan="8" >
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
      
      </tr>    
    </tbody>
<tr>
  <tr style="border: 1px solid silver;">
              <td colspan="2" style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td><b>Paid To:</b>{{ $data->_ledger->_name ?? '' }}</td> </tr>
                  <tr><td><b>Address:</b>{{ $data->_address ?? '' }}</td> </tr>
                  <tr><td><b>Phone:</b>{{ $data->_phone ?? '' }}</td> </tr>
                </table>
              </td>
              <td style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td>
                    <b>Invoice No: {{ $data->_order_number ?? '' }}</b><br>
                    <b>Date:</b>  {{ _view_date_formate($data->_date ?? '') }}  {{$data->_time ?? ''}}<br>
                    <b>Created By:</b> {{$data->_user_name ?? ''}}<br>
                    <b>Branch:</b> {{$data->_master_branch->_name ?? ''}}
                  </td></tr>
                </table>
              </td>
            </tr>
</tr>
<tr style="border: 1px solid silver;">
            <td style="border: 1px solid silver;font-weight: bold;">Payment Type</td>
            <td style="border: 1px solid silver;font-weight: bold;">Narration</td>
            <td style="border: 1px solid silver;font-weight: bold;text-align: right;" class="text-right">Amount</td>
          </tr>
 @php
          $_total_amount=0;
          @endphp
           @forelse($data->purchase_account as $detail_key=>$detail)
          
            @if($detail->_cr_amount > 0)
             @php
          $_total_amount +=$detail->_cr_amount ?? 0;
          @endphp
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail->_ledger->_name ?? '' !!}</td>
            
            <td style="border: 1px solid silver;">{!! $detail->_short_narr ?? '' !!}</td>
            <td style="border: 1px solid silver;text-align: right;" class="text-right" >{!! _report_amount( $detail->_cr_amount ?? 0 ) !!}</td>
             
          </tr>
          @endif

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;" colspan="2" class="text-right"><b>Total</b></td>
              <th  style="border: 1px solid silver;text-align: right;"  class="text-right" ><b>{!! _report_amount($_total_amount ?? 0) !!}</b></th>
            </tr>

            <tr>
              <td colspan="3" class="text-left"><b>In Words: </b>{{ nv_number_to_text( $_total_amount ?? 0) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-left"><b>Narration:</b> {{ $data->_note ?? '' }}</td>
            </tr>


    
     <tr>
        <td >
          <div class="inv_footer_arrea_left" style="padding-top:50px;">
            <span class="sing_section">Received By  </span>
          </div>
        </td>
        <td >
          <div class="inv_footer_arrea_center" style="padding-top:50px;">
            <span class="sing_section"> Checked by</span>
          </div>
        </td>
        
        <td >
          <div class="inv_footer_arrea_right" style="white-space:nowrap;padding-top:50px;">
            <span class="sing_section"> Authorized Signature</span>
          </div>
        </td>
        
      </tr>
      <tr>
        <td colspan="3">
          <table style="width:100%;">
            <td style="text-align: left;"><span style="color:#baa5c9">Print Date: {{date('d M Y') }}</span></td>
            <td style="text-align:center;padding-left: 30px;"><span style="font-size:24px;color: #B18B07;font-weight: bold;font-family: cursive;">Thank You for your Business</span></td>
            <td style="text-align:right;padding-left: 50px;">Print Time: {{ date('h:i:s a') }}</td>
          </table>
          
        </td>
        
      </tr>
      
   
  </table>
</div>


<script type="text/javascript">
  window.print();
</script>
</body>


</html>

     

    


     

   

  


