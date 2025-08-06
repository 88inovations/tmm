<div class="tab-pane " id="hrm_empaddresses">
<table class="table">
    <thead>
      
        <tr>
            <th>#</th>
            <th>{{__('label._type')}}</th>
            <th>{{__('label._district')}}</th>
            <th>{{__('label._police')}}</th>
            <th>{{__('label._post')}}</th>
            <th>{{__('label._address')}}</th>
            <th>{{__('label._eaddress')}}</th>
        </tr>
    </thead>
    @php
$hrm_empaddresses=$data->hrm_empaddresses ?? [];
    @endphp
    <tbody class="hrm_empaddresses_body">
        @forelse($hrm_empaddresses as $h_e_key=>$val)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_empaddresses_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_empaddresses_id[]" value="{{$val->id ?? 0}}">
          </td>
           <td>
                 <select name="_type[]" class="form-control _type">
                     <option value="Present" @if($val->_type=="Present") selected @endif>Present</option>
                     <option value="Parmanent" @if($val->_type=="Parmanent") selected @endif>Parmanent</option>
                 </select>
            </td>
            <td>
                 <input type="text"   name="_district[]" class="form-control _district " value="{{$val->_district ?? '' }}" placeholder="{{__('label._district')}}" >
            </td>
            <td>
                 <input type="text"   name="_police[]" class="form-control _police " value="{{$val->_police ?? '' }}" placeholder="{{__('label._police')}}" >
            </td>
            <td>
                 <input type="text"   name="_post[]" class="form-control _post " value="{{$val->_post ?? '' }}" placeholder="{{__('label._post')}}" >
            </td>
            
            <td>
                 <input type="text"   name="_address[]" class="form-control _address " value="{{$val->_address ?? ''}}" placeholder="{{__('label._address')}}" >
            </td>
            <td>
                 <input type="text"   name="_eaddress[]" class="form-control _eaddress " value="{{$val->_eaddress ?? '' }}" placeholder="{{__('label._eaddress')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewhrm_empaddresses(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div><!-- ENd of Tab -->