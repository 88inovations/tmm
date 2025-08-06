@extends('backend.layouts.app')
@section('title',$page_name ?? '')


@section('content')
<div class="_report_button_header">
   <a class="nav-link"  href="{{ route('lc_manage.index') }}" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section  id="printablediv">
  
<style type="text/css">
  th{
    font-weight: bold;
  }
  td{
    border: 1px solid #000;
  }
  .table-total{
    font-weight: bold;
  }
  .text-center{
    border: 0px !important;
  }
</style>


        
        <table class="table table-bordered">
          <tr style="border:none !important;">
            <td style="border:none !important;" colspan="6" class="text-center">
              <span style="font-size: 22px;font-weight: bold;">{{$settings->name ?? '' }}</span></td>
            </tr>
            <tr style="border:none !important;">
                <td style="border:none !important;" colspan="6" class="text-center">{{$settings->_address ?? '' }}</td>
              </tr>
              <tr style="border:none !important;">
                <td style="border:none !important;" colspan="6" class="text-center">{{$settings->_phone ?? '' }}</td>
              </tr>
              <tr style="border:none !important;">
              <td style="border:none !important;font-weight: bold;" colspan="6" class="text-center"> {{$page_name ?? ''}}</td>
            
          </tr>
            <tr>
                <th>Date</th>
                <td>{{ $lcMaster->_date }}</td>
                <th>PO No</th>
                <td>{{ $lcMaster->po_no }}</td>
                <th>LC IP No</th>
                <td>{{ $lcMaster->lc_ip_no }}</td>
            </tr>
            <tr>
                <th>LC IP Date</th>
                <td>{{ $lcMaster->lc_ip_date }}</td>
                <th>Expiry Date</th>
                <td>{{ $lcMaster->expiry_date }}</td>
                <th>Amendment Date</th>
                <td>{{ $lcMaster->amendment_date }}</td>
            </tr>
            <tr>
                <th>Bill No</th>
                <td>{{ $lcMaster->bill_no }}</td>
                <th>PI No</th>
                <td>{{ $lcMaster->pi_no }}</td>
                <th>PI Date</th>
                <td>{{ $lcMaster->pi_date }}</td>
            </tr>
            <tr>
                <th>Bill of Entry No</th>
                <td>{{ $lcMaster->bill_of_enty_no }}</td>
                <th>Bill of Entry Date</th>
                <td>{{ $lcMaster->bill_of_enty_date }}</td>
                <th>Date of Arrival</th>
                <td>{{ $lcMaster->date_of_arrival }}</td>
            </tr>
            <tr>
                <th>LC Type</th>
                <td>{{ $lcMaster->lc_type }}</td>
                <th>LCA No</th>
                <td>{{ $lcMaster->lca_no }}</td>
                <th>Transport Type</th>
                <td>{{ $lcMaster->transport_type }}</td>
            </tr>
            <tr>
                <th>Partial Shipment</th>
                <td>{{ $lcMaster->partial_shipment }}</td>
                <th>Bank</th>
                <td>{{ $lcMaster->bank_name }}</td>
                <th>Supplier</th>
                <td>{{ $lcMaster->supplier_name }}</td>
            </tr>
            <tr>
                <th>CNF</th>
                <td>{{ $lcMaster->cnf_name }}</td>
                <th>Bank Branch</th>
                <td>{{ $lcMaster->bank_branch_name }}</td>
                <th>Insurance Company</th>
                <td>{{ $lcMaster->insurance_company_name }}</td>
            </tr>
            <tr>
                <th>Insurance Cover Note</th>
                <td>{{ $lcMaster->insurance_cover_note }}</td>
                <th>Insurance Cover Date</th>
                <td>{{ $lcMaster->insurance_cover_date }}</td>
                <th>LC TT</th>
                <td>{{ $lcMaster->lc_tt }}</td>
            </tr>
            <tr>
                <th>Currency</th>
                <td>{{ $lcMaster->currency }}</td>
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
                <th>Remark</th>
                <td>{{ $lcMaster->remark }}</td>
            </tr>
        </table>
    

    <table class="table table-bordered ">
        <thead>
            <tr>
                <th>#</th>
                <th>Product ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Foreign Rate</th>
                <th>Foreign Amount</th>
                <th>Value</th>
                <th>Barcode</th>
                <th>HS Code 1</th>
                <th>HS Code 2</th>

                @foreach($ledgerNames as $ledgerName)
                    <th>{{ $ledgerName }}</th>
                @endforeach

                <th>Line Total</th>
            </tr>
        </thead>

        <tbody>
            @php 
                $grandTotals = array_fill_keys($ledgerIds->toArray(), 0); 
                $grandLineTotal = 0;
                $total_qty=0;
                $total__value=0;
                $total__foreign_amount=0;
            @endphp

            @foreach($results as $index => $row)
                @php 
                    $lineTotal = $row->_value; // Calculate line total based on the _value or other logic

                $total_qty   +=$row->_qty ?? 0;
                $total__value +=$row->_value ?? 0;
                $total__foreign_amount +=$row->_foreign_amount ?? 0;
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="white-space: nowrap;">{{ $row->_item_id ?? '' }}</td>
                    <td style="white-space: nowrap;">{{ $row->_item_code ?? '' }}</td>
                    <td style="white-space: nowrap;">{{ $row->_item_name ?? '' }}</td>
                    <td style="white-space: nowrap;"   class="text-right">{{ _report_amount($row->_qty ?? 0) }}</td>
                    <td style="white-space: nowrap;"   class="text-right">{{ _report_amount($row->_rate ?? 0) }}</td>
                    <td style="white-space: nowrap;"   class="text-right">{{ _report_amount($row->_foreign_rate ?? 0) }}</td>
                    <td style="white-space: nowrap;"   class="text-right">{{ _report_amount($row->_foreign_amount ?? 0) }}</td>
                    <td style="white-space: nowrap;"   class="text-right">{{ _report_amount($row->_value ?? 0) }}</td>
                    <td style="white-space: nowrap;">{{ $row->_barcode ?? '' }}</td>
                    <td style="white-space: nowrap;">{{ $row->_hs_code ?? '' }}</td>
                    <td style="white-space: nowrap;">{{ $row->_hs_code_2 ?? '' }}</td>

                    @foreach($ledgerIds as $ledgerId)
                        @php 
                            $value = $row->{"Ledger_$ledgerId"} ?? 0;
                            $grandTotals[$ledgerId] += $value; 
                        @endphp
                        <td style="white-space: nowrap;text-align: right;">{{ _report_amount($value ?? 0) }}</td>
                    @endforeach

                    @php 
                        $grandLineTotal += $lineTotal; // Add line total to grand total
                    @endphp
                    <td class="table-total text-right">{{ _report_amount($lineTotal ?? 0) }}</td>
                </tr>
            @endforeach

            <!-- Grand Total Row -->
            <tr class="table-total">
                <th colspan="4" class="text-end">Grand Total</th>
                <th  class="text-right">{{_report_amount($total_qty ?? 0)}}</th>
                <th colspan="2"></th>
                <th  class="text-right">{{_report_amount($total__foreign_amount ?? 0)}}</th>
                <th  class="text-right">{{_report_amount($total__value ?? 0)}}</th>
                 <th colspan="3"></th>
                @foreach($ledgerIds as $ledgerId)
                    <th class="text-right">{{ _report_amount($grandTotals[$ledgerId] ?? 0) }}</th>
                @endforeach

                <th  class="text-right">{{ _report_amount($grandLineTotal ?? 0) }}</th>
            </tr>
        </tbody>
    </table>
 @include('backend.message.invoice_footer')

@endsection
