@extends('backend.layouts.app')
@section('title',$page_name)

@section('style')
<style type="text/css">
  ._list_table td, th {
   
    white-space: normal !important;
}
</style>
@endsection

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
               <form  action="" method="GET">

                @csrf
                  <input type="hidden" class="_form_name" name="_form_name" value="sales_man_wise_sales_detail" />
                     @include('basic.report_date_filter')
                     @include('basic.org_report')
                    
                    <div class="row">
                            @php
$_sales_man_id = $previous_filter["_sales_man_id"] ?? '';
$_report_type = $previous_filter["_report_type"] ?? '';
                            @endphp
                              <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                              <select class="form-control _sales_man" name="_sales_man_id">
                                @if(sizeof($sales_persons) > 1)
                                <option value=""><----All {{__('label._sales_man_id')}}----></option>
                                  @endif
                                  @forelse($sales_persons as $person)
                                    <option value="{{$person->id}}" @if($_sales_man_id==$person->id) selected @endif>{!! $person->_code ?? '' !!} - {!! $person->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                              </select>
                    </div>
                    <div class="row">
                            
                              <label class="mr-2" for="_report_type">{{__('label._type')}}:</label>
                              <select class="form-control _report_type" name="_report_type">
                                <option value="1" @if($_report_type==1) selected @endif>Only Sales Amount</option>
                                <option value="2" @if($_report_type==2) selected @endif>Sales & Sales Return</option>
                                <option value="3" @if($_report_type==3) selected @endif>Sales & Return With Product Details</option>
                                <option value="4" @if($_report_type==4) selected @endif>Sales & Return Summary</option>
                              </select>
                    </div>

                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit"  class="btn btn-success mt-2 form-control mb-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href=""  class="btn btn-danger form-control mt-2 " title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
                        </div>
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>

<!-- Report Section Start  -->
@if(sizeof($datas) > 0)

@if($_report_type==1) 
@include('backend.sales_man_report.sales_man_wise_only_sales_report')

 @endif
@if($_report_type==2) 
@include('backend.sales_man_report.sales_and_sales_return')

 @endif
@if($_report_type==3) 
@include('backend.sales_man_report.sales_return_item_details')

 @endif
@if($_report_type==4) 
@include('backend.sales_man_report.sales_and_return_summary')

 @endif
  
  @endif
<!-- End of Report Data view Section -->



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

