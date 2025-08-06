 <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong> Receive Details</strong>
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
                                            <th>Receive Amount</th>
                                            <th style="display: none;">Cr. Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            @php
                                              $_account_dr_total = 0;
                                              $_account_cr_total = 0;
                                            @endphp
                                            @forelse($data->s_account as $account)
                                            

                                            @php
                                              $_account_dr_total += $account->_dr_amount ?? 0;
                                              $_account_cr_total += $account->_cr_amount ?? 0;
                                            @endphp
                                            @if($data->_ledger_id !=$account->_ledger_id)
                                            <tr class="_voucher_row  ">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                                <input type="hidden" name="purchase_account_id[]" class="form-control purchase_account_id" value="{{$account->id}}">
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" value="{{ $account->_ledger->_name ?? '' }}" @if($__user->_ac_type==1) attr_account_head_no="1" @endif>
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" value="{{$account->_ledger_id}}" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                              
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($account->_branch_id)) @if($account->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required  >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($account->_cost_center)) @if($account->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr" value="{{$account->_short_narr ?? '' }}">
                                              </td>
                                              <td>
                                                <input type="number" min="0"  name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',$account->_dr_amount ?? 0 )}}">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" min="0"  name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',$account->_cr_amount ?? 0 )}}">
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
                                              <td>
                                                <input type="number" min="0"  step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="{{_php_round($_account_dr_total)}}" readonly required>
                                              </td>


                                              <td class="display_none">
                                                <input type="number" min="0"  step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="{{_php_round($_account_cr_total)}}" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>