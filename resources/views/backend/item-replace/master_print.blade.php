
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$page_name}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <style type="text/css">
    .table td, .table th {
        padding: .15rem !important;
        vertical-align: top;
        border-top: 1px solid #CCCCCC;
    }
  </style>
</head>
<body>
<div class="wrapper">

<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
           <small class="float-right">Date: {{ change_date_format($current_date ?? '') }} Time:{{$current_time}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h3 class="text-center"><b>{{$page_name}} List</b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
      
      </div>
      <!-- /.col -->
    </div>
  
<div class="table-responsive">
   <table class="table table-bordered report_print_table">
                <thead>
                    <tr>
                         <th>SL</th>
                         <th><b>ID</b></th>
                         <th><b>Date</b></th>
                         <th><b>Branch</b></th>
                         <th><b>Order Number</b></th>
                         <th><b>Order Ref</b></th>
                         <th><b>Referance</b></th>
                         <th><b>Ledger</b></th>
                         <th><b>Sub Total</b></th>
                         <th><b>VAT</b></th>
                         <th><b>Total</b></th>
                         <th><b>User</b></th>
                        
                      </tr>
                </thead>
                <tbody>
                   @php
                      $sum_of_amount=0;
                      @endphp
                        @foreach ($datas as $key => $data)
                        @php
                           $sum_of_amount += $data->_total ?? 0;
                        @endphp
                        <tr>
                            
                             <td>
                                {{($key+1)}}
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_date ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>

                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ $data->_order_ref_id ?? '' }}</td>
                            <td>{{ $data->_referance ?? '' }}</td>
                            <td>{{ $data->_ledger->_name ?? '' }}</td>
                            <td>{{ _report_amount( $data->_sub_total ?? 0) }} </td>
                            <td>{{ _report_amount( $data->_total_vat ?? 0) }} </td>
                            <td>{{ _report_amount( $data->_total ?? 0) }} </td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                            
                           
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                     <tr>
                          <td colspan="10" class="text-center"><b>Total</b></td>
                          <td><b>{{ _report_amount($sum_of_amount) }} </b></td>
                          <td></td>
                        </tr>
                </tfoot>
                      
                        
                    </table>
                </div>
    
    <!-- /.row -->

    <div class="row">
      
      <!-- /.col -->
      @include('backend.message.invoice_footer')
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>