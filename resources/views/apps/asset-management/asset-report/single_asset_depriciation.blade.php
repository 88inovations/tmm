@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_sales_list')
            <li class="breadcrumb-item"><a href="{{route('asset_sales_list')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="GET" action="{{ route('single_asset_depriciation') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
                        
                             <label class="mt-2 text-1000 col-md-4 text-right">{{__('label.name')}}<span class="_required">*</span></label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="name" class="form-control asset_name_search" value="{!! old('name',$request->name ?? '') !!}" placeholder="{{__('label.name')}}" attr_url="{{route('asset_search')}}">
                               <input type="hidden" id="_asset_id" name="_asset_id" class="form-control _asset_id" value="{{old('_asset_id',$request->_asset_id ?? '')}}"  required >
                            <div class="asset_name_box"> </div>

                          </div>
                        
                         
                             <label class="mt-2 text-1000 col-md-4 text-right">{{__('label.asset_tag')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_tag" class="form-control asset_tag" value="{{old('asset_tag',$request->asset_tag ?? '' )}}" placeholder="{{__('label.asset_tag')}}"  attr_url="{{route('asset_search')}}">
                                <div class="asset_name_box"> </div>
                              </div>
                       
                         
                             <label class="mt-2 text-right col-md-4">{{__('label.asset_code')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_code" class="form-control asset_code" value="{{old('asset_code',$request->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" attr_url="{{route('asset_search')}}">
                               <div class="asset_name_box"> </div>
                          </div>
                     
                     
                             <label class="mt-2 text-right col-md-4">{{__('label.model_no')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="model_no" class="form-control model_no" value="{{old('model_no',$request->model_no ?? '')}}" placeholder="{{__('label.model_no')}}" attr_url="{{route('asset_search')}}">
                              <div class="asset_name_box"> </div>
                          </div>
                      
                         
                  <div class="col-12 mt-4 mb-4">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >Report</button></div>
                </div>
              </div>

                    
                   
                </div>
              
              
              
            
            
          
        </form>
<div class="container-fluid">

    @if(sizeof($datas) > 0)
    <div style="width: 100px;margin:0px auto;">
      <nav  aria-label="breadcrumb" style="margin-top:10px;">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
             <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
             </a>
          </li>
          <li class="breadcrumb-item">
              <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
          </li>
        </ol>
      </nav>
    </div>
    <div class="invoice" id="printablediv">
      <div class="text-center">
          <address>
            <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
                {!! $settings->name ?? '' !!}<br>
                @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
               
                
            </address>
      </div>
      <div class="row">
         <div class="col-md-12">
            <p>Depreciation Schedule</p>
                <p>{{__('label._name')}}: <b>{!! $asset_item->name ?? '' !!} </b>,{{__('label.asset_tag')}} : <b>{!! $asset_item->asset_tag ?? '' !!}</b> ,{{__('label.model_no')}} :<b> {!! $asset_item->model_no ?? '' !!}</b> ,{{__('label.serial_no')}} : <b>{!! $asset_item->serial_no ?? '' !!}</b> </p>
                <p>{{__('label.purchase_date')}}: <b>{!! _view_date_formate($asset_item->purchase_date ?? '') !!}</b></p>
                <p>{{__('label.evaluated_price')}}: <b>{!! _report_amount($asset_item->evaluated_price ?? 0) !!}</b></p>
                <p>{{__('label.dep_rate')}}: <b>{!! _report_amount($asset_item->dep_rate ?? 0) !!}</b></p>
         </div>
      </div>
  
  
       
        <table class="table table-bordered table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.sl')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._year')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._month')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.Beginning_Book_Value')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._asset_dep_rate')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.Monthly_Depreciation')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.accumulated_dep_val')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.Ending_Book_Value')}}</th>

                     
        </tr>
          </thead>
          <tbody class="list" id="order-table-body">
             @forelse($datas as $key => $value)
        <tr class="">
        <td class="= align-middle  ps-8 white-space-nowrap">{!! ($key+1) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_dep_year ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _number_to_month($value->_dep_month ?? '') !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($value->book_value ?? 0) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($value->_asset_dep_rate ?? 0) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($value->_asset_dep_amount ?? 0) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($value->accumulated_dep_val ?? 0) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount(($value->book_value ?? 0)-($value->_asset_dep_amount ?? 0)) !!}</td>
        </tr>
        @empty
        <tr>
        <td colspan="8" style="text-align:center;"><b>{!! __('label.no_data_found') !!}</b></td>
        </tr>
        @endforelse
        </tbody>
        </table>





<div style="padding-top: 100px;">
    @include('backend.message.invoice_footer')
</div>
                     
 </div>
 @endif
    
</div>
</div>
</div>
</div>


@endsection

@section('script')
  <script>


  
  </script>
@endsection