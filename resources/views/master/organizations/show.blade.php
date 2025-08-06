@extends('layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">{{__('label.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('organizations.index')}}">{{__('label.organizations')}}</a></li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ url('basic/organization-relation') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $data->_name ?? '' !!}</h2>
              <input type="hidden" name="id" value="{{$data->id}}">
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-12">
              
             
              <h4 class="mb-3">{{__('label.relation_org_brac_store_dep_desig')}}</h4>
              <div class="row g-0 border-top border-bottom border-300">
                <div class="col-sm-4">
                  <div class="nav flex-sm-column border-bottom border-bottom-sm-0 border-end-sm border-300 fs--1 vertical-tab h-100 justify-content-between" role="tablist" aria-orientation="vertical">
                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center active" id="orgBranch" data-bs-toggle="tab" data-bs-target="#orgBranchContent" role="tab" aria-controls="orgBranchContent" aria-selected="true"> <span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span><span class="d-none d-sm-inline">{{__('label.branches')}}</span></a>
                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="costCenterTab" data-bs-toggle="tab" data-bs-target="#costCenterTabContent" role="tab" aria-controls="costCenterTabContent" aria-selected="false"> <span class="me-sm-2 fs-4 nav-icons" data-feather="package"></span><span class="d-none d-sm-inline">{{__('label.cost-centers')}}</span></a>
                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="stores" data-bs-toggle="tab" data-bs-target="#storesContent" role="tab" aria-controls="storesContent" aria-selected="false"> <span class="me-sm-2 fs-4 nav-icons" data-feather="truck"></span><span class="d-none d-sm-inline">{{__('label.store-house')}}</span></a>
                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="departmentTab" data-bs-toggle="tab" data-bs-target="#departmentTabContent" role="tab" aria-controls="departmentTabContent" aria-selected="false"> <span class="me-sm-2 fs-4 nav-icons" data-feather="globe"></span><span class="d-none d-sm-inline">{{__('label.departments')}}</span></a>
                    <a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center" id="designationstab" data-bs-toggle="tab" data-bs-target="#designationstabContent" role="tab" aria-controls="designationstabContent" aria-selected="false"> <span class="me-sm-2 fs-4 nav-icons" data-feather="sliders"></span><span class="d-none d-sm-inline">{{__('label.designations')}}</span></a>
                    
                  </div>
                </div>
                @php
                $_org_branches=$data->_org_branches ?? [];
                $org_branch_ids =[];
                foreach($_org_branches as $val){
                  $org_branch_ids[]=$val->branch_id;
                }
                $_org_cost_centers=$data->_org_cost_centers ?? [];
                 $_org_cost_centers_ids =[];
                foreach($_org_cost_centers as $val){
                  $_org_cost_centers_ids[]=$val->cost_center_id;
                }
                $_org_stores=$data->_org_stores ?? [];
                 $_org_stores_ids =[];
                foreach($_org_stores as $val){
                  $_org_stores_ids[]=$val->store_id;
                }

                $_org_departments=$data->_org_departments ?? [];
                $_org_departments_ids =[];
                foreach($_org_departments as $val){
                  $_org_departments_ids[]=$val->department_id;
                }

                $_org_designations=$data->_org_designations ?? [];
                 $_org_designations_ids =[];
                foreach($_org_designations as $val){
                  $_org_designations_ids[]=$val->designation_id;
                }

                @endphp
                <div class="col-sm-8">
                  <div class="tab-content py-3 ps-sm-4 h-100">
                    <div class="tab-pane fade show active" id="orgBranchContent" role="tabpanel">
                      <h5 class="mb-3 text-1000">{{__('label.branches')}}</h5>
                      <div class="row g-3">
                        <select class="form-control" name="org_branches[]" multiple>
                          @forelse($branchs as $key=>$val)
                            <option value="{{$val->id}}" @if(in_array($val->id,$org_branch_ids)) selected @endif >{!! $val->id ?? '' !!} - {!! $val->_name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="tab-pane fade h-100" id="costCenterTabContent" role="tabpanel" aria-labelledby="costCenterTab">
                      <div class="d-flex flex-column h-100">
                        <h5 class="mb-3 text-1000">{{__('label.cost-centers')}}</h5>
                        <div class="row g-3 flex-1 mb-4">
                          <select class="form-control" name="org_cost_centers[]" multiple>
                          @forelse($costcenters as $key=>$val)
                            <option value="{{$val->id}}" @if(in_array($val->id,$_org_cost_centers_ids)) selected @endif >{!! $val->id ?? '' !!} - {!! $val->_name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                        </div>
                        
                      </div>
                    </div>
                    <div class="tab-pane fade h-100" id="storesContent" role="tabpanel" aria-labelledby="stores">
                      <div class="d-flex flex-column h-100">
                        <h5 class="mb-3 text-1000">{{__('label.store-house')}}</h5>
                        <div class="flex-1">
                        <select class="form-control" name="org_store_houses[]" multiple>
                          @forelse($storeHouses as $key=>$val)
                            <option value="{{$val->id}}" @if(in_array($val->id,$_org_stores_ids)) selected @endif >{!! $val->id ?? '' !!} - {!! $val->_name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                          
                        </div>
                        
                      </div>
                    </div>
                    <div class="tab-pane fade" id="departmentTabContent" role="tabpanel" aria-labelledby="departmentTab">
                      <h5 class="mb-3 text-1000">{{__('label.departments')}}</h5>
                      
                     
                      <div>
                        <select class="form-control" name="org_departments[]" multiple>
                          @forelse($departments as $key=>$val)
                            <option value="{{$val->id}}" @if(in_array($val->id,$_org_departments_ids)) selected @endif>{!! $val->id ?? '' !!} - {!! $val->name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                        
                      </div>
                    </div>
                    <div class="tab-pane fade" id="designationstabContent" role="tabpanel" aria-labelledby="designationstab">
                      <h5 class="mb-3 text-1000">{{__('label.designations')}}</h5>
                      
                     <select class="form-control" name="org_designations[]" multiple>
                          @forelse($designations as $key=>$val)
                            <option value="{{$val->id}}" @if(in_array($val->id,$_org_designations_ids)) selected @endif>{!! $val->id ?? '' !!} - {!! $val->_name ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                      
                      
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="col-auto mt-5">
            
            <button class="btn btn-primary mb-2 mb-sm-0" type="submit">{{__('label.save')}}</button></div>
        </form>

        @endsection

@section('script')

@endsection