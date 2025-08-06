@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('steward-waiter.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('steward-waiter-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ route('steward-waiter.create') }}"> Add New </a>
               </li>
              @endcan
             
                @can('account-ledger-create')
             <li class="breadcrumb-item active">
                 <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> Add New Ledger
                </button>
               
               @endcan
              </li>
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 @include('backend.steward-waiter.search')
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th class="_action">Action</th>
                         <th>Branch</th>
                         <th>Details</th>
                         <th>Status</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key+1 }}</td>
                               <td style="display: flex;">
                            <div class="dropdown mr-1">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"> Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                   <a class="dropdown-item "  href="{{ route('steward-waiter.show',$data->id) }}">View  </a>
                                  @can('steward-waiter-edit')
                                    <a class="dropdown-item " href="{{ route('steward-waiter.edit',$data->id) }}">Edit</a>
                                  @endcan
                                 @can('steward-waiter-delete')
                                  {!! Form::open(['method' => 'DELETE','route' => ['steward-waiter.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm "><span class="_required">Delete</span></button>
                                  {!! Form::close() !!}
                                  @endcan
                                </div>
                              </div>
                        </td>

                            
                           
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>
                              @php
                                          $stewared = explode(',', $data->_ledgers ?? '');
                                          @endphp
                                          @forelse($stewared as $l_id)
                                        <span>{{_ledger_name($l_id)}}</span><br>
                                          @empty
                                          @endforelse
                            </td>
                            <td>{{ selected_status($data->_status ?? 0) }}</td>
                            
                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>

    @include('backend.common-modal.item_ledger_modal')
</div>

@endsection