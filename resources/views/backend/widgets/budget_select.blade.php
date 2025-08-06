 


              <div class="col-xs-12 col-sm-12 col-md-2 ">
              <div class="form-group ">
              <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
              <select class="form-control _master_organization_id" name="organization_id" required >
                @if(sizeof($permited_organizations)>1) 
                            <option value="">--{{__('label.select')}}--</option>
                            @endif
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
              </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group ">
                                <label>{{__('label.Branch')}}:<span class="_required">*</span></label>
                               <select class="form-control _master_branch_id" name="_branch_id" required >
                                  @if(sizeof($permited_branch) > 1) 
                           <option value="">--{{__('label.select')}}--</option>
                            @endif
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2  ">
                            <div class="form-group ">
                                <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
                               <select class="form-control _master_cost_center_id" name="_cost_center_id" required >
                                @if(sizeof($permited_costcenters)>1) 
                              <option value="">--{{__('label.select')}}--</option>
                           @endif
                                   @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
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
                         <option value="{{$b_val->id}}" @if(isset($data->_budget_id)) @if($data->_budget_id == $b_val->id) selected @endif   @endif> {{ $b_val->_name ?? '' }}</option>
           @empty
           @endforelse
       </select>
   </div>
</div>