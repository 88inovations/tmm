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
               
          
         
            <div class="card-body filter_body" style="">
               <form  action="{{url('general_balance-sheet-report')}}" method="GET">
                @csrf
                    <div class="row">
                      <div class="col-md-12">
                          <label>Up To Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_datex" class="form-control datetimepicker-input" data-target="#reservationdate" required @if(isset($previous_filter["_datex"])) value='{{$previous_filter["_datex"] }}' @endif  />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                              @if(isset($previous_filter["_datex"]))
                              <input type="hidden" name="_old_filter" class="_old_filter" value="1">
                              @else
                              <input type="hidden" name="_old_filter" class="_old_filter" value="0">
                              @endif
                        </div>
                      </div>
                      
                      <div class="col-md-12">
                          <label>Branch:</label>
                         <select id="_branch_id" class="form-control _branch_id multiple_select" name="_branch_id[]" multiple size='2' >
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" 
                            @if(isset($previous_filter["_branch_id"])) 
                               @if(in_array($branch->id,$previous_filter["_branch_id"])) selected @endif
                               @endif
                             > {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>
                      <div class="col-md-12">
                          <label>Cost Center:</label>
                         <select class="form-control width_150_px _cost_center multiple_select" multiple name="_cost_center[]" size='2'  >
                                            
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]))
                              @if(in_array($costcenter->id,$previous_filter["_cost_center"])) selected @endif
                                 @endif
                              > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                      @php
                      $levels = array('Level 1','Level 2');
                      @endphp
                      <div class="col-md-12">
                          <label>Report Level:</label>
                         <select class="form-control width_150_px _level "  name="_level"   >
                          <option value="Level 1"  @if(isset($previous_filter["_level"]))
                              @if($previous_filter["_level"] =="Level 1") selected @endif
                                 @endif>Level 1</option>
                          <option value="Level 2"  @if(isset($previous_filter["_level"]))
                              @if($previous_filter["_level"] =="Level 2") selected @endif
                                 @endif>Level 2</option>
                                            
                            
                          </select>
                      </div>


                    
                    </div>
                    <br>
                     <div class="row">
                         <select id="_with_zero" class="form-control  _with_zero " name="_with_zero"  >
                           <option value="1" @if(isset($previous_filter["_with_zero"])) @if($previous_filter["_with_zero"] ==1) selected @endif @endif >Without Zero Amount</option>
                           <option value="0" @if(isset($previous_filter["_with_zero"])) @if($previous_filter["_with_zero"] ==0) selected @endif @endif>With Zero Amount</option>
                         
                         </select>
                     </div>
                    
                    
                    
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                              <a href="{{url('general_balance-sheet-filter-reset')}}"   class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
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

    //  $('#reservationdate_2').datetimepicker({
    //     format:default_date_formate
    // });

     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
       // $(".datetimepicker-input_2").val(date__today())
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

