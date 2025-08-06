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
 <a class="nav-link"  href="{{url('sales')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('sales-edit')
    <a class="nav-link"  title="Edit" href="{{ route('sales.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
     
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        {{ $settings->_top_title ?? '' }}
        <h2 class="page-header">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
        <h4 class="text-center"><b>Money Receipt </b></h4>
      </div>
      <!-- /.col -->
      
      
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table  style="width: 100%;border:1px solid silver;">
         
          
         
          <tbody>
           
            <tr style="border: 1px solid silver;">
              <td colspan="2" style="border: 1px solid silver;">
                <table style="width: 100%">
                  <tr><td><b>Received From:</b>{{ $data->_ledger->_name ?? '' }}</td> </tr>
                  <tr><td><b>Address:</b>{{ $data->_ledger->_address ?? '' }}</td> </tr>
                  <tr><td><b>Phone:</b>{{ $data->_ledger->_phone ?? '' }}</td> </tr>
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
            
          <tr style="border: 1px solid silver;">
            <td style="border: 1px solid silver;font-weight: bold;">Receipt Type</td>
            <td style="border: 1px solid silver;font-weight: bold;">Narration</td>
            <td style="border: 1px solid silver;font-weight: bold;" class="text-right">Amount</td>
          </tr>
          @php
          $_total_amount=0;
          @endphp
           @forelse($data->s_account as $detail_key=>$detail)
          
            @if($detail->_dr_amount > 0)
             @php
          $_total_amount +=$detail->_dr_amount ?? 0;
          @endphp
          <tr style="border: 1px solid silver;">
            
            <td style="border: 1px solid silver;">{!! $detail->_ledger->_name ?? '' !!}</td>
            
            <td style="border: 1px solid silver;">{!! $detail->_short_narr ?? '' !!}</td>
            <td style="border: 1px solid silver;" class="text-right" >{!! _report_amount(  $detail->_dr_amount ?? 0 ) !!}</td>
             
          </tr>
          @endif

          @empty
          @endforelse
          <tr style="border: 1px solid silver;" >
              <td  style="border: 1px solid silver;" colspan="2" class="text-right"><b>Total</b></td>
              <td  style="border: 1px solid silver;"  class="text-right" ><b>{!! _report_amount($_total_amount ?? 0) !!}</b></td>
            </tr>
            <tr style="border:none;">
              <td colspan="3" style="border:none;height: 10px;"></td>
            </tr>

            <tr style="border:none;">
              <td colspan="2" class="text-left" style="border:none;">
                <table class="table table-bordered">
                  @php
                  $voucher_master_id = $data->id;
                  $_table_name = 'sales_accounts';
                  $receive_ledger = $data->_ledger_id;
                  $collected_amount = 0;

                  $cash_group = $settings->_cash_group ?? 0;
                  $_bank_group = $settings->_bank_group ?? 0;

                    $customer_accuont_lastrow =\DB::table('accounts')
                        ->where('_ref_master_id',$voucher_master_id)
                        ->where('_table_name',$_table_name)
                        ->where('_account_ledger',$receive_ledger)
                        ->where('_status',1)
                        ->orderBy('id','DESC')
                        ->first();
                  $collected_amount =\DB::table('accounts')
                        ->where('_ref_master_id',$voucher_master_id)
                        ->where('_table_name',$_table_name)
                        ->whereIn('_account_group',[$cash_group,$_bank_group])
                        ->where('_status',1)
                        ->orderBy('id','DESC')
                        ->SUM('_dr_amount');
                       // dump($collected_amount);
                        
                $befor_row= $customer_accuont_lastrow->id ?? 0; 

                  $previous_balance = \DB::select("SELECT SUM(t1._dr_amount-t1._cr_amount) as _balance FROM accounts as t1 WHERE t1._account_ledger=$receive_ledger AND t1.id < $befor_row AND _status=1 ");
                  @endphp
                  <tr>
                    <td>Previous Balance</td>
                    <td>{{ _show_amount_dr_cr(_report_amount($previous_balance[0]->_balance ?? 0)) }}</td>
                  </tr>
                  <tr>
                    <td>Collected</td>
                    <td>{{ _show_amount_dr_cr(_report_amount(-($collected_amount ?? 0))) }}</td>
                  </tr>
                  <tr>
                    <td>Net Balance</td>
                    @php
                      $net_balance= (($previous_balance[0]->_balance ?? 0)+(-($collected_amount ?? 0)));
                    @endphp
                    <td>{{ _show_amount_dr_cr(_report_amount( $net_balance ?? 0)) }}</td>
                  </tr>
                </table>
              </td>
              <td>
                
              </td>
            </tr>

            <tr>
              <td colspan="3" class="text-left"><b>In Words: </b>{{ nv_number_to_text( $_total_amount ?? 0) }}</td>
            </tr>
            <tr>
              <td colspan="3" class="text-left"><b>Narration:</b> {{ $data->_note ?? '' }}</td>
            </tr>
          
          </tbody>
          <tfoot>
            
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

     
      
                <div class="row">
                    <div class="col-4 text-left " style="margin-bottom: 50px;">
                      <span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;">Customer Signature</span>
                    </div>
                    <div class="col-4"></div>
                    @php
                    $form_settings=\DB::table('sales_form_settings')->first();
                    $_seal_image =$form_settings->_seal_image ?? '';
                    @endphp
                    
                    <div class="col-4 text-center " style="margin-bottom: 50px;">
                      @if($form_settings->_seal_image !='')
                     <div style="height: 120px;width:auto; ">
                        <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$form_settings->_seal_image ?? ''}}"   />
                     </div> <br>
                     @endif
                      <span style="border-bottom: 1px solid #f5f9f9;border-top: 1px solid #000;"> Authorised Signature</span>
                    </div>
                
                 
      
    </div>
    <!-- /.row -->
  </section>

@endsection