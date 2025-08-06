
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
</head>
<body>
<div class="wrapper">

<section class="invoice">
   
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-2 invoice-col">
        
      </div>
      <!-- /.col -->
      <div class="col-sm-8 invoice-col text-center">
        <h2 class="page-header">
            {{$settings->name ?? '' }}
          <small class="float-right"></small>
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
          <b>Account Ledger</b>
        </address>
       
      </div>
      <!-- /.col -->
      <div class="col-sm-2 invoice-col text-right">
        
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  
<div class="table-responsive">
   <table class="table table-bordered">
                <thead>
                    <tr>
                         <th>ID</th>
                         <th>Type</th>
                         <th>Group</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Balance</th>
                         <th>Possition</th>
                         <th>Status</th>
                        
                      </tr>
                </thead>
                <tbody>
                  
                      @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->account_type->_name ?? '' }}</td>
                            <td>{{ $data->account_group->_name ?? '' }}</td>
                            <td>{{ $data->_name }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                           <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                   <tr>
                     <td colspan="10">
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

</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>