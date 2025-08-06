<div class="tab-pane table-responsive" id="hrm_guarantors">
    <div class="">
<table class="table">
    <thead>
        <tr>
            <th >#</th>
            <th class="width_200_px">{{__('label._name')}}</th>
            <th class="width_200_px">{{__('label._father')}}</th>
            <th class="width_200_px">{{__('label._mother')}}</th>
            <th class="width_200_px">{{__('label._occupation')}}</th>
            <th class="width_200_px">{{__('label._workstation')}}</th>
            <th class="width_200_px">{{__('label._address1')}}</th>
            <th class="width_200_px">{{__('label._address2')}}</th>
            <th class="width_200_px">{{__('label._mobile')}}</th>
            <th class="width_200_px">{{__('label._email')}}</th>
            <th class="width_200_px">{{__('label._nationalid')}}</th>
            <th class="width_150_px">{{__('label._dob')}}</th>
        </tr>
    </thead>
      
    @php
$hrm_guarantorss=$data->_hrm_guarantors ?? [];
    @endphp
    <tbody class="hrm_guarantorss_body">
        @forelse($hrm_guarantorss as $h_e_key=>$guar_val)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_guarantors_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_guarantors_id[]" value="{{$guar_val->id ?? 0}}">
          </td>
           <td>
            <input type="text"   name="gur_name[]" class="form-control width_250_px gur_name " value="{{$guar_val->_name ?? '' }}" placeholder="{{__('label._name')}}" >
           </td>
           <td>
            <input type="text"   name="gur_father[]" class="form-control width_250_px gur_father " value="{{$guar_val->_father ?? '' }}" placeholder="{{__('label._father')}}" >
           </td>
           <td>
            <input type="text"   name="gur_mother[]" class="form-control width_250_px gur_mother " value="{{$guar_val->_mother ?? '' }}" placeholder="{{__('label._mother')}}" >
           </td>
           <td>
            <input type="text"   name="gur_occupation[]" class="form-control width_250_px gur_occupation " value="{{$guar_val->_occupation ?? '' }}" placeholder="{{__('label._occupation')}}" >
           </td>
           <td>
            <input type="text"   name="gur_workstation[]" class="form-control width_250_px gur_workstation " value="{{$guar_val->_workstation ?? '' }}" placeholder="{{__('label._workstation')}}" >
           </td>
           <td>
            <input type="text"   name="gur_address1[]" class="form-control width_250_px gur_address1 " value="{{$guar_val->_address1 ?? '' }}" placeholder="{{__('label._address1')}}" >
           </td>
           <td>
            <input type="text"   name="gur_address2[]" class="form-control width_250_px gur_address2 " value="{{$guar_val->_address2 ?? '' }}" placeholder="{{__('label._address2')}}" >
           </td>
           <td>
            <input type="text"   name="gur_mobile[]" class="form-control width_250_px gur_mobile " value="{{$guar_val->_mobile ?? '' }}" placeholder="{{__('label._mobile')}}" >
           </td>
           <td>
            <input type="text"   name="gur_email[]" class="form-control width_250_px gur_email " value="{{$guar_val->_email ?? '' }}" placeholder="{{__('label._email')}}" >
           </td>
           <td>
            <input type="text"   name="gur_nationalid[]" class="form-control width_250_px gur_nationalid " value="{{$guar_val->_nationalid ?? '' }}" placeholder="{{__('label._nationalid')}}" >
           </td>
           <td>
            <input type="date"   name="gur_dob[]" class="form-control width_250_px gur_dob " value="{{$guar_val->_dob ?? '' }}" placeholder="{{__('label._dob')}}" >
           </td>
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="11">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_guarantors(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>
</div>

</div>