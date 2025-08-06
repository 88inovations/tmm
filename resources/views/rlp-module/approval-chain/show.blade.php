
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('approval-chain')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('approval-chain-edit')
 <a  href="{{ route('approval-chain.edit',$data->id) }}" 
    class="nav-link "  title="Edit"  >
    <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    
    <div class="container-fluid">
     
    <!-- /.row -->
    <table class="table" style="width:100%;">
      <tr>
                <td colspan="2" style="text-align: center;border: 0px;">
                    {{ $settings->_top_title ?? '' }}<br>
                   <img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 60px;width: 120px"  ><br>
                  <strong>{{ $settings->name ?? '' }}</strong><br>
             {{$settings->_address ?? '' }}<br>
            {{$settings->_phone ?? '' }}<br>
            {{$settings->_email ?? '' }}<br>
            
      
            <b>{{__('label.approval-chain')}}</b>
                </td>
              </tr>
      <tr>
        <td>{{__('label._id')}}:</td>
        <td>{{ $data->id ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._name')}}:</td>
        <td>{{ $data->chain_name ?? '' }}</td>
      </tr>
      <tr>
        <td>{{__('label.chain_type')}}:</td>
        <td>{{ selected_access_chain_types($data->chain_type) }}</td>
      </tr>
      
      <tr>
        <td>{{__('label.organization_id')}}:</td>
        <td>{{ $data->_organization->_name ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._branch_id')}}:</td>
        <td>{{ $data->_branch->_name ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._cost_center_id')}}:</td>
        <td>{{ $data->_cost_center->_name ?? ''  }}</td>
      </tr>
      <tr>
        <td>{{__('label._status')}}:</td>
        <td>{{ selected_status($data->_status)  }}</td>
      </tr>
      <tr>
        <td colspan="2"><b>{{__('label._details')}}</b></td>
      </tr>
      <tr>
        <td colspan="2">
          @php
                              $_chain_user = $data->_chain_user ?? [];
                              @endphp
                              @if(sizeof($_chain_user) > 0)
                              <table class="table">
                                 <thead >
                                            <th class="text-left" >{{__('label.id')}}</th>
                                            <th class="text-left" >{{__('label._name')}}</th>
                                            <th class="text-left" >{{__('label._group_name')}}</th>
                                            <th class="text-left" >{{__('label._order')}}</th>
                                          </thead>
                                @forelse($_chain_user as $key=>$val)
                                  <tr>
                                    <td>{!! $val->user_id ?? '' !!}</td>
                                    <td>{!! _find_employee_name($val->user_id ?? '') !!}</td>
                                    <td>{!! $val->_user_group->_name ?? '' !!}</td>
                                    <td>{!! $val->_order ?? '' !!}</td>
                                    
                                  </tr>
                                @empty
                                @endforelse
                                </table>
                              @endif
        </td>
      </tr>
      
      
    </table>
    
    <div class="col-12 mt-5">
  <div class="row">
    <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Received By</span></div>
    <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Prepared By</span></div>
    <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Checked By</span></div>
    <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;"> Approved By</span></div>
  </div>
</div>

    

    
    </div>
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection