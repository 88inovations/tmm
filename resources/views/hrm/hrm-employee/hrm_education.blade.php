<div class="tab-pane " id="hrm_education">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._level')}}</th>
            <th>{{__('label._subject')}}</th>
            <th>{{__('label._institute')}}</th>
            <th>{{__('label._year')}}</th>
            <th>{{__('label._score')}}</th>
            <th>{{__('label._edsdate')}}</th>
            <th>{{__('label._ededate')}}</th>
        </tr>
    </thead>
    @php
$hrm_educations=$data->_hrm_education ?? [];
    @endphp
    <tbody class="hrm_educations_body">
        @forelse($hrm_educations as $h_e_key=>$edu_val)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_education_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_education_id[]" value="{{$edu_val->id ?? 0}}">
          </td>
           <td>
                 <input type="text"   name="_level[]" class="form-control _level " value="{{$edu_val->_level ?? '' }}" placeholder="{{__('label._level')}}" >
            </td>
            
            <td>
                 <input type="text"   name="_subject[]" class="form-control _subject " value="{{$edu_val->_subject ?? ''}}" placeholder="{{__('label._subject')}}" >
            </td>
            <td>
                 <input type="text"   name="_institute[]" class="form-control _institute " value="{{$edu_val->_institute ?? '' }}" placeholder="{{__('label._institute')}}" >
            </td>
            <td>
                 <input type="text"   name="_year[]" class="form-control _year " value="{{$edu_val->_year ?? '' }}" placeholder="{{__('label._year')}}" >
            </td>
            <td>
                 <input type="text"   name="_score[]" class="form-control _score " value="{{$edu_val->_score ?? '' }}" placeholder="{{__('label._score')}}" >
            </td>
            <td>
                 <input type="date"   name="_edsdate[]" class="form-control _edsdate " value="{{$edu_val->_edsdate ?? '' }}" placeholder="{{__('label._edsdate')}}" >
            </td>
            <td>
                 <input type="date"   name="_ededate[]" class="form-control _ededate " value="{{$edu_val->_ededate ?? '' }}" placeholder="{{__('label._ededate')}}" >
            </td>
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_education(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div>