 

@if(isset($permited_organizations))

 <div class="form-group row">
              <label class="col-md-4 col-form-label">{!! __('label.organization') !!}:</label>
              <div class="col-md-8">
              <select class="form-control _master_organization_id" name="organization_id"  >
                @if(sizeof($permited_organizations)>1) 
                            <option value="">--{{__('label.select')}}--</option>
                            @endif
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
</div>
@endif

@if(isset($permited_branch))
                        <div class="form-group row">
                              <label class="col-md-4 col-form-label">{{__('label.Branch')}}:</label>
                              <div class="col-md-8">
                               <select class="form-control _master_branch_id" name="_branch_id"  >
                                  @if(sizeof($permited_branch) > 1) 
                           <option value="">--{{__('label.select')}}--</option>
                            @endif
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
@endif
@if(isset($permited_costcenters))
 <div class="form-group row">
                              <label class="col-md-4 col-form-label">{{__('label.Cost center')}}:</label>
                              <div class="col-md-8">
                               <select class="form-control _master_cost_center_id" name="_cost_center_id"  >
                                @if(sizeof($permited_costcenters)>1) 
                              <option value="">--{{__('label.select')}}--</option>
                           @endif
                                   @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                            </div>
                        </div>
@endif

@if(isset($permited_budgets))
<div class="form-group row">
                  <label class="col-md-4 col-form-label">{{__('label._budget_id')}}:</label>
                  <div class="col-md-8">
      <select class="form-control _master_budget_id" name="_budget_id"  >
           @if(sizeof($permited_budgets)>1) 
             <option value="">{{__('label.select')}}</option>
           @endif
          @forelse($permited_budgets as $b_val )
                         <option value="{{$b_val->id}}" @if(isset($request->_budget_id)) @if($request->_budget_id == $b_val->id) selected @endif   @endif> {{ $b_val->_name ?? '' }}</option>
           @empty
           @endforelse
       </select>
   </div>
</div>
@endif