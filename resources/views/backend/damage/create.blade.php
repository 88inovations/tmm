@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <a class="m-0 _page_name" href="{{ route('damage.index') }}"> {{ $page_name ?? '' }} </a>
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
                @can('damage-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('damage.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    @php
   
    $_show_barcode = $form_settings->_show_barcode ?? 0;
    $_show_cost_rate =  $form_settings->_show_cost_rate ?? 0;
    $_show_vat =  $form_settings->_show_vat ?? 0;
    $_inline_discount = $form_settings->_inline_discount ?? 0;
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
               <form action="{{route('damage.store')}}" method="POST" class="purchase_form" >
                @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="damage_adjustments">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>

                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 display_none" >
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Damage Ref:</label>
                              <input type="text" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id')}}" placeholder="Damage Ref" >
                                
                            </div>
                        </div>
                        
                         
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Order Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number')}}" placeholder="Order Number" readonly >
                                
                            </div>
                        </div>
                        @include('basic.org_create')
                       <!--  <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group ">
                                <label>Cost Center:<span class="_required">*</span></label>
                               <select class="form-control _cost_center_id" name="_cost_center_id" required >
                                  
                                  @forelse($permited_costcenters as $cost_center )
                                  <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div> -->
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Ledger:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id')}}" placeholder="Ledger" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id')}}" placeholder="Ledger" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone')}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address')}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance')}}" placeholder="Referance" >
                            </div>
                        </div>
                         
                        
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >Item</th>
                                             <th class="text-left display_none" >Base Unit</th>
                                            <th class="text-left display_none" >Con. Qty</th>
                                            <th class="text-left @if(isset($form_settings->_show_unit)) @if($form_settings->_show_unit==0) display_none    @endif @endif" >Tran. Unit</th>
                                          
                                            <th class="text-left @if($_show_barcode  ==0) display_none @endif" >Barcode</th>
                                            <th class="text-left @if($_show_warranty  ==0) display_none @endif" >Warranty</th>
                                            
                                            <th class="text-left" >Qty</th>
                                            <th class="text-left @if($_show_cost_rate  ==0) display_none @endif" >Cost</th>
                                            <th class="text-left" >Rate</th>
                                            
                                            <th class="text-left  @if($_show_vat  ==0) display_none @endif" >VAT%</th>
                                            <th class="text-left  @if($_show_vat  ==0) display_none @endif" >VAT Amount</th>
                                           
                                             
                                            <th class="text-left @if($_inline_discount  ==0) display_none @endif" >Dis%</th>
                                            <th class="text-left @if($_inline_discount  ==0) display_none @endif" >Dis</th>
                                            <th class="text-left" >Value</th>

                                            <th class="text-middle @if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none @endif
                                            @endif" >Manu. Date</th>
                                             <th class="text-middle @if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none @endif
                                            @endif"> Expired Date </th>
                                           
                                            <th class="text-left  @if(sizeof($permited_branch)  ==1) display_none @endif " >Branch</th>
                                            
                                            
                                             <th class="text-left  @if(sizeof($permited_costcenters)  ==1) display_none @endif " >Cost Center</th>
                                            
                                             
                                             <th class="text-left @if(sizeof($store_houses)  ==1) display_none @endif" >Store</th>
                                           
                                            
                                             <th class="text-left  @if($_show_self  ==0) display_none @endif " >Shelf</th>
                                           
                                           
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
                                                <input type="hidden" name="_ref_counter[]" value="1" class="_ref_counter" id="1__ref_counter">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>

                                              <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly>
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>
                                             
                                              <td class=" @if($_show_barcode==0) display_none @endif ">
                                                <input type="text" name="_barcode[]" class="form-control _barcode " id="1__barcode" >
                                                <input type="hidden" class="_old_barcode" value="" />

                                                <input type="hidden" name="_unique_barcode[]" value="0" class="_unique_barcode   1__unique_barcode" id="1_unique_barcode">
                                              </td>
                                              <td class="@if($_show_warranty==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}"  >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td class=" @if($_show_cost_rate ==0) display_none @endif " >
                                                <input type="number" name="_rate[]" class="form-control _rate  " readonly>
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup " >
                                              </td>
                                              
                                              <td class=" @if($_show_vat == 0) display_none @endif ">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" placeholder="VAT%" >
                                              </td>
                                              <td class="@if($_show_vat ==0) display_none @endif " >
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount" placeholder="VAT Amount"  >
                                              </td>
                                              
                                              
                                              <td class="@if($_inline_discount ==0) display_none @endif " >
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class="@if($_inline_discount ==0) display_none @endif" >
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" >
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " >
                                              </td>
                                            
                                               <td class="@if(sizeof($permited_branch) == 1) display_none @endif ">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                             
                                               <td class=" @if(sizeof($permited_costcenters) == 1) display_none @endif " >
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            
                                              <td class=" @if(sizeof($store_houses) == 1) display_none @endif ">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                             
                                             
                                              <td class=" @if($_show_self==0) display_none @endif ">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              
                                              
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="2" class="text-right"><b>Total</b></td>
                                              
                                                <td  class="text-right @if($_show_barcode==0) display_none @endif"></td>
                                                <td class="@if($_show_warranty==0) display_none @endif"></td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif"></td>
                                              <td></td>
                                              
                                              <td class="@if($_show_vat==0) display_none @endif"></td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="0" readonly required>
                                              </td>
                                              
                                              <td class="@if($_inline_discount==0) display_none @endif"></td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount" value="0" readonly required>
                                              </td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                              </td>
                                             
                                               <td class="@if(sizeof($permited_branch) == 1) display_none @endif"></td>
                                              
                                              
                                               <td class="@if(sizeof($permited_costcenters) == 1) display_none @endif"></td>
                                             
                                               <td class="@if(sizeof($store_houses) == 1) display_none @endif"></td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif"></td>
                                             
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
                                     <input type="hidden" name="_master_id" value="{{url('damage/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_sub_total">Sub Total</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="0">
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="0" >
                              </td>
                            </tr>
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total_discount">Total Discount</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="0">
                              </td>
                            </tr>
                           
                            <tr class=" @if($_show_vat==0) display_none @endif">
                              <td style="border:0px;width: 20%;"><label for="_total_vat">Total VAT</label></td>
                              <td style="border:0px;width: 80%;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_total_vat" readonly value="0">
                              </td>
                            </tr>
                           
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_total">NET Total </label></td>
                              <td style="border:0px;width: 80%;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="0">
                           <input type="hidden" name="_item_row_count" value="1" class="_item_row_count">
                              </td>
                            </tr>
                             @include('backend.message.send_sms')
                            
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('damage-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Damage Adjustment Form Settings</h5>
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

@endsection

@section('script')

<script type="text/javascript">
  @if(empty($form_settings))
    $("#form_settings").click();
    setting_data_fetch();
  @endif
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }




  $(document).on("click","#form_settings",function(){
         setting_data_fetch();
  })

  function setting_data_fetch(){
      var request = $.ajax({
            url: "{{url('damage-setting-modal')}}",
            method: "GET",
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_form_setting_info").html(result);
         })
  }


  

  

  $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-damage-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
