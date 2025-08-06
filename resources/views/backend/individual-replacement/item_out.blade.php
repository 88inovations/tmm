<div class="form-group row">
                        <label for="_customer_name" class="col-sm-4 col-form-label">Customer:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_customer_name" name="_customer_name" placeholder="Customer">
                          <input type="hidden" readonly class="form-control" id="_customer_id" name="_customer_id" >
                         
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_out_item_name" class="col-sm-4 col-form-label">Item Name:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_out_item_name" placeholder="Item Name">
                          <input type="hidden" readonly class="form-control" name="_out_item_id" id="_out_item_id" >

                          <input type="hidden" readonly class="form-control" name="_out_p_p_l_id" id="_out_p_p_l_id" >
                          <input type="hidden" readonly class="form-control" name="_out_purchaseoutvoice_no" id="_out_purchaseoutvoice_no" >
                          <input type="hidden" readonly class="form-control" name="_out_purchase_detail_id" id="_out_purchase_detail_id" >
                          <input type="hidden" readonly class="form-control" name="_out_sales_ref_id" id="_out_sales_ref_id" >
                          <input type="hidden" readonly class="form-control" name="_out_sales_detail_ref_id" id="_out_sales_detail_ref_id" >
                          <input type="hidden" readonly class="form-control" name="_out_manufacture_date" id="_out_manufacture_date" >
                          <input type="hidden" readonly class="form-control" name="_out_expire_date" id="_out_expire_date" >
                          <input type="hidden" readonly class="form-control" name="_out_branch_id" id="_out_branch_id" >
                        </div>
                      </div>
                    <div class="form-group row @if($_show_barcode==0) display_none @endif ">
                        <label for="_out_barcode" class="col-sm-4 col-form-label">Barcode:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_out_barcode" name="_out_barcode" placeholder="Barcode">
                         
                        </div>
                      </div>
                      <div class="form-group row @if($_show_short_note==0) display_none @endif">
                        <label for="_out_short_note" class="col-sm-4 col-form-label">Short Note:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_out_short_note" name="_out_short_note" placeholder="Short Note">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_qty" class="col-sm-4 col-form-label">QTY:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" id="_out_qty" name="_out_qty" placeholder="Qty" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_rate" class="col-sm-4 col-form-label">Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" name="_out_rate" id="_out_rate" placeholder="Rate" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_sales_rate" class="col-sm-4 col-form-label">Sales Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_sales_rate" class="form-control _in_common_keyup" id="_out_sales_rate" placeholder="Sales Rate" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_out_discount" class="col-sm-4 col-form-label">Dis.%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_discount"  class="form-control" id="_out_discount" placeholder="Discount%" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_out_discount_amount" class="col-sm-4 col-form-label">Dis. Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_discount_amount"  class="form-control" id="_out_discount_amount" placeholder="Discount Amount" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_out_vat" class="col-sm-4 col-form-label">Vat%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_vat"  class="form-control" id="_out_vat" placeholder="Vat" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_out_vat_amount" class="col-sm-4 col-form-label">Vat Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_vat_amount"  class="form-control" id="_out_vat_amount" placeholder="Vat Amount" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_value" class="col-sm-4 col-form-label">Value:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_out_value"   class="form-control" id="_out_value" value="0" >
                         
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_out_net_total" class="col-sm-4 col-form-label">Net Total:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly name="_out_net_total"  class="form-control" id="_out_net_total" value="0" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_warranty" class="col-sm-4 col-form-label">Warranty:</label>
                        <div class="col-sm-8">
                         <select class="form-control" name="_out_warranty" id="_out_warranty">
                           <option value="">Select</option>
                           @forelse($warranties as $val)
                            <option value="{{$val->id}}">{{$val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                         </select>
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_out_adjustment_amount" class="col-sm-4 col-form-label">Adjustment Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_adjustment_amount" class="form-control" id="out_adjustment_amount" placeholder="Adjustment Amount">
                          
                         
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="_out_ledger_id" class="col-sm-4 col-form-label">Receive Ledger:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_out_ledger_id"  >
                            <option value="">Select</option>
                                   @forelse($_defalut_group_ledgers as $_ledger )
                                                  <option value="{{$_ledger->id}}" @if(isset($request->_out_ledger_id)) @if($request->_out_ledger_id == $_ledger->id) selected @endif   @endif> {{ $_ledger->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                        </div>
                      </div>

                      
                    <div class="form-group row">
                        <label for="_out_payment_amount" class="col-sm-4 col-form-label">Receive Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_out_payment_amount" class="form-control" id="_out_payment_amount" placeholder="Amount">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_out_status" class="col-sm-4 col-form-label">Delivery Status:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_out_status"  >
                            <option value="">Select Status</option>
                            <option value="0">Delivery Not Done</option>
                            <option value="1">Delivered</option>
                                
                          </select>
                        </div>
                      </div>
                      