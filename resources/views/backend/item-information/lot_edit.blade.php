@extends('backend.layouts.app')
@section('title',$page_name)

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name"> {{ $page_name ?? '' }} </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @can('item-information-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ url('lot-item-information') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
                
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
         @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               
                 <form action="{{ url('item-sales-price-update') }}" method="POST">
                    @csrf
                    <div class="row">
                       
                      
                       
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_item">Item:<span class="_required">*</span></label>
                                <input type="text" id="_item" name="_item" class="form-control" value="{{old('_item',$data->_item)}}" placeholder="Item" required>
                                <input type="hidden" name="id" value="{{$data->id}}">
                            </div>
                        </div>
                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_unit">Unit:<span class="_required">*</span></label>

                                <select class="form-control _unit_id " id="_unit_id" name="_unit_id" required>
                                  <option value="" >--Units--</option>
                                  @foreach($units as $unit)
                                   <option value="{{$unit->id}}" @if(isset($data->_unit_id)) @if($data->_unit_id==$unit->id) selected @endif @endif >{{$unit->_name ?? ''}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                       



                       
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Warranty: </label>
                               <select  class="form-control _warranty " name="_warranty" required>
                                  <option value="0">--Select Warranty--</option>
                                  @forelse($_warranties as $_warranty )
                                  <option value="{{$_warranty->id}}" @if(isset($data->_warranty)) @if($data->_warranty == $_warranty->id) selected @endif   @endif>{{ $_warranty->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                      
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_p_discount_input">Discount Rate:</label>
                                <input type="number" min="0" step="any" id="_p_discount_input" name="_p_discount_input" class="form-control" value="{{old('_p_discount_input',$data->_p_discount_input)}}" placeholder="Discount Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_p_vat">Vat Rate:</label>
                                <input type="number" min="0" step="any" id="_p_vat" name="_p_vat" class="form-control" value="{{old('_p_vat',$data->_p_vat)}}" placeholder="Vat Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_pur_rate">Purchase Rate:</label>
                                <input type="number" step="any" min="0" id="_pur_rate"  class="form-control" value="{{old('_pur_rate',$data->_pur_rate)}}" placeholder="Purchase Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_sales_rate">Sales Rate:</label>
                                <input type="number" min="0" step="any" id="_sales_rate" name="_sales_rate" class="form-control" value="{{old('_sales_rate',$data->_sales_rate)}}" placeholder="Sales Rate" >
                            </div>
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="_barcode">Model/Barcode:</label>
                                <input type="text" id="1__barcode" name="_barcode" class="form-control 1__barcode" value="{{old('_barcode',$data->_barcode)}}"   placeholder="Model" >
                            </div>
                            <script type="text/javascript">
                            $('#1__barcode').amsifySuggestags({
                            trimValue: true,
                            dashspaces: true,
                            showPlusAfter: 1,
                            });
                            </script>
                            </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="_qty">QTY:</label>
                                <input type="number" step="any" min="0" id="_qty" name="_qty" class="form-control" value="{{old('_qty',$data->_qty)}}" placeholder="QTY"  >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="_short_note">{{__('label._short_note')}}:</label>
                                <input type="text"  id="_short_note" name="_short_note" class="form-control" value="{{old('_short_note',$data->_short_note ?? '' )}}" placeholder="{{__('label._short_note')}}"  >
                            </div>
                        </div>
                       
                       
                         <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label for="_status">Status:</label>
                                <select class="form-control" name="_status" id="_status">
                                  <option  value="1" @if($data->_status==1) selected @endif >Active</option>
                                  <option  value="0" @if($data->_status==0) selected @endif >In Active</option>
                                </select>
                            </div>
                        </div>
                        
                        
                       <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    </div>
                    </form>
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>



@endsection

@section('script')
<script type="text/javascript">
     function _new_barcode_function(_item_row_count){
      $(document).find('#1__barcode').amsifySuggestags({
      trimValue: true,
      dashspaces: true,
      showPlusAfter: 1,
      });
  }
</script>
@endsection