<div class="tab-pane " id="hrm_rewards">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._rcategory')}}</th>
            <th>{{__('label._rtype')}}</th>
            <th>{{__('label._rcause')}}</th>
            <th>{{__('label._rnote')}}</th>
        </tr>
    </thead>
    @php
$_hrm_rewards=$data->_hrm_rewards ?? [];
//dump($_hrm_rewards);
    @endphp
    <tbody class="hrm_rewardss_body">
        @forelse($_hrm_rewards as $h_e_key=>$reword)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_rewards_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_rewards_id[]" value="{{$reword->id ?? 0}}">
          </td>
           <td>
                 <input type="text"   name="_rcategory[]" class="form-control _rcategory " value="{{$reword->_rcategory ?? '' }}" placeholder="{{__('label._rcategory')}}" >
            </td>
            
            <td>
                 <input type="text"   name="_rtype[]" class="form-control _rtype " value="{{$reword->_rtype ?? ''}}" placeholder="{{__('label._rtype')}}" >
            </td>
            <td>
                 <input type="text"   name="_rcause[]" class="form-control _rcause " value="{{$reword->_rcause ?? '' }}" placeholder="{{__('label._rcause')}}" >
            </td>
            <td>
                 <input type="text"   name="_rnote[]" class="form-control _rnote " value="{{$reword->_rnote ?? '' }}" placeholder="{{__('label._rnote')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="5">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_rewards(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div>