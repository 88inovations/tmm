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
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('dm_receive_from_stock')}}" method="GET">
                @csrf
                    <div class="row">
                      <div class="col-md-6">
                      <label>Start Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input" data-target="#reservationdate" required @if(isset($previous_filter["_datex"])) value='{{$previous_filter["_datex"] }}' @endif  />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                              @if(isset($previous_filter["_datex"]))
                              <input type="hidden" name="_old_filter" class="_old_filter" value="1">
                              @else
                              <input type="hidden" name="_old_filter" class="_old_filter" value="0">
                              @endif
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label>End Date:</label>
                        <div class="input-group date" id="reservationdate_2" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_2" data-target="#reservationdate_2" required @if(isset($previous_filter["_datey"])) value='{{$previous_filter["_datey"] }}' @endif  />
                                      <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                      </div>
                      @include('basic.org_report')
                   
              
                      <div class="col-md-12">
                        <label>{{__('label._store_id')}}:</label>
                         <select class="form-control  _store "  name="_store"  >
                              <option value="all"><---All {{__('label._store_id')}}--></option>
                            @forelse($stores as $store )
                            <option value="{{$store->id}}" 
                              @if(isset($previous_filter["_store"]))
                              $previous_filter["_store"])) selected @endif
                              > {{ $store->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                      <div class="col-md-12">
                        <label>{{__('label._category_id')}}:</label>
                         <select class="form-control  _category_id "  name="_category_id"  >
                              <option value=""><---All {{__('label._category_id')}}--></option>
                            @forelse($item_categories as $category )
                            <option value="{{$category->id}}" 
                              @if(isset($previous_filter["_category_id"]))
                              $previous_filter["_category_id"])) selected @endif
                              > {{ $category->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                      <div class="col-md-12">
                        <label>{{__('label._customer_id')}}:</label>
                         <select class="form-control  _customer_id "  name="_customer_id"  >
                              <option value=""><---All {{__('label._customer_id')}}--></option>
                            @forelse($customer_ledgers as $customer )
                            <option value="{{$customer->id}}" 
                              @if(isset($previous_filter["_customer_id"]) && $previous_filter["_customer_id"]==$customer->id) selected @endif
                              > {{ $customer->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
    
                 
                    </div>
                    
                    <div class="row">
                      <label>Items:</label><br>
                    </div>
                     <div class="row">
                         <select id="_item_id" class="form-control  _item_id select2"  name="_item_id[]"   multiple>
                          
                          @forelse($items as $key=>$item)
                          <option value="{{$item->_item_id}}" @if(isset($previous_filter["_item_id"]))
                              @if(in_array($item->_item_id,$previous_filter["_item_id"])) selected @endif
                                 @endif >{{ $item->_item_name ?? ''  }}</option>
                          @empty
                          @endforelse
                         </select>
                     </div>

                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('dm_receive_from_stock')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>


@if(sizeof($group_array_values) > 0)
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <div class="_report_button_header">
    
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
  @if(isset($previous_filter["_branch_id"]) && $p_branch->id==$previous_filter["_branch_id"]) 
   <span style="background: #f4f6f9;margin-right: 2px;padding: 5px;"><b>{{ $p_branch["_name"] }}</b></span>
  @endif
  @endforeach  </b></td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             

            <th>{{__('label.sl')}} </th>
            <th style="width: 10%;">{{__('label.id')}}</th>
            <th style="width: 10%;">{{__('label._customer_id')}}</th>
            <th style="width: 10%;">{{__('label._date')}}</th>
            <th style="width: 10%;">{{__('label._item')}}</th>
            <th style="width: 10%;">{{__('label._unit_id')}}</th>
            <th style="width: 10%;" class="text-right">{{__('label._qty')}}</th>
            <th style="width: 10%;" class="text-right">{{__('label._sales_rate')}}</th>
            <th style="width: 10%;" class="text-right">{{__('label._value')}}</th>
          </tr>
          
          
          </thead>
          <tbody>
            @php
             
              $_total_stockin = 0;
              $_total_stockout = 0;
              $_total_balance = 0;
               $remove_duplicate_branch=array();
            @endphp
            @forelse($group_array_values as $key=>$_detail)
            @php
              $key_arrays = explode("__",$key);
             $_branch_id =  $key_arrays[0];
             $_cost_center_id =  $key_arrays[1];
             $_store_id =  $key_arrays[2];
             $_category_id =  $key_arrays[3];
              @endphp
             @if(!in_array($key,$remove_duplicate_branch))
            <tr>
              @php
                array_push($remove_duplicate_branch,$key);
              @endphp
              <th colspan="9">





            @if(sizeof($_branch_ids) > 1 )
              {{ _branch_name($_branch_id) }} |
             @endif
             @if(sizeof($_cost_center_ids) > 1 )
                {{ _cost_center_name($_cost_center_id) }} |
             @endif
             @if(sizeof($stores) > 1 )
                {{ _store_name($_store_id) }} |
             @endif
            
              
              </th>
            </tr>
            @endif

            @php
              $_sub_total_qty = 0;
              $_sub_total_value = 0;
              $row_counter =0;
            @endphp
            @forelse($_detail as $g_value)

            @php
              $row_counter +=1;
              $_sub_total_qty += $g_value->_qty;
              $_sub_total_value += $g_value->_value;
            @endphp
            <tr>
             

            
            <td style="width: 5%;">{!! $row_counter !!} </td>
            <td style="width: 7%;white-space: nowrap;">
              <a href="{{url('damage_receive/print')}}/{{$g_value->id}}">
              {!! $g_value->_order_number ?? '' !!} </a>
               </td>
            <td style="width: 10%;">{{ $g_value->_code ?? '' }} {{ $g_value->_ledger_name ?? '' }} </td>
            <td style="width: 10%;">{!! _view_date_formate($g_value->_date ?? '') !!}</td>
            <td style="width: 10%;">{{ $g_value->_item_name ?? '' }} </td>

            <td style="width: 10%;">{!! _find_unit($g_value->_transection_unit) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_qty) !!}</td>
            <td style="width: 10%;" class="text-right">{!! _report_amount($g_value->_sales_rate) !!}</td>
            <td style="width: 10%;" class="text-right">{{ _report_amount( $g_value->_value) }}</td>
          </tr>
          @empty
          @endforelse
@if($row_counter > 1)
          <tr>
           

            <th colspan="6" class="text-left" >Sub Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_value) !!}</th>
          </tr>
@endif
          @empty
          @endforelse
          <tr>
           

            <th colspan="6" class="text-left">Grand Total </th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_qty) !!}</th>
            <th style="width: 10%;" class="text-right"></th>
            <th style="width: 10%;" class="text-right">{!! _report_amount($_sub_total_value) !!}</th>
          </tr>
            
            
          </tbody>
          <tfoot>
            <tr>
              <td colspan="7">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

</div>
<!-- ENd of Report Part -->

@endif





    </div>  
</div>



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

    var _item_category_ids = $(document).find('._item_category').val();
    if(_item_category_ids?.length > 0){
      _category_base_items(_item_category_ids);
    }

$(document).find('._item_category').on('change',function(){
    var _category_id = $(this).val();
    _category_base_items(_category_id);
    
  })

    function _category_base_items(_category_id){
      var request = $.ajax({
          url: "{{url('stock-ledger-cat-item')}}",
          method: "GET",
          data: { _category_id : _category_id },
          dataType: "HTML"
        });
      request.done(function( result ) {
        $("#_item_id").html(result);
        });
         
        request.fail(function( jqXHR, textStatus ) {
         console.log(textStatus)
        });
    }
     

  })

  


        

         

</script>
@endsection

