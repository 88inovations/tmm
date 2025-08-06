@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('documents.index') }}">{!! $page_name ?? '' !!} </a>
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
      <div class="container">
                 @include('backend.message.message')
              
             
              
                {!! Form::open(array('route' => 'documents.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                    
                        <table>
                            <tr>
                                <input type="hidden" name="id" value="{{$data->id ?? ''}}">
                                <td class="col-md-3"><label>{!! __('label.organization') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                    <select class="form-control _ledger_organization_id" name="organization_id" required >

                                   
                                   @forelse($permited_organizations as $val )
                                   <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                   @empty
                                   @endforelse
                                 </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><label>{!! __('label.Branch') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                    <select class="form-control" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><label>{!! __('label._cost_center_id') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                    <select class="form-control _ledger_cost_center_id" name="_cost_center_id" required >
                               
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><label>{!! __('label.document_title') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                   <input type="text" name="document_title" class="form-control" placeholder="{{__('label.document_title')}}" value="{{old('document_title',$data->document_title ?? '')}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><label>{!! __('label._documents') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                   <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_documents" class="form-control">
                                   <br>
                                   <img id="output_1" class="banner_image_create" src="{{asset($data->_documents ?? '')}}"  style="max-height:100px;max-width: 100px; " />
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><label>{!! __('label._status') !!}:<span class="_required">*</span></label></td>
                                <td class="col-md-9">
                                    <select class="form-control" name="_status">
                                  @foreach(common_status() as $key=>$s_val)
                                  <option value="{{$key}}" @if(isset($data->_status) && $data->_status==$key) selected @endif >{{$s_val}}</option>
                                  @endforeach
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"></td>
                                <td class="col-md-9">
                                    <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                                </td>
                            </tr>
                        </table>

                    {!! Form::close() !!}
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


@endsection