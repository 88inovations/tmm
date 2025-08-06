@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="{{ url('salary_sheet_list') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
         <div class="message-area">
    @include('backend.message.message')
    </div>
            <div class="card-body p-4" >


{!! Form::open(array('route' => 'sallary_sheet_report','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                
                        
                      @php
                        $users = \Auth::user();
                        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                        $permited_branch = permited_branch(explode(',',$users->branch_ids));
                        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                        @endphp 


                         <div class="form-group row">
                             <label class="col-md-2">{!! __('label.organization') !!}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_organization_id" name="organization_id" required >
                                @if(sizeof($permited_organizations) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               
                               @forelse($permited_organizations as $val )
                               <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Branch')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_branch_id" name="_branch_id" required >
                               @if(sizeof($permited_branch) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_branch as $branch )
                               <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{{__('label.Cost center')}}:</label>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <select class="form-control _cost_center_id" name="_cost_center_id" required >
                               @if(sizeof($permited_costcenters) > 1) 
                                <option value="">--Select--</option>
                                 @endif
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label.employee_category_id') !!}:</label>
                            <div class="col-md-5" style="display: flex;">
                                <select class="form-control _sub_category_id" name="_category_id" required>
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($employee_catogories as $val)
                                  <option value="{{$val->id}}" @if(old('_category_id')==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._department_id') !!}:</label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_department_id" name="_department_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($departments as $val)
                                  <option value="{{$val->id}}" @if(old('_department_id')==$val->id) selected @endif>{!! $val->_department ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._jobtitle_id') !!}:</label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_jobtitle_id" name="_jobtitle_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($designations as $val)
                                  <option value="{{$val->id}}" @if(old('_jobtitle_id')==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                            <div class="form-group row">
                                <label class="col-md-2">{!!__('label._grade_id') !!}:</label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_grade_id" name="_grade_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($grades as $val)
                                  <option value="{{$val->id}}" @if(old('_grade_id')==$val->id) selected @endif>{!! $val->_grade ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._location') !!}:</label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_location" name="_location"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_locations as $val)
                                  <option value="{{$val->id}}" @if(old('_location')==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label class="col-md-2">{!!__('label._zone_id') !!}:</label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_zone_id" name="_zone_id"  >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($job_zones as $val)
                                  <option value="{{$val->id}}" @if(old('_zone_id')==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                        </div>
                        
                         
                </div>
                     
                      
                      
                      
                      
                
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.report')}}</button>
                           
                        </div>
                        <br><br>
                    
                 
                    
                    
                     
                    {!! Form::close() !!}


                     </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript"> 

</script>
@endsection