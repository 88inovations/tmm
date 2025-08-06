@php
  $__purchase_account = $data->purchase_order_account ?? [];

  @endphp

@if(sizeof($__purchase_account) > 0)
                        
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>Ledger</th>
                                  <th>Branch</th>
                                  <th>Cost Center</th>
                                  <th>Short Narr.</th>
                                  <th class="text-right" >Dr. Amount</th>
                                  <th class="text-right" >Cr. Amount</th>
                                </thead>
                                <tbody>
                                  @php
                                    $_dr_amount = 0;
                                    $_cr_amount = 0;
                                  @endphp
                                  @forelse($__purchase_account AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_ledger->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_branch->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_detail_cost_center->_name ?? '' }}</td>
                                    <td>{{ $_master_val->_short_narr ?? '' }}</td>
                  <td class="text-right">{{ _report_amount( $_master_val->_dr_amount ?? 0) }}</td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_cr_amount ?? 0) }} </td>
                                    @php 
                                    $_dr_amount += $_master_val->_dr_amount;   
                                    $_cr_amount += $_master_val->_cr_amount;  
                                    @endphp
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b>{{ _report_amount($_dr_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_cr_amount ?? 0 ) }} </b></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          
                        @endif