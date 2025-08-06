<div  >

  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="" method="GET" class="form-horizontal">
            @csrf
              <div class="modal-content">
                <div class="modal-header">
                  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body search_modal">
                 @php 
                    $row_numbers = filter_page_numbers();
                         
                  @endphp
                 
                  <div class="form-group row">
                    <label for="_date" class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
                      <div class="row">
                         <div class="col-sm-3">Use Date: 
                          <select class="form-control" name="_user_date">
                            <option value="no" @if(isset($request->_user_date)) @if($request->_user_date=='no') selected @endif  @endif>No</option>
                            <option value="yes" @if(isset($request->_user_date)) @if($request->_user_date=='yes') selected @endif  @endif>Yes</option>
                          </select>

                         </div>
                        <div class="col-sm-4">From: 
                          
                          <div class="input-group date" id="reservationdate_datex" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input_datex" data-target="#reservationdate_datex" value="@if(isset($request->_datex)){{$request->_datex ?? ''}}@endif" />
                                      <div class="input-group-append" data-target="#reservationdate_datex" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                        </div>
                        <div class="col-sm-4">To: 
                          <div class="input-group date" id="reservationdate_datey" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_datey" data-target="#reservationdate_datey" value="@if(isset($request->_datey)){{$request->_datey ?? ''}}@endif" />
                                      <div class="input-group-append" data-target="#reservationdate_datey" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">{{__('label.id')}}:</label>
                    <div class="col-sm-9">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Search By Id" 
                      value="@if(isset($request->id)){{$request->id ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="rlp_no" class="col-sm-3 col-form-label">{{__('label.rlp_no')}}:</label>
                    <div class="col-sm-9">
                      <input type="text" id="rlp_no" name="rlp_no" class="form-control" placeholder="{{__('label.rlp_no')}}" 
                      value="@if(isset($request->rlp_no)){{$request->rlp_no ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="rlp_user_office_id" class="col-sm-3 col-form-label">{{__('label.rlp_user_office_id')}}:</label>
                    <div class="col-sm-9">
                      <input type="text" id="rlp_user_office_id" name="rlp_user_office_id" class="form-control" placeholder="{{__('label.rlp_user_office_id')}}" 
                      value="@if(isset($request->rlp_user_office_id)){{$request->rlp_user_office_id ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="priority" class="col-sm-3 col-form-label">{{__('label.priority')}}:</label>
                    <div class="col-sm-9">
                      <select class="form-control priority" name="priority"  >
                            <option value="">{{__('label.select')}} {{__('label.priority')}}</option>
                            @forelse(priorities() as $p_key=>$p_val)
                            <option value="{{$p_key}}" @if(isset($request->priority) && $p_key==$request->priority ) selected @endif >{{$p_val}}</option>
                            @empty
                            @endforelse
                          </select>
                    </div>
                  </div>
@php
$request_departments = \DB::select("SELECT DISTINCT t2.id,t2._department as _name FROM rlp_masters as t1 INNER JOIN hrm_departments as t2 ON t1.request_department=t2.id ORDER BY t2._department asc");
@endphp
                  <div class="form-group row">
                    <label for="request_department" class="col-sm-3 col-form-label">{{__('label.request_department')}}:</label>
                    <div class="col-sm-9">
                      <select id="request_department" class="form-control request_department" name="request_department"  >
                            <option value="">{{__('label.select')}} {{__('label.request_department')}}</option>
                            @forelse($request_departments as $key=>$val)
                            <option value="{{$val->id}}" @if(isset($request->request_department) && $val->id==$request->request_department ) selected @endif >{!! $val->_name ?? '' !!}</option>
                            @empty
                            @endforelse
                          </select>
                    </div>
                  </div>
@php
$users = \Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
@endphp 

<div class="form-group row">
    <label for="organization_id" class="col-sm-3 col-form-label">{!! __('label.organization') !!}:</label>
    <div class="col-sm-9">
      <select id="organization_id" class="form-control _master_organization_id" name="organization_id"  >
    <option value="">{{__('label.select_organization')}}</option>
     @forelse($permited_organizations as $val )
     <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
     @empty
     @endforelse
   </select>
    </div>
</div>
<div class="form-group row">
    <label for="_master_branch_id" class="col-sm-3 col-form-label">{!! __('label.Branch') !!}:</label>
    <div class="col-sm-9">
      <select class="form-control _master_branch_id" name="_branch_id"  >
          <option value="">{{__('label.select_branch')}}</option>
          @forelse($permited_branch as $branch )
          <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
          @empty
          @endforelse
        </select>
    </div>
</div>
<div class="form-group row">
    <label  class="col-sm-3 col-form-label">{{__('label.Cost center')}}:</label>
    <div class="col-sm-9">
      <select class="form-control _cost_center_id" name="_cost_center_id"  >
        <option value="">{{__('label.select_cost_center')}}</option>
          @forelse($permited_costcenters as $cost_center )
          <option value="{{$cost_center->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
          @empty
          @endforelse
        </select>
    </div>
</div>


                  
                  
                  <div class="form-group row">
                    <label for="rlp_status" class="col-sm-3 col-form-label">Approval Status:</label>
                    <div class="col-sm-9">
                      
                       <select id="rlp_status" class="form-control" name="rlp_status" >
                        <option value="">Select</option>
                            @foreach($status_details AS $key=>$val)
                            <option value="{{$val->id}}" @if(isset($request->rlp_status)) @if($key==$request->rlp_status) selected @endif @endif >{!! $val->name ?? '' !!}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="_lock" class="col-sm-3 col-form-label">Lock:</label>
                    <div class="col-sm-9">
                      @php
                    $_locks = [ '0'=>'Open', '1'=>'Locked'];
                      @endphp
                       <select id="_lock" class="form-control" name="_lock" >
                        <option value="">Select</option>
                            @foreach($_locks AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->_lock)) @if($key==$request->_lock) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>
                  

                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Order By:</label>
                    <div class="col-sm-9">
                      @php
             $cloumns = [ 'id'=>'ID','request_date'=>'Date','organization_id'=>__('label.organization_id'),'_branch_id'=>__('label._branch_id'),'_cost_center_id'=>__('label._cost_center_id'),'rlp_no'=>__('label.rlp_no'),'rlp_status'=>__('label._status'),];

                      @endphp
                       <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->asc_cloumn)) @if($key==$request->asc_cloumn) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Sort Order:</label>
                    <div class="col-sm-9">
                       <select class=" form-control" name="_asc_desc">
                        @foreach(asc_desc() AS $key=>$val)
                            <option value="{{$val}}" @if(isset($request->_asc_desc)) @if($val==$request->_asc_desc) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div> 
                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Limit:</label>
                    <div class="col-sm-9">
                     <select name="limit" class="form-control" >
                              @forelse($row_numbers as $row)
                               <option  @if($limit == $row) selected @endif   value="{{ $row }}">{{$row}}</option>
                              @empty
                              @endforelse
                      </select>
                    </div>
                  </div>
                         

                             
                          
                       
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-2"></i> Search</button>
                </div>
              </div>
            </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                  <form action="" method="GET">
                    @csrf

                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                                
                                <select name="limit" class="form-control" onchange="this.form.submit()">
                                        @forelse($row_numbers as $row)
                                         <option  @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
                                        @empty
                                        @endforelse
                                </select>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-group ">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('rlp-reset')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>