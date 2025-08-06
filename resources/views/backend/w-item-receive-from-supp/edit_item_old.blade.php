
@php
$old_item=$data->_ind_repl_old_item ?? '';
//dump($old_item);
@endphp
<div class="form-group row">
                        <label for="_item_name" class="col-sm-4 col-form-label">Item Name:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_old_item_name" placeholder="Item Name" value="{{$old_item->_items->_name}}">
                          <input type="hidden" readonly class="form-control" name="_old_item_id" id="_old_item_id" value="{{$old_item->_item_id}}">

                          <input type="hidden" name="_old_item_master_id" value="{{$old_item->id}}">

                          <input type="hidden" readonly class="form-control" name="_old_p_p_l_id" id="_old_p_p_l_id" value="{{ $old_item->_p_p_l_id }}">
                          <input type="hidden" readonly class="form-control" name="_old_purchase_invoice_no" id="_old_purchase_invoice_no" value="{{ $old_item->_purchase_invoice_no }}">
                          <input type="hidden" readonly class="form-control" name="_old_purchase_detail_id" id="_old_purchase_detail_id" value="{{ $old_item->_purchase_detail_id }}">
                          <input type="hidden" readonly class="form-control" name="_old_sales_ref_id" id="_old_sales_ref_id" value="{{ $old_item->_sales_ref_id }}">
                          <input type="hidden" readonly class="form-control" name="_old_sales_detail_ref_id" id="_old_sales_detail_ref_id" value="{{ $old_item->_sales_detail_ref_id }}">
                          <input type="hidden" readonly class="form-control" name="_old_manufacture_date" id="_old_manufacture_date" value="{{ $old_item->_manufacture_date }}">
                          <input type="hidden" readonly class="form-control" name="_old_expire_date" id="_old_expire_date" value="{{ $old_item->_expire_date }}">
                          <input type="hidden" readonly class="form-control" name="_old_branch_id" id="_old_branch_id" value="{{ $old_item->_branch_id }}">
                        </div>
                      </div>
                    <div class="form-group row @if($_show_barcode==0) display_none @endif ">
                        <label for="_old_barcode" class="col-sm-4 col-form-label">Barcode:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_old_barcode" name="_old_barcode" placeholder="Barcode" value="{{ $old_item->_barcode }}">
                         
                        </div>
                      </div>
                    <div class="form-group row ">
                        <label for="_old_sales_date" class="col-sm-4 col-form-label">Sales Date:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_old_sales_date" name="_old_sales_date" placeholder="Sales Date" value="{{ $old_item->_sales_date }}">
                         
                        </div>
                      </div>
                    <div class="form-group row ">
                        <label for="_old_warranty_date" class="col-sm-4 col-form-label">Complain Date:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" id="_old_warranty_date" name="_old_warranty_date" placeholder="Complain Date" value="{{ $old_item->_warranty_date }}">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_short_note==0) display_none @endif">
                        <label for="_old_short_note" class="col-sm-4 col-form-label">Short Note:</label>
                        <div class="col-sm-8">
                          <input type="text"  class="form-control" id="_old_short_note" name="_old_short_note" placeholder="Short Note" value="{{ $old_item->_short_note }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_old_qty" class="col-sm-4 col-form-label">QTY:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control _in_common_keyup" id="_old_qty" name="_old_qty" placeholder="Qty" value="{{ $old_item->_qty }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_cost_rate==0) display_none @endif">
                        <label for="_old_rate" class="col-sm-4 col-form-label">Rate:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly class="form-control" name="_old_rate" id="_old_rate" placeholder="Rate" value="{{ $old_item->_rate }}">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_old_sales_rate" class="col-sm-4 col-form-label">Sales Rate:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly name="_old_sales_rate" class="form-control" id="_old_sales_rate" placeholder="Sales Rate" value="{{ $old_item->_sales_rate }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif">
                        <label for="_old_discount" class="col-sm-4 col-form-label">Dis.%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_old_discount" readonly class="form-control" id="_old_discount" placeholder="Discount%" value="{{ $old_item->_discount }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_inline_discount==0) display_none @endif">
                        <label for="_old_discount_amount" class="col-sm-4 col-form-label">Dis. Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_old_discount_amount" readonly class="form-control" id="_old_discount_amount" placeholder="Discount Amount" value="{{ $old_item->_discount_amount }}" >
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_old_vat" class="col-sm-4 col-form-label">Vat%:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_old_vat" readonly class="form-control" id="_old_vat" placeholder="Vat"  value="{{ $old_item->_vat }}">
                         
                        </div>
                      </div>
                    <div class="form-group row @if($_show_vat==0) display_none @endif">
                        <label for="_old_vat_amount" class="col-sm-4 col-form-label">Vat Amount:</label>
                        <div class="col-sm-8">
                          <input type="text" name="_old_vat_amount" readonly class="form-control" id="_old_vat_amount" placeholder="Vat Amount"  value="{{ $old_item->_vat_amount }}">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_old_value" class="col-sm-4 col-form-label">Value:</label>
                        <div class="col-sm-8">
                          <input type="text"  readonly name="_old_value" class="form-control" id="_old_value" placeholder="Value" value="{{ $old_item->_value }}">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_old_warranty_text" class="col-sm-4 col-form-label">Warranty:</label>
                        <div class="col-sm-8">
                          <input type="text" readonly name="_old_warranty_text" class="form-control" id="_old_warranty_text" placeholder="Warranty" value="{{$old_item->_items->_warranty_name->_name}}">
                          <input type="hidden" readonly value="_old_warranty" class="form-control" id="_old_warranty" value="{{$old_item->_items->_warranty_name->id}}">
                         
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="_old_warranty_comment" class="col-sm-4 col-form-label">Warranty Comment:</label>
                        <div class="col-sm-8">
                          <input  type="hidden" readonly name="_old_warranty_comment" class="form-control _required" id="_old_warranty_comment" placeholder="Warranty Comment" value="{{$old_item->_warranty_comment}}">
                          <span id="_old_warranty_comment_text" class="_required">{{$old_item->_warranty_comment}}</span>
                          
                         
                        </div>
                      </div>