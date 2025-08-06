@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('sales-return.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('sales-return-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('sales-return.create') }}"> Add New </a>
               </li>
              @endcan
            </ol>
          </div>
          
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                <div class="row">
                   @php

                     $currentURL = URL::full();
                     $current = URL::current();
                    if($currentURL === $current){
                       $print_url = $current."?print=single";
                       $print_url_detal = $current."?print=detail";
                    }else{
                         $print_url = $currentURL."&print=single";
                         $print_url_detal = $currentURL."&print=detail";
                    }
    

                   @endphp
                    <div class="col-md-4">
                       @include('backend.sales-return.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('sales-return-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>{{__('label.organization')}}</b></th>
                         <th class=""><b>Branch</b></th>
                         <th class=""><b>Return Number</b></th>
                         <th class=""><b>Sales ID</b></th>
                         <th class=""><b>Referance</b></th>
                         <th class=""><b>Ledger</b></th>
                         <th class=""><b>Sub Total</b></th>
                         <th class=""><b>VAT</b></th>
                         <th class=""><b>Total</b></th>
                         <th class=""><b>User</b></th>
                         <th>Lock</th>
                      </tr>
                      </thead>
                      <tbody>
                      @php
                      $sum_of_amount=0;
                       $sum_of_sub_total=0;
                      @endphp
                        @foreach ($datas as $key => $data)
                        @php
                           $sum_of_amount += $data->_total ?? 0;
                           $sum_of_sub_total += $data->_sub_total ?? 0;
                        @endphp

                           @php
                        $__s_account = $data->s_account ?? [];
                        $___master_details = $data->_master_details ?? [];
                        @endphp
                        <tr>
                            
                              <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item "  href="{{url('sales-return/print')}}/{{$data->id}}" >
                                         View & Print
                                      </a>
                                     @can('sales-return-edit')
                                        <a class="dropdown-item "   href="{{ route('sales-return.edit',$data->id) }}" >
                                          Edit & Update
                                        </a>
                                    @endcan
                                     @can('money-receipt-print')
                                     @if(sizeof($__s_account) > 0)
                                        <a class="dropdown-item " href="{{ url('sales-return-money-receipt') }}/{{$data->id}}">
                                         Payment Receipt
                                        </a>
                                     @endif
                                    @endcan

                                   
                                  </div>
                                </div>
                               
                               
                                <a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} {{ $data->_time ?? '' }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>

                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ $data->_order_ref_id ?? '' }}</td>
                            <td>{{ $data->_referance ?? '' }}</td>
                            <td>{{ $data->_ledger->_name ?? '' }}</td>
                            <td>{{ _report_amount( $data->_sub_total ?? 0) }} </td>
                            <td>{{ _report_amount( $data->_total_vat ?? 0) }} </td>
                            <td>{{ _report_amount( $data->_total ?? 0) }} </td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                            <td style="display: flex;">
                              @can('lock-permission')
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$data->id}}" value="{{$data->_lock}}" @if($data->_lock==1) checked @endif>
                              @endcan

                              
                              @if($data->_lock==1)
                              <i class="fa fa-lock _green ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @else
                              <i class="fa fa-lock _required ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @endif

                            </td>
                            
                           
                        </tr>


                        @if(sizeof($___master_details) > 0)
                        <tr>
                          <td colspan="14" >
                           <div class="collapse" id="collapseExample__{{$key}}">
                            <div class="card " >
                              <table class="table">
                                <thead >
                                            <th class="text-middle" >ID</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left" >Unit</th>
                                            <th class="text-middle">Barcode</th>
                                           
                                            <th class="text-middle" >Qty</th>
                                            <th class="text-middle @if($form_settings->_show_cost_rate==0) display_none @endif " >Rate</th>
                                            <th class="text-middle" >Sales Rate</th>
                                            @if(isset($form_settings->_inline_discount)) @if($form_settings->_inline_discount==1)
                                            <th class="text-middle" >Dis%</th>
                                            <th class="text-middle" >Dis. Amount</th>
                                             @else
                                            <th class="text-middle display_none" >Dis.%</th>
                                            <th class="text-middle display_none" >Dis. Amount</th>
                                            @endif
                                            @endif
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <th class="text-middle" >VAT%</th>
                                            <th class="text-middle" >VAT</th>
                                             @else
                                            <th class="text-middle display_none" >VAT%</th>
                                            <th class="text-middle display_none" >VAT Amount</th>
                                            @endif
                                            @endif

                                            <th class="text-middle" >Value</th>
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
                                     $_discount_total = 0;
                                    $_qty_total = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <th class="" >{{$_item->id}}</th>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                       $_discount_total += $_item->_discount_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                     @endphp
                                            <td class="" >{!! $_item->_items->_name ?? '' !!}</td>
                                            <td class="" >{!! $_item->_trans_unit->_name ?? '' !!}</td>
                                               <td>
                                                     @php
                                                $barcode_arrays = explode(',', $_item->_barcode ?? '');
                                                @endphp
                                                @forelse($barcode_arrays as $barcode)
                                              <span>{{$barcode}}</span><br>
                                                @empty
                                                @endforelse
                                                    </td>
                                            <td class="text-right" >{!! $_item->_qty ?? 0 !!}</td>
                                            <td class="text-center @if($form_settings->_show_cost_rate==0) display_none @endif" >{!! _report_amount($_item->_rate ?? 0) !!} Per {{ $_item->_units->_name ?? ''}}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                             @if(isset($form_settings->_inline_discount)) @if($form_settings->_inline_discount==1)
                                            <td class="text-right" >{!! $_item->_discount ?? 0 !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                             @else
                                            <td class="text-right display_none" >{!! $_item->_discount ?? 0 !!}</td>
                                            <td class="text-right display_none" >{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
                                            @endif
                                            @endif
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
                                              <td></td>
                                              <td></td>
                                              <td colspan="2"  class="text-right"><b>Total</b></td>
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
                                               @if(isset($form_settings->_inline_discount)) @if($form_settings->_inline_discount==1)
                                              <td></td>
                                              <td class="text-right">
                                                <b>{{_report_amount($_discount_total ?? 0)}}</b>
                                              </td>
                                              @else
                                              <td class="display_none"></td>
                                              <td class="text-right display_none">
                                                 <b>{{ _report_amount($_discount_total ?? 0) }}</b>
                                              </td>
                                              @endif
                                              @endif
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
                          </div>
                        </td>
                        </tr>
                        @endif
                        @if(sizeof($__s_account) > 0)
                        <tr>
                          <td colspan="14" >
                           <div class="collapse" id="collapseExample__{{$key}}">
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Ledger</th>
                                  <th>Branch</th>
                                  <th>Cost Center</th>
                                  <th>Short Narr.</th>
                                  <th class="text-right" >Dr. Amount</th>
                                  <th class="text-right" >Cr. Amount</th>
                                </thead>
                                <tbody>
                                  @php
                                    $_dr_amount = 0;
                                    $_cr_amount = 0;
                                  @endphp
                                  @forelse($data->s_account AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_ledger->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_branch->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_cost_center->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_short_narr ?? '' }}</td>
                  <td class="text-right">{{ _report_amount( $_master_val->_dr_amount ?? 0) }}</td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_cr_amount ?? 0) }} </td>
                                    @php 
                                    $_dr_amount += $_master_val->_dr_amount;   
                                    $_cr_amount += $_master_val->_cr_amount;  
                                    @endphp
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b>{{ _report_amount($_dr_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_cr_amount ?? 0 ) }} </b></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                          <td colspan="9" class="text-center"><b>Total</b></td>
                          <td><b>{{ _report_amount($sum_of_sub_total) }} </b></td>
                          <td></td>
                          <td><b>{{ _report_amount($sum_of_amount) }} </b></td>
                          <td></td>
                          <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
 $(function () {
   var default_date_formate = `{{default_date_formate()}}`
   var _datex = `{{$request->_datex ?? '' }}`
   var _datey = `{{$request->_datey ?? '' }}`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 


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


  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});

 $(document).on('keyup','._search_main_ledger_id',delay(function(e){
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _account_head_id = 13;

  var request = $.ajax({
      url: "{{url('main-ledger-search')}}",
      method: "GET",
      data: { _text_val,_account_head_id },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                  
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $("._ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);

    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })
  
  $(document).on("click",'.search_modal',function(){
    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })

  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="sales_returns";
   if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })

</script>
@endsection