 


@if(sizeof($datas) > 0)
 <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <tr>
                                            <th>&nbsp;</th>
                                            <th>{{__('label.sl')}}</th>
                                            <th>{{__('label._date')}}</th>
                                            <th>{{__('label._order_number')}}</th>
                                            <th>Terms</th>
                                            <th>Ref</th>
                                            <th>Sales Amount</th>
                                            <th>Pre.{{__('label._receive_amount')}}</th>
                                            <th>Pre.{{__('label._due_amount')}}</th>
                                            <th>{{__('label._collection_ledger')}}</th>
                                            <th>{{__('label.collect_amount')}}</th>
                                            <th>{{__('label.current_due')}}</th>
                                            <th>{{__('label._is_close')}}</th>
                                            <th>{{__('label.effect')}}</th>
                                          </tr>
                                          </thead>
                                          <tbody>
@php
$_grand_total   = 0;
$_grand_receive_amount   = 0;
$_grand_due_amount   = 0;
$_grand_collection_amount   = 0;
$_grand_due_balance   = 0;
@endphp
@forelse($datas as $key=>$data)



@php
$_grand_total            +=$data->_total ??  0;
$_grand_receive_amount   +=$data->_receive_amount ?? 0;
$_grand_due_amount       +=$data->_due_amount ?? 0;
$_grand_collection_amount +=$data->_collection_amount ?? 0;
$_grand_due_balance       += $data->_due_amount ?? 0;
@endphp

                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm  btn-danger due_invoice_row" onclick="return confirm('Are you sure!')"><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;"> {!! _view_date_formate($data->_date ?? '') !!}
                                                <input type="hidden" name="sales_id[]" value="{{$data->id ?? 0 }}">
                                                <input type="hidden" name="_order_number[]" value="{{$data->_order_number ?? ''}}">
                                              </td>
                                              <td style="white-space: nowrap;"> {!! $data->_order_number ?? '' !!} </td>
                                              <td style="white-space: nowrap;"> {{ _id_to_name($data->_payment_terms,'_name','transection_terms') }} </td>
                                              <td style="white-space: nowrap;"> {!! $val->_referance ?? '' !!}</td>
                                               <td>
                                                <input type="number" min="0" step="any" name="_total[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$data->_total ?? 0)}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="{{__('label._receive_amount')}}" value="{{old('_receive_amount',$data->_receive_amount ?? 0)}}" readonly>
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="{{__('label._due_amount')}}" value="{{old('_due_amount',$data->_due_amount ?? 0)}}" readonly>
                                              </td>
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    @forelse($collection_ledgers as $c_ledger)
                                                     <option value="{{$c_ledger->id ?? 0}}">{{$c_ledger->_code ?? ''}}-{{$c_ledger->_name ?? 0}}</option>
                                                     @empty
                                                     @endforelse
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" max="{{$data->_due_amount ?? 0}}" step="any" name="_collection_amount[]" class="form-control  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$data->_collection_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="{{__('label._due_balance')}}" value="{{old('_due_balance',$data->_due_amount ?? 0)}}" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0">Open</option>
                                                  <option value="1">Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                                </select>
                                               </td>
                                            </tr>
                                @empty

                                @endforelse
                                          </tbody>
                                          <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="6">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="{{$_grand_receive_amount}}" readonly="">
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="{{$_grand_due_amount}}" readonly="">
                                              </td>
                                               <td> 
                                                   </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="Collection Amount" value="{{$_grand_collection_amount}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_balance" class="form-control  _grand_due_balance" placeholder="label._due_balance" value="{{$_grand_due_balance}}" readonly="">
                                              </td>
                                             
                                             
                                              <td> </td>
                                               <td></td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                               
                            </div>
                          </div>
                        </div>
        @else
        <div style="width: 100%;">
            <h4 style="text-align:center;color: red;">No Data Found</h4>
        </div>
        @endif

