<div>
                  <form action="" method="GET">
                    @csrf
                     @php 
                        $row_numbers = [10,20,30,40,50,100,200,300,400,500,600,1000,2000,100000,200000,500000];
                        @endphp
                        <div class="row">
                          <div class="col-md-2">
                            <select name="limit" class="form-control">
                                    @forelse($row_numbers as $row)
                                     <option @if(isset($request->limit)) @if($request->limit == $row) selected @endif  @endif value="{{ $row }}">{{$row}}</option>
                                    @empty
                                    @endforelse
                            </select>
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="_name" class="form-control" placeholder="Search By Name" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="_code" class="form-control" placeholder="Code" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                          </div>
                          <!-- Status Filter -->
            <div class="col-md-2">
                <div class="form-group">
                    
                    <select name="_status" id="_status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="1" {{ request('_status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('_status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
             @php
$order_cloumns = ['id'=>'ID','_name'=>'Name','_code'=>'CODE', 'status'=>'Status', 'created_at'=>'Created at', 'updated_at'=>'Updated At'];

$_order_cloumn = $request->_order_cloumn ?? 'id';
$limit = $request->limit ?? 10;
$_asc_des = $request->_asc_des ?? 'DESC';


            @endphp


            <div class="col-md-2">
                
                <select name="_order_cloumn" class="form-control">
                   <option value="">Order Cloumn</option>
                   @forelse($order_cloumns  as $c_key=>$c_name)
                    <option value="{{$c_key}}" @if($c_key==$_order_cloumn) selected @endif >{{$c_name ?? '' }}</option>
                   @empty
                   @endforelse
                </select>
            </div>
            <div class="col-md-2">
               
                <select name="_asc_des" class="form-control">
                   <option value="">Order By</option>
                    <option value="DESC" @if($_asc_des=='DESC') selected @endif >DESC</option>
                    <option value="ASC" @if($_asc_des=='ASC') selected @endif >ASC</option>
                  
                </select>
            </div>
                          
                          
                          
                          <div class="col-md-2">
                              <button class=" btn btn-info" type="submit"><i class="fa fa-search "></i> Search</button>
                          </div>
                          <div class="col-md-2">
                      <div class="d-flex flex-row justify-content-end">
                         
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               <div class="dropdown-divider"></div>
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             
                        
                          </div>
                    </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>