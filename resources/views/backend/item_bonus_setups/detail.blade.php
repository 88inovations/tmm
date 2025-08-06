  
                        
                          
                            <div class="card " >
                              <table class="table">
                                <thead >
                                  <th class="text-left">ID</th>
                                  <th class="text-left">Item</th>
                                  <th class="text-left">Unit</th>
                                  <th class="text-left">Code</th>
                                  <th class="text-right">QTY</th>
                                  <th class="text-right">Rate</th>
                                  <th class="text-right">Value</th>
                                  <th class="text-right">Wastage Amount</th>
                                  <th class="text-right">Wastage Rate</th>
                                  <th class="text-left">Status</th>
                                </thead>
                                <tbody>
                                  @php
                                  $_total_qty=0;
                                  $_total_value=0;
                                  $_total_wastage_amt=0;
                                  @endphp
                                  @forelse($_input_details as $key=>$value)
                                  @php
                                  $_total_qty +=$value->_qty ?? 0;
                                  $_total_value +=$value->_value ?? 0;
                                  $_total_wastage_amt +=$value->_wastage_amt ?? 0 ;
                                  @endphp
                                  <tr>
                                    <td>{{($key+1)}}</td>
                                    <td>{{$value->_item ?? '' }}</td>
                                    <td>{{$value->_unit ?? '' }}</td>
                                    <td>{{$value->_code ?? '' }}</td>
                                    <td class="text-right">{{_report_amount($value->_qty ?? 0) }}</td>
                                    <td class="text-right">{{_report_amount($value->_rate ?? 0) }}</td>
                                    <td class="text-right">{{_report_amount($value->_value ?? 0) }}</td>
                                    <td class="text-right">{{_report_amount($value->_wastage_amt ?? 0) }}</td>
                                    <td class="text-right">{{_report_amount($value->_wastage_rate ?? 0) }}</td>
                                    <td>{{ selected_status($value->_status ?? 0) }}</td>
                                  </tr>
                                  @empty
                                  @endforelse
                                  
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="4" class="text-right"><b>Total</b></td>
                                    <td class="text-right"><b>{{$_total_qty}}</b></td>
                                    <td></td>
                                    <td class="text-right"><b>{{_report_amount($_total_value)}}</b></td>
                                    <td class="text-right"><b>{{_report_amount($_total_wastage_amt)}}</b></td>
                                    <td></td>
                                    <td></td>
                                  </tr>        
                                </tfoot>
                              </table>
                            </div>

                            <div class="card " >
                              <div class="card-header"></div>
                              <div class="card-body">
                              <table class="table">
                                <thead >
                                  <th class="text-left">ID</th>
                                  <th class="text-left">Expense/Profite</th>
                                  <th class="text-left">Narration</th>
                                  <th class="text-right">Amount</th>
                                  <th class="text-left">Status</th>
                                </thead>
                                <tbody>
                                  @php
                                  $_total_amount=0;
                                  @endphp
                                  @forelse($_addition_details as $key=>$value)
                                   @php
                                  $_total_amount +=$value->_amount ?? 0;
                                  @endphp
                                  <tr>
                                    <td>{{($key+1)}}</td>
                                    <td>{{$value->_name ?? '' }}</td>
                                    <td>{{$value->_short_narr ?? '' }}</td>
                                    <td class="text-right">{{ _report_amount($value->_amount ?? 0) }}</td>
                                    <td>{{ selected_status($value->_status ?? 0) }}</td>
                                  </tr>
                                  @empty
                                  @endforelse
                                  
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="3" class="text-right"><b>Total</b></td>
                                    <td class="text-right"><b>{{_report_amount($_total_amount)}}</b></td>
                                    <td></td>
                                    
                                  </tr>        
                                </tfoot>
                              </table>
                              </div>
                            </div>
                          
                        