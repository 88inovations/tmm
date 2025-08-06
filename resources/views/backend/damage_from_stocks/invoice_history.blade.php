@if($form_settings->_show_due_history==1)
@if(sizeof($history_sales_invoices) > 0) 
        <table class=" " style="width: 100%; border-collapse: collapse;">
          <thead style="background:#96d896;">
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;">Date</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Invoice No.</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Sales Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">Pending Amount</td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;">O/D By Days</td>
            </tr>
          </thead>
         
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
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;">{{ _view_date_formate($his_val->_date ?? '') }}</td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;padding-right:5px;z">{{ $his_val->_order_number ?? '' }}</td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;">{{ _report_amount($his_val->_total ?? 0) }}</td>
              <td style="border:1px solid #000;text-align: right;font-size: 10px;white-space: nowrap;padding-right:5px;">{{ _report_amount($his_val->_due_amount ?? 0) }}</td>
              <td style="border:1px solid #000;text-align: center;font-size: 10px;white-space: nowrap;color:red;font-weight:bold;">
                  @php
                  $diff_days = _date_diff($his_val->_date,date('Y-m-d'));
                   $_days = $data->_terms_con->_days ?? 0;
                  @endphp
                  @if($diff_days > $_days) 
                  {{ ($diff_days-$_days) }} Days
                  @endif
                  
                  </td>
              
            </tr>
            @empty
            @endforelse
         
          
            <tr>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;" colspan="2"><b>Total</b></td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;"><b>{{ _report_amount($due_sales_amount ?? 0) }}</b></td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;white-space: nowrap;"><b>{{ _report_amount($due_due_amount ?? 0) }}</b></td>
              <td style="border:1px solid #000;text-align: center;font-size: 12px;"></td>
            </tr>
          
        </table>

@endif
@endif