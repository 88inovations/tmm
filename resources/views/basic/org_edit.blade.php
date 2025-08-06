@php
$users = \Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
 $permited_budgets = permited_budgets(explode(',',$users->cost_center_ids));

$organization_id = $data->organization_id ?? '';
$_budget_id = $data->_budget_id ?? '';
$_cost_center_id = $data->_cost_center_id ?? '';
$_branch_id = $data->_branch_id ?? '';

@endphp 

<div class="col-xs-12 col-sm-12 col-md-2 ">
 <div class="form-group ">
     <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
    <select class="form-control _master_organization_id" name="organization_id" required >
        @if(sizeof($permited_organizations) > 1)
        <option value=""><---Select---></option>
        @endif

       @forelse($permited_organizations as $val )
       <option value="{{$val->id}}" @if($organization_id == $val->id) selected @endif >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
       @empty
       @endforelse
     </select>
 </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group ">
        <label>Branch:<span class="_required">*</span></label>
       <select class="form-control _master_branch_id" name="_branch_id" required >
          @if(sizeof($permited_branch) > 1)
        <option value=""><---Select---></option>
        @endif
        
          @forelse($permited_branch as $branch )
          <option value="{{$branch->id}}" @if($_branch_id == $branch->id) selected @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
          @empty
          @endforelse
        </select>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group ">
        <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
       <select class="form-control _cost_center_id" name="_cost_center_id" required >
            @if(sizeof($permited_costcenters) > 1)
        <option value=""><---Select---></option>
        @endif
          @forelse($permited_costcenters as $cost_center )
          <option value="{{$cost_center->id}}" @if($_cost_center_id == $cost_center->id) selected @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
          @empty
          @endforelse
        </select>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-2  ">
   <div class="form-group ">
       <label>{{__('label._budget_id')}}:</label>
      <select class="form-control _master_budget_id" name="_budget_id"  >
           @if(sizeof($permited_budgets)>1) 
             <option value="">{{__('label.select')}}</option>
           @endif
          @forelse($permited_budgets as $b_val )
                         <option value="{{$b_val->id}}" @if($_budget_id == $b_val->id) selected @endif> {{ $b_val->_name ?? '' }}</option>
           @empty
           @endforelse
       </select>
   </div>
</div>