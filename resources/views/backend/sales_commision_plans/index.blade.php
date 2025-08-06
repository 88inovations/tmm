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
            <a class="m-0 _page_name" href="{{ route('sales_commision_plans.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('sales_commision_plans-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('sales_commision_plans.create') }}"> Add New </a>
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
              
              <div class="card-body">
                <div class="table-responsive">
                  
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>Plan Name</b></th>
                         <th class=""><b>Year</b></th>
                         <th class=""><b>{{__('label._start_date')}}</b></th>
                         <th class=""><b>{{__('label._end_date')}}</b></th>
                         <th class=""><b>{{__('label._details')}}</b></th>
                         <th>Status</th>

                      </tr>
                      </thead>
                      <tbody>
                    
                        @foreach ($datas as $key => $data)
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class="dropdown-item " href="{{ route('sales_commision_plans.show',$data->id) }}" >
                                         View & Print
                                      </a>
                                     
                                     @can('sales_commision_plans-edit')
                                        <a class="dropdown-item " href="{{ route('sales_commision_plans.edit',$data->id) }}" >
                                          Edit
                                        </a>
                                    @endcan
                                    
                                  </div>
                                </div>
                                
                                
                                <a class="btn btn-sm btn-default _action_button _single_data_click" attr_invoice_id="{{$data->id}}" _attr_key="{{$key}}" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} </td>
                            <td>{{ $data->_name ?? '' }}</td>
                            <td>{{ $data->_fescal_year ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_start_date ?? '') }} </td>
                            <td>{{ _view_date_formate($data->_end_date ?? '') }} </td>
                            <td>{{ $data->_details ?? '' }}</td>
                            <td>{{ selected_status($data->_status ?? 0)  }}</td>
                           
                            
                           
                        </tr>
                        <tr>
                          <td colspan="9" class="collapse " id="collapseExample__{{$key}}">
                            <table class="table table-bordered" >
                                          <thead >
@php

$_details = $data->_detail ?? [];
@endphp
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >{{__('label._target_min')}}</th>
                                            <th class="text-left" >{{__('label._target_max')}}</th>
                                            <th class="text-left" >{{__('label._credit_limit')}}</th>
                                            <th class="text-left" >{{__('label._terms_id')}}</th>
                                            <th class="text-left" >{{__('label._p_qty')}}</th>
                                            <th class="text-left" >{{__('label._bonus_qty')}}</th>
                                            <th class="text-left" >{{__('label._anual_discount')}}</th>
                                            <th class="text-left" >{{__('label._cash_discount_rate')}}</th>
                                            <th class="text-left" >{{__('label._gift_item')}}</th>
                                            <th class="text-left" >{{__('label._grade')}}</th>
                                            <th class="text-left" >{{__('label._status')}}</th>
                                          </thead>
                                          <tbody >
                                        
                                            @forelse($_details as $detail)
                                             <tr >
                                             
                                               <td>{{ $$detail->id ?? '' }} </td>
                                              <td>{{_report_amount($detail->_target_min ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_target_max ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_credit_limit ?? 0)}}</td>
                                              <td>{{id_to_cloumn($detail->_terms_id,'_name','transection_terms') }} || {{id_to_cloumn($detail->_terms_id,'_days','transection_terms') }} Days</td>
                                              <td>{{_report_amount($detail->_p_qty ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_bonus_qty ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_discount_rate ?? 0)}}</td>
                                              <td>{{_report_amount($detail->_cash_discount_rate ?? 0)}}</td>
                                              <td>{{$detail->_gift_item ?? '' }}</td>
                                              <td>{{$detail->_grade ?? '' }}</td>
                                              <td>{{ selected_status($data->detail ?? 0)  }}</td>
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                         
                                          </tbody>
                                          
                                      </table>
                            
                          </td>
                         <tr>

                       
                        @endforeach
                       
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
 
$(document).on("click","._single_data_click",function(){
      var has_class = $(this).hasClass("already_show")
      if(has_class){return false; }
        var invoice_id = $(this).attr("attr_invoice_id");
        var _attr_key = $(this).attr("_attr_key");
        $(this).addClass("already_show");
        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        $.ajax({
           type:'POST',
           url:"{{ url('sales_commision_plans-wise-detail') }}",
           data:{invoice_id,_attr_key},
           success:function(data){
            $(document).find("._single_data_display__"+invoice_id).html(data);
           }
        });
    })
 

// if(_datex =='' && _datey =='' ){
//   $(".datetimepicker-input_datex").val(date__today());
//   $(".datetimepicker-input_datey").val(date__today());
//   console.log('Ok new Page')
// }else{
//   $(".datetimepicker-input_datex").val(after_request_date__today( `{{$request->_datex}}` ))
//   $(".datetimepicker-input_datey").val(after_request_date__today( `{{$request->_datey}}` ))
//   console.log('after search')
// }

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

$(document).on('keyup','._search_main_item_id',delay(function(e){
   
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]. _manufacture_company;
                         search_html += `<tr class="search_row_main_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_unit_id" class="_item_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   </td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_item').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));
 
$(document).on('click','.search_row_main_item',function(){
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
 $(document).find("._search_main_item_id").val(_name);
 $(document).find("._main_item_id").val(_id);

  

 
  $('.search_box_main_item').hide();
  $('.search_box_main_item').removeClass('search_box_show').hide();
  
})


</script>
@endsection