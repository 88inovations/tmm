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
                    <label for="id" class="col-sm-3 col-form-label">ID:</label>
                    <div class="col-sm-9">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Search By Id" 
                      value="@if(isset($request->id)){{$request->id ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_from_branch " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_from_branch" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_from_branch)) @if($request->_from_branch == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_from_cost_center " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_from_cost_center" required >
                                  
                                  @forelse($permited_costcenters as $_cost_center )
                                  <option value="{{$_cost_center->id}}" @if(isset($request->_from_cost_center)) @if($request->_from_cost_center == $_cost_center->id) selected @endif   @endif>{{ $_cost_center->id ?? '' }} - {{ $_cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_to_branch " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_to_branch" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_to_branch)) @if($request->_to_branch == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_to_cost_center " class="col-sm-3 col-form-label">From Branch:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="_to_cost_center" required >
                                  
                                  @forelse($permited_costcenters as $_cost_center )
                                  <option value="{{$_cost_center->id}}" @if(isset($request->_to_cost_center)) @if($request->_to_cost_center == $_cost_center->id) selected @endif   @endif>{{ $_cost_center->id ?? '' }} - {{ $_cost_center->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_date" class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
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
                    <label for="_reference" class="col-sm-3 col-form-label">Reference:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_reference" name="_reference" class="form-control" placeholder="Search By Reference" value="@if(isset($request->_reference)){{$request->_reference ?? ''}}@endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_note" class="col-sm-3 col-form-label">Note:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_note" name="_note" class="form-control" placeholder="Search By Note" value="@if(isset($request->_note)){{$request->_note ?? ''}}@endif">
                    </div>
                  </div>
                  

                  <div class="form-group row">
                    <label for="_total" class="col-sm-3 col-form-label">Stock Out Total:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_total" name="_total" class="form-control" placeholder="Stock Out Total" value="@if(isset($request->_total)){{$request->_total ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_stock_in__total" class="col-sm-3 col-form-label">Stock In Amount:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_stock_in__total" name="_stock_in__total" class="form-control" placeholder="Search By Stock In Amount" value="@if(isset($request->_stock_in__total)){{$request->_stock_in__total ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_created_by" class="col-sm-3 col-form-label">Created By:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_created_by" name="_created_by" class="form-control" placeholder="Search  Created By" value="@if(isset($request->_created_by)){{$request->_created_by ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_updated_by" class="col-sm-3 col-form-label">Updated By:</label>
                    <div class="col-sm-9">
                      <input type="text" id="_updated_by" name="_updated_by" class="form-control" placeholder="Search Updated By " value="@if(isset($request->_updated_by)){{$request->_updated_by ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_p_status" class="col-sm-3 col-form-label">Status:</label>
                    <div class="col-sm-9">
                      @php
                      $_p_statuss = [ '1'=>'Transit', '2'=>'Work-in-progress', '3'=>'Complete'];
                      @endphp
                       <select id="_p_status" class="form-control" name="_p_status" >
                        <option value="">Select</option>
                            @foreach($_p_statuss AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->_p_status)) @if($key==$request->_p_status) selected @endif @endif >{{$val}}</option>
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

                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Order By:</label>
                    <div class="col-sm-9">
                      @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_from_cost_center'=>'From cost center','_from_branch'=>'From Branch','_to_cost_center'=>'To Cost Center','_to_branch'=>'To branch','_reference'=>'Reference', '_note '=>'Note','_type'=>'Type','_total'=>'Stock Out Total','_stock_in__total'=>'Stock In Total','_p_status'=>'Status','_lock'=>'Lock'];

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
                                     <a href="{{url('transfer-production-reset')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>