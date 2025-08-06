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
                    <label for="_date" class="col-sm-2 col-form-label">Date:</label>
                    <div class="col-sm-10">
                      <div class="row">
                         <div class="col-sm-2">Use Date: 
                          <select class="form-control" name="_user_date">
                            <option value="no" @if(isset($request->_user_date)) @if($request->_user_date=='no') selected @endif  @endif>No</option>
                            <option value="yes" @if(isset($request->_user_date)) @if($request->_user_date=='yes') selected @endif  @endif>Yes</option>
                          </select>

                         </div>
                        <div class="col-sm-5">From: 
                          
                          <div class="input-group date" id="reservationdate_datex" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input_datex" data-target="#reservationdate_datex" value="@if(isset($request->_datex)){{$request->_datex ?? ''}}@endif" />
                                      <div class="input-group-append" data-target="#reservationdate_datex" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                        </div>
                        <div class="col-sm-5">To: 
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
                    <label for="id" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Search By Id" 
                      value="@if(isset($request->id)){{$request->id ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_order_number" class="col-sm-2 col-form-label">Invoice No:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_order_number" name="_order_number" class="form-control" placeholder="Search By Invoice No" 
                      value="@if(isset($request->_order_number)){{$request->_order_number ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_order_ref_id" class="col-sm-2 col-form-label">{{__('label.issue_number')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_order_ref_id" name="_order_ref_id" class="form-control" placeholder="{{__('label.issue_number')}}" 
                      value="@if(isset($request->_order_ref_id)){{$request->_order_ref_id ?? ''}}@endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_ledger_id " class="col-sm-2 col-form-label">{{__('label._ledger_id')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="@if(isset($request->_search_main_ledger_id)) {{$request->_search_main_ledger_id ?? ''}}  @endif" placeholder="{{__('label._ledger_id')}}" >
                            <input type="hidden" id="_ledger_id" name="_ledger_id" class="form-control _ledger_id" value="@if(isset($request->_ledger_id)){{$request->_ledger_id ?? ''}}@endif" placeholder="{{__('label._ledger_id')}}" required>
                            <div class="search_box_main_ledger"> </div>
                    </div>
                  </div>
                 
 <div class="form-group row">
  <div class="col-xs-2 col-sm-2 col-md-2 ">
     <label for="_master_organization_id " class=" col-form-label">{!! __('label.organization') !!}:</label>
   </div>
      <div class="col-xs-10 col-sm-10 col-md-10 ">
    <select class="form-control _master_organization_id" name="organization_id"  >

       <option value="">{{__('label.select_organization')}}</option>
       @forelse($permited_organizations as $val )
       <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
       @empty
       @endforelse
     </select>
   </div>
 </div>

                  <div class="form-group row">
                    <label for="_branch_id " class="col-sm-2 col-form-label">{{__('label._branch_id')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_branch_id"  >
                                  <option value="">{!! __('label.select') !!}</option>
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_cost_center_id" class="col-sm-2 col-form-label">{{__('label._cost_center_id')}}:</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="_cost_center_id">
                        <option value="">{{__('label.select_cost_center')}}</option>
                      @forelse($permited_costcenters as $cost)
                         <option value="{{$cost->id}}" @if(isset($request->_cost_center_id)) @if($cost["id"]==$request->_cost_center_id) selected @endif @endif>{{$cost->_name}}</option>
                      @empty
                      @endforelse
                      </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="_referance" class="col-sm-2 col-form-label">Referance:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_referance" name="_referance" class="form-control" placeholder="Search By Referance" value="@if(isset($request->_referance)){{$request->_referance ?? ''}}@endif">
                    </div>
                  </div>
                  
                  
                  
                  
                  <div class="form-group row">
                    <label for="_user_name" class="col-sm-2 col-form-label">User:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_user_name" name="_user_name" class="form-control" placeholder="Search By User" value="@if(isset($request->_user_name)){{$request->_user_name ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_lock" class="col-sm-2 col-form-label">Lock:</label>
                    <div class="col-sm-10">
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
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_user_name'=>'User name','_order_number'=>'Order Number','_branch_id '=>'Branch','_ledger_id'=>'Ledger','_cost_center_id'=>'Cost Center'];

                      @endphp
                       <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->asc_cloumn)) @if($key==$request->asc_cloumn) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sort Order:</label>
                    <div class="col-sm-10">
                       <select class=" form-control" name="_asc_desc">
                        @foreach(asc_desc() AS $key=>$val)
                            <option value="{{$val}}" @if(isset($request->_asc_desc)) @if($val==$request->_asc_desc) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div> 
                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Limit:</label>
                    <div class="col-sm-10">
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
                                     <a href="{{url('material-issue-return')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>