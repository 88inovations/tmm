@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content mt-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                 <h4 class="text-center">{{ $page_name ?? '' }}</h4>
            </div>
           @include('backend.message.message')
         
            <div class="card-body" style="width: 350px;margin:0px auto;margin-bottom: 20px;">
               <form  action="{{url('all-lock')}}" method="post">
                @csrf
                    <div class="row">
                      <label>Start Date:<span class="_required">*</span></label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input" data-target="#reservationdate" required @if(isset($previous_filter["_datex"])) value='{{$previous_filter["_datex"] }}' @endif />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                         @if(isset($previous_filter["_datex"]))
                              <input type="hidden" name="_old_filter" class="_old_filter" value="1">
                              @else
                              <input type="hidden" name="_old_filter" class="_old_filter" value="0">
                              @endif
                    </div>
                    <div class="row">
                      <label>End Date:<span class="_required">*</span></label>
                        <div class="input-group date" id="reservationdate_2" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_2" data-target="#reservationdate_2" required @if(isset($previous_filter["_datey"])) value='{{$previous_filter["_datey"] }}' @endif />
                                      <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                    </div>
                    <div class="">
                    <div class="row  ">
                      <label>Branch:<span class="_required">*</span></label><br> </div>
                     <div class="row ">
                         <select id="_branch_id" required class="form-control _branch_id multiple_select" name="_branch_id[]" multiple size='2' >
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" @if(isset($previous_filter["_branch_id"])) 
                               @if(in_array($branch->id,$previous_filter["_branch_id"])) selected @endif
                               @endif >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                     </div>
                   </div>
                    <div class="">
                    <div class="row  ">
                      <label>Cost Center:<span class="_required">*</span></label><br> </div>
                     <div class="row ">
                         <select class="form-control width_150_px _cost_center multiple_select" required multiple name="_cost_center[]" size='2'  >
                                            
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]))
                              @if(in_array($costcenter->id,$previous_filter["_cost_center"])) selected @endif
                                 @endif > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                     </div>
                  </div>
                    <div class="row">
                      <label>Transection Type:<span class="_required">*</span></label><br>
                    </div>
                     <div class="row">
                         <select class="form-control" name="_table_name" required>
                           <option value="">Select</option>
                           @foreach($tables as $key=>$val )
                              <option value="{{$key}}" @if(isset($previous_filter["_table_name"]))
                              @if($key==$previous_filter["_table_name"]) selected @endif
                                 @endif >{{$val}}</option>
                           @endforeach
                         </select>
                      </div>
                    <div class="row">
                      <label>Action Type:<span class="_required">*</span></label><br>
                    </div>
                     <div class="row">
                         <select class="form-control" name="_action" required>
                           <option value="1" @if(isset($previous_filter["_action"]))
                              @if(1==$previous_filter["_action"]) selected @endif
                                 @endif >Lock</option>
                           <option value="0" @if(isset($previous_filter["_action"]))
                              @if(0==$previous_filter["_action"]) selected @endif
                                 @endif>Unlock </option>
                           
                         </select>
                      </div>
                     
                     <div class="row mt-5">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Submit</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('lock-reset')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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

