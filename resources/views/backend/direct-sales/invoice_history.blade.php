@if($form_settings->_show_due_history==1)
@if(sizeof($history_sales_invoices) > 0) 
        <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="border:1px dotted grey;">Date</th>
              <th style="border:1px dotted grey;">Order Number</th>
              <th style="border:1px dotted grey;">Sales Amount</th>
              <th style="border:1px dotted grey;">Due Amount</th>
              <th style="border:1px dotted grey;">Days</th>
            </tr>
          </thead>
          <tbody>
            @php
            $due_sales_amount=0;
            $due_due_amount =0;
            @endphp
            @forelse($history_sales_invoices as $his_val)
            @php
            $due_sales_amount +=$his_val->_total ?? 0;
            $due_due_amount +=$his_val->_due_amount ?? 0;
            @endphp
              <tr>
              <td style="border:1px dotted grey;">{{ _view_date_formate($his_val->_date ?? '') }}</td>
              <td style="border:1px dotted grey;">{{ $his_val->_order_number ?? '' }}</td>
              <td style="border:1px dotted grey;">{{ _report_amount($his_val->_total ?? 0) }}</td>
              <td style="border:1px dotted grey;">{{ _report_amount($his_val->_due_amount ?? 0) }}</td>
              <td style="border:1px dotted grey;">{{ _date_diff($his_val->_date,date('Y-m-d')) }}</td>
              
            </tr>
            @empty
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td style="border:1px dotted grey;" colspan="2"><b>Total</b></td>
              <td style="border:1px dotted grey;"><b>{{ _report_amount($due_sales_amount ?? 0) }}</b></td>
              <td style="border:1px dotted grey;"><b>{{ _report_amount($due_due_amount ?? 0) }}</b></td>
              <td style="border:1px dotted grey;"></td>
            </tr>
          </tfoot>
        </table>

@endif
@endif