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
                          <div class="col-md-8">
                            <input type="text" name="name" class="form-control" placeholder="Search By Name" value="@if(isset($request->name)) {{$request->name ?? ''}}  @endif">
                          </div>
                          
                          <div class="col-md-2">
                              <button class="form-control btn btn-warning" type="submit">Search</button>
                          </div>
                        </div><!-- end row -->
                   
                  </form>
                </div>