@extends('backend.layouts.app')
@section('title',$page_name)

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
           <a class="m-0 _page_name" href="{{ route('purchase-order.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
              @include('backend.common-modal.item_ledger_sub_link')
              
             
                
              
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('purchase-order.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                  @include('backend.message.message')
                    
              </div>
             
              <div class="card-body">
               <form action="{{url('purchase-order/update')}}" method="POST" class="purchase_form" >
                @csrf
                      <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" value="purchase_orders">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}"  />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" name="_purchase_id" value="{{$data->id}}">
                              <input  type="hidden" name="add_or_edit" class="add_or_edit" value="1">
                        </div>

                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Order Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number',$data->_order_number)}}" placeholder="Order Number" readonly>
                                
                            </div>
                        </div>
                        
                        @include('basic.org_edit')
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="delivery_status">Delivery Status:</label>
                              <select class="form-control" name="_delivery_status">
                                @forelse(_delivery_status() as $key=>$d_val)
                                  <option value="{{$key}}" @if($data->_delivery_status==$key) selected @endif >{{$d_val ?? ''}}</option>
                                @empty
                                @endforelse
                              </select>
                             
                                
                            </div>
                        </div>

                      </div>
                      <div class="row">
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Supplier:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Supplier" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone)}}" placeholder="Phone" >
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address)}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_supplier_so_no">{{__('label._supplier_so_no')}}:</label>
                              <input type="text" id="_supplier_so_no" name="_supplier_so_no" class="form-control _supplier_so_no" value="{{old('_supplier_so_no',$data->_supplier_so_no)}}" placeholder="{{__('label._supplier_so_no')}}" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_referance)}}" placeholder="Referance" >
                                
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
                                            <th class="text-middle" >&nbsp;</th>
                                            <th class="text-middle" >ID</th>
                                            <th class="text-middle" >Item</th>
                                            <th class="text-left" >Base Unit</th>
                                            <th class="text-middle" >Base Rate </th>
                                            <th class="text-left" >Con. Qty</th>
                                            <th class="text-left" >Tran. Unit</th>
                                            <th class="text-middle">Qty</th>
                                            <th class="text-middle" >Rate </th>
                                            <th class="text-middle" >Value</th>
                                          </thead>
                                          @php
                                          $_total_qty_amount = 0;
                                          $_total_vat_amount =0;
                                          $_total_value_amount =0;
                                          @endphp
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @forelse($data->_master_details as $detail)
                                             @php
                                              $_total_qty_amount += $detail->_qty ??  0;
                                              $_total_vat_amount += $detail->_vat_amount ??  0;
                                              $_total_value_amount += $detail->_value ??  0;
                                              @endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{ $detail->id }}
                                                <input type="hidden" name="purchase_detail_id[]" value="{{ $detail->id }}" class="form-control purchase_detail_id" >
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{$detail->_items->_name ?? '' }}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="{{$detail->_item_id}}">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              <td class="">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="{!! $detail->_base_unit !!}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="{!! $detail->_items->_units->_name ?? '' !!}" />
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_base_rate[]" class="form-control _base_rate _common_keyup" value="{!! $detail->_base_rate ?? 0 !!}" >
                                              </td>
                                              <td>
                                                <input type="number" name="conversion_qty[]" class="form-control conversion_qty "  readonly  value="{!! $detail->_unit_conversion ?? 1 !!}"  >
                                                <input type="hidden" name="_code[]" class="form-control _code " >
                                              </td>
                                             <?php
                                            // echo "<pre>";
                                            // print_r($detail->_items->unit_conversion);
                                            // echo "</pre>";
                                              ?>
                                              <td class="">
                                                <select class="form-control _unit_id" name="_unit_id[]">
                                                  @forelse($detail->_items->unit_conversion as $conversion_units )
                                                    <option value="{{$conversion_units->_conversion_unit}}" @if($conversion_units->_conversion_unit==$detail->_transection_unit) selected @endif >{!! $conversion_units->_conversion_unit_name ?? '' !!}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup text-right"  value="{{$detail->_qty ?? 0 }}"  step="any" min="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate  text-right" value="{{$detail->_rate ?? 0 }}"  step="any" min="0">
                                                
                                              </td>
                                             
                                             
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value  text-right" readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                            
                                              
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_order_row(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td  class="text-right"></td>
                                              <td  class="text-right"></td>
                                              <td  class="text-right"></td>
                                              <td  class="text-right"></td>
                                             
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control  text-right _total_qty_amount" value="{{$_total_qty_amount}}" readonly required>
                                              </td>
                                              <td></td>
                                            
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control  text-right _total_value_amount" value="{{$_total_value_amount ?? 0}}" readonly required>



                                              </td>
                                              
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                         @if($__user->_ac_type==1)
                      @include('backend.purchase-order.create_ac_cb')
                         
                      @else
                       @include('backend.purchase-order.create_ac_detail')
                      @endif
                          

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;">
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_note">Note</label></td>
                              <td style="width: 70%;border:0px;">
                                @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('purchase-order/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '' )}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_term_condition">Term & Condition</label></td>
                              <td style="width: 70%;border:0px;">
                               <textarea class="form-control " id="summernote" name="_term_condition">{!! $data->_term_condition ?? '' !!}</textarea>
                              </td>
                            </tr>
                            <tr class="display_none">
                              <td style="width: 10%;border:0px;"><label for="_sub_total">Sub Total</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="{{ _php_round($data->_sub_total ?? 0) }}">
                              </td>
                            </tr>
                           
                            
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total">Net Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="{{ _php_round($data->_total ?? 0)}}">
                              </td>
                            </tr>
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




</div>
@include('backend.common-modal.item_ledger_modal')

@endsection

@section('script')

@include('backend.purchase-order.purchase_order_script')


@endsection