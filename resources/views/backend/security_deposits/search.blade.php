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
                    <label for="id" class="col-sm-2 col-form-label">{{__('label.id')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="id" name="id" class="form-control" placeholder="Id" 
                      value="@if(isset($request->id)){{$request->id ?? ''}}@endif">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="_order_number" class="col-sm-2 col-form-label">{{__('label._order_number')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_order_number" name="_order_number" class="form-control" placeholder="Invoice No/Scan Barcode" value="@if(isset($request->_order_number)){{$request->_order_number ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_branch_id " class="col-sm-2 col-form-label">{{__('label._branch_id')}}:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="_branch_id" required >
                                  
                            @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_ledger_id " class="col-sm-2 col-form-label">{{__('label._ledger_id')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="@if(isset($request->_search_main_ledger_id)) {{$request->_search_main_ledger_id ?? ''}}  @endif" placeholder="{{__('label._ledger_id')}}" >

                            <input type="hidden" id="_ledger_id" name="_ledger_id" class="form-control _ledger_id" value="@if(isset($request->_ledger_id)){{$request->_ledger_id ?? ''}}@endif" placeholder="{{__('label._ledger_id')}}" required>
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
                    <label for="_referance" class="col-sm-2 col-form-label">{{__('label._type')}}:</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="_type" >
                                <option value=""><--Select--></option>
                                <option value="Receive" @if(isset($request->_type) && $request->_type=='Receive') selected @endif >Receive</option>
                                <option value="Return" @if(isset($request->_type) && $request->_type=='Return') selected @endif >Return</option>
                              </select>
                    </div>
                  </div>
                   
                  <div class="form-group row">
                    <label for="_voucher_no" class="col-sm-2 col-form-label">{{__('label._voucher_no')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_voucher_no" name="_voucher_no" class="form-control" placeholder="{{__('label._voucher_no')}}" value="@if(isset($request->_voucher_no)){{$request->_voucher_no ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_bank_name" class="col-sm-2 col-form-label">{{__('label._bank_name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_bank_name" name="_bank_name" class="form-control" placeholder="{{__('label._bank_name')}}" value="@if(isset($request->_bank_name)){{$request->_bank_name ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_bank_branch_name" class="col-sm-2 col-form-label">{{__('label._bank_branch_name')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_bank_branch_name" name="_bank_branch_name" class="form-control" placeholder="{{__('label._bank_branch_name')}}" value="@if(isset($request->_bank_branch_name)){{$request->_bank_branch_name ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_cheque_no" class="col-sm-2 col-form-label">{{__('label._cheque_no')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_cheque_no" name="_cheque_no" class="form-control" placeholder="{{__('label._cheque_no')}}" value="@if(isset($request->_cheque_no)){{$request->_cheque_no ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_cheque_date" class="col-sm-2 col-form-label">{{__('label._cheque_date')}}:</label>
                    <div class="col-sm-10">
                      <input type="date" id="_cheque_date" name="_cheque_date" class="form-control" placeholder="{{__('label._cheque_date')}}" value="@if(isset($request->_cheque_date)){{$request->_cheque_date ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_amount" class="col-sm-2 col-form-label">{{__('label._amount')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_amount" name="_amount" class="form-control" placeholder="{{__('label._amount')}}" value="@if(isset($request->_amount)){{$request->_amount ?? ''}}@endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_remarks" class="col-sm-2 col-form-label">{{__('label._remarks')}}:</label>
                    <div class="col-sm-10">
                      <input type="text" id="_remarks" name="_remarks" class="form-control" placeholder="{{__('label._remarks')}}" value="@if(isset($request->_remarks)){{$request->_remarks ?? ''}}@endif">
                    </div>
                  </div>
                  
                  
                  <div class="form-group row">
                    <label for="_lock" class="col-sm-2 col-form-label">Lock:</label>
                    <div class="col-sm-10">
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
             $cloumns = [ 'id'=>'ID','_date'=>'Date','_user_name'=>'User name','_order_number'=>'Order Number','_order_ref_id'=>'Order Refarance','_referance'=>'Referance','_note'=>'Note', '_branch_id '=>'Branch','_ledger_id'=>'Ledger','_amount'=>'Amount','_type'=>"Type"];

            

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
                          <div class="col-md-12 d-flex">
                            <div class="form-group">
                                <a class="m-0 _page_name" href="{{ route('security_deposits.index') }}">{!! $page_name ?? '' !!} </a>
                              </div>
                            <div class="form-group ml-2">
                                @can('security_deposits-create')
                             
                                    <a title="Add New" class="btn btn-info btn-sm mr-1" href="{{ route('security_deposits.create') }}"><i class="nav-icon fas fa-plus"></i> Create New </a>
                                  @endcan
                              </div>
                            
                          
                              <div class="form-group ml-2">
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('security_deposits')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                              </div>

                              


                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>