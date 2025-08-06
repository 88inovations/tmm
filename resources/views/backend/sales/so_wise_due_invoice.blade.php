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
            <a class="m-0 _page_name" href="#">{!! $page_name ?? '' !!} </a>
            
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
                  

                   @endphp
                    <div class="col-md-12">
                       @include('backend.sales.so_search')
                    </div>
                   
                  </div>
              </div>
            
        <div class="card-body pb-0">
         
                
                <div class="pt-0 ">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th>Collection</th>
                        <th>{{__('label._order_number')}}</th>
                        <th>{{__('label._date')}}</th>
                        <th>{{__('label.payment_date')}}</th>
                        <th>Terms</th>
                        <th>{{__('label._sales_man_id')}}</th>
                        <th>{{__('label._code')}}</th>
                        <th>{{__('label._name')}}</th>
                        <th>{{__('label._alious')}}</th>
                        <th>{{__('label._phone')}}</th>
                        <th>Sales Amount </th>
                        <th>{{__('label._receive_amount')}}</th>
                        <th>{{__('label._due_amount')}}</th>
                      </tr>
                    </thead>
                    <tbody>
@php
$total_sales = 0;
$total_collection = 0;
$total_due       =0;
@endphp

                       @forelse ($datas as $key => $data)


@php
$total_sales    +=$data->_total ??  0;
$total_collection +=$data->_receive_amount ??  0;
$total_due       += $data->_due_amount ?? 0;
@endphp
                        <td>{{($key+1)}}</td>
                        <td style="display:flex;">

                          <button type="button" 
                         class="btn btn-sm btn-success white_space invoice_wise_due_collection invoice_wise_due_collection__{{$data->id}} mr-3 ml-3" 
                         attr_id="{{$data->id}}"
                         attr_order_number="{{$data->_order_number }}"
                         attr_url="{{url('invoice_wise_due_collection')}}"
                         data-toggle="modal" 
                         data-target="#exampleModalSecond" title="Invoice Wise Due Collection">TK. Collection </button>
<a class="btn btn-sm btn-default _action_button _single_data_click" attr_invoice_id="{{$data->id}}" _attr_key="{{$key}}" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i></a>

                       </td>
                        <td class="white_space">{{ ($data->_order_number ?? '') }}</td>
                        <td  class="white_space">{{ _view_date_formate($data->_date ?? '') }} </td>
                        <td  class="white_space">{{ _view_date_formate($data->payment_date ?? '') }}</td>
                        <td  class="white_space"><span style="color: {{ $data->_terms_con->_font_color ?? '' }}">  {{ $data->_terms_con->_name ?? '' }}</span></td>
                        <td  class="white_space">{{$data->_sales_man->_name ?? '' }}</td>
                        <td  class="white_space">{{ $data->_ledger->_code ?? '' }}</td>
                        <td  class="white_space">{{ $data->_ledger->_name ?? '' }}</td>
                        <td  class="white_space">{{ $data->_ledger->_alious ?? '' }}</td>
                        <td  class="white_space">{{ $data->_phone ?? '' }}</td>
                        <td  class="white_space">{{ _report_amount( $data->_total ?? 0) }} </td>
                        <td  class="white_space">{{ _report_amount( $data->_receive_amount ?? 0) }} </td>
                        <td  class="white_space">{{ _report_amount( $data->_due_amount ?? 0) }}</td>
                      </tr>

                      <tr>
                          <td colspan="14" class="collapse " id="collapseExample__{{$key}}">
                          <!--   <div class="_single_data_display__{{$data->id}}">
                              <h2 style="color: green">Loading..............</h2>
                            </div> -->
                            @include('backend.sales.sales_details')
                            
                          </td>
                         </tr>
                       @empty
                       @endforelse
                    </tbody>

<tfoot>
                       <tr>
                        <th colspan="11">Grand Total</th>
                        <th>{{ _report_amount( $total_sales ?? 0) }} </th>
                        <th>{{ _report_amount( $total_collection ?? 0) }} </th>
                        <th>{{ _report_amount( $total_due ?? 0) }}</th>
                      </tr>
