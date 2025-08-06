@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
<style type="text/css">
  .width_250px{
    width: 250px !important;
  }
  .Import_field{
    display: none;
  }
</style>
<div class="container-fluid " style="padding: 10px;">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_import_cost_list')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            @can('asset_import_cost_create')
            <li class="breadcrumb-item"><a href="{{route('asset_import_cost.create')}}">Add New</a></li>
            @endcan
            
            <li class="breadcrumb-item display_none">
           
           <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#importModal"> Upload File</button>
            </li>
          
           
           <li class="breadcrumb-item display_none">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
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
              <div class="col-md-2">
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
  @include('basic.org_import')

<div class="col-md-3">
  <h4 class="mb-1">{{__('label._purchase_type')}}<span class="_required">*</span></h4>
              <select class="form-control _purchase_type" name="_purchase_type" required>
                <option value=""><---{{__('label._purchase_type')}}---></option>
                <option value="Import" @if($_purchase_type=="Import") selected @endif>Import</option>
                <option value="Local" @if($_purchase_type=="Local") selected @endif>Local</option>
                <option value="Opening" @if($_purchase_type=="Opening") selected @endif>Opening</option>
              </select>
</div>
<div class="col-md-2">
  <h4 class="mb-1">{{__('label._voucher_number')}}</h4>
              <input  class="form-control mb-2 @error('_voucher_number') is-invalid @enderror" name="_voucher_number" type="text" placeholder="{{__('label._voucher_number')}}" value="{!! old('_voucher_number',$data->_voucher_number ?? '' ) !!}" readonly />
</div>
 <div class="col-md-2 @if($_purchase_type !='Import') Import_field @endif">             
              <h4 class="mb-1">{{__('label._bank_name')}}</h4>
              <input class="form-control mb-2 @error('_bank_name') is-invalid @enderror" name="_bank_name" type="text" placeholder="{{__('label._bank_name')}}" value="{!! old('_bank_name',$data->_bank_name ?? '' ) !!}" />
  </div>
  <div class="col-md-3 @if($_purchase_type !='Import') Import_field @endif">
              <h4 class="mb-1">{{__('label._branch_name')}}</h4>
              <input class="form-control mb-2 @error('_branch_name') is-invalid @enderror" name="_branch_name" type="text" placeholder="{{__('label._branch_name')}}" value="{!! old('_branch_name',$data->_branch_name ?? '' ) !!}" />
  </div>
