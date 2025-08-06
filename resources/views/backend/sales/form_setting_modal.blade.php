
<div class="form-group row">
        <label for="_default_inventory" class="col-sm-5 col-form-label">Default Inventory</label>
        <select class="form-control col-sm-7" name="_default_inventory">
          <option value="">--Select ledger--</option>
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_inventory))@if($form_settings->_default_inventory==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_sales" class="col-sm-5 col-form-label">Default Sales Account</label>
        <select class="form-control col-sm-7" name="_default_sales">
          <option value="">--Select ledger--</option>
          @foreach($p_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_sales))@if($form_settings->_default_sales==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_cost_of_solds" class="col-sm-5 col-form-label">Cost of Goods Sold</label>
        <select class="form-control col-sm-7" name="_default_cost_of_solds">
          <option value="">--Select ledger--</option>
          @foreach($cost_of_solds as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_cost_of_solds))@if($form_settings->_default_cost_of_solds==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_discount" class="col-sm-5 col-form-label">Default Discount Account</label>
        <select class="form-control col-md-7" name="_default_discount">
          <option value="">--Select ledger--</option>
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_discount))@if($form_settings->_default_discount==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_vat_account" class="col-sm-5 col-form-label">Default VAT Account</label>
        <select class="form-control col-md-7" name="_default_vat_account">
          <option value="">--Select ledger--</option>
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_vat_account))@if($form_settings->_default_vat_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group row">
        <label for="_default_cash_account" class="col-sm-5 col-form-label">Default CASH Account</label>
        <select class="form-control col-md-7" name="_default_cash_account">
          <option value="">--Select ledger--</option>
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_cash_account))@if($form_settings->_default_cash_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group row">
        <label for="_show_default_cash" class="col-sm-5 col-form-label">Selected Cash Account</label>
        <select class="form-control col-sm-7" name="_show_default_cash">
         
          <option value="0" @if(isset($form_settings->_show_default_cash))@if($form_settings->_show_default_cash==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_default_cash))@if($form_settings->_show_default_cash==1) selected @endif @endif>YES</option>
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
        <label for="_show_free_qty" class="col-sm-5 col-form-label">Show Free Qty</label>
        <select class="form-control col-sm-7" name="_show_free_qty">
         
          <option value="0" @if(isset($form_settings->_show_free_qty))@if($form_settings->_show_free_qty==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_free_qty))@if($form_settings->_show_free_qty==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_sales_man" class="col-sm-5 col-form-label">Show Sales Man</label>
        <select class="form-control col-sm-7" name="_show_sales_man">
         
          <option value="0" @if(isset($form_settings->_show_sales_man))@if($form_settings->_show_sales_man==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_sales_man))@if($form_settings->_show_sales_man==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_delivery_man" class="col-sm-5 col-form-label">Show Delivery Man</label>
        <select class="form-control col-sm-7" name="_show_delivery_man">
         
          <option value="0" @if(isset($form_settings->_show_delivery_man))@if($form_settings->_show_delivery_man==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_delivery_man))@if($form_settings->_show_delivery_man==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_payment_terms" class="col-sm-5 col-form-label">Show Payment Terms</label>
        <select class="form-control col-sm-7" name="_show_payment_terms">
         
          <option value="0" @if(isset($form_settings->_show_payment_terms))@if($form_settings->_show_payment_terms==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_payment_terms))@if($form_settings->_show_payment_terms==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_inline_discount" class="col-sm-5 col-form-label">Show Inline Discount</label>
        <select class="form-control col-sm-7" name="_inline_discount">
         
          <option value="0" @if(isset($form_settings->_inline_discount))@if($form_settings->_inline_discount==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_inline_discount))@if($form_settings->_inline_discount==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_vat" class="col-sm-5 col-form-label">Show VAT</label>
        <select class="form-control col-sm-7" name="_show_vat">
         
          <option value="0" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==1) selected @endif @endif>YES</option>
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
        <label for="_show_model" class="col-sm-5 col-form-label">Show Model</label>
        <select class="form-control col-sm-7" name="_show_model">
          <option value="0" @if(isset($form_settings->_show_model))@if($form_settings->_show_model==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_model))@if($form_settings->_show_model==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_pack_size" class="col-sm-5 col-form-label">Show Pack Size</label>
        <select class="form-control col-sm-7" name="_show_pack_size">
          <option value="0" @if(isset($form_settings->_show_pack_size))@if($form_settings->_show_pack_size==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_pack_size))@if($form_settings->_show_pack_size==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_short_note" class="col-sm-5 col-form-label">Show Short Note</label>
        <select class="form-control col-sm-7" name="_show_short_note">
          <option value="0" @if(isset($form_settings->_show_short_note))@if($form_settings->_show_short_note==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_short_note))@if($form_settings->_show_short_note==1) selected @endif @endif>YES</option>
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
        <label for="_show_p_balance" class="col-sm-5 col-form-label">Invoice Show Previous Balance</label>
        <select class="form-control col-sm-7" name="_show_p_balance">
          <option value="0" @if(isset($form_settings->_show_p_balance))@if($form_settings->_show_p_balance==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_p_balance))@if($form_settings->_show_p_balance==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_due_history" class="col-sm-5 col-form-label">Show Due Invoice</label>
        <select class="form-control col-sm-7" name="_show_due_history">
          <option value="0" @if(isset($form_settings->_show_due_history))@if($form_settings->_show_due_history==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_due_history))@if($form_settings->_show_due_history==1) selected @endif @endif>YES</option>
        </select>
      </div>
      
      <div class="form-group row">
        <label for="_invoice_template" class="col-sm-5 col-form-label">Invoice Template</label>
        <select class="form-control col-sm-7" name="_invoice_template">
          <option value="1" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==1) selected @endif @endif>Template A</option>
          <option value="2" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==2) selected @endif @endif>Template B</option>
          <option value="3" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==3) selected @endif @endif>Template C</option>
          <option value="4" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==4) selected @endif @endif>Template D</option>
          <option value="6" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==6) selected @endif @endif>Template E</option>
          <option value="5" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==5) selected @endif @endif>Pos Template</option>
          <option value="7" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==7) selected @endif @endif>Invoice AV</option>
          <option value="9" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==9) selected @endif @endif>Print 9</option>
          <option value="10" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==10) selected @endif @endif>Print 10</option>
          <option value="11" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==11) selected @endif @endif>Print 11</option>
          <option value="12" @if(isset($form_settings->_invoice_template))@if($form_settings->_invoice_template==12) selected @endif @endif>Print 12</option>
        </select>
      </div>

      @php
      $_string_ids = $form_settings->_cash_customer ?? 0;
      if($_string_ids !=0){
        $_cash_customer = explode(",",$_string_ids);
      }else{
        $_cash_customer =[];
      }
      @endphp
      <div class="form-group row">
        <label for="_cash_customer" class="col-sm-4 col-form-label">Cash Customer</label>
        <select class="form-control col-sm-8 select2" name="_cash_customer[]" multiple size="8">
          @forelse($_cash_customers as $value)
          <option value="{{$value->id}}" @if(in_array($value->id,$_cash_customer)) selected @endif >{{ $value->_name ?? '' }}</option>
          @empty
          @endforelse
         
        </select>
      </div>
      <br><br><br>
      <div class="form-group row">
        <label for="_defaut_customer" class="col-sm-4 col-form-label">Default Customer</label>
        <select class="form-control col-sm-8 " name="_defaut_customer"  >
            <option value="">Select Customer</option>
          @forelse($_cash_customers as $value)
          <option value="{{$value->id}}" @if($value->id==$form_settings->_defaut_customer) selected @endif >{{ $value->_name ?? '' }}</option>
          @empty
          @endforelse
         
        </select>
      </div>
      <div class="form-group row">
        <label for="_is_header" class="col-sm-5 col-form-label">Invoice Header Show</label>
        <select class="form-control col-sm-7" name="_is_header">
          <option value="0" @if(isset($form_settings->_is_header))@if($form_settings->_is_header==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_is_header))@if($form_settings->_is_header==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_is_footer" class="col-sm-5 col-form-label">Invoice Footer Show</label>
        <select class="form-control col-sm-7" name="_is_footer">
          <option value="0" @if(isset($form_settings->_is_footer))@if($form_settings->_is_footer==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_is_footer))@if($form_settings->_is_footer==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_margin_top" class="col-sm-5 col-form-label">Invoice Margin top</label>
         <input id="_margin_top" class="form-control col-sm-7" type="text" name="_margin_top" value="@if(isset($form_settings->_margin_top)){{$form_settings->_margin_top}} @endif">
      </div>
      <div class="form-group row">
        <label for="_margin_bottom" class="col-sm-5 col-form-label">Invoice Margin Bottom</label>
         <input id="_margin_bottom" class="form-control col-sm-7" type="text" name="_margin_bottom" value="@if(isset($form_settings->_margin_bottom)){{$form_settings->_margin_bottom}} @endif">
      </div>
      <div class="form-group row">
        <label for="_margin_left" class="col-sm-5 col-form-label">Invoice Margin Left</label>
         <input id="_margin_left" class="form-control col-sm-7" type="text" name="_margin_left" value="@if(isset($form_settings->_margin_left)){{$form_settings->_margin_left}} @endif">
      </div>
      <div class="form-group row">
        <label for="_margin_right" class="col-sm-5 col-form-label">Invoice Margin Right</label>
         <input id="_margin_right" class="form-control col-sm-7" type="text" name="_margin_right" value="@if(isset($form_settings->_margin_right)){{$form_settings->_margin_right}} @endif">
      </div>
      <div class="form-group row">
        <label for="_seal_image" class="col-sm-5 col-form-label">Authorised Signature</label>
        <div class="col-sm-7">
          <input id="_seal_image" class="form-control " type="file" name="_seal_image" value="@if(isset($form_settings->_seal_image)){{$form_settings->_seal_image}} @endif" onchange="loadFile(event,1 )">
         
         <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$form_settings->_seal_image ?? ''}}"  style="max-height:100px;max-width: 100px; " />
        </div>
         
         
         
      </div>
      <br><br><br>

      <script type="text/javascript">
         $('.select2').select2()
      </script>