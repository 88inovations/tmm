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
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset-entry-assign.index')}}">{{__('label.asset-entry-assign')}}</a></li>
            @endcan
           
            <li class="breadcrumb-item">
               <a style="cursor: pointer;"   title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i>
               </a>
            </li>
            <li class="breadcrumb-item">
                <a style="cursor: pointer;" onclick="fnExcelReport();"   title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
            </li>
           
          </ol>
        </nav>
        <div class="mb-9">
       


<section class="invoice" id="printablediv">
   <div class="text-center">
      <address>
        <img src="{{asset('/')}}{{$settings->logo ?? '' }}" style="width:60px;height: 60px;"><br>
            {!! $settings->name ?? '' !!}<br>
            @if($settings->address !=''){!! $settings->address ?? '' !!}, {!! $settings->phone ?? '' !!}<br>@endif
           
           Date: {{date('d-m-Y')}}<br>
           <b>{!! $brand->name ?? '' !!} {{__('label.brand_wise_asset_list')}}</b>
        </address>
  </div>
  
       
                        <table class="table table-bordered table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                            <th class=" align-middle ps-8" style="width:3%">{{__('label.sl')}}</th>
                           
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.assign-status')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.users')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset_tag')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.serial_no')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.device_name')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.model_no')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.description')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.remarks')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.category')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset-brand')}}</th>
                            <th class=" align-middle ps-8" style="width:10%">{{__('label.asset-condition')}}</th>
                            <th class=" align-middle ps-8">{{__('label.asset-vendor')}}</th>
                            <th class=" align-middle ps-8">{{__('label.status')}}</th>
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="">
            <td class=" align-middle  ps-8">
                      {{($key+1)}}
                      
            </td>
                      
            <td class=" align-middle white-space-nowrap ps-8 ">
              {!! $value->assign_status->name ?? '' !!}
            </td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->current_user->name ?? '' !!}</td>
            <td class=" align-middle white-space-nowrap ps-8 ">{!! $value->asset_tag ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->serial_no ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->model_no ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->description ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->remarks ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->category->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->brand->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->condition->name ?? '' !!}</td>
            <td class=" align-middle  ps-8 ">{!! $value->vendor->name ?? '' !!}</td>
            
           <td class=" align-middle  text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->status)}}">
            <span class="badge-label">{{ selected_status($value->status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
          
                    </tr>
                   @empty
                   @endforelse
                          </tbody>

                        </table>

                     
 </section>
          
        
            
</div>
</div>
</div>
</div>



@endsection

@section('script')
@endsection