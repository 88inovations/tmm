<div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Account Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>Ledger</th>
                                            
                                          
                                            @if(sizeof($permited_costcenters)>1)
                                               <th>Branch</th>
                                              @else
                                               <th class="display_none">Branch</th>
                                              @endif
                                              @if(sizeof($permited_costcenters)>1)
                                                <th>Cost Center</th>
                                              @else
                                                <th class="display_none">Cost Center</th>
                                              @endif
                                            <th>Short Narr.</th>
                                            <th>Dr. Amount</th>
                                            <th>Cr. Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger"  >
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                               @if(sizeof($permited_costcenters)>1)
                                              <td>
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
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
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <td>
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default " onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              @if(sizeof($permited_costcenters)>1)
                                               <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters)>1)
                                              <td></td>
                                              @else
                                              <td class="display_none"></td>
                                              @endif
                                             
                                              
                                              <td  class="text-right"><b>Total</b></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="0" readonly required>
                                              </td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                            
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>