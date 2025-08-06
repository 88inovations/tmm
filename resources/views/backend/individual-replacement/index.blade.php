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
            <a class="m-0 _page_name" href="{{ route('individual-replacement.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('individual-replacement-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('individual-replacement.create') }}"> Add New </a>
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
                       @include('backend.individual-replacement.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('individual-replacement-print')
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
                <div class="table-responsive">
                  
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>ID</b></th>
                         <th class=""><b>Invoice No</b></th>
                         <th class=""><b>Date</b></th>
                         <th class=""><b>Customer</b></th>
                         <th class=""><b>Supplier</b></th>
                         <th class=""><b>Referance</b></th>
                         <th class=""><b>Branch</b></th>
                         <th class=""><b>Status</b></th>
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

                       
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @can('individual-replacement-edit')
                                        <a class="dropdown-item " href="{{ route('individual-replacement.edit',$data->id) }}" >
                                          Edit
                                        </a>
                                    @endcan
                                     <a class="dropdown-item " href="{{url('individual-replacement-in-report')}}/{{$data->id}}" >
                                         Individual Replacement In Report
                                      </a>
                                      <a class="dropdown-item " href="{{url('individual-replacement-out-report')}}/{{$data->_order_ref_id}}" >
                                         Individual Replacement out Report
                                      </a>
                                     <a class="dropdown-item " href="{{url('individual-replacement-customer-delivery-report')}}/{{$data->id}}" >
                                         Individual Customer Delivery Report
                                      </a>
                                     <a class="dropdown-item " href="{{url('individual-replacement-print')}}/{{$data->id}}" >
                                         Details
                                      </a>
                                     
                                     
                                    
                                  </div>
                                </div>
                                
                                
                                <a class="btn btn-sm btn-default _action_button _single_data_click" attr_invoice_id="{{$data->id}}" _attr_key="{{$key}}" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} {{ $data->_time ?? '' }}</td>
                            <td>{{ $data->_supplier_ledger->_name ?? '' }}</td>
                            <td>{{ $data->_customer_ledger->_name ?? '' }}</td>
                            <td>{{ $data->_referance ?? '' }}</td>
                           
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            <td>{{ selected_ser_status($data->_service_status) }}</td>
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
                        <tr>
                          <td colspan="11" class="collapse " id="collapseExample__{{$key}}">
                            <div class="_single_data_display__{{$data->id}}">
                              <h2 style="color: green">Loading..............</h2>
                            </div>
                            
                          </td>
                         <tr>

                       
                        @endforeach
                       
                        </tbody>
                    </table>

                     {!! $datas->render() !!}
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
           url:"{{ url('individual-replacement-wise-detail') }}",
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
      console.log()

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="_ledger_filter_table" >
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        </td style="white-space:nowrap;"><td>${data[i]?._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}"></td>
                                        <td class="_phone">${data[i]?._phone}</td>
                                   </tr>`;
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
    var _table_name ="individual_replace_masters";
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