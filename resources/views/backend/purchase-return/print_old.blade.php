
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$page_name}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <style type="text/css">
    .display_none{
    display: none;
}
  </style>
  <style type="text/css">
    .table td, .table th {
        padding: .15rem !important;
        vertical-align: top;
        border: 1px solid #CCCCCC;
    }
  </style>
</head>
<body>
<div class="wrapper">

<section class="invoice">
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 33%;text-align: left;">
              <table class="table" style="border:none;">
                  <tr> <td style="border:none;" > <b>INVOICE NO: {{ $data->id ?? '' }}</b></td></tr>
                <tr> <td style="border:none;" > <b> Supplier:</b>  {{$data->_ledger->_name ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Phone:</b>  {{ $data->_phone ?? '' }} </td></tr>
                <tr> <td style="border:none;" > <b> Address:</b> {{ $data->_address ?? '' }} </td></tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr> <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_address ?? '' }}</b></td></tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_phone ?? '' }}</b>,<b>{{$settings->_email ?? '' }}</b></td></tr>
                 <tr> <td class="text-center" style="border:none;"><b>{{$page_name}} Invoice</b></td> </tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: right;">
              <table class="table" style="border:none;">
                  <tr> <td class="text-right" style="border:none;"  > <b>Time:</b> {{$data->_time ?? ''}} </td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Created By:</b> {{$data->_user_name ?? ''}}</td></tr>
                  <tr> <td class="text-right"  style="border:none;" > <b>Branch:</b> {{$data->_master_branch->_name ?? ''}} </td></tr>
              </table>
            </td>
          </tr>
        </table>
        </div>
      </div>
    
      <div class="row">
        <div class="col-12 table-responsive">
         
            @if(sizeof($data->_master_details) > 0)
                        
                              <table class="table">
                                <thead >
                                            <th class="text-middle" >SL</th>
                                            <th class="text-middle" >Item</th>
                                           @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                            <th class="text-middle" >Barcode</th>
                                            @else
                                            <th class="text-middle display_none" >Barcode</th>
                                            @endif
                                            @endif
                                            <th class="text-right" >Qty</th>
                                            <th class="text-right" >Rate</th>
                                            <th class="text-right" >Sales Rate</th>
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <th class="text-right" >VAT%</th>
                                            <th class="text-right" >VAT</th>
                                             @else
                                            <th class="text-right display_none" >VAT%</th>
                                            <th class="text-right display_none" >VAT Amount</th>
                                            @endif
                                            @endif

                                            <th class="text-right" >Value</th>
                                             @if(sizeof($permited_branch) > 1)
                                            <th class="text-middle" >Branch</th>
                                            @else
                                            <th class="text-middle display_none" >Branch</th>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <th class="text-middle" >Cost Center</th>
                                            @else
                                             <th class="text-middle display_none" >Cost Center</th>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <th class="text-middle" >Store</th>
                                            @else
                                             <th class="text-middle display_none" >Store</th>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <th class="text-middle" >Shelf</th>
                                            @else
                                             <th class="text-middle display_none" >Shelf</th>
                                            @endif
                                            @endif
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td class="" >{{($item_key+1)}}</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                     @endphp
                                            <td class="" >{!! $_item->_items->_name ?? '' !!}</td>
                                           @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                            <td class="" >{!! $_item->_barcode ?? '' !!}</td>
                                            @else
                                            <td class=" display_none" >{!! $_item->_barcode ?? '' !!}</td>
                                            @endif
                                            @endif
                                            <td class="text-right" >{!! $_item->_qty ?? 0 !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_rate ?? 0) !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <td class="text-right" >{!! $_item->_vat ?? 0 !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                             @else
                                            <td class="text-right display_none" >{!! $_item->_vat ?? 0 !!}</td>
                                            <td class="text-right display_none" >{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            @endif
                                            @endif

                                            <td class="text-right" >{!! _report_amount($_item->_value ?? 0) !!}</td>
                                             @if(sizeof($permited_branch) > 1)
                                            <td class="" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @else
                                            <td class=" display_none" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <td class="" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <td class="" >{!! $_item->_store->_name ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_store->_name ?? '' !!}</td>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <td class="" >{!! $_item->_store_salves_id ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_store_salves_id ?? '' !!}</td>
                                            @endif
                                            @endif
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td>
                                                
                                              </td>
                                              <td  class="text-right"><b>Total</b></td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif
                                              <td class="text-right">
                                                <b>{{ $_qty_total ?? 0}}</b>
                                                


                                              </td>
                                              <td></td>
                                              <td></td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td></td>
                                              <td class="text-right">
                                                <b>{{_report_amount($_vat_total ?? 0)}}</b>
                                              </td>
                                              @else
                                              <td class="display_none"></td>
                                              <td class="text-right display_none">
                                                 <b>{{ _report_amount($_vat_total ?? 0) }}</b>
                                              </td>
                                              @endif
                                              @endif
                                              <td class="text-right">
                                               <b> {{ _report_amount($_value_total ?? 0) }}</b>
                                              </td>
                                              @if(sizeof($permited_branch) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif

                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td></td>
                                              @else
                                              @endif
                                              <td class="display_none"></td>
                                              @endif
                                            </tr>
                                </tfoot>
                              </table>
                           
                          </div>
                        </td>
                        </tr>
                        @endif
         
      </div>
      <div class="row">
      <div class="col-12 table-responsive">
        <table class="table">
          
          <tbody>
           
          <tr>
            <th class="text-right" ><b>Sub Total</b></th>
            <th class="text-right">{!! _report_amount($data->_sub_total ?? 0) !!}</th>
          </tr>
         
          <tr>
            <th class="text-right" ><b>Discount</b></th>
            <th class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
          </tr>
         
          @if($form_settings->_show_vat==1)
          <tr>
            <th class="text-right" ><b>VAT</b></th>
            <th class="text-right">{!! _report_amount($data->_total_vat ?? 0) !!}</th>
          </tr>
          @endif
          <tr>
            <th class="text-right" ><b>NET Total</b></th>
            <th class="text-right">{!! _report_amount($data->_total ?? 0) !!}</th>
          </tr>
          @if($form_settings->_show_p_balance==1)
          <tr>
            <th class="text-right" ><b>Previous Balance</b></th>
            <th class="text-right">{!! _report_amount($data->_p_balance ?? 0) !!}</th>
          </tr>
          <tr>
            <th class="text-right" ><b>Current Balance</b></th>
            <th class="text-right">{!! _report_amount($data->_l_balance ?? 0) !!}</th>
          </tr>
          @endif
          </tbody>
          
        </table>
      </div>
      <!-- /.col -->
    </div>

    <!-- Table row -->
    @if(sizeof($data->purchase_account) > 0)
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table">
          <thead>
          <tr>
            <th>ID</th>
            <th>Ledger</th>
            <th>Branch</th>
            <th>Cost Center</th>
            <th>Short Narr.</th>
            <th class="text-right" >Dr. Amount</th>
            <th class="text-right" >Cr. Amount</th>
          </tr>
          </thead>
          <tbody>
            @php
            $_total_dr_amount =0;
            $_total_cr_amount =0;
            @endphp
            @forelse($data->purchase_account as $detail_key=>$detail)
          <tr>
            <td>{!! $detail->id ?? '' !!}</td>
            <td>{!! $detail->_ledger->_name ?? '' !!}</td>
            <td>{!! $detail->_detail_branch->_name ?? '' !!}</td>
            <td>{!! $detail->_detail_cost_center->_name ?? '' !!}</td>
            <td>{!! $detail->_short_narr ?? '' !!}</td>
            <td class="text-right" >{!! _report_amount( $detail->_dr_amount ?? 0 ) !!}</td>
            <td class="text-right" >{!! _report_amount($detail->_cr_amount ?? 0 )!!}</td>
              @php
            $_total_dr_amount +=$detail->_dr_amount ?? 0;
            $_total_cr_amount +=$detail->_cr_amount ?? 0;
            @endphp
          </tr>
          @empty
          @endforelse
          
          </tbody>
          <tfoot>
            <tr>
              <th  colspan="5" class="text-right">Total:</th>
              <th  class="text-right" >{!! _report_amount($_total_dr_amount ?? 0) !!}</th>
              <th  class="text-right" >{!! _report_amount($_total_cr_amount ?? 0) !!}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    @endif

    <div class="row">
    
       @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>

</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>