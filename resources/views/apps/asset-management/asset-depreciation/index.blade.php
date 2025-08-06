@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="container-fluid">
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_depreciation-list')
            <li class="breadcrumb-item"><a href="{{route('asset_depreciation.index')}}">{{__('label.asset_depreciation')}}</a></li>
            @endcan
              @can('asset_depreciation-create')
            <li class="breadcrumb-item">
               <a class="btn btn-primary btn-sm "
                  href="{{route('asset_depreciation.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
            </li>
            @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
          
        

        <div>
                    
                    <div class="">
                      <div class="d-flex flex-row justify-content-end">
                       Number of Item: {{$data_count}} {!! $data->render() !!}
                      </div>
                      <div class="">
                        <table class="table table-bordered table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                            <th class=" ">{{__('label.action')}}</th>
                            <th class=" ">{{__('label.sl')}}</th>
                            <th class=" ">{{__('label.id')}}</th>
                            <th class=" ">{{__('label._voucher_id')}}</th>
                            <th class=" ">{{__('label._voucher_code')}}</th>
                            <th class=" ">{{__('label._date')}}</th>
                            <th class=" ">{{__('label._dep_month')}}</th>
                            <th class=" ">{{__('label._dep_year')}}</th>
                            <th class=" ">{{__('label._total_amount')}}</th>
                            <th class=" ">{{__('label._note')}}</th>
                            <th class=" ">{{__('label._status')}}</th>
                            <th class=" ">{{__('label._lock')}}</th>
                            <th class=" ">{{__('label.created_by')}}</th>
                            <th class=" ">{{__('label.updated_by')}}</th>
                            <th class=" ">{{__('label.created_at')}}</th>
                            <th class=" ">{{__('label.updated_at')}}</th>
                            </tr>
                          </thead>
                          <tbody >
                  @forelse ($data as $key => $value)

                   <tr class="" >
            <td class=" align-middle white-space-nowrap ps-8" >
                      <div class="d-flex align-items-center text-90">
                      
                            <a class="mr-4"  href="{!! route('asset_depreciation.edit',$value->id) !!}" title="Edit">
                              <span class="fas fa-pen"></span>
                            </a>
                        
                            <a class="mr-4"  href="{!! route('asset_depreciation.show',$value->id) !!}" title="Summary Report">
                              Summary
                            </a>
                            <a class="mr-4"  href="{!! route('asset_depreciation_detail',$value->id) !!}" title="Detail Report">
                              Detail
                            </a>
                       
                       
                       
                        
                       
                      </div>
                      
            </td>
                     
                     
            <td  style="white-space: nowrap;">{!! ($key+1) !!}</td>
            <td  style="white-space: nowrap;">{!! $value->id ?? '' !!}</td>
            <td  style="white-space: nowrap;">{!! $value->_voucher_id ?? '' !!}</td>
            <td  style="white-space: nowrap;">{!! $value->_voucher_code ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->_date ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! _number_to_month($value->_dep_month ?? '') !!}</td>
            <td style="white-space: nowrap;">{!! $value->_dep_year ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->_total_amount ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->_note ?? '' !!}</td>
            

            <td class=" align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 badge-phoenix-success">
            <span class="badge-label">{{ selected_status($value->_status) }}</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
          </td>
          <td style="white-space: nowrap;">{!! $value->_lock ?? '' !!}</td>

            <td style="white-space: nowrap;">{!! $value->created_by ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->updated_by ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->created_at ?? '' !!}</td>
            <td style="white-space: nowrap;">{!! $value->updated_at ?? '' !!}</td>
            
           
                    </tr>
                    
                  @empty
                  @endforelse
                          </tbody>

                        </table>

                      </div>
                     <div class="d-flex flex-row justify-content-end">
                        {!! $data->render() !!}
                      </div>
                    </div>
                  </div>
        </div>
        </div>
        </div>



@endsection

@section('script')
@endsection