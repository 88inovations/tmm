@extends('backend.layouts.app')
@section('title','General Settings')
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
 
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name" >Invoice Prefix Setup </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body" style="margin-bottom: 20px;">
                <form method="POST" action="{{url('invoice-prefix-store')}}" enctype="multipart/form-data">
               @csrf
                    <div class="row">
                     <div class="card">
             
              <div class="card-body">
                        <div class="col-md-12">
                          <table class="table table-bordered" style="width: 100%;">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Module Name</th>
                                <th>Prefix</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($data as $key=>$val)
                              <tr>
                                <td>
                                  <input type="text" name="id[]" class="form-control" value="{{$val->id}}" readonly>
                                </td>
                                <td>
                                  <input type="text" name="_table_name[]" class="form-control" value="{{$val->_table_name}}" readonly>
                                </td>
                                <td>
                                  <input type="text" name="_prefix[]" class="form-control" value="{{$val->_prefix}}">
                                </td>
                              </tr>
                              @empty
                              @endforelse
                            </tbody>
                          </table>
                        </div>

                      </div>
                        </div>
                       
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                        <br><br>
                    </div>
                    </form>
                
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