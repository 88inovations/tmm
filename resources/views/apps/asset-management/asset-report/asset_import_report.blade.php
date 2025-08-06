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
        <form class="mb-9" method="GET" action="{{ route('asset_import_report') }}" enctype='multipart/form-data'>
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

    
    $_end_date = $request->_end_date ?? '';
    $_start_date = $request->_start_date ?? '';





             @endphp
                    
                             <label class="mt-2 text-right col-md-4">{{__('label._start_date')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="date" name="_start_date" class="form-control _start_date" value="{!! old('_start_date',$_start_date ?? '') !!}" >
                          </div>
                       
                             <label class="mt-2 text-right col-md-4">{{__('label._end_date')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="date" name="_end_date" class="form-control _end_date" value="{!! old('_end_date',$_end_date ?? '') !!}" >
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



    

</div>


@if(sizeof($datas) > 0)
    <div class="container-fluid">
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
                @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}@endif
            </address>
            <p><b>{{$page_name ?? ''}}</b></p>
            @if($_start_date !='')
            <p>{{ _view_date_formate($_start_date ?? '' )  }} TO {{ _view_date_formate($_end_date ?? '' )  }}</p>
            @endif
      </div>
      <div class="row">
          
               
      </div>
  
  
       
        <table class="table table-bordered table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class=" align-middle ps-8" style="width:10%">{{__('label.sl')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._date')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._supplier_name')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._lc_date')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._bill_of_entry_date')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._voucher_number')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._asset_name')}}</th>
            <th class=" align-middle ps-8" style="width:10%">{{__('label._asset_value_bdt')}}</th>

                     
        </tr>
          </thead>
@php
$_total_asset_value_bdt=0;
@endphp
          <tbody class="list" id="order-table-body">
@forelse($datas as $key => $value)

@php
$_total_asset_value_bdt +=$value->_asset_value_bdt ?? 0;
@endphp
        <tr class="">
        <td class="= align-middle  ps-8 white-space-nowrap">{!! ($key+1) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _view_date_formate($value->_date ?? '' ) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_supplier_name ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _view_date_formate($value->_lc_date ?? '' ) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! _view_date_formate($value->_bill_of_entry_date ?? '' ) !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_voucher_number ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! $value->_asset_name ?? '' !!}</td>
        <td class="= align-middle  ps-8 white-space-nowrap">{!! (_report_amount($value->_asset_value_bdt ?? 0)) !!}</td>
        </tr>
        @empty
        <tr>
        <td colspan="8" style="text-align:center;"><b>{!! __('label.no_data_found') !!}</b></td>
        </tr>
        @endforelse
        </tbody>
        <tfoot>
          <tr>
             <tr class="">
        <th colspan="7" class="= align-middle  ps-8 white-space-nowrap"><b>Grand Total</b></th>
        <th class="= align-middle  ps-8 white-space-nowrap text-bold">{!! (_report_amount($_total_asset_value_bdt ?? 0)) !!}</th>
        </tr>
          </tr>
        </tfoot>
        </table>





<div style="padding-top: 100px;">
    @include('backend.message.invoice_footer')
</div>
                     

</div>
</div>
 @endif
</div>

@endsection

