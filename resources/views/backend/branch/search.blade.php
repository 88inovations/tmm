<div  >
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
                            <input type="text" name="_address" class="form-control" placeholder="Address" value="@if(isset($request->_address)) {{$request->_address ?? ''}}  @endif">
                          </div>
                          
                          <div class="col-md-2">
                            <input type="text" name="_email" class="form-control" placeholder="Email" value="@if(isset($request->_email)) {{$request->_email ?? ''}}  @endif">
                          </div>
                          <div class="col-md-2">
                            <input type="text" name="_phone" class="form-control" placeholder="Phone" value="@if(isset($request->_phone)) {{$request->_phone ?? ''}}  @endif">
                          </div>
                          
                          <div class="col-md-2">
                              <button class="form-control btn btn-warning" type="submit">Search</button>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>