console.log(result)
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i]._master_id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i]._item_id}">
                                        </td><td>${data[i]._name}
                      <input type="hidden" name="_p_item_row_id" class="_p_item_row_id" value="${data[i].id}">
                      <input type="hidden" name="_p_item_name" class="_p_item__name" value="${data[i]._name}">
                      <input type="hidden" name="_p_item_item_id" class="_p_item_item_id" value="${data[i]._item_id}">
                      <input type="hidden" name="_p_item__unit_id" class="_p_item__unit_id" value="${data[i]._unit_id}">
                      <input type="hidden" name="_p_item_barcode" class="_p_item_barcode" value="${data[i]._barcode}">
  <input type="hidden" name="_p_item_manufacture_date" class="_p_item_manufacture_date" value="${data[i]._manufacture_date}">
  <input type="hidden" name="_p_item_expire_date" class="_p_item_expire_date" value="${data[i]._expire_date}">
  <input type="hidden" name="_p_item_sales_rate" class="_p_item_sales_rate" value="${data[i]._sales_rate}">
  <input type="hidden" name="_p_item_qty" class="_p_item_qty" value="${data[i]._qty}">
  <input type="hidden" name="_p_item_pur_rate" class="_p_item_pur_rate" value="${data[i]._pur_rate}">
  <input type="hidden" name="_p_item_sales_discount" class="_p_item_sales_discount" value="${data[i]._sales_discount}">
  <input type="hidden" name="_p_item_sales_vat" class="_p_item_sales_vat" value="${data[i]._sales_vat}">
  <input type="hidden" name="_p_item_purchase_detail_id" class="_p_item_purchase_detail_id" value="${data[i]._purchase_detail_id}">
  <input type="hidden" name="_p_item_master_id" class="_p_item_master_id" value="${data[i]._master_id}">
  <input type="hidden" name="_p_item_branch_id" class="_p_item_branch_id" value="${data[i]._branch_id}">
  <input type="hidden" name="_p_item_cost_center_id" class="_p_item_cost_center_id" value="${data[i]._cost_center_id}">
  <input type="hidden" name="_p_item_store_id" class="_p_item_store_id" value="${data[i]._store_id}">
  <input type="hidden" name="_p_item_store_salves_id" class="_p_item_store_salves_id" value="${data[i]._store_salves_id}">
   <input type="hidden" name="_p_item_warranty" class="_p_item_warranty" value="${data[i]._warranty}">
   <input type="hidden" name="_p_item_unique_barcode" class="_p_item_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
   <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]?._unit_name}">
                                   </td>

                                   
                                   <td>${data[i]._qty} ${data[i]?._unit_name}</td>
                                    <td>${data[i]._sales_rate}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var row_id = $(this).find('._p_item_row_id').val();
  var _name = $(this).find('._p_item__name').val();
  var _p_item_item_id = $(this).find('._p_item_item_id').val();
  var _unit_id = $(this).find('._p_item__unit_id').val();
  var _barcode = $(this).find('._p_item_barcode').val();
  var _manufacture_date = $(this).find('._p_item_manufacture_date').val();
  var _expire_date = $(this).find('._p_item_expire_date').val();
  var _sales_rate = parseFloat($(this).find('._p_item_sales_rate').val());
  var _qty = $(this).find('._p_item_qty').val();
  var _pur_rate = $(this).find('._p_item_pur_rate').val();
  var _sales_discount = $(this).find('._p_item_sales_discount').val();
  var _sales_vat = $(this).find('._p_item_sales_vat').val();
  var _purchase_detail_id = $(this).find('._p_item_purchase_detail_id').val();
  var _master_id = $(this).find('._p_item_master_id').val();
  var _branch_id = $(this).find('._p_item_branch_id').val();
  var _cost_center_id = $(this).find('._p_item_cost_center_id').val();
  var _store_id = $(this).find('._p_item_store_id').val();
  var _store_salves_id = $(this).find('._p_item_store_salves_id').val();
  var _warranty = $(this).find('._p_item_warranty').val();
  var _unique_barcode = $(this).find('._p_item_unique_barcode').val();
  var _item_row_count =  $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
 
