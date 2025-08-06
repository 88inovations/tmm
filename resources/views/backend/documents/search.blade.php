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
                               <option @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
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
                    <label for="_master_organization_id" class="col-sm-2 col-form-label">{!! __('label.organization') !!}:</label>
                    <div class="col-sm-10">
                      <select class="form-control _master_organization_id" name="organization_id" required >
                       @forelse($permited_organizations as $val )
                       <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                       @empty
                       @endforelse
                     </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_branch_id" class="col-sm-2 col-form-label">{!! __('label._branch_id') !!}:</label>
                    <div class="col-sm-10">
                      <select class="form-control _master_branch_id" name="_branch_id" required >
                   
                   @forelse($permited_branch as $branch )
                   <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                   @empty
                   @endforelse
                 </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_cost_center_id" class="col-sm-2 col-form-label">{!! __('label._cost_center_id') !!}:</label>
                    <div class="col-sm-10">
                      <select class="form-control _cost_center_id" name="_cost_center_id" required >
       
                       @forelse($permited_costcenters as $cost_center )
                       <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                       @empty
                       @endforelse
                     </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{__('label.documents')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" name="documents" class="form-control"  value="@if(isset($request->documents)) {{$request->documents ?? ''}}  @endif">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
                        $cloumns = [ 'id'=>'ID','document_title'=>'Document Title','organization_id'=>__('label.organization_id'),'_branch_id'=>__('label._branch_id'),'_cost_center_id'=>__('label._cost_center_id'),'_status'=>__('label._status')];

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
                                     <a href="{{url('documents')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div>