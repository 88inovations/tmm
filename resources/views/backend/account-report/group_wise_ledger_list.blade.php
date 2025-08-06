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
               <form  action="{{url('group_wise_ledger_list')}}" method="GET">
                @csrf
                
                    <div class="row">
                      
@include('basic.org_report')
                    

                    </div>
                    
                    
                    
                    <div class="row">
                      <label>Ledger Group:</label><br> </div>
                     <div class="row">
                         <select  class="form-control _account_group_id select2" name="_account_group_id[]"   multiple>
                           @forelse($account_groups as $group)
                           <option value="{{$group->id}}"
          @if(isset($previous_filter["_account_group_id"]))
                  @if(in_array($group->id,$previous_filter["_account_group_id"])) selected @endif
            @endif
                             >{{$group->_name}}</option>
                           @empty
                           @endforelse
                         </select>
                     </div>
                     
                
                     


                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                              <a href="{{url('group_wise_ledger_list_reset')}}"   class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
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

@if($request->has('_account_group_id'))



<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b>{{$settings->name ?? '' }}</b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
<?php
$sequence_to_remove = "––------------–--";
?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        <table class="table" style="border:none;width: 100%;margin-bottom: 0px !important;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-bottom: 0px !important;">
                


                <tr style="border:none;">
                  <td style="border:none;">
                      <table class="table" >
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Date </th>
                          <td style="width:90%;text-align: left;border: none;">: {{date('d-m-Y')}} </td>
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Name of Territory  </th>
                          @if($request->_branch_id =='all')
                          <td style="width:90%;text-align: left;border: none;">: ALL </td>
                          @else
                          <td style="width:90%;text-align: left;border: none;">: {{ id_to_cloumn($request->_branch_id,'_name','branches') }} </td>
                          @endif
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Ledger Group  </th>
                          <td style="width:90%;text-align: left;border: none;">:
                            @forelse($previous_filter["_account_group_id"] as $group_id)

                            <span style="padding:5px;font-weight: bold;">{{ id_to_cloumn($group_id,'_name','account_groups') }}</span> 
                            @empty
                            @endforelse
                          </td>
                        </tr>
                        

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Subject </th>
                          <td style="width:90%;text-align: left;border: none;">: Ledger List</td>
                         
                        </tr>

                       
                      </table>
                  </td>
                </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
             
        <tr>
         <th>SL</th>
         <th>Ledger ID</th>
         <th>Code</th>
         <th>Ledger Name</th>
         <th>{{__('label._alious')}}</th>
         <th>Phone</th>
         <th>{{__('label._whatsup_number')}}</th>
         <th>{{__('label._email')}}</th>
         <th>{{__('label._address')}}</th>
        </tr>
       
          
          
          </thead>
          <tbody>
            @forelse($datas as $key=>$data)
    <tr>
         <td>{{($key+1)}}</td>
         <td class="white_space">{!! $data->id ?? '' !!}</td>
         <td class="white_space">{!! $data->_code ?? '' !!}</td>
         <td class="white_space">{!! $data->_name ?? '' !!}</td>
         <td>{!! $data->_alious ?? '' !!}</td>
         <td>{!! $data->_phone ?? '' !!}</td>
         <td>{!! $data->_whatsup_number ?? '' !!}</td>
         <td>{!! $data->_email ?? '' !!}</td>
         <td>{!! $data->_address ?? '' !!}</td>
        
        </tr>
@empty
@endforelse

          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="9" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

  @endif



@endsection

@section('script')


@endsection

