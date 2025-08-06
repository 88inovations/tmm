@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')


<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('date-wise-invoice-print-report')}}" method="POST" target="__blank">
                @csrf
                 @include('basic.report_date_filter')
                 
                    <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group ">
                            <label>{!! __('label.organization') !!}:</label>
                            <select  class="form-control _master_organization_id " name="organization_id"  >
                              <option value="all">All {!! __('label.organization') !!}</option>
                             @forelse($permited_organizations as $val )
                             <option value="{{$val->id}}"  @if(isset($previous_filter["organization_id"])) 
                                             @if($val->id==$previous_filter["organization_id"]) selected @endif
                                             @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                             @empty
                             @endforelse
                            </select>
                            </div>
                            </div>

                      <div class="col-md-12">
                        <label>{{__('label._branch_id')}}: <span class="_required">*</span></label>
                        <select id="_branch_id" class="form-control _branch_id multiple_select" name="_branch_id"   required>
                          <option value="all">All {{__('label._branch_id')}}</option>
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" 
                            @if(isset($previous_filter["_branch_id"])) 
                               @if($branch->id==$previous_filter["_branch_id"]) selected @endif
                               @endif
                             >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>

                      <div class="col-md-12">
                        <label>{{__('label._cost_center_id')}}:</label>
                         <select class="form-control width_150_px _cost_center "  name="_cost_center"   >
                             <option value="all">All {{__('label._cost_center_id')}}</option>      
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]))
                              @if($costcenter->id==$previous_filter["_cost_center"]) selected @endif
                                 @endif
                              > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>

                    </div>
                    
                     <div class="row">
                      <label>{{__('label._sales_man_id')}}:</label><br></div>
                     <div class="row">
                         <select id="_sales_man_id" class="form-control  _sales_man_id " name="_sales_man_id"  >
                          <option value="all">All {{__('label._sales_man_id')}}</option>
                           @forelse($sales_mans as $sales_man)
                           <option value="{{$sales_man->id}}" @if(isset($previous_filter["_sales_man_id"])) @if($sales_man->id==$previous_filter["_sales_man_id"]) selected @endif  @endif>{{$sales_man->_name}}</option>
                           @empty
                           @endforelse
                          
                         </select>
                     </div>
                     <br>
                     <div class="row">
                      <label>{{__('label._delivery_man_id')}}:</label><br></div>
                     <div class="row">
                         <select id="_delivery_man_id" class="form-control  _delivery_man_id " name="_delivery_man_id" >
                          <option value="all">All {{__('label._delivery_man_id')}}</option>
                           @forelse($delivery_mans as $_delivery_man)
                           <option value="{{$_delivery_man->id}}" @if(isset($previous_filter["_delivery_man_id"])) @if($_delivery_man->id==$previous_filter["_delivery_man_id"]) selected @endif  @endif>{{$_delivery_man->_name}}</option>
                           @empty
                           @endforelse
                          
                         </select>
                     </div>
                     <br>
                     <div class="row">
                      <label>{{__('label._user_id')}}:</label><br></div>
                     <div class="row">
                         <select id="_name" class="form-control  _name " name="_name"   >
                         <option value="all">All {{__('label._user_id')}}</option>
                           @forelse($users_info as $user)
                           <option value="{{$user->name}}" @if(isset($previous_filter["_name"])) @if($user->name==$previous_filter["_name"]) selected @endif  @endif>{{$user->name}}</option>
                           @empty
                           <option value="{{Auth::user()->name}}" >{{Auth::user()->name}}</option>
                           @endforelse
                          
                         </select>
                     </div>
                     <br>
                  
                
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                               
                                      <a href="{{url('user-wise-collection-payment-filter-reset')}}"     class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
                        </div>
                        <br><br>
                     </div>

                 
                 
                    
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


 
    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }
     
     


     function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            
          }
     

  })

  

 

  



        

         

</script>
@endsection

