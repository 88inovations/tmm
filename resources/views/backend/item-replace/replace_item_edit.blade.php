 <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Old Item Information</strong>
                                
                               
                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <tr>
                                              <th>Item</th>
                                              <th>Barcode</th>
                                              <th>Qty</th>
                                              <th>Rate</th>
                                              <th>Reason</th>
                                            </tr>
                                          </thead>
                                          <tbody class="_old_area__purchase_details" id="_old_area__purchase_details">
                                            @forelse($_master_in_details as $in_key=>$in_detail)
                                            <tr class="_old_purchase_row">
                                              
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _old_search_item_id width_280_px" placeholder="Item" value="{{ $in_detail->_items->_name }}" readonly>
                                                <input type="hidden" name="_old_item_id[]" class="form-control _item_id width_200_px" value="{{$in_detail->_item_id}}">
                                                
                                                <input type="hidden" name="_old_sales_detail_id[]" class="form-control _old_sales_detail_id " value="{{ $in_detail->id }}" readonly>
                                                <input type="hidden" name="_warranty_row_id[]" class="form-control _warranty_row_id " value="{{$in_detail->_complain_detail_row_id}}" readonly>

                                              </td>
                                             
                                              <td>
                                                <input type="text" name="{{$in_key}}_old_barcode__{{$in_detail->_item_id}}" class="form-control _barcode {{$in_key}}__barcode " id="{{$in_key}}__barcode" value="{{$in_detail->_barcode ?? '' }}"  readonly>
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _old_qty " value="{{$in_detail->_qty ?? 0}}" readonly>
                                                <input type="hidden" name="_old_ref_counter[]" value="{{$in_key}}" class="_ref_counter" id="{{$in_key}}__ref_counter">
                                              </td>
                                              
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _old_sales_rate " value="{{$in_detail->_sales_rate}}" readonly>
                                                
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_warranty_reason[]" class="form-control _old_warranty_reason " readonly value="{{$in_detail->_warranty_reason}}">
                                              </td>
                                              
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>