<div class="tab-pane " id="current_salary_structures">
@php
    $previous_detail = $data->_details ?? [];
@endphp
<div class="card">
                <div class="row">
                    @forelse($payheads as $p_key=>$p_val)
                    <div class="col-md-4 ">
                        <h3>{!! $p_key ?? '' !!}</h3>
                        @if(sizeof($p_val) > 0)
                            @forelse($p_val as $l_val)
                            @php
                            //dump($l_val);
                            @endphp
                            <div class="form-group row ">
                            <label class="col-sm-6 col-form-label" for="_item">{{$l_val->_ledger ?? '' }}:</label>
                             <div class="col-sm-6">
                                <input type="hidden" name="_payhead_id[]" class="_payhead_id" value="{{$l_val->id}}">
                                <input type="hidden" name="_payhead_type_id[]" class="_payhead_type_id" value="{{$l_val->_type}}">
                               
                              <input type="number"  name="_amount[]" class="form-control payhead_amount @if(isset($l_val->_payhead_type) && $l_val->_payhead_type->cal_type==1) _add_salary @endif  @if($l_val->_payhead_type->cal_type==2) _deduction_salary @endif"
                               @forelse($previous_detail as $p_val)
                                @if($p_val->_payhead_id==$l_val->id)
                                value="{{ $p_val->_amount ?? 0}}"
                               @endif
                              @empty
                              @endforelse

                                placeholder="{{__('label._amount')}}" >
                              <input type="hidden" name="_detail_row_id[]" class="_detail_row_id" 
                              @forelse($previous_detail as $p_val)
                                @if($p_val->_payhead_id==$l_val->id)
                                    value="{{ $p_val->id ?? 0}}"

                               @endif

                              @empty
                              @endforelse

                               >
                              
                            </div>
                        </div>
                        @empty
                        @endforelse
                        @endif
                    </div>

                        @empty
                        @endforelse
                    
                </div>

              <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Earnings:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_earnings" class="form-control total_earnings" value="{{$data->total_earnings ?? 0}}"  readonly>
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Total Deduction:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_deduction" class="form-control total_deduction" value="{{$data->total_deduction ?? 0}}"  readonly>
                        </div>
                    </div>
                    <div class="form-group row pt-2">
                        <label class="col-sm-2 col-form-label" >Net Total Salary:</label>
                         <div class="col-sm-6">
                            <input type="text" name="net_total_earning" class="form-control net_total_earning" value="{{$data->net_total_earning ?? 0}}"  readonly>
                        </div>
                    </div>
        </div>
</div>