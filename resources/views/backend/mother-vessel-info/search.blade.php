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
                    <label for="filter_limit" class="col-sm-2 col-form-label">Limit:</label>
                    <div class="col-sm-10">
                     <select name="limit" class="form-control" id="filter_limit" >
                              @forelse($row_numbers as $row)
                               <option   value="{{ $row }}" @if($limit==$row) selected @endif >{{$row}} </option>
                              @empty
                              @endforelse
                      </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">{{__('label.id')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="{{__('label.id')}}" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_name" class="col-sm-2 col-form-label">{{__('label._name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_name" name="_name" class="form-control" placeholder="{{__('label._name')}}" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">{{__('label._code')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_code" name="_code" class="form-control" placeholder="{{__('label._code')}}" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">{{__('label._license_no')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_license_no" name="_license_no" class="form-control" placeholder="{{__('label._license_no')}}" value="@if(isset($request->_license_no)) {{$request->_license_no ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_country_name" class="col-sm-2 col-form-label">{{__('label._country_name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_country_name" name="_country_name" class="form-control" placeholder="{{__('label._country_name')}}" value="@if(isset($request->_country_name)) {{$request->_country_name ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_country_name" class="col-sm-2 col-form-label">{{__('label._type')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_type">
                          <option value="">{{__('label.select')}}</option>
                            @forelse(_vessel_types() as $key=>$val)
                            <option value="{{$key}}" @if( isset($request->_type) && $request->_type==$key) selected @endif>{{$val}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_route" class="col-sm-2 col-form-label">{{__('label._route')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_route" name="_route" class="form-control" placeholder="{{__('label._route')}}" value="@if(isset($request->_route)) {{$request->_route ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_owner_name" class="col-sm-2 col-form-label">{{__('label._owner_name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_owner_name" name="_owner_name" class="form-control" placeholder="{{__('label._owner_name')}}" value="@if(isset($request->_owner_name)) {{$request->_owner_name ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_contact_one" class="col-sm-2 col-form-label">{{__('label._contact_one')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_contact_one" name="_contact_one" class="form-control" placeholder="{{__('label._contact_one')}}" value="@if(isset($request->_contact_one)) {{$request->_contact_one ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_contact_two" class="col-sm-2 col-form-label">{{__('label._contact_two')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_contact_two" name="_contact_two" class="form-control" placeholder="{{__('label._contact_two')}}" value="@if(isset($request->_contact_two)) {{$request->_contact_two ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_contact_three" class="col-sm-2 col-form-label">{{__('label._contact_three')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_contact_three" name="_contact_three" class="form-control" placeholder="{{__('label._contact_three')}}" value="@if(isset($request->_contact_three)) {{$request->_contact_three ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_capacity" class="col-sm-2 col-form-label">{{__('label._capacity')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_capacity" name="_capacity" class="form-control" placeholder="{{__('label._capacity')}}" value="@if(isset($request->_capacity)) {{$request->_capacity ?? ''}}  @endif">
                    </div>
                  </div>


                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{__('label.order_by')}}:</label>
                    <div class="col-sm-10">
                      @php
                      $cloumns = [ 'id'=>__('label.id'),'_name'=>__('label._name'),'_code'=>__('label._code')];

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
                                         <option @if(isset($request->limit)) @if($request->limit == $row) selected @endif  @endif value="{{ $row }}">{{$row}}</option>
                                        @empty
                                        @endforelse
                                </select>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <div class="form-group mt-1">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('vessel-info')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>