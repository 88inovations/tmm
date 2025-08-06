
@php
$_out_item=$data->_ind_repl_out_item ?? '';
//dump($old_item);
@endphp


<div class="form-group row">
                        <label for="_customer_name" class="col-sm-4 col-form-label">Customer:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_customer_name" name="_customer_name" placeholder="Customer" value="{{ $data->_customer_ledger->_name ?? '' }}">
                          <input type="hidden" readonly class="form-control" id="_customer_id" name="_customer_id" value="{{ $data->_customer_ledger->id ?? '' }}">
                         
                        </div>
                        <input type="hidden" name="_out_item_master_id" value="{{$_out_item->id}}">
                      </div>
                      <div class="form-group row">
                        <label for="_out_item_name" class="col-sm-4 col-form-label">Item Name:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_item_name" class="form-control _out_item_name " placeholder="Item" value="{{$_out_item->_items->_name ?? '' }}" readonly>
                            <input type="hidden" name="_out_item_id" class="form-control _out_item_id " value="{{ $_out_item->_item_id ?? '' }}">

                          <input type="hidden" name="_out_id" value="{{$_out_item->id ?? '' }}">

                          <input type="hidden" readonly class="form-control" name="_out_p_p_l_id" id="_out_p_p_l_id" value="{{ $_out_item->_p_p_l_id ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_purchase_invoice_no" id="_out_purchase_invoice_no" value="{{ $_out_item->_purchase_invoice_no ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_purchase_detail_id" id="_out_purchase_detail_id" value="{{ $_out_item->_purchase_detail_id ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_sales_ref_id" id="_out_sales_ref_id" value="{{ $_out_item->_sales_ref_id ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_sales_detail_ref_id" id="_out_sales_detail_ref_id" value="{{ $_out_item->_sales_detail_ref_id ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_manufacture_date" id="_out_manufacture_date" value="{{ $_out_item->_manufacture_date ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_expire_date" id="_out_expire_date" value="{{ $_out_item->_expire_date ?? ''  }}">
                          <input type="hidden" readonly class="form-control" name="_out_branch_id" id="_out_branch_id" value="{{ $_out_item->_branch_id ?? ''  }}">
                        </div>
                      </div>
                    <div class="form-group row @if($_show_barcode==0) display_none @endif ">
                        <label for="_out_barcode" class="col-sm-4 col-form-label">Barcode:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_out_barcode" name="_out_barcode" placeholder="Barcode" value="{{ $_out_item->_barcode ?? ''  }}" >
                         
                        </div>
                      </div>
                      <div class="form-group row @if($_show_short_note==0) display_none @endif">
                        <label for="_out_short_note" class="col-sm-4 col-form-label">Short Note:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_out_short_note" name="_out_short_note" placeholder="Short Note" value="{{ $_out_item->_short_note ?? ''  }}">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_qty" class="col-sm-4 col-form-label">QTY:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" id="_out_qty" name="_out_qty" placeholder="Qty" value="{{ $_out_item->_qty ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_rate" class="col-sm-4 col-form-label">Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" name="_out_rate" id="_out_rate" placeholder="Rate" value="{{ $_out_item->_rate ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_sales_rate" class="col-sm-4 col-form-label">Sales Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_sales_rate" class="form-control _in_common_keyup" id="_out_sales_rate" placeholder="Sales Rate" value="{{ $_out_item->_sales_qty ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_out_discount" class="col-sm-4 col-form-label">Dis.%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_discount"  class="form-control" id="_out_discount" placeholder="Discount%" value="{{ $_out_item->_discount ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_out_discount_amount" class="col-sm-4 col-form-label">Dis. Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_discount_amount"  class="form-control" id="_out_discount_amount" placeholder="Discount Amount" value="{{ $_out_item->_discount_amount ?? 0  }}"  >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_out_vat" class="col-sm-4 col-form-label">Vat%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_vat"  class="form-control" id="_out_vat" placeholder="Vat" value="{{ $_out_item->_vat ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_out_vat_amount" class="col-sm-4 col-form-label">Vat Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_vat_amount"  class="form-control" id="_out_vat_amount" placeholder="Vat Amount" value="{{ $_out_item->_vat_amount ?? 0  }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_value" class="col-sm-4 col-form-label">Value:</label>
                        <div class="col-sm-8">
                          <input type="text"   class="form-control" id="_out_value"  value="{{ $_out_item->_value ?? 0  }}"  >
                         
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_out_net_total" class="col-sm-4 col-form-label">Net Total:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly name="_out_net_total"  class="form-control" id="_out_net_total"   value="{{ $_out_item->_net_total ?? 0  }}"  >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_warranty" class="col-sm-4 col-form-label">Warranty:</label>
                        <div class="col-sm-8">
                         <select class="form-control" name="_out_warranty" id="_out_warranty">
                           <option value="">Select</option>
                           @forelse($warranties as $val)
                            <option value="{{$val->id}}" @if($_out_item->_warranty==$val->id) selected @endif  >{{$val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                         </select>
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_adjustment_amount" class="col-sm-4 col-form-label">Adjustment Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_adjustment_amount" class="form-control" id="out_adjustment_amount" placeholder="Adjustment Amount" value="{{ $_out_item->_adjustment_amount ?? 0  }}"  >
                          
                         
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="_out_ledger_id" class="col-sm-4 col-form-label">Receive Ledger:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_out_ledger_id"  >
                            <option value="">Select</option>
                                   @forelse($_defalut_group_ledgers as $_ledger )
                                                  <option value="{{$_ledger->id}}" @if(isset($_out_item->_out_ledger_id)) @if($_out_item->_out_ledger_id == $_ledger->id) selected @endif   @endif> {{ $_ledger->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                        </div>
                      </div>

                      
                    <div class="form-group row">
                        <label for="_out_payment_amount" class="col-sm-4 col-form-label">Receive Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_payment_amount" class="form-control" id="_out_payment_amount" placeholder="Amount" value="{{$_out_item->_out_payment_amount ?? 0 }}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_out_status" class="col-sm-4 col-form-label">Delivery Status:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_out_status"  >
                            <option value="">Select Status</option>
                            <option value="0" @if($_out_item->_out_status==0) selected @endif >Delivery Not Done</option>
                            <option value="1" @if($_out_item->_out_status==1) selected @endif >Delivered</option>
                                
                          </select>
                        </div>
                      </div>
                      