@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')

<?php

$tree = buildTree($data);

 ?>
 <div class="container">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('asset-category.index')}}">{{__('label.asset-category')}}</a></li>
            <li class="breadcrumb-item active">{{__('label.new_asset-category')}}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('asset-category.store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{{__('label.new_asset-category')}}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-8">
              <div class="mb-6 " style="display:none;">
                   <h4 class="mb-3">{{__('label.asset-category')}}</h4>
                    
                    <select id="indented-select" class="form-control @error('parent_id') is-invalid @enderror"
                      name="parent_id"  >
                                  <option value="">{{__('label.parent-category')}}</option>
                                    <?php
                                    $html = '';
                                    function generateOptions($category_resize_data, $indent = 0) {
                                        foreach ($category_resize_data as $key => $value) {
                                            echo '<option value="' . $value['id'] . '">' . str_repeat('-', $indent * 2) . $value['id'].'-' .$value['name']. '</option>';
                                            if (is_array($value['children']) && !empty($value['children'])) {
                                                generateOptions($value['children'], $indent + 1);
                                            }
                                        }
                                    }
                                    
                                    generateOptions($tree);
                                    ?>
                                </select>
              </div>

              <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.name')}}<span class="_required">*</span></label>
              </div>
              <div class="col-sm-12 mb-1">
                <input required class="form-control  @error('name') is-invalid @enderror" name="name" type="text" placeholder="{{__('label.name')}}" value="{{old('name')}}" />
              </div>

              
              <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.code')}}<span class="_required">*</span></label>
              </div>
              <div class="col-sm-12 mb-1">
                <input required class="form-control  @error('code') is-invalid @enderror" name="code" type="text" placeholder="{{__('label.code')}}" value="{{old('code')}}" />
              </div>

              
              <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.dep_rate')}}<span class="_required">*</span></label>
              </div>
              <div class="col-sm-12 mb-1">
                <input required class="form-control  @error('dep_rate') is-invalid @enderror" name="dep_rate" type="number" min="0" step="any" placeholder="{{__('label.dep_rate')}}" value="{{old('dep_rate')}}" />
              </div>

              
                         
                  <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.asset_ledger_id')}}<span class="_required">*</span></label>
                  </div>
                  <div class="col-sm-12 mb-1">
                      <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id')}}" placeholder="{{__('label.asset_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                      <input type="hidden" id="asset_ledger_id" name="asset_ledger_id" class="form-control asset_ledger_id" value="{{old('asset_ledger_id')}}"  required>
                      <div class="search_box_main_ledger"> </div>
                  </div>
                   <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.asset_dep_ledger_id')}}<span class="_required">*</span></label>
                   </div>
                    <div class="col-sm-12 mb-1">
                  
                            <input type="text" id="_search_asset_dep_ledger_id" name="_search_asset_dep_ledger_id" class="form-control _search_asset_dep_ledger_id" value="{{old('_search_asset_dep_ledger_id')}}" placeholder="{{__('label.asset_dep_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="asset_dep_ledger_id" name="asset_dep_ledger_id" class="form-control asset_dep_ledger_id" value="{{old('asset_dep_ledger_id')}}"  required>
                            <div class="asset_dep_search_box_main_ledger"> </div>
                    </div>
                <div class="col-sm-12">
                   <label class=" mb-1 text-1000">{{__('label.asset_dep_exp_ledger_id')}}<span class="_required">*</span></label>
                   </div>
                    <div class="col-sm-12 mb-1">
                  
                            <input type="text" id="_search_asset_dep_exp_ledger_id" name="_search_asset_dep_exp_ledger_id" class="form-control _search_asset_dep_exp_ledger_id" value="{{old('_search_asset_dep_exp_ledger_id')}}" placeholder="{{__('label.asset_dep_exp_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="asset_dep_exp_ledger_id" name="asset_dep_exp_ledger_id" class="form-control asset_dep_exp_ledger_id" value="{{old('asset_dep_exp_ledger_id')}}"  required>
                            <div class="asset_dep_exp_search_box_main_ledger"> </div>
                    </div>
               
              
              
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label.description')}}</h4>
                <textarea class="summernote" name="description" >{{old('description')}}</textarea>
              </div>
              
              <div class="mb-6">
                <h4 class="mb-3">Display images</h4>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="loadFile(event,1 )">
                <img id="output_1"  class="inputImageDisplay"  src="" />
              </div>
              <div class="mb-6">
                <h4 class="mb-3"> {{__('label._status')}}:</h4>
               <select class="form-control" name="status">
                                  <option value="1" >Active</option>
                                  <option value="0" >In Active</option>
                                </select>
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
                                <option value="{{$key}}" @if($key==1) selected @endif >{{$val}}</option>
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
                              <input type="number" min="0" step="any" name="order" class="form-control" value="{{old('order',0)}}"  />
                          </div>
                        </div>
                        
                        
                        
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                
            </div>
          </div>
          <div class="col-12 gy-6">
                <div class="row g-3 justify-content-start">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" fdprocessedid="ua7pt">SAVE</button></div>
                </div>
              </div>
        </form>
</div>
        @endsection



@section('script')

<script>
  var items = <?php echo json_encode($data); ?>;
  console.log(items)

    function updateSelection() {
        const select = document.getElementById('indented-select');
        const selectedOption = select.options[select.selectedIndex];
        console.log(selectedOption.value, selectedOption.text);
    }


</script>
 <script>
    $(function () { $('.summernote').summernote(); })
  </script>
@endsection