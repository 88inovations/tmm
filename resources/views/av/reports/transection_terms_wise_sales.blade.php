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
          
         @php

$_payment_terms      = $request->_payment_terms ?? '';
$group_by            = $request->group_by ?? '';
$_search_main_ledger_id = $request->_search_main_ledger_id ?? '';
$_ledger_id = $request->_ledger_id ?? '';
$_sales_man_id = $request->_sales_man_id ?? '';
         @endphp
            <div class="card-body filter_body" style="">
               <form  action="{{url('transection_terms_wise_sales_report')}}" method="POST" target="__blank">
                @csrf
                    <div class="row">
                      <div class="col-md-6">
                          <label>Start Date:</label>
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
                      <div class="col-md-6">
                          <label>End Date:</label>
                        <div class="input-group date" id="reservationdate_2" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_2" data-target="#reservationdate_2" required @if(isset($previous_filter["_datey"])) value='{{$previous_filter["_datey"] }}' @endif  />
                                      <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                      </div>
                      @include('av.reports.org_bran_cost')

                      <div class="col-xs-12 col-sm-12 col-md-12 ">
                        <div class="form-group ">
                        <label>{!! __('label._payment_terms') !!}:</label>
                        <select  class="form-control _payment_terms " name="_payment_terms"  >
                          <option value="">All </option>
                        
                         @forelse($transection_terms as $val )
                         <option value="{{$val->id}}" 
                          @if($val->id==$_payment_terms) selected @endif  >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                         @empty
                         @endforelse
                        </select>
                        </div>
                        </div>
                        <div class="col-md-12">
                          <label>{{__('label._sales_man_id')}}:</label>
                         <select class="form-control width_150_px _sales_man_id select2"  name="_sales_man_id"   >
                       
                            <option value=""> {{__('label._sales_man_id')}}</option>
                        
                            @forelse($sales_persons as $sales_man )
                            <option value="{{$sales_man->id}}" 
                              @if($sales_man->id==$_sales_man_id) selected @endif
                                 
                              > {{ $sales_man->_code ?? '' }} |{{ $sales_man->_name ?? '' }} | {{ $sales_man->b_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">{{__('label._customer_id')}}:</label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" placeholder="{{__('label._ledger_id')}}" value="{{$_search_main_ledger_id ?? ''}}">

                            <input type="hidden" id="_main_ledger_id" name="_ledger_id" class="form-control _main_ledger_id"  placeholder="Customer ID" value="{{$_ledger_id}}" >
                            <div class="search_box_main_ledger"> </div>
                            </div>
                        </div>

                      <div class="col-xs-12 col-sm-12 col-md-12 ">
                        <div class="form-group ">
                        <label class="_required">{!! __('label._group_by') !!}:</label>
                        <select  class="form-control group_by " name="group_by"  required>
                         
                         @forelse($group_by_array as $key=>$group_by_val )
                         <option value="{{$key}}" 
                          @if($key==$group_by) selected @endif  >{{ $group_by_val ?? ''}}</option>
                         @empty
                         @endforelse
                        </select>
                        </div>
                        </div>
                    
                    </div>
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('transection_terms_wise_sales')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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

