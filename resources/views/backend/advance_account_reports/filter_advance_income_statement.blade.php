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
              <div class="row">
                <div class="col-sm-7 text-right">
                  <h4>{{ $page_name ?? '' }}</h4>
                </div>
                <div class="col-sm-5 text-right" >
                  @can('income-statement-settings')
                  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  <i class="fa fa-cog" aria-hidden="true"></i> 
                </button>
                @endcan
                 
                </div>
              </div>
                
             
            </div>
          
         
            <div class="card-body filter_body" style="">
               <form  action="{{url('advance_income_statement_report')}}" method="POST">
                @csrf
                    @include('basic.report_date_filter')
                      <div class="row">
                         @include('basic.org_report')
                      </div>
                      
                      @php
$levels =[1,2,3,4,5];
$_level_id = $previous_filter["_level"] ?? 1 ;
                      @endphp
                      <div class="col-md-12">
                          <label>Report Level:</label>
                         <select class="form-control width_150_px  "  name="_level_id"  >
                          @foreach($levels as $level)
                            <option value="{{$level}}" @if($_level_id ==$level) selected @endif >Level {{$level}}</option>
                          @endforeach
                           <option value="6" >Only Group & Ledger [Lavel 6]</option>
                          </select>
                      </div>

                    
                    </div>
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('income-statement-filter-reset')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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
<div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
           <form action="{{url('income-statement-settings')}}" method="post">
            @csrf
          <div class="modal-content">
           
            <div class="modal-header">
              <h4 class="modal-title">Income Statement Settings</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th class="text-right">Show</th>
                  </tr>
                  @forelse($_filter_ledgers as $key=>$value)
                  <tr >
                    <th  colspan="2">{{$key}}</th>
                  </tr>
                      @forelse($value as $v_key=>$led)
                        <tr class="@if($led->_show==0) _nv_warning @endif">
                          <th>
                            <input type="hidden" name="_l_id[]" value="{{$led->id}}">
                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $led->_name ?? '' }}
                          </th>
                          <th class="text-right  " >
                            <select class="form-control" name="_show[]">
                              <option value="1" @if($led->_show==1) selected @endif >Show</option>
                              <option value="0" @if($led->_show==0) selected @endif >Hide</option>
                            </select>
                          </th>
                        </tr>
                      @empty
                      @endforelse
                  @empty
                  @endforelse

                </thead>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


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

