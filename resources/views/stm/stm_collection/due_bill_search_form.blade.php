
@php
$_student_table_id  = $student_info->id;
$_user_table_id  = $student_info->_user_table_id;
$_admission_session_id = $student_info->_admission_session_id ?? 0;
$_stm_division_id = $student_info->_education_type ?? 0;
$_admission_class_id = $request->_admission_class_id ?? 0;
 $_bill_type          = $request->_bill_type;

@endphp


<div  class="p-2 purple_bg">
@if(sizeof($datas) > 0)
    <form action="{{ route('stm_collection.store') }}" method="POST">
        @csrf
        <div class="card p-2 purple_bg" >
        <div class="row">
        <div class="form-group col-md-3">
            <label for="_date">Date</label>
            <div class="width_250_px">
            <input type="date" name="_date" class="form-control " value="{{date('Y-m-d')}}" required>
            
            <input type="hidden" name="_student_table_id" value="{{$_student_table_id ?? 0}}">
            <input type="hidden" name="_user_table_id" value="{{$_user_table_id ?? 0}}">
           
            <input type="hidden" name="_admission_class_id" value="{{$_admission_class_id ?? 0}}">
            <input type="hidden" name="_form_name" value="stm_collection_masters">
            <input type="hidden" name="stm_collection_id" value="0">
                
            </div>
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id">{{__('label._admission_session_id')}}</label>
            <select class="form-control _admission_session_id" name="_admission_session_id">
                <option value="{{$_admission_session_id}}">
                {!! _id_to_name($_admission_session_id,'_name','stm_education_sessions') !!}</option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_stm_division_id">{{__('label._stm_division_id')}}</label>
            <select class="form-control _stm_division_id" name="_stm_division_id">
                <option value="{{$_stm_division_id}}">
                {!! _id_to_name($_stm_division_id,'_name','stm_divisions') !!}</option>
            </select>
            
        </div>

        <div class="col-md-3 col-sm-12">
            <label for="_admission_class_id">{{__('label._admission_class_id')}}</label>
            <select class="form-control _admission_class_id" name="_admission_class_id">
                <option value="{{$_admission_class_id}}">
                {!! _id_to_name($_admission_class_id,'_name','stm_classes') !!}</option>
            </select>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_student_id">{{__('label._student_id')}}</label>
            <input type="text" name="_student_id" class="form-control _student_id" value="{!! $student_info->_student_id ?? '' !!}" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_name_in_english">{{__('label._name_in_english')}}</label>
            <input type="text" name="_name_in_english" class="form-control _name_in_english" value="{!! $student_info->_name_in_english ?? '' !!}" readonly>
            
        </div>
        <div class="col-md-3 col-sm-12">
            <label for="_father_name_english">{{__('label._father_name_english')}}</label>
            <input type="text" name="_father_name_english" class="form-control _father_name_english" value="{!! $student_info->_father_name_english ?? '' !!}" readonly>
            
        </div>

        <div class="form-group @if(sizeof($permited_organizations) == 1) display_none @endif col-md-3">
            <label for="organization_id">{{__('label.organization_id')}}</label>
            <div class="">
                <select name="organization_id" class="form-control " required>
                @forelse($permited_organizations as $org)
                    <option value="{{ $org->id }}">{{ $org->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
            </div>
            
        </div>

        <div class="form-group @if(sizeof($permited_branch) == 1) display_none @endif col-md-3">
            <label for="_branch_id">{{__('label._branch_id')}}</label>
            <select name="_branch_id" class="form-control " required>
                @forelse($permited_branch as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="form-group  @if(sizeof($permited_costcenters) == 1) display_none @endif col-md-3">
            <label for="_cost_center_id">{{__('label._cost_center_id')}}</label>
            <select name="_cost_center_id" class="form-control ">
                @forelse($permited_costcenters as $center)
                    <option value="{{ $center->id }}">{{ $center->_name ?? '' }}</option>
                @empty
                @endforelse
            </select>
        </div>

@php
$bill_types =_fees_types();
$_bill_type  = $request->_bill_type ?? '_admission_fee';
$_make_ledger_coloumn_name = $_bill_type.'_ledger';
@endphp
       <div class="form-group col-md-3">
            <label for="_bill_type">Bill Type</label>
            <select name="_bill_type" class="form-control ">
                <option value="{{$_bill_type}}">{{$bill_types[$_bill_type] ?? ''}}</option>
            </select>
        </div>

       
        <div class="form-group col-md-3">
            <label for="_roshid_book_no">{{__('label._roshid_book_no')}}</label>
            <input type="text" name="_roshid_book_no" class="form-control _roshid_book_no " value="{{old('_roshid_book_no',$data->_roshid_book_no ?? '')}}">
        </div>
        <div class="form-group col-md-3">
            <label for="_roshid_no">{{__('label._roshid_no')}}</label>
            <input type="text" name="_roshid_no" class="form-control _roshid_no " value="{{old('_roshid_no',$data->_roshid_no ?? '')}}">
        </div>
</div>
</div>
      <div class="col-md-12">
          <div class="card">
              <table class="table table-bordered">
                   <thead>
                        <tr>
                        <th>&nbsp;</th>
                        <th>{{__('label.sl')}}</th>
                        <th>Month </th>
                        <th>Year </th>
                        <th>Fee </th>
                        <th>Pre. Receive </th>
                        <th>Pre. Due Amount </th>
                        <th>{{__('label._collection_ledger')}}</th>
                        <th>{{__('label.collect_amount')}}</th>
                        <th>{{__('label._discount_amount')}}</th>
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
$_grand_discount_amount   = 0;
$_grand_due_balance   = 0;
@endphp
                          @forelse($datas as $key=> $data)
@php
$_grand_total                   +=$data->_fee_amount ??  0;
$_grand_due_balance             +=$data->_due_amount ??  0;
$_grand_receive_amount          +=$data->_receive_amount ??  0;
$_grand_due_amount              +=$data->_due_amount ??  0;
$_grand_discount_amount         +=$data->_discount_amount ??  0;
@endphp
                          <tr class="_voucher_row">
                                              <td>
                                                

                                                <input type="hidden" name="_session_id[]" value="{{$data->_session_id ?? 0}}">
                                                <input type="hidden" name="_month_id[]" value="{{$data->_month_id ?? 0}}">
                                                <input type="hidden" name="_year[]" value="{{$data->_year ?? 0}}">
                                                <input type="hidden" name="stm_bill_master_details_id[]" value="{{$data->id ?? 0}}">
                                                <input type="hidden" name="stm_bill_collections_id[]" value="0">
                                                
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;">{!! _number_to_month($data->_month_id ?? '' ) !!}  </td>
                                              <td style="white-space: nowrap;">{!! $data->_year ?? '' !!}  </td>
                                              
                                            
                                              
                                              
                                             
                                            
                                               <td>
                                                <input type="number" min="0" step="any" name="_fee_amount[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$data->_fee_amount ?? 0)}}" readonly>

                                                
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="Receive Amount" value="{{$data->_receive_amount ?? 0}}" readonly="">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="Due Amount" value="{{$data->_due_amount ?? 0}}" readonly="">
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
                                                <input type="number"  type="number" min="0" max="{{$data->_fee_amount ?? 0}}" step="any" name="_collection_amount[]" class="form-control _collection_discount_amount  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$data->_collection_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0"  step="any" name="_discount_amount[]" class="form-control _collection_discount_amount  _discount_amount" placeholder="{{__('label._discount_amount')}}" value="{{old('_discount_amount',$data->_discount_amount ?? 0)}}" >
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
                                              <td colspan="4">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="{{$_grand_receive_amount ?? 0}}" readonly="">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="{{$_grand_due_amount ?? 0}}" readonly="">
                                              </td>
                                              <td></td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{$_grand_collection_amount}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_discount_amount" class="form-control  _grand_discount_amount" placeholder="{{__('label._discount_amount')}}" value="{{$_grand_discount_amount}}" readonly>
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
      

        <div class="form-group">
            <label for="_note">Note <span class="_required">*</span></label>
            <textarea name="_note" rows="3" class="form-control" required>{!! old('_note') !!}</textarea>
        </div>

       
        <div class="text-center p-4">
        <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </form>
@else

<h3 class="text-center">No Data Found</h3>
@endif

</div>