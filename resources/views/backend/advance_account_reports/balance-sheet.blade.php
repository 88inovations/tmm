@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card">
               @if (count($errors) > 0)
                 <div class="alert alert-danger">
                      <strong>Whoops!</strong> There were some problems with your input.<br><br>
                      <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                  </div>
              @endif
            <div class="card-header">
              
                  <h4 class="text-center">{{ $page_name ?? '' }}</h4>
            </div>
          
         
            <div class="card-body filter_body" style="">
               <form  action="{{url('balance-sheet-report')}}" method="GET">
                @csrf
                     @include('basic.report_date_filter')
                    <div class="row">
                      @include('basic.org_report')
                      
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
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('balance-sheet-filter-reset')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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

