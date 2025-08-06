
<div class="form-group row">
        <label for="_default_inventory" class="col-sm-5 col-form-label">Default Inventory</label>
        <select class="form-control col-sm-7" name="_default_inventory">
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_inventory))@if($form_settings->_default_inventory==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_production_account" class="col-sm-5 col-form-label">Production Account</label>
        <select class="form-control col-sm-7" name="_production_account">
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_production_account))@if($form_settings->_production_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_transit_account" class="col-sm-5 col-form-label">Transfer Account</label>
        <select class="form-control col-sm-7" name="_transit_account">
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_transit_account))@if($form_settings->_transit_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      
      
      <div class="form-group row">
        <label for="_show_unit" class="col-sm-5 col-form-label">Show Unit</label>
        <select class="form-control col-sm-7" name="_show_unit">
         
          <option value="0" @if(isset($form_settings->_show_unit))@if($form_settings->_show_unit==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_unit))@if($form_settings->_show_unit==1) selected @endif @endif>YES</option>
        </select>
      </div>
      
      <div class="form-group row">
        <label for="_show_cost_rate" class="col-sm-5 col-form-label">Show Cost Rate</label>
        <select class="form-control col-sm-7" name="_show_cost_rate">
         
          <option value="0" @if(isset($form_settings->_show_cost_rate))@if($form_settings->_show_cost_rate==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_cost_rate))@if($form_settings->_show_cost_rate==1) selected @endif @endif>YES</option>
        </select>
      </div>
      
      
      
      
      <div class="form-group row">
        <label for="_show_barcode" class="col-sm-5 col-form-label">Show Barcode</label>
        <select class="form-control col-sm-7" name="_show_barcode">
          <option value="0" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_store" class="col-sm-5 col-form-label">Show Store</label>
        <select class="form-control col-sm-7" name="_show_store">
          <option value="0" @if(isset($form_settings->_show_store))@if($form_settings->_show_store==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_store))@if($form_settings->_show_store==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_self" class="col-sm-5 col-form-label">Show Shelf</label>
        <select class="form-control col-sm-7" name="_show_self">
          <option value="0" @if(isset($form_settings->_show_self))@if($form_settings->_show_self==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_self))@if($form_settings->_show_self==1) selected @endif @endif>YES</option>
        </select>
      </div>
     <div class="form-group row">
        <label for="_show_expire_date" class="col-sm-5 col-form-label">Show Expire Date</label>
        <select class="form-control col-sm-7" name="_show_expire_date">
          <option value="0" @if(isset($form_settings->_show_expire_date))@if($form_settings->_show_expire_date==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_expire_date))@if($form_settings->_show_expire_date==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_manufacture_date" class="col-sm-5 col-form-label">Show Manufacture Date</label>
        <select class="form-control col-sm-7" name="_show_manufacture_date">
          <option value="0" @if(isset($form_settings->_show_manufacture_date))@if($form_settings->_show_manufacture_date==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_manufacture_date))@if($form_settings->_show_manufacture_date==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_warranty" class="col-sm-5 col-form-label"> Show Warranty</label>
        <select class="form-control col-sm-7" name="_show_warranty">
          <option value="0" @if(isset($form_settings->_show_warranty))@if($form_settings->_show_warranty==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_warranty))@if($form_settings->_show_warranty==1) selected @endif @endif>YES</option>
        </select>
      </div>
      
     
      
      <div class="form-group row">
        <label for="_invoice_template" class="col-sm-5 col-form-label">Invoice Template</label>
        <select class="form-control col-sm-7" name="_invoice_template">
          <option value="1" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==1) selected @endif @endif>Template A</option>
          <option value="2" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==2) selected @endif @endif>Template B</option>
          <option value="3" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==3) selected @endif @endif>Template C</option>
          <option value="4" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==4) selected @endif @endif>Template D</option>
          
        </select>
      </div>
<br>

      <script type="text/javascript">
         $('.select2').select2()
      </script>