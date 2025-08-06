@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <a class="m-0 _page_name" href="{{ route('steward-waiter.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('steward-waiter.index') }}"> {!! $page_name ?? '' !!}</a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
                
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Branch:</strong>
                        {{ $data->_branch->_name ?? '' }}
                    </div>
                </div>
                
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Steward/Waiter:</strong><br>
                        @php
                                          $stewared = explode(',', $data->_ledgers ?? '');
                                          @endphp
                                          @forelse($stewared as $l_id)
                                        <span>{{_ledger_name($l_id)}}</span><br>
                                          @empty
                                          @endforelse
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Created At:</strong>
                        {{ $data->created_at ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Updated At:</strong>
                        {{ $data->updated_at ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status:</strong>
                        {{ selected_status($data->_status ?? 0) }}
                    </div>
                </div>
               
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


@endsection