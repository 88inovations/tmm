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
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            
          @php

$_main_item_id = $request->_main_item_id ?? '';
$_main_item__search_item_id = $request->_main_item__search_item_id ?? '';
$_search_main_ledger_id = $request->_search_main_ledger_id ?? '';
$_ledger_id = $request->_ledger_id ?? '';



          @endphp
         
            <div class="card-body filter_body" >
               <form  action="{{url('branch_and_customer_wise_s_r_report')}}" method="POST">
                @csrf
                <input type="hidden" name="_form_name" class="_form_name" value="branch_wise_sales_statement">
                    <div class="row">
                       @include('basic.report_date_filter')
                      @include('basic.org_report')
                     

                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <label>{{__('label._sales_man_id')}}:</label>
                         <select class="form-control  _sales_man_id _sales_man"  name="_sales_man_id"   >
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
                      @php
                $report_type = $previous_filter['report_type'] ?? 1;
                    @endphp
                    <div class="row">
                      <label>Report Type:</label>
                        <select class="form-control report_type" name="report_type">
                        
                          <option value="2" @if($report_type==2) selected  @endif>Territory And Customer wise Product Sales & Return Details</option>
                          
                        </select>
                    </div>
                   
                    <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">{{__('label._customer_id')}}:</label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" placeholder="{{__('label._ledger_id')}}" value="{{$_search_main_ledger_id ?? ''}}" required>

                            <input type="hidden" id="_main_ledger_id" name="_ledger_id" class="form-control _main_ledger_id"  placeholder="Customer ID" value="{{$_ledger_id}}" >
                            <div class="search_box_main_ledger"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <label class="mr-2" for="_main_item__search_item_id">Item:</label>
                            <input type="text" id="_main_item__search_item_id" name="_main_item__search_item_id" class="form-control _main_item__search_item_id width_280_px" placeholder="Item" value="{{$_main_item__search_item_id}}">
                              <input type="hidden" name="_main_item_id" class="form-control _main_item_id width_200_px" value="{{$_main_item_id}}" >
                              <div class="_main_item_search_box_item"></div>
                        </div>
                    </div>
                    
                    
                    
                     
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('branch_and_customer_wise_s_r')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>


 
 @if($report_type==2)
  @include("backend.inventory-report.p_t_c_i_wise_sales_statement_3")
  @endif

 
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">



$(document).on('change','.report_type',function(){
var report_type =  $(this).val();
if(report_type ==1){
  $(document).find('._main_item__search_item_id').attr('required',true);
}  

});

 
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

   






$(document).on('keyup','._search_ledger_id_ledger',delay(function(e){
  var _gloabal_this = $(this);

  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "{{url('ledger-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
        
            search_html +=`<div class="card"><table class="_filter_ledger_search_table" >
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row _ledger_search_row" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_ledger" class="_id_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_leder" class="_name_leder" value="${data[i]._name}">
                                        </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      $(document).find('.search_box').html(search_html);
      $(document).find('.search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

  
 $(document).on('click','._ledger_search_row',function(){
  var _id = $(this).children('td').find('._id_ledger').val();
  var _name = $(this).find('._name_leder').val();
  $(document).find('._ledger_id').val(_id);
  var _id_name = `${_name} `;
  $(document).find('._search_ledger_id_ledger').val(_id_name);

  $('.search_box').hide();
  $('.search_box').removeClass('search_box_show').hide();
})

  $(document).on('keyup','._main_item__search_item_id',delay(function(e){
    $(document).find('._main_item__search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
console.log("ok")

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
            search_html +=`<div class="card"><table style="width: 500px;">
             <thead>
              <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Item</th>
                <th>Pack Size</th>
                <th>Unit</th>
                <th>Manufacture</th>
              </tr>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                          var _balance = data[i]?._balance
                          
                         search_html += `<tr class="_main_item_row_item" >
                                          <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td>
                                         <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_item_code" class="_item_code" value="${data[i]._code}">
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                   <input type="hidden" name="_item_pack_size" class="_item_pack_size" value="${data[i]?._pack_size?._name}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                    <td>${data[i]?._pack_size?._name}</td>
                                   <td>${_balance} ${data[i]._units?._name}</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="4">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('._main_item_search_box_item').html(search_html);
      _gloabal_this.parent('div').find('._main_item_search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','._main_item_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  $(document).find("#_main_item__search_item_id").val(_name);
  $(document).find("._main_item_id").val(_id);
  $('._main_item_search_box_item').hide();
  $('._main_item_search_box_item').removeClass('search_box_show').hide();
  
})
  


$(document).on('click',function(){
    var searach_show= $('.search_box').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box').removeClass('search_box_show').hide();
    }
    var _main_item_search_box_item= $('._main_item_search_box_item').hasClass('search_box_show');
    if(_main_item_search_box_item ==true){
      $('._main_item_search_box_item').removeClass('search_box_show').hide();
    }
})

        

         

</script>
@endsection

