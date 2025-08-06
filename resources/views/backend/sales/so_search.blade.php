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
                    <label for="_branch_id " class="col-sm-2 col-form-label">{{__('label._branch_id')}}:</label>
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
                    <label for="_order_number" class="col-sm-2 col-form-label">Invoice No:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_order_number" name="_order_number" class="form-control" placeholder="Search By Invoice No" 
                      value="@if(isset($request->_order_number)){{$request->_order_number ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_payment_terms " class="col-sm-2 col-form-label">{{__('label._payment_terms')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_payment_terms"  >
                                  <option value=""><--- Select {{__('label._payment_terms')}} ---></option>
                                  @forelse($transection_terms as $tran_terms )
                                  <option value="{{$tran_terms->id}}" @if(isset($request->_payment_terms)) @if($request->_payment_terms == $tran_terms->id) selected @endif   @endif>{{ $tran_terms->id ?? '' }} - {{ $tran_terms->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_ledger_id " class="col-sm-2 col-form-label">Customer:</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="_ledger_id">
                        <option value="">Select Customer</option>
                        @forelse($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->_name ?? '' }} | {{$customer->_code ?? '' }} </option>
                        @empty
                        @endforelse
                      </select>
                           
                    </div>
                  </div>
                 
                  

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_order_number'=>'Order Number'];

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
                <div class="modal-footer justify-content-start">
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
                          
                          <div class="col-md-12">
                              <div class="form-group ">
                                
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> Advance Search</button>
                                     <a href="{{url('so_wise_due_invoice')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
                              </div>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>