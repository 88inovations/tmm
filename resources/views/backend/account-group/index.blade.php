@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
  ._shortable_li{
    cursor: pointer !important; 
  }
</style>
<div class="content-header">
      <div class="container-fluid">
        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('account-group.index') }}"> {!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('account-group-create')
              <li class="breadcrumb-item active">
                  
                  <a 
               class="btn btn-sm btn-info active " 
               href="{{ route('account-group.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
               </li>
              @endcan
            </ol>
          </div>
          
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 
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
                     @include('backend.account-group.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('voucher-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Print
                                </a>
                               <div class="dropdown-divider"></div>
                              
                                
                              
                                    
                            </li>
                             @endcan   
                         {!! $datas->render() !!}
                          </div>
                    </div>
                  </div>
              </div>
              <form action="{{url('account_group_short_update')}}" method="POST" class="account_group_form">
                          @csrf
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered _list_table">
                    <thead>
                      <tr>
                        <th>SL</th>
                         <th  style="width: 10%" class="">##</th>
                         <th  style="width: 10%" class="">Action</th>
                         <th  style="width: 5%" class="_no">ID</th>
                         <th style="width: 10%" >Account</th>
                         <th style="width: 10%" >Account Type</th>
                         <th style="width: 5%" >Code</th>
                         <th style="width: 20%" >Name</th>
                         <th style="width: 5%" >Possition</th>
                         <th style="width: 35%" >Details</th>
                         <th style="width: 5%" >Status</th>
                      </tr>
                    </thead>
                      <tbody id="sortable-list">
                        
                        @foreach ($datas as $key => $data)
                        <tr id="item__{{$data->id}}" class="_shortable_li">
                          <td style="width: 15%">
                            Up/Down 
                          </td>
                          <td>{{($key+1)}}</td>
                          <td style="display: flex;">
                           
                                <a   
                                  href="{{ route('account-group.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  @can('account-group-edit')
                                  <a   
                                  href="{{ route('account-group.edit',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>

                                    
                                  @endcan
                               
                               
                        </td>

                          
                             
                             <td>{{ $data->id }}</td>
                            <td>{{ $data->account_type->_main_account_head->_name ?? '' }}</td>
                            <td>{{ $data->account_type->_name ?? '' }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td> {{ $data->_name ?? '' }}</td>
                            <td>
                              <input type="hidden" name="id[]" value="{{$data->id}}"  class="form-control id id__{{$data->id}}">
                              <input type="text" name="_short[]" value="{{$data->_short}}"  class="form-control serial serial__{{$data->id}}">
                            </td>
                            <td>{{ $data->_details ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                            
                        </tr>
                        @endforeach
                       
                       
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="8">  {!! $datas->render() !!} </td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.d-flex -->

              </div>
            </div>
            <!-- /.card -->

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary form_submit">Short Update</button>
                        </div>
                          
             </form>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
$(function() {
  $("#sortable-list").sortable({
    stop: function(event, ui) {
      var data = $(this).sortable('toArray');
      for (var i = 0; i < data.length; i++) {
        var item = data[i];
       let  substrings = item.split("__");
       let item_index = substrings[1];
       $(".serial__"+item_index).val((i+1));
        console.log(item_index)
      }
      
    }
  });


$(document).on('click',"form_submit",function(){
  $(document).find('.account_group_form').submit();
})

  


});
</script>
@endsection