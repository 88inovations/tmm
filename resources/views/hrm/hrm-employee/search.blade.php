<div  >

  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="" method="GET" class="form-horizontal">
            @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h1>{{$page_name ?? '' }} {{__('label.search')}}</h1>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 @php 
                        $row_numbers = filter_page_numbers();
                         
                        @endphp
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label.Limit')}}:</label>
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
                    <label  class="col-sm-2 col-form-label">{{__('label.employee_category_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _category_id" name="_category_id">
                        <option value="">{{__('label.select')}}</option>
                        @forelse($employee_catogories as $val )
                        <option value="{{$val->id}}" @if(isset($request->_category_id)) @if($request->_category_id == $val->id) selected @endif   @endif>{{ $val->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._department_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_department_id">
                          <option value="">{{__('label.select')}}</option>
                          @forelse($departments as $val )
                          <option value="{{$val->id}}" @if(isset($request->_department_id)) @if($request->_department_id == $val->id) selected @endif   @endif>{{ $val->_department ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._jobtitle_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_jobtitle_id">
                          <option value="">{{__('label.select')}}</option>
                          @forelse($designations as $val )
                          <option value="{{$val->id}}" @if(isset($request->_jobtitle_id) && $request->_jobtitle_id == $val->id)  selected  @endif>{{ $val->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._grade_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _account_groups" name="_grade_id">
                          <option value="">{{__('label.select')}}</option>
                          @forelse($grades as $val )
                          <option value="{{$val->id}}" @if(isset($request->_grade_id) && $request->_grade_id == $val->id)  selected  @endif>{{ $val->_grade ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label.id')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" name="id" class="form-control" placeholder="Exp:1,2,3,4" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_name" class="form-control" placeholder="{{__('label._name')}}" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._code')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_code" class="form-control" placeholder="{{__('label._code')}}" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._phone')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_mobile1" class="form-control" placeholder="{{__('label._phone')}}" value="@if(isset($request->_mobile1)) {{$request->_mobile1 ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._email')}}:</label>
                    <div class="col-sm-10">
                       <input type="text" name="_email" class="form-control" placeholder="{{__('label._email')}}" value="@if(isset($request->_email)) {{$request->_email ?? ''}}  @endif">
                    </div>
                  </div>

                  
                  <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">{{__('label._order_by')}}:</label>
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
                    <label  class="col-sm-2 col-form-label">{{__('label.short_order')}}:</label>
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
                  <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('label._close')}}</button>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-2"></i> {{__('label.search')}}</button>
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
                                     <a href="{{url('hrm-employee')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div>