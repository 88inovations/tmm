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
        <form class="mb-9" method="post" action="{{ route('asset-vendor.store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
              <h4 class="mb-1">{{__('label.name')}}<span class="_required">*</span></h4>
              <input class="form-control mb-2 @error('name') is-invalid @enderror" name="name" type="text" placeholder="{{__('label.name')}}" value="{!! old('name') !!}" />
              <h4 class="mb-1">{{__('label.code')}}</h4>
              <input class="form-control mb-2 @error('code') is-invalid @enderror" name="code" type="text" placeholder="{{__('label.code')}}" value="{!! old('code') !!}" />
              
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.phone')}}</h4>
                <input type="text" name="phone" class="form-control" placeholder="{{__('label.phone')}}" value="{!! old('phone') !!}">
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.address')}}</h4>
                <textarea class="summernote" name="address" >{!! old('address') !!}</textarea>
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.description')}}</h4>
                <textarea class="summernote" name="description" >{!! old('description') !!}</textarea>
              </div>
              <div class="mb-6">
                <h4 class="mb-3">Logo</h4>
                <input type="file" name="logo" class="form-control" accept="image/*" onchange="loadFile(event,1 )">
                <img id="output_1"  class="inputImageDisplay"  src="" />
              </div>
              
              

            </div>
            <div class="col-12 col-xl-4">
              <div class="row g-2">
                <div class="col-12 col-xl-12">
                  <div class="card mb-3">
                    <div class="card-body">
                     
                      <div class="row gx-3">
                      @include('common-widgets.language_select')
                        <div class="col-12 col-sm-6 col-xl-12">
                          <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">{{__('label.status')}}</h5>
                            </div>
                              <select name="status" class="form-select" id="status">
                                 @forelse(common_status() as $key=>$val)
                                <option value="{{$key}}" >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-12">
                          <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                              <h5 class="mb-0 text-1000 me-2">{{__('label.order')}}</h5>
                            </div>
                              <input type="number" name="order" step="any" min="0" class="form-control" value="{!! old('order',0) !!}">
                          </div>
                        </div>
                        
                        
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                
            </div>
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