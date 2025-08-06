
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
        <h3 class="text-center"><b>{{$page_name}}</b></h3>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col text-right">
      
      </div>
      <!-- /.col -->
    </div>
  
<div class="table-responsive">
   <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>{{__('label.sl')}}</b></th>
                         <th class=""><b>{{__('label.from_date')}}</b></th>
                         <th class=""><b>{{__('label.to_date')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      @php
                      $sum_of_amount=0;
                      @endphp
                        @foreach ($datas as $key => $data)
                        @php
                           $sum_of_amount += $data->_amount ?? 0;
                        @endphp
                        <tr>
                            
                             
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_dfrom ?? '' ) }}</td>
                            <td>{{ _view_date_formate($data->_dto ?? '' ) }}</td>
                            <td>{{ $data->_entry_by->name ?? '' }}</td>
                            

                            </td>
                            
                           
                        </tr>
                        <tr>
                          <td colspan="12" >
                           <div >
                            <div class="card " >
                              <table class="table">
                                <thead>
                                  <th>{{__('label.id')}}</th>
                                  <th>{{__('label.name')}}</th>
                                  <th>{{__('label.date')}}</th>
                                  <th>{{__('label.type')}}</th>
                                </thead>
                                <tbody>
                                  
                                  @forelse($data->holiday_details AS $detail_key=>$_master_val )
                                  <tr>
                                    <td>{{ ($_master_val->id) }}</td>
                                    <td>{{ $_master_val->_name ?? '' }}</td>
                                    <td>{{ _view_date_formate($_master_val->_date ?? '') }}</td>
                                    <td>{{ $_master_val->_type ?? '' }}</td>
                                   
                                  </tr>
                                  @empty
                                  @endforelse
                                </tbody>
                                
                              </table>
                            </div>
                          </div>
                        </td>
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