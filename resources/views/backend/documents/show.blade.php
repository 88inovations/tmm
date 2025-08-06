@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">{!! $page_name ?? '' !!} </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @can('documents-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('documents.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
        <table class="table table-bordered _list_table" >
                     
                      
                        <tr>
                            <td class="col-md-3">{{__('label.organization_id')}}</td>
                            <td class="col-md-9">{{ $data->company_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">{{__('label._branch_id')}}</td>
                            <td class="col-md-9">{{ $data->_branch_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">{{__('label._cost_center_id')}}</td>
                            <td class="col-md-9">{{ $data->cost_center_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">{{__('label._name')}}</td>
                            <td class="col-md-9">{{ $data->document_title ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-3">{{__('label.documents')}}</td>
                            <td class="col-md-9">
                                <a href="{{asset($data->_documents)}}" download>
                              <img src="{{asset($data->_documents)}}" alt="{{ $data->document_title ?? '' }}" >
                            </a>
                            <br>
                               <a class="btn btn-sm btn-info" href="{{asset($data->_documents)}}" download>{{__('Download')}}</a>
                        </td>
                        </tr>
                        <tr>
                            <td class="col-md-3">{{__('label._status')}}</td>
                            <td class="col-md-9">{{ selected_status($data->_status) }}</td>
                        </tr>

                       
                        </tbody>
                    </table>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection