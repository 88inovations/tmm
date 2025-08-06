@php

//echo $_talbe_name;
$item_details = [];
if($_talbe_name =='sales'){
  $item_details = \App\Models\SalesDetail::with(['_items','_trans_unit'])->where('_no',$_master_id)->where('_status',1)->get();
}
if($_talbe_name =='sales_returns'){
  $item_details = \App\Models\SalesReturnDetail::with(['_items'])->where('_no',$_master_id)->where('_status',1)->get();
}

if($_talbe_name =='purchases'){
  $item_details = \App\Models\PurchaseDetail::with(['_items'])->where('_no',$_master_id)->where('_status',1)->get();
}

if($_talbe_name =='purchase_returns'){
  $item_details = \App\Models\PurchaseReturnDetail::with(['_items'])->where('_no',$_master_id)->where('_status',1)->get();
}

@endphp




@if(sizeof( $item_details ) > 0)


 <tr class="border_none">
                    <td class="border_none"></td>
                    <td class="border_none" colspan="3">
                      <table style="width:100%;" class="border_none">
                        <tr>
                          <th>SL</th>
                          <th>Product Name</th>
                          <th>Qty</th>
                          <th>Unit</th>
                          <th>Rate</th>
                          <th>Amount</th>
                        </tr>
                        @forelse( $item_details  as $item_key=>$item_val)
                        <tr class="border_none">
                          <td>{!! ($item_key+1) !!}</td>
                          <td>{!! $item_val->_items->_name ?? '' !!}</td>
                          <td>{!! _report_amount($item_val->_qty ?? 0) !!}</td>
                          <td>{!! $item_val->_trans_unit->_name ?? '' !!}</td>
                          <td>{!! _report_amount($item_val->_sales_rate ?? 0) !!}</td>
                          <td>{!! _report_amount($item_val->_value ?? 0) !!}</td>
                          
                        </tr>
                        @empty
                        @endforelse
                      </table>


                    </td>
                    <td></td>
                    <td></td>
                  </tr>

@endif