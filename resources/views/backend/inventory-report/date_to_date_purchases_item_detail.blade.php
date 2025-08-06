@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-body filter_body" >
               <form  action="{{url('date_to_date_purchases_item_detail')}}" method="GET">
                @csrf
                    <div class="row">
                      @include('basic.report_date_filter')
                      @include('basic.org_report')
                     

                    </div>
                    
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('date_to_date_purchases_item_detail')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>




@if($request->has('_datex') && $request->has('_datey'))

@php

$_datex = change_date_format($request->_datex ?? '');
$_datey = change_date_format($request->_datey ?? '');
$organization_id = $request->organization_id ?? '';
$_branch_id = $request->_branch_id ?? '';
$_cost_center = $request->_cost_center ?? '';

@endphp

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b>{{$settings->name ?? '' }}</b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
<?php
$sequence_to_remove = "––------------–--";
?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
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
        <table class="table" style="border:1px solid silver;width: 100%;margin-bottom: 0px !important;">
         <thead>
           <tr>
             <th class="border_silver">SL</th>
             <th class="border_silver">{{__('label._date')}}</th>
             <th class="border_silver">{{__('label._order_number')}}</th>
             <th class="border_silver">{{__('label._code')}}</th>
             <th class="border_silver">{{__('label._ledger_id')}}</th>
             <th class="border_silver">Item Code</th>
             <th class="border_silver">{{__('label._item')}}</th>
             <th class="border_silver">{{__('label._barcode')}}</th>
             <th class="border_silver">{{__('label._qty')}}</th>
             <th class="border_silver">{{__('label._transection_unit')}}</th>
             <th class="border_silver">{{__('label._rate')}}</th>
             <th class="border_silver">{{__('label._value')}}</th>

           </tr>
         </thead>
         <tbody>
          @php
          $_grand_sub_total = 0;
          $_grand_total_discount = 0;
          $_grand_total_vat = 0;
          $_grand_total = 0;
          $_grand_qty = 0;
          $_grand_value = 0;
          @endphp
          @forelse($datas as $key=>$data)
           <tr>
             <td colspan="9" class="text-bold border_silver">{{$key ?? '' }}</td>
           </tr>

          @php
          $_sub_sub_total = 0;
          $_sub_total_discount = 0;
          $_sub_total_vat = 0;
          $_sub_total = 0;
          $_sub_qty = 0;
          $_sub_value = 0;
          @endphp
           @forelse($data as $_d_key=>$val)

           @php
          if($key=='Sales'){
                   $_grand_sub_total +=$val->_sub_total ?? 0;
                    $_grand_total_discount +=$val->_total_discount ?? 0;
                    $_grand_total_vat +=$val->_total_vat ?? 0;
                    $_grand_total +=$val->_total ?? 0;

                      $_grand_qty  +=$val->_qty ?? 0;
                      $_grand_value +=$val->_value ?? 0;

          }else{
                   $_grand_sub_total -=$val->_sub_total ?? 0;
                    $_grand_total_discount -=$val->_total_discount ?? 0;
                    $_grand_total_vat -=$val->_total_vat ?? 0;
                    $_grand_total     -=$val->_total ?? 0;
                    $_grand_qty     -=$val->_qty ?? 0;
                    $_grand_value   -=$val->_value ?? 0;
          }
          $_sub_sub_total +=$val->_sub_total ?? 0;
          $_sub_total_discount +=$val->_total_discount ?? 0;
          $_sub_total_vat +=$val->_total_vat ?? 0;
          $_sub_total +=$val->_total ?? 0;
          $_sub_qty     +=$val->_qty ?? 0;
          $_sub_value   +=$val->_value ?? 0;


          @endphp

     <tr>
             <td class="border_silver">{{($_d_key+1)}}</td>
             <td class="border_silver"  style="white-space:nowrap;">{{$val->_date }}</td>
             <td class="border_silver"  style="white-space:nowrap;">{{$val->_order_number ?? '' }}</td>
             <td class="border_silver"  style="white-space:nowrap;">{{$val->_code ?? '' }}</td>
             <td class="border_silver">{{$val->_name ?? '' }}</td>
             <td class="border_silver">{{$val->item_code ?? '' }}</td>
             <td class="border_silver">{{$val->_item_name ?? '' }}</td>
             <td class="border_silver">{{$val->_barcode ?? '' }}</td>
             <td class="border_silver">{{_report_amount($val->_qty ?? 0 )}}</td>
             <td class="border_silver">{{$val->_tran_unit ?? '' }}</td>
             <td class="border_silver text-right">{{_report_amount($val->_sales_rate ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_value ?? 0 )}}</td>
             
           </tr>

           @empty
           @endforelse
          <tr>
             <th class="border_silver" colspan="7">Total {{$key ?? '' }}</th>
             <th class="border_silver"></th>
             <th class="border_silver text-right">{{_report_amount($_sub_qty)}}</th>
             <th class="border_silver"></th>
             <th class="border_silver"></th>
             <th class="border_silver text-right">{{_report_amount($_sub_value)}}</th>
           </tr>
           @empty
           @endforelse




            <tr>
             <th class="border_silver " colspan="7">Net Total [Purchase - Purchase Return]</th>
             <th class="border_silver "></th>
            <th class="border_silver ">{{_report_amount($_grand_qty)}}</th>
             <th class="border_silver text-right"></th>
             <th class="border_silver "></th>
             <th class="border_silver text-right">{{_report_amount($_grand_value)}}</th>
           </tr>
         </tbody>

         
          <tfoot>
            <tr style="border:none;">
              <td colspan="10" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

  @endif



@endsection

@section('script')

<script type="text/javascript">

    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


     function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            
          }
     

  })


</script>
@endsection

