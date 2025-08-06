
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('item-replace')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('item-replace-edit')
    <a class="nav-link"  title="Edit" href="{{ route('item-replace.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    
    
    <!-- /.row -->
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 33%;text-align: left;">
              <table class="table" style="border:none;">
                  <tr> <td style="border:none;" > <b>INVOICE NO: {{ $data->_order_number ?? '' }}</b></td></tr>
                  <tr> <td style="border:none;" > <b>Date: </b>{{ _view_date_formate($data->_date ?? '') }}</td></tr>
                <tr> <td style="border:none;" > <b> Customer:</b>  {{$data->_ledger->_name ?? '' }}</td></tr>
                <tr> <td style="border:none;" > <b> Phone:</b>  {{$data->_phone ?? '' }} </td></tr>
                <tr> <td style="border:none;" > <b> Address:</b> {{$data->_address ?? '' }} </td></tr>
              </table>
            </td>
            <td style="border:none;width: 33%;text-align: center;">
              <table class="table" style="border:none;">
                <tr> <td class="text-center" style="border:none;font-size: 24px;">{{ $settings->_top_title ?? '' }}<br></td> </tr>
                <tr> <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_address ?? '' }}</b></td></tr>
                <tr> <td class="text-center" style="border:none;"><b>{{$settings->_phone ?? '' }}</b>,<b>{{$settings->_email ?? '' }}</b></td></tr>
                 <tr> <td class="text-center" style="border:none;"><h3>{{$page_name}} </h3></td> </tr>
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
                        
                              <table class="table _grid_table">
                                <thead >
                                            <th class="text-middle "  >SL</th>
                                            <th class="text-middle "  >Item</th>
                                            <th class="text-middle  @if($form_settings->_show_barcode==0) display_none @endif"  >Barcode</th>
                                            <th class="text-right "  >Qty</th>
                                            <th class="text-right "  >Rate</th>
                                            <th class="text-right @if($form_settings->_show_vat==0) display_none @endif"  >VAT%</th>
                                            <th class="text-right @if($form_settings->_show_vat==0) display_none @endif"  >VAT Amount</th>
                                            <th class="text-right  @if($form_settings->_inline_discount==0) display_none @endif"  >Dis%</th>
                                            <th class="text-right  @if($form_settings->_inline_discount==0) display_none @endif"  >Discount</th>
                                            <th class="text-right "  >Value</th>
                                            <th class="text-middle   @if(sizeof($permited_branch) ==1) display_none @endif "  >Branch</th>
                                             <th class="text-middle   @if(sizeof($permited_costcenters) ==1) display_none @endif "  >Cost Center</th>
                                             <th class="text-middle  @if(sizeof($store_houses) ==1) display_none @endif"  >Store</th>
                                             <th class="text-middle @if($form_settings->_show_self==0) display_none @endif"  >Shelf</th>
                                            
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <td class="" >{{($item_key+1)}}</td>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                      $_total_discount_amount += $_item->_discount_amount ?? 0;
                                     @endphp
                                            <td class="  " >{!! $_item->_items->_name ?? '' !!}</td>
                                            <td class="   @if($form_settings->_show_barcode==0) display_none @endif" >

                                               @php
                                          $barcode_arrays = explode(',', $_item->_barcode ?? '');
                                          @endphp
                                          @forelse($barcode_arrays as $barcode)
                                        <span>{{$barcode}}</span><br>
                                          @empty
                                          @endforelse
                                             
                                            </td>
                                            <td class="text-right  " >{!! $_item->_qty ?? 0 !!}</td>
                                            <td class="text-right  " >{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            <td class="text-right   @if($form_settings->_show_vat==0) display_none @endif" >{!! $_item->_vat ?? 0 !!}</td>
                                            <td class="text-right   @if($form_settings->_show_vat==0) display_none @endif" >{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            <td class="text-right   @if($form_settings->_inline_discount==0) display_none @endif" >{!! $_item->_discount ?? 0 !!}</td>
                                            <td class="text-right   @if($form_settings->_inline_discount==0) display_none @endif" >{!! $_item->_discount_amount ?? 0 !!}</td>
                                            <td class="text-right  " >{!! _report_amount($_item->_value ?? 0) !!}</td>
                                            <td class=" @if(sizeof($permited_branch) == 1)  display_none @endif" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                             <td class="@if(sizeof($permited_costcenters) == 1)  display_none @endif" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                             <td class=" @if(sizeof($store_houses) == 1)  display_none @endif" >{!! $_item->_store->_name ?? '' !!}</td>
                                             <td class="@if($form_settings->_show_self==0) display_none @endif" >{!! $_item->_store_salves_id ?? '' !!}</td>
                                            
                                           
                                          
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td class="">
                                                
                                              </td>
                                              <td  class="text-right "><b>Total</b></td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right  display_none"></td>
                                             @endif
                                            @endif
                                              <td class="text-right ">
                                                <b>{{ $_qty_total ?? 0}}</b>
                                                


                                              </td>
                                              <td class="display_none"></td>
                                              <td class=""></td>
                                              
                                              <td class=" @if($form_settings->_show_vat==0) display_none @endif "></td>
                                              <td class=" text-right @if($form_settings->_show_vat==0) display_none @endif ">
                                                 <b>{{ _report_amount($_vat_total ?? 0) }}</b>
                                              </td>
                                              
                                            <td class=" text-right @if($form_settings->_inline_discount==0) display_none @endif " ></td>
                                            <td class=" text-right @if($form_settings->_inline_discount==0) display_none @endif " ><b>{!! $_total_discount_amount ?? 0 !!}</b></td>
                                            
                                              <td class=" text-right">
                                               <b> {{ _report_amount($_value_total ?? 0) }}</b>
                                              </td>
                                               <td class=" @if(sizeof($permited_branch) == 1) display_none @endif"></td>
                                               <td class=" @if(sizeof($permited_costcenters) == 1) display_none @endif"></td>
                                               <td class=" @if(sizeof($store_houses) == 1) display_none @endif"></td>
                                              <td class="@if($form_settings->_show_self==0) display_none @endif "></td>
                                             
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
            <th class="text-right" ><b> Discount[-]</b></th>
            <th class="text-right">{!! _report_amount($data->_total_discount ?? 0) !!}</th>
          </tr>
         
          @if($form_settings->_show_vat==1)
          <tr>
            <th class="text-right" ><b>VAT[+] </b></th>
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
            <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)) !!}</th>
          </tr>
          <tr>
            <th class="text-right" ><b>Current Balance</b></th>
            <th class="text-right">{!! _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)) !!}</th>
          </tr>
          @endif


          
          </tbody>
          
        </table>
      </div>
      <!-- /.col -->
    </div>
     <!-- Table row -->
    @if(sizeof($data->s_account) > 0)
    <div class="row">
      <div class="col-12 table-responsive">
        <span><b>Account Details</b></span>
        <table class="table">
          <thead>
          <tr>
            <th>ID</th>
            <th>Ledger</th>
            
            <th class="text-right" >Dr. Amount</th>
            <th class="text-right" >Cr. Amount</th>
          </tr>
          </thead>
          <tbody>
            @php
            $_total_dr_amount =0;
            $_total_cr_amount =0;
            @endphp
            @forelse($data->s_account as $detail_key=>$detail)
            
          <tr>
            <td>{!! $detail->id ?? '' !!}</td>
            <td>{!! $detail->_ledger->_name ?? '' !!}</td>
            
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
              <th  colspan="2" class="text-right">Total:</th>
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
    <div class="col-12">
       
        <p class="lead"> <b>In Words:  {{ nv_number_to_text($data->_total ?? 0) }} </b></p>
        @include("backend.sales.invoice_history")
      </div>
      
      <!-- /.col -->
      @include('backend.message.invoice_footer')
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection