@php
$check_info = $data->check_info ?? '';
$_voucher_emp_ref = $data->_voucher_emp_ref ?? '';
@endphp
@can('import_module')
@php
$lc_masters = \DB::table("lc_masters")->select('id','lc_ip_no')->get();
$_lc_id = $data->_lc_id ?? '';
$_lc_stage_id = $data->_lc_stage_id ?? '';
@endphp
<div class="col-xs-12 col-sm-12 col-md-3 display_none">
    <div class="form-group">
      <label class="mr-2" for="_lc_no">{{__('label._lc_no')}}:</label>
      <select class="form-control _lc_id _voucher_lc_id_select select2"
      attr_url="{{route('lc_wise_item')}}"
       name="_lc_id">
        <option value="">Select LC</option>
        @forelse($lc_masters as $lc)
        <option value="{{$lc->id}}" 
          attr_lc_no="{!! $lc->lc_ip_no ?? '' !!}"
          @if($_lc_id ==$lc->id) selected  @endif
           >{!! $lc->lc_ip_no ?? '' !!}</option>
        @empty
        @endforelse
      </select>
    
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-3 display_none">
    <div class="form-group">
      <label class="mr-2" for="_lc_stage_id">{{__('label._lc_stage_id')}}:</label>
      <select class="form-control _lc_stage_id  _voucher_lc_id_select"
       attr_url="{{route('lc_wise_item')}}"
  
       name="_lc_stage_id">
        <option value="">Select Stage</option>
        @forelse(lc_stages() as $skey=>$stage)
        <option value="{{$skey}}" 
          @if($_lc_stage_id ==$skey) selected  @endif
           >{!! $stage ?? '' !!}</option>
        @empty
        @endforelse
      </select>
    </div>
</div>

@endcan


<div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_man">Emp Ref:</label>
                              <input type="text" id="_search_main_sales_man" name="_search_main_sales_man" class="form-control _search_main_sales_man" value="{!! $_voucher_emp_ref->_name ?? '' !!}" placeholder="Emp Ref" >

                            <input type="hidden" id="_sales_man_id" name="_sales_man_id" class="form-control _sales_man" value="{{$data->_sales_man_id ?? ''}}" placeholder="Sales Man" >
                            <div class="search_box_sales_man"> </div>
                            </div>
                        </div>

<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_bank_name">{{__('label._bank_name')}}:</label>
      <input type="text" id="_bank_name" name="_bank_name" class="form-control _bank_name" value="{{old('_bank_name',$check_info->_bank_name ?? '')}}" placeholder="{{__('label._bank_name')}}" >
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_branch_name">{{__('label._branch_name')}}:</label>
      <input type="text" id="_branch_name" name="_branch_name" class="form-control _branch_name" value="{{old('_branch_name',$check_info->_branch_name ?? '')}}" placeholder="{{__('label._branch_name')}}" >
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_bank_account">{{__('label._bank_account')}}:</label>
      <input type="text" id="_bank_account" name="_bank_account" class="form-control _bank_account" value="{{old('_bank_account',$check_info->_bank_account ?? '')}}" placeholder="{{__('label._bank_account')}}" >
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_check_no">{{__('Bank CHEQUE Number')}}:</label>
      <input type="text" id="_check_no" name="_check_no" class="form-control _check_no" value="{{old('_check_no',$check_info->_check_no ?? '')}}" placeholder="{{__('Bank Check Number')}}" >
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_issue_date">{{__('CHEQUE Issue Date')}}:</label>
      <input type="date" id="_issue_date" name="_issue_date" class="form-control _issue_date" value="{{old('_issue_date',$check_info->_issue_date ?? '')}}"  >
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group">
      <label class="mr-2" for="_cash_date">{{__('CHEQUE Cash Date')}}:</label>
      <input type="date" id="_cash_date" name="_cash_date" class="form-control _cash_date" value="{{old('_cash_date',$check_info->_cash_date ?? '')}}"  >
    </div>
</div>