<div class="tab-pane " id="hrm_experiences">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._company')}}</th>
            <th>{{__('label._jobtitle_id')}}</th>
            <th>{{__('label._wfrom')}}</th>
            <th>{{__('label._wto')}}</th>
            <th>{{__('label._note')}}</th>
        </tr>
    </thead>
    @php
$hrm_experiences=$data->hrm_experiences ?? [];
    @endphp
    <tbody class="hrm_experiences_body">
        @forelse($hrm_experiences as $h_e_key=>$val)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_experiences_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_experiences_id[]" value="{{$val->id ?? 0}}">
          </td>
           <td>
                 <input type="text" name="_company[]" class="form-control _company" placeholder="{{__('label._company')}}" value="{{$val->_company ?? '' }}">
            </td>
            <td>
                <select class="form-control " name="hrm_experiences_jobtitle_id[]"  >
                  <option value="">{{__('label.select')}}</option>
                  @forelse($designations as $deg)
                  <option value="{{$deg->id}}" @if($val->_jobtitle_id==$deg->id) selected @endif>{!! $deg->_name ?? '' !!}</option>
                  @empty
                  @endforelse
                </select>
            </td>
            <td>
                 <input type="date"   name="_wfrom[]" class="form-control _wfrom " value="{{$val->_wfrom ?? '' }}" placeholder="{{__('label._wfrom')}}" >
            </td>
            <td>
                 <input type="date"   name="_wto[]" class="form-control _wto " value="{{$val->_wto ?? '' }}" placeholder="{{__('label._wto')}}" >
            </td>
            
            <td>
                 <input type="text"   name="_note[]" class="form-control _note " value="{{$val->_note ?? ''}}" placeholder="{{__('label._note')}}" >
            </td>
            
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_experiences(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><!-- ENd of Tab -->