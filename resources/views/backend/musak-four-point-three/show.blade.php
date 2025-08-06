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
 <a class="nav-link"  href="{{url('musak-four-point-three')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('musak-four-point-three-edit')
    <a class="nav-link"  title="Edit" href="{{ route('musak-four-point-three.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
       @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">

     <!-- <div class="row">
      <div class="col-12">
       <h3 class="page-header">
        <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->title ?? '' }}
        <small class="float-right">Date: {!! _view_date_formate($data->_date ?? '') !!}</small>
       </h3>
      </div>

     </div> -->

     <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
       
       <address>
        <span><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 60px"  > {{$settings->name ?? '' }}</span><br>
        
        Address: {{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}<br>
        BIN:  {{$settings->_bin ?? '' }}<br>
        TIN:  {{$settings->_bin ?? '' }}<br>
        Date:  {{ _view_date_formate($data->_date ?? '') }}<br>
       </address>
      </div>

      <div class="col-sm-4 invoice-col text-center">
       <b>{!! $page_name ?? '' !!}</b>
      </div>

      <div class="col-sm-4 invoice-col text-right">
       <b>Mushak 4.3</b><br>
       
      </div>

     </div>

    


     <div class="row">
      <div class="col-12 table-responsive">
       <table class="table table-bordered ">
       
          <tr>
            <th>SL</th>
            <th>HS CODE</th>
            <th>Product Description</th>
            <th>Unit</th>
            <th colspan="5" class="text-center">Row material and paking detail</th>
            <th colspan="2">Details of value addition</th>
            <th>Remarks</th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Detail</th>
            <th>Amount <br> including<br> depreciation</th>
            <th>Purchase<br> Price</th>
            <th>Amount of<br>depreciation</th>
            <th>Percentage<br>rate</th>
            <th>Value added<br>tax</th>
            <th>Price</th>
            <th></th>
          </tr>
          <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
          </tr>
        
        <tbody>
          <tr>
             <td>1</td>
             <td>{{$data->_items->_code ?? '' }}</td>
             <td>{{$data->_items->_name ?? '' }}</td>
             <td>{{$data->_items->_units->_name ?? '' }}</td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
           </tr>
          @php
          $input_details = $data->input_detail ?? [];
          $addition_details = $data->addition_detail ?? [];
           $input_number = sizeof($input_details);
          $addition_number = sizeof($addition_details);
          if( intval($input_number) > intval($addition_number)){
             $_row_number = $input_number;
          }else{
               $_row_number = $addition_number;
            }
            $_total_value_with_wastage=0;
            $_total_value = 0;
            $_total_wastage_amount = 0;
            $_total_addition_amount=0;
          @endphp
          @for ($i = 0; $i < intval($_row_number); $i++) 

          @php
             $_total_value_with_wastage +=( $input_details[$i]->_value ?? 0 ) + ($input_details[$i]->_wastage_amt ?? 0);
            $_total_value += $input_details[$i]->_value ?? 0;
            $_total_wastage_amount += $input_details[$i]->_wastage_amt ?? 0;
            $_total_addition_amount +=$addition_details[$i]->_amount ?? 0;
          @endphp
           <tr>
             
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td >{{$input_details[$i]->_input_item->_name ?? '' }}</td>
             <td class="text-right">{{ _report_amount(( $input_details[$i]->_value ?? 0 ) + ($input_details[$i]->_wastage_amt ?? 0)) }}</td>
             <td class="text-right">{{_report_amount( $input_details[$i]->_value ?? 0 )}}</td>
             <td class="text-right">{{_report_amount( $input_details[$i]->_wastage_amt ?? 0 )}}</td>
             <td class="text-right">{{_report_amount( $input_details[$i]->_wastage_rate ?? 0 )}}</td>
             <td >{{$addition_details[$i]->_addition_ledger->_name ?? '' }}</td>
             <td class="text-right">
              @if($addition_details[$i]->_amount ?? 0 > 0)
              {{ _report_amount($addition_details[$i]->_amount ?? 0) }}
              @endif
            </td>
             <td></td>
           </tr>
           @endfor
        </tbody>
        <tfoot>
          <tr>
             
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td class="text-center"><b>Total</b></td>
             <td class="text-right"><b>{{ _report_amount($_total_value_with_wastage) }}</b></td>
             <td class="text-right"><b>{{ _report_amount($_total_value) }}</b></td>
             <td class="text-right"><b>{{ _report_amount( $_total_wastage_amount ?? 0 ) }}</b></td>
             <td></td>
             <td></td>
             <td class="text-right"><b>{{ _report_amount( $_total_addition_amount ?? 0) }}</b></td>
             <td><b>{{ _report_amount($_total_value_with_wastage + $_total_addition_amount) }}</b></td>
           </tr>
              <tr style="border: none !important;">
                <td colspan="12" class="text-right" style="height: 50px;border: 0px #fff;"><b>Name of person responsible for establishment:{{$data->_responsiable_per->_name ?? '' }}&ensp;&ensp;     </b></td>
              </tr>
              <tr style="border: none !important;">
                <td colspan="12" class="text-right" style="height: 50px;border: 0px #fff;"><b>Designation:______________________________</b></td>
              </tr>
              <tr style="border: none !important;">
                <td colspan="12" class="text-right" style="height: 50px;border: 0px #fff;"><b>Signature:_________________________________</b></td>
              </tr>
              <tr style="border: none !important;">
                <td colspan="12" class="text-right" style="height: 50px;border: 0px #fff;"><b>Seal:_________________________________</b></td>
              </tr>
        </tfoot>
       </table>
      </div>

     </div>

   

   @endsection

@section('script')


@endsection