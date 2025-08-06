<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
  <style>
    /* Add this CSS to ensure vertical alignment */
    .table tbody td {
        vertical-align: top !important;
    }
    
    /* For the month cell specifically */
    .month-header-cell {
        vertical-align: top;
        padding-top: 12px; /* Adjust as needed */
    }
</style>
  <div class="_report_button_header">
    <a class="nav-link"  href="{{url('report-panel')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
  <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    <div class="row">
      <div class="col-12">
        <table class="table" style="border:none;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr class="_report_header_tr" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
                 <tr class="_report_header_tr" > <td class="text-center" style="border:none;">
                   {{__('label._branch_id')}} : {{ _branch_name($previous_filter["_branch_id"] ?? '') }}
                  <br>
                   {{__('label._cost_center_id')}} : {{ _cost_center_name($previous_filter["_cost_center_id"] ?? '') }}</td> </tr>
              </table>
            </td>
            
          </tr>
        </table>
        </div>
      </div>

    <!-- Table row -->
     <table class="cewReportTable">
          <tbody>

            <tr>
              <td style="vertical-align: top !important;">
                <table class="table">
                 
                  <thead>
                    <tr>
                      <td colspan="3" class="text-center"><h3>Income</h3></td>
                    </tr>
                    <tr>
                      <th>Code</th>
                      <th>Ledger</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
$total_income = 0;
                    @endphp
                    @forelse($income_8 as $key=>$incomes)
                    <tr>
                      <td colspan="3">{!! $key ?? '' !!}</td>
                    </tr>
                      @forelse($incomes as $income)
                                          @php
$total_income += $income->_current_balance ?? 0;
                    @endphp
                        <tr>
                          
                            <td>{!! $income->_code ?? '' !!}</td>
                            <td>{!! $income->_l_name ?? '' !!}</td>
                            <td>{!! _report_amount($income->_current_balance ?? 0) !!}</td>
                            
                        </tr>
                      @empty
                      @endforelse
                    @empty
                    @endforelse
                  </tbody>
                  <tfoot>
                     <tr>
                          
                            <th colspan="2">Total Income</th>
                            <th>{!! _report_amount($total_income ?? 0) !!}</th>
                            
                        </tr>
                  </tfoot>
                 
                </table>
              </td>
              <td style="vertical-align: top !important;">
                <table class="table">

                  <thead>
                    <tr>
                      <td colspan="3" class="text-center"><h3>Expenses</h3></td>
                    </tr>
                    <tr>
                       
                      <th>Code</th>
                      <th>Ledger</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
$total_expense = 0;
                    @endphp
                    @forelse($other_income_expenses as $key=>$expenses)
                    <tr>
                      <td colspan="3">{!! $key ?? '' !!}</td>
                    </tr>
                      @forelse($expenses as $expense)
                                          @php
$total_expense += -($expense->_current_balance ?? 0);
                    @endphp
                        <tr>
                          
                            <td>{!! $expense->_code ?? '' !!}</td>
                            <td>{!! $expense->_l_name ?? '' !!}</td>
                            <td>{!! _report_amount(-$expense->_current_balance ?? 0) !!}</td>
                            
                        </tr>
                      @empty
                      @endforelse
                    @empty
                    @endforelse
                  </tbody>
                  <tfoot>
                     <tr>
                          
                            <th colspan="2">Total expense</th>
                            <th>{!! _report_amount($total_expense ?? 0) !!}</th>
                            
                        </tr>
                  </tfoot>
                 
                </table>
              </td>
            </tr>

            <tr>
              <th><b>Balance Income & Expneses</b></th>
              <th><b>{!! _report_amount($total_income-$total_expense) !!}</b></th>
            </tr>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="8">
                <div class="row">
                   @include('backend.message.invoice_footer')
                </div>
              </td>
            </tr>
          </tfoot>
        </table>
     


    <!-- /.row -->
  </section>

</div>