console.log("_unique_barcode "+_unique_barcode)
console.log("_item_row_count "+_item_row_count)

if(_unique_barcode ==1){
  _new_barcode_function(_item_row_count)
}


  if(_barcode=='null'){ _barcode='' } 
  if(_store_salves_id=='null'){ _store_salves_id='' } 
  if(isNaN(_sales_rate)){ _sales_rate=0 }
  if(isNaN(_pur_rate)){ _pur_rate=0 }
  if(isNaN(_sales_vat)){ _sales_vat=0 }
  _vat_amount = ((_sales_rate*_sales_vat)/100)
  if(isNaN(_sales_discount)){ _sales_discount=0 }
  _discount_amount = ((_sales_rate*_sales_discount)/100)


var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();
var self = $(this);

    var request = $.ajax({
      url: "{{url('item-wise-units')}}",
      method: "GET",
      data: { item_id:_p_item_item_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      self.parent().parent().parent().parent().parent().parent().find('._transection_unit').html("")
      self.parent().parent().parent().parent().parent().parent().find("._transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
 $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);
  
var find_counter_id = $(this).parent().parent().parent().parent().parent().parent().find('._ref_counter').val();
var _new_name_for_barcode = `${find_counter_id}__barcode__${row_id}`;
$(this).parent().parent().parent().parent().parent().parent().find('#'+_item_row_count+"__barcode").attr('name',_new_name_for_barcode); 

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_p_item_item_id);
  var _id_name = `${_master_id},${_name},${_qty}`;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._p_p_l_id').val(row_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_invoice_no').val(_master_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._purchase_detail_id').val(_purchase_detail_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._old_barcode').val(_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_pur_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_sales_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount').val(_sales_discount);
  $(this).parent().parent().parent().parent().parent().parent().find('._discount_amount').val(_discount_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
   if(_unique_barcode ==1){
    $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(0);
    $(this).parent().parent().parent().parent().parent().parent().find('._qty').attr('readonly',true);
  }
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._store_salves_id').val(_store_salves_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._manufacture_date').val(_manufacture_date);
  $(this).parent().parent().parent().parent().parent().parent().find('._expire_date').val(_expire_date);
  $(this).parent().parent().parent().parent().parent().parent().find('._warranty').val(_warranty);
  $(this).parent().parent().parent().parent().parent().parent().find('._unique_barcode').val(_unique_barcode);

  


  _purchase_total_calculation();
  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
})

