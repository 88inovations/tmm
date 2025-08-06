@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('item-category.index') }}"> {!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @include('backend.common-modal.item_ledger_sub_link')
              <li class="breadcrumb-item active">
                 <a class="btn btn-primary" href="{{ route('item-category.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i> </a>
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
               
                 <form action="{{ url('item-category/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label>Parents Categories:</label>
                                
                                <select class="form-control " name="_parent_id" required>
                                  <option value="0">Base Category</option>
                                  @forelse($parents_categories as $category)
                                @php
                                  $_childs_category = $category->_childs ?? [];
                                  $has_child = sizeof($_childs_category);
                                 @endphp
                                  <option value="{{$category->id}}" @if($category->id==$data->_parent_id) selected @endif >{{ $category->_name ?? '' }}</option>
                                   @if($has_child > 0)
                                   {!! display_child_category($_childs_category,$level=0,$data->_parent_id,$data->_parent_id) !!}
                                    
                                    @endif
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Name:</label>
                                
                                <input type="text" name="_name" class="form-control" required="true" value="{!! $data->_name ?? '' !!}">
                            </div>
                        </div>
                             <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.code')}}<span class="_required">*</span></label>
              </div>
              <div class="col-sm-12 mb-1">
                <input required class="form-control  @error('code') is-invalid @enderror" name="code" type="text" placeholder="{{__('label.code')}}" value="{{old('code',$data->_code ?? '')}}" />
              </div>

        @can('asset-management-report')  
              <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.dep_rate')}}<span class="_required">*</span></label>
              </div>
              <div class="col-sm-12 mb-1">
                <input required class="form-control  @error('dep_rate') is-invalid @enderror" name="dep_rate" type="number" min="0" step="any" placeholder="{{__('label.dep_rate')}}" value="{{old('dep_rate',$data->dep_rate ?? 0)}}" />
              </div>

                     <div class="col-md-12">
                   <h5 class="mb-1 text-1000">{{__('label.asset_ledger_id')}}<span class="_required">*</span></h5>
                    
                    <div class=" mb-1">
                                        <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->category_ledger->_name ?? '')}}" placeholder="{{__('label.asset_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  required>

                                        <input type="hidden" id="asset_ledger_id" name="asset_ledger_id" class="form-control asset_ledger_id _main_ledger_id" value="{{old('asset_ledger_id',$data->asset_ledger_id ?? '')}}"  required>
                                        <div class="search_box_main_ledger"> </div>
                                </div>
                        </div>
                         <div class="col-sm-12">
                   <h5 class="mb-1 text-1000">{{__('label.asset_dep_ledger_id')}}</h5>
                    
                    <div class=" mb-1">
                                        <input type="text" id="_search_asset_dep_ledger_id" name="_search_asset_dep_ledger_id" class="form-control _search_asset_dep_ledger_id" value="{{old('_search_asset_dep_ledger_id',$data->dep_exp_category_ledger->_name ?? '')}}" placeholder="{{__('label.asset_dep_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  >

                                        <input type="hidden" id="asset_dep_ledger_id" name="asset_dep_ledger_id" class="form-control asset_dep_ledger_id" value="{{old('asset_dep_ledger_id',$data->asset_dep_ledger_id ?? '')}}"  >
                                        <div class="asset_dep_search_box_main_ledger"> </div>
                                </div>
                        </div>
                         <div class="col-sm-12">
                   <h5 class="mb-1 text-1000">{{__('label.asset_dep_exp_ledger_id')}}</h5>
                    
                    <div class=" mb-1">
                                        <input type="text" id="_search_asset_dep_exp_ledger_id" name="_search_asset_dep_exp_ledger_id" class="form-control _search_asset_dep_exp_ledger_id" value="{{old('_search_asset_dep_exp_ledger_id',$data->acc_dep_category_ledger->_name ?? '')}}" placeholder="{{__('label.asset_dep_exp_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  >

                                        <input type="hidden" id="asset_dep_exp_ledger_id" name="asset_dep_exp_ledger_id" class="form-control asset_dep_exp_ledger_id" value="{{old('asset_dep_exp_ledger_id',$data->asset_dep_exp_ledger_id ?? '')}}"  >
                                        <div class="asset_dep_exp_search_box_main_ledger"> </div>
                                </div>
                        </div>
            @endcan
              <div class="col-md-12 mb-6">
                <h4 class="mb-3"> {{__('label._description')}}</h4>
                <textarea class="form-control" name="_description" >{!! old('_description',$data->_description ?? '' ) !!}</textarea>
              </div>
              
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            
                            <div class="form-group">
                                <label>Image:</label>
                               <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
                               <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$data->_image ?? ''}}"  style="max-height:100px;max-width: 100px; " />
                            </div>
                        
                        </div>
                        
                       <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
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