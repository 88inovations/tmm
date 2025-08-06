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
          
            <li class="breadcrumb-item"><a href="{{url('asset-management/report')}}">{!! $page_name ?? '' !!}</a></li>
           
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="GET" action="{{ route('asset_eng_consumptions_report') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-12">
              
<div class="row g-0 border-top border-bottom border-300" style="padding:10px; ;">
               
             @php

    $_ledger_id = $request->_ledger_id ?? '';
    $category_id = $request->category_id ?? '';
    $_asset_id = $request->_asset_id ?? '';
    $asset_tag = $request->asset_tag ?? '';
    $asset_code = $request->asset_code ?? '';
    $model_no = $request->model_no ?? '';
    $_end_date = $request->_end_date ?? '';
    $_start_date = $request->_start_date ?? '';





             @endphp
                         
                        
                       
                        
                             <label class="mt-2 text-right col-md-4">{{__('label._start_date')}}<span class="_required">*</span></label>
                             <div class="col-md-6 mt-2">
                              <input type="date" name="_start_date" class="form-control _start_date" value="{!! old('_start_date',$_start_date ?? '') !!}" required>
                          </div>
                       
                       
                             <label class="mt-2 text-right col-md-4">{{__('label._end_date')}}<span class="_required">*</span></label>
                             <div class="col-md-6 mt-2">
                              <input type="date" name="_end_date" class="form-control _end_date" value="{!! old('_end_date',$_end_date ?? '') !!}" required>
                          </div>
                        
                             <label class="mt-2 text-right col-md-4">{{__('label._ledger_id')}}</label>
                             <div class="col-md-6 mt-2">
                              <select class="form-control _ledger_id" name="_ledger_id">
                                <option value=""><---All---></option>
                                  @forelse($asset_ledgers as $ledger)
                                  <option value="{!! $ledger->id ?? '' !!}" @if($_ledger_id==$ledger->id) selected @endif >{!! $ledger->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse

                              </select>

                          </div>
                        
                             <label class="mt-2 text-right col-md-4">{{__('label._category_id')}}</label>
                             <div class="col-md-6 mt-2">
                              <select class="form-control category_id" name="category_id">
                                <option value=""><---All---></option>
                                  @forelse($assets_categories as $category)
                                  <option value="{!! $category->id ?? '' !!}" @if($category_id==$category->id ) selected @endif>{!! $category->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse

                              </select>

                          </div>
                       
                             <label class="mt-2 text-right col-md-4">{{__('label.name')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="name" class="form-control asset_name_search" value="{!! old('name',$request->name ?? '') !!}" placeholder="{{__('label.name')}}" attr_url="{{route('asset_search')}}" attr_sold="">
                               <input type="hidden" id="_asset_id" name="_asset_id" class="form-control _asset_id" value="{{old('_asset_id',$request->_asset_id ?? '')}}"   >
                            <div class="asset_name_box"> </div>

                          </div>
                      
                             <label class="mt-2 text-right col-md-4">{{__('label.asset_tag')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_tag" class="form-control asset_tag" value="{{old('asset_tag',$request->asset_tag ?? '' )}}" placeholder="{{__('label.asset_tag')}}"  attr_url="{{route('asset_search')}}"  attr_sold="">
                                <div class="asset_name_box"> </div>
                              </div>
                        
                             <label class="mt-2 text-right col-md-4">{{__('label.asset_code')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_code" class="form-control asset_code" value="{{old('asset_code',$request->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" attr_url="{{route('asset_search')}}"  attr_sold="">
                               <div class="asset_name_box"> </div>
                          </div>
                       
                             <label class="mt-2 text-right col-md-4">{{__('label.model_no')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="model_no" class="form-control model_no" value="{{old('model_no',$request->model_no ?? '')}}" placeholder="{{__('label.model_no')}}" attr_url="{{route('asset_search')}}"  attr_sold="">
                              <div class="asset_name_box"> </div>
                          </div>
                       
                        </div>
                        
                      </div>
                  <div class="col-12 mb-4 mt-4">
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
            <p><b>{{$page_name ?? ''}}</b></p>
            @if($_start_date !='')
            <p><b>{{ _view_date_formate($_start_date ?? '' )  }} TO {{ _view_date_formate($_end_date ?? '' )  }}</b></p>
            @endif
      </div>
      <div class="row">
          
               
      </div>
  
  
       
        <table class="table table-bordered table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.sl')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._date')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._ledger_id')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._category_id')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._asset_id')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._asset_tag')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.model_no')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.serial_no')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._voucher_number')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.cost')}}</th>

                     
        </tr>
@php
$total_cost =0;
@endphp
          </thead>
          <tbody class="list" id="order-table-body">
             @forelse($datas as $key => $value)

             @php
$total_cost +=$value->cost ?? 0;
@endphp
        <tr class="">
        <td class="= align-middle  ps-8 white-space-nowrap">{!! ($key+1) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _view_date_formate($value->_date ?? '') !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->ledger_name ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->cat_name ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_asset_name ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_asset_tag ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->model_no ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->serial_no ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_voucher_number ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($value->cost ?? 0) !!}</td>
        </tr>
        @empty
        <tr>
        <td colspan="10" style="text-align:center;"><b>{!! __('label.no_data_found') !!}</b></td>
        </tr>
        @endforelse
        </tbody>
        <tfoot>
           <tr class="">
        <th colspan="9" class="= align-middle  ps-8 white-space-nowrap">Grand Total</th>
        <th class="= align-middle  ps-8 white-space-nowrap">{!! _report_amount($total_cost ?? 0) !!}</th>
        </tr>
        </tfoot>
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