<div class="col-md-3">
  <h4 class="mb-1">{{__('label._supplier_name')}}<span class="_required">*</span></h4>
              <input required class="form-control mb-2 @error('_supplier_name') is-invalid @enderror" name="_supplier_name" type="text" placeholder="{{__('label._supplier_name')}}" value="{!! old('_supplier_name',$data->_supplier_name ?? '' ) !!}" />
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
  <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">
              <h4 class="mb-1">{{__('label._invoice_no')}}</h4>
              <input class="form-control mb-2 @error('_invoice_no') is-invalid @enderror" name="_invoice_no" type="text" placeholder="{{__('label._invoice_no')}}" value="{!! old('_invoice_no',$data->_invoice_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">             
              <h4 class="mb-1">{{__('label._invoice_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_invoice_date') is-invalid @enderror" name="_invoice_date" type="date" placeholder="{{__('label._invoice_date')}}" value="{!! old('_invoice_date',$data->_invoice_date ?? '') !!}" />
</div>
  <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">
              <h4 class="mb-1">{{__('label._boe_no')}}</h4>
              <input class="form-control mb-2 @error('_boe_no') is-invalid @enderror" name="_boe_no" type="text" placeholder="{{__('label._boe_no')}}" value="{!! old('_boe_no',$data->_boe_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">             
              <h4 class="mb-1">{{__('label._boe_date')}}</h4>
              <input class="form-control width_250px mb-2 @error('_boe_date') is-invalid @enderror" name="_boe_date" type="date" placeholder="{{__('label._boe_date')}}" value="{!! old('_boe_date',$data->_boe_date ?? '') !!}" />
</div>
  <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">
              <h4 class="mb-1">{{__('label._bl_no')}}</h4>
              <input class="form-control mb-2 @error('_bl_no') is-invalid @enderror" name="_bl_no" type="text" placeholder="{{__('label._bl_no')}}" value="{!! old('_bl_no',$data->_bl_no ?? '' ) !!}" />
 </div>
 <div class="col-md-3  @if($_purchase_type !='Import') Import_field @endif">             
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
              <input class="form-control _currency_rate mb-2 @error('_currency_rate') is-invalid @enderror" name="_currency_rate" type="number" min="0" step="any" placeholder="{{__('label._currency_rate')}}" value="{!! old('_currency_rate',$data->_currency_rate ?? '' ) !!}" />
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
 <input class="form-control width_250px mb-2 @error('_cnf_agent_id') is-invalid @enderror" name="_cnf_agent_id" type="hidden" placeholder="{{__('label._cnf_agent_id')}}" value="{!! old('_cnf_agent_id',$data->_cnf_agent_id ?? '') !!}" />
</div>
</div>
              <div class="row g-5">
                <div class="table-responsive">
                <table class="table table-borderd">
                  <thead>
                    <tr>
                      <td style="font-size: 10px;">SL</td>
                      <td style="font-size: 10px;">{{__('label._asset_category_id')}}</td>
                      <td style="font-size: 10px;">Asset Code</td>
                      <td style="font-size: 10px;">{{__('label._asset_name')}}</td>
                      <td style="font-size: 10px;">{{__('label._unit_id')}}</td>
                      <td style="font-size: 10px;">{{__('label._qty')}}</td>
                      <td style="font-size: 10px;">{{__('label._rate_usd')}}</td>
                      <td style="font-size: 10px;">{{__('label._cfr_value_usd')}}</td>
                      <td style="font-size: 10px;">{{__('label._currency_rate_usd_to_bdt')}}</td>
                      <td style="font-size: 10px;">{{__('label._cfr_value_bdt')}}</td>

                      <td style="font-size: 10px;">{{__('label._insurance_bdt')}}</td>
                      <td style="font-size: 10px;">{{__('label._lc_commision_bdt')}}</td>
                      <td style="font-size: 10px;">{{__('label._custom_duty_bdt')}}</td>
                      <td style="font-size: 10px;" class="_required">{{__('label._custom_duty_tax_ait')}}</td>
                      <td style="font-size: 10px;" class="_required">{{__('label._custom_duty_tax_ait_2nd')}}</td>
                      <td style="font-size: 10px;">{{__('label._customer_other_charge_other')}}</td>
                      <td style="font-size: 10px;">{{__('label._port_charge')}}</td>
                      <td style="font-size: 10px;" class="_required">{{__('label._port_charge_ait')}}</td>
                      <td style="font-size: 10px;">{{__('label._shiping_agent_charge')}}</td>
                      <td style="font-size: 10px;">{{__('label._shiping_agent_deduction_charge_2nd')}}</td>
                      <td style="font-size: 10px;">{{__('label._deport_charge')}}</td>
                      <td style="font-size: 10px;">{{__('label._container_damage_charge')}}</td>
                      <td style="font-size: 10px;">{{__('label._cnf_agen_commision')}}</td>
                      <td style="font-size: 10px;">{{__('label._installation_cost')}}</td>
                      <td style="font-size: 10px;">{{__('label._other_cost')}}</td>
                      <td style="font-size: 10px;">{{__('label._total_initial_cost')}}</td>
                      <td style="font-size: 10px;">{{__('label._salvage_value')}}</td>
                      <td style="font-size: 10px;">{{__('label._depreciable_asset_value')}}</td>
                      <td style="font-size: 10px;">{{__('label._other_cost_bdt')}}</td>
                      <td style="font-size: 10px;">{{__('label._asset_value_bdt')}}</td>
                      <td style="font-size: 10px;">{{__('label._remarks')}}</td>
                    </tr>
                  </thead>
                  <tbody class="cost_row_body">
                    @php
$_details = $data->_details ?? [];

$total_qty = 0;
$total_cfr_value_usd = 0;
$total_cfr_value_bdt = 0;
$total_insurance_bdt = 0;
$total_lc_commision_bdt = 0;
$total_custom_duty_bdt = 0;
$total_custom_duty_tax_ait = 0;
$total_custom_duty_tax_ait_2nd = 0;
$total_customer_other_charge_other = 0;
$total_port_charge = 0;
$total_port_charge_ait = 0;
$total_shiping_agent_charge = 0;
$total_shiping_agent_deduction_charge_2nd = 0;
$total_deport_charge = 0;
$total_container_damage_charge = 0;
$total_cnf_agen_commision = 0;
$total_installation_cost = 0;
$total_other_cost = 0;
$total_salvage_value = 0;
$total_depreciable_asset_value = 0;
$total_other_cost_bdt = 0;
$total_asset_value_bdt = 0;
$total_total_initial_cost = 0;


                    @endphp
  @if(sizeof($_details) > 0)
  @forelse($_details as $key=>$detail)
  @php
$_asset_category_id = $detail->_asset_category_id ?? '';

$total_qty                        +=$detail->_qty ??  0;
$total_cfr_value_usd              +=$detail->_cfr_value_usd ??  0;
$total_cfr_value_bdt              +=$detail->_cfr_value_bdt ??  0;
$total_insurance_bdt              +=$detail->_insurance_bdt ??  0;
$total_lc_commision_bdt           +=$detail->_lc_commision_bdt ??  0;
$total_custom_duty_bdt            +=$detail->_custom_duty_bdt ??  0;
$total_custom_duty_tax_ait        +=$detail->_custom_duty_tax_ait ??  0;
$total_custom_duty_tax_ait_2nd    +=$detail->_custom_duty_tax_ait_2nd ??  0;
$total_customer_other_charge_other +=$detail->_customer_other_charge_other ??  0;
$total_port_charge                +=$detail->_port_charge ??  0;
$total_port_charge_ait            +=$detail->_port_charge_ait ??  0;
$total_shiping_agent_charge       +=$detail->_shiping_agent_charge ??  0;
$total_shiping_agent_deduction_charge_2nd +=$detail->_shiping_agent_deduction_charge_2nd ??  0;
$total_deport_charge              +=$detail->_deport_charge ??  0;
$total_container_damage_charge    +=$detail->_container_damage_charge ??  0;
$total_cnf_agen_commision         +=$detail->_cnf_agen_commision ??  0;
$total_installation_cost          +=$detail->_installation_cost ??  0;
$total_other_cost                 +=$detail->_other_cost ??  0;
$total_total_initial_cost            +=$detail->_total_initial_cost ??  0;
$total_salvage_value              +=$detail->_salvage_value ??  0;
$total_depreciable_asset_value    +=$detail->_depreciable_asset_value ??  0;
$total_other_cost_bdt             +=$detail->_other_cost_bdt ??  0;
$total_asset_value_bdt            +=$detail->_asset_value_bdt ??  0;


@endphp
          

                    <tr class="">
                      <td> <button class="btn btn-sm btn-danger btn-sm costRowRemove" type="button">X</button></td>
                      <td>
                         <input type="text" name="_asset_category_id[]" class="form-control _asset_category_id width_250px" placeholder="{{__('label._asset_category_id')}}" value="{{$detail->_asset_ledger->_name ?? ''}}" readonly>
                      </td>
                      <td>
                        <input class="form-control _item_code _search_item_code width_150px" type="text" name="_item_code[]" value="{{$detail->_items->_code ?? ''}}">
                        <div class="search_box_item"></div>
                       
                      </td>
                      <td>
                        <input class="form-control _asset_name _search_item_id width_250px" type="text" name="_asset_name[]" value="{{$detail->_asset_name ?? ''}}">
                         <div class="search_box_item"></div>
                        <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px"  value="{{$detail->_item_id ?? '' }}">
                        <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="{{$detail->id ?? ''}}">
                      </td>
                      <td>
                        <input type="text" name="_unit_id[]" class="form-control _unit_id" value="{{$detail->_items->_units->_name ?? '' }}" readonly/>
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="{{$detail->_qty ?? 0}}"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="{{$detail->_rate_usd ?? 0}}"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="{{$detail->_cfr_value_usd ?? 0}}" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="{{$detail->_currency_rate_usd_to_bdt ?? 0}}" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="{{$detail->_cfr_value_bdt ?? 0}}" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="{{$detail->_insurance_bdt ?? 0}}" > </td>

                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="{{$detail->_lc_commision_bdt ?? 0}}" ></td>

                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="{{$detail->_custom_duty_bdt ?? 0}}" ></td>

                      <td><input class="form-control _custom_duty_tax_ait width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait[]" value="{{$detail->_custom_duty_tax_ait ?? 0}}" ></td>
                      <td><input class="form-control _custom_duty_tax_ait_2nd width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait_2nd[]" value="{{$detail->_custom_duty_tax_ait_2nd ?? 0}}" ></td>
                      <td><input class="form-control _customer_other_charge_other width_150px _cccenter" type="number" min="0" step="any" name="_customer_other_charge_other[]" value="{{$detail->_customer_other_charge_other ?? 0}}" ></td>
                      <td><input class="form-control _port_charge width_150px _cccenter" type="number" min="0" step="any" name="_port_charge[]" value="{{$detail->_port_charge ?? 0}}" ></td>
                      <td><input class="form-control _port_charge_ait width_150px _cccenter" type="number" min="0" step="any" name="_port_charge_ait[]" value="{{$detail->_port_charge_ait ?? 0}}" ></td>
                      <td><input class="form-control _shiping_agent_charge width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_charge[]" value="{{$detail->_shiping_agent_charge ?? 0}}" ></td>
                      <td><input class="form-control _shiping_agent_deduction_charge_2nd width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_deduction_charge_2nd[]" value="{{$detail->_shiping_agent_deduction_charge_2nd ?? 0}}" ></td>
                      <td><input class="form-control _deport_charge width_150px _cccenter" type="number" min="0" step="any" name="_deport_charge[]" value="{{$detail->_deport_charge ?? 0}}" ></td>
                      <td><input class="form-control _container_damage_charge width_150px _cccenter" type="number" min="0" step="any" name="_container_damage_charge[]" value="{{$detail->_container_damage_charge ?? 0}}" ></td>
                      <td><input class="form-control _cnf_agen_commision width_150px _cccenter" type="number" min="0" step="any" name="_cnf_agen_commision[]" value="{{$detail->_cnf_agen_commision ?? 0}}" ></td>
                      <td><input class="form-control _installation_cost width_150px _cccenter" type="number" min="0" step="any" name="_installation_cost[]" value="{{$detail->_installation_cost ?? 0}}" ></td>
                      <td><input class="form-control _other_cost width_150px _cccenter" type="number" min="0" step="any" name="_other_cost[]" value="{{$detail->_other_cost ?? 0}}" ></td>
                      <td><input class="form-control _total_initial_cost width_150px _cccenter" type="number" min="0" step="any" name="_total_initial_cost[]" value="{{$detail->_total_initial_cost ?? 0}}" ></td>
                      <td><input class="form-control _salvage_value width_150px _cccenter" type="number" min="0" step="any" name="_salvage_value[]" value="{{$detail->_salvage_value ?? 0}}" ></td>
                      <td><input class="form-control _depreciable_asset_value width_150px _cccenter" type="number" min="0" step="any" name="_depreciable_asset_value[]" value="{{$detail->_depreciable_asset_value ?? 0}}" ></td>

                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="{{$detail->_other_cost_bdt ?? 0}}" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="{{_php_round($detail->_asset_value_bdt ?? 0)}}" readonly></td>
                       <td><input class="form-control _remarks width_250px" type="text"  name="_remarks[]" value="{!! $detail->_remarks ?? '' !!}" ></td>
                    </tr>
  @empty
  @endforelse
@else
<tr class="">
                      <td> <button class="btn btn-danger btn-sm costRowRemove" type="button">X</button></td>
                      <td>
                         <input type="text" name="_asset_category_id[]" class="form-control _asset_category_id width_250px" placeholder="{{__('label._asset_category_id')}}" readonly>
                      </td>
                    <td>
                        <input class="form-control _item_code _search_item_code width_150px" type="text" name="_item_code[]" value="{{$detail->_item_code ?? ''}}">
                        <div class="search_box_item"></div>
                       
                      </td>
                      <td>
                        <input class="form-control _asset_name _search_item_id width_250px" type="text" name="_asset_name[]" value="">
                         <div class="search_box_item"></div>
                        <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px"  value="">
                        <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="">
                      </td>
                      <td>
                         <input type="text" name="_unit_id[]" class="form-control _unit_id" value="" readonly />
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="0"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="0"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="0" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="0" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="0" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="0" > </td>

                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="0" ></td>
                      
                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="0" ></td>

                      <td><input class="form-control _custom_duty_tax_ait width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait[]" value="0" ></td>

                      <td><input class="form-control _custom_duty_tax_ait_2nd width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait_2nd[]" value="0" ></td>

                      <td><input class="form-control _customer_other_charge_other width_150px _cccenter" type="number" min="0" step="any" name="_customer_other_charge_other[]" value="0" ></td>

                      <td><input class="form-control _port_charge width_150px _cccenter" type="number" min="0" step="any" name="_port_charge[]" value="0" ></td>

                      <td><input class="form-control _port_charge_ait width_150px _cccenter" type="number" min="0" step="any" name="_port_charge_ait[]" value="0" ></td>

                      <td><input class="form-control _shiping_agent_charge width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_charge[]" value="0" ></td>
                      <td><input class="form-control _shiping_agent_deduction_charge_2nd width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_deduction_charge_2nd[]" value="0" ></td>
                      <td><input class="form-control _deport_charge width_150px _cccenter" type="number" min="0" step="any" name="_deport_charge[]" value="0" ></td>
                      <td><input class="form-control _container_damage_charge width_150px _cccenter" type="number" min="0" step="any" name="_container_damage_charge[]" value="0" ></td>
                      <td><input class="form-control _cnf_agen_commision width_150px _cccenter" type="number" min="0" step="any" name="_cnf_agen_commision[]" value="0" ></td>
                      <td><input class="form-control _installation_cost width_150px _cccenter" type="number" min="0" step="any" name="_installation_cost[]" value="0" ></td>
                      <td><input class="form-control _other_cost width_150px _cccenter" type="number" min="0" step="any" name="_other_cost[]" value="0" ></td>
                      <td><input class="form-control _total_initial_cost width_150px _cccenter" type="number" min="0" step="any" name="_total_initial_cost[]" value="0" ></td>
                      <td><input class="form-control _salvage_value width_150px _cccenter" type="number" min="0" step="any" name="_salvage_value[]" value="0" ></td>
                      <td><input class="form-control _depreciable_asset_value width_150px _cccenter" type="number" min="0" step="any" name="_depreciable_asset_value[]" value="0" ></td>

                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _remarks width_250px" type="text"  name="_remarks[]" ></td>
                    </tr>

@endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>
                        <button class="  btn btn-primary btn-lg  addCostRow" type="button">+</button>
                      </th>
                      <th colspan="4">Grand Total</th>
                     
                      
                      <td><input class="form-control total_qty width_150px _cccenter" type="number" min="0" step="any" name="total_qty" readonly value="{{$total_qty ?? 0 }}"></td>
                      <td></td>
                      <td><input class="form-control total_cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="total_cfr_value_usd" readonly value="{{$total_cfr_value_usd ?? 0}}" ></td>
                      
                      <td></td>

                      <td><input class="form-control total_cfr_value_bdt width_150px " type="number" min="0" step="any" name="total_cfr_value_bdt" readonly value="{{$total_cfr_value_bdt ?? 0}}" ></td>
                      <td><input class="form-control total_insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="total_insurance_bdt" readonly value="{{$total_insurance_bdt ?? 0}}" > </td>

                      <td><input class="form-control total_lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="total_lc_commision_bdt" readonly value="{{$total_lc_commision_bdt ?? 0}}" ></td>


                      <td><input class="form-control total_custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="total_custom_duty_bdt" readonly value="{{$total_custom_duty_bdt ?? 0}}" ></td>
                      
                      <td><input class="form-control total_custom_duty_tax_ait width_150px _cccenter" type="number" min="0" step="any" name="total_custom_duty_tax_ait" readonly value="{{$total_custom_duty_tax_ait ?? 0}}" ></td>
                      <td><input class="form-control total_custom_duty_tax_ait_2nd width_150px _cccenter" type="number" min="0" step="any" name="total_custom_duty_tax_ait_2nd" readonly value="{{$total_custom_duty_tax_ait_2nd ?? 0}}" ></td>
                      <td><input class="form-control total_customer_other_charge_other width_150px _cccenter" type="number" min="0" step="any" name="total_customer_other_charge_other" readonly value="{{$total_customer_other_charge_other ?? 0}}" ></td>
                      <td><input class="form-control total_port_charge width_150px _cccenter" type="number" min="0" step="any" name="total_port_charge" readonly value="{{$total_port_charge ?? 0}}" ></td>
                      <td><input class="form-control total_port_charge_ait width_150px _cccenter" type="number" min="0" step="any" name="total_port_charge_ait" readonly value="{{$total_port_charge_ait ?? 0}}" ></td>
                      <td><input class="form-control total_shiping_agent_charge width_150px _cccenter" type="number" min="0" step="any" name="total_shiping_agent_charge" readonly value="{{$total_shiping_agent_charge ?? 0}}" ></td>
                      <td><input class="form-control total_shiping_agent_deduction_charge_2nd width_150px _cccenter" type="number" min="0" step="any" name="total_shiping_agent_deduction_charge_2nd" readonly value="{{$total_shiping_agent_deduction_charge_2nd ?? 0}}" ></td>
                      <td><input class="form-control total_deport_charge width_150px _cccenter" type="number" min="0" step="any" name="total_deport_charge" readonly value="{{$total_deport_charge ?? 0}}" ></td>
                      <td><input class="form-control total_container_damage_charge width_150px _cccenter" type="number" min="0" step="any" name="total_container_damage_charge" readonly value="{{$total_container_damage_charge ?? 0}}" ></td>
                      <td><input class="form-control total_cnf_agen_commision width_150px _cccenter" type="number" min="0" step="any" name="total_cnf_agen_commision" readonly value="{{$total_cnf_agen_commision ?? 0}}" ></td>
                      <td><input class="form-control total_installation_cost width_150px _cccenter" type="number" min="0" step="any" name="total_installation_cost" readonly value="{{$total_installation_cost ?? 0}}" ></td>

                      <td><input class="form-control total_other_cost width_150px _cccenter" type="number" min="0" step="any" name="total_other_cost" readonly value="{{$total_other_cost ?? 0}}" ></td>

                      <td><input class="form-control total_total_initial_cost width_150px _cccenter" type="number" min="0" step="any" name="total_total_initial_cost" readonly value="{{$total_total_initial_cost ?? 0}}" ></td>

                      <td><input class="form-control total_salvage_value width_150px _cccenter" type="number" min="0" step="any" name="total_salvage_value" readonly value="{{$total_salvage_value ?? 0}}" ></td>
                      <td><input class="form-control total_depreciable_asset_value width_150px _cccenter" type="number" min="0" step="any" name="total_depreciable_asset_value" readonly value="{{$total_depreciable_asset_value ?? 0}}" ></td>

                      <td> <input class="form-control total_other_cost_bdt width_150px" type="text"  name="total_other_cost_bdt" readonly value="{{$total_other_cost_bdt ?? 0}}" readonly></td>
                      <td><input class="form-control total_asset_value_bdt width_150px" type="number" min="0" step="any" name="total_asset_value_bdt" readonly value="{{$total_asset_value_bdt ?? 0}}" readonly></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
              
             
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._note')}}</h4>
                <textarea class="form-control" name="_note" >{!! old('_note',$data->_note ?? '') !!}</textarea>
              </div>
@php
$_cost_accounts = $data->_cost_account ?? [];
@endphp

              <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>{{__('label._ledger_id')}}</th>
                                            <th class="@if(sizeof($permited_organizations)==1) display_none @endif">{{__('label.organization_id')}}</th>
                                            <th class="@if(sizeof($permited_branch)==1) display_none @endif">{{__('label.Branch')}}</th>
                                            <th class="@if(sizeof($permited_costcenters)==1) display_none @endif">{{__('label.Cost center')}}</th>
                                            <th class="@if(sizeof($permited_budgets)==1) display_none @endif">{{__('label._budget_id')}}</th>
                                            <th>{{__('label.Short Narr.')}}</th>
                                             <th>{{__('label._foreign_amount')}}</th>
                                            <th>{{__('label.Dr. Amount')}}</th>
                                            <th>{{__('label.Cr. Amount')}}</th>
                                          </thead>
                                          <tbody class="area__voucher_details" id="area__voucher_details">
    @php
$total_dr_amount=0;
$total_cr_amount=0;
@endphp
            @if(sizeof($_cost_accounts) > 0)
            @forelse($_cost_accounts as $cost_key=>$cost_account)
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>

                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" value="{!! $cost_account->_ledger->_name ?? '' !!}">
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id"  value="{!! $cost_account->_ledger_id ?? '' !!}">
                                                <div class="search_box"></div>
                                              </td>
@php
$organization_details_id = $cost_account->organization_id ?? '';
$_branch_id_detail = $cost_account->_branch_id ?? '';
$_cost_center = $cost_account->_cost_center ?? '';
$_budget_details_id = $cost_account->_budget_details_id ?? '';

$total_dr_amount      +=$cost_account->_dr_amount ?? 0;
$total_cr_amount      +=$cost_account->_cr_amount ?? 0;
@endphp
                                              <td class="@if(sizeof($permited_organizations)==1) display_none @endif">
                                                 <select class="form-control organization_details_id" name="organization_details_id[]"  >
                                                  
                                                 @forelse($permited_organizations as $val )
                                                 <option value="{{$val->id}}" @if($organization_details_id==$val->id) selected @endif >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                                 @empty
                                                 @endforelse
                                                </select>
                                              </td>
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}"  @if($_branch_id_detail == $branch->id) selected @endif   >{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                                <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}"  @if($_cost_center == $costcenter->id) selected @endif   > {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              <td class="@if(sizeof($permited_budgets)==1) display_none @endif">
                                                <select class="form-control _budget_details_id" name="_budget_details_id[]"  >
                                                     
                                                    @forelse($permited_budgets as $b_val )
                                                                   <option value="{{$b_val->id}}"  @if($_budget_details_id == $b_val->id) selected @endif   > {{ $b_val->_name ?? '' }}</option>
                                                     @empty
                                                     @endforelse
                                                 </select>
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr" value="{!! $cost_account->_short_narr ?? '' !!}">
                                              </td>
                                               <td>
                                                <input type="number" min="0" step="any" name="_foreign_amount[]" class="form-control  _foreign_amount" placeholder="{{__('label._foreign_amount')}}" value="{{$cost_account->_foreign_amount ?? 0 }}">
                                              </td>
                                              <td>
                                                <input type="number" min="0" step="any" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{$cost_account->_dr_amount ?? 0 }}">
                                              </td>
                                              <td>
                                                <input min="0" step="any" type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{$cost_account->_cr_amount ?? 0}}">
                                              </td>
                                            </tr>
                          @empty
                          @endforelse
                          @else


                          @endif
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-info" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="2" class="text-right"><b>Total</b></td>
                                              <td class="@if(sizeof($permited_organizations)==1) display_none @endif"></td>
                                              <td class="@if(sizeof($permited_branch)==1) display_none @endif"></td>
                                              <td class="@if(sizeof($permited_costcenters)==1) display_none @endif"></td>
                                              <td class="@if(sizeof($permited_budgets)==1) display_none @endif"></td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="{{$total_dr_amount ?? 0}}" readonly required>
                                              </td>


                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="{{$total_cr_amount ?? 0}}" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                                
                            </div>
                          </div>
                        </div>
             
              </div>
              

          
            
          <div class="col-12 ">
                <div class="row  justify-content-center mt-4 mb-4">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>
        </form>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <form action="{{ route('import_modal_settings')}}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sales Form Settings</h5>
        <button type="button" class="close exampleModalClose"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body display_form_setting_info">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary exampleModalClose" >Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>
        @endsection

