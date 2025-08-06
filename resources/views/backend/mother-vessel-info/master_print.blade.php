
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
  
<div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                        <th>{{__('lable._action')}}</th>
                        <th>{{ __('label.id') }} </th>
                        <th>{{ __('label._name') }}</th>
                        <th>{{ __('label._code') }}</th>
                        <th>{{ __('label._code') }}</th>
                        <th>{{ __('label._license_no') }}</th>
                        <th>{{ __('label._route') }}</th>
                        <th>{{ __('label._owner_name') }}</th>
                        <th>{{ __('label._contact_one')' }}</th>
                        <th>{{ __('label._contact_two') }}</th>
                        <th>{{ __('label._contact_three') }}</th>
                        <th>{{ __('label._capacity') }}</th>
                        <th>{{ __('label._type') }}</th>
                        <th>{{ __('label._status') }}</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                             <td style="display: flex;">
                           
                                <a  
                                  href="{{ route('vessel-info.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('vessel-info-edit')
                                  <a  
                                  href="{{ route('vessel-info.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i>
                                </a>
                                  @endcan
                                  
                                @can('vessel-info-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['vessel-info.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan  
                               
                        </td>

                           
                            <td>{{ $data->id }} </td>
                            <td> {{ $data->_name ?? '' }}</td>
                            <td> {{ $data->_code ?? '' }}</td>
                            <td> {{ $data->_country_name ?? '' }}</td>
                            <td> {{ $data->_license_no ?? '' }}</td>
                            <td> {{ $data->_route ?? '' }}</td>
                            <td> {{ $data->_owner_name ?? '' }}</td>
                            <td> {{ $data->_contact_one ?? '' }}</td>
                            <td> {{ $data->_contact_two ?? '' }}</td>
                            <td> {{ $data->_contact_three ?? '' }}</td>
                            <td> {{ $data->_capacity ?? '' }}</td>
                            <td>{{ selected_vessel_type($data->_type) }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
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