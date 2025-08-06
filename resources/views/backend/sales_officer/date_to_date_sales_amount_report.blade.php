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
               <form  action="{{url('date_to_date_sales_amount_report')}}" method="POST">
                @csrf
                <input type="hidden" name="_form_name" class="_form_name" value="date_to_date_sales_amount_report">
                @include('basic.report_date_filter')
                    <div class="row">
                   
                         @php
              $users = \Auth::user();
              $permited_organizations = permited_organization(explode(',',$users->organization_ids));
              
              @endphp 


              <div class="col-xs-12 col-sm-12 col-md-12 ">
              <div class="form-group ">
              <label>{!! __('label.organization') !!}:</label>
              <select  class="form-control _master_organization_id " name="organization_id" required >

                @if(sizeof($permited_organizations) > 1)
                <option value="all">All {!! __('label.organization') !!}</option>
                @endif
               @forelse($permited_organizations as $val )
               <option value="{{$val->id}}" 
                @if(isset($previous_filter["organization_id"]) && $val->id==$previous_filter["organization_id"]) ) selected @endif
                               >{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
               @empty
               @endforelse
              </select>
              </div>
              </div>
              <div class="col-md-12">
                          <label>{{__('label._branch_id')}}:</label>
                         <select id="_branch_id" class="form-control _branch_id _master_branch_id" name="_branch_id"  required>
                          @if(sizeof($permited_branch) > 1)
                          <option value="all">All {{__('label._branch_id')}}</option>
                          @endif
                          @forelse($permited_branch as $branch )
                          <option value="{{$branch->id}}" 
                            @if(isset($previous_filter["_branch_id"]) && $branch->id==$previous_filter["_branch_id"]) selected @endif
                             > {{ $branch->_name ?? '' }}</option>
                          @empty
                          @endforelse
                         </select>
                      </div>
                      <div class="col-md-12">
                          <label>{{__('label._cost_center_id')}}:</label>
                         <select class="form-control width_150_px _cost_center "  name="_cost_center"  required >
                          @if(sizeof($permited_costcenters) > 1)
                                      <option value="all">All {{__('label._cost_center_id')}}</option>
                          @endif
                            @forelse($permited_costcenters as $costcenter )
                            <option value="{{$costcenter->id}}" 
                              @if(isset($previous_filter["_cost_center"]) && $costcenter->id==$previous_filter["_cost_center"]) selected @endif
                                 
                              > {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>

               @php
$sales_officers_id  = $request->sales_officer_id ?? '';
$report_type  = $request->report_type  ?? '';
               @endphp        
                  
                    <div class="col-sm-12 ">
                        <label for="sales_officer_id" class="col-sm-4 col-form-label">Sales Officer</label>
                        <select class="form-control  sales_officer_id _sales_man" name="sales_officer_id"  required>
                          @if(sizeof($sales_officers) > 1)
                            <option value="">All Officer</option>
                          @endif
                          @forelse($sales_officers as $sales_officer )
                          <option value="{{$sales_officer->id}}" @if($sales_officer->id==$sales_officers_id) selected @endif>{{ $sales_officer->_code ?? '' }} - {{ $sales_officer->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                    <div class="col-sm-12 ">
                        <label for="report_type" class="col-sm-4 col-form-label">Report Type:<span class="_required">*</span></label>
                        <select class="form-control  report_type " name="report_type"  required>
                          <option value="invoice_wise_sales" @if($report_type=='invoice_wise_sales') selected @endif>Invoice Wise Sales</option>
                          <option value="date_wise_sales" @if($report_type=='date_wise_sales') selected @endif>Date Wise Sales</option>
                          <option value="sales_and_return_summary" @if($report_type=='sales_and_return_summary') selected @endif>Sales & Return Summary</option>
                          <option value="date_wise_sales_and_collection" @if($report_type=='date_wise_sales_and_collection') selected @endif>Date Wise Sales & Collection Amount</option>
                          <option value="customer_due_summary" @if($report_type=='customer_due_summary') selected @endif>Customer Due Summary</option>
                          <option value="customer_collection_detail" @if($report_type=='customer_collection_detail') selected @endif>Collection Detail</option>
                        </select>
                    </div>
                    
                  
                    </div>
                    
                    
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('date_to_date_sales_amount_report')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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

