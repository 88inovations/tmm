@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('documents.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('documents-create')
              <li class="breadcrumb-item active">
                  

                  <a  
               class="btn btn-sm btn-info active " 
               href="{{ route('documents.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>


               </li>
              @endcan
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
                 

                  <div class="row">
                   @php

 $currentURL = URL::full();
 $current = URL::current();
if($currentURL === $current){
   $print_url = $current."?print=single";
   $print_url_detal = $current."?print=detail";
}else{
     $print_url = $currentURL."&print=single";
     $print_url_detal = $currentURL."&print=detail";
}
    

                   @endphp
                    <div class="col-md-4">
                      @include('backend.documents.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                          
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered _list_table" >
                      <thead>
                        <tr>
                         <th>SL</th>
                         <th>Action</th>
                         <th>{{__('label.organization_id')}}</th>
                         <th>{{__('label._branch_id')}}</th>
                         <th>{{__('label._cost_center_id')}}</th>
                         <th>{{__('label._name')}}</th>
                         <th>{{__('label.documents')}}</th>
                         <th>{{__('label._status')}}</th>
                      </tr>
                      </thead>
                      <tbody>
                      
                        
                           @forelse($datas as $key3=>$data)

                        <tr>
                           <td>{{($key3+1)}}</td>
                           <td style="display: flex;">
                           
                                <a 
                                  href="{{ route('documents.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                  @can('documents-edit')
                                  <a 
                                  href="{{ route('documents.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan
                                @can('documents-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['documents.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                          
                             
                            <td>{{ $data->company_name ?? '' }}</td>
                            <td>{{ $data->_branch_name ?? '' }}</td>
                            <td>{{ $data->cost_center_name ?? '' }}</td>
                            <td>{{ $data->document_title ?? '' }}</td>
                            <td>
                              <a href="{{asset($data->_documents)}}" download>
                              <img src="{{asset($data->_documents)}}" alt="{{ $data->document_title ?? '' }}" width="104" height="142">
                            </a>
                            <br>
                               <a class="btn btn-sm btn-info" href="{{asset($data->_documents)}}" download>{{__('Download')}}</a>
                            </td>
                            
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @empty
                        @endforelse
                       
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
</div>

@endsection