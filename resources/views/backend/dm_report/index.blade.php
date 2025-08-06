@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection

@section('content')
@php
$__user= Auth::user();
@endphp

    <div class="content">
      <div class="container-fluid">
   <h2 class="text-center">{!! $page_name ?? '' !!}</h2>
    <div class="container-fluid   " >
        <div class="row  ">
                 @can('account-report-menu') 
                <div class="col-md-6">
                    <div class="card bg-default">
                    <h4>{{__('label.account_report')}}</h4>
                    <ul>
                        @can('dm_item_ledger')
                        <li><a target="__blank" href="{{url('dm_item_ledger')}}">{{ __('label.dm_item_ledger') }}</a></li>
                        @endcan
                        @can('dm_item_stock_possition')
                        <li><a target="__blank" href="{{url('dm_item_stock_possition')}}">{{ __('label.dm_item_stock_possition') }}</a></li>
                        @endcan
                        @can('dm_item_stock_value')
                        <li><a target="__blank" href="{{url('dm_item_stock_value')}}">{{ __('label.dm_item_stock_value') }}</a></li>
                        @endcan
                        @can('dm_receive_from_customer')
                        <li><a target="__blank" href="{{url('dm_receive_from_customer')}}">{{ __('label.dm_receive_from_customer') }}</a></li>
                        @endcan
                        @can('dm_receive_from_stock')
                        <li><a target="__blank" href="{{url('dm_receive_from_stock')}}">{{ __('label.dm_receive_from_stock') }}</a></li>
                        @endcan
                        @can('dm_send_to_supplier')
                        <li><a target="__blank" href="{{url('dm_send_to_supplier')}}">{{ __('label.dm_send_to_supplier') }}</a></li>
                        @endcan
                       
                    </ul>
                   </div>
                </div>
                @endcan
                

                
                
        </div>
    </div>
    
</div>
    
    </div>

    @endsection