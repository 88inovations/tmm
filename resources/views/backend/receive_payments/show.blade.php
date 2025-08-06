@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

    <div class="message-area">
     @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                     <h4><a  href="{{ route('supplier_payment.index') }}"> {!! $page_name ?? '' !!} </a>  
                      
                      </h4>
                  </div>
                  <div class="col-md-6">
                   <div class="d-flex right" style="float: right;">
                       
                      @can('customer_payment_edit')
                                    <a title="Edit" class="btn  btn-default  mr-3" href="{{ route('supplier_payment.edit',$data->id) }}">
                                      <i class="nav-icon fas fa-edit"></i>
                                    </a>
                      @endcan
                      @can('customer_payment_print')
                         <a style="cursor: pointer;" class="btn btn-sm btn-danger mr-3"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="nav-icon fas fa-print"></i></a>
     
                      @endcan
                      @can('customer_payment_list')
                       <a class="btn btn-sm btn-primary" title="List" href="{{ route('supplier_payment.index') }}"> <i class="nav-icon fa fa-th-list" aria-hidden="true"></i></a>
                       @endcan
                    </div>
                   
                  </div>
                </div>
             </div>
              <div class="card-body">
                <div class="wrapper">
  <!-- Main content -->
<section class="invoice" id="printablediv">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
           <img src="{{asset($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}"  style="width: 120px;height:auto;"> {{$settings->name ?? '' }}
          <small class="float-right">Date: {{ _view_date_formate($data->_date ?? '') }} {{$data->_time ?? ''}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-7 invoice-col">
        
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
      </div>
      <!-- /.col -->
      
      <!-- /.col -->
      <div class="col-sm-5 invoice-col text-right">
        <b>{{__('label._order_number')}}: {{ $data->_order_number ?? '' }}</b><br>
        <span>{{__('label._ledger_id')}}: {{ $data->_sup_cus->_name ?? '' }}</span><br>
        <span>{{__('label._code')}}: {{ $data->_sup_cus->_code ?? '' }}</span><br>
        <span>{{__('label._alious')}}: {{ $data->_sup_cus->_alious ?? '' }}</span><br>
        <span>{{__('label._balance')}}: {{ _report_amount($data->_sup_cus->_balance ?? 0) }}</span><br>
        
             
      </div>

      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 ">
         <h3 class="text-center">{!! $page_name ?? '' !!}</h3>
        <table class="table">
                                <thead>
                                  <th>ID</th>
                                  <th>{{__('label._voucher_code')}}</th>
                                  <th>{{__('label._invoice_number')}}</th>
                                  <th>{{__('label._collection_ledger_id')}}</th>
                                  <th>Sales Amount</th>
                                  <th>Total Collection</th>
                                  <th>Pre. Due</th>
                                  <th>{{__('label._collection_amount')}}</th>
                                  <th>Current Due</th>
                                  <th>{{__('label._is_close')}}</th>
                                  <th>{{__('label._is_effect')}}</th>
                                  
                                </thead>
                                <tbody>
                                  @php
                                    $_master_details = $data->_master_details ?? [];
                                    $_total = 0;
                                    $_receive_amount = 0;
                                    $_due_amount = 0;
                                    $_collection_amount = 0;
                                    $_due_balance = 0;
                                  @endphp
                                  @forelse($_master_details AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_voucher_code ?? '' }}</td>
                                    <td>{{ $_master_val->_invoice_number ?? '' }}</td>
                                    <td>{{ $_master_val->_receive_ledger->_name ?? '' }}</td>
                  <td class="text-right">{{ _report_amount( $_master_val->_total ?? 0) }}</td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_receive_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_due_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_collection_amount ?? 0) }} </td>
                  <td class="text-right"> {{ _report_amount( $_master_val->_due_balance ?? 0) }} </td>
                                    <td>{{ $_master_val->_is_close ?? '' }}</td>
                                    <td>{{ $_master_val->_is_effect ?? '' }}</td>
                                    @php 
                                    $_total += $_master_val->_total;   
                                    $_receive_amount += $_master_val->_receive_amount;  
                                    $_due_amount += $_master_val->_due_amount;  
                                    $_collection_amount += $_master_val->_collection_amount;  
                                    $_due_balance += $_master_val->_due_balance;  



                                    @endphp
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="4" class="text-right"><b>Total</b></td>
                                    <td  class="text-right"><b>{{ _report_amount($_total ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_receive_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_due_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_collection_amount ?? 0 ) }} </b></td>
                                    <td  class="text-right"><b>{{ _report_amount( $_due_balance ?? 0 ) }} </b></td>
                                    <td  class="text-right"></td>
                                    <td  class="text-right"></td>
                                    
                                  </tr>
                                </tfoot>
                              </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-12">
       
        <p class="lead"> <b>In Words:   {{ nv_number_to_text($_collection_amount ?? 0) }} </b></p>
        
      </div>
       @include('backend.message.invoice_footer')
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
               
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>


@endsection