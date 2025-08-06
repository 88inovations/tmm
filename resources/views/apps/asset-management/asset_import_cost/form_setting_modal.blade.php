
<div class="form-group row">
        <label for="_insurance_bdt_ledger_id" class="col-sm-5 col-form-label">{{__('label._insurance_bdt')}}</label>
        <select class="form-control col-sm-7" name="_insurance_bdt_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_insurance_bdt_ledger_id))@if($form_settings->_insurance_bdt_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_lc_commision_bdt_ledger_id" class="col-sm-5 col-form-label">{{__('label._lc_commision_bdt')}}</label>
        <select class="form-control col-sm-7" name="_lc_commision_bdt_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_lc_commision_bdt_ledger_id))@if($form_settings->_lc_commision_bdt_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_custom_duty_bdt_ledger_id" class="col-sm-5 col-form-label">{{__('label._custom_duty_bdt')}}</label>
        <select class="form-control col-sm-7" name="_custom_duty_bdt_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_custom_duty_bdt_ledger_id))@if($form_settings->_custom_duty_bdt_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_custom_duty_tax_ait_ledger_id" class="col-sm-5 col-form-label">{{__('label._custom_duty_tax_ait')}}</label>
        <select class="form-control col-sm-7" name="_custom_duty_tax_ait_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_custom_duty_tax_ait_ledger_id))@if($form_settings->_custom_duty_tax_ait_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_custom_duty_tax_ait_2nd_ledger_id" class="col-sm-5 col-form-label">{{__('label._custom_duty_tax_ait_2nd')}}</label>
        <select class="form-control col-sm-7" name="_custom_duty_tax_ait_2nd_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_custom_duty_tax_ait_2nd_ledger_id))@if($form_settings->_custom_duty_tax_ait_2nd_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_customer_other_charge_other_ledger_id" class="col-sm-5 col-form-label">{{__('label._customer_other_charge_other')}}</label>
        <select class="form-control col-sm-7" name="_customer_other_charge_other_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_customer_other_charge_other_ledger_id))@if($form_settings->_customer_other_charge_other_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_port_charge_ledger_id" class="col-sm-5 col-form-label">{{__('label._port_charge')}}</label>
        <select class="form-control col-sm-7" name="_port_charge_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_port_charge_ledger_id))@if($form_settings->_port_charge_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_port_charge_ait_ledger_id" class="col-sm-5 col-form-label">{{__('label._port_charge_ait')}}</label>
        <select class="form-control col-sm-7" name="_port_charge_ait_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_port_charge_ait_ledger_id))@if($form_settings->_port_charge_ait_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_shiping_agent_charge_ledger_id" class="col-sm-5 col-form-label">{{__('label._shiping_agent_charge')}}</label>
        <select class="form-control col-sm-7" name="_shiping_agent_charge_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_shiping_agent_charge_ledger_id))@if($form_settings->_shiping_agent_charge_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_shiping_agent_deduction_charge_2nd_ledger_id" class="col-sm-5 col-form-label">{{__('label._shiping_agent_deduction_charge_2nd')}}</label>
        <select class="form-control col-sm-7" name="_shiping_agent_deduction_charge_2nd_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_shiping_agent_deduction_charge_2nd_ledger_id))@if($form_settings->_shiping_agent_deduction_charge_2nd_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_deport_charge_ledger_id" class="col-sm-5 col-form-label">{{__('label._deport_charge')}}</label>
        <select class="form-control col-sm-7" name="_deport_charge_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_deport_charge_ledger_id))@if($form_settings->_deport_charge_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_container_damage_charge_ledger_id" class="col-sm-5 col-form-label">{{__('label._container_damage_charge')}}</label>
        <select class="form-control col-sm-7" name="_container_damage_charge_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_container_damage_charge_ledger_id))@if($form_settings->_container_damage_charge_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_cnf_agen_commision_ledger_id" class="col-sm-5 col-form-label">{{__('label._cnf_agen_commision')}}</label>
        <select class="form-control col-sm-7" name="_cnf_agen_commision_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_cnf_agen_commision_ledger_id))@if($form_settings->_cnf_agen_commision_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
<div class="form-group row">
        <label for="_installation_cost_ledger_id" class="col-sm-5 col-form-label">{{__('label._installation_cost')}}</label>
        <select class="form-control col-sm-7" name="_installation_cost_ledger_id">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_installation_cost_ledger_id))@if($form_settings->_installation_cost_ledger_id==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
    
         
         
         
      </div>
      <br><br><br>

      <script type="text/javascript">
         $('.select2').select2()
      </script>