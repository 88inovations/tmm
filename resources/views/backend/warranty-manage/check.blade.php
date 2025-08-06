@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
@php
$__user =\Auth::user();
@endphp
<div class="content-header">
      <div class="container">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="warranty-check"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
            </ol>

          </div>
         


      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              
              <div class="card-body filter_body">
                <form action="{{url('warranty-check')}}" method="GET">
                  @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="_form_name" class="_form_name"  value="warranty_masters">
                            <div class="form-group">
                                  
                              <input required type="text" name="_barcode" class="form-control " placeholder="Barcode" value="{{$request->_barcode ?? '' }}" />
                                      
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          
                            <button type="submit" class="btn btn-success mt-2 ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Check</button>
                            <a href="{{url('warranty-check')}}" class="btn btn-danger mt-2  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Reset</a>
                           
                        </div>
                    </form>
                  </div>
              </div>
            </div>
            <!-- /.card -->

        </div>  
@if(sizeof($data) > 0)
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th>Item Information</th>
                  <th>Purchase Information</th>
                  <th>Sales Information</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  @forelse($data as $key=>$value)
                  <tr>
                    <td>
                     <p> Name: {{ $value->_item ?? '' }}</p>
                     <p> Barcode: {{ $value->_barcode ?? '' }}</p>
                     <p> Warranty: {{ $value->_name ?? '' }}</p>
                    </td>
                    <td>
                     <p> Invoice No: <a href="{{url('purchase/print')}}/{{$value->_master_id}}">{{ $value->_p_order_number ?? '' }}</a></p>
                     <p> Supplier: {{ _ledger_name($value->_p_ledger ?? '') }}</p>
                     <p> Date: {{ _view_date_formate($value->_p_date ?? '') }}</p>
                    </td>
                     <td>
                     <p> Invoice No: <a href="{{url('sales/print')}}/{{$value->_s_id}}">{{ $value->_order_number ?? '' }}</a></p>
                     <p> Customer: {{ _ledger_name($value->_s_ledger ?? '') }}</p>
                     <p> Date: {{ _view_date_formate($value->_date ?? '') }}</p>
                    </td>
                    <td>
                      <?php
                      $date = $value->_date;
                    $warranty_valid_date = date('Y-m-d', strtotime($date.'+'.$value->_duration.' '.$value->_period.''));
                    $current_date= date('Y-m-d');

                    if ($warranty_valid_date > $current_date) { ?>

                  <p style="color:green;">Warranty Validity Date Untill {{ _view_date_formate($warranty_valid_date) }}</p>
                 <h3 style="color:green;">Warranty  available</h3>

                 <?php  } else { ?>
                 <p style="color:red;">Warranty Validity Date Expired {{ _view_date_formate($warranty_valid_date) }}</p>
                 <h3 style="color:red;">Warranty Not available</h3>
                  <?php }  ?>
                      
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4">
                      <h3 style="text-align: center;">No Data Found</h3>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
@else
@if(isset($request->_barcode))
    <h3 style="text-align: center;">No Data Found</h3> 
@endif   
@endif


        </div>
        <!-- /.row -->
      </div>
     



@endsection

@section('script')


@endsection