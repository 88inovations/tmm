  @php
  $__purchase_account = $data->purchase_account ?? [];
  $___master_details = $data->_master_details ?? [];
  @endphp

 @if(sizeof($___master_details) > 0)
                        
                          
                            <div class="card " >
                              <table class="table">
                                <thead >
                                            <th class="text-left" >ID</th>
                                            <th class="text-left" >Item</th>
                                           
                                            <th class="text-left @if($form_settings->_show_barcode==0) display_none @endif" >Barcode</th>
                                            <th class="text-left" >Unit</th>
                                            
                                            <th class="text-right" >Qty</th>
                                            <th class="text-right" >Rate</th>
                                            <th class="text-right" >Sales Rate</th>
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <th class="text-right" >VAT%</th>
                                            <th class="text-right" >VAT</th>
                                             @else
                                            <th class="text-left display_none" >VAT%</th>
                                            <th class="text-left display_none" >VAT</th>
                                            @endif
                                            @endif

                                            <th class="text-right" >Value</th>
                                             @if(sizeof($permited_branch) > 1)
                                            <th class="text-left" >Branch</th>
                                            @else
                                            <th class="text-left display_none" >Branch</th>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <th class="text-left" >Cost Center</th>
                                            @else
                                             <th class="text-left display_none" >Cost Center</th>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <th class="text-left" >Store</th>
                                            @else
                                             <th class="text-left display_none" >Store</th>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <th class="text-left" >Shelf</th>
                                            @else
                                             <th class="text-left display_none" >Shelf</th>
                                            @endif
                                            @endif
                                           
                                          </thead>
                                <tbody>
                                  @php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                  @endphp
                                  @forelse($data->_master_details AS $item_key=>$_item )
                                  <tr>
                                     <th class="" >{{$_item->id}}</th>
                                     @php
                                      $_value_total +=$_item->_value ?? 0;
                                      $_vat_total += $_item->_vat_amount ?? 0;
                                      $_qty_total += $_item->_qty ?? 0;
                                     @endphp
                                            <td class="" >{!! $_item->_items->_name ?? '' !!}</td>
                                           
                                            <td class="@if($form_settings->_show_barcode==0) display_none @endif">
                                               @php
                                          $barcode_arrays = explode(',', $_item->_barcode ?? '');
                                          @endphp
                                          @forelse($barcode_arrays as $barcode)
                                        <span>{{$barcode}}</span><br>
                                          @empty
                                          @endforelse
                                              </td>
                                           
                                            <td class="text-left" >{!! $_item->_trans_unit->_name ?? '' !!}</td>
                                            <td class="text-right" >{!! $_item->_qty ?? 0 !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_rate ?? 0) !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_sales_rate ?? 0) !!}</td>
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <td class="text-right" >{!! $_item->_vat ?? 0 !!}</td>
                                            <td class="text-right" >{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                             @else
                                            <td class="text-right display_none" >{!! $_item->_vat ?? 0 !!}</td>
                                            <td class="text-right display_none" >{!! _report_amount($_item->_vat_amount ?? 0) !!}</td>
                                            @endif
                                            @endif

                                            <td class="text-right" >{!! _report_amount($_item->_value ?? 0) !!}</td>
                                             @if(sizeof($permited_branch) > 1)
                                            <td class="" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @else
                                            <td class=" display_none" >{!! $_item->_detail_branch->_name ?? '' !!}</td>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <td class="" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_detail_cost_center->_name ?? '' !!}</td>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <td class="" >{!! $_item->_store->_name ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_store->_name ?? '' !!}</td>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <td class="" >{!! $_item->_store_salves_id ?? '' !!}</td>
                                            @else
                                             <td class=" display_none" >{!! $_item->_store_salves_id ?? '' !!}</td>
                                            @endif
                                            @endif
                                           
                                          </thead>
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                              <td>
                                                
                                              </td>
                                              <td  class="text-right"><b>Total</b></td>
                                              
                                              <td  class="text-right @if($form_settings->_show_barcode==0) display_none @endif"></td>
                                              <td></td>
                                              
                                              <td class="text-right">
                                                <b>{{ $_qty_total ?? 0}}</b>
                                                


                                              </td>
                                              <td></td>
                                              <td></td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td></td>
                                              <td class="text-right">
                                                <b>{{_report_amount($_vat_total ?? 0)}}</b>
                                              </td>
                                              @else
                                              <td class="display_none"></td>
                                              <td class="text-right display_none">
                                                 <b>{{ _report_amount($_vat_total ?? 0) }}</b>
                                              </td>
                                              @endif
                                              @endif
                                              <td class="text-right">
                                               <b> {{ _report_amount($_value_total ?? 0) }}</b>
                                              </td>
                                              @if(sizeof($permited_branch) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif

                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td></td>
                                              @else
                                              @endif
                                              <td class="display_none"></td>
                                              @endif
                                            </tr>
                                </tfoot>
                              </table>
                            </div>
                          
                        @endif
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
                                  @forelse($data->purchase_account AS $detail_key=>$_master_val )
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