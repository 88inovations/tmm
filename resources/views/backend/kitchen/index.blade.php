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
            <a class="m-0 _page_name" href="{{ route('kitchen.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
             
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('kitchen.index') }}"><i class="fas fa-sync"></i> Refresh </a>
               </li>
              
            </ol>
          </div>
          
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        	@forelse($datas as $key=> $data)

        	@php
        	$_sales_ref = $data->_sales_ref ?? '';
        	$_sales_details = $_sales_ref->_master_details ?? [];
        	@endphp
        	<div class="col-md-3">
	          	<div class="card p-2" >
					  <div class="card-body">
					  
					    
					    
					    <div class="card-title" style="width: 100%;background-color: #ffbc00;font-size: 20px;">
					    	<div class="row">
					    		<div class="col-sm-4"><b>Table No:</b></div>
					    		<div class="col-sm-8">
					    			@php
		                              $tabless = explode(',', $data->_sales_ref->_table_id ?? '');
		                              @endphp
		                               
		                              @forelse($tabless as $l_id)
		                            	<span style="background-color: #f5f5f5;padding: 2px;font-weight: bold;">{{_table_name($l_id)}}</span><br>
		                              @empty
		                              @endforelse 
					    		</div>
					    	</div>
					    </div>
					    <div class="card-title" style="width: 100%;">
					    	<b>Invoice No:   {{$_sales_ref->id ?? ''}}</b>
					    </div>
					    
					    <div class="card-title" style="width: 100%;">
					    	<div class="row">
					    		<div class="col-sm-4"><b>Service staff:</b></div>
					    		<div class="col-sm-8">
					    			@php
		                              $stewared = explode(',', $data->_sales_ref->_served_by_ids ?? '');
		                              @endphp
		                              
		                              @forelse($stewared as $l_id)
		                              <span style="background-color: #f5f5f5;">{{_ledger_name($l_id)}}</span><br>
		                              @empty
		                              @endforelse
					    		</div>
					    	</div>	
					    	
                        </div>
                        <div class="card-title" style="width: 100%;">
                               <b>Placed at:</b>{{ _view_date_formate($data->_sales_ref->_date ?? '') }} {{ $data->_sales_ref->_time ?? '' }}
                        </div>
					    <div class="card-title" style="width: 100%;">
                              <b>Location:</b> {{ $data->_sales_ref->_master_branch->_name ?? '' }}
                          </div>
					    <div class="card-title" style="width: 100%;">
                              <b>Customer:</b> {{ $data->_sales_ref->_ledger->_name ?? '' }}
                          </div>
					    
					    <button 
					    	_attr_order_id="{{$data->_res_sales_id ?? ''}}" 
					    	_attr_kitchen_id="{{$data->id ?? ''}}"
					     	data-toggle="modal" data-target="#exampleModal" 
					     	class="btn btn-warning mt-2 _coocked_confirm_save" 
					     	style="width: 100%;">Cooked & Served <i class="fa fa-check" aria-hidden="true"></i>
					 	</button>
					    
					    <button style="width: 100%;" type="button" 
					    		class="btn btn-primary mt-2 " 
					    		data-toggle="modal" 
					    		data-target="#exampleModal__{{$key}}">Order Details <i class="fa fa-eye" aria-hidden="true"></i>
					    </button>
					   <!--  <button 
					    	data-toggle="modal" data-target="#exampleModal" 
					    	_attr_order_id="{{$data->_res_sales_id ?? ''}}" 
					    	_attr_kitchen_id="{{$data->id ?? ''}}"
					     	class="btn btn-default mt-2 check_available_ingredients" 
					     	style="width: 100%;">Check Available Ingredients <i class="fa fa-check-square" aria-hidden="true"></i>
					    </button> -->

					  </div>
				</div>
        	</div>

			<!-- Modal -->
		<div class="modal fade" id="exampleModal__{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-xl" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Sell Details ( Invoice No. : {{$data->_res_sales_id ?? ''}})</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			       <section class="invoice" id="printablediv" style="">
		
							<table class="table" style="border-collapse: collapse;">
								<tr>
								<td colspan="9" style="text-align: center;">
								{{ $settings->_top_title ?? '' }}<br>
								<strong>{{ $settings->name ?? '' }}</strong><br>
								{{$settings->_address ?? '' }}<br>
								{{$settings->_phone ?? '' }}<br>
								{{$settings->_email ?? '' }}<br>
								<b>{{$page_name}}</b>
								</td>
								</tr>
							<tr>
								
								
							<td colspan="5" style="text-align: left;border: 1px dotted grey;">
							<table style="">
							<tr> <td style="border:none;" > <b>Customer:</b></td></tr>
							<tr> <td style="border:none;" > {{$_sales_ref->_ledger->_name ?? '' }}</td></tr>
							<tr> <td style="border:none;" >Phone:{{$_sales_ref->_phone ?? '' }} </td></tr>
							<tr> <td style="border:none;" >Address:{{$_sales_ref->_address ?? '' }} </td></tr>
							</table>
							</td>
							<td colspan="4" style="border: 1px dotted grey;">
							<table style="text-align: left;">
							<tr> <td style="border:none;" > Invoice No: {{ $_sales_ref->_order_number ?? '' }}</td></tr>
							<tr> <td style="border:none;" > Date: {{ _view_date_formate($_sales_ref->_date ?? '') }}</td></tr>
							<tr> <td style="border:none;" > Time: {{ $_sales_ref->_time ?? '' }}</td></tr>
							</table>
							</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align: left;border:1px dotted grey;">
									<div class="row">
						    			<div class="col-sm-6"><b>Table No:</b></div>
						    			<div class="col-sm-6">
						    				@php
				                              $tabless = explode(',', $data->_sales_ref->_table_id ?? '');
				                              @endphp
				                               
				                              @forelse($tabless as $l_id)
				                            	<span style="background-color: #f5f5f5;">{{_table_name($l_id)}}</span><br>
				                              @empty
				                              @endforelse 
						    			</div>
						    		</div>
								</td>
								<td colspan="4" style="text-align: left;border:1px dotted grey;">
									<div class="row">
							    		<div class="col-sm-6"><b>Service staff:</b></div>
							    		<div class="col-sm-6">
							    			@php
				                              $stewared = explode(',', $data->_sales_ref->_served_by_ids ?? '');
				                              @endphp
				                              
				                              @forelse($stewared as $l_id)
				                              <span style="background-color: #f5f5f5;">{{_ledger_name($l_id)}}</span><br>
				                              @empty
				                              @endforelse
							    		</div>
							    	</div>	
								</td>
							<tr>


							<tbody>
							<tr>
							<td style="text-align: left;border:1px dotted grey;">SL</td>
							<td style="text-align: left;border:1px dotted grey;">Item</td>
							<td style="text-align: right;border:1px dotted grey;">QTY</td>
							<td style="text-align: right;border:1px dotted grey;">Rate</td>
							<td style="text-align: right;border:1px dotted grey;">Discount</td>
							<td style="text-align: right;border:1px dotted grey;">Discount Amount</td>
							<td style="text-align: right;border:1px dotted grey;">VAT</td>
							<td style="text-align: right;border:1px dotted grey;">VAT Amount</td>
							<td style="text-align: right;border:1px dotted grey;">Amount</td>
							</tr>
							@php
							$_value_total = 0;
							$_vat_total = 0;
							$_qty_total = 0;
							$_total_discount_amount = 0;
							@endphp
							@forelse($_sales_ref->_master_details AS $item_key=>$_item )
							<tr>

								@php
								$_value_total +=$_item->_value ?? 0;
								$_vat_total += $_item->_vat_amount ?? 0;
								$_qty_total += $_item->_qty ?? 0;
								$_total_discount_amount += $_item->_discount_amount ?? 0;
								@endphp
								<td class="text-left" style="border:1px dotted grey;" >{{($item_key+1)}}</td>
								<td  class="text-left" style="border:1px dotted grey;">{!! $_item->_items->_name ?? '' !!}</td>
								<td  style="border:1px dotted grey;text-align: right;" >{!! _report_amount($_item->_qty ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_discount ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_discount_amount ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_vat ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;">{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
								<td  style="border:1px dotted grey;text-align: right;" >{!! _report_amount($_item->_value ?? 0) !!}</td>
							</tr>
							@empty
							@endforelse
							<tr>
							<td style="border:1px dotted grey;" colspan="2" class="text-right "><b>Sub Total</b></td>

							<td style="border:1px dotted grey;text-align: right;" class="text-right "> <b>{{ _report_amount($_qty_total ?? 0) }}</b> </td>
							<td style="border:1px dotted grey;text-align: right;"></td>
							<td style="border:1px dotted grey;text-align: right;"></td>
							<td style="border:1px dotted grey;text-align: right;">{{ _report_amount($_total_discount_amount ?? 0) }}</td>

							<td style="border:1px dotted grey;text-align: right;"></td>
							<td style="border:1px dotted grey;text-align: right;" class=" text-right"><b> {{ _report_amount($_vat_total ?? 0) }}</b>
							</td>

							<td style="border:1px dotted grey;text-align: right;" class=" text-right"><b> {{ _report_amount($_value_total ?? 0) }}</b>
							</td>
							</tr>



							<td style="border:1px dotted grey;" colspan="9" class="text-left" >  Developed By:{{ _devloped_by() }}</td>
							</tr>


							</tbody>
							</table>

							</section>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>Print</button>
			      </div>
			    </div>
			  </div>
			</div>
        	@empty
        	@endforelse
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
<!-- Start Check qty Modal -->
 <div style="width: 100%;" class="modal  fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <form action="{{ url('coocked-served-confirm')}}" method="POST">
        @csrf
        <input type="hidden" name="_kitchen_id" class="_kitchen_id" id="_kitchen_id">
        <input type="hidden" name="_sales_id" class="_sales_id" id="_sales_id">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title _modal_title"  id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body display_available_ingredients">
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary _confirm_save">Confirm & Save</button>
      </div>
    </div>
     </form>
  </div> <!-- End Check qty Modal -->

 

</div>

@endsection

@section('script')

<script type="text/javascript">
$(document).on("click",".check_available_ingredients",function(){
		var _kitchen_id = $(this).attr("_attr_kitchen_id");
		var _sales_id = $(this).attr("_attr_order_id");
		console.log(_kitchen_id);
		console.log(_sales_id);
		$(document).find("._kitchen_id").val(_kitchen_id);
		$(document).find("._sales_id").val(_sales_id);
		$(document).find("._confirm_save").hide();
		$(document).find("._modal_title").text("Check Available Ingredients (Order NO:"+_sales_id+")");
		$(document).find(".display_available_ingredients").empty();

	 	$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
		var request = $.ajax({
            url: "{{url('check_available_ingredients')}}",
            method: "POST",
            data:{_kitchen_id,_sales_id},
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_available_ingredients").html(result);
         })   
})

$(document).on("click","._coocked_confirm_save",function(){
		var _kitchen_id = $(this).attr("_attr_kitchen_id");
		var _sales_id = $(this).attr("_attr_order_id");
		console.log(_kitchen_id);
		console.log(_sales_id);
		$(document).find("._kitchen_id").val(_kitchen_id);
		$(document).find("._sales_id").val(_sales_id);
		$(document).find("._confirm_save").show();
		$(document).find("._modal_title").text("Coocked Confirm and Save  (Order NO:"+_sales_id+")");
		$(document).find(".display_available_ingredients").empty();
	 	$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
		var request = $.ajax({
            url: "{{url('coocked_confirm_check')}}",
            method: "POST",
            data:{_kitchen_id,_sales_id},
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_available_ingredients").html(result);
         })   
})


</script>
@endsection