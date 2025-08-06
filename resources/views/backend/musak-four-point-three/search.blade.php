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
                    <label for="id" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Search By Id" 
                      value="@if(isset($request->id)){{$request->id ?? ''}}@endif">
                    </div>
                  </div>
                
                  <div class="form-group row">
                    <label for="_ledger_id " class="col-sm-2 col-form-label">Item:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_search_main_item_id" class="form-control _search_main_item_id width_280_px" placeholder="Item" value="@if(isset($request->_search_main_item_id)) {{$request->_search_main_item_id ?? ''}}  @endif" >
                      <input type="hidden" name="_main_item_id" class="form-control _main_item_id width_200_px" value="@if(isset($request->_main_item_id)){{$request->_main_item_id ?? ''}}@endif">
                      <div class="search_box_main_item">
                        
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_ledger_id " class="col-sm-2 col-form-label">Responsible Person:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="@if(isset($request->_search_main_ledger_id)) {{$request->_search_main_ledger_id ?? ''}}  @endif" placeholder="Responsible Person" >

                            <input type="hidden" id="_ledger_id" name="_responsible_person" class="form-control _ledger_id" value="@if(isset($request->_ledger_id)){{$request->_ledger_id ?? ''}}@endif" placeholder="Responsible Person" >
                            <div class="search_box_main_ledger"> </div>
                    </div>
                  </div>
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
                    <label for="_user_name" class="col-sm-2 col-form-label">User:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_user_name" name="_user_name" class="form-control" placeholder="Search By User" value="@if(isset($request->_user_name)){{$request->_user_name ?? ''}}@endif">
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

                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_ledger_id'=>'Ledger','_item_id'=>'Item Name'];

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
                                     <a href="{{url('musak-four-point-three')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>