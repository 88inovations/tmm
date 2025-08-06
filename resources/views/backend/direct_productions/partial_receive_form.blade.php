@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container">
          <div class="card">
            <div class="card-header">
              <h4 class="text-center">{{ $page_name ?? '' }}</h4>
                 @include('backend.message.message')
            </div>
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('finished_goods_receive_to_stock')}}" method="GET">
                @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <label>{{__('label.unlock_productions')}}:</label>
                        <select id="production_id" class="form-control production_id select2" name="production_id" required>
                          <option value="">---Select---</option>
                          @forelse($unlock_productions as $val)
                          <option value="{{$val->id}}"  >{{ $val->_order_number ?? '' }} || {{ _view_date_formate($val->_date ?? '') }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>

                    </div>
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Submit</button>
                        </div>
                         
                        <br><br>
                     </div>
                   </form>
                
              </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



@endsection



