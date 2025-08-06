
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
        <h3 class="text-center"><b>Voucher </b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
      
      </div>
      <!-- /.col -->
    </div>
  
<div class="table-responsive">
   <table class="table table-bordered">
                <thead>
                    <tr>
                         <th>SL</th>
                         <th class="_no">ID</th>
                         <th>Code</th>
                         <th>Date</th>
                         <th>Type</th>
                         <th>Amount</th>
                         <th>Refarance</th>
                         <th>Note</th>
                         <th>Branch</th>
                         <th>User</th>
                        
                      </tr>
                </thead>
                <tbody>
                  @php
                  $amount_sum = 0;
                  @endphp
                      @foreach ($datas as $key => $data)
                        <tr>
                            
                             
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ $data->_date ?? '' }}</td>
                            <td>{{ $data->_voucher_type ?? '' }}</td>
                            <td>{{ number_format((float) $data->_amount ?? 0, default_des(), '.', ',') }} </td>
                            <td>{{ $data->_transection_ref ?? '' }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                            
                            @php
                  $amount_sum += $data->_amount ?? 0;
                  @endphp
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                    <tr>
                         <th class="_no"></th>
                         <th class="_no"></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th><b>{{ number_format((float) $amount_sum, default_des(), '.', ',') }}</b></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                        
                      </tr>
                </tfoot>
                      
                        
                    </table>
                </div>
    
    <!-- /.row -->

    <div class="row">
      
      <!-- /.col -->
      <div class="col-12 mt-5">
        <div class="row">
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Received By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Prepared By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Checked By</span></div>
          <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;"> Approved By</span></div>
        </div>

          
       
      </div>
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