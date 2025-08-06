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
            <a class="m-0 _page_name" href="{{ route('item-replace.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('item-replace-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('item-replace.create') }}"> Add New </a>
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
                       @include('backend.item-replace.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('item-replace-print')
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
                         <th class=""><b>Action</b></th>
                         <th class=""><b>ID</b></th>
                         <th class=""><b>Date</b></th>
                         @if(sizeof($permited_branch) !=1)
                         <th class=""><b>Branch</b></th>
                         @endif
                         <th class=""><b>Order Number</b></th>
                         <th class=""><b>Order Ref</b></th>
                         <th class=""><b>Referance</b></th>
                         <th class=""><b>Ledger</b></th>
                         <th class=""><b>Sub Total</b></th>
                         <th class=""><b>VAT</b></th>
                         <th class=""><b>Total</b></th>
                         <th class=""><b>User</b></th>
                         <th class="">Lock</th>
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
                                     <a class="dropdown-item " href="{{url('item-replace/print')}}/{{$data->id}}" >
                                         View & Print
                                      </a>
                                     <a class="dropdown-item " href="{{url('item-replace/challan')}}/{{$data->id}}" >
                                         Challan
                                      </a>
                                     @can('item-replace-edit')
                                        <a class="dropdown-item " href="{{ route('item-replace.edit',$data->id) }}" >
                                          Edit
                                        </a>
                                    @endcan
                                     @can('money-receipt-print')
                                     
                                        <a class="dropdown-item " href="{{ url('item-replace-money-receipt') }}/{{$data->id}}">
                                         Money Receipt
                                        </a>
                                    
                                    @endcan

                                   
                                  </div>
                                </div>
                                <a class="btn btn-sm btn-default _action_button _single_data_click" attr_invoice_id="{{$data->id}}" _attr_key="{{$key}}" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }}</td>
                            @if(sizeof($permited_branch) !=1)
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            @endif

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

                        <tr>
                          <td colspan="13" class="collapse " id="collapseExample__{{$key}}">
                            <div class="_single_data_display__{{$data->id}}">
                              <h2 style="color: green">Loading..............</h2>
                            </div>
                            
                          </td>
                         </tr>
                          
                        @endforeach
                        <tr>
                          @php
                          if(sizeof($permited_branch) !=1){
                          $conspan=6;
                        }else{
                           $conspan=7;
                      }
                          @endphp
                          <td colspan="{{$conspan}}" class="text-center"><b>Total</b></td>
                          <td><b>{{ _report_amount($sum_of_sub_total) }} </b></td>
                          <td></td>
                          <td><b>{{ _report_amount($sum_of_amount) }} </b></td>
                          <td></td>
                          <td></td>
                        </tr>
                          </td>
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


  $(document).on("click","._single_data_click",function(){
      var has_class = $(this).hasClass("already_show")
      if(has_class){ return false; }
      var invoice_id = $(this).attr("attr_invoice_id");
      var _attr_key = $(this).attr("_attr_key");
      $(this).addClass("already_show");
      $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
               type:'POST',
               url:"{{ url('item-replace-invoice-wise-detail') }}",
               data:{invoice_id,_attr_key},
               success:function(data){
                $(document).find("._single_data_display__"+invoice_id).html(data);
               }

            });
    })


  

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
                                        </td><td>${data[i]._name} | ${data[i]._phone}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}"></td></tr>`;
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
  

 $(document).on('keyup','._search_main_delivery_man_id',delay(function(e){
    $(document).find('._search_main_delivery_man_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    

  var request = $.ajax({
      url: "{{url('main-ledger-search')}}",
      method: "GET",
      data: { _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_delivery_man_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_delivery_man_ledger" class="_id_delivery_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_delivery_man_ledger" class="_name_delivery_man_ledger" value="${data[i]._name}"></td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_delivery_man').html(search_html);
      _gloabal_this.parent('div').find('.search_box_delivery_man').addClass('search_box_show').show();
      
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


  $(document).on("click",'.search_row_delivery_man_ledger',function(){
    var _id = $(this).children('td').find('._id_delivery_man_ledger').val();
    var _name = $(this).find('._name_delivery_man_ledger').val();
    $("._delivery_man_id").val(_id);
    $("._search_main_delivery_man_id").val(_name);
    $('.search_box_delivery_man').hide();
    $('.search_box_delivery_man').removeClass('search_box_show').hide();
  })

  

 $(document).on('keyup','._search_main_sales_man_id',delay(function(e){
    $(document).find('._search_main_sales_man_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    

  var request = $.ajax({
      url: "{{url('main-ledger-search')}}",
      method: "GET",
      data: { _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_sales_man_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_sales_man_ledger" class="_id_sales_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_delivery_man_ledger" class="_name_sales_man_ledger" value="${data[i]._name}"></td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_sales_man').html(search_html);
      _gloabal_this.parent('div').find('.search_box_sales_man').addClass('search_box_show').show();
      
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


  $(document).on("click",'.search_row_sales_man_ledger',function(){
    var _id = $(this).children('td').find('._id_delivery_man_ledger').val();
    var _name = $(this).find('._name_sales_man_ledger').val();
    $("._sales_man_id").val(_id);
    $("._search_main_sales_man_id").val(_name);
    $('.search_box_sales_man').hide();
    $('.search_box_sales_man').removeClass('search_box_show').hide();
  })
 
  $(document).on("click",'.search_modal',function(){
    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })



  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="replacement_masters";
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