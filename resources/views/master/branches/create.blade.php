@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">{{__('label.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('branches.index')}}">{!! $page_name ?? '' !!}</a></li>
            <li class="breadcrumb-item active">{!! $page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('branches.store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
             

              <h4 class="mb-1">{{__('label.name')}}<span class="_required">*</span></h4>
              <input required class="form-control mb-2 @error('_name') is-invalid @enderror" name="_name" type="text" placeholder="{{__('label._name')}}" value="{!! old('_name') !!}" />
              <h4 class="mb-1">{{__('label.code')}}</h4>
              <input class="form-control mb-2 @error('_code') is-invalid @enderror" name="_code" type="text" placeholder="{{__('label._code')}}" value="{!! old('_code') !!}" />
              
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._phone')}}</h4>
                <input type="text" name="_phone" class="form-control" placeholder="{{__('label._phone')}}" value="{!! old('_phone') !!}">
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._email')}}</h4>
                <input type="text" name="_email" class="form-control" placeholder="{{__('label._email')}}" value="{!! old('_email') !!}">
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._address')}}</h4>
                <textarea class="summernote" name="_address" >{!! old('_address') !!}</textarea>
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