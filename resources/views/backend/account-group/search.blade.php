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
                         
                  @endphp
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Limit:</label>
                    <div class="col-sm-10">
                     <select name="limit" class="form-control" >
                              @forelse($row_numbers as $row)
                               <option  @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
                              @empty
                              @endforelse
                      </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="EXP:1,2,3,4,5" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_name" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_name" name="_name" class="form-control" placeholder="Search By Name" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">Code:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_code" name="_code" class="form-control" placeholder="Search By Code" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_short" class="col-sm-2 col-form-label">Possition:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_short" name="_short" class="form-control" placeholder="Search By Possition" value="@if(isset($request->_short)) {{$request->_short ?? ''}}  @endif">
                    </div>
                  </div>
                  @php
$_account_head_id = $request->_account_head_id ?? '';
                  @endphp

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Account Type :</label>
                    <div class="col-sm-10">
                       <select class=" form-control" name="_account_head_id">
                        
                                  <option value="">--Select--</option>
                                  @forelse($account_types as $account_type )


                                  <option value="{{$account_type->id}}"  @if($_account_head_id == $account_type->id) selected @endif  >{{ $account_type->_code ?? '' }}-{{ $account_type->_name ?? '' }}</option>

                                  @php
                                  $_child_groups = $account_type->_child_group ?? [];
                                  @endphp
                                  @forelse($_child_groups as $group)
                                        <option value="{{$group->id}}"  @if($_account_head_id == $group->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;{{ $group->_code ?? '' }}-{{ $group->_name ?? '' }}</option>

                                        @php
                                        $third_child_group=$group->_child_group ?? [];
                                        @endphp

                                         @forelse($third_child_group as $third_child_val)

 <option value="{{$third_child_val->id}}"  @if($_account_head_id == $third_child_val->id) selected @endif   > &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;{{ $third_child_val->_code ?? '' }}-{{ $third_child_val->_name ?? '' }}</option>
                                         @empty
                                         @endforelse



                                  @empty
                                  @endforelse

                                  @empty
                                  @endforelse
                                </select>

                    </div>
                  </div>  


                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
                      $cloumns = [ 'id'=>'ID','_name'=>'Name','_code'=>'Code','_account_head_id'=>'Account Type','_short'=>'Possition'];

                      @endphp
                       <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->asc_cloumn)) @if($key==$request->asc_cloumn) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sort :</label>
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
                                         <option @if($limit)) @if($limit == $row) selected @endif  @endif value="{{ $row }}">{{$row}}</option>
                                        @empty
                                        @endforelse
                                </select>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-group mt-1">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('account-group-reset')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>