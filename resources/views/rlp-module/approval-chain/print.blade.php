
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
   
  
<div class="">
    <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label.organization')}}</b></th>
                         <th class=""><b>{{__('label.Branch')}}</b></th>
                         <th class=""><b>{{__('label.Cost center')}}</b></th>
                         <th class=""><b>{{__('label.chain_name')}}</b></th>
                         <th class=""><b>{{__('label.details')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        @foreach ($datas as $key => $data)
                        <tr>
                            
                            
                            <td>{{ $data->id }}</td>
                            


                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>{{ $data->_cost_center->_name ?? '' }}</td>
                            <td>{{ $data->chain_name ?? '' }}</td>
                            <td>
                              
                              @php
                              $_chain_user = $data->_chain_user ?? [];
                              @endphp
                              @if(sizeof($_chain_user) > 0)
                              <table class="table">
                                @forelse($_chain_user as $key=>$val)
                                  <tr>
                                    <td>{!! $val->user_id ?? '' !!}</td>
                                    <td>{!! _find_employee_name($val->user_id ?? '') !!}</td>
                                    <td>{!! $val->_user_group->_name ?? '' !!}</td>
                                    <td>{!! $val->_order ?? '' !!}</td>
                                   
                                  </tr>
                                @empty
                                @endforelse
                                </table>
                              @endif
                            </td>
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