@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('warranty-manage.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('warranty-manage-create')
              <li class="breadcrumb-item active">
                  <a class="btn btn-info" href="{{ route('warranty-manage.create') }}"> Create New </a>
               </li>
              @endcan
            </ol>
          </div>
         


      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                <div class="row">
                   @php

                     $currentURL = URL::full();
                     $current = URL::current();
                    if($currentURL === $current){
                       $print_url = $current."?print=single";
                       $print_url_detal = $current."?print=detail";
                    }else{
                         $print_url = $currentURL."&print=single";
                         $print_url_detal = $currentURL."&print=detail";
                    }
    

                   @endphp
                    <div class="col-md-4">
                       @include('backend.warranty-manage.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('warranty-manage-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                        <th>SL</th>
                         <th>Action</th>
                          <th>ID</th>
                          <th>Complain No</th>
                         <th>Date</th>
                         <th>Delivery Date</th>
                         <th>Sales Invoice</th>
                         <th>Referance </th>
                         <th>Customer </th>
                         <th>Warranty Status</th>
                         <th>User </th>
                         <th>Lock</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{($key+1)}}</td>
                          <td style="display: flex;">
                            <div class="dropdown mr-1">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"> Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                   <a class="dropdown-item " href="{{ route('warranty-manage.show',$data->id) }}">Print  </a>

                                   <a class="dropdown-item " href="{{url('individual-replacement-out-report')}}/{{$data->id}}" >
                                         Inovice for Supplier Claim
                                      </a>

                                  @can('warranty-manage-edit')
                                    <a class="dropdown-item " href="{{ route('warranty-manage.edit',$data->id) }}">Edit</a>
                                  @endcan
                                <!--  @can('warranty-manage-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['warranty-manage.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm "><span class="_required">Delete</span></button>
                                  {!! Form::close() !!}
                                  @endcan -->
                                </div>
                              </div>
                        </td>
                             
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }}</td>
                            <td>{{ _view_date_formate($data->_delivery_date ?? '') }}</td>
                            <td>{{ $data->_order_ref_id ?? '' }}</td>
                            <td>{{ $data->_referance ?? '' }}</td>
                            <td>{{ $data->_ledger->_name ?? '' }}</td>
                            <td>{{ _selected_warranty_status($data->_waranty_status)  }}</td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                            <td style="display: flex;">
                              @can('lock-permission')
                              <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$data->id}}" value="{{$data->_lock}}" @if($data->_lock==1) checked @endif>
                              @endcan
                              @if($data->_lock==1)
                              <i class="fa fa-lock _green ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @else
                              <i class="fa fa-lock _required ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                              @endif
                            </td>
                            
                            
                            
                           
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(function(){
       $('#reservationdate_datex').datetimepicker({
          format:'L'
      });
       $('#reservationdate_datey').datetimepicker({
           format:'L'
      });
  })

  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="warranty_masters";
      if($(this).is(':checked')){
            $(this).prop("selected", "selected");
          var _action = 1;
          $('._icon_change__'+_id).addClass('_green').removeClass('_required');
         
         
        } else {
          $(this).removeAttr("selected");
          var _action = 0;
            $('._icon_change__'+_id).addClass('_required').removeClass('_green');
           
        }
      _lock_action(_id,_action,_table_name)
       
  })
</script>
@endsection