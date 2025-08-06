@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style type="text/css">
  .tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, 
.tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:2px solid #000;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:2px solid #000;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:2px solid #000;
    border-radius:3px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none;
    cursor:pointer;
}
.tree>ul>li::before,
.tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:27px
}
.tree li span:hover {
    background: white;
    border:2px solid #94a0b4;
    }

[aria-expanded="false"] > .expanded,
[aria-expanded="true"] > .collapsed {
  display: none;
}

.indented-select {
            padding: 5px;
        }

        .indent {
            margin-left: 15px;
        }
    
    
</style>

@section('content')
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('asset-category.create')}}">{{__('label.asset-category')}}</a></li>
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
        

  <?php
    
  $menuItems =$data;

   

    // Organize data into a nested array
    $tree = buildTree($menuItems);
    
    ?>


<?php

function generateTreeMenuHtmlCollapse($items) {
        $html = '<ul>';
        foreach ($items as $item) {
            $html .= '';
            
            // Check if the item has children
            if (!empty($item['children'])) {
              $html .='<li>
                        <span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#page__'.removeAllSpace($item->name).'" aria-expanded="false" aria-controls="page__'.removeAllSpace($item->name).'"  >
                          <i class="collapsed"> <i class="fas fa-folder"></i></i>
                          <i class="expanded"><i class="far fa-folder-open"></i></i> '.$item->id.'-'.$item->name.'</a></span>
                        <ul>
                          <div id="page__'.removeAllSpace($item->name).'" class="collapse ">';
                          $html .= generateTreeMenuHtmlCollapse($item['children']);
                            
                        $html .=  '</div>
                        </ul>
                      </li>';
            } else {
                $html .= '<li><span><i class="far fa-file"></i><a attr_cat_id='.$item->id.' class=" ml-1 editCategory" href="#!">';
                $html .= $item->id.'-'.$item->name;
                $html .= '</a></span></li>';
            }

            
        }
        $html .= '</ul>';
        return $html;
    }


 ?>
 <div class="container">
 <div class="row">
   
   <div class="col-md-5" style="display:none;">
     <div class="tree ">
              <ul>
                <li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#AllCategory" aria-expanded="true" aria-controls="AllCategory"><i class="collapsed"><i class="fas fa-folder"></i></i>
                    <i class="expanded"><i class="far fa-folder-open"></i></i> All Category</a></span>
                  <div id="AllCategory" class="collapse show">

                  <?php  echo generateTreeMenuHtmlCollapse($tree); ?>
                    
                  </div>
                </li>
              </ul>
            </div>
   </div>
   <div class="col-md-12">
     <div id="orderTable" data-list='{"valueNames":["name","description","status","created_at","updated_at"],"page":10,"pagination":true}'>
                  <div class="mb-4">
              <div class="row g-3">
                <div class="col-auto">
                  <div class="search-box">
                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search" type="search" placeholder="Search orders" aria-label="Search" />
                      <span class="fas fa-search search-box-icon"></span>
                    </form>
                  </div>
                </div>
                
                <div class="col-auto">
                  @can('asset-category-create')
                  <a class="btn btn-primary "  href="{{route('asset-category.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
                   @endcan
                </div>
              </div>
            </div>
            
                    
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                      <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                              
                              <th class="sort align-middle ps-8 d-flex" scope="col">
                                {{__('label.action')}}
                              </th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="name" >{{__('label.name')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="code" >{{__('label.code')}}</th>
                              
                              <th class="sort align-middle ps-8" scope="col" data-sort="dep_rate" >{{__('label.dep_rate')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="description" >{{__('label.description')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_ledger_id" >{{__('label.asset_ledger_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_dep_exp_ledger_id" >{{__('label.asset_dep_exp_ledger_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_dep_ledger_id" >{{__('label.asset_dep_ledger_id')}}</th>
                              <th class=" align-middle ps-8" scope="col" >{{__('label.image')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="is_feature" >{{__('label.is_feature')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="status" >{{__('label.status')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_at" >{{__('label.created_at')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_at" >{{__('label.updated_at')}}</th>
                              
                             
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
             <td class="name align-middle white-space-nowrap ps-8">
                      <div class="d-flex align-items-center text-90">
                         @can('asset-category-edit')
                            <a class="mr-10"  href="{{ route('asset-category.edit',$value->id) }}?_lang_ref={!! $lan_data->lang_code ?? 'en_US' !!}" title="{!! $lan_data->lang_name ?? 'English' !!}">
                              <span class="fas fa-pen"></span>
                            </a>
                            

                        @endcan
                       
                         @can('asset-category-delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['asset-category.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
            <td class="name align-middle white-space-nowrap ps-8 ">{!! $value->name ?? '' !!}</td>
            <td class="code align-middle white-space-nowrap ps-8 ">{!! $value->code ?? '' !!}</td>
            <td class="code align-middle white-space-nowrap ps-8 ">{!! $value->dep_rate ?? '' !!}</td>
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->description ?? '' !!}</td>
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->category_ledger->_name ?? '' !!}</td>
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->dep_exp_category_ledger->_name ?? '' !!}</td>
            <td class="description align-middle white-space-nowrap ps-8 ">{!! $value->acc_dep_category_ledger->_name ?? '' !!}</td>
            <td class="color align-middle white-space-nowrap ps-8 ">
              @if($value->logo !='')
              <img src="{{asset('/')}}{{$value->logo}}" style="width:50px;height: 50px;">
              @endif
            </td>
            <td class="color align-middle white-space-nowrap ps-8 ">{!! selected_featured($value->is_featured ?? '') !!}</td>
            
                
          <td class="status align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->status)}}">
            <span class="badge-label">{{ selected_status($value->status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        </td>
            <td class="created_at align-middle white-space-nowrap ps-8 ">{!! $value->created_at ?? '' !!}</td>    
            <td class="updated_at align-middle white-space-nowrap ps-8 ">{!! $value->updated_at ?? '' !!}</td>    
                    </tr>
                   @empty
                   @endforelse
                          </tbody>
                        </table>
                      </div>
                      @include('common-widgets.datatable_footer')
                    </div>
                  </div>
   </div>
 </div>
           
        </div>
</div>


@endsection

@section('script')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> -->

@endsection