@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="container">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-condition-list')
            <li class="breadcrumb-item"><a href="{{route('asset-condition.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('asset-condition.store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
             

              <h4 class="mb-1">{{__('label.name')}}<span class="_required">*</span></h4>
              <input required class="form-control mb-2 @error('name') is-invalid @enderror" name="name" type="text" placeholder="{{__('label.name')}}" value="{!! old('name') !!}" />
              <h4 class="mb-1">{{__('label.code')}}</h4>
              <input class="form-control mb-2 @error('code') is-invalid @enderror" name="code" type="text" placeholder="{{__('label.code')}}" value="{!! old('code') !!}" />
              
             
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.description')}}</h4>
                <textarea class="form-control" name="description" >{!! old('description') !!}</textarea>
              </div>
             
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._status')}}:</h4>
               <select class="form-control" name="status">
                                  <option value="1" >Active</option>
                                  <option value="0" >In Active</option>
                                </select>
              </div>
              

            </div>
           
          <div class="col-12 mb-4 mt-4">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>
        </form>
</div>
</div>
        @endsection

@section('script')
  <script>
   
  </script>
@endsection