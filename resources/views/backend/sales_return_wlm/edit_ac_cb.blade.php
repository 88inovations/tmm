<div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Payment Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>Ledger</th>
                                               <th class=" @if(sizeof($permited_branch)==1) display_none @endif ">Branch</th>
                                              <th class=" @if(sizeof($permited_costcenters)==1) display_none @endif ">Cost Center</th>
                                             
                                            <th>Short Narr.</th>
                                            <th class="display_none">Dr. Amount</th>
                                            <th>Payment Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            @php
                                            $_total_dr_amount =0;
                                            $_total_cr_amount =0;
                                            @endphp
                                            @forelse($data->s_account as $_s_acc)
                                            @php
                                            $_total_dr_amount +=floatval($_s_acc->_dr_amount ?? 0);
                                            $_total_cr_amount +=floatval($_s_acc->_cr_amount ?? 0);
                                            @endphp
                                              @if($data->_ledger_id !=$_s_acc->_ledger_id)
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" value="{{ $_s_acc->_ledger->_name ?? '' }}" @if($__user->_ac_type==1) attr_account_head_no="1" @endif  > 
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" value="{{$_s_acc->_ledger_id}}" >
                                                <input type="hidden" name="_sales_account_detail_id[]" class="form-control _sales_account_detail_id" value="{{$_s_acc->id}}" >
                                                <div class="search_box"  >
                                                  
                                                </div>
                                              </td>
                                              
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($_s_acc->_branch_id)) @if($_s_acc->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($_s_acc->_cost_center)) @if($_s_acc->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr" value="{{$_s_acc->_short_narr ?? '' }}">
                                              </td>
                                               <td class=" @if($__user->_ac_type==1) display_none @endif" >
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',$_s_acc->_dr_amount)}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',$_s_acc->_cr_amount)}}">
                                              </td>
                                            </tr>
                                            @endif
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif"></td>
                                              <td class="@if(sizeof($permited_costcenters)==1) display_none @endif"></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td class=" @if($__user->_ac_type==1) display_none @endif" >
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="{{$_total_dr_amount ?? 0 }}" readonly required>
                                              </td>


                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="{{$_total_cr_amount ?? 0 }}"  readonly required>
                                              </td>
                                            </tr>
                                            
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>