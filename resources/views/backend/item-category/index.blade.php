@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('item-category.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('item-category-create')

              <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info active " 
               href="{{ route('item-category.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
               </li>
              @endcan
            </ol>
          </div>
         
<style type="text/css">
  .border1px{
    border: 1px solid #000;
    width: 100%;
  }
</style>

      </div><!-- /.container-fluid -->
    </div>
   @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 @include('backend.item-category.search')
              </div>
              <div class="card-body">


 


                <div class="d-flex">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                       
                         <th class="">Action</th>
                         <th>Number of Product</th>
                         <th>Code</th>
                         @can('asset-management-report')
                         <th>{{__('label.dep_rate')}}</th>
                         <th>{{__('label.asset_ledger_id')}}</th>
                         <th>{{__('label.asset_dep_ledger_id')}}</th>
                         <th>{{__('label.asset_dep_exp_ledger_id')}}</th>
                        @endcan
                         <th>{{__('label._description')}}</th>





                         </tr>
                      </thead>
                      <tbody>
                        @php
                         $default_image = $settings->logo;
                         $sl=1;
                         @endphp 
                      
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td> <div style="width:200px;display: flex;">
                              <a  type="button" 
                                  href="{{ route('item-category.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                  @can('item-category-edit')
                                  <a  type="button" 
                                  href="{{ route('item-category.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan
                                @can('item-category-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                             </div></td>
                            
                             
                           <td><span class="text-bold">{{ $data->id ?? '' }} | </span> {{ $data->_name ?? '' }} <span class="_required">({{ $data->_cat_wise_item_count_count ?? '' }})</span> </td>
                           <td>{{$data->_code ?? '' }}</td>
                           @can('asset-management-report')
                           <td>{{$data->dep_rate ?? '' }}</td>
                           <td>{{ _ledger_name($data->asset_ledger_id ?? '') }}</td>
                           <td>{{ _ledger_name($data->asset_dep_ledger_id ?? '') }}</td>
                           <td>{{ _ledger_name($data->asset_dep_exp_ledger_id ?? '') }}</td>
                           @endcan
                           <td>{!! $data->_description ?? '' !!}</td>
                        </tr>
                        @php
                        $second_childs = $data->_childs ?? [];
                        @endphp
                        <!-- Start of Second Loop -->
                        @forelse($second_childs as $second_key=>$second_val)
                          <tr>
                            <td> <div style="width:200px;display: flex;">
                              <a  type="button" 
                                  href="{{ route('item-category.show',$second_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                  @can('item-category-edit')
                                  <a  type="button" 
                                  href="{{ route('item-category.edit',$second_val->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan
                                @can('item-category-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $second_val->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                             </div></td>
                            
                             
                           <td> <span class="text-bold">{{ $second_val->id ?? '' }} | </span>{{ $second_val->_parents->_name ?? '' }}/ {{ $second_val->_name ?? '' }} <span class="_required">({{ $second_val->_cat_wise_item_count_count ?? 0 }})</span></td>
                        </tr>
                        <!-- End of Second Loop -->
                        @php
                        $third_childs = $second_val->_childs ?? [];
                        @endphp
                          <!-- Start of third Loop -->
                          @forelse($third_childs as $third_key=>$third_val)
                            <tr>
                              <td> <div style="width:200px;display: flex;">
                                <a  type="button" 
                                    href="{{ route('item-category.show',$third_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                    @can('item-category-edit')
                                    <a  type="button" 
                                    href="{{ route('item-category.edit',$third_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                    @endcan
                                  @can('item-category-delete')
                                   {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $third_val->id],'style'=>'display:inline']) !!}
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                    {!! Form::close() !!}
                                 @endcan  
                               </div></td>
                              
                               
                             <td>

                         <span class="text-bold">{{ $third_val->id ?? '' }}</span> |   {{ $third_val->_parents->_parents->_name ?? '' }}/ {{ $third_val->_parents->_name ?? '' }}/ {{ $third_val->_name ?? '' }} <span class="_required">({{ $third_val->_cat_wise_item_count_count ?? 0 }})</span></td>
                          </tr>
                          <!-- End of third Loop -->
                          @php
                        $fourth_childs = $third_val->_childs ?? [];
                        @endphp
                          <!-- Start of fourth Loop -->
                          @forelse($fourth_childs as $fourth_key=>$fourth_val)
                            <tr>
                              <td> <div style="width:200px;display: flex;">
                                <a  type="button" 
                                    href="{{ route('item-category.show',$fourth_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                    @can('item-category-edit')
                                    <a  type="button" 
                                    href="{{ route('item-category.edit',$fourth_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                    @endcan
                                  @can('item-category-delete')
                                   {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $fourth_val->id],'style'=>'display:inline']) !!}
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                    {!! Form::close() !!}
                                 @endcan  
                               </div></td>
                              
                               
                             <td>

                          <span class="text-bold">{{ $fourth_val->id ?? '' }} | </span> {{ $fourth_val->_parents->_parents->_parents->_name ?? '' }}/  {{ $fourth_val->_parents->_parents->_name ?? '' }}/ {{ $fourth_val->_parents->_name ?? '' }}/ {{ $fourth_val->_name ?? '' }} <span class="_required">({{ $fourth_val->_cat_wise_item_count_count ?? 0 }})</span></td>
                         
                          </tr>
                          <!-- End of third Loop -->
                          

                            @php
                        $fifth_childs = $fourth_val->_childs ?? [];
                        @endphp
                          <!-- Start of fifth Loop -->
                          @forelse($fifth_childs as $fifth_key=>$fifth_val)
                            <tr>
                              <td> <div style="width:200px;display: flex;">
                                <a  type="button" 
                                    href="{{ route('item-category.show',$fifth_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                    @can('item-category-edit')
                                    <a  type="button" 
                                    href="{{ route('item-category.edit',$fifth_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                    @endcan
                                  @can('item-category-delete')
                                   {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $fifth_val->id],'style'=>'display:inline']) !!}
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                    {!! Form::close() !!}
                                 @endcan  
                               </div></td>
                              
                               
                             <td>

                        <span class="text-bold">{{ $fifth_val->id ?? '' }}</span> | {{ $fifth_val->_parents->_parents->_parents->_parents->_name ?? '' }}/ {{ $fifth_val->_parents->_parents->_parents->_name ?? '' }}/  {{ $fifth_val->_parents->_parents->_name ?? '' }}/ {{ $fifth_val->_parents->_name ?? '' }}/ {{ $fifth_val->_name ?? '' }} <span class="_required">({{ $fifth_val->_cat_wise_item_count_count ?? 0 }})</span></td>
                          </tr>
                          <!-- End of third Loop -->
                          @php
                        $six_childs = $fifth_val->_childs ?? [];
                        @endphp
                          <!-- Start of six Loop -->
                          @forelse($six_childs as $six_key=>$six_val)
                            <tr>
                              <td> <div style="width:200px;display: flex;">
                                <a  type="button" 
                                    href="{{ route('item-category.show',$six_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                    @can('item-category-edit')
                                    <a  type="button" 
                                    href="{{ route('item-category.edit',$six_val->id) }}"
                                    class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                    @endcan
                                  @can('item-category-delete')
                                   {!! Form::open(['method' => 'DELETE','route' => ['item-category.destroy', $six_val->id],'style'=>'display:inline']) !!}
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                    {!! Form::close() !!}
                                 @endcan  
                               </div></td>
                              
                               
                             <td>

                        <span class="text-bold">{{ $six_val->id ?? '' }}</span> | {{ $six_val->_parents->_parents->_parents->_parents->_parents->_name ?? '' }}/{{ $six_val->_parents->_parents->_parents->_parents->_name ?? '' }}/ {{ $six_val->_parents->_parents->_parents->_name ?? '' }}/  {{ $six_val->_parents->_parents->_name ?? '' }}/ {{ $six_val->_parents->_name ?? '' }}/ {{ $six_val->_name ?? '' }} <span class="_required">({{ $six_val->_cat_wise_item_count_count ?? 0 }})</span></td>
                          </tr>
                          <!-- End of third Loop -->
                          @empty
                          @endforelse

                          @empty
                          @endforelse

                          @empty
                          @endforelse
                          

                          @empty
                          @endforelse

                        @empty
                        @endforelse

                         

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                
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