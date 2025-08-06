<div class="tab-pane " id="hrm_nominees">

    @php
    $hrm_nominees = $data->hrm_nominees ?? '';
    @endphp
    <div class="">
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nname')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nname" class="form-control" value="{{$hrm_nominees->_nname ?? ''}}" placeholder="{{__('label._nname')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nfather')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nfather" class="form-control" value="{{$hrm_nominees->_nfather ?? ''}}" placeholder="{{__('label._nfather')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nmother')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nmother" class="form-control" value="{{$hrm_nominees->_nmother ?? ''}}" placeholder="{{__('label._nmother')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._ndob')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="date" name="_ndob" class="form-control" value="{{$hrm_nominees->_ndob ?? ''}}" placeholder="{{__('label._ndob')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nnationalid')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nnationalid" class="form-control" value="{{$hrm_nominees->_nnationalid ?? ''}}" placeholder="{{__('label._nnationalid')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nmobile')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nmobile" class="form-control" value="{{$hrm_nominees->_nmobile ?? ''}}" placeholder="{{__('label._nmobile')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._naddress1')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_naddress1" class="form-control" value="{{$hrm_nominees->_naddress1 ?? ''}}" placeholder="{{__('label._naddress1')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._naddress2')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_naddress2" class="form-control" value="{{$hrm_nominees->_naddress2 ?? ''}}" placeholder="{{__('label._naddress2')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nrelation')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nrelation" class="form-control" value="{{$hrm_nominees->_nrelation ?? ''}}" placeholder="{{__('label._nrelation')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nbenefit')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                   <input type="text" name="_nbenefit" class="form-control" value="{{$hrm_nominees->_nbenefit ?? ''}}" placeholder="{{__('label._nbenefit')}}">
                 </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2">{{__('label._nphoto')}}:</label>
                <div class="col-xs-12 col-sm-12 col-md-5 ">
                     <input type="file" accept="image/*" onchange="loadFile(event,3 )"  name="_nphoto" class="form-control">
                               <img id="output_3" class="banner_image_create" src="{{asset($hrm_nominees->_nphoto ?? $settings->logo ?? '')}}"  style="max-height:100px;max-width: 100px; " />

                   
                 </div>
            </div>
           
    </div>

</div>
