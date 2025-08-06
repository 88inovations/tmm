@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-vendor-list')
            <li class="breadcrumb-item"><a href="{{route('asset-vendor.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ url('asset-management/old-data-insert') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
              <h4 class="mb-1">{{__('label.name')}}<span class="_required">*</span></h4>
            <select name="table_name" class="form-control" required>
              <option value="">--select type--</option>
              <option value="branch">Branch</option>
              <option value="assets_categories">assets_categories</option>
              <option value="assets_conditions">assets_conditions</option>
              <option value="assets_device_locations">assets_device_locations</option>
              <option value="assets_locations">assets_locations</option>
              <option value="assets_vendors">assets_vendors</option>
              <option value="asset_brands">asset_brands</option>
              <option value="assets_users">assets_users</option>
              <option value="asset_items">asset_items</option>
              <option value="asset_assigns">asset_assigns</option>
              <option value="assign_statuses">assign_statuses</option>
            </select>
              
              
              

            </div>
            
          <div class="col-12 ">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>
        </form>

        @endsection

@section('script')
  <script>
   

    $(function () { $('.summernote').summernote(); })
  </script>
@endsection