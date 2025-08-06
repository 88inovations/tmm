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
                    <label for="inputEmail3" class="col-sm-2 col-form-label">{{__('label._category_id')}}:</label>
                    <div class="col-sm-10 ">
                      <select class="form-control  _category_id" name="_category_id">
                        <option value="">---Select---    </option>
                        @forelse($categories as $category )
                        <option value="{{$category->id}}" @if(isset($request->_category_id)) @if($request->_category_id == $category->id) selected @endif   @endif>{{ $category->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" name="id" class="form-control _main_item_id" placeholder="Exp:1,2,3,4" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Item:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_item" class="form-control _search_main_item_id" placeholder="Search By Item" value="@if(isset($request->_item)) {{$request->_item ?? ''}}  @endif">
                      <div class="search_box_main_item"></div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_unit_id" class="col-sm-2 col-form-label">Unit:</label>
                    <div class="col-sm-10">
                      <select class="form-control _unit_id" id="_unit_id" name="_unit_id" >
                                  <option value="" >--Units--</option>
                                  @foreach($units as $unit)
                                   <option value="{{$unit->id}}" @if(isset($request->_unit_id)) @if($request->_unit_id==$unit->id) selected @endif @endif >{{$unit->_name ?? ''}}</option>
                                  @endforeach
                                </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="_code" class="col-sm-2 col-form-label">Code:</label>
                    <div class="col-sm-10">
                      <input type="text" name="_code" class="form-control" placeholder="Search By Code" value="@if(isset($request->_code)) {{$request->_code ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="_barcode" class="col-sm-2 col-form-label">Model:</label>
                    <div class="col-sm-10">
                       <input type="text" name="_barcode" class="form-control" placeholder="Search By Model" value="@if(isset($request->_barcode)) {{$request->_barcode ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_discount " class="col-sm-2 col-form-label">Discount :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_discount" name="_discount" class="form-control" placeholder="Search By Discount" value="@if(isset($request->_discount)) {{$request->_discount  ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_vat " class="col-sm-2 col-form-label">Vat :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_vat" name="_vat" class="form-control" placeholder="Search By Vat Rate" value="@if(isset($request->_vat)) {{$request->_vat  ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_pur_rate " class="col-sm-2 col-form-label">Purchase Rate :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_pur_rate" name="_pur_rate" class="form-control" placeholder="Search By Purchase Rate" value="@if(isset($request->_pur_rate)) {{$request->_pur_rate  ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_sale_rate " class="col-sm-2 col-form-label">Sales Rate :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_sale_rate" name="_sale_rate" class="form-control" placeholder="Search By Sales Rate" value="@if(isset($request->_sale_rate)) {{$request->_sale_rate  ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="_manufacture_company   " class="col-sm-2 col-form-label">Manufacture Company  :</label>
                    <div class="col-sm-10">
                       <input type="text" id="_manufacture_company" name="_manufacture_company" class="form-control" placeholder="Search By Purchase Rate" value="@if(isset($request->_manufacture_company)) {{$request->_manufacture_company ?? ''}}  @endif">
                    </div>
                  </div>

                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Order By:</label>
                    <div class="col-sm-10">
                      @php
                        $cloumns = [ 'id'=>'ID','_item'=>'Item','_code'=>'Code','_barcode'=>'Barcode','_category_id'=>'Category Id','_discount'=>'Discount', '_vat'=>'Vat','_pur_rate'=>'Purchase Rate','_sale_rate'=>'Sales Rate','_manufacture_company'=>'Manufacture Company','_serial'=>'Serial'];

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
                               <option @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
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
                                    <button type="button" class="btn btn-sm btn-warning mr-3 " data-toggle="modal" data-target="#exampleModalFile" title="Product excel file Upload"><i class="fa fa-upload mr-2"></i> </button>


                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                     <a href="{{url('item-information-reset')}}" class="btn btn-sm btn-danger" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
                                     </div>
                                </div>
                          </div>
                          
                        </div><!-- end row -->
                   
                  </form>
                </div>


  <div class="modal fade" id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="{{url('cylinder_upload')}}" method="post" enctype='multipart/form-data'>
         @csrf
         <input type="file" name="file" class="form-control">
         <br/>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary">Upload</button>
       </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>