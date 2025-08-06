@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <a class="m-0 _page_name" href="{{ route('direct_productions.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>
               </li>
               @endcan
               @can('account-ledger-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> 
                </button>
               </li>
               @endcan
                @can('production-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('direct_productions.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php
    
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_self = $form_settings->_show_self ?? 0;
    $_show_warranty = $form_settings->_show_warranty ?? 0;
    @endphp
  
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                @include('backend.message.message')
                    <div class="alert _required ">
                      <span class="_over_qty"></span> 
                    </div>

                    
              </div>
              <div class="card-body">
                {!! Form::model(null, ['method' => 'PATCH','class'=>'purchase_form','route' => ['direct_productions.update', $id]]) !!}
                
               
                @csrf
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label>{!! __('label.production_no') !!}:<span class="_required">*</span></label>
                        <input type="text" name="production_no" class="form-control" value="{{$production_info->_order_number}}" readonly>
                     </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label>{!! __('label.production_start_date') !!}:<span class="_required">*</span></label>
                        <input type="text" name="production_start_date" class="form-control" value="{{_view_date_formate($production_info->created_at)}}" readonly>
                     </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-4 ">
                     <div class="form-group ">
                         <label>{!! __('label.finished_goods_receive_status') !!}:<span class="_required">*</span></label>
                         <select class="form-control" name="finished_goods_receive_status">
                           <option value="1"> Receive & Open </option>
                         <option value="2"> Receive & Close </option>
                         </select>
                         
                     </div>
                    </div>
                </div>
                    <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="production">
                            <div class="form-group">
                                <label>{{__('label.entry_date')}}:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                                  <input type="hidden" name="id" value="{{$id}}">
                              </div>
                        </div>

        
                        
                      @php
                    $users = \Auth::user();
                    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                    @endphp 
                    <div class="col-xs-12 col-sm-12 col-md-2 ">
                     <div class="form-group ">
                         <label>{!! __('label.organization_id') !!}:<span class="_required">*</span></label>
                        <select class="form-control " name="organization_id" required >
                           @forelse($permited_organizations as $val )
                           <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                         </select>
                     </div>
                    </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>{{__('label._branch_id')}}:<span class="_required">*</span></label>
                               <select class="form-control" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>{{__('label._cost_center_id')}}:<span class="_required">*</span></label>
                               <select class="form-control" name="_cost_center_id" required >
                                  
                                  @forelse($permited_costcenters as $cost_center )
                                  <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-2 " >
                            <div class="form-group ">
                                <label>{{__('label._store_id')}}:<span class="_required">*</span></label>
                               <select class="form-control" name="_store_id" required >
                                  @forelse($store_houses as $store )
                                  <option value="{{$store->id}}" @if(isset($request->_store_id)) @if($request->_store_id == $store->id) selected @endif   @endif>{{ $store->id ?? '' }} - {{ $store->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Item</th>
                                              <th class="text-left" >Base Unit</th>
                                            <th class="text-left " >Con. Qty</th>
                                            <th class="text-left " >Tran. Unit</th>
                                           
                                            <th class="text-left @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==0) display_none    @endif @endif" >Barcode</th>
                                            <th>Target Qty</th>
                                            <th>Previous Receive</th>
                                         
                                            <th class="text-left" >Receive Qty</th>
                                            <th class="text-left" >Rate</th>
                                            <th class="text-left" >Sales Rate</th>
                                           
                                            
                                          

                                            <th class="text-left" >Value</th>
                                             
                                            
                                             
                                             <th class="text-left @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-left @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                            <th class="text-left @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none @endif
                                            @endif" >Shelf</th>
                                            
                                           
                                          </thead>
                                          <tbody class="area__purchase_details" id="_stock_in_area__purchase_details">
                                            @forelse($datas as $key=> $data)
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td></td>
                                              <td>
                                                <input type="text" name="_stock_in__search_item_id[]" class="form-control _stock_in__search_item_id width_280_px" placeholder="Item" value="{{_item_name($data->_item_id)}}" readonly>
                                                 <input type="hidden" name="_stock_in__item_id[]" class="form-control _stock_in__item_id width_200_px" value="{{$data->_item_id}}">
                                                <input type="hidden" name="_stock_in__p_p_l_id[]" class="form-control _stock_in__p_p_l_id " value="{{$data->_p_p_l_id}}">
                                                <input type="hidden" name="_stock_in__purchase_invoice_no[]" class="form-control _stock_in__purchase_invoice_no" >
                                                <input type="hidden" name="_stock_in__purchase_detail_id[]" class="form-control _stock_in__purchase_detail_id" >
                                                <div class="_stock_in_search_box_item"></div>
                                              </td>
                                                 <td class="">
                                                <input type="hidden" class="form-control _stock_in_base_unit_id width_100_px" name="_stock_in_base_unit_id[]" value="{{$data->_base_unit}}" />
                                                <input type="text" class="form-control _stock_in_main_unit_val width_100_px" readonly name="_stock_in_main_unit_val[]" value="{{_find_unit($data->_base_unit)}}" />
                                              </td>
                                              <td class="">
                                                <input type="number" name="_stock_inconversion_qty[]" min="0" step="any" class="form-control _stock_inconversion_qty " value="1" readonly>
                                                <input type="hidden" name="_stock_in_base_rate[]" min="0" step="any" class="form-control _stock_in_base_rate "  readonly value="{{$data->_rate ?? 1}}">
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <input type="hidden" name="_stock_in_transection_unit[]" class="form-control _stock_in_transection_unit" value="{{$data->_transection_unit}}">
                                                <input type="text" name="_stock_in_transection_unit_name[]" class="form-control _stock_in_transection_unit" value="{{_find_unit($data->_transection_unit)}}" readonly>
                                                
                                              </td>
                                              
                                              <td class="@if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==0) display_none   @endif @endif">
                                                <input type="text" name="{{($key+1)}}_stock_in__barcode[]" class="form-control _stock_in__barcode {{($key+1)}}___stock_in_barcode "  id="{{($key+1)}}___stock_in_barcode" value="{{$data->_barcode}}">

                                                <input type="hidden" name="_stock_in__ref_counter[]" value="{{($key+1)}}" class="_stock_in__ref_counter" id="{{($key+1)}}___stock_in_ref_counter">

                                              </td>

                                                @if($data->_unique_barcode==1)
 <script type="text/javascript">
  $('#<?php echo ($key+1);?>_stock_in__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
                                            </script>
                                            @endif
                                            
                                              <td>
                                                <input type="number" name="_stock_in_main_qty[]" class="form-control _stock_in_main_qty _stock_in_common_keyup" value="{{$data->main_qty ?? 0}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in_previous_receive_qty[]" class="form-control _stock_in_previous_receive_qty _stock_in_common_keyup" value="{{$data->previous_receive_qty ?? 0}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__qty[]" class="form-control _stock_in__qty _stock_in_common_keyup" value="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__rate[]" class="form-control _stock_in__rate _stock_in_common_keyup" value="{{$data->_rate ?? 0}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_stock_in__sales_rate[]" class="form-control _stock_in__sales_rate " value="{{$data->_sales_rate ?? 0}}">
                                              </td>
                                             
                                             
                                             
                                              <td>
                                                <input type="number" name="_stock_in__value[]" class="form-control _stock_in__value " readonly value="0">
                                              </td>
                                           
                                              
                                              
                                              
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__manufacture_date[]" class="form-control _stock_in__manufacture_date " value="{{$data->_manufacture_date ?? '' }}">
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_stock_in__expire_date[]" class="form-control _stock_in__expire_date " value="{{$data->_expire_date ?? '' }}">
                                              </td>
                                             <td class="@if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none  @endif @endif">
                                                <input type="text" name="_stock_in__store_salves_id[]" class="form-control _stock_in__store_salves_id "  >
                                              </td>
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif"></td>
                                              <td colspan="2"  class="text-right"><b>Total</b></td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _stock_in__total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _stock_in__total_value_amount" value="0" readonly required>
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif  @endif"></td>

                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif  @endif"></td>

                                              <td class="@if(isset($form_settings->_show_self)) @if($form_settings->_show_self==0) display_none  @endif  @endif"></td>
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                     


                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;margin: 0px auto;">
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_note">Note<span class="_required">*</span></label></td>
                              <td style="border:0px;width: 80%;">
                                @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('production/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_sub_total">Status</label></td>
                              <td style="border:0px;width: 80%;">
                                @php
                                $_p_statues = \DB::table("production_status")->whereIn('id',[3])->get();
                                @endphp
                                
                               <select class="form-control" name="_p_status" required >
                                  
                                  @forelse($_p_statues as $_statues )
                                  <option value="{{$_statues->id}}" @if(isset($request->_p_status)) @if($request->_p_status == $_statues->id) selected @endif   @endif> {{ $_statues->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                              </td>
                            </tr>
                           
                           
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_stock_in__total">Stock In Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="text" name="_stock_in__total" class="form-control width_200_px" id="_stock_in__total" readonly value="0">


                           <input type="hidden" name="_item_row_count" value="1" class="_item_row_count">
                           <input type="hidden" name="_stock_in__item_row_count" value="1" class="_stock_in__item_row_count">
                              </td>
                            </tr>
                            
                              
                            
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                        <button 
                          type="submit" 
                            class="btn btn-success mt-2 "  onclick="return confirm('Do You Chcek Carefully?')"
                            >Check & Receive Finished Goods In Stock <i class="fa fa-check" aria-hidden="true"></i>
                        </button> 
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

<div style="width: 100%;" class="modal  fade" id="checkAbailableModal" tabindex="-1" role="dialog" aria-labelledby="checkAbailableModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl display_available_ingredients" role="document">
    
  </div> <!-- End Check qty Modal -->

 

</div>

<div class="modal fade" id="barcodeDisplayModal" tabindex="-1" role="dialog" aria-labelledby="barcodeDisplayModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title _barcode_modal_item_name" id="barcodeDisplayModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body _barcode_modal_list_body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <form action="{{ url('production-form-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Production/production Form Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body display_form_setting_info">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>



</div>
@include('backend.common-modal.item_ledger_modal')

@php
      $_string_ids = $form_settings->_cash_customer ?? 0;
      if($_string_ids !=0){
        $_cash_customer = explode(",",$_string_ids);
      }else{
        $_cash_customer =[];
      }
      @endphp

@endsection
@section('script')
@include('backend.direct_productions.stock_out_script')
@include('backend.direct_productions.stock_in_script')

<script type="text/javascript">
     $(document).on('click','.check_row_materials',function(){


var item_ids = [];
var item_ids_empty = [];
$(document).find("._stock_in__item_id").each(function(){
    var item_id = $(this).val();
   if(isNaN(item_id)){item_id=0}
    if(item_id ==0){
        item_ids_empty.push(1);
        
    }else{
          item_ids.push(item_id);
    }

})

if(item_ids_empty?.length >0 ){
    //alert('Item Field Must not be Empty');
    var message =`<h1>Item Field Must Not Be Empty</h1>`;
    $("._confirm_save").attr('disabled',true)
    $( "#display_available_ingredients" ).html(message );
    return false;
}

    $(document).find("#spinner_div").show();
    var create_url = $(this).attr('attr_url');
    var request = $.ajax({
      url: create_url,
      data:$('.purchase_form').serialize(),
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {

      $(document).find("#spinner_div").hide();
      $( ".display_available_ingredients").html( msg );

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
 });

     $(document).on("click","._confirm_save",function(){
        var _note = $(document).find("#_note").val();
        if(_note==""){
            alert("Note Is Reqired");
            $(document).find('.modal_close').click();
            return false;
        }
        $(document).find(".purchase_form").submit();
     })
</script>
@endsection

