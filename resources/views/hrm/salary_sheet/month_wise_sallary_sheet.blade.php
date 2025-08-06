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
                    <a class="m-0 _page_name" href="{{ url('report-panel') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
         <div class="message-area">
    @include('backend.message.message')
    </div>
            <div class="card-body p-4" >
                {!! Form::open(array('url' => 'month_wise_salary_sheet_report','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                
                        
                      @php
                        $users = \Auth::user();
                        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
                        $permited_branch = permited_branch(explode(',',$users->branch_ids));
                        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
                        @endphp 
 <div class="form-group row">
<label class="col-sm-2 col-form-label _required" >{{__('label._month')}}:</label>
                            <div class="col-md-2">
                                <select class="form-control _month" name="_month" required>
                                    <option value="">{{__('label.select')}}</option>
                                    @forelse(_month_names() as $month_key=>$month)
                                    <option value="{{$month_key}}">{{$month ?? '' }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
</div>
         <div class="form-group row">
                    <label class="col-sm-2 col-form-label _required" >{{__('label._year')}}:</label>
                             <div class="col-sm-2">
                                <select name="_year" class="form-control" required>
    <?php
    // Get the current year
    $currentYear = date('Y');

    // Display the last two years
    for ($i = 2; $i > 0; $i--) {
        $year = $currentYear - $i;
        echo "<option value='$year'>$year</option>";
    }

    // Display the current year
    echo "<option value='$currentYear' selected>$currentYear</option>";

    // Display the next year
    $nextYear = $currentYear + 1;
    echo "<option value='$nextYear'>$nextYear</option>";
    ?>
</select>

                            </div>
                        </div>
                         <div class="form-group row">
                             <label class="col-md-2">{!! __('label.organization') !!}:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5 ">
                            <select class="form-control _master_organization_id" name="organization_id"  >
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
                            <select class="form-control _master_branch_id" name="_branch_id"  >
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
                             <label class="col-md-2">{{__('label.Cost center')}}:<span class="_required">*</span></label>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <select class="form-control _cost_center_id" name="_cost_center_id"  >
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
                        
                            
                      
                
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-4 mb-4  text-middle">
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

