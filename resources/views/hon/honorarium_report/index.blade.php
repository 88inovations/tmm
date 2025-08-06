@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
<style type="text/css">
    .report_link{
        font-size: 16px;
        padding-top: 7px;
        border-bottom: 1px solid silver;
    }
</style>
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp

    <div class="content">
      <div class="container">
   <h2 class="text-center _page_name">{!! $page_name ?? '' !!}</h2>
    <div class="container   " >
        <div class="row  ">
                 @can('honorarium_module') 
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid silver;">
                    <h4 class="text-center">{{__('label.honorarium_report')}}</h4>
                        <div class="dropdown-divider"></div>
                         @can('honorarium_bill_sheet')
                          
                          <a href="{{url('honorarium_bill_sheet')}}" class="dropdown-item">
                            <i class="fa fa-sitemap mr-2" aria-hidden="true"></i>{{ __('label.honorarium_bill_sheet') }}
                          </a>
                         @endcan
          
           
                   </div>
                </div>
                @endcan



    
    
</div>
</div>
</div>
    
    </div>

    @endsection