@section('script')
  <script>
   
  $(document).on("click","#form_settings",function(){
         setting_data_fetch();
  })

  function setting_data_fetch(){
      var request = $.ajax({
            url: "{{route('import_cost_setting_modal')}}",
            method: "GET",
            dataType: "html"
          });
         request.done(function( result ) {
              $(document).find(".display_form_setting_info").html(result);
         })
  }

  $(document).on('keyup','._currency_rate',function(){
      change_currency_rate();
  })

  function change_currency_rate(){
        var _currency_rate = parseFloat($(document).find("._currency_rate").val());
    if(isNaN(_currency_rate)){_currency_rate=0}
    $(document).find('._currency_rate_usd_to_bdt').val(_currency_rate);
    _cost_gross_total_calculation();
  }
    

    function voucher_row_add(event) {
    var number_of_row = $(document).find(".number_of_row").val();
    var new_row_number = (number_of_row+1);
      event.preventDefault();
      $("#area__voucher_details").append(`<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      <td class="@if(sizeof($permited_organizations)==1) display_none @endif">
                      <select class="form-control width_150_px organization_details_id organization_details_id__${new_row_number}" name="organization_details_id[]"  required >
                        @forelse($permited_organizations as $org )
                            <option value="{{$org->id}}" >{{ $org->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                      <td class="@if(sizeof($permited_branch)==1) display_none @endif">
                      <select class="form-control width_150_px _branch_id_detail _branch_id_detail__${new_row_number}" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" >{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        <td class="@if(sizeof($permited_costcenters)==1) display_none @endif">
                          <select class="form-control width_150_px _cost_center _cost_center__${new_row_number}" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                      </td>
                        <td class="@if(sizeof($permited_budgets)==1) display_none @endif">
                          <select class="form-control _budget_details_id _budget_details_id__${new_row_number}" name="_budget_details_id[]"  >
                            @forelse($permited_budgets as $b_val )
                                           <option value="{{$b_val->id}}" > {{ $b_val->_name ?? '' }}</option>
                             @empty
                             @endforelse
                         </select>
                      </td>
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                              <td>
                                <input type="number" name="_foreign_amount[]" class="form-control  _foreign_amount"  min="0" step="any"placeholder="{{__('label._foreign_amount')}}" value="{{old('_foreign_amount',0)}}">
                              </td>
                            <td>
                              <input type="number" min="0" step="any" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" min="0" step="any" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`);

 

      
  }

    $(document).on("click",".addCostRow",function(){
            $(".cost_row_body").append(`<tr class="">
                      <td> <button class="btn btn-sm btn-danger costRowRemove" type="button">X</button></td>
                      <td>
                         <input type="text" name="_asset_category_id[]" class="form-control _asset_category_id width_250px" placeholder="{{__('label._asset_category_id')}}" readonly>
                      </td>
                    <td>
                        <input class="form-control _item_code _search_item_code width_150px" type="text" name="_item_code[]" value="">
                        <div class="search_box_item"></div>
                       
                      </td>
                      <td>
                        <input class="form-control _asset_name _search_item_id width_250px" type="text" name="_asset_name[]" value="">
                         <div class="search_box_item"></div>
                        <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px"  value="">
                        <input class="form-control asset_import_cost_details_id" type="hidden" name="asset_import_cost_details_id[]" value="">
                      </td>
                      <td>
                       <input type="text" name="_unit_id[]" class="form-control _unit_id" value='' readonly/>
                      </td>
                      <td><input class="form-control _qty width_150px _cccenter" type="number" min="0" step="any" name="_qty[]" value="0"></td>
                      <td><input class="form-control _rate_usd width_150px _cccenter" type="number" min="0" step="any" name="_rate_usd[]" value="0"></td>
                      <td><input class="form-control _cfr_value_usd width_150px _cccenter" type="number" min="0" step="any" name="_cfr_value_usd[]" value="0" ></td>
                      
                      <td><input class="form-control _currency_rate_usd_to_bdt width_150px _cccenter" type="number" min="0" step="any"name="_currency_rate_usd_to_bdt[]" value="0" ></td>

                      <td><input class="form-control _cfr_value_bdt width_150px " type="number" min="0" step="any" name="_cfr_value_bdt[]" value="0" ></td>
                      <td><input class="form-control _insurance_bdt width_150px _cccenter" type="number" min="0" step="any" name="_insurance_bdt[]" value="0" > </td>

                      <td><input class="form-control _lc_commision_bdt width_150px _cccenter" type="number" min="0" step="any" name="_lc_commision_bdt[]" value="0" ></td>
                      
                      <td><input class="form-control _custom_duty_bdt width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_bdt[]" value="0" ></td>

                      <td><input class="form-control _custom_duty_tax_ait width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait[]" value="0" ></td>
                      <td><input class="form-control _custom_duty_tax_ait_2nd width_150px _cccenter" type="number" min="0" step="any" name="_custom_duty_tax_ait_2nd[]" value="0" ></td>
                      <td><input class="form-control _customer_other_charge_other width_150px _cccenter" type="number" min="0" step="any" name="_customer_other_charge_other[]" value="0" ></td>
                      <td><input class="form-control _port_charge width_150px _cccenter" type="number" min="0" step="any" name="_port_charge[]" value="0" ></td>
                      <td><input class="form-control _port_charge_ait width_150px _cccenter" type="number" min="0" step="any" name="_port_charge_ait[]" value="0" ></td>
                      <td><input class="form-control _shiping_agent_charge width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_charge[]" value="0" ></td>
                      <td><input class="form-control _shiping_agent_deduction_charge_2nd width_150px _cccenter" type="number" min="0" step="any" name="_shiping_agent_deduction_charge_2nd[]" value="0" ></td>
                      <td><input class="form-control _deport_charge width_150px _cccenter" type="number" min="0" step="any" name="_deport_charge[]" value="0" ></td>
                      <td><input class="form-control _container_damage_charge width_150px _cccenter" type="number" min="0" step="any" name="_container_damage_charge[]" value="0" ></td>
                      <td><input class="form-control _cnf_agen_commision width_150px _cccenter" type="number" min="0" step="any" name="_cnf_agen_commision[]" value="0" ></td>
                      <td><input class="form-control _installation_cost width_150px _cccenter" type="number" min="0" step="any" name="_installation_cost[]" value="0" ></td>

                      <td><input class="form-control _other_cost width_150px _cccenter" type="number" min="0" step="any" name="_other_cost[]" value="0" ></td>

                      <td><input class="form-control _total_initial_cost width_150px _cccenter" type="number" min="0" step="any" name="_total_initial_cost[]" value="0" ></td>

                      <td><input class="form-control _salvage_value width_150px _cccenter" type="number" min="0" step="any" name="_salvage_value[]" value="0" ></td>
                      <td><input class="form-control _depreciable_asset_value width_150px _cccenter" type="number" min="0" step="any" name="_depreciable_asset_value[]" value="0" ></td>

                      <td> <input class="form-control _other_cost_bdt width_150px" type="text"  name="_other_cost_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _asset_value_bdt width_150px" type="number" min="0" step="any" name="_asset_value_bdt[]" value="0" readonly></td>
                      <td><input class="form-control _remarks width_250px" type="text"  name="_remarks[]" ></td>
                    </tr>`);

 change_currency_rate();

    })


    $(document).on("click",".costRowRemove",function(){
      $(this).closest("tr").remove();
      _cost_gross_total_calculation();

    })


    $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    purchase_item_search(_gloabal_this,_text_val);

}, 500));

  $(document).on('keyup','._search_item_code',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    purchase_item_search(_gloabal_this,_text_val);

}, 500));

