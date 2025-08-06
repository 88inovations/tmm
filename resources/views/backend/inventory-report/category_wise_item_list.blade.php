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
                        <label>{{__('label._category_id')}}:</label>
                        <select id="_category_id" class="form-control _category_id " name="_category_id" >
                          <option value="">ALL</option>
                          @forelse($categories as $val)
                          <option value="{{$val->id}}" @if(isset($request->_category_id) && $request->_category_id==$val->id) selected @endif >{{$val->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>

                    </div>
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
        <!-- /.row -->
      </div>
    </div>  
<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
  <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 
               
              </table>
            </td>
            
          </tr>
        </table>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>SL</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Unit</th>
            <th>W.H Price</th>
            <th>Trade Price</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
         
          @forelse($datas as $key=>$details)
          <tr>
            <th colspan="7">{{ $key ?? '' }}</th>
          </tr>
           @php
          $serial =1;
          @endphp

          @forelse($details as $val)
          <tr class="">
            <td>{{($serial)}}</td>
            <td>{!! $val->_code ?? '' !!}</td>
            <td>{!! $val->_item ?? '' !!}</td>
            <td>{!! $val->unit_name ?? '' !!}</td>
            <td>{!! $val->_sale_rate ?? '' !!}</td>
            <td>{!! $val->_trade_price ?? '' !!}</td>
            <td></td>
          </tr>
          @php
          $serial++;
          @endphp
        @empty
          @endforelse
          
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
</div>



@endsection



