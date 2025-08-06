     @php
              $users = \Auth::user();
              $permited_organizations = permited_organization(explode(',',$users->organization_ids));
              
              @endphp 


              <div class="col-xs-12 col-sm-12 col-md-12 ">
              <div class="form-group ">
              <label>{!! __('label.organization') !!}:</label>
              <select  class="form-control _master_organization_id " name="organization_id"  >

                @if(sizeof($permited_organizations) > 1)
                <option value="all">All {!! __('label.organization') !!}</option>
                @endif
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" 
                @if(isset($previous_filter["organization_id"]) && $val->id==$previous_filter["organization_id"]) ) selected @endif
                               >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
              </div>
              <div class="col-md-12">
                          <label>{{__('label._branch_id')}}:</label>
                         <select id="_branch_id" class="form-control _branch_id _master_branch_id" name="_branch_id"  >
                          @if(sizeof($permited_branch) > 1)
                          <option value="all">All {{__('label._branch_id')}}</option>
                          @endif
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" 
                            @if(isset($previous_filter["_branch_id"]) && $branch->id==$previous_filter["_branch_id"]) selected @endif
                             > {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>
                      <div class="col-md-12">
                          <label>{{__('label._cost_center_id')}}:</label>
                         <select class="form-control width_150_px _cost_center "  name="_cost_center"   >
                          @if(sizeof($permited_costcenters) > 1)
                                      <option value="all">All {{__('label._cost_center_id')}}</option>
                          @endif
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]) && $costcenter->id==$previous_filter["_cost_center"]) selected @endif
                                 
                              > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>