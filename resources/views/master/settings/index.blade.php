@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')

@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">{{__('label.dashboard')}}</a></li>
            
            
            <li class="breadcrumb-item">{{$edit_page_name ?? ''}}</li>
            
          </ol>
        </nav>
        @include('messages.message')
        <div class="mb-9">
        
           <form class="mb-9" method="post" action="{{ route('general-settings-save')}}" enctype='multipart/form-data'>
        @csrf
        
               
              <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
              <input type="hidden" name="id" value="{{$data->id ?? ''}}">
              <h4 class="mb-1">{{__('label.name')}}<span class="_required">*</span></h4>
              <input class="form-control mb-2 @error('name') is-invalid @enderror" name="name" type="text" placeholder="{{__('label.name')}}" value="{!! old('name',$data->name ?? '') !!}" />

              <h4 class="mb-1">{{__('label.code')}}</h4>
              <input class="form-control mb-2 @error('code') is-invalid @enderror" name="code" type="text" placeholder="{{__('label.code')}}" value="{!! old('code',$data->code ?? '' ) !!}" />
              
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.tag_line')}}</h4>
                <textarea class="form-control" name="tag_line" placeholder="{{__('label.tag_line')}}">{!! old('tag_line',$data->tag_line ?? '') !!}</textarea>
                
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.phone')}}</h4>
                <textarea class="form-control" name="phone" placeholder="{{__('label.phone')}}">{!! old('phone',$data->phone ?? '') !!}</textarea>
                
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.address')}}</h4>
                <textarea class="form-control" name="address" >{!! old('address',$data->address ?? '' ) !!}</textarea>
              </div>
              
              <div class="mb-6">
                <h4 class="mb-3">Logo</h4>
                <input type="file" name="logo" class="form-control" accept="image/*" onchange="loadFile(event,1 )">
                <img id="output_1"  class="inputImageDisplay"  src="{{asset('/')}}{!! $data->logo ?? '' !!}" />
              </div>
              <div class="mb-6">
                <h4 class="mb-3">{{__('label.favicon')}}</h4>
                <input type="file" name="favicon" class="form-control" accept="image/*" onchange="loadFile(event,2 )">
                <img id="output_2"  class="inputImageDisplay"  src="{{asset('/')}}{!! $data->favicon ?? '' !!}" />
              </div>
              <div class="mb-6">
                <h4 class="mb-3">{{__('label.apple_touch_icon')}}</h4>
                <input type="file" name="apple_touch_icon" class="form-control" accept="image/*" onchange="loadFile(event,3 )">
                <img id="output_3"  class="inputImageDisplay"  src="{{asset('/')}}{!! $data->apple_touch_icon ?? '' !!}" />
              </div>
              <div class="mb-6">
                <h4 class="mb-3">{{__('label.favicon_32')}}</h4>
                <input type="file" name="favicon_32" class="form-control" accept="image/*" onchange="loadFile(event,4 )">
                <img id="output_4"  class="inputImageDisplay"  src="{{asset('/')}}{!! $data->favicon_32 ?? '' !!}" />
              </div>
              <div class="mb-6">
                <h4 class="mb-3">{{__('label.favicon_16')}}</h4>
                <input type="file" name="favicon_16" class="form-control" accept="image/*" onchange="loadFile(event,5 )">
                <img id="output_5"  class="inputImageDisplay"  src="{{asset('/')}}{!! $data->favicon_16 ?? '' !!}" />
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
        </div>



@endsection

@section('script')
 <script>
   

    $(function () {
        $('.summernote').summernote();
        })
  </script>
@endsection


