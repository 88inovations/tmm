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
            <li class="breadcrumb-item"><a href="{{route('asset-entry-assign.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
       
           <form class="mb-9" method="POST" action="{{ route('assign_to_user') }}" enctype='multipart/form-data'>
        @csrf
       
          <div class="row g-3 flex-between-end ">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>

          <div class="container">
              <div class="row">
                <div class="col-md-3">
                    <h5 class="mb-1 text-1000 ">Asset Enty ID</h5>
                     <input type='text' name="asset_item_id" class="form-control" value="{{$data->id ?? '' }}" readonly>
                </div>
                <div class="col-md-3">
                         <label class="text-1000">Asset ID<span class="_required">*</span></label><br>
                           
                              <input type="text" name="_item_id" class="form-control _item_id" value="{!! old('_item_id',$data->_item_id ?? '') !!}" placeholder="{{__('label._item_id')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                        <h5 class="text-1000">{{__('label.device_name')}}<span class="_required">*</span></h5>
                              <input type="text" name="name" class="form-control" value="{!! old('name',$data->name ?? '') !!}" placeholder="{{__('label.device_name')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.asset_tag')}}</h5>
                              <input type="text" name="asset_tag" class="form-control" value="{{old('asset_tag',$data->asset_tag ?? '')}}" placeholder="{{__('label.asset_tag')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                        <h5 class="mb-1 text-1000">{{__('label.asset_code')}}</h5>
                      <input type="text" name="asset_code" class="form-control" value="{{old('asset_code',$data->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.model_no')}}</h5>
                              <input type="text" name="model_no" class="form-control" value="{{old('model_no',$data->model_no ?? '' )}}" placeholder="{{__('label.model_no')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                        <h5 class="mb-1 text-1000">{{__('label.serial_no')}}</h5>
                              <input type="text" name="serial_no" class="form-control" value="{{old('serial_no',$data->serial_no ?? '' )}}" placeholder="{{__('label.serial_no')}}" readonly> 
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                      <h5 class="mb-1 text-1000">{{__('label.status')}}</h5>
                            
                              <select name="status" class="form-control" id="status">
                                 @forelse(common_status() as $key=>$val)
                                <option value="{{$key}}" @if($data->status==$key) selected @endif >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>
                  </div><!-- End of col-md-3 -->
                <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.asset-category')}}<span class="_required">*</span></h5>
                       <input type='hidden' name="id" class="form-control" value="{{$data->id ?? '' }}" readonly>
                      
                    
                    <select id="indented-select" class="form-control @error('category_id') is-invalid @enderror"  
                      name="category_id"  >
                                  <option value="">{{__('label.parent-category')}}</option>
                                    <?php
                                    $html = '';
                                    function generateOptions($category_resize_data, $indent = 0) {
                                        foreach ($category_resize_data as $key => $value) {
                                            echo '<option value="' . $value['id'] . '">' . str_repeat('-', $indent * 2) . $value['id'].'-' .$value['_name']. '</option>';
                                            if (is_array($value['children']) && !empty($value['children'])) {
                                                generateOptions($value['children'], $indent + 1);
                                            }
                                        }
                                    }
                                    
                                    generateOptions($tree);
                                    ?>
                                </select>
                  </div> <!-- End of col-md-3 -->
                  <div class="col-md-3">
                      <h5 class="mb-1 text-1000">{{__('label.asset_ledger_id')}}<span class="_required">*</span></h5>
                    
                   
                                        <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->category_ledger->_name ?? '')}}" placeholder="{{__('label.asset_ledger_id')}}"  attr_url="{{url('main-ledger-search')}}"  readonly>

                                        <input type="hidden" id="asset_ledger_id" name="asset_ledger_id" class="form-control asset_ledger_id" value="{{old('asset_ledger_id',$data->asset_ledger_id ?? '')}}"  >
                                        <div class="search_box_main_ledger"> </div>
                                
                        </div> <!-- End of Col-md-3 -->
                  
                  
                  <div class="col-md-3">
                    <h5 class="mb-1 text-1000">{{__('label.asset-brand')}}</h5>
                              <select class="form-control" name="brand_id">
                                <option value="">{{__('label.select_asset_brand')}}</option>
                                @forelse($ass_brands as $val)
                                <option value="{{$val->id}}" @if($val->id==$data->brand_id) selected @endif>{!! $val->_code ?? '' !!}-{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                      
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                    <h5 class="mb-1 text-1000">{{__('label.asset-condition')}}</h5>
                              <select class="form-control" name="asset_condition_id">
                                <option value="">{{__('label.select_asset-condition')}}</option>
                                @forelse($ass_conditions as $val)
                                <option value="{{$val->id}}" @if($val->id==$data->asset_condition_id) selected @endif >{!! $val->code ?? '' !!}-{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                      
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                       <h5 class="mb-1 text-1000 _required">{{__('label.assign-status')}}</h5>
                              <select class="form-control" name="assign_status_id">
                                 <option value="0">Select Assign Status</option>
                                @forelse($assign_status as $key=>$val)
                                <option value="{{$val->id}}" @if($data->assign_status_id==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                  </div><!-- End of col-md-3 -->
                  </div>
                  <div class="row " style="background: #cad5d052;padding: 10px;">
                  <div class="col-md-3">
                      <h5 class="mb-1 text-1000 _required">{{__('label.assign_date')}}</h5>
                             <input type="hidden" name="asset_assigns_id" value="{!! $current_user->id ?? 0  !!}">
                              <input type="date" name="assign_date" class="form-control" placeholder="{{__('label.assign_date')}}" value="{{old('assign_date',$current_user->assign_date ?? '' )}}" required>
                  </div><!-- End of col-md-3 -->

                  <div class="col-md-6">
                      <h5 class="mb-1 text-1000">{{__('label.asset_user_id')}}</h5>
                      <select class="form-control asset_user_id select2" name="asset_user_id" >
                        <option value="">Select Employee</option>
                        @forelse($ass_users as $ass_key=>$ass_val)
                          <option 

                          value="{{ $ass_val->id ?? '' }}"

                          attr__employee_cat_id="{!! $ass_val->_employee_cat->id ?? '' !!}"
                          attr__employee_cat_name="{!! $ass_val->_employee_cat->_name ?? '' !!}"

                          attr__emp_department_id="{!! $ass_val->_emp_department->id ?? '' !!}"
                          attr__emp_department_name="{!! $ass_val->_emp_department->_name ?? '' !!}"
                          
                          attr__emp_designation_id="{!! $ass_val->_emp_designation->id ?? '' !!}"
                          attr__emp_designation_name="{!! $ass_val->_emp_designation->_name ?? '' !!}"
                          
                          attr__emp_grade_id="{!! $ass_val->_emp_grade->id ?? '' !!}"
                          attr__emp_grade_name="{!! $ass_val->_emp_grade->_name ?? '' !!}"
                          
                          attr__branch_id="{!! $ass_val->_branch->id ?? '' !!}"
                          attr__branch_name="{!! $ass_val->_branch->_name ?? '' !!}"
                          attr__cost_center_id="{!! $ass_val->_cost_center->id ?? '' !!}"
                          attr__cost_center_name="{!! $ass_val->_cost_center->_name ?? '' !!}"
                          attr__organization_id="{!! $ass_val->_organization->id ?? '' !!}"
                          attr__organization_name="{!! $ass_val->_organization->_name ?? '' !!}"



                            >{{ $ass_val->_code ?? '' }}-{{ $ass_val->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                  </div>
 <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.organization_id')}}</h5>
                              <input type="hidden" name="organization_id" class="form-control organization_id" value="{{old('organization_id',$current_user->organization_id ?? '' )}}" placeholder="{{__('label.organization_id')}}" readonly>
                              <input type="text" name="organization_id_name" class="form-control organization_id_name" value="{{old('organization_id_name')}}" placeholder="{{__('label.organization_id')}}" readonly>
                  </div><!-- End of col-md-3 -->
 <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.branch_id')}}</h5>
                              <input type="hidden" name="branch_id" class="form-control branch_id" value="{{old('branch_id',$current_user->branch_id ?? '' )}}" placeholder="{{__('label.branch_id')}}" readonly>
                              <input type="text" name="branch_id_name" class="form-control branch_id_name" value="{{old('branch_id_name' )}}" placeholder="{{__('label.branch_id')}}" readonly>
                  </div><!-- End of col-md-3 -->
 <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.dept_id')}}</h5>
                              <input type="hidden" name="dept_id" class="form-control dept_id" value="{{old('dept_id',$current_user->dept_id ?? '' )}}" placeholder="{{__('label.dept_id')}}" readonly>
                              <input type="text" name="dept_id_name" class="form-control dept_id_name" value="{{old('dept_id_name' )}}" placeholder="{{__('label.dept_id')}}" readonly>
                  </div><!-- End of col-md-3 -->
 <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.designation_id')}}</h5>
                              <input type="hidden" name="designation_id" class="form-control designation_id" value="{{old('designation_id',$current_user->designation_id ?? '' )}}" placeholder="{{__('label.designation_id')}}" readonly>
                              <input type="text" name="designation_id_name" class="form-control designation_id_name" value="{{old('designation_id_name' )}}" placeholder="{{__('label.designation_id')}}" readonly>
                  </div><!-- End of col-md-3 -->
 <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.project_id')}}</h5>
                              <input type="hidden" name="project_id" class="form-control project_id" value="{{old('project_id',$current_user->project_id ?? '' )}}" placeholder="{{__('label.project_id')}}" readonly>
                              <input type="text" name="project_id_name" class="form-control project_id_name" value="{{old('project_id_name' )}}" placeholder="{{__('label.project_id')}}" readonly>
                  </div><!-- End of col-md-3 -->


                


                  <div class="col-md-3">
                       <h5 class="mb-1 text-1000">{{__('label.group_serial_no')}}</h5>
                              <input type="text" name="group_serial_no" class="form-control" value="{{old('group_serial_no',$current_user->group_serial_no ?? '' )}}" placeholder="{{__('label.group_serial_no')}}" readonly>
                  </div><!-- End of col-md-3 -->
                  
                  <div class="col-md-3">
                      <label for="asset_location_id">{{__('label.asset-location')}}</label>
                             <select class="form-control asset_location_id" id="asset_location_id" name="asset_location_id" >
                                <option value="">{{__('label.select_asset-location')}}</option>
                                 @forelse($ass_buildings as $key=>$val)
                                    <option value="{{$val->id}}"
                                    @if(isset($current_user->asset_location_id) && $current_user->asset_location_id==$val->id) selected @endif >{!!$val->code ?? '' !!}-{!!$val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                        </select>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                        <label for="asset_room_id">{{__('label.asset-actual-location')}}</label>
                             <select class="form-control asset_room_id" id="asset_room_id" name="asset_room_id">
                                <option value="">{{__('label.select_asset-actual-location')}}</option>
                                 @forelse($ass_rooms as $key=>$val)
                                    <option value="{{$val->id}}"
                                    @if(isset($current_user->asset_room_id) && $current_user->asset_room_id==$val->id) selected @endif >{!!$val->code ?? '' !!}-{!!$val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                        </select>
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                      <label for="asset_floor">{{__('label.asset_floor')}}</label>
                             <input class="form-control" type="text" name="asset_floor" placeholder="{{__('label.asset_floor')}}" value="{{old('asset_floor',$ass_user->asset_floor ?? '' )}}">
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                      <label for="assign_remarks">{{__('label.assign_remarks')}}</label>
                             <input class="form-control" type="text" name="assign_remarks" placeholder="{{__('label.assign_remarks')}}" value="{{old('assign_remarks',$ass_user->assign_remarks ?? '' )}}">
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                       <h5 class="mb-0 text-1000 me-2">{{__('label.status')}}</h5>
                       <select name="assign_status" class="form-control" id="assign_status">
                                 @forelse(common_status() as $key=>$val)
                                <option value="{{$key}}" @if($data->status==$key) selected @endif >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>

                  </div><!-- End of col-md-3 -->
                  <div class="col-md-3">
                      <h5 class="mb-1 text-1000">{{__('label.inspection_date')}}</h5>
                             <input  class="form-control" type="date" name="inspection_date" value="{{old('inspection_date',$ass_user->inspection_date ?? '')}}" placeholder="{{__('label.inspection_date')}}" >
                  </div><!-- End of col-md-3 -->
                  <div class="col-md-12">
                      <table class="table">
                        @php

                        $_inspections = $data->_inspections ?? [];
                        @endphp
                        @forelse($inspection_cats as $key=>$val)
                        @php
                            $ins_lists = $val->check_list ?? [];
                        @endphp
                       <tr>
                           <td colspan="3"><b>{!! $val->name ?? '' !!}</b></td>
                       </tr>
                        @forelse($ins_lists as $list_val)
                          <tr>
                              <td>
                                  <input type="hidden" name="inspect_list_id[]" value="{{$list_val->id}}">

                                  <input type="hidden" name="inspect_row_id[]" value="{{inspection_row_id($_inspections,$list_val->id)}}">
                                  {!! $list_val->name ?? '' !!}
                              </td>
                              <td>

                                <input id="is_check_list__{{$list_val->id}}"  type="checkbox" {{inspection_checkOrNot($_inspections,$list_val->id)}}   onchange="updateCheckboxValue($(this))"  >
                               <input type="hidden" class="display_checkbox"  name="chek_list_chek[]" value="{{inspection_checkOrNotWithVal($_inspections,$list_val->id)}}">
                             <td>
                              <td>
                                  <input class="form-control" type="text" name="inspect_remarks[]" placeholder="{{__('label.remarks')}}" value="{{inspection_remarks($_inspections,$list_val->id)}}">
                              </td>
                          </tr>
                        @empty
                        @endforelse
                          @empty
                          @endforelse
                      </table>
                  </div><!-- End of col-md-12 -->

                   <div class="col-md-6">
                             <h5 class="mb-1 text-1000">{{__('label.remarks')}}</h5>
                             
                             <textarea class="form-control " name="inspection_remarks">{{old('inspection_remarks',$current_user->inspection_remarks ?? '')}}</textarea>
                        </div>
                      <div class="col-md-6">
                             <h5 class="mb-1 text-1000">{{__('label.inspector_information')}}</h5>
                             <textarea class="form-control " name="inspector_information">{{old('inspector_information',$current_user->inspector_information ?? '')}}</textarea>
                             
                        </div>

                         <div class="col-md-3">
                            <h4 class="mb-3">{{__('label.asset_image_1')}}</h4>
                            <input type="file" name="asset_image_1" class="form-control" accept="image/*" onchange="loadFile(event,1 )">
                            <img id="output_1"  style="width: 150px;" class="inputImageDisplay"  src="" />
                        </div>
                        <div class="col-md-3">
                            <h4 class="mb-3">{{__('label.asset_image_2')}}</h4>
                            <input type="file" name="asset_image_2" class="form-control" accept="image/*" onchange="loadFile(event,2 )">
                            <img id="output_2"  style="width: 150px;"  class="inputImageDisplay"  src="" />
                        </div>
              </div><!-- End of Row -->
          </div><!-- End of Container -->
         
              

            </div>
            
          <div class="col-12 mt-5 mb-5">
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
     $('.summernote').summernote(); 
     var department_id = `<?php echo json_encode($current_user->dept_id ?? 0); ?>`;
    var designation_id = `<?php echo json_encode($current_user->designation_id ?? 0); ?>`;

    if(department_id !=0){
      $(document).find(".department_id").val(department_id).change();
    }    
    if(designation_id !=0){
      $(document).find(".designation_id").val(designation_id).change();
    }

   })

    
      

    var parent_id = <?php echo json_encode($data->category_id); ?>;
   $(document).find("#indented-select").val(parent_id).change();
  var url = `{{url('basic/user_base_org_chain')}}`;
   var organization_id=  <?php echo json_encode($current_user->organization_id ?? 1);?>;
   var user_id=  <?php echo json_encode($current_user->asset_user_id ?? 1);?>;
//   organizationWisechain(organization_id,url,user_id);

    $(document).on('change','.organization_id',function(){
      var organization_id = $(this).val();
      var url = $(this).attr('attr_url');
      var user_id =0;
      organizationWisechain(organization_id,url,user_id);
    })

    $(document).on('change','.asset_user_id',function(){
      var url = `{{url('basic/user_base_org_chain')}}`;
      var user_id =$(this).val();

      var attr__employee_cat_id = $(this).find(':selected').attr('attr__employee_cat_id');
      var attr__employee_cat_name = $(this).find(':selected').attr('attr__employee_cat_name');
      var attr__emp_department_id = $(this).find(':selected').attr('attr__emp_department_id');
      var attr__emp_department_name = $(this).find(':selected').attr('attr__emp_department_name');
      var attr__emp_designation_id = $(this).find(':selected').attr('attr__emp_designation_id');
      var attr__emp_designation_name = $(this).find(':selected').attr('attr__emp_designation_name');
      var attr__emp_grade_id = $(this).find(':selected').attr('attr__emp_grade_id');
      var attr__emp_grade_name = $(this).find(':selected').attr('attr__emp_grade_name');
      var attr__branch_id = $(this).find(':selected').attr('attr__branch_id');
      var attr__branch_name = $(this).find(':selected').attr('attr__branch_name');
      var attr__cost_center_id = $(this).find(':selected').attr('attr__cost_center_id');
      var attr__cost_center_name = $(this).find(':selected').attr('attr__cost_center_name');
      var attr__organization_id = $(this).find(':selected').attr('attr__organization_id');
      var attr__organization_name = $(this).find(':selected').attr('attr__organization_name');
      console.log(attr__organization_name)

      $(document).find(".organization_id").val(attr__organization_id);
      $(document).find(".organization_id_name").val(attr__organization_name);
      $(document).find(".branch_id").val(attr__branch_id);
      $(document).find(".branch_id_name").val(attr__branch_name);
      $(document).find(".dept_id").val(attr__emp_department_id);
      $(document).find(".dept_id_name").val(attr__emp_department_name);
      $(document).find(".designation_id").val(attr__emp_designation_id);
      $(document).find(".designation_id_name").val(attr__emp_designation_name);
      $(document).find(".project_id").val(attr__cost_center_id);
      $(document).find(".project_id_name").val(attr__cost_center_name);















      if(!user_id){return false;}
    //  user_base_org_chain(url,user_id);;



    })


    function user_base_org_chain(url,user_id){
      var request = $.ajax({
          url: url,
          method: "GET",
          data: {user_id },
          dataType: "html",
          async:false,
        });
         
        request.done(function( response ) {
          $( ".userWisechainBody" ).html( response );
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
    }

    function organizationWisechain(organization_id,url,user_id){
      var request = $.ajax({
          url: url,
          method: "GET",
          data: { organization_id,user_id },
          dataType: "html",
          async:false,
        });
         
        request.done(function( response ) {
          $( ".organizationWisechainBody" ).html( response );
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
    }

  </script>
@endsection