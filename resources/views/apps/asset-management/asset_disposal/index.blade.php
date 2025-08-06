@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_disposal_list')
            <li class="breadcrumb-item"><a href="{{route('asset_disposal_list')}}">{{__('label.asset_disposal')}}</a></li>
            @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')
       
        <div id="orderTable" data-list='{"valueNames":["id","organization_id","_cost_center_id","_branch_id","_budget_id","_date","_order_number","voucher_id","voucher_code","_asset_customer_id","_asset_id","asset_ledger_id","asset_dep_ledger_id","gain_or_loss_ledger_id","_payment_receive_id","original_cost","accumulated_depreciation","sale_price","book_value","gain_loss","created_by","updated_by","created_at","updated_at"],"page":10,"pagination":true}'>
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
                  @can('asset_disposal_create')
                  <a class="btn btn-primary "
                  href="{{route('asset_disposal_create')}}"
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
                              
                             
                              <th class=" align-middle ps-8" scope="col"  >{{__('label.action')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_date" >{{__('label._date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="voucher_id" >{{__('label.voucher_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="voucher_code" >{{__('label.voucher_code')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_asset_customer_id" >{{__('label._asset_customer_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_asset_id" >{{__('label._asset_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_ledger_id" >{{__('label.asset_ledger_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_payment_receive_id" >{{__('label._payment_receive_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="original_cost" >{{__('label.original_cost')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="accumulated_depreciation" >{{__('label.accumulated_depreciation')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="book_value" >{{__('label.book_value')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="sale_price" >{{__('label.sale_price')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="gain_loss" >{{__('label.gain_loss')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="organization_id" >{{__('label.organization_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_cost_center_id" >{{__('label._cost_center_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_branch_id" >{{__('label._branch_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_budget_id" >{{__('label._budget_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_by" >{{__('label.created_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_by" >{{__('label.updated_by')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="created_at" >{{__('label.created_at')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="updated_at" >{{__('label.updated_at')}}</th>
                              
                           
                            </tr>
                          </thead>
                          <tbody class="list" id="order-table-body">
                             @forelse ($data as $key => $value)
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
             <td class=" align-middle white-space-nowrap ps-8">
                      <div class="d-flex align-items-center text-90">
                         @can('asset_disposal_edit')
                            <a class="mr-10"  href="{{ route('asset_disposal.edit',$value->id) }}"  title="Edit">
                              <span class="fas fa-pen"></span>
                            </a>
                           

                        @endcan
                       @can('asset_disposal_delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['asset_disposal.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
           
            <td class="_date align-middle white-space-nowrap ps-8 ">{!! _view_date_formate($value->_date ?? '') !!}</td>
            <td class="voucher_id align-middle white-space-nowrap ps-8 ">
              {!! $value->voucher_id ?? '' !!}
            </td>
            <td class="voucher_code align-middle white-space-nowrap ps-8 ">
              <a target="__blank" href="{{url('voucher')}}/{!! $value->voucher_id ?? '' !!}">{!! $value->voucher_code ?? '' !!}</a></td>
            <td class="_asset_customer_id align-middle white-space-nowrap ps-8 ">{!! $value->_asset_customer->_name ?? '' !!}</td>
            <td class="_asset_id align-middle white-space-nowrap ps-8 ">{!! $value->_asset->name ?? '' !!}  {!! $value->_asset->asset_code ?? '' !!}</td>
            <td class="asset_ledger_id align-middle white-space-nowrap ps-8 ">{!! $value->asset_ledger->_name ?? '' !!}  </td>
            <td class="_payment_receive_id align-middle white-space-nowrap ps-8 ">{!! $value->_payment_receive->_name ?? '' !!}  </td>
            <td class="original_cost align-middle white-space-nowrap ps-8 ">{!! $value->original_cost ?? 0 !!}  </td>
            <td class="accumulated_depreciation align-middle white-space-nowrap ps-8 ">{!! $value->accumulated_depreciation ?? 0 !!}  </td>
            <td class="book_value align-middle white-space-nowrap ps-8 ">{!! $value->book_value ?? 0 !!}  </td>
            <td class="sale_price align-middle white-space-nowrap ps-8 ">{!! $value->sale_price ?? 0 !!}  </td>
            <td class="gain_loss align-middle white-space-nowrap ps-8 ">{!! $value->gain_loss ?? 0 !!}  </td>
            <td class="organization_id align-middle white-space-nowrap ps-8 ">{!! $value->_organization->_name ?? '' !!}  </td>
            <td class="_cost_center_id align-middle white-space-nowrap ps-8 ">{!! $value->_master_cost_center->_name ?? '' !!}  </td>
            <td class="_branch_id align-middle white-space-nowrap ps-8 ">{!! $value->_master_branch->_name ?? '' !!}  </td>
            <td class="_budget_id align-middle white-space-nowrap ps-8 ">{!! $value->_budget_id ?? '' !!}  </td>
            <td class="created_by align-middle white-space-nowrap ps-8 ">{!! $value->created_by ?? '' !!}  </td>
            <td class="updated_by align-middle white-space-nowrap ps-8 ">{!! $value->updated_by ?? '' !!}  </td>   
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



@endsection

@section('script')

@endsection