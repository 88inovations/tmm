
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
       
        <div style="text-align: center;">
       <h3> {{$settings->name ?? '' }} </h3>
       <div>{{$settings->_address ?? '' }}</br>
       {{$settings->_phone ?? '' }}</div>
       <h3>{{$page_name}}</h3>

      </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
   
  
<div class="table-responsive">
   <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label._name')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        @foreach ($datas as $key => $data)
                        
                        <tr>
                            
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_name ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           <td>{{ $data->_entry_by->name ?? '' }}</td>
                           
                        </tr>
                        
                        @endforeach
                        

                        </tbody>
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