</tfoot>
                  </table>
                 
                </div>
                </div>
               
              
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
             {!! $datas->render() !!}
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>



                
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
               url:"{{ url('invoice-wise-detail') }}",
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
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Phone</th>
            <th>{{__('label._branch_id')}}</th>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_sales_man_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_sales_man_ledger" class="_id_sales_man_ledger" value="${data[i].id}">
                                        </td>
                                        <td>${data[i]?._code}</td>

                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_delivery_man_ledger" class="_name_sales_man_ledger" value="${data[i]._name}"></td>
                                        <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._phone}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        </tr>`;
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


 $(document).on("click",".invoice_wise_due_collection",function(){
      var invoice_id        = $(this).attr("attr_id");
      var attr_url          = $(this).attr("attr_url");
      var attr_order_number = $(this).attr("attr_order_number");
      $(document).find("#exampleModalSecondLabel").text('Invoice Wise Due Collection');
       var request = $.ajax({
            url: attr_url,
            method: "GET",
            data: { invoice_id, attr_order_number},
            dataType: "HTML"
          });
     
          request.done(function( result ) {

            $(document).find("#commonEntryModalFormSecond").html(result)

          })




 })


 $(document).on('keyup','.modal_collection_amount',function(){
  var line_this = $(document);
  var modal_collection_amount = parseFloat($(document).find('.modal_collection_amount').val());
  if(isNaN(modal_collection_amount)){modal_collection_amount=0}

  var modal_invoice_total = parseFloat($(document).find('.modal_invoice_total').val());
  if(isNaN(modal_invoice_total)){modal_invoice_total=0}
    
  var modal_invoice_receive_amount = parseFloat($(document).find('.modal_invoice_receive_amount').val());
  if(isNaN(modal_invoice_receive_amount)){modal_invoice_receive_amount=0}
    
  var modal_invoice_due_amount = parseFloat($(document).find('.modal_invoice_due_amount').val());
  if(isNaN(modal_invoice_due_amount)){modal_invoice_due_amount=0}
    


  var modal_invoice_current_due_amount = parseFloat(parseFloat(modal_invoice_due_amount)-parseFloat(modal_collection_amount)).toFixed(2);

if(modal_invoice_current_due_amount < 0 ){
  var modal_invoice_current_due_amount = 0;
  $(document).find('.modal_collection_amount').val(modal_invoice_due_amount);
   var modal_collection_amount = parseFloat($(document).find('.modal_collection_amount').val());
  if(isNaN(modal_collection_amount)){modal_collection_amount=0}
  var modal_invoice_current_due_amount = parseFloat(parseFloat(modal_invoice_due_amount)-parseFloat(modal_collection_amount)).toFixed(2);

}


  $(document).find('.modal_invoice_current_due_amount').val(modal_invoice_current_due_amount);

  


  if(modal_invoice_current_due_amount <=0){
    $(document).find('.modal_is_close').val(1).change();
  }else{
    $(document).find('.modal_is_close').val(0).change();
  }
// console.log("modal_invoice_due_amount "+ modal_invoice_due_amount);
 
if(modal_invoice_current_due_amount <= 0){
    $(document).find('.modal_invoice_current_due_amount').val(0);
    $(document).find('.modal_collection_amount').val(modal_invoice_due_amount);
  }



});


$(document).on('change','.modal_is_close',function(){
  var _is_close  = $(document).find('.modal_is_close').val();
  var _due_balance  = $(document).find('.modal_invoice_current_due_amount').val();
   if(isNaN(_due_balance)){_due_balance=0}
  if(_due_balance !=0){
   // alert('Due Amount Must be Zero to Close this Invoice');
    $(document).find('.modal_is_close').val(0).change();
  }


});


 /* Invoice wise Sales Collection Submit */

 $(document).on('click','.invoiceWiseCollectionButton',function(){

 
      var modal_collection_amount  = parseFloat($(document).find('.modal_collection_amount').val());

      if(isNaN(modal_collection_amount)){modal_collection_amount=0}

      var modal_collec_url  = $(document).find('.modal_collec_url').val();
 var formData = $(document).find(".invoice_wise_collection_save").serialize(); // Automatically serializes form data

 if(modal_collection_amount ==0){
  alert(" Please Input Amount");
  return false;
 }

  $(document).find(".invoiceWiseCollectionButton").prop('disabled', true);
//console.log(formData)
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                $.ajax({
                    url: modal_collec_url,
                    type: "POST",
                    data: formData,
                    dataType: 'JSON',
                    success: function (response) {
                     
                      var message    = response?.message;
                      var due_amount = response?.due_amount;
                      var invoice_id = response?.invoice_id;
                      console.log("due_amount "+due_amount)

                      if(due_amount ==0){
                        $(document).find(".invoice_wise_due_collection__"+invoice_id).hide()
                      }
                       console.log(response)
                        console.log(message)
                       alert(message);
                       $(document).find(".commonModalClose").click();
                    },
                    error: function (xhr) {
                        
                    }
                });


 })


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
    var _table_name ="sales";
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