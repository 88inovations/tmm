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
       
           <form class="mb-9" method="post" action="{{ url('asset-management/return-receive') }}" enctype='multipart/form-data'>
        @csrf
        
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          
                
                @php
                

                @endphp
                <div class="col-sm-12">
                 <div class="row">
                     <div class="col-md-12">

                        @php
$_employee = $current_user->_user ?? '';
                        @endphp
                         <table class="table table-bordered">
                             <tr>
                                 <td>Employee ID</td>
                                 <td>{!! $_employee->_code ?? '' !!}</td>
                                 <td>Employee Name</td>
                                 <td>{!! $_employee->_name ?? '' !!}</td>
                             </tr>
                             <tr>
                                 <td>{{__('label.organization_id')}}</td>
                                 <td>{!! $current_user->organization->_name ?? '' !!}</td>
                                 <td>{!! __('label._branch_id') !!}</td>
                                 <td>{!! $current_user->branch->_name ?? '' !!}</td>
                             </tr>
                             <tr>
                                 <td>{{__('label._department_id')}}</td>
                                 <td>{!! $current_user->department->_name ?? '' !!}</td>
                                 <td>{!! __('label._cost_center_id') !!}</td>
                                 <td>{!! $current_user->cost_center->_name ?? '' !!}</td>
                             </tr>
                             <tr>
                                 <td>{{__('label.asset_location_id')}}</td>
                                 <td>{!! $current_user->building->name ?? '' !!}</td>
                                 <td>{!! __('label.asset_room_id') !!}</td>
                                 <td>{!! $current_user->room->name ?? '' !!}</td>
                             </tr>
                         </table>
                     </div>
                 </div>
                   
                      <div class="row g-3">
                         <div class="col-md-3">
                            <input type="hidden" name="asset_row_id" value="{{$data->id}}">
                             <h5 class="mb-1 text-1000 _required">{{__('label.return_date')}}<span class="_required">*</span></h5>
                              <input type="date" name="return_date" class="form-control" value="{!! old('return_date',$data->return_date ?? '') !!}" placeholder="{{__('label.return_date')}}" required>
                        </div>
                       
                         <div class="col-md-3">
                             <label for="assign_remarks">{{__('label.remarks')}}</label>
                             <input class="form-control" type="text" name="assign_remarks" placeholder="{{__('label.remarks')}}" value="{{old('assign_remarks',$ass_user->assign_remarks ?? '' )}}">
                        
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
                            <label class="text-1000 _required">{{__('label.assign-status')}}</label><br>
                            <div >
                             <select class="form-control" name="assign_status_id" required>
                                 <option value="0">Select Assign Status</option>
                                @forelse($assign_status as $key=>$val)
                                <option value="{{$val->id}}" @if($data->assign_status_id==$val->id) selected @endif >{!! $val->name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.status')}}</label><br>
                            <div>
                              <select name="status" class="form-control" id="status">
                                 @forelse(common_status() as $key=>$val)
                                <option value="{{$key}}" @if($data->status==$key) selected @endif >{{$val}}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>

                       <div class="col-md-1">
                            <label class="text-1000">{{__('label._item_id')}}<span class="_required">*</span></label><br>
                            <div >
                              <input type="text" name="_item_id" class="form-control _item_id" value="{!! old('_item_id',$data->_item_id ?? '') !!}" placeholder="{{__('label._item_id')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-1000">{{__('label._name')}}<span class="_required">*</span></label><br>
                            <div >
                              <input type="text" name="name" class="form-control name_of_asset" value="{!! old('name',$data->name ?? '') !!}" placeholder="{{__('label._name')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.asset_tag')}}</label><br>
                            <div >
                             <input type="text" name="asset_tag" class="form-control" value="{{old('asset_tag',$data->asset_tag ?? '')}}" placeholder="{{__('label.asset_tag')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.asset_code')}}</label><br>
                            <div >
                             <input type="text" name="asset_code" class="form-control" value="{{old('asset_code',$data->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.model_no')}}</label><br>
                            <div >
                             <input type="text" name="model_no" class="form-control" value="{{old('model_no',$data->model_no ?? '' )}}" placeholder="{{__('label.model_no')}}" readonly>
                                </div>
                        </div>
                        <div class="col-md-2">
                            <label class="text-1000">{{__('label.serial_no')}}</label><br>
                            <div >
                             <input type="text" name="serial_no" class="form-control" value="{{old('serial_no',$data->serial_no ?? '' )}}" placeholder="{{__('label.serial_no')}}" readonly>
                                </div>
                        </div>
                    </div>

                    <div class="row">
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
                        </div>
              </div><!-- End of Row -->
               
            </div>          
              

           
            
          <div class="col-md-12 mb-5 mt-5">
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
    // $('.summernote').summernote(); 
     var department_id = `<?php echo json_encode($ass_user->dept_id ?? 0); ?>`;
    var designation_id = `<?php echo json_encode($ass_user->designation_id ?? 0); ?>`;

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
   var organization_id=  <?php echo json_encode($ass_user->organization_id ?? 1);?>;
   var user_id=  <?php echo json_encode($ass_user->asset_user_id ?? 1);?>;
 //  organizationWisechain(organization_id,url,user_id);

    $(document).on('change','.organization_id',function(){
      var organization_id = $(this).val();
      var url = $(this).attr('attr_url');
      var user_id =0;
      organizationWisechain(organization_id,url,user_id);
    })

    $(document).on('change','.asset_user_id',function(){
      var url = `{{url('basic/user_base_org_chain')}}`;
      var user_id =$(this).val();
      if(!user_id){return false;}
      user_base_org_chain(url,user_id);;

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