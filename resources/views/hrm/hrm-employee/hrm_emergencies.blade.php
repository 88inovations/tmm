<div class="tab-pane " id="hrm_emergencies">
<table class="table">
    <thead>
       
        <tr>
            <th>#</th>
            <th>{{__('label._name')}}</th>
            <th>{{__('label._relationship')}}</th>
            <th>{{__('label._mobile')}}</th>
            <th>{{__('label._home')}}</th>
            <th>{{__('label._work')}}</th>
        </tr>
    </thead>
    @php
$hrm_emergencies=$data->hrm_emergencies ?? [];

    @endphp
    <tbody class="hrm_emergencies_body">
        @forelse($hrm_emergencies as $em_key=>$em_val)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_emergencies_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_emergencies_id[]" value="{{$em_val->id ?? 0}}">
          </td>
           <td>
                 <input type="text"   name="emerg_name[]" class="form-control _name " value="{{$em_val->_name ?? '' }}" placeholder="{{__('label._name')}}" >
            </td>
            
            <td>
                 <input type="text"   name="emerg_relationship[]" class="form-control _relationship " value="{{$em_val->_relationship ?? ''}}" placeholder="{{__('label._relationship')}}" >
            </td>
            <td>
                 <input type="text"   name="emerg_mobile[]" class="form-control _mobile " value="{{$em_val->_mobile ?? '' }}" placeholder="{{__('label._mobile')}}" >
            </td>
            <td>
                 <input type="text"   name="emerg_home[]" class="form-control _home " value="{{$em_val->_home ?? '' }}" placeholder="{{__('label._home')}}" >
            </td>
            <td>
                 <input type="text"   name="emerg_work[]" class="form-control _work " value="{{$em_val->_work ?? '' }}" placeholder="{{__('label._work')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="6">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_emergencies(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div>