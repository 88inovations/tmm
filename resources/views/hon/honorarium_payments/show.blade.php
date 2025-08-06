@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('honorarium_payments')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 20px;"><b>{{$page_name}}  </b></td> </tr>
                
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">Date : {{_view_date_formate($data->_date ?? '')}}</td> </tr>
                 
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                  {{__('label.organization_id')}} : {{ $data->_organization->_name ?? '' }}
                  
                 </td> 
               </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                {{__('label._branch_id')}} : {{ $data->_branch->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._cost_center_id')}} : {{ $data->_cost_center->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._code')}} : {{ $data->_ledger->_code ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._name')}} : {{ $data->_ledger->_name ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._address')}} : {{ $data->_ledger->_address ?? '' }}
                
                 </td> </tr>
                 <tr style="line-height: 16px;" > <td class="" style="border:none;font-size: 16px;font-weight: 500;">
                 
                   {{__('label._phone')}} : {{ $data->_ledger->_phone ?? '' }}
                
                 </td> </tr>
                
              </table>
            </td>
           
          </tr>
        </table>

    <!-- Table row -->
     <table class="cewReportTable">
          <thead>
          <tr>
           
          <tr>
               <th style="width:10%;">Sl</th>
              <th style="width: 10%;white-space: nowrap;"><b>{{__('label._month')}}</b></th>
               <th style="width: 10%;white-space: nowrap;"><b>{{__('label._year')}}</b></th>
               <th style="width: 10%;white-space: nowrap;"><b>{{__('label._code')}}</b></th>
               <th style="width: 50%;white-space: nowrap;"><b>{{__('label._ledger_id')}}</b></th>
               <th style="width: 10%;white-space: nowrap;"><b>{{__('label._paid_amount')}}</b></th>
             </tr>
          </thead>
          <tbody>
    

  @php
  $total_paid_amount = 0;

  @endphp
 @forelse($_details as $key=>$h_data)
 @php
  $total_paid_amount +=$h_data->_amount ??  0;
  @endphp

            <tr>
               <td class="white_space">{{($key+1)}}</td>
               <td class="white_space">{!! _number_to_month($h_data->_month ?? 0) !!}</td>
               <td>{!! $h_data->_year ?? '' !!}</td>
               <td>{!! $h_data->_cash_ledger->_code ?? '' !!}</td>
               <td>{!! $h_data->_cash_ledger->_name ?? '' !!}</td>
               <td class="white_space">{!! _report_amount($h_data->_amount ?? 0) !!}</td>
              
             </tr>
           
          @empty
          @endforelse
           
            
          
          </tbody>
          @if(sizeof($_details) > 1)
          <tfoot>
            <tr>
               <th colspan="5">Total</th>
               <th>{!! _report_amount($total_paid_amount ?? 0) !!}</th>
              
             </tr>
             <tr>
            <td  colspan="6">In Words:  {{ nv_number_to_text($total_paid_amount ?? 0) }} </td>
          </tr>
          </tfoot>
          @endif
          
        </table>

       @include('backend.message.invoice_footer')

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')



@endsection
