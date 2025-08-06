@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
 <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_eng_consumptions_list')
            <li class="breadcrumb-item"><a href="{{route('asset_eng_consumptions.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            @can('asset_eng_consumptions_create')
            <li class="breadcrumb-item">
              <a class="btn btn-primary btn-sm "
                  href="{{route('asset_eng_consumptions.create')}}"
                  ><span class="fas fa-plus me-2"></span>{{__('label.new')}}</a>
            </li>
            @endcan
          </ol>
        </nav>
        <div class="mb-9">
          @include('messages.message')


           

       
        <div >
                
                    
                    <div class="">
                      <div class="">
                        <table class="table table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                             
                             
                              <th class=" align-middle ps-8" scope="col"  >{{__('label.action')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="id" >{{__('label.id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_date" >{{__('label._date')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_voucher_number" >{{__('label._voucher_number')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_id" >{{__('label.asset_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_tag" >{{__('label.asset_tag')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="asset_code" >{{__('label.asset_code')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="energy_used" >{{__('label.energy_used')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="cost" >{{__('label.cost')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="operating_hours" >{{__('label.operating_hours')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="fuel_used_liters" >{{__('label.fuel_used_liters')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="electricity_used_kwh" >{{__('label.electricity_used_kwh')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_note" >{{__('label._note')}}</th>

                              <th class="sort align-middle ps-8" scope="col" data-sort="organization_id" >{{__('label.organization_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_cost_center_id" >{{__('label._cost_center_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_branch_id" >{{__('label._branch_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_budget_id" >{{__('label._budget_id')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_lock" >{{__('label._lock')}}</th>
                              <th class="sort align-middle ps-8" scope="col" data-sort="_status" >{{__('label._status')}}</th>
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
                         @can('asset_eng_consumptions_edit')
                            <a class="mr-4"  href="{{ route('asset_eng_consumptions.edit',$value->id) }}" title="Edit">
                              <span class="fas fa-pen"></span>
                            </a>
                           

                        @endcan
                         @can('asset_eng_consumptions_list')
                            <a class="mr-4"  href="{{ route('asset_eng_consumptions.show',$value->id) }}" title="Edit">
                              <span class="fas fa-eye"></span>
                            </a>
                           

                        @endcan
                       
                        @can('asset_eng_consumptions_delete')         
                                    {!! Form::open(['method' => 'DELETE','route' => ['asset_eng_consumptions.destroy', $value->id],'style'=>'display:inline']) !!}
                                         <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash "></i></button>
                                    {!! Form::close() !!}
                          @endcan
                      </div>
                      
                      </td>
                      
                     
            <td class="id align-middle white-space-nowrap ps-8 ">{!! $value->id ?? '' !!}</td>
           
            <td class="_date align-middle white-space-nowrap ps-8 ">{!! _view_date_formate($value->_date ?? '') !!}</td>
            <td class="_voucher_number align-middle white-space-nowrap ps-8 ">
               {!! $value->_voucher_code ?? '' !!}
            </td>
            <td class="_asset_id align-middle white-space-nowrap ps-8 ">{!! $value->_asset_item->name ?? '' !!}</td>
            <td class="asset_tag align-middle white-space-nowrap ps-8 ">{!! $value->_asset_item->asset_tag ?? '' !!}</td>
            <td class="asset_code align-middle white-space-nowrap ps-8 ">{!! $value->_asset_item->asset_code ?? '' !!}</td>
            <td class="energy_used align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->energy_used ?? 0) !!}</td>
            <td class="cost align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->cost ?? 0) !!}</td>
            <td class="operating_hours align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->operating_hours ?? 0) !!}</td>
            <td class="fuel_used_liters align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->fuel_used_liters ?? 0) !!}</td>
            <td class="electricity_used_kwh align-middle white-space-nowrap ps-8 ">{!! _report_amount($value->electricity_used_kwh ?? 0) !!}</td>
            <td class="_note align-middle white-space-nowrap ps-8 ">{!! $value->_note ?? '' !!}  </td>

           <td class="organization_id align-middle white-space-nowrap ps-8 ">{!! $value->organization->_name ?? '' !!}  </td>
            <td class="_cost_center_id align-middle white-space-nowrap ps-8 ">{!! $value->cost_center->_name ?? '' !!}  </td>
            <td class="_branch_id align-middle white-space-nowrap ps-8 ">{!! $value->branch->_name ?? '' !!}  </td>
            <td class="_budget_id align-middle white-space-nowrap ps-8 ">{!! $value->_budget_id ?? '' !!}  </td>
            <td class="_status align-middle white-space-nowrap text-start fw-bold text-700">
            <span class="badge badge-phoenix fs--2 {{_status_base_class($value->_status)}}">
            <span class="badge-label">{{ selected_status($value->_status) }}</span>
            <span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
            </td>
               <td class="_lock align-middle white-space-nowrap ps-8 " >
                  @can('lock-permission')
                
                  <input class=" _invoice_lock" type="checkbox" name="_lock" attr_url="{{url('_lock_action')}}" _attr_invoice_id="{{$value->id}}" value="{{$value->_lock}}" @if($value->_lock==1) checked @endif>
                  @endcan

                  
                  @if($value->_lock==1)
                  <i class="fa fa-lock _green ml-1 _icon_change__{{$value->id}}" aria-hidden="true"></i>
                  @else
                  <i class="fa fa-lock _required ml-1 _icon_change__{{$value->id}}" aria-hidden="true"></i>
                  @endif
                  

                </td>

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
        </div>
        </div>
        </div>



@endsection

@section('script')

<script type="text/javascript">
   $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var url = $(this).attr('attr_url');
    console.log(_id)
    var _table_name ="asset_eng_consumptions";
      if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name,url)
       
  })
</script>

@endsection