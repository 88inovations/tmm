@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
@php
$__user =\Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('warranty-manage.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('warranty-manage-create')
              <li class="breadcrumb-item active">
                  <a class="btn btn-sm btn-info" href="{{ route('warranty-manage.index') }}"> List </a>
               </li>
              @endcan
              
             <li class="breadcrumb-item active">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
               <li class="breadcrumb-item active">
                  <a target="__blank" class="btn btn-sm btn-danger" href="{{ url('warranty-manage/print') }}/{{$data->id}}"> <i class="nav-icon fas fa-print"></i> </a>
               </li>
              
            </ol>

          </div>
         


      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 @if($settings->_barcode_service ==1)
                <div class="row mb-2">
                 
                     <div class="col-md-12">
                       <div class=" mt-2" >
                                <div style="width: 400px;margin:0px auto;">
                                  <input required="" type="text" id="_serach_baorce" name="_serach_baorce" class="form-control _serach_baorce"  placeholder="Search with Unique Barcode"  >
                                    <div class="_main_item_search_box"></div>
                                </div>
                          </div>
                        </div> 
               </div>
               @endif
              </div>
              <div class="card-body">
                {!! Form::model($data, ['method' => 'PATCH','route' => ['warranty-manage.update', $data->id]]) !!}
                @csrf
                
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Invoice NO:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{$data->_order_number }}" placeholder="Order Number" readonly>
                                
                            </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name"  value="warranty_masters">
                            <div class="form-group">
                                <label>Receive Date:</label>
                                  <div style="display: flex;" class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}" />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-2">
                        
                            <div class="form-group">
                                <label>Delivery Date:</label>
                                  <div style="display: flex;" class="input-group date" id="reservationdate_delivery" data-target-input="nearest">
                                      <input type="text" name="_delivery_date" class="form-control datetimepicker-input" data-target="#reservationdate_delivery" value="{{_view_date_formate($data->_delivery_date)}}"/>
                                      <div class="input-group-append" data-target="#reservationdate_delivery" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 @if(sizeof($permited_branch) == 1) display_none @endif ">
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>

                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Customer" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Customer" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Sales Invoice:<span class="_required">*</span></label>
                              <input type="text" id="_search_order_ref_id" name="_search_order_ref_id" class="form-control _search_order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Sales Invoice" >
                              <input type="hidden" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id ?? '' )}}" placeholder="Sales Order" >
                              <div class="search_box_purchase_order"></div>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_date">Sales Date:</label>
                              <input type="text" id="_sales_date" name="_sales_date" class="form-control _sales_date" value="{{_view_date_formate($data->_sales_date)}}" placeholder="Sales Date" readonly>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone)}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address)}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_referance)}}" placeholder="Referance" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 mb-2">
                            <div class="form-group">
                              <label class="mr-2" for="_waranty_status">Status:</label>
                              <select name="_waranty_status" class="_waranty_status form-control" required>
                                @forelse(_warranty_status() as $key=>$val)
                                <option value="{{$key}}" @if($data->_waranty_status == $key) selected @endif >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>
                            </div>

                        </div>



                    </div>
                    @php
                    $_master_details = $data->_master_details ?? [];
                    @endphp
                    @if(sizeof($_master_details) > 0)
                    <div class="row">
                       <div class="table-responsive">
                                      <table class="table table-bordered">
                                          <thead>
                                            <tr><th class="text-left">&nbsp;</th>
                                            <th class="text-left">Item</th>
                                          
                                            <th class="text-left">Barcode</th>
                                            <th class="text-left ">Warranty</th>
                                            
                                            <th class="text-left">Qty</th>
                                            <th class="text-left display_none">Cost</th>
                                            <th class="text-left display_none">Sales Rate</th>
                                            
                                            <th class="text-left display_none">VAT%</th>
                                            <th class="text-left display_none">VAT Amount</th>
                                           
                                             
                                            <th class="text-left display_none">Dis%</th>
                                            <th class="text-left display_none">Discount</th>
                                            <th class="text-left display_none">Value</th>

                                            <th class="text-middle display_none">Manu. Date</th>
                                             <th class="text-middle display_none"> Expired Date </th>
                                           
                                            <th class="text-left @if(sizeof($permited_branch)==1) display_none @endif">Branch</th>
                                             <th class="text-left @if(sizeof($permited_costcenters)==1) display_none @endif">Cost Center</th>
                                             <th class="text-left @if(sizeof($store_houses)==1) display_none @endif">Store</th>
                                             <th class="text-left">Reason of Problem</th>
                                           
                                           


                                          </tr></thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                        @forelse($_master_details as $key=>$value)
                                            <tr class="_purchase_row _purchase_row__">
                                              <td>
                                                <a href="#none" class="btn btn-default _purchase_row_remove"><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{ $value->_items->_name ?? '' }}">

                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " value="{{$value->_item_id}}">
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " value="{{$value->_p_p_l_id}}">
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" value="{{$data->id}}">
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" value="{{$value->id}}">
                                                <input type="hidden" name="_sales_ref_id[]" class="form-control _sales_ref_id" value="0" >
                                                <input type="hidden" name="_sales_detail_ref_id[]" class="form-control _sales_detail_ref_id" value="0" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                             
                                              <td class="">
                                               
                                                <input type="text" name="_barcode_[]" class="form-control _barcode 1__barcode" value="{{$value->_barcode}}" id="1__barcode" readonly="">
                                                <input type="hidden" name="_ref_counter[]" value="1" class="_ref_counter" id="1__ref_counter">
                                              </td>
                                              <td class="  ">
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--Select --</option>
                                                   @forelse($_warranties as $warranty)
                                                    <option value="{{$warranty->id}}"
                                                      @if($value->_warranty == $warranty->id) selected @endif
                                                      >{{$warranty->_name ?? '' }}</option>
                                                    @empty
                                                    @endforelse
                                                  </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="{{$value->_qty ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_rate[]" class="form-control _rate  " readonly="" value="{{$value->_rate ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup " value="{{$value->_sales_rate ?? 0 }}">
                                              </td>
                                              
                                              <td class="display_none">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" placeholder="" value="{{$value->_vat ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount" placeholder="" value="{{$value->_vat_amount ?? 0 }}">
                                              </td>
                                              
                                              
                                              <td class="display_none">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup" value="{{$value->_discount ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount" value="{{$value->_discount_amount ?? 0 }}">
                                              </td>
                                              
                                              <td class="display_none">
                                                <input type="number" name="_value[]" class="form-control _value " readonly="" value="{{$value->_value ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " value="{{$value->_manufacture_date ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " value="{{$value->_expire_date ?? 0 }}">
                                              </td>
                                            
                                               <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]" required="">
                                                  @forelse($permited_branch as $branch)
                                                      <option 
                                                      value="{{$branch->id}}"
                                                      @if($branch->id == $value->_branch_id) selected @endif
                                                      >{{$branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                  </select>
                                              </td>
                                             
                                             
                                               <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required="">
                                                  @forelse($permited_costcenters as $cost)
                                                    <option value="{{$cost->id}}"
                                                       @if($cost->id == $value->_cost_center_id) selected @endif
                                                      > {{$cost->_name ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                  </select>
                                              </td>
                                            
                                              <td class="@if(sizeof($store_houses)==1) display_none @endif">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                    <option value="{{$store->id}}"
                                                      @if($store->id == $value->_store_id) selected @endif
                                                      >{{$store->_name ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                             
                                             
                                              <td class="">
                                                <input type="text" name="_warranty_reason[]" class="form-control _warranty_reason " value="{{$value->_warranty_reason ?? '' }}">
                                              </td>
                                              
                                              
                                            </tr>
                                          @empty
                                          @endforelse
                                          </tbody>
                                          <tfoot>
                                            <!-- <tr>
                                              <td class="">
                                                <a href="#none" class="btn btn-default display_none" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td class="text-right"><b>Total</b></td>
                                              
                                                <td class="text-right   "></td>
                                                <td class="text-right   "></td>
                                             
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly="" required="">
                                              </td>
                                              <td class="  "></td>
                                              <td></td>
                                              
                                              <td class=" display_none "></td>
                                              <td class="  display_none">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="0" readonly="" required="">
                                              </td>
                                              
                                              <td class=" display_none "></td>
                                              <td class=" display_none ">
                                                <input type="number" step="any" min="0" name="_total_discount_amount" class="form-control _total_discount_amount" value="0" readonly="" required="">
                                              </td>
                                             
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly="" required="">
                                              </td>
                                              <td class="display_none">
                                              </td>
                                              <td class="display_none">
                                              </td>
                                             
                                               <td class=""></td>
                                              
                                              
                                               <td class=""></td>
                                             
                                               <td class="display_none"></td>
                                              
                                              <td class="display_none"></td>
                                             
                                            </tr> -->
                                          </tfoot>
                                      </table>
                                </div>

                    </div>
                    @endif

                    
                    @if($__user->_ac_type==1)
                 
                      @include('backend.warranty-manage.edit_acc_cb')
                         
                      @else
                       @include('backend.warranty-manage.edit_acc_detail')
                      @endif
                      <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;margin: 0px auto;">
                            <tr>
                              <td style="border:0px;width: 20%;"><label for="_note">Note<span class="_required">*</span></label></td>
                              <td style="border:0px;width: 80%;">
                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '' )}}" placeholder="Note" required >
                              </td>
                            </tr>
                           
                          </table>
                        </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>


                 {!! Form::close() !!}
                  
                </form>

              </div>
            </div>
            <!-- /.card -->

            </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('warranty-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sales Return Form Settings</h5>
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

@endsection

@section('script')

<script type="text/javascript">
  $(function () {

    var default_date_formate = `{{default_date_formate()}}`
    // Summernote
    
    
     $('#reservationdate_delivery').datetimepicker({
        format:default_date_formate

    });
     

  })

  $(document).on('keyup','#_serach_baorce',function(e){
    if(e.keyCode == 13){
      var _text_val = $(this).val();
      var _branch_id = $(document).find("._master_branch_id").val();
       console.log("_text_val "+ _text_val)
       _main_item_search(_text_val)

    }
      

  })

  function _main_item_search(_text_val){
  var request = $.ajax({
      url: "{{url('barcode-warranty-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
  request.done(function( result ) {
    console.log("keyup call function and ger data")
    var html_row=``;
    if(result?.length > 0){
      console.log(result)
      console.log(result?.[0]?._branch_id)
      var data = result?.[0];
      $(document).find("#_search_main_ledger_id").val(data?._ledger_name);
      $(document).find("#_main_ledger_id").val(data?._ledger_id);
      $(document).find("#_search_order_ref_id").val(data?._sales_id);
      $(document).find("#_order_ref_id").val(data?._sales_id);
      $(document).find("._master_branch_id").val(data?._branch_id);
      $(document).find("#_sales_date").val(data?._date);
      $(document).find("#_phone").val(data?._phone);
      $(document).find("#_address").val(data?._address);
      $(document).find("._search_item_id").val(data?._item_name);
      $(document).find("._item_id").val(data?._item_id);
      $(document).find("._p_p_l_id").val(data?._p_p_id);
      $(document).find("._purchase_invoice_no").val(0);
      $(document).find("._purchase_detail_id").val(0);
      $(document).find("#1__barcode").val(data?._barcode);
      $(document).find("._warranty").val(data?._wattanty_id);
      $(document).find("._qty").val(data?._qty);
      $(document).find("._main_branch_id_detail").val(data?._branch_id);
      $(document).find("._main_cost_center").val(data?._cost_center_id);
      $(document).find("._main_store_id").val(data?._store_id);
      
      //Hidden fileds
      $(document).find("._rate").val(data?._rate);
      $(document).find("._sales_rate").val(data?._sales_rate);
      $(document).find("._vat").val(data?._vat);
      $(document).find("._vat_amount").val(data?._vat_amount);
      $(document).find("._discount").val(data?._discount);
      $(document).find("._discount_amount").val(data?._discount_amount);
      $(document).find("._value").val(data?._value);
      $(document).find("._manufacture_date").val(data?._manufacture_date);
      $(document).find("._manufacture_date").val(data?._expire_date );
      $(document).find("._sales_ref_id").val(data?._sales_id );
      $(document).find("._sales_detail_ref_id").val(data?._sales_detail_id );




    }

    
      var search_html =``;
      var data = result.datas; 
      var __this_barcode = result._this_barcode; 
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


}

  var default_date_formate = `{{default_date_formate()}}`;
//$(".datetimepicker-input").val(date__today())

$("#_serach_baorce").focus();

var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td></td>
                      <td><input type="text" name="_search_ledger_id[]" @if($__user->_ac_type==1) attr_account_head_no="1" @endif  class="form-control _search_ledger_id width_280_px" placeholder="Ledger"   >
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>

                       @if(sizeof($permited_branch)>1)
                      <td>
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @else
                          <td class="display_none">
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @endif

                         @if(sizeof($permited_costcenters)>1)
                        <td>
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @else
                        <td class="display_none">
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @endif
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td class=" @if($__user->_ac_type==1) display_none @endif ">
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }
function purchase_row_add(event){
  $(document).find("#area__purchase_details").append(`<tr class="_purchase_row _purchase_row__">
                                              <td>
                                                <a href="#none" class="btn btn-default _purchase_row_remove"><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id ">
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id ">
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" value="0">
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" value="0">
                                                <input type="hidden" name="_sales_ref_id[]" class="form-control _sales_ref_id" value="0" >
                                                <input type="hidden" name="_sales_detail_ref_id[]" class="form-control _sales_detail_ref_id" value="0" >
                                                <div class="search_box_item"></div>
                                              </td>
                                             
                                              <td class="">
                                                <input type="text" name="_barcode_[]" class="form-control _barcode 1__barcode" value="" id="1__barcode" readonly="">
                                                <input type="hidden" name="_ref_counter[]" value="1" class="_ref_counter" id="1__ref_counter">
                                              </td>
                                              <td class="  ">
                                                <select name="_warranty[]" class="form-control _warranty 1___warranty">
                                                   <option value="0">--Select --</option>
                                                    @forelse($_warranties as $warranty)
                                                    <option value="{{$warranty->id}}">{{$warranty->_name ?? '' }}</option>
                                                    @empty
                                                    @endforelse
                                                  </select>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_rate[]" class="form-control _rate  " readonly="">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup ">
                                              </td>
                                              
                                              <td class="display_none">
                                                <input type="number" name="_vat[]" class="form-control  _vat _common_keyup" placeholder="">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_vat_amount[]" class="form-control  _vat_amount" placeholder="">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_discount[]" class="form-control  _discount _common_keyup">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_discount_amount[]" class="form-control  _discount_amount">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_value[]" class="form-control _value " readonly="">
                                              </td>
                                              <td class="display_none">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date ">
                                              </td>
                                              <td class="display_none">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date ">
                                              </td>
                                               <td class="">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]" required="">
                                                               @forelse($permited_branch as $branch)
                                                      <option value="{{$branch->id}}">{{$branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                  </select>
                                              </td>
                                               <td class="">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required="">
                                                     @forelse($permited_costcenters as $cost)
                                                    <option value="{{$cost->id}}"> {{$cost->_name ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                  </select>
                                              </td>
                                              <td class="">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                    @forelse($store_houses as $store)
                                                    <option value="{{$store->id}}">{{$store->_name ?? ''}}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              <td class="">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id ">
                                              </td>
                                            </tr>`)
}

$(document).on('keyup','._search_order_ref_id',delay(function(e){
    $(document).find('._search_order_ref_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _branch_id = $(document).find('._master_branch_id').val();

  var request = $.ajax({
      url: "{{url('sales-order-search')}}",
      method: "GET",
      data: { _text_val,_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
       console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table table-bordered style="width: 100%;">
                            <thead>
                              <th style="border:1px solid #ccc;text-align:center;">ID</th>
                              <th style="border:1px solid #ccc;text-align:center;">Supplier</th>
                              <th style="border:1px solid #ccc;text-align:center;">Date</th>
                            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var _delivery_man_id = (data[i]._delivery_man ) ? data[i]._delivery_man.id : '' ;
                          var _delivery_man_name = (data[i]._delivery_man ) ? data[i]._delivery_man._name : '' ;
                          var _sales_man_id = (data[i]._sales_man ) ? data[i]._sales_man.id : '' ;
                          var _sales_man_name = (data[i]._sales_man ) ? data[i]._sales_man._name : '' ;
                          var __address = (data[i]._ledger._address ) ? data[i]._ledger._address : '' ;
                          var __phone = (data[i]._ledger._phone ) ? data[i]._ledger._phone : '' ;

                         search_html += `<tr class="search_row_purchase_order" >
                                        <td style="border:1px solid #ccc;">${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i]._ledger_id}">
                                        <input type="hidden" name="_purchase_main_id" class="_purchase_main_id" value="${data[i].id}">
                                        <input type="hidden" name="_purchase_main_date" class="_purchase_main_date" value="${after_request_date__today(data[i]._date)}">
                                        </td><td style="border:1px solid #ccc;">${data[i]._ledger._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._ledger._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${__address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${__phone}">
                                        <input type="hidden" name="_delivery_man_main_id" class="_delivery_man_main_id" value="${_delivery_man_id}">
                                        <input type="hidden" name="_delivery_man_main_name" class="_delivery_man_main_name" value="${_delivery_man_name}">
                                        <input type="hidden" name="_sales_man_main_id" class="_sales_man_main_id" value="${_sales_man_id}" >
                                        <input type="hidden" name="_sales_man_main_name" class="_sales_man_main_name" value="${_sales_man_name}" }">
                                        <input type="hidden" name="_date_main_ledger" class="_date_main_ledger" value="${after_request_date__today(data[i]._date)}">
                                   </td>
                                   <td style="border:1px solid #ccc;">${after_request_date__today(data[i]._date)}
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_purchase_order').html(search_html);
      _gloabal_this.parent('div').find('.search_box_purchase_order').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));
$(document).on("click",'.search_row_purchase_order',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _purchase_main_id = $(this).find('._purchase_main_id').val();
    var _purchase_main_date = $(this).find('._purchase_main_date').val();
    var _main_branch_id = $(this).find('._main_branch_id').val();
    var _date_main_ledger = $(this).find('._date_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();


    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    var _search_main_delivery_man = $(this).find('._delivery_man_main_name').val();
    var _delivery_man_id = $(this).find('._delivery_man_main_id').val();
    var _search_main_sales_man = $(this).find('._sales_man_main_name').val();
    var _sales_man = $(this).find('._sales_man_main_id').val();
   
    if(_address_main_ledger =='null' ){ _address_main_ledger =""; } 
    if(_phone_main_ledger =='null' ){ _phone_main_ledger =""; } 

    $("._main_ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);
    $("._order_ref_id").val(_purchase_main_id);
    $("._phone").val(_phone_main_ledger);
    $("._address").val(_address_main_ledger);




    $("._search_main_delivery_man").val(_search_main_delivery_man);
    $("._delivery_man_id").val(_delivery_man_id);
    $("._search_main_sales_man").val(_search_main_sales_man);
    $("._sales_man").val(_sales_man);
    $("._search_order_ref_id").val(_purchase_main_id);
    $("._sales_date").val(_purchase_main_date);

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var request = $.ajax({
      url: "{{url('sales-order-details')}}",
      method: "POST",
      data: { _purchase_main_id,_main_branch_id },
      dataType: "JSON"
    });
    request.done(function( result ) {
      console.log(result)
      var data = result;
      var _purchase_row_single = ``;
      $(document).find("#area__purchase_details").empty();
     
if(data.length > 0 ){
  for (var i = 0; i < data.length; i++) {
    var _item_name = (data[i]._items._name) ? data[i]._items._name : '' ;
    var _store_salves_id = (data[i]._store_salves_id) ? data[i]._store_salves_id : '' ;
    var _barcode  = (data[i]._barcode ) ? data[i]._barcode  : '' ;
    var _warranty  = (data[i]._warranty ) ? data[i]._warranty  : '0' ;
    var _unique_barcode  = (data[i]._items._unique_barcode ) ? data[i]._items._unique_barcode  : '' ;
    
    var _qty   = (data[i]._qty  ) ? data[i]._qty   : 0 ;
    var _rate    = (data[i]._rate) ? data[i]._rate    : 0 ;
    var _sales_rate = (data[i]._sales_rate ) ? data[i]._sales_rate : 0 ;
    var _vat = (  data[i]._vat ) ? data[i]._vat : 0 ;

    var _manufacture_date = (data[i]._manufacture_date) ? data[i]._manufacture_date : '' ;
    var _expire_date = (data[i]._expire_date) ? data[i]._expire_date : '' ;

    var _vat_amount = ( ((data[i]._qty*data[i]._sales_rate)*data[i]._vat)/100 ) ? ( ((data[i]._qty*data[i]._sales_rate)*data[i]._vat)/100 ) : 0 ;
    var _discount = (data[i]._discount ) ? data[i]._discount : 0 ;
    var _discount_amount = ( ((data[i]._qty*data[i]._sales_rate)*data[i]._discount)/100 ) ? ( ((data[i]._qty*data[i]._sales_rate)*data[i]._discount)/100 ) : 0 ;
    var _value = ( (data[i]._qty*data[i]._sales_rate) ) ? (data[i]._qty*data[i]._sales_rate) : 0 ;
    var _item_row_count = (i+1);

       $(document).find("#area__purchase_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id ${_item_row_count}__search_item_id width_280_px" placeholder="Item" value="${_item_name}(${_qty})" readonly>
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id " value="${data[i]._item_id}" >
                                                <input type="hidden" name="_p_p_l_id[]" class="form-control _p_p_l_id " value="${data[i]._p_p_l_id}"  >
                                                <input type="hidden" name="_purchase_invoice_no[]" class="form-control _purchase_invoice_no" value="0">
                                                <input type="hidden" name="_purchase_detail_id[]" class="form-control _purchase_detail_id" value="0">
                                                <input type="hidden" name="_sales_ref_id[]" class="form-control _sales_ref_id" value="${data[i]._no}" >
                                                <input type="hidden" name="_sales_detail_ref_id[]" class="form-control _sales_detail_ref_id" value="${data[i].id}" >
                                              </td>
                                              <td class="">
                                                <input type="hidden" class="_old_barcode" value="${((data[i]._barcode=='null') ? '' : data[i]._barcode) }" />
                                                <input type="text" name="${_item_row_count}__barcode__${data[i]._p_p_l_id}" class="form-control _barcode ${_item_row_count}__barcode " id="${_item_row_count}__barcode" value="" >
                                                <input type="hidden" name="_ref_counter[]" value="${_item_row_count}" class="_ref_counter" id="${_item_row_count}__ref_counter">
                                                <input type="hidden" name="_unique_barcode[]" value="" class="_unique_barcode   ${_item_row_count}__unique_barcode" id="${_item_row_count}_unique_barcode">
                                              </td>
                                              <td class="">
                                                <select name="_warranty[]" class="form-control _warranty ${_item_row_count}___warranty">
                                                   <option value="0">--None --</option>
                                                      @forelse($_warranties as $_warranty )
                                                      <option value="{{$_warranty->id}}" >{{ $_warranty->_name ?? '' }}</option>
                                                      @empty
                                                      @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty ${_item_row_count}__qty _common_keyup" value="0"  ${((_unique_barcode==1) ? 'readonly' : '') }>
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_rate[]" class="form-control _rate " readonly value="${_rate}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate _common_keyup" value="${_sales_rate}">
                                              </td>
                                               
                                                <td class="display_none">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="${_vat}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="${_vat_amount}" >
                                              </td>
                                                <td class="display_none">
                                                <input type="text" name="_discount[]" class="form-control  _discount _common_keyup" value="${_discount}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="text" name="_discount_amount[]" class="form-control  _discount_amount" value="${_discount_amount}" >
                                              </td>
                                             
                                              <td class="display_none">
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="${_value}" >
                                              </td>
                                               <td class="display_none">
                                                <input type="date" name="_manufacture_date[]" class="form-control _manufacture_date " value="${_manufacture_date}" >
                                              </td>
                                              <td class="display_none">
                                                <input type="date" name="_expire_date[]" class="form-control _expire_date " value="${_expire_date }" >
                                              </td>
                                              <td class="">
                                              <input type="hidden" class="_main_branch_id_detail" name="_main_branch_id_detail[]" value="${data[i]._branch_id}" />
                                              <input type="text" readonly class="_main_branch_name_detail" name="_main_branch_name_detail[]" value="${data[i]._detail_branch._name}" />
                                              </td>
                                              
                                               <td class="">
                                                <input type="hidden" class="_main_cost_center" name="_main_cost_center[]" value="${data[i]._cost_center_id}" />
                                              <input type="text" readonly class="_main_cost_center_name_detail" name="_main_cost_center_name_detail[]" value="${data[i]._detail_cost_center._name}" />
                                              </td>
                                              <td class="">
                                              <input type="hidden" class="_main_store_id" name="_main_store_id[]" value="${data[i]._store_id}" />
                                              <input type="text" readonly class="_main_store_name_detail" name="_main_store_name_detail[]" value="${data[i]._store._name}" />
                                              </td>
                                              <td class="">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="${_store_salves_id}" >
                                              </td>
                                            </tr>`);
$("."+_item_row_count+"___warranty").val(_warranty);
                                            if(_unique_barcode ==1){ _new_barcode_function(_item_row_count)   }

                                          }

                                          

                                        }

           // $(document).find("#area__purchase_details").html(_purchase_row_single);
              _purchase_total_calculation();
    })



  })

function _new_barcode_function(_item_row_count){
      $('#'+_item_row_count+'__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
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

function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
          _total__value +=parseFloat($(this).val());
      });
      $(document).find("._qty").each(function() {
          _total_qty +=parseFloat($(this).val());
      });

      $(document).find("._vat_amount").each(function() {
          _total__vat +=parseFloat($(this).val());
      });
      $(document).find("._discount_amount").each(function() {
          _total_discount_amount +=parseFloat($(this).val());
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

  $(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $('.search_box_main_ledger').hasClass('search_box_show');
    var search_row_purchase_order= $('.search_box_purchase_order').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }

    if(search_box_main_ledger ==true){
      $('.search_box_main_ledger').removeClass('search_box_show').hide();
    }

    if(search_row_purchase_order ==true){
      $('.search_box_purchase_order').removeClass('search_box_show').hide();
    }
})


   $(document).on("click","#form_settings",function(){
         setting_data_fetch();
  })

  function setting_data_fetch(){
      var request = $.ajax({
            url: "{{url('warranty-setting-modal')}}",
            method: "GET",
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_form_setting_info").html(result);
         })
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
</script>
@endsection