  @php
  $_ind_repl_old_item = $data->_ind_repl_old_item ?? '';
  $_ind_repl_in_item = $data->_ind_repl_in_item ?? '';
  $_ind_repl_out_item = $data->_ind_repl_out_item ?? '';
  $_ind_repl_in_account = $data->_ind_repl_in_account ?? '';
  $_ind_repl_out_acount = $data->_ind_repl_out_acount ?? '';


  @endphp

  @if($_ind_repl_old_item !='')
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="6">Old Item Information</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_old_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_old_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_old_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_old_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_old_item->_sales_rate ?? 0 }}</td>
          <td>{{ (($_ind_repl_old_item->_qty ?? 0) * ($_ind_repl_old_item->_sales_rate ?? 0))  }}</td>
        </tr>
     
    </tbody>
  </table>
  @endif

  @if($_ind_repl_in_item != '')
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="7">Item Receive From Supplier</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_in_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_in_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_in_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_in_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_in_item->_sales_rate ?? 0 }}</td>
          <td>{{ ($_ind_repl_in_item->_qty * $_ind_repl_in_item->_rate)  }}</td>
          <td>@if($_ind_repl_in_item->_in_status==1) <span class="btn btn-success">Received</span> @else <span class="btn btn-danger">Not Received </span>@endif</td>
        </tr>
      
    </tbody>
    <tfoot>
      @forelse($_ind_repl_in_account as $key=>$val)
      <tr>
        <td colspan="3">{{$val->_ledger->_name ?? '' }}</td>
        <td colspan="2">@if($val->_dr_amount > 0 ) {{ $val->_dr_amount }} Dr. @endif</td>
        <td colspan="2">@if($val->_cr_amount > 0 ) {{ $val->_cr_amount }} Cr. @endif</td>
       
      </tr>

      @empty
      @endforelse
    </tfoot>
  </table>
  @endif
  @if($_ind_repl_out_item!='' )
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="7">Item Delivery to Customer</th>
      </tr>
      <tr>
        <th>Item</th>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Cost Price</th>
        <th>Sales Price</th>
        <th>Value</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      
        <tr>
          <td>{{$_ind_repl_out_item->_items->_name ?? '' }}</td>
          <td>{{$_ind_repl_out_item->_barcode ?? '' }}</td>
          <td>{{ $_ind_repl_out_item->_qty ?? 0 }}</td>
          <td>{{ $_ind_repl_out_item->_rate ?? 0 }}</td>
          <td>{{ $_ind_repl_out_item->_sales_rate ?? 0 }}</td>
          <td>{{ ($_ind_repl_out_item->_qty * $_ind_repl_out_item->_sales_rate)  }}</td>
          <td>@if($_ind_repl_out_item->_out_status==1) <span class="btn btn-success">Delivered</span> @else <span class="btn btn-danger">Not Delivered </span>@endif</td>
        </tr>
     
    </tbody>
    <tfoot>
      @forelse($_ind_repl_out_acount as $key=>$val)
      <tr>
        <td colspan="3">{{$val->_ledger->_name ?? '' }}</td>
        <td colspan="2">@if($val->_dr_amount > 0 ) {{ $val->_dr_amount }} Dr. @endif</td>
        <td colspan="2">@if($val->_cr_amount > 0 ) {{ $val->_cr_amount }} Cr. @endif</td>
       
      </tr>

      @empty
      @endforelse
    </tfoot>
  </table>
  @endif
