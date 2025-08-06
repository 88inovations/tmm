
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
<div style="padding-left: 20px;display: flex;">
 
    <a class="nav-link"  href="{{url('lot-item-information')}}" role="button"><i class="fa fa-arrow-left"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
   
    <!-- info row -->
    <div class="col-12">
       <div style="text-align: center;">
         <h3><img src="{{url('/')}}/{{$settings->logo}}" alt="{{$settings->name ?? '' }}" style="height: 50px;width: 50px"  > {{$settings->name ?? '' }}
       
       </h3>
       <div>{{$settings->_address ?? '' }}<br>
        Phone: {{$settings->_phone ?? '' }}<br>
        Email: {{$settings->_email ?? '' }}</div>
       </div>
       <h3 class="text-center">  {{$page_name}}</h3>
        
      </div>
  
<div class="table-responsive">
   <table  style="width: 100%" style="border:1px solid silver;">
                <thead>
                    <tr>
                         <th>ID</th>
                         <th>Item</th>
                         <th>Unit</th>
                         <th>Code</th>
                         <th>Model</th>
                         <th>Category</th>
                         <th>Stock</th>
                         <th>Purchase Rate</th>
                         <th>Sales Rate</th>
                         <th>Manufacture Company</th>
                         <th>Discount</th>
                         <th>Vat</th>
                         <th>Status</th>
                        
                      </tr>
                </thead>
                <tbody>
                  
                      @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $data->id ?? '' }}</td>
                            <td>{{ $data->_item ?? '' }}</td>
                            <td>{{ $data->_units->_name ?? '' ?? '' }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ $data->_barcode ?? '' }}</td>
                            <td>{{ $data->_category->_name ?? '' }}</td>
                            <td>{{ _report_amount($data->_balance ?? 0) }}</td>
                            <td>{{ _report_amount($data->_pur_rate ?? 0 ) }}</td>
                            <td>{{ _report_amount($data->_sales_rate ?? 0 ) }}</td>
                            <td>{{ $data->_manufacture_company ?? '' }}</td>
                            <td>{{ _report_amount( $data->_discount ?? 0 ) }}</td>
                            <td>{{ _report_amount( $data->_vat ?? 0 ) }}</td>
                            
                           <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                   <tr>
                     <td colspan="13">
                       <div class="col-12 mt-5">
                          <div class="row">
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Received By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Prepared By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Checked By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;"> Approved By</span></div>
                          </div>
                        </div>
                     </td>
                   </tr>
                </tfoot>
                      
                        
                    </table>
                </div>
    
    
  </section>

@endsection