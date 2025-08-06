@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<div class="container">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_import_cost_list')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            @can('asset_import_cost_create')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.create')}}">Add New</a></li>
            @endcan
            
            <li class="breadcrumb-item active">
           
           <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#importModal"> Upload File</button>
            </li>
          </ol>
        </nav>
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Upload Members Excel File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ route('import_asset_file_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                     
                    
                        <div class="form-group">
                            <label for="file">Choose Excel File:</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('asset_import_cost.store') }}" enctype='multipart/form-data'>
        @csrf
          
          <div class="row g-5">
          
             @php
            $id = $data->id ?? '';
             @endphp
              <input type="hidden" name="_form_name" value="asset_import_costs">
              <input type="hidden" name="id" value="{{$data->id ?? ''}}">
              @if($id !='')
              <div class="col-md-12">
              <h4 class="mb-1">{{__('label._order_number')}}<span class="_required">*</span></h4>
              <input required class="form-control width_150px mb-2 @error('_order_number') is-invalid @enderror" name="_order_number" type="text" placeholder="{{__('label._order_number')}}" value="{!! old('_order_number',$data->_order_number ?? '' ) !!}" readonly />
            </div>
            @endif
<div class="col-md-3">
  <h4 class="mb-1">{{__('label._date')}}<span class="_required">*</span></h4>
              <input required class="form-control width_250px mb-2 @error('_date') is-invalid @enderror" name="_date" type="date" placeholder="{{__('label._date')}}" value="{!! old('_date',$data->_date ?? date('Y-m-d')) !!}" />
</div>
@php
$_purchase_type = $data->_purchase_type ?? '';
@endphp
<div class="col-md-3">
  <h4 class="mb-1">{{__('label._purchase_type')}}<span class="_required">*</span></h4>
              <select class="form-control _purchase_type" name="_purchase_type" required>
                <option value=""><---{{__('label._purchase_type')}}---></option>
                <option value="Import" @if($_purchase_type=="Import") selected @endif>Import</option>
                <option value="Local" @if($_purchase_type=="Local") selected @endif>Local</option>
                <option value="Opening" @if($_purchase_type=="Opening") selected @endif>Opening</option>
              </select>
</div>
<div class="col-md-3">
  <h4 class="mb-1">{{__('label._voucher_number')}}</h4>
              <input  class="form-control mb-2 @error('_voucher_number') is-invalid @enderror" name="_voucher_number" type="text" placeholder="{{__('label._voucher_number')}}" value="{!! old('_voucher_number',$data->_voucher_number ?? '' ) !!}" />
</div>
<div class="col-md-3">
  <h4 class="mb-1">{{__('label._supplier_name')}}<span class="_required">*</span></h4>
              <input required class="form-control mb-2 @error('_supplier_name') is-invalid @enderror" name="_supplier_name" type="text" placeholder="{{__('label._supplier_name')}}" value="{!! old('_supplier_name',$data->_supplier_name ?? '' ) !!}" />
