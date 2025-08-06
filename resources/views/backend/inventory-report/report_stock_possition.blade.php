@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('stock-possition')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <br/><b>@foreach($permited_branch as $p_branch)
                      @if(isset($previous_filter["_branch_id"]))
                        @if($p_branch->id==$previous_filter["_branch_id"]) 
                       <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>    
                        @endif
                      @endif
                      @endforeach </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
@php

$_datex = change_date_format($previous_filter["_datex"] ?? '');
$_datey = change_date_format($previous_filter["_datey"] ?? '');
$organization_id = $previous_filter["organization_id"] ?? '';
$_branch_id =  $previous_filter["_branch_id"] ?? '';
$_cost_center =$previous_filter["_cost_center"] ??   '';

@endphp
 <table class="table" style="border:none;width: 100%;margin-bottom: 0px !important;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-bottom: 0px !important;">
                


                <tr style="border:none;">
                  <td style="border:none;">
                      <table class="table" >
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Date </th>
                          <td style="width:90%;text-align: left;border: none;">:{{date('d-m-Y')}} </td>
                          
                         
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label.organization_id')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ id_to_cloumn($organization_id,'_name','companies') }} </td>
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label._branch_id')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ id_to_cloumn($_branch_id,'_name','branches') }} </td>
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label._cost_center')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ id_to_cloumn($_cost_center,'_name','cost_centers') }} </td>
                        </tr>
                       
                        

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Subject </th>
                          <td style="width:90%;text-align: left;border: none;">:{{$page_name ?? ''}} </td>
                         
                        </tr>

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Business Period       </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ _view_date_formate($_datex)}}  To  {{_view_date_formate($_datey)}} </td>
                         
                        </tr>
                      </table>
                  </td>
                </tr>
              </table>
            </td>
            
          </tr>
        </table>
    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             
            <th>SL</th>
            <th >Item Code </th>
            <th >Item Name </th>
            <th style="width: 10%;">Unit</th>
            <th style="width: 10%;" class="text-right">Opening</th>
            <th style="width: 10%;" class="text-right">Stock In</th>
            <th style="width: 10%;" class="text-right">Stock Out</th>
            <th style="width: 10%;" class="text-right">Closing</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">Remarks</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
              $_total_opening = 0;
              $_total_stockin = 0;
              $_total_stockout = 0;
              $_sub_total_opening = 0;
              $_sub_total_stockin = 0;
              $_sub_total_stockout = 0;
              $_sub_total_balance = 0;
              $_total_balance = 0;
               $remove_duplicate_branch=array();
            @endphp
            @forelse($group_array_values as $key=>  $g_value)

            @php
             $_sub_total_opening += $g_value->_opening;
              $_sub_total_stockin += $g_value->_stockin;
              $_sub_total_stockout += $g_value->_stockout;
              $_sub_total_balance += ($g_value->_opening+$g_value->_stockin+$g_value->_stockout);

              $_total_opening += $g_value->_opening;
              $_total_stockin += $g_value->_stockin;
              $_total_stockout += $g_value->_stockout;
              $_total_balance += ($g_value->_opening+$g_value->_stockin+$g_value->_stockout);
            @endphp
            <tr>
             

            <td class="white_space">{!! ($key+1) !!}  </td>
            <td class="white_space">{!! $g_value->_code ?? '' !!}  </td>
            <td class="white_space"> {!! $g_value->_name ?? '' !!} </td>
            <td style="width: 10%;">{!! $g_value->_unit ?? '' !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_opening) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_stockin) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_stockout) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount(($g_value->_opening+$g_value->_stockin+$g_value->_stockout)) !!}</td>
            @php
            $base_unit_qty=($g_value->_opening+$g_value->_stockin+$g_value->_stockout);
            $unit_conversions =\DB::table("unit_conversions")->where("_item_id",$g_value->_item_id)->where("_status",1)->get();
            @endphp
            
            <td style="width: 10%;" class="text-right">
                <table class="table" style="border:none;">
                    
                
                @forelse($unit_conversions as $conversion)
                  <tr>
                      <td>{{  _report_amount($base_unit_qty/($conversion->_conversion_qty ?? 0) )   }} </td>
                      <td>{{ $conversion->_conversion_unit_name ?? '' }}</td>
                      <td>{{ $conversion->_conversion_qty ?? 0 }}*{{ _find_unit($conversion->_base_unit_id ?? 0 ) }}={{$conversion->_conversion_unit_name ?? ''}}</td>
                  </tr>
                @empty
                @endforelse
                </table>
                
                </td>
            
            <td></td>
          </tr>
          @empty
          @endforelse

         

          
          <tr>
            

            <th colspan="4" class="text-left" >Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_opening) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_stockin) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_stockout) !!}</th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_total_balance) !!}</th>
            <td></td>
            <td></td>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="10">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')


@endsection