function purchase_item_search(_gloabal_this,_text_val){
    var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 500px;">
            <thead>
              <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Item</th>
                <th>Pack Size</th>
                <th>Unit</th>
                <th>Manufacture</th>
              </tr>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                          var _balance = data[i]?._balance
                         search_html += `<tr class="search_row_item" >

                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td>
                                         <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_item_code" class="_item_code" value="${data[i]._code}">
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_category" class="_item_category" value="${data[i]?._category?._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_unique_barcode" class="_unique_barcode" value="${data[i]._unique_barcode}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                   <input type="hidden" name="_item_pack_size" class="_item_pack_size" value="${data[i]?._pack_size?._name}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                    <td>${data[i]?._pack_size?._name}</td>
                                   <td>${_balance} ${data[i]._units?._name}</td>
                                   <td>${_manufacture_company}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4"><button type="button" class="btn btn-sm btn-success new_item_using_modal" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-plus"></i> New Item
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}



$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _item_code = $(this).children('td').find('._item_code').val();
  var _id = $(this).children('td').find('._id_item').val();
  var _main_unit_text = $(this).children('td').find('._main_unit_text').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  var _item_category = $(this).find('._item_category').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  var _unique_barcode = parseFloat($(this).find('._unique_barcode').val());
 // var _main_unit_text = parseFloat($(this).find('._main_unit_text').val());

  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_code').val(_item_code);
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._asset_category_id').val(_item_category);
  $(this).parent().parent().parent().parent().parent().parent().find('._unit_id').val(_main_unit_text);
 
  
  $(document).find('.search_box_item').hide();
  $(document).find('.search_box_item').removeClass('search_box_show').hide();
  
})





    $(document).on("keyup","._cccenter",function(){
      var __global_this = $(this);
      single_line_sum_calculation(__global_this)
    })

    function single_line_sum_calculation(__global_this){
      //console.log(__global_this)
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

      var _custom_duty_tax_ait = parseFloat(__global_this.closest("tr").find("._custom_duty_tax_ait").val());
      if(isNaN(_custom_duty_tax_ait)){_custom_duty_tax_ait=0}
        
      var _custom_duty_tax_ait_2nd = parseFloat(__global_this.closest("tr").find("._custom_duty_tax_ait_2nd").val());
      if(isNaN(_custom_duty_tax_ait_2nd)){_custom_duty_tax_ait_2nd=0}
        
      var _customer_other_charge_other = parseFloat(__global_this.closest("tr").find("._customer_other_charge_other").val());
      if(isNaN(_customer_other_charge_other)){_customer_other_charge_other=0}
        
      var _port_charge = parseFloat(__global_this.closest("tr").find("._port_charge").val());
      if(isNaN(_port_charge)){_port_charge=0}
        
      var _port_charge_ait = parseFloat(__global_this.closest("tr").find("._port_charge_ait").val());
      if(isNaN(_port_charge_ait)){_port_charge_ait=0}
        
      var _shiping_agent_charge = parseFloat(__global_this.closest("tr").find("._shiping_agent_charge").val());
      if(isNaN(_shiping_agent_charge)){_shiping_agent_charge=0}
        
      var _shiping_agent_deduction_charge_2nd = parseFloat(__global_this.closest("tr").find("._shiping_agent_deduction_charge_2nd").val());
      if(isNaN(_shiping_agent_deduction_charge_2nd)){_shiping_agent_deduction_charge_2nd=0}
        
      var _deport_charge = parseFloat(__global_this.closest("tr").find("._deport_charge").val());
      if(isNaN(_deport_charge)){_deport_charge=0}
        
      var _container_damage_charge = parseFloat(__global_this.closest("tr").find("._container_damage_charge").val());
      if(isNaN(_container_damage_charge)){_container_damage_charge=0}
        
      var _cnf_agen_commision = parseFloat(__global_this.closest("tr").find("._cnf_agen_commision").val());
      if(isNaN(_cnf_agen_commision)){_cnf_agen_commision=0}
        
      var _installation_cost = parseFloat(__global_this.closest("tr").find("._installation_cost").val());
      if(isNaN(_installation_cost)){_installation_cost=0}
        
      var _other_cost = parseFloat(__global_this.closest("tr").find("._other_cost").val());
      if(isNaN(_other_cost)){_other_cost=0}
        
      var _total_initial_cost = parseFloat(__global_this.closest("tr").find("._total_initial_cost").val());
      if(isNaN(_total_initial_cost)){_total_initial_cost=0}
        
      var _salvage_value = parseFloat(__global_this.closest("tr").find("._salvage_value").val());
      if(isNaN(_salvage_value)){_salvage_value=0}
        
      var _depreciable_asset_value = parseFloat(__global_this.closest("tr").find("._depreciable_asset_value").val());
      if(isNaN(_depreciable_asset_value)){_depreciable_asset_value=0}

      var _asset_value_bdt = parseFloat(__global_this.closest("tr").find("._asset_value_bdt").val());
      if(isNaN(_asset_value_bdt)){_asset_value_bdt=0}








 





      var _other_cost_bdt =( parseFloat(parseFloat(_lc_commision_bdt)+parseFloat(_custom_duty_bdt)+parseFloat(_insurance_bdt)+parseFloat(_customer_other_charge_other)+parseFloat(_port_charge)+parseFloat(_shiping_agent_charge)+parseFloat(_shiping_agent_deduction_charge_2nd)+parseFloat(_deport_charge)+parseFloat(_container_damage_charge)+parseFloat(_cnf_agen_commision)+parseFloat(_installation_cost)+parseFloat(_other_cost))-parseFloat(parseFloat(_custom_duty_tax_ait)+parseFloat(_custom_duty_tax_ait_2nd)+parseFloat(_port_charge_ait))).toFixed(2);

    var total_deduction_amount= parseFloat(parseFloat(_custom_duty_tax_ait)+parseFloat(_custom_duty_tax_ait_2nd)+parseFloat(_port_charge_ait)).toFixed(2);

var _total_initial_cost = parseFloat((parseFloat(_other_cost_bdt)+parseFloat(_cfr_value_bdt))-parseFloat(total_deduction_amount)).toFixed(2);
var _depreciable_asset_value = parseFloat((parseFloat(_total_initial_cost))-parseFloat(_salvage_value)).toFixed(2);

var _asset_value_bdt = parseFloat(parseFloat(_total_initial_cost)-parseFloat(total_deduction_amount)).toFixed(2);

    //_lc_commision_bdt
//_custom_duty_bdt
//_customer_other_charge_other
//_port_charge
//_port_charge_ait
//_shiping_agent_charge
//_shiping_agent_deduction_charge_2nd
//_deport_charge
//_container_damage_charge
//_cnf_agen_commision
//_installation_cost
//_other_cost
//_total_initial_cost
// _salvage_value
// _depreciable_asset_value
// _asset_value_bdt


     __global_this.closest("tr").find("._other_cost_bdt").val(_other_cost_bdt);
    // __global_this.closest("tr").find("._total_initial_cost").val(_other_cost_bdt);

    // var _asset_value_bdt = parseFloat(parseFloat(_other_cost_bdt)+parseFloat(_cfr_value_bdt));
     __global_this.closest("tr").find("._total_initial_cost").val(_total_initial_cost);
     __global_this.closest("tr").find("._depreciable_asset_value").val(_depreciable_asset_value);
     __global_this.closest("tr").find("._asset_value_bdt").val((_total_initial_cost));

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

      var total_qty              =0;
      var total_cfr_value_usd    =0;
      var total_cfr_value_bdt    =0;
      var total_insurance_bdt    =0;
      var total_lc_commision_bdt =0;
      var total_custom_duty_bdt =0;
      var total_custom_duty_tax_ait  =0;
      var total_custom_duty_tax_ait_2nd   =0;
      var total_customer_other_charge_other  =0;
      var total_port_charge  =0;
      var total_port_charge_ait  =0;
      var total_shiping_agent_charge  =0;
      var total_shiping_agent_deduction_charge_2nd  =0;
      var total_deport_charge  =0;
      var total_container_damage_charge  =0;
      var total_cnf_agen_commision  =0;
      var total_installation_cost  =0;
      var total_other_cost  =0;
      var total_salvage_value  =0;
      var total_depreciable_asset_value  =0;
      var total_other_cost_bdt  =0;
      var total_asset_value_bdt  =0;
      var total_total_initial_cost  =0;




       $(document).find("._qty").each(function() {
            var _qty =parseFloat($(this).val());
            if(isNaN(_qty)){_qty = 0}
          total_qty +=parseFloat(_qty);
      });

      $(document).find("._cfr_value_usd").each(function() {
            var _cfr_value_usd =parseFloat($(this).val());
            if(isNaN(_cfr_value_usd)){_cfr_value_usd = 0}
          total_cfr_value_usd +=parseFloat(_cfr_value_usd);
      });

      $(document).find("._cfr_value_bdt").each(function() {
            var _cfr_value_bdt =parseFloat($(this).val());
            if(isNaN(_cfr_value_bdt)){_cfr_value_bdt = 0}
          total_cfr_value_bdt +=parseFloat(_cfr_value_bdt);
      });

      $(document).find("._insurance_bdt").each(function() {
            var _insurance_bdt =parseFloat($(this).val());
            if(isNaN(_insurance_bdt)){_insurance_bdt = 0}
          total_insurance_bdt +=parseFloat(_insurance_bdt);
      });

      $(document).find("._lc_commision_bdt").each(function() {
            var _lc_commision_bdt =parseFloat($(this).val());
            if(isNaN(_lc_commision_bdt)){_lc_commision_bdt = 0}
          total_lc_commision_bdt +=parseFloat(_lc_commision_bdt);
      });

      $(document).find("._custom_duty_bdt").each(function() {
            var _custom_duty_bdt =parseFloat($(this).val());
            if(isNaN(_custom_duty_bdt)){_custom_duty_bdt = 0}
          total_custom_duty_bdt +=parseFloat(_custom_duty_bdt);
      });

      $(document).find("._custom_duty_tax_ait").each(function() {
            var  _custom_duty_tax_ait =parseFloat($(this).val());
            if(isNaN( _custom_duty_tax_ait)){ _custom_duty_tax_ait = 0}
          total_custom_duty_tax_ait +=parseFloat( _custom_duty_tax_ait);
      });

      $(document).find("._custom_duty_tax_ait").each(function() {
            var  _custom_duty_tax_ait =parseFloat($(this).val());
            if(isNaN( _custom_duty_tax_ait)){ _custom_duty_tax_ait = 0}
          total_custom_duty_tax_ait +=parseFloat( _custom_duty_tax_ait);
      });


      $(document).find("._customer_other_charge_other").each(function() {
            var  _customer_other_charge_other =parseFloat($(this).val());
            if(isNaN( _customer_other_charge_other)){ _customer_other_charge_other = 0}
          total_customer_other_charge_other +=parseFloat( _customer_other_charge_other);
      });

      $(document).find("._port_charge").each(function() {
            var  _port_charge =parseFloat($(this).val());
            if(isNaN( _port_charge)){ _port_charge = 0}
          total_port_charge +=parseFloat( _port_charge);
      });

      $(document).find("._port_charge_ait").each(function() {
            var  _port_charge_ait =parseFloat($(this).val());
            if(isNaN( _port_charge_ait)){ _port_charge_ait = 0}
          total_port_charge_ait +=parseFloat( _port_charge_ait);
      });
      $(document).find("._shiping_agent_charge").each(function() {
            var  _shiping_agent_charge =parseFloat($(this).val());
            if(isNaN( _shiping_agent_charge)){ _shiping_agent_charge = 0}
          total_shiping_agent_charge +=parseFloat( _shiping_agent_charge);
      });
      $(document).find("._shiping_agent_deduction_charge_2nd").each(function() {
            var  _shiping_agent_deduction_charge_2nd =parseFloat($(this).val());
            if(isNaN( _shiping_agent_deduction_charge_2nd)){ _shiping_agent_deduction_charge_2nd = 0}
          total_shiping_agent_deduction_charge_2nd +=parseFloat( _shiping_agent_deduction_charge_2nd);
      });
      $(document).find("._deport_charge").each(function() {
            var  _deport_charge =parseFloat($(this).val());
            if(isNaN( _deport_charge)){ _deport_charge = 0}
          total_deport_charge +=parseFloat( _deport_charge);
      });

      $(document).find("._container_damage_charge").each(function() {
            var  _container_damage_charge =parseFloat($(this).val());
            if(isNaN( _container_damage_charge)){ _container_damage_charge = 0}
          total_container_damage_charge +=parseFloat( _container_damage_charge);
      });
      
      $(document).find("._cnf_agen_commision").each(function() {
            var  _cnf_agen_commision =parseFloat($(this).val());
            if(isNaN( _cnf_agen_commision)){ _cnf_agen_commision = 0}
          total_cnf_agen_commision +=parseFloat( _cnf_agen_commision);
      });

      $(document).find("._custom_duty_tax_ait_2nd").each(function() {
            var  _custom_duty_tax_ait_2nd =parseFloat($(this).val());
            if(isNaN( _custom_duty_tax_ait_2nd)){ _custom_duty_tax_ait_2nd = 0}
          total_custom_duty_tax_ait_2nd +=parseFloat( _custom_duty_tax_ait_2nd);
      });

      
      $(document).find("._installation_cost").each(function() {
            var  _installation_cost =parseFloat($(this).val());
            if(isNaN( _installation_cost)){ _installation_cost = 0}
          total_installation_cost +=parseFloat( _installation_cost);
      });

      $(document).find("._other_cost").each(function() {
            var  _other_cost =parseFloat($(this).val());
            if(isNaN( _other_cost)){ _other_cost = 0}
          total_other_cost +=parseFloat( _other_cost);
      });
      $(document).find("._total_initial_cost").each(function() {
            var  _total_initial_cost =parseFloat($(this).val());
            if(isNaN( _total_initial_cost)){ _total_initial_cost = 0}
          total_total_initial_cost +=parseFloat( _total_initial_cost);
      });
      $(document).find("._salvage_value").each(function() {
            var  _salvage_value =parseFloat($(this).val());
            if(isNaN( _salvage_value)){ _salvage_value = 0}
          total_salvage_value +=parseFloat( _salvage_value);
      });

      $(document).find("._depreciable_asset_value").each(function() {
            var  _depreciable_asset_value =parseFloat($(this).val());
            if(isNaN( _depreciable_asset_value)){ _depreciable_asset_value = 0}
          total_depreciable_asset_value +=parseFloat( _depreciable_asset_value);
      });

     

      $(document).find("._other_cost_bdt").each(function() {
            var _other_cost_bdt =parseFloat($(this).val());
            if(isNaN(_other_cost_bdt)){_other_cost_bdt = 0}
          total_other_cost_bdt +=parseFloat(_other_cost_bdt);
      });

      $(document).find("._asset_value_bdt").each(function() {
            var _asset_value_bdt =parseFloat($(this).val());
            if(isNaN(_asset_value_bdt)){_asset_value_bdt = 0}
          total_asset_value_bdt +=parseFloat(_asset_value_bdt);
      });


       $(document).find(".total_qty").val(parseFloat(total_qty).toFixed(2));
       $(document).find(".total_cfr_value_usd").val(parseFloat(total_cfr_value_usd).toFixed(2));
       $(document).find(".total_cfr_value_bdt").val(parseFloat(total_cfr_value_bdt).toFixed(2));
       $(document).find(".total_insurance_bdt").val(parseFloat(total_insurance_bdt).toFixed(2));
       $(document).find(".total_custom_duty_bdt").val(parseFloat(total_custom_duty_bdt).toFixed(2));
       $(document).find(".total_lc_commision_bdt").val(parseFloat(total_lc_commision_bdt).toFixed(2));
       $(document).find(".total_custom_duty_tax_ait").val(parseFloat(total_custom_duty_tax_ait).toFixed(2));
       $(document).find(".total_custom_duty_tax_ait_2nd").val(parseFloat(total_custom_duty_tax_ait_2nd).toFixed(2));
       $(document).find(".total_customer_other_charge_other").val(parseFloat(total_customer_other_charge_other).toFixed(2));
       $(document).find(".total_port_charge").val(parseFloat(total_port_charge).toFixed(2));
       $(document).find(".total_port_charge_ait").val(parseFloat(total_port_charge_ait).toFixed(2));
       $(document).find(".total_shiping_agent_charge").val(parseFloat(total_shiping_agent_charge).toFixed(2));
       $(document).find(".total_shiping_agent_deduction_charge_2nd").val(parseFloat(total_shiping_agent_deduction_charge_2nd).toFixed(2));
       $(document).find(".total_deport_charge").val(parseFloat(total_deport_charge).toFixed(2));
       $(document).find(".total_container_damage_charge").val(parseFloat(total_container_damage_charge).toFixed(2));
       $(document).find(".total_cnf_agen_commision").val(parseFloat(total_cnf_agen_commision).toFixed(2));
       $(document).find(".total_installation_cost").val(parseFloat(total_installation_cost).toFixed(2));
       $(document).find(".total_other_cost").val(parseFloat(total_other_cost).toFixed(2));
       $(document).find(".total_salvage_value").val(parseFloat(total_salvage_value).toFixed(2));
       $(document).find(".total_depreciable_asset_value").val(parseFloat(total_depreciable_asset_value).toFixed(2));
       $(document).find(".total_other_cost_bdt").val(parseFloat(total_other_cost_bdt).toFixed(2));
       $(document).find(".total_total_initial_cost").val(parseFloat(total_total_initial_cost).toFixed(2));
       $(document).find(".total_asset_value_bdt").val(parseFloat(total_asset_value_bdt).toFixed(2));



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