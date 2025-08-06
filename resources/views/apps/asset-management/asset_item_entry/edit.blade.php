@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
<?php

$tree = buildTree($categories);

 ?>


        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset-entry-assign-list')
            <li class="breadcrumb-item"><a href="{{route('asset_item_entry.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
       
           <form class="mb-9" method="post" action="{{ route('asset_item_entry.update', $data->id) }}" enctype='multipart/form-data'>
        @csrf
        @method('PUT')
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-12">
              
<div class="row g-0 border-top border-bottom border-300">
               
                @php
                

                @endphp
                <div class="col-sm-12">
                  <div class="tab-content py-3 ps-sm-4 h-100">
                    <div class="tab-pane fade show active" id="assetBasicContent" role="tabpanel">
                        
                      <div class="row g-3">

                        <div class="col-md-4">
                            <label>{{__('label.asset-category')}}<span class="_required">*</span></label><br>
                            <select id="indented-select" class="category_id  form-control @error('category_id') is-invalid @enderror"  
                      name="category_id"  attr_url="{{url('asset-management/category_detail')}}">
                                  <option value="">{{__('label.parent-category')}}</option>
                                   @forelse($assets_categories as $cat)
                                  <option value="{{$cat->id}}" @if($cat->id==$data->category_id) selected @endif >{!! $cat->_name ?? '' !!}</option>

                                   @empty
                                   @endforelse
                                </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_ledger_id')}}<span class="_required">*</span></label><br>
                            <div >
                                        <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',_find_ledger($data->asset_ledger_id ?? 0))}}" placeholder="{{__('label.asset_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  required>

                                        <input type="hidden" id="asset_ledger_id" name="asset_ledger_id" class="form-control asset_ledger_id" value="{{old('asset_ledger_id',$data->asset_ledger_id ?? '')}}"  required>
                                        <div class="search_box_main_ledger"> </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_dep_ledger_id')}}<span class="_required">*</span></label><br>
                            <div >
                                       <input type="text" id="_search_asset_dep_ledger_id" name="_search_asset_dep_ledger_id" class="form-control _search_asset_dep_ledger_id" value="{{old('_search_asset_dep_ledger_id',_find_ledger($data->asset_dep_ledger_id ?? 0))}}" placeholder="{{__('label.asset_dep_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  required>

                                        <input type="hidden" id="asset_dep_ledger_id" name="asset_dep_ledger_id" class="form-control asset_dep_ledger_id" value="{{old('asset_dep_ledger_id',$data->asset_dep_ledger_id ?? '')}}"  required>
                                        <div class="asset_dep_search_box_main_ledger"> </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_dep_exp_ledger_id')}}<span class="_required">*</span></label><br>
                            <div >
                                      <input type="text" id="_search_asset_dep_exp_ledger_id" name="_search_asset_dep_exp_ledger_id" class="form-control _search_asset_dep_exp_ledger_id" value="{{old('_search_asset_dep_exp_ledger_id',_find_ledger($data->asset_dep_exp_ledger_id))}}" placeholder="{{__('label.asset_dep_exp_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  required>

                                        <input type="hidden" id="asset_dep_exp_ledger_id" name="asset_dep_exp_ledger_id" class="form-control asset_dep_exp_ledger_id" value="{{old('asset_dep_exp_ledger_id',$data->asset_dep_exp_ledger_id ?? '')}}"  required>
                                        <div class="asset_dep_exp_search_box_main_ledger"> </div>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.asset-brand')}}</label><br>
                            <div >
                                       <select class="form-control" name="brand_id">
                                <option value="">{{__('label.select_asset_brand')}}</option>
                                @forelse($ass_brands as $val)
                                <option value="{{$val->id}}" @if($val->id==$data->brand_id) selected @endif>{!! $val->_code ?? '' !!}-{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.asset-condition')}}</label><br>
                            <div >
                             <select class="form-control" name="asset_condition_id">
                                <option value="">{{__('label.select_asset-condition')}}</option>
                                @forelse($ass_conditions as $val)
                                <option value="{{$val->id}}" @if($val->id==$data->asset_condition_id) selected @endif >{!! $val->code ?? '' !!}-{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.assign-status')}}</label><br>
                            <div >
                             <select class="form-control" name="assign_status_id">
                                 <option value="0">Select Assign Status</option>
                                @forelse($assign_status as $key=>$val)
                                <option value="{{$val->id}}" @if($data->assign_status_id==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000 _required">{{__('label.organization_id')}}</label><br>
                            <div >
                             <select class="form-control" name="organization_id" required>
                                 <option value="0">Select {{__('label.organization_id')}}</option>
                                @forelse($organizations as $key=>$val)
                                <option value="{{$val->id}}" @if($data->organization_id==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000 _required">{{__('label._branch_id')}}</label><br>
                            <div >
                             <select class="form-control" name="branch_id" required>
                                 <option value="0">Select {{__('label._branch_id')}}</option>
                                @forelse($_org_branches as $key=>$val)
                                <option value="{{$val->id}}" @if($data->branch_id==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000 _required">{{__('label._cost_center_id')}}</label><br>
                            <div >
                             <select class="form-control" name="project_id" required>
                                 <option value="0">Select {{__('label._cost_center_id')}}</option>
                                @forelse($_org_cost_centers as $key=>$val)
                                <option value="{{$val->id}}" @if($data->project_id==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000 _required">{{__('label._budget_id')}}</label><br>
                            <div >
                             <select class="form-control" name="_budget_id" required>
                                 <option value="0">Select {{__('label._budget_id')}}</option>
                                @forelse($budgets as $key=>$val)
                                <option value="{{$val->id}}" @if($data->_budget_id==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>

                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.import_cost_detail_id')}}<span class="_required">*</span></label><br>
                            <div >
                              <input attr_url="{{route('import_cost_detail_ref')}}" type="text" name="import_cost_detail_id" class="form-control import_cost_detail_id" value="{!! old('import_cost_detail_id',$data->import_cost_detail_id ?? '') !!}" placeholder="{{__('label.import_cost_detail_id')}}">
                                 <div class="asset_name_box"> </div>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label._item_id')}}<span class="_required">*</span></label><br>
                            <div >
                              <input type="text" name="_item_id" class="form-control _item_id" value="{!! old('_item_id',$data->_item_id ?? '') !!}" placeholder="{{__('label._item_id')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label._name')}}<span class="_required">*</span></label><br>
                            <div >
                              <input type="text" name="name" class="form-control name_of_asset" value="{!! old('name',$data->name ?? '') !!}" placeholder="{{__('label._name')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_tag')}}</label><br>
                            <div >
                             <input type="text" name="asset_tag" class="form-control" value="{{old('asset_tag',$data->asset_tag ?? '')}}" placeholder="{{__('label.asset_tag')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_code')}}</label><br>
                            <div >
                             <input type="text" name="asset_code" class="form-control" value="{{old('asset_code',$data->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.model_no')}}</label><br>
                            <div >
                             <input type="text" name="model_no" class="form-control" value="{{old('model_no',$data->model_no ?? '' )}}" placeholder="{{__('label.model_no')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.serial_no')}}</label><br>
                            <div >
                             <input type="text" name="serial_no" class="form-control" value="{{old('serial_no',$data->serial_no ?? '' )}}" placeholder="{{__('label.serial_no')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                             <label class="mb-1 text-1000 ">{{__('label.insured_amount')}}</label>
                             <div>
                              <input type="text" name="insured_amount" class="form-control" value="{{old('insured_amount',$data->insured_amount ?? 0)}}" placeholder="{{__('label.insured_amount')}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-1000 ">{{__('label.annual_benefit')}}</label><br>
                             <div>
                              <input type="text" name="annual_benefit" class="form-control" value="{{old('annual_benefit',$data->annual_benefit ?? 0 )}}" placeholder="{{__('label.annual_benefit')}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-1000 ">{{__('label.compliance_status')}}</label><br>
                             <div>
                              <input type="text" name="compliance_status" class="form-control" value="{{old('compliance_status',$data->compliance_status ?? '' )}}" placeholder="{{__('label.compliance_status')}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-1000 ">{{__('label.risk_level')}}</label><br>
                             <div>
                              <input type="text" name="risk_level" class="form-control" value="{{old('risk_level',$data->risk_level ?? '')}}" placeholder="{{__('label.risk_level')}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-1000 ">{{__('label.utilization_rate')}}</label><br>
                             <div>
                              <input type="text" name="utilization_rate" class="form-control" value="{{old('utilization_rate',$data->utilization_rate ?? '' )}}" placeholder="{{__('label.utilization_rate')}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                             <label class="text-1000 ">{{__('label.service_agreement_expiry')}}</label><br>
                             <div>
                              <input type="date" name="service_agreement_expiry" class="form-control" value="{{old('service_agreement_expiry',$data->service_agreement_expiry ?? '' )}}" placeholder="{{__('label.service_agreement_expiry')}}">
                          </div>
                        </div>

                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.domain_intune')}}</label><br>
                            <div >
                             <input type="text" name="domain_intune" class="form-control" value="{{old('domain_intune',$data->domain_intune ?? '' )}}" placeholder="{{__('label.domain_intune')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.os_type')}}</label><br>
                            <div>
                             <input type="text" name="os_type" class="form-control" value="{{old('os_type',$data->os_type ?? '' )}}" placeholder="{{__('label.os_type')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.year_manufacture')}}</label><br>
                            <div>
                             <input type="text" name="year_manufacture" class="form-control" value="{{old('year_manufacture',$data->year_manufacture ?? '' )}}" placeholder="{{__('label.year_manufacture')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.origin')}}</label><br>
                            <div>
                             <input type="text" name="origin" class="form-control" value="{{old('origin',$data->origin ?? '' )}}" placeholder="{{__('label.origin')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.description')}}</label><br>
                            <div>
                             <textarea class="form-control" name="description">{{old('description',$data->description ?? '')}}</textarea>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.remarks')}}</label><br>
                            <div>
                             <textarea class="form-control" name="remarks">{{old('remarks',$data->remarks ?? '' )}}</textarea>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.status')}}</label><br>
                            <div>
                              <select name="status" class="form-select" id="status">
                                 @forelse(common_status() as $key=>$val)
                                <option value="{{$key}}" @if($data->status==$key) selected @endif >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.purchase_date')}}</label><br>
                            <div>
                              <input type="date" name="purchase_date" class="form-control" value="{{old('purchase_date',$data->purchase_date ?? '' )}}" placeholder="{{__('label.purchase_date')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.dep_date')}}</label><br>
                            <div>
                               <input type="date" name="dep_date" class="form-control dep_date" value="{{old('dep_date',$data->dep_date ?? '' )}}" placeholder="{{__('label.dep_date')}}">
                                </div>
                        </div>

                        <div class="col-md-4">
                             <label>{{__('label.asset-vendor')}}</label><br>

                             <input type="text" name="search_asset_vendor" class="form-control search_asset_vendor" value="{{old('search_asset_vendor',_find_ledger($data->vendor_id))}}"  attr_url="{{url('main-ledger-search')}}" placeholder="{{__('label.asset-vendor')}}" >
                             <input type="hidden" name="vendor_id" class="form-control vendor_id" value="{{old('vendor_id',$data->vendor_id ?? '')}}">
                             <div class="asset_vendor_box"> </div>
                              
                          </div>

                       
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.purchase_voucher_no')}}</label><br>
                            <div>
                                <input type="text" name="purchase_voucher_no" class="form-control" value="{{old('purchase_voucher_no',$data->purchase_voucher_no ?? '' )}}" placeholder="{{__('label.purchase_voucher_no')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.purchase_price')}}</label><br>
                            <div>
                                <input type="number" min="0" step="any"  name="purchase_price" class="form-control purchase_price" value="{{old('purchase_price',$data->purchase_price ?? '')}}" placeholder="{{__('label.purchase_price')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.extra_cost')}}</label><br>
                            <div>
                                <input type="number" min="0" step="any"  name="extra_cost" class="form-control extra_cost" value="{{old('extra_cost',$data->extra_cost ?? 0)}}" placeholder="{{__('label.extra_cost')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.estimated_life')}}</label><br>
                            <div>
                                <input type="number" min="0" step="any"  name="estimated_life" class="form-control" value="{{old('estimated_life',$data->estimated_life ?? '' )}}" placeholder="{{__('label.estimated_life')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.evaluated_price')}}</label><br>
                            <div>
                                <input type="number" min="0" step="any"  name="evaluated_price" class="form-control evaluated_price" value="{{old('evaluated_price',$data->evaluated_price ?? '' )}}" placeholder="{{__('label.evaluated_price')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.salvage_value')}}</label><br>
                            <div>
                                <input type="number" min="0" step="any"  name="salvage_value" class="form-control salvage_value" value="{{old('salvage_value',$data->salvage_value ?? '' )}}" placeholder="{{__('label.salvage_value')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.dep_type')}}</label><br>
                            <div>
                                <select name="dep_type" class="form-control">
                               <option value="1" @if($data->dep_type==1) selected @endif >{{__('label.percentage')}}</option>
                               <option value="2" @if($data->dep_type==2) selected @endif >{{__('label.fixed')}}</option>
                             </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.dep_rate')}}</label><br>
                            <div>
                               <input  class="form-control" type="number" min="0" step="any"  name="dep_rate" value="{{old('dep_rate',$data->dep_rate ?? 0)}}" placeholder="{{__('label.dep_rate')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.dep_value')}}</label><br>
                            <div>
                               <input  class="form-control" type="number" min="0" step="any"  name="dep_value" value="{{old('dep_value',$data->dep_value ?? '' )}}" placeholder="{{__('label.dep_value')}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.accumulated_dep_val')}}</label><br>
                            <div>
                               <input  class="form-control" type="number" min="0" step="any"  name="accumulated_dep_val" value="{{old('accumulated_dep_val',$data->accumulated_dep_val ?? '')}}" placeholder="{{__('label.accumulated_dep_val')}}" >
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.warranty_start_date')}}</label><br>
                            <div>
                               <input type="date" name="warranty_start_date" class="form-control" value="{{old('warranty_start_date',$data->warranty_start_date)}}" placeholder="{{__('label.warranty_start_date')}}">
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.warranty_end_date')}}</label><br>
                            <div>
                               <input type="date" name="warranty_end_date" class="form-control" value="{{old('warranty_end_date',$data->warranty_end_date ?? '')}}" placeholder="{{__('label.warranty_end_date')}}">
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.warranty_status')}}</label><br>
                            <div>
                               <select class="form-control" name="warranty_status">
                                 @foreach(_warranty_status() as $key=>$val)
                                    <option value="{{$key}}" @if($key==$data->warranty_status) selected @endif >{{$val}}</option>
                                 @endforeach
                             </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_image_1')}}</label><br>
                            <div>
                               <input type="file" name="asset_image_1" class="form-control" accept="image/*" onchange="loadFile(event,1 )">
                            <img id="output_1"  style="width: 150px;" class="inputImageDisplay"  src="{{asset($data->asset_image_1 ?? '')}}" />
                                </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-1000">{{__('label.asset_image_2')}}</label><br>
                            <div>
                               <input type="file" name="asset_image_2" class="form-control" accept="image/*" onchange="loadFile(event,2 )">
                            <img style="width: 150px;" id="output_2"  class="inputImageDisplay"  src="{{asset($data->asset_image_2 ?? '')}}" />
                                </div>
                        </div>

                         
                         
                        
                      </div>
                    
                  
                 
                    
                   
                    
                  
                    
                  </div>
                </div>
              </div>
              
              

            </div>
            
          <div class="col-12 ">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>
        </form>
</div>
</div>
</div>
        @endsection

@section('script')
  <script>
    $(function () {
     
     var department_id = `<?php echo json_encode($current_user->dept_id ?? 0); ?>`;
    var designation_id = `<?php echo json_encode($current_user->designation_id ?? 0); ?>`;

    if(department_id !=0){
      $(document).find(".department_id").val(department_id).change();
    }    
    if(designation_id !=0){
      $(document).find(".designation_id").val(designation_id).change();
    }

   })

    
      
 $(document).on('change','.category_id',function(){
      var category_id = $(this).val();
      var url = $(this).attr('attr_url');
      
       var request = $.ajax({
          url: url,
          method: "GET",
          data: {category_id },
          async:false,
        });
         
        request.done(function( response ) {
         console.log(response)
         var data = response;
         var _search_main_ledger_id = data?.category_ledger?._name;
         var asset_ledger_id = data?.asset_ledger_id;
         var dep_rate = data?.dep_rate;
         $(document).find(".dep_rate").val(dep_rate);
         $(document).find("._search_main_ledger_id").val(_search_main_ledger_id);
         $(document).find(".asset_ledger_id").val(asset_ledger_id);

         var _search_asset_dep_ledger_id = data?.acc_dep_category_ledger?._name;
         var asset_dep_ledger_id = data?.asset_dep_ledger_id;
         $(document).find("._search_asset_dep_ledger_id").val(_search_asset_dep_ledger_id);
         $(document).find(".asset_dep_ledger_id").val(asset_dep_ledger_id);

         var _search_asset_dep_exp_ledger_id = data?.dep_exp_category_ledger?._name;
         var asset_dep_exp_ledger_id = data?.asset_dep_exp_ledger_id;
         $(document).find("._search_asset_dep_exp_ledger_id").val(_search_asset_dep_exp_ledger_id);
         $(document).find(".asset_dep_exp_ledger_id").val(asset_dep_exp_ledger_id);



        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });


    })

  //   var parent_id = <?php echo json_encode($data->category_id); ?>;
  //  $(document).find("#indented-select").val(parent_id).change();
  // var url = `{{url('basic/user_base_org_chain')}}`;
  //  var organization_id=  <?php echo json_encode($current_user->organization_id ?? 1);?>;
  //  var user_id=  <?php echo json_encode($current_user->asset_user_id ?? 0);?>;
  //  organizationWisechain(organization_id,url,user_id);

  //   $(document).on('change','.organization_id',function(){
  //     var organization_id = $(this).val();
  //     var url = $(this).attr('attr_url');
  //     var user_id =0;
  //     organizationWisechain(organization_id,url,user_id);
  //   })

  //   $(document).on('change','.asset_user_id',function(){
  //     var url = `{{url('basic/user_base_org_chain')}}`;
  //     var user_id =$(this).val();
  //     if(!user_id){return false;}
  //     user_base_org_chain(url,user_id);;

  //   })


  //   function user_base_org_chain(url,user_id){
  //     var request = $.ajax({
  //         url: url,
  //         method: "GET",
  //         data: {user_id },
  //         dataType: "html",
  //         async:false,
  //       });
         
  //       request.done(function( response ) {
  //         $( ".userWisechainBody" ).html( response );
  //       });
         
  //       request.fail(function( jqXHR, textStatus ) {
  //         alert( "Request failed: " + textStatus );
  //       });
  //   }

  //   function organizationWisechain(organization_id,url,user_id){
  //     var request = $.ajax({
  //         url: url,
  //         method: "GET",
  //         data: { organization_id,user_id },
  //         dataType: "html",
  //         async:false,
  //       });
         
  //       request.done(function( response ) {
  //         $( ".organizationWisechainBody" ).html( response );
  //       });
         
  //       request.fail(function( jqXHR, textStatus ) {
  //         alert( "Request failed: " + textStatus );
  //       });
  //   }

  </script>
@endsection