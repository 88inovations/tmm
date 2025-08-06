<!-- LC Item Details Section -->

@if(sizeof($items) > 0)

<h3>LC Item Wise Cost Details</h3>
        <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Ledger</th>
                                            <th class="text-left" >Type</th>
                                            <th class="text-left" >Item</th>
                                            <th class="text-left" >Code</th>
                                            <th class="text-left " >Tran. Unit</th>
                                            <th class="text-left " >HS code</th>
                                            <th class="text-left " >HS code 2</th>
                                            <th class="text-left " >Note</th>
                                            <th class="text-left" >Order Qty</th>
                                            <th class="text-left" >Cost Qty</th>
                                            <th class="text-left" >Cost Rate</th>
                                            <th class="text-left" >Value</th>
                                            <th class="text-left" >Weight Avg</th>
                                          </thead>
                                          <tbody class="area__purchase_details" id="area__purchase_details">
@php
$total_qty=0;
$total_value=0;
@endphp


                                            @if(isset($items))
                                            @forelse($items as $key=>$item)

@php
$total_qty   +=$item->_qty ?? 0;
$total_value  +=$item->_value ?? 0;
@endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <input type="hidden" name="lc_item_costs_id[]" value="0">
                                              </td>
                                              <td>{{$item->id}}
                                                  <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="{{$item->id}}" readonly>
                                              </td>
                                              <td class="__lc_cost_item_ledger">
                                                <select class="form-control _cost_deduct_ledger_id" name="_cost_deduct_ledger_id[]">
                                                  
                                                </select>
                                              </td>
                                              <td class="__lc_cost_adjust_type">
                                                <select class="form-control _adjust_type" name="_adjust_type[]">
                                                  <option value="1">Add Cost</option>
                                                  <option value="2">Deduction</option>
                                                </select>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_code[]" class="form-control  width_150_px" placeholder="Code" value="{{$item->_item_code ?? '' }}" readonly>
                                                <div class="search_box_item"></div>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control  width_280_px" placeholder="Item" value="{{$item->_item_name ?? '' }}" readonly>
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="{{$item->_item_id ?? 0}}" readonly>
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>

                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" value="{{$item->_base_unit}}" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" value="{{_find_unit($item->_base_unit_id)}}" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" step="any"  name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="{{$item->_unit_conversion ?? 1}}" readonly>
                                                  <input type="number" step="any"  name="_base_rate[]" min="0" step="any" class="form-control _base_rate "  readonly value="{{$item->_base_rate ?? 0}}">
                                              </td>
                                               <td class="">
                                                <select class="form-control _transection_unit" name="_transection_unit[]">
                                                  @forelse($item->_items->unit_conversion as $conversion_units )
                                                    <option 
                                                    value="{{$conversion_units->_conversion_unit}}" 
                                                    attr_base_unit_id="{{$conversion_units->_base_unit_id}}" 
        attr_conversion_qty="{{$conversion_units->_conversion_qty}}" 
        attr_conversion_unit="{{$conversion_units->_conversion_unit}}" 
        attr_item_id="{{$conversion_units->_item_id}}"

                                                    @if($conversion_units->_conversion_unit==$item->_transection_unit) selected @endif >{!! $conversion_units->_conversion_unit_name ?? '' !!}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            
                                          
                                              
                                              <td class="">
                                                <input type="text" name="_hs_code[]" class="form-control _hs_code 1__hs_code "  id="1__hs_code" value="{!! $item->_hs_code ?? '' !!}">

                                                <input type="hidden" name="_ref_counter[]" value="{{($key+1)}}" class="_ref_counter" id="1__ref_counter">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_hs_code_2[]" class="form-control _hs_code_2 1__hs_code_2 "  id="1__hs_code_2" value="{{$item->_hs_code_2 ?? '' }}">

                                              </td>
                                              <td class="">
                                                <input type="text" name="_short_note[]" class="form-control _short_note 1__short_note " value="{!! $item->_short_note ?? '' !!}" >
                                              </td>
                                            
                                              <td>
                                                <input type="number" step="any"  name="item_quantity[]" class="form-control item_quantity " value="{{$item->_qty ?? 0}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" step="any"  name="_qty[]" class="form-control _qty _common_keyup" value="{{$item->_qty ?? 0}}" >
                                              </td>
                                              <td>
                                                <input type="number" step="any"  name="_rate[]" class="form-control _rate _common_keyup" value="0">
                                              </td>
                                             
                                             
                                              <td>
                                                <input type="number" step="any"  name="_value[]" class="form-control _value " value="0" >
                                              </td>
                                            <td>
                                                <input type="text" name="_weight_avg[]" class="form-control _weight_avg " value="{!! $item->_weight_avg ?? '' !!}" >
                                              </td>
                                             
                                              
                                            </tr>
                                            @empty
                                             @endforelse
                                       
                                    @endif
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td ></td>
                                              <td class=""></td>
                                              <td></td>
                                              
                                             
                                              <td  class="text-right"></td>
                                             
                                              <td>
                                                <input type="number" step="any"  step="any" min="0" name="_order_qty" class="form-control _order_qty" value="{{$total_qty ?? 0}}" readonly required>
                                              </td>
                                              <td>
                                                <input type="number" step="any"  step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              
                                            
                                              <td>
                                                <input type="number" step="any"  step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              
                                              
                                            </tr>

                                          </tfoot>
                                      </table>
                                </div>
                            </div>
@endif
                 <!--  -->