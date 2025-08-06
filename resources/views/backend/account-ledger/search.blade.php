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
                        $_branch_id = $request->_branch_id ?? '';
                         
                        @endphp
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
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Account Type:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_head_id" name="_account_head_id">
                        <option value="">Type</option>
                        @forelse($account_types as $account_type )
                        <option value="{{$account_type->id}}" @if(isset($request->_account_head_id)) @if($request->_account_head_id == $account_type->id) selected @endif   @endif>{{ $account_type->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Account Group:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_account_group_id">
                          <option value="">Group</option>
                          @forelse($account_groups as $account_group )
                          <option value="{{$account_group->id}}" @if(isset($request->_account_group_id)) @if($request->_account_group_id == $account_group->id) selected @endif   @endif>{{ $account_group->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{__('label._branch_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _branch_id" name="_branch_id">
                          <option value="">{{__('label._branch_id')}}</option>
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" name="id" class="form-control" placeholder="Exp:1,2,3,4" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">Code:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_code" class="form-control" placeholder="Search By Code" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_name" class="form-control" placeholder="Search By Name" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Phone:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_phone" class="form-control" placeholder="Search By Phone" value="@if(isset($request->_phone)) {{$request->_phone ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                       <input type="text" name="_email" class="form-control" placeholder="Search By Email" value="@if(isset($request->_email)) {{$request->_email ?? ''}}  @endif">
                    </div>
                  </div>

                  
                  <div class="form-group row">
                    <label for="_status" class="col-sm-2 col-form-label">{{__('label._status')}}:</label>
                    <div class="col-sm-10">
                      @php
                      $_status = $request->_status ?? 1;
                      @endphp
                       <select class="form-control" name="_status" >
                            
                            <option value="">Select Status</option>
                             <option value="1" @if($_status==1) selected @endif >Active</option>
                              <option value="0" @if($_status==0) selected @endif >In Active</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
                        $cloumns = [ 'id'=>'ID','_account_group_id'=>'Account Group','_account_head_id'=>'Account Head','_name'=>'Name','_code'=>'Code','_nid'=>'NID', '_email'=>'Email','_phone'=>'Phone'];

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
                                     <a href="{{url('account-ledger-reset')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div>