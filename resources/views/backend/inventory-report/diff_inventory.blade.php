@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <div class="content ">
      <div class="container">
          <div class="card">
         
            <div class="card-body filter_body" >
               <form  action="" method="GET">
                @csrf
                    <div class="row">
                      

                     

                      <div class="col-md-12">
                        <label>Data Type:</label>
                        <select id="only_diff" class="form-control only_diff " name="only_diff" >
                          <option value="0" @if(isset($request->only_diff) && $request->only_diff==0) selected @endif >ALL</option>
                          <option value="1" @if(isset($request->only_diff) && $request->only_diff==1) selected @endif >Only Diff</option>
                         </select>
                      </div>

                      

                    </div>
                    
                    
                    
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
        <!-- /.row -->
      </div>
    </div>  

    <div class="container">
      <table class="table">
        <thead>
          <tr>
            <th>SL</th>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Item Inventory Qty</th>
            <th>Product Price QTY</th>
            <th>Diff</th>
          </tr>
        </thead>
        <tbody>
          @forelse($results as $key=>$val)
          @php
          $diff=( $val->_qty-$val->_p_qty);
          @endphp
          <tr class="@if($diff !=0) _required @endif">
            <td>{{($key+1)}}</td>
            <td>{!! $val->_item_id ?? '' !!}</td>
            <td>{!! $val->_item ?? '' !!}</td>
            <td>{!! $val->_qty ?? '' !!}</td>
            <td>{!! $val->_p_qty ?? '' !!}</td>
            <td>{!! ( $val->_qty-$val->_p_qty) !!}</td>
          </tr>
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
</div>



@endsection



