
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
      <div class="col-sm-4 invoice-col">
        <h2 class="page-header">
           <img src="{{asset('/')}}{{$settings->logo ?? ''}}" alt="{{$settings->name ?? '' }}"  style="width: 60px;height: 60px;"> {{$settings->name ?? '' }}
           
        </h2>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <h3 class="text-center"><b>{{$page_name}} </b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
      <p class="float-right">Date: {{ change_date_format(date('Y-m-d') ?? '') }} Time:{{ date('H:i:s') }}</p>
      </div>
      <!-- /.col -->
    </div>
  
<div class="table-responsive">
   <table class="table table-bordered">
                <thead>
                    <tr>
                         <th>SL</th>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Status</th>
                        
                      </tr>
                </thead>
                <tbody>
                  
                      @foreach ($datas as $key => $data)
                        <tr>
                            
                             
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_name ?? '' }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                            
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                   
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