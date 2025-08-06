<div class="tab-pane table-responsive" id="hrm_transfers">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._forganization_id')}}</th>
            <th>{{__('label._fbranch_id')}}</th>
            <th>{{__('label._fcost_center_id')}}</th>
            <th>{{__('label._ttransfer')}}</th>

            <th>{{__('label._torganization_id')}}</th>
            <th>{{__('label._tbranch_id')}}</th>
            <th>{{__('label._tcost_center_id')}}</th>
            <th>{{__('label._tjoin')}}</th>
            <th>{{__('label._tnote')}}</th>
        </tr>

        
    </thead>
    @php
$hrm_transferss=$data->_hrm_transfers ?? [];
    @endphp
    <tbody class="hrm_transferss_body">
        @forelse($hrm_transferss as $h_e_key=>$transfer)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_transfers_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_transfers_id[]" value="{{$transfer->id ?? 0}}">
          </td>
           <td>
                 <select class="form-control _forganization_id" name="_forganization_id[]"  >
                    @if(sizeof($permited_organizations) > 1) 
                    <option value="">--Select--</option>
                     @endif
                   
                   @forelse($permited_organizations as $val )
                   <option value="{{$val->id}}" @if(isset($transfer->_forganization_id)) @if($transfer->_forganization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                   @empty
                   @endforelse
                 </select>
            </td>
            
            <td>
                 <select class="form-control _fbranch_id" name="_fbranch_id[]"  >
                               @if(sizeof($permited_branch) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" @if(isset($transfer->_fbranch_id)) @if($transfer->_fbranch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
            </td>
            <td>
                <select class="form-control _fcost_center_id" name="_fcost_center_id[]"  >
                               @if(sizeof($permited_costcenters) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($transfer->_fcost_center_id)) @if($transfer->_fcost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
            </td>
            <td>
                 <input type="date"   name="_ttransfer[]" class="form-control _ttransfer " value="{{$transfer->_ttransfer ?? '' }}" placeholder="{{__('label._ttransfer')}}" >
            </td>
            <td>
                 <select class="form-control _torganization_id" name="_torganization_id[]"  >
                    @if(sizeof($permited_organizations) > 1) 
                    <option value="">--Select--</option>
                     @endif
                   
                   @forelse($permited_organizations as $val )
                   <option value="{{$val->id}}" @if(isset($transfer->_torganization_id)) @if($transfer->_torganization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                   @empty
                   @endforelse
                 </select>
            </td>
            
            <td>
                 <select class="form-control _tbranch_id" name="_tbranch_id[]"  >
                               @if(sizeof($permited_branch) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" @if(isset($transfer->_tbranch_id)) @if($transfer->_tbranch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
            </td>
            <td>
                <select class="form-control _tcost_center_id" name="_tcost_center_id[]"  >
                               @if(sizeof($permited_costcenters) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($transfer->_tcost_center_id)) @if($transfer->_tcost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
            </td>
            <td>
                 <input type="date"   name="_tjoin[]" class="form-control _tjoin " value="{{$transfer->_tjoin ?? '' }}" placeholder="{{__('label._tjoin')}}" >
            </td>
            <td>
                 <input type="text"   name="_tnote[]" class="form-control _tnote " value="{{$transfer->_tnote ?? '' }}" placeholder="{{__('label._tnote')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="10">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_transfers(event)"><i class="fa fa-plus"></i></a>
                  </th>
        </tr>
    </tfoot>
</table>

</div>