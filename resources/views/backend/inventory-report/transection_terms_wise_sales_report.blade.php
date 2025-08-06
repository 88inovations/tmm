@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="text-center">{{ $page_name ?? '' }}</h4>
                 @include('backend.message.message')
            </div>
          
         @php

$_datex = change_date_format($request->_datex ?? '');
$_datey = change_date_format($request->_datey ?? '');
$organization_id = $request->organization_id ?? '';
$_branch_id = $request->_branch_id ?? '';
$_cost_center = $request->_cost_center ?? '';
$_sales_man_id = $request->_sales_man_id ?? '';
$_invoice_type = $request->_invoice_type ?? 'all';

@endphp
            <div class="card-body filter_body" >
               <form  action="{{url('transection_terms_wise_sales_report')}}" method="GET">
                @csrf
                    <div class="row">
                         <input type="hidden" name="_form_name" class="_form_name" value="transection_terms_wise_sales_report">
                       @include('basic.report_date_filter')
                      @include('basic.org_report')
                     
                     

                    </div>
                    
                     <div class="row">
                      <div class="col-md-12">
                          <label>{{__('label._sales_man_id')}}:</label>
                         <select class="form-control width_150_px _sales_man_id _sales_man"  name="_sales_man_id"   >
                       @if(sizeof($sales_persons) > 1)
                            <option value=""> {{__('label._sales_man_id')}}</option>
                      @endif
                            @forelse($sales_persons as $sales_man )
                            <option value="{{$sales_man->id}}" 
                              @if(isset($previous_filter["_sales_man_id"]) && $sales_man->id==$previous_filter["_sales_man_id"]) selected @endif
                                 
                              > {{ $sales_man->_code ?? '' }} |{{ $sales_man->_name ?? '' }} | {{ $sales_man->b_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-12">
                          <label>{{__('label.transection_terms')}}:</label>
                         <select class="form-control width_150_px transection_terms "  name="transection_terms"   >
                       
                            <option value=""> {{__('label.transection_terms')}}</option>
                        
                            @forelse($transection_terms as $trans )
                            <option value="{{$trans->id}}" 
                              @if(isset($previous_filter["transection_terms"]) && $trans->id==$previous_filter["transection_terms"]) selected @endif
                                 
                              > {{ $trans->_name ?? '' }} | {{ $trans->_days ?? '' }} Days </option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-12">
                          <label>{{__('label._invoice_type')}}:</label>
                         <select class="form-control width_150_px _invoice_type "  name="_invoice_type"   >
                       
                            <option value="all" @if($_invoice_type=='all') selected @endif> All </option>
                            <option value="due"  @if($_invoice_type=='due') selected @endif>Due</option>
                            <option value="paid"  @if($_invoice_type=='paid') selected @endif>Paid</option>
                        
                            
                          </select>
                      </div>
                    </div>
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('transection_terms_wise_sales_report')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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
                        @if($_sales_man_id !='')
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">{{__('label._sales_man_id')}}  </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ id_to_cloumn($_sales_man_id,'_name','account_ledgers') }} </td>
                        </tr>
                       @endif
                        

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
        <table class="table" style="width: 100%;margin-bottom: 0px !important;">
         <thead>
           <tr>
             <th class="border_silver">SL</th>
             <th class="border_silver">{{__('label._date')}}</th>
             <th class="border_silver">{{__('label._order_number')}}</th>
             <th class="border_silver">{{__('label._code')}}</th>
             <th class="border_silver">{{__('label._ledger_id')}}</th>
             <th class="border_silver">{{__('label._phone')}}</th>
             <th class="border_silver">{{__('label._sub_total')}}</th>
             <th class="border_silver">{{__('label._total_discount')}}</th>
             <th class="border_silver">{{__('label._total_vat')}}</th>
             <th class="border_silver">{{__('label._total')}}</th>
             <th class="border_silver">{{__('label._sales_return')}}</th>
             <th class="border_silver">{{__('label._receive_amount')}}</th>
             <th class="border_silver">{{__('label._due_amount')}}</th>
             <th class="border_silver">{{__('label._is_close')}}</th>
           </tr>
         </thead>
         <tbody>
          @php
          $_grand_sub_total = 0;
          $_grand_total_discount = 0;
          $_grand_total_vat = 0;
          $_grand_total = 0;
          $_grand_sales_return = 0;
          $_grand_receive_amount = 0;
          $_grand_due_amount = 0;
          @endphp
          @forelse($datas as $key=>$data)
           <tr>
             <th class="border_silver" colspan="14" class="text-bold">{{$key ?? '' }}</th>
           </tr>

          @php
          $_sub_sub_total = 0;
          $_sub_total_discount = 0;
          $_sub_total_vat = 0;
          $_sub_total = 0;
           $_sub_sales_return = 0;
          $_sub_receive_amount = 0;
          $_sub_due_amount = 0;
          @endphp
           @forelse($data as $_d_key=>$val)

           @php
          
$_grand_sub_total +=$val->_sub_total ?? 0;
$_grand_total_discount +=$val->_total_discount ?? 0;
$_grand_total_vat +=$val->_total_vat ?? 0;
$_grand_total +=$val->_total ?? 0;

$_grand_sales_return +=$val->_sales_return ??  0;
$_grand_receive_amount +=$val->_receive_amount ?? 0;
$_grand_due_amount +=$val->_due_amount ??  0;

        
          $_sub_sub_total +=$val->_sub_total ?? 0;
          $_sub_total_discount +=$val->_total_discount ?? 0;
          $_sub_total_vat +=$val->_total_vat ?? 0;
          $_sub_total +=$val->_total ?? 0;
          $_sub_sales_return +=$val->_sales_return ??  0;
$_sub_receive_amount +=$val->_receive_amount ?? 0;
$_sub_due_amount +=$val->_due_amount ??  0;


          @endphp

      <tr>
             <td class="border_silver">{{($_d_key+1)}}</td>
             <td class="border_silver" style="white-space:nowrap;">{{$val->_date }}</td>
             <td class="border_silver" style="white-space:nowrap;">{{$val->_order_number ?? '' }}</td>
             <td class="border_silver" style="white-space:nowrap;">{{$val->_code ?? '' }}</td>
             <td class="border_silver">{{$val->_name ?? '' }}</td>
             <td class="border_silver">{{$val->_phone ?? '' }}</td>
             <td class="border_silver text-right">{{_report_amount($val->_sub_total ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_total_discount ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_total_vat ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_total ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_sales_return ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_receive_amount ?? 0 )}}</td>
             <td class="border_silver text-right">{{_report_amount($val->_due_amount ?? 0 )}}</td>
             <td class="border_silver ">
              @if($val->_is_close ==1)
                <span class="btn btn-success btn-sm">Close</span>
              @else
              <span class="btn btn-danger btn-sm">Open</span>
              @endif
             
            </td>

             


           </tr>

           @empty
           @endforelse
          <tr>
             <th class="border_silver" colspan="6">Total {{$key ?? '' }}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_sub_total)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_total_discount)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_total_vat)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_total)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_sales_return)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_receive_amount)}}</th>
             <th class="border_silver text-right">{{_report_amount($_sub_due_amount)}}</th>
             <th class="border_silver text-right"></th>
           </tr>
           @empty
           @endforelse






            <tr>
             <th class="border_silver" colspan="6">Net Total</th>
             <th class="border_silver text-right">{{_report_amount($_grand_sub_total)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_total_discount)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_total_vat)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_total)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_sales_return)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_receive_amount)}}</th>
             <th class="border_silver text-right">{{_report_amount($_grand_due_amount)}}</th>
             <th class="border_silver text-right"></th>
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