$(document).on('change','._transection_unit',function(){
  var __this = $(this);
  var conversion_qty = $('option:selected', this).attr('attr_conversion_qty');
 
  $(this).closest('tr').find(".conversion_qty").val(conversion_qty);

  converted_qty_value(__this);
})

function converted_qty_value(__this){

  var _vat_amount =0;
  var _qty = __this.closest('tr').find('._qty').val();
  var _rate = __this.closest('tr').find('._rate').val();
  var _base_rate = __this.closest('tr').find('._base_rate').val();
  var _sales_rate =parseFloat( __this.closest('tr').find('._sales_rate').val());
  var _item_vat = __this.closest('tr').find('._vat').val();
  var conversion_qty = parseFloat(__this.closest('tr').find('.conversion_qty').val());
  var _item_discount = parseFloat(__this.closest('tr').find('._discount').val());


   if(isNaN(_item_vat)){ _item_vat   = 0 }

  if(isNaN(conversion_qty)){ conversion_qty   = 1 }
  var converted_price_rate = (( conversion_qty/1)*_base_rate);

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_base_rate)){ _base_rate =0 }

  if(converted_price_rate ==0){
    converted_price_rate = _sales_rate;
  }
  converted_price_rate = parseFloat(converted_price_rate).toFixed(2);
  if(isNaN(converted_price_rate)){converted_price_rate=0}

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*converted_price_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*converted_price_rate)*_item_discount)/100)


   var _value = parseFloat(converted_price_rate*_qty).toFixed(2);
 __this.closest('tr').find('._sales_rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
  __this.closest('tr').find('._vat_amount').val(_vat_amount);
  __this.closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();


}

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $('.search_box_main_ledger').hasClass('search_box_show');
    var search_box_delivery_man= $('.search_box_delivery_man').hasClass('search_box_show');
    var search_box_sales_man= $('.search_box_sales_man').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $('.search_box_main_ledger').removeClass('search_box_show').hide();
    }
    if(search_box_delivery_man ==true){
      $('.search_box_delivery_man').removeClass('search_box_show').hide();
    }
    if(search_box_sales_man ==true){
      $('.search_box_sales_man').removeClass('search_box_show').hide();
    }
})

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());
  var _sales_rate =parseFloat( $(this).closest('tr').find('._sales_rate').val());
  var _item_vat = parseFloat($(this).closest('tr').find('._vat').val());
  var _item_discount = parseFloat($(this).closest('tr').find('._discount').val());

   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   if(isNaN(_item_discount)){ _item_discount =0 }
   _vat_amount = Math.ceil(((_qty*_sales_rate)*_item_vat)/100)
   _discount_amount = Math.ceil(((_qty*_sales_rate)*_item_discount)/100)

  $(this).closest('tr').find('._value').val((_qty*_sales_rate));
  $(this).closest('tr').find('._vat_amount').val(_vat_amount);
  $(this).closest('tr').find('._discount_amount').val(_discount_amount);
    _purchase_total_calculation();
})

