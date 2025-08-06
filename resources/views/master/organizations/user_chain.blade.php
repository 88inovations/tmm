@php
 $attr_org_branches = $data->_org_branches?? [];
 $attr_org_departments=$data->_org_departments ?? [];
  $attr_org_designations=$data->_org_designations ?? [];
@endphp

 <h4 class="mb-2">{{__('label.organizations')}}</h4>
  <select attr_url="{{url('basic/organizationWisechain')}}" class="form-control mb-2 organization_id" name="organization_id"  >
    <option value="">{{__('label.select_organizations')}}</option>
    <option value="{{$data->id}}" selected  >{!! $data->_code ?? '' !!}-{!! $data->_name ?? '' !!}</option>
  </select>
  <div class="organizationWisechainBody">
 <h4 class="mb-2">{{__('label.branches')}}</h4>
  <select class="form-control mb-2 branch_id" name="branch_id" >
    <option value="">{{__('label.select_branches')}}</option>
    @forelse($attr_org_branches as $val)
    <option value="{{$val->branch_id}}" @if(isset($userInfo->branch_id) && $userInfo->branch_id==$val->branch_id) selected @endif >{!! $val->_branch
->_code ?? '' !!}-{!! $val->_branch
->_name ?? '' !!}</option>
    @empty
    @endforelse
  </select>
  <h4 class="mb-2">{{__('label.departments')}}</h4>
  <select class="form-control mb-2 department_id" name="department_id" >
    <option value="">{{__('label.select_departments')}}</option>
    @forelse($attr_org_departments as $val)
    <option value="{{$val->department_id}}" @if(isset($userInfo->department_id) && $userInfo->department_id==$val->department_id) selected @endif>{!! $val->_department->code ?? '' !!}-{!! $val->_department->name ?? '' !!}</option>
    @empty
    @endforelse
  </select>
  <h4 class="mb-2">{{__('label.designations')}}</h4>
  <select class="form-control mb-2 designation_id" name="designation_id" >
    <option value="">{{__('label.select_designations')}}</option>
    @forelse($attr_org_designations as $val)
    <option value="{{$val->designation_id}}" @if(isset($userInfo->designation_id) && $userInfo->designation_id==$val->designation_id) selected @endif>{!! $val->_designation->_code ?? '' !!}-{!! $val->_designation->_name ?? '' !!}</option>
    @empty
    @endforelse
  </select>
</div>