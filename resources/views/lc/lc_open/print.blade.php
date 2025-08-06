@extends('backend.layouts.app')
@section('title',$page_name ?? '')


@section('content')
<div class="_report_button_header">
   <a class="nav-link"  href="{{ route('lc_manage.index') }}" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section  id="printablediv">
    <div class="container mt-4">
        <table class="table" style="border:none;">
          <tr>
            <td style="border:none;width: 25%;text-align: left;">
              
            </td>
            <td style="border:none;width: 50%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name ?? ''}} </b></td> </tr>
                 
              </table>
            </td>
            <td style="border:none;width: 25%;text-align: right;">
            </td>
          </tr>
        </table>
       
        <!-- LC Master Details -->
        <h4>LC Master Information</h4>
     <table class="table _grid_table">
            <tr>
                <th>ID</th>
                <td>{{ $lcMaster->id }}</td>
                <th>Organization</th>
                <td>{!! id_wise_name($lcMaster->organization_id,'companies',"_name") !!}</td>
            </tr>
            <tr>
                <th>Branch</th>
                <td>{!! id_wise_name($lcMaster->_branch_id,'branches',"_name") !!}</td>
                <th>Cost Center</th>
                <td>{!! id_wise_name($lcMaster->_cost_center_id,'cost_centers',"_name") !!}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ _view_date_formate($lcMaster->_date) }}</td>
                <th>PO No</th>
                <td>{{ $lcMaster->po_no }}</td>
            </tr>
            <tr>
                <th>LC/IP No</th>
                <td>{{ $lcMaster->lc_ip_no }}</td>
                <th>LC/IP Date</th>
                <td>{{ _view_date_formate($lcMaster->lc_ip_date ?? '') }}</td>
            </tr>
            <tr>
                <th>Amendment Date</th>
                <td>{{ _view_date_formate($lcMaster->amendment_date ?? '') }}</td>
                <th>Bill No</th>
                <td>{{ $lcMaster->bill_no }}</td>
            </tr>
            <tr>
                <th>PI No</th>
                <td>{{ $lcMaster->pi_no }}</td>
                <th>PI Date</th>
                <td>{{ _view_date_formate($lcMaster->pi_date ?? '') }}</td>
            </tr>
            <tr>
                <th>Bill of Entry No</th>
                <td>{{ $lcMaster->bill_of_enty_no }}</td>
                <th>Bill of Entry Date</th>
                <td>{{ _view_date_formate($lcMaster->bill_of_enty_date ?? '') }}</td>
            </tr>
            <tr>
                <th>Date of Arrival</th>
                <td>{{ $lcMaster->date_of_arrival }}</td>
                <th>LC Type</th>
                <td>{{ $lcMaster->lc_type }}</td>
            </tr>
            <tr>
                <th>LCA No</th>
                <td>{{ $lcMaster->lca_no }}</td>
                <th>Transport Type</th>
                <td>{{ $lcMaster->transport_type }}</td>
            </tr>
            <tr>
                <th>Partial Shipment</th>
                <td>{{ $lcMaster->partial_shipment }}</td>
                <th>Bank</th>
                <td>{!! id_wise_name($lcMaster->bank,'account_ledgers',"_name") !!}</td>
            </tr>
            <tr>
                <th>Supplier</th>
                <td>{!! id_wise_name($lcMaster->supplier,'account_ledgers',"_name") !!}</td>
                <th>CNF Agent</th>
                <td>{!! id_wise_name($lcMaster->cnf,'account_ledgers',"_name") !!}</td>
            </tr>
            <tr>
                <th>Bank Branch</th>
                <td>{{ $lcMaster->bank_branch }}</td>
                <th>Insurance Company</th>
                <td>{!! id_wise_name($lcMaster->insurance_company,'account_ledgers',"_name") !!}</td>
            </tr>
            <tr>
                <th>Insurance Cover Note</th>
                <td>{{ $lcMaster->insurance_cover_note }}</td>
                <th>Insurance Cover Date</th>
                <td>{{ _view_date_formate($lcMaster->insurance_cover_date ?? '') }}</td>
            </tr>
            <tr>
                <th>LC/TT</th>
                <td>{{ $lcMaster->lc_tt }}</td>
                <th>Currency</th>
                <td>{{ $lcMaster->currency }}</td>
            </tr>
            <tr>
                <th>CIF Value (Foreign)</th>
                <td>{{ $lcMaster->_cif_value_foreign }}</td>
                <th>CIF Value (Local)</th>
                <td>{{ $lcMaster->_cif_value_local }}</td>
            </tr>
            <tr>
                <th>Rate to BDT</th>
                <td>{{ $lcMaster->_rate_to_bdt }}</td>
                <th>Local Amount</th>
                <td>{{ $lcMaster->_local_amount }}</td>
            </tr>
            <tr>
                <th>Remark</th>
                <td>{{ $lcMaster->remark }}</td>
                <th>Note</th>
                <td>{{ $lcMaster->_note }}</td>
            </tr>
          
        </table>

        <!-- LC Item Details -->
        <h4 class="mt-4">LC Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                  <!--   <th>Barcode</th>
                    <th>HS Code</th>
                    <th>HS Code 2</th>
                    <th>Weight Avg</th> -->
                    <th>Quantity</th>
                    <th>{{__('label._foreign_rate')}}</th>
                    <th>Rate</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @php
$total_qty=0;
$total_value=0;
                @endphp
                @foreach ($lcItems as $key=> $item)

                 @php
$total_qty +=$item->_qty ?? 0;
$total_value +=$item->_value ?? 0;
                @endphp

                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td style="">{!! id_wise_name($item->_category_id,'item_categories',"_name") !!}</td>
                    <td style="white-space: nowrap;">{{ $item->_item_code ?? '' }}</td>
                    <td>{{ $item->_item_name ?? '' }}</td>
                    <td>{!! id_wise_name($item->_base_unit,'units',"_name") !!}</td>
                    <td style="white-space: nowrap;display: none;">{{ $item->_barcode ?? '' }}</td>
                    <td style="white-space: nowrap;display: none;">{{ $item->_hs_code ?? '' }}</td>
                    <td style="white-space: nowrap;display: none;">{{ $item->_hs_code_2 ?? '' }}</td>
                    <td style="white-space: nowrap;display: none;">{{ $item->weight_avg ?? '' }}</td>
                    <td style="white-space: nowrap;">{{ _report_amount($item->_qty ?? 0) }}</td>
                    <td style="white-space: nowrap;">{{ _report_amount($item->_foreign_rate ?? 0) }}</td>
                    <td style="white-space: nowrap;">{{ _report_amount($item->_rate ?? 0) }}</td>
                    <td style="white-space: nowrap;">{{ _report_amount($item->_value ?? 0) }}</td>
                    
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Grand Total</th>
                    <th>{!! _report_amount($total_qty ?? 0) !!}</th>
                    <th></th>
                    <th></th>
                    <th>{!! _report_amount($total_value ?? 0) !!}</th>
                </tr>
            </tfoot>
            
        </table>
        @include('backend.message.invoice_footer')
    </div>
</section>
@endsection
