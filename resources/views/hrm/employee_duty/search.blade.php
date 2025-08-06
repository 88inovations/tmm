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
                <div class="modal-body">
                 @php 
                        $row_numbers = filter_page_numbers();

                        $_employee_id = $request->_employee_id ?? '';
                        $_branch_id = $request->_branch_id ?? '';
                         
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
                    <label for="_branch_id " class="col-sm-2 col-form-label">{{__('label._branch_id')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_branch_id"  >
                                  <option value=""><--- Select {{__('label._branch_id')}} ---></option>
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}"@if($_branch_id == $branch->id) selected @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="_employee_id " class="col-sm-2 col-form-label">{{__('label._employee_id')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" name="_employee_id"  >
                                  <option value=""><--- Select {{__('label._employee_id')}} ---></option>
                                  @forelse($emmployees as $employee )
                                  <option value="{{$employee->id}}" @if($_employee_id == $employee->id) selected @endif   >{{ $employee->id ?? '' }} - {{ $employee->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>

                  

                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
                        $cloumns = [ 'id'=>'ID','_date'=>__('label._date')];

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
                               <option @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
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
                                         <option @if($limit == $row) selected @endif   value="{{ $row }}">{{$row}}</option>
                                        @empty
                                        @endforelse
                                </select>
                              </div>
                          </div>
                          
                          
                          <div class="col-md-8">
                              <div class="form-group mr-2">
                                <div class="d-flex">
                                   
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('employee_duty')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div>

