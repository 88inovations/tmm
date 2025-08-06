<div class="tab-pane " id="hrm_languages">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label._language')}}</th>
            <th>{{__('label._fluency')}}</th>
            <th>{{__('label._lnote')}}</th>
        </tr>
    </thead>
    @php
$hrm_languagess=$data->_hrm_languages ?? [];
    @endphp
    <tbody class="hrm_languagess_body">
        @forelse($hrm_languagess as $h_e_key=>$lan)
        <tr>
            <td>
            <a href="#none" class="btn btn-default hrm_languages_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_languages_id[]" value="{{$lan->id ?? 0}}">
          </td>
           <td>
                 <input type="text"   name="_language[]" class="form-control _language " value="{{$lan->_language ?? '' }}" placeholder="{{__('label._language')}}" >
            </td>
            
            <td>
                 <input type="text"   name="_fluency[]" class="form-control _fluency " value="{{$lan->_fluency ?? ''}}" placeholder="{{__('label._fluency')}}" >
            </td>
            <td>
                 <input type="text"   name="_lnote[]" class="form-control _lnote " value="{{$lan->_lnote ?? '' }}" placeholder="{{__('label._lnote')}}" >
            </td>
            
        </tr>
        @empty
        @endforelse
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNew_hrm_languages(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="6"></th>
        </tr>
    </tfoot>
</table>

</div>