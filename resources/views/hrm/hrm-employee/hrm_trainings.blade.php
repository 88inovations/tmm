<div class="tab-pane table-responsive" id="hrm_trainings">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._type')}}</th>
            <th>{{__('label._name')}}</th>
            <th>{{__('label._subject')}}</th>
            <th>{{__('label.organization_id')}}</th>
            <th>{{__('label._place')}}</th>
            <th>{{__('label._trfrom')}}</th>
            <th>{{__('label._trto')}}</th>
            <th>{{__('label._result')}}</th>
            <th>{{__('label._note')}}</th>
        </tr>
    </thead>
    @php
$hrm_trainingss=$data->_hrm_trainings ?? [];
    @endphp
    <tbody class="hrm_trainingss_body">
        @forelse($hrm_trainingss as $h_e_key=>$training)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_trainings_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_trainings_id[]" value="{{$training->id ?? 0}}">
          </td>
           <td>
                 <input type="text"   name="training_type[]" class="form-control _type " value="{{$training->_type ?? '' }}" placeholder="{{__('label._type')}}" >
            </td>
            
            <td>
                 <input type="text"   name="training_name[]" class="form-control _name " value="{{$training->_name ?? ''}}" placeholder="{{__('label._name')}}" >
            </td>
            <td>
                 <input type="text"   name="training_subject[]" class="form-control _subject " value="{{$training->_subject ?? '' }}" placeholder="{{__('label._subject')}}" >
            </td>
            <td>
                 <input type="text"   name="training_organized[]" class="form-control _organized " value="{{$training->_organized ?? '' }}" placeholder="{{__('label._organized')}}" >
            </td>
            <td>
                 <input type="text"   name="training_place[]" class="form-control _place " value="{{$training->_place ?? '' }}" placeholder="{{__('label._place')}}" >
            </td>
            <td>
                 <input type="date"   name="training_trfrom[]" class="form-control _trfrom " value="{{$training->_trfrom ?? '' }}" placeholder="{{__('label._trfrom')}}" >
            </td>
            <td>
                 <input type="date"   name="training_trto[]" class="form-control _trto " value="{{$training->_trto ?? '' }}" placeholder="{{__('label._trto')}}" >
            </td>
            <td>
                 <input type="text"   name="training_result[]" class="form-control _result " value="{{$training->_result ?? '' }}" placeholder="{{__('label._result')}}" >
            </td>
            <td>
                 <input type="text"   name="training_note[]" class="form-control _note " value="{{$training->_note ?? '' }}" placeholder="{{__('label._note')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="10">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_trainings(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div>