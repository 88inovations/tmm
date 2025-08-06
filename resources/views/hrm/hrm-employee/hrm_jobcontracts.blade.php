<div class="tab-pane " id="hrm_jobcontracts">

    @php
    $hrm_jobcontracts = $data->hrm_jobcontracts ?? '';
    @endphp
    <div class="">
            <div class="form-group row">
                <label class="col-md-2">{{__('label._ctype')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_ctype" class="form-control" value="{{$hrm_jobcontracts->_ctype ?? ''}}" placeholder="{{__('label._ctype')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._csdate')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="date" name="_csdate" class="form-control" value="{{$hrm_jobcontracts->_csdate ?? ''}}" placeholder="{{__('label._csdate')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._cedate')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="date" name="_cedate" class="form-control" value="{{$hrm_jobcontracts->_cedate ?? ''}}" placeholder="{{__('label._cedate')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._cdetail')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                    <textarea class="form-control" name="_cdetail">{!! $hrm_jobcontracts->_cdetail ?? '' !!}</textarea>
                   
                 </div>
            </div>
    </div>

</div>