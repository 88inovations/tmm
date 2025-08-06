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
      
      <li class="breadcrumb-item"><b>{!! $page_name ?? '' !!}</b></li>
      
     
     
     
    </ol>
  </nav>
  <div class="mb-9">
    <ol class=" mb-0">
      <li><a target="__blank" href="{{url('asset-management/list-filter')}}">{!! __('label.Asset List') !!}</a></li>
      <li><a target="__blank" href="{{route('single_asset_depriciation')}}">{!! __('label.single_asset_depriciation') !!}</a></li>
      <!-- <li><a target="__blank" href="{{route('single_asset_sales_report')}}">{!! __('label.single_asset_sales_report') !!}</a></li> -->
      <li><a target="__blank" href="{{route('asset_sales_report')}}">{!! __('label.asset_sales_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_import_report')}}">{!! __('label.asset_import_report') !!}</a></li>
      <!-- <li><a target="__blank" href="{{route('all_asset_import_report')}}">{!! __('label.all_asset_import_report') !!}</a></li> -->
      <li><a target="__blank" href="{{route('depriciation_report_all')}}">{!! __('label.depriciation_report_all') !!}</a></li>
    <!--   <li><a target="__blank" href="{{route('asset_valuation_report')}}">{!! __('label.asset_valuation_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_utilization_report')}}">{!! __('label.asset_utilization_report') !!}</a></li> -->
      <li><a target="__blank" href="{{route('maintenance_and_repair_costs_report')}}">{!! __('label.maintenance_and_repair_costs_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_eng_consumptions_report')}}">{!! __('label.asset_eng_consumptions_report') !!}</a></li>
     <!--  <li><a target="__blank" href="{{route('total_asset_value_report')}}">{!! __('label.total_asset_value_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_age_report')}}">{!! __('label.asset_age_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_status_report')}}">{!! __('label.asset_status_report') !!}</a></li>
      <li><a target="__blank" href="{{route('asset_location_report')}}">{!! __('label.asset_location_report') !!}</a></li>
      <li><a target="__blank" href="{{route('insurance_coverage_report')}}">{!! __('label.insurance_coverage_report') !!}</a></li> -->

     
      
     
     
     
    </ol>
       
  </div>
  </div>
  </div>
  </div>



@endsection

@section('script')
@endsection