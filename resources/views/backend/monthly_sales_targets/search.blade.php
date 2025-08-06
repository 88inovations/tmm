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
                    <label for="_branch_id " class="col-sm-2 col-form-label">Branch:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_branch_id"  >
                                  <option value=""><--- Select {{__('label._branch_id')}} ---></option>
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="_cost_center_id" class="col-sm-2 col-form-label">Cost Center:</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="_cost_center_id">
                        <option value="">Select Cost Center</option>
                      @forelse($permited_costcenters as $cost)
                         <option value="{{$cost->id}}" @if(isset($request->_cost_center_id)) @if($cost["id"]==$request->_cost_center_id) selected @endif @endif>{{$cost->_name}}</option>
                      @empty
                      @endforelse
                      </select>
                    </div>
                  </div>

                 
                   <div class="form-group row">
                    <label for="_ledger_id" class="col-sm-2 col-form-label">{{__('label._ledger_id')}}:</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" name="_ledger_id">
                        <option value="">Select Ledger</option>
                      @forelse($ledgers_accounts as $ledger)
                         <option value="{{$ledger->id}}" @if(isset($request->_ledger_id)) @if($ledger->id==$request->_ledger_id) selected @endif @endif>{{$ledger->_code ?? ''}} | {{$ledger->_name ?? ''}}</option>
                      @empty
                      @endforelse
                      </select>
                    </div>
                  </div>

                 
                  
                  

                
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date'];

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
                         
                          <div class="col-md-8">
                              <div class="form-group " style="display:flex;">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                    @if($_group==2)
                                     <a href="{{url('customer_sales_target_list')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     @endif
                                    @if($_group==1)
                                     <a href="{{route('monthly_sales_targets.index')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     @endif
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>