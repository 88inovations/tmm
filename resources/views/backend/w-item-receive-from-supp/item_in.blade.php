<div class="form-group row">
                        <label for="_supplier_name" class="col-sm-4 col-form-label">Supplier:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_supplier_name" name="_supplier_name" placeholder="Supplier">
                          <input type="hidden" readonly class="form-control" id="_supplier_id" name="_supplier_id" >
                         
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="_item_name" class="col-sm-4 col-form-label">Item Name:</label>
                        <div class="col-sm-8">
                          <table class="table">
                            <tr>
                              <td>
                            <input type="text" name="_in_item_name" class="form-control _in_item_name " placeholder="Item">
                            <input type="hidden" name="_in_item_id" class="form-control _in_item_id " >
                            <div class="search_box_item">
                              
                            </div>
                          </td>
                            </tr>
                          </table>
                          

                          <input type="hidden" readonly class="form-control" name="_in_p_p_l_id" id="_in_p_p_l_id" >
                          <input type="hidden" readonly class="form-control" name="_in_purchase_invoice_no" id="_in_purchase_invoice_no" >
                          <input type="hidden" readonly class="form-control" name="_in_purchase_detail_id" id="_in_purchase_detail_id" >
                          <input type="hidden" readonly class="form-control" name="_in_sales_ref_id" id="_in_sales_ref_id" >
                          <input type="hidden" readonly class="form-control" name="_in_sales_detail_ref_id" id="_in_sales_detail_ref_id" >
                          <input type="hidden" readonly class="form-control" name="_in_manufacture_date" id="_in_manufacture_date" >
                          <input type="hidden" readonly class="form-control" name="_in_expire_date" id="_in_expire_date" >
                          <input type="hidden" readonly class="form-control" name="_in_branch_id" id="_in_branch_id" >
                        </div>
                      </div>
                    <div class="form-group row @if($_show_barcode==0) display_none @endif ">
                        <label for="_in_barcode" class="col-sm-4 col-form-label">Barcode:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_in_barcode" name="_in_barcode" placeholder="Barcode">
                         
                        </div>
                      </div>
                      <div class="form-group row @if($_show_short_note==0) display_none @endif">
                        <label for="_in_short_note" class="col-sm-4 col-form-label">Short Note:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_in_short_note" name="_in_short_note" placeholder="Short Note">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_qty" class="col-sm-4 col-form-label">QTY:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" id="_in_qty" name="_in_qty" placeholder="Qty" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_rate" class="col-sm-4 col-form-label">Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control _in_common_keyup" name="_in_rate" id="_in_rate" placeholder="Rate" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_sales_rate" class="col-sm-4 col-form-label">Sales Rate:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_in_sales_rate" class="form-control _in_common_keyup" id="_in_sales_rate" placeholder="Sales Rate" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_in_discount" class="col-sm-4 col-form-label">Dis.%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_in_discount"  class="form-control" id="_in_discount" placeholder="Discount%" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif ">
                        <label for="_in_discount_amount" class="col-sm-4 col-form-label">Dis. Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_in_discount_amount"  class="form-control" id="_in_discount_amount" placeholder="Discount Amount" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_in_vat" class="col-sm-4 col-form-label">Vat%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_in_vat"  class="form-control" id="_in_vat" placeholder="Vat" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_in_vat_amount" class="col-sm-4 col-form-label">Vat Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_in_vat_amount"  class="form-control" id="_in_vat_amount" placeholder="Vat Amount" value="0">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_value" class="col-sm-4 col-form-label">Value:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly name="_in_value" class="form-control" id="_in_value" value="0" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_net_total" class="col-sm-4 col-form-label">Net Total:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly   class="form-control" id="_in_net_total" value="0" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_warranty" class="col-sm-4 col-form-label">Warranty:</label>
                        <div class="col-sm-8">
                         <select class="form-control" name="_in_warranty" id="_in_warranty">
                           <option value="">Select</option>
                           @forelse($warranties as $val)
                            <option value="{{$val->id}}">{{$val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                         </select>
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_adjustment_amount" class="col-sm-4 col-form-label">Adjustment Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_in_adjustment_amount" class="form-control" id="_in_adjustment_amount" placeholder="Adjustment Amount">
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_ledger_id" class="col-sm-4 col-form-label">Payment Ledger:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_in_ledger_id"  >
                            <option value="">Select</option>
                                   @forelse($_defalut_group_ledgers as $_ledger )
                                                  <option value="{{$_ledger->id}}" @if(isset($request->_in_ledger_id)) @if($request->_in_ledger_id == $_ledger->id) selected @endif   @endif> {{ $_ledger->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_in_payment_amount" class="col-sm-4 col-form-label">Payment Amount:</label>
                        <div class="col-sm-8">
                          <input type="text"  name="_in_payment_amount" class="form-control" id="_in_payment_amount" placeholder="Amount">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="_in_status" class="col-sm-4 col-form-label">Receive Status:</label>
                        <div class="col-sm-8">
                          <select class="form-control" name="_in_status"  >
                            <option value="">Select Status</option>
                            <option value="0">Not Receive</option>
                            <option value="1">Receive</option>
                                
                          </select>
                        </div>
                      </div>

                      