</div>

              
 <div class="col-md-3 ">             
              <h4 class="mb-1">{{__('label._bank_name')}}</h4>
              <input class="form-control mb-2 @error('_bank_name') is-invalid @enderror" name="_bank_name" type="text" placeholder="{{__('label._bank_name')}}" value="{!! old('_bank_name',$data->_bank_name ?? '' ) !!}" />
  </div>
  <div class="col-md-3">
              <h4 class="mb-1">{{__('label._branch_name')}}</h4>
              <input class="form-control mb-2 @error('_branch_name') is-invalid @enderror" name="_branch_name" type="text" placeholder="{{__('label._branch_name')}}" value="{!! old('_branch_name',$data->_branch_name ?? '' ) !!}" />
  </div>
  <div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._lc_no')}}</h4>
              <input class="form-control mb-2 @error('_lc_no') is-invalid @enderror" name="_lc_no" type="text" placeholder="{{__('label._lc_no')}}" value="{!! old('_lc_no',$data->_lc_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">             
              <h4 class="mb-1">{{__('label._lc_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_lc_date') is-invalid @enderror" name="_lc_date" type="date" placeholder="{{__('label._lc_date')}}" value="{!! old('_lc_date',$data->_lc_date ?? date('Y-m-d')) !!}" />
</div>
  <div class="col-md-3  display_none">
              <h4 class="mb-1">{{__('label._pi_no')}}</h4>
              <input class="form-control mb-2 @error('_pi_no') is-invalid @enderror" name="_pi_no" type="text" placeholder="{{__('label._pi_no')}}" value="{!! old('_pi_no',$data->_pi_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  display_none">             
              <h4 class="mb-1">{{__('label._pi_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_pi_date') is-invalid @enderror" name="_pi_date" type="date" placeholder="{{__('label._pi_date')}}" value="{!! old('_pi_date',$data->_pi_date ?? '') !!}" />
</div>
  <div class="col-md-3  ">
              <h4 class="mb-1">{{__('label._invoice_no')}}</h4>
              <input class="form-control mb-2 @error('_invoice_no') is-invalid @enderror" name="_invoice_no" type="text" placeholder="{{__('label._invoice_no')}}" value="{!! old('_invoice_no',$data->_invoice_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  ">             
              <h4 class="mb-1">{{__('label._invoice_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_invoice_date') is-invalid @enderror" name="_invoice_date" type="date" placeholder="{{__('label._invoice_date')}}" value="{!! old('_invoice_date',$data->_invoice_date ?? '') !!}" />
</div>
  <div class="col-md-3  ">
              <h4 class="mb-1">{{__('label._boe_no')}}</h4>
              <input class="form-control mb-2 @error('_boe_no') is-invalid @enderror" name="_boe_no" type="text" placeholder="{{__('label._boe_no')}}" value="{!! old('_boe_no',$data->_boe_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  ">             
              <h4 class="mb-1">{{__('label._boe_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_boe_date') is-invalid @enderror" name="_boe_date" type="date" placeholder="{{__('label._boe_date')}}" value="{!! old('_boe_date',$data->_boe_date ?? '') !!}" />
</div>
  <div class="col-md-3  ">
              <h4 class="mb-1">{{__('label._bl_no')}}</h4>
              <input class="form-control mb-2 @error('_bl_no') is-invalid @enderror" name="_bl_no" type="text" placeholder="{{__('label._bl_no')}}" value="{!! old('_bl_no',$data->_bl_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  ">             
              <h4 class="mb-1">{{__('label._bl_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_bl_date') is-invalid @enderror" name="_bl_date" type="date" placeholder="{{__('label._bl_date')}}" value="{!! old('_bl_date',$data->_bl_date ?? '') !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif "> 
              <h4 class="mb-1">{{__('label._incoterms')}}</h4>
              <input class="form-control mb-2 @error('_incoterms') is-invalid @enderror" name="_incoterms" type="text" placeholder="{{__('label._incoterms')}}" value="{!! old('_incoterms',$data->_incoterms ?? '' ) !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif "> 
              <h4 class="mb-1">{{__('label._import_currency')}}</h4>
              <input class="form-control mb-2 @error('_import_currency') is-invalid @enderror" name="_import_currency" type="text" placeholder="{{__('label._import_currency')}}" value="{!! old('_import_currency',$data->_import_currency ?? '' ) !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif "> 
              <h4 class="mb-1">{{__('label._currency_rate')}}</h4>
              <input class="form-control mb-2 @error('_currency_rate') is-invalid @enderror" name="_currency_rate" type="number" min="0" step="any" placeholder="{{__('label._currency_rate')}}" value="{!! old('_currency_rate',$data->_currency_rate ?? '' ) !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif "> 
              <h4 class="mb-1">{{__('label._bill_of_entry_no')}}</h4>
              <input class="form-control mb-2 @error('_bill_of_entry_no') is-invalid @enderror" name="_bill_of_entry_no" type="text" placeholder="{{__('label._bill_of_entry_no')}}" value="{!! old('_bill_of_entry_no',$data->_bill_of_entry_no ?? '' ) !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._bill_of_entry_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_bill_of_entry_date') is-invalid @enderror" name="_bill_of_entry_date" type="date" placeholder="{{__('label._bill_of_entry_date')}}" value="{!! old('_bill_of_entry_date',$data->_bill_of_entry_date ?? date('Y-m-d')) !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._date_of_arrival')}}</h4>
              <input class="form-control width_250px mb-2 @error('_date_of_arrival') is-invalid @enderror" name="_date_of_arrival" type="date" placeholder="{{__('label._date_of_arrival')}}" value="{!! old('_date_of_arrival',$data->_date_of_arrival ?? '') !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._ammendment_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_ammendment_date') is-invalid @enderror" name="_ammendment_date" type="date" placeholder="{{__('label._ammendment_date')}}" value="{!! old('_ammendment_date',$data->_ammendment_date ?? '') !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._ammendment_reason')}}</h4>
              <input class="form-control width_250px mb-2 @error('_ammendment_reason') is-invalid @enderror" name="_ammendment_reason" type="text" placeholder="{{__('label._ammendment_reason')}}" value="{!! old('_ammendment_reason',$data->_ammendment_reason ?? '') !!}" />
</div>

<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._procurement_officer')}}</h4>
              <input class="form-control width_250px mb-2 @error('_procurement_officer') is-invalid @enderror" name="_procurement_officer" type="text" placeholder="{{__('label._procurement_officer')}}" value="{!! old('_procurement_officer',$data->_procurement_officer ?? '') !!}" />
</div>
<div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif ">
              <h4 class="mb-1">{{__('label._cnf_agent')}}</h4>
              <input class="form-control width_250px mb-2 @error('_cnf_agent') is-invalid @enderror" name="_cnf_agent" type="text" placeholder="{{__('label._cnf_agent')}}" value="{!! old('_cnf_agent',$data->_cnf_agent ?? '') !!}" />
              <input class="form-control width_250px mb-2 @error('_cnf_agent_id') is-invalid @enderror" name="_cnf_agent_id" type="text" placeholder="{{__('label._cnf_agent_id')}}" value="{!! old('_cnf_agent_id',$data->_cnf_agent_id ?? '') !!}" />
</div>
</div>
              <div class="row g-5">
                <div class="table-responsive">
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>{{__('label._ledger_id')}}</th>
                      <th>{{__('label._name')}}</th>
                      <th>{{__('label._unit_id')}}</th>
                      <th>{{__('label._qty')}}</th>
                      <th>{{__('label._rate_usd')}}</th>
                      <th>{{__('label._cfr_value_usd')}}</th>
                      <th>{{__('label._currency_rate_usd_to_bdt')}}</th>
                      <th>{{__('label._cfr_value_bdt')}}</th>
                      <th>{{__('label._insurance_bdt')}}</th>
                      <th>{{__('label._lc_commision_bdt')}}</th>
                      <th>{{__('label._custom_duty_bdt')}}</th>
                      <th>{{__('label._other_cost_bdt')}}</th>
                      <th>{{__('label._asset_value_bdt')}}</th>
                    </tr>
                  </thead>
                  <tbody class="cost_row_body">
                    @php
$_details = $data->_details ?? [];
                    @endphp
  @if(sizeof($_details) > 0)
  @forelse($_details as $key=>$detail)
                    <tr class="">
                      <td> <button class="btn btn-danger costRowRemove" type="button">X</button></td>
                      <td>
                        @php
$_asset_category_id = $detail->_asset_category_id ?? '';
                        @endphp
                        <select class="form-control _asset_category_id width_250px" name="_asset_category_id[]" required>
                          <option value="0"><---Select---></option>
                          @forelse($_asset_ledgers as $ledger)
                          <option value="{{$ledger->id ?? ''}}" @if($ledger->id==$_asset_category_id) selected @endif >{!! $ledger->_name ?? '' !!}</option>
 
                          @empty
                          @endif
                        </select>
                      </td>
                      <td>
                        <input class="form-control _asset_name" type="text" name="_asset_name[]" value="{{$detail->_asset_name ?? ''}}">
                        <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="{{$detail->id ?? ''}}">
                      </td>
                      <td>
                        <select class="form-control _unit_id width_150px" name="_unit_id[]">
                          <option value="0"><---Unit---></option>
                            @forelse($units as $unit)
                          <option value="{{$unit->id}}" @if($detail->_unit_id==$unit->id) selected @endif >{{$unit->_name ?? '' }}</option>
                            @empty
                            @endforelse
                        </select>
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="{{$detail->_qty ?? 0}}"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="{{$detail->_rate_usd ?? 0}}"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="{{$detail->_cfr_value_usd ?? 0}}" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="{{$detail->_currency_rate_usd_to_bdt ?? 0}}" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="{{$detail->_cfr_value_bdt ?? 0}}" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="{{$detail->_insurance_bdt ?? 0}}" > </td>
                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="{{$detail->_lc_commision_bdt ?? 0}}" ></td>
                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="{{$detail->_custom_duty_bdt ?? 0}}" ></td>
                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="{{$detail->_other_cost_bdt ?? 0}}" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="{{_php_round($detail->_asset_value_bdt ?? 0)}}" readonly></td>
                    </tr>
  @empty
  @endforelse
@else
<tr class="">
                      <td> <button class="btn btn-danger costRowRemove" type="button">X</button></td>
                     <td>
                      
                         <select class="form-control _asset_category_id width_250px" name="_asset_category_id[]" required>
                          <option value="0"><---Select---></option>
                          @forelse($_asset_ledgers as $ledger)
                          <option value="{{$ledger->id ?? ''}}"  >{!! $ledger->_name ?? '' !!}</option>
 
                          @empty
                          @endif
                        </select>
                      </td>
                      <td><input class="form-control _asset_name" type="text" name="_asset_name[]" value="">

                      <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="">

                      </td>
                      <td>
                        <select class="form-control _unit_id width_150px" name="_unit_id[]">
                          <option value="0"><---Unit---></option>
                            @forelse($units as $unit)
                          <option value="{{$unit->id}}">{{$unit->_name ?? '' }}</option>
                            @empty
                            @endforelse
                        </select>
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="0"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="0"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="0" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="0" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="0" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="0" > </td>
                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="0" ></td>
                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="0" ></td>
                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="0" readonly></td>
                    </tr>

@endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>
                        <button class="form-control btn btn-primary  addCostRow" type="button">+</button>
                      </th>
                      <th colspan="3">Grand Total</th>
                      <th>
<input class="form-control _total_qty ?? 0 " type="number" min="0" step="any" name="_total_qty" value="{{$data->_total_qty ?? 0 }}" readonly>
                      </th>
                      <th></th>
                      <th>
                        <input class="form-control _total_cfr_value_usd" type="number" min="0" step="any" name="_total_cfr_value_usd" value="{{$data->_total_cfr_value_usd ?? 0}}" readonly>
                     </th>
                     <th></th>
                      <th>
                        <input class="form-control _total_cfr_value_bdt" type="number" min="0" step="any" name="_total_cfr_value_bdt" value="{{$data->_total_cfr_value_bdt ?? 0}}" readonly>
                     </th>
                      <th>
                        <input class="form-control _total_insurance_bdt" type="number" min="0" step="any" name="_total_insurance_bdt" value="{{$data->_total_insurance_bdt ?? 0}}" readonly>
                     </th>
                      <th>
                        <input class="form-control _total_lc_commision_bdt" type="number" min="0" step="any" name="_total_lc_commision_bdt" value="{{$data->_total_lc_commision_bdt ?? 0}}" readonly>
                     </th>
                      <th>
                        <input class="form-control _total_custom_duty_bdt" type="number" min="0" step="any" name="_total_custom_duty_bdt" value="{{$data->_total_custom_duty_bdt ?? 0}}" readonly>
                     </th>
                      <th>
                        <input class="form-control _total_other_cost_bdt" type="number" min="0" step="any" name="_total_other_cost_bdt" value="{{$data->_total_other_cost_bdt ?? 0}}" readonly>
                     </th>
                      <th>
                        <input class="form-control _total_asset_value_bdt" type="number" min="0" step="any" name="_total_asset_value_bdt" value="{{$data->_total_asset_value_bdt ?? 0}}" readonly>
                     </th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
              
             
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._note')}}</h4>
                <textarea class="summernote" name="_note" >{!! old('_note',$data->_note ?? '') !!}</textarea>
              </div>
             
              
              

          
            
          <div class="col-12 ">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>
        </form>
</div>
        @endsection

@section('script')
  <script>
   

    $(function () { $('.summernote').summernote(); })

    $(document).on("click",".addCostRow",function(){
            $(".cost_row_body").append(`<tr class="">
                      <td> <button class="btn btn-danger costRowRemove" type="button">X</button></td>
                      <td>
                      
                        <select class="form-control _asset_category_id width_250px" name="_asset_category_id[]" required>
                          <option value="0"><---Select---></option>

                          @forelse($_asset_ledgers as $ledger)
                          <option value="{{$ledger->id ?? ''}}"  >{!! $ledger->_name ?? '' !!}</option>
 
                          @empty
                          @endif
                        </select>
                      </td>

                      <td><input class="form-control _asset_name" type="text" name="_asset_name[]" value="">

                      <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="">

                      </td>
                      <td>
                        <select class="form-control _unit_id width_150px" name="_unit_id[]">
                          <option value="0"><---Unit---></option>
                            @forelse($units as $unit)
                          <option value="{{$unit->id}}">{{$unit->_name ?? '' }}</option>
                            @empty
                            @endforelse
                        </select>
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="0"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="0"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="0" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="0" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="0" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="0" > </td>
                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="0" ></td>
                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="0" ></td>
                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="0" readonly></td>
                    </tr>`);

    })


    $(document).on("click",".costRowRemove",function(){
      $(this).closest("tr").remove();
      _cost_gross_total_calculation();

    })



    $(document).on("keyup","._cccenter",function(){
      var __global_this = $(this);
      single_line_sum_calculation(__global_this)
    })

    function single_line_sum_calculation(__global_this){
      console.log(__global_this)
      var _qty = parseFloat(__global_this.closest("tr").find("._qty").val());
      if(isNaN(_qty)){_qty=0}
      var _rate_usd = parseFloat(__global_this.closest("tr").find("._rate_usd").val());
      if(isNaN(_rate_usd)){_rate_usd=0}
      var _cfr_value_usd = parseFloat(parseFloat(_rate_usd)*parseFloat(_qty));
      __global_this.closest("tr").find("._cfr_value_usd").val(_cfr_value_usd);

      var _currency_rate_usd_to_bdt = parseFloat(__global_this.closest("tr").find("._currency_rate_usd_to_bdt").val());
      if(isNaN(_currency_rate_usd_to_bdt)){_currency_rate_usd_to_bdt=0}
      

      var _cfr_value_bdt = parseFloat(parseFloat(_cfr_value_usd)*parseFloat(_currency_rate_usd_to_bdt)).toFixed(2);
      __global_this.closest("tr").find("._cfr_value_bdt").val(_cfr_value_bdt);

      var _insurance_bdt = parseFloat(__global_this.closest("tr").find("._insurance_bdt").val());
      if(isNaN(_insurance_bdt)){_insurance_bdt=0}

      var _lc_commision_bdt = parseFloat(__global_this.closest("tr").find("._lc_commision_bdt").val());
      if(isNaN(_lc_commision_bdt)){_lc_commision_bdt=0}

      var _custom_duty_bdt = parseFloat(__global_this.closest("tr").find("._custom_duty_bdt").val());
      if(isNaN(_custom_duty_bdt)){_custom_duty_bdt=0}

      var _other_cost_bdt = parseFloat(parseFloat(_lc_commision_bdt)+parseFloat(_custom_duty_bdt)+parseFloat(_insurance_bdt)).toFixed(2);
     __global_this.closest("tr").find("._other_cost_bdt").val(_other_cost_bdt);

     var _asset_value_bdt = parseFloat(parseFloat(_other_cost_bdt)+parseFloat(_cfr_value_bdt));
     __global_this.closest("tr").find("._asset_value_bdt").val(_asset_value_bdt);

     _cost_gross_total_calculation();
    }


    $(document).on("keyup","._cfr_value_bdt",function(){
      var __global_this = $(this);

      console.log(__global_this)
      var _qty = parseFloat(__global_this.closest("tr").find("._qty").val());
      if(isNaN(_qty)){_qty=0}
      // var _rate_usd = parseFloat(__global_this.closest("tr").find("._rate_usd").val());
      // if(isNaN(_rate_usd)){_rate_usd=0}
      // var _cfr_value_usd = parseFloat(parseFloat(_rate_usd)*parseFloat(_qty));
      // __global_this.closest("tr").find("._cfr_value_usd").val(_cfr_value_usd);

      // var _currency_rate_usd_to_bdt = parseFloat(__global_this.closest("tr").find("._currency_rate_usd_to_bdt").val());
      // if(isNaN(_currency_rate_usd_to_bdt)){_currency_rate_usd_to_bdt=0}
      

     
    var _cfr_value_bdt = __global_this.closest("tr").find("._cfr_value_bdt").val();
    if(isNaN(_cfr_value_bdt)){_cfr_value_bdt = 0 }

      var _insurance_bdt = parseFloat(__global_this.closest("tr").find("._insurance_bdt").val());
      if(isNaN(_insurance_bdt)){_insurance_bdt=0}

      var _lc_commision_bdt = parseFloat(__global_this.closest("tr").find("._lc_commision_bdt").val());
      if(isNaN(_lc_commision_bdt)){_lc_commision_bdt=0}

      var _custom_duty_bdt = parseFloat(__global_this.closest("tr").find("._custom_duty_bdt").val());
      if(isNaN(_custom_duty_bdt)){_custom_duty_bdt=0}

      var _other_cost_bdt = parseFloat(parseFloat(_lc_commision_bdt)+parseFloat(_custom_duty_bdt)+parseFloat(_insurance_bdt)).toFixed(2);
     __global_this.closest("tr").find("._other_cost_bdt").val(_other_cost_bdt);

     var _asset_value_bdt = parseFloat(parseFloat(_other_cost_bdt)+parseFloat(_cfr_value_bdt));
     __global_this.closest("tr").find("._asset_value_bdt").val(_asset_value_bdt);

     _cost_gross_total_calculation();

    });



    function _cost_gross_total_calculation(){

      var _total_qty              =0;
      var _total_cfr_value_usd    =0;
      var _total_cfr_value_bdt    =0;
      var _total_insurance_bdt    =0;
      var _total_lc_commision_bdt =0;
      var _total_custom_duty_bdt  =0;
      var _total_other_cost_bdt   =0;
      var _total_asset_value_bdt  =0;
       $(document).find("._qty").each(function() {
            var _qty =parseFloat($(this).val());
            if(isNaN(_qty)){_qty = 0}
          _total_qty +=parseFloat(_qty);
      });

      $(document).find("._cfr_value_usd").each(function() {
            var _cfr_value_usd =parseFloat($(this).val());
            if(isNaN(_cfr_value_usd)){_cfr_value_usd = 0}
          _total_cfr_value_usd +=parseFloat(_cfr_value_usd);
      });

      $(document).find("._cfr_value_bdt").each(function() {
            var _cfr_value_bdt =parseFloat($(this).val());
            if(isNaN(_cfr_value_bdt)){_cfr_value_bdt = 0}
          _total_cfr_value_bdt +=parseFloat(_cfr_value_bdt);
      });

      $(document).find("._insurance_bdt").each(function() {
            var _insurance_bdt =parseFloat($(this).val());
            if(isNaN(_insurance_bdt)){_insurance_bdt = 0}
          _total_insurance_bdt +=parseFloat(_insurance_bdt);
      });

      $(document).find("._lc_commision_bdt").each(function() {
            var _lc_commision_bdt =parseFloat($(this).val());
            if(isNaN(_lc_commision_bdt)){_lc_commision_bdt = 0}
          _total_lc_commision_bdt +=parseFloat(_lc_commision_bdt);
      });

      $(document).find("._custom_duty_bdt").each(function() {
            var _custom_duty_bdt =parseFloat($(this).val());
            if(isNaN(_custom_duty_bdt)){_custom_duty_bdt = 0}
          _total_custom_duty_bdt +=parseFloat(_custom_duty_bdt);
      });

      $(document).find("._other_cost_bdt").each(function() {
            var _other_cost_bdt =parseFloat($(this).val());
            if(isNaN(_other_cost_bdt)){_other_cost_bdt = 0}
          _total_other_cost_bdt +=parseFloat(_other_cost_bdt);
      });

      $(document).find("._asset_value_bdt").each(function() {
            var _asset_value_bdt =parseFloat($(this).val());
            if(isNaN(_asset_value_bdt)){_asset_value_bdt = 0}
          _total_asset_value_bdt +=parseFloat(_asset_value_bdt);
      });


       $(document).find("._total_qty").val(parseFloat(_total_qty).toFixed(2));
       $(document).find("._total_cfr_value_usd").val(parseFloat(_total_cfr_value_usd).toFixed(2));
       $(document).find("._total_cfr_value_bdt").val(parseFloat(_total_cfr_value_bdt).toFixed(2));
       $(document).find("._total_insurance_bdt").val(parseFloat(_total_insurance_bdt).toFixed(2));
       $(document).find("._total_lc_commision_bdt").val(parseFloat(_total_lc_commision_bdt).toFixed(2));
       $(document).find("._total_custom_duty_bdt").val(parseFloat(_total_custom_duty_bdt).toFixed(2));
       $(document).find("._total_other_cost_bdt").val(parseFloat(_total_other_cost_bdt).toFixed(2));
       $(document).find("._total_asset_value_bdt").val(parseFloat(_total_asset_value_bdt).toFixed(2));
     



    }

    $(document).on('change','._purchase_type',function(){
      var _purchase_type = $(this).val();
      if(_purchase_type=='Import'){
        $(document).find(".Import_field").show();
      }else{
      $(document).find(".Import_field").hide();
      }
    })



  </script>
@endsection