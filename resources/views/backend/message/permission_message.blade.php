@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mt-5">
          <div class="col-sm-12">
            <h1 class="m-0 text-center _required">{!! $__message ?? '' !!} </h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    

@endsection