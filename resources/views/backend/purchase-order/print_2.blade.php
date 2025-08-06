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
        <td colspan="8" style="padding-bottom: 10px;border-bottom: 4px solid pink;">
          <div style="width: 100%;position: relative;">
            <div class="logo_araa">
               <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px"  >
            </div>
            <div class="company_name_area">
               <div style="padding-right: 10px;">
                 <div class="company_name_title">{{$settings->title ?? '' }}</div>
               <div class="company_sub_title">{{$settings->keywords ?? '' }}</div><br>
               
               </div>
            </div>
            <div class="company_address_area">
              <div style="padding-left: 20px;">
                 <div class="head_office">Corporate Office</div>
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
     
    </thead>

    <tbody>
       
      <tr>
        
        <td colspan="8" >
          <img src="{{asset($settings->_water_mark_image ?? '')}}" class="background-image" alt="Background Image">
        </td>
      
      </tr>
       <tr>
         <td colspan="8" style="padding-top:30px;"><b>Date: </b>{{  _view_date_formate($data->_date ?? '' ) }}</td>
       </tr>
       <tr>
         <td colspan="8" ><b>REF: </b>{{  $data->_order_number ?? ''  }}</td>
       </tr>
       <tr>
         <td colspan="8" > 
          {{  $data->_ledger->_name ?? ''  }}<br>
          {{  $data->_address ?? ''  }}<br>
          {{  $data->_phone ?? ''  }}<br>

         </td>
       </tr>
        <tr>
         <td colspan="8" >Attention: {{  $data->_ledger->_alious ?? ''  }}</td>
       </tr>
        <tr>
         <td colspan="8" ><b>Subject: Supply Order for Product</b></td>
       </tr>
        <tr>
         <td colspan="8" style="padding-bottom:20px;">
          Dear Sir,<br>
          The Management of {{$settings->title ?? '' }} is pleased to issue supply order in your favor described here under:

         </td>
       </tr>
       <tr>
         <th style="width: 5%;border:1px solid silver;">SL</th>
         <th style="width: 25%;border:1px solid silver;text-align: left;">Name of Product</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Pack Size</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Unit</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Quantity</th>
         <th style="width: 10%;border:1px solid silver;white-space: nowrap;">Unit Price</th>
         <th style="width: 15%;border:1px solid silver;white-space: nowrap;">Amount</th>
         <th style="width: 15%;border:1px solid silver;white-space: nowrap;">Total Amount</th>
       </tr>

       @php
      $_master_details = $data->_master_details ?? [];
      $total_amount=0;
       @endphp

       @forelse($_master_details as $key=>$val)

        @php
   
      $total_amount  +=$val->_value ?? 0;
       @endphp
       <tr>
         <td style="width: 5%;border:1px solid silver;">{{($key+1)}}</td>
         <td style="width: 35%;border:1px solid silver;text-align: left;">{!! $val->_items->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;">{!! $val->_items->_pack_size->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;">{!! $val->_trans_unit->_name ?? '' !!}</td>
         <td style="width: 10%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_qty ?? 0) !!}</td>
         <td style="width: 10%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_rate ?? 0) !!}</td>
         <td style="width: 15%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_value ?? 0) !!}</td>
         <td style="width: 15%;border:1px solid silver;text-align: right;">{!! _report_amount($val->_value ?? 0) !!}</td>
         
       </tr>

       @empty
       @endforelse
         <tr>
         
         <td colspan="6" style="border:1px solid silver;text-align: right;">Grand Total</td>
         <td style="width: 15%;border:1px solid silver;text-align: right;"></td>
         <td style="width: 15%;border:1px solid silver;text-align: right;">{!! _report_amount($total_amount?? 0) !!}</td>
         
       </tr>
       <tr>
         <td colspan="8" style="padding-top:10px;">
           In Word: {{ nv_number_to_text( $data->_total ?? 0) }}
         </td>
       </tr>
       <tr>
         <td colspan="8" style="padding-top:10px;">
           Schedule of Supply:  {!! $data->_term_condition ?? '' !!}
         </td>
       </tr>
       <tr>
         <td colspan="8" style="padding-top:10px;">
           Place of Supply: {{$settings->title ?? '' }}, {!! $data->_master_branch->_address ?? '' !!}, {!! $data->_master_branch->_phone ?? '' !!}
         </td>
       </tr>
       <tr>
         <td colspan="8" style="padding-top:20px;">
          In view of the above, you are requested to strictly follow the required schedule and supply.<br>

           
         </td>
       </tr>
       <tr>
         <td colspan="8" style="padding-top:10px;">
          Kindly Quote our reference number and date in all of your challans, bills and your future communication.<br>
          with us if any,
          
           
         </td>
       </tr>
                
    </tbody>



    <tfoot class="inv_template_footer">
    <tr>
        <td colspan="8">
          Thanking you<br>
         Very sincerely yours<br>
        </td>
      </tr>
    <tr>
        <td colspan="8" style="padding-top:80px;">
          {!! $settings->author ?? '' !!}<br>
          {!! $settings->title ?? '' !!}<br>
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

     

    


     

   

  