$(document).on('keyup','._vat_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
  var _vat_amount =  $(this).closest('tr').find('._vat_amount').val();
  
   if(isNaN(_vat_amount)){ _vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _vat = parseFloat((_vat_amount/(_sales_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._vat').val(_vat);

    $(this).closest('tr').find('._value').val((_qty*_sales_rate));
 
    _purchase_total_calculation();
})


$(document).on('keyup','._discount_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
  var _discount_amount =  $(this).closest('tr').find('._discount_amount').val();
  
   if(isNaN(_discount_amount)){ _discount_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_sales_rate)){ _sales_rate =0 }
   var _discount = parseFloat((_discount_amount/(_sales_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._discount').val(_discount);

    $(this).closest('tr').find('._value').val((_qty*_sales_rate));
 
    _purchase_total_calculation();
})

$(document).on("change","#_discount_input",function(){
  var _discount_input = $(this).val();
  var res = _discount_input.match(/%/gi);
  if(res){
     res = _discount_input.split("%");
    res= parseFloat(res);
    on_invoice_discount = ($("#_sub_total").val()*res)/100
    $("#_discount_input").val(on_invoice_discount)

  }else{
    on_invoice_discount = _discount_input;
  }

   $("#_discount_input").val(on_invoice_discount);
    _purchase_total_calculation()
})



 function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
      $(document).find("._vat_amount").each(function() {
            var _s_vat =parseFloat($(this).val());
            if(isNaN(_s_vat)){_s_vat = 0}
          _total__vat +=parseFloat(_s_vat);
      });
      $(document).find("._discount_amount").each(function() {
            var _s_discount_amount =parseFloat($(this).val());
            if(isNaN(_s_discount_amount)){_s_discount_amount = 0}
          _total_discount_amount +=parseFloat(_s_discount_amount);
      });
      $("._total_qty_amount").val(_total_qty);
      $("._total_value_amount").val(_total__value);
      $("._total_vat_amount").val(_total__vat);
      $("._total_discount_amount").val(_total_discount_amount);

      var _discount_input = parseFloat($("#_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }
      var _total_discount = parseFloat(_discount_input)+parseFloat(_total_discount_amount);
      $("#_sub_total").val(_math_round(_total__value));
      $("#_total_vat").val(_total__vat);
      $("#_total_discount").val(parseFloat(_discount_input)+parseFloat(_total_discount_amount));
      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $("#_total").val(_total);
  }





function purchase_row_add(event){
   event.preventDefault();
   var _item_row_count = parseFloat($(document).find('._item_row_count').val());
   var _item_row_count = (parseFloat(_item_row_count)+1);

      $("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" >
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" >
                                               <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                                <input type="number" name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly>
                                              </td>
                                              <td class="@if($form_settings->_show_unit==0) display_none @endif">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                </select>
                                              </td>


                                             
                                              <td class="@if($_show_barcode==0) display_none @endif">
                                                <input type="text" name="_barcode[]" class="form-control _barcode " id="${_item_row_count}__barcode" >
                                                <input type="hidden" class="_old_barcode" value="" />

                                                <input type="hidden" name="_unique_barcode[]" value="" class="_unique_barcode   ${_item_row_count}__unique_barcode" id="${_item_row_count}_unique_barcode">
                                              </td>
                                              <td class="@if($_show_warranty  ==0) display_none @endif">
                                                <select name="_warranty[]" class="form-control _warranty ${_item_row_count}___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td class="@if($_show_cost_rate==0) display_none @endif">
                                                <input type="number" name="_rate[]" class="form-control _rate " readonly >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup" >
                                              </td>
                                               
                                                <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                              <td class="@if($_show_vat==0) display_none @endif">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount" >
                                              </td>
                                                <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" >
                                              </td>
                                              <td class="@if($_inline_discount==0) display_none @endif">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" >
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_manufacture_date)) @if($form_settings->_show_manufacture_date==0) display_none  @endif @endif">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " >
                                              </td>
                                              <td class="@if(isset($form_settings->_show_expire_date)) @if($form_settings->_show_expire_date==0) display_none  @endif @endif">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " >
                                              </td>
                                              
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                               <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                             
                                              <td class="@if(sizeof($store_houses)==1) display_none @endif">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              
                                              <td class="@if($_show_self==0) display_none @endif">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              
                                              
                                            </tr>`);
 $(document).find('._item_row_count').val(_item_row_count)

}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _purchase_total_calculation();
  })

 


  $(document).on('click','.submit-button',function(event){
    event.preventDefault();

    var counter_array=[];
    var _all_barcode = [];

    

    $(document).find('.show-plus-bg').each(function(index){
         console.log(parseFloat($(this).text())); 
         var _ref_counter = $(this).closest('tr').find('._ref_counter').val(); 
        if(!counter_array.includes(_ref_counter)){
            var _barcode_unique =   $(this).closest('tr').find('._barcode_unique').val(); 
            var _barcode = $(this).closest('tr').find('._barcode').val(); 
            var _qty = $(this).closest('tr').find('._qty').val();
            var _barcodes = isEmpty(_barcode);
            _all_barcode.push(_barcode);
            counter_array.push(_ref_counter);

        }
         
    })

    _all_barcode = _all_barcode.toString();

   

    var _p_p_l_ids_qtys = new Array();
     var _only_p_ids = [];
     var empty_qty = [];
      var _id_and_qtys = [];

    $(document).find('._p_p_l_id').each(function(index){
     var _p_id =  $(this).val();
     var _p_qty = $(document).find('._qty').eq(index).val();
     var _conversion_qty = $(document).find('.conversion_qty').eq(index).val();
     _conversion_qty = parseFloat(_conversion_qty);
     _p_qty = parseFloat(_p_qty);

     _p_qty = parseFloat(_conversion_qty*_p_qty);
     
     if(isNaN(_p_qty)){
        empty_qty.push(_p_id);
     }
     _only_p_ids.push(_p_id);
      _p_p_l_ids_qtys.push( {_p_id: _p_id, _p_qty: _p_qty});
     

    })
     var unique_p_ids = [...new Set(_only_p_ids)];
     var _stop_sales =0;
    if(_p_p_l_ids_qtys.length > 0){
        var request = $.ajax({
                url: "{{url('check-available-qty')}}",
                method: "GET",
                async:false,
                data: { _p_p_l_ids_qtys,unique_p_ids,_all_barcode },
                dataType: "JSON"
              });
               
              request.done(function( result ) {
                console.log(result)
                  if(result.length > 0){
                     
                   _stop_sales=1;
                  }else{
                     $(document).find("._over_qty").text('');
                  }
              })
    }
    // return false;
    if(_stop_sales ==1){
        alert(" You Can not Adjust More then Available Qty Or Wrong Barcode  ");
       var _message =" You Can not Adjust More then Available Qty Or Wrong Barcode";
        $(document).find("._over_qty").text(_message);
        $(".remove_area").hide();
      return false;
    }

 
    
   
    var _total_dr_amount = $(document).find("._total_dr_amount").val();
    var _total_cr_amount = $(document).find("._total_cr_amount").val();
    var _voucher_type = $(document).find('._voucher_type').val();
    var _note = $(document).find('._note').val();
    var _main_ledger_id = $(document).find('._main_ledger_id').val();



    if(_main_ledger_id  ==""){
       alert(" Please Add Ledger  ");
        $(document).find('._search_main_ledger_id').addClass('required_border').focus();
        return false;
    }

    if(empty_qty.length > 0){
       alert(" You Can not sale empty qty !");
      return false;

    }


    var empty_ledger = [];
    $(document).find("._search_item_id").each(function(){
        if($(this).val() ==""){
          alert(" Please Add Item  ");
          $(this).addClass('required_border');
          empty_ledger.push(1);
        }  
    })

    if(empty_ledger.length > 0){
      return false;
    }
   




    if(_note ==""){
       
       $(document).find('._note').focus().addClass('required_border');
      return false;
    }else if(_main_ledger_id ==""){
       
      $(document).find('._search_main_ledger_id').focus().addClass('required_border');
      return false;
    }else{
      $(document).find('.purchase_form').submit();
    }
  })

 function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }


 

$(".datetimepicker-input").val(date__today())

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

</script>
@endsection

