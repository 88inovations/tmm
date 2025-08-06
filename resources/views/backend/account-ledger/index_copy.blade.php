@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('account-ledger.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('account-ledger-create')
              <li class="breadcrumb-item active">
                  
   <button type="button" 
       class="btn btn-sm btn-info active attr_base_create_url" 
       data-toggle="modal" data-target="#commonEntryModal_item" 
       attr_base_create_url="{{ route('account-ledger.create') }}">
        <i class="nav-icon fas fa-plus"></i> Create New
       </button>
                 


               </li>
              @endcan
            </ol>
          </div>
          
        </div><!-- /.row -->
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
                      @include('backend.account-ledger.search')
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
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i> Print
                                </a>  
                            </li>
                             @endcan   
                        
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
 <!-- Page Url and display area Define -->
               <input type="hidden" name="page_url" class="page_url" value="{{url('account-ledger')}}">
               <input type="hidden" name="display_area" class="display_area" value="#dataDisplayArea">

<!-- Page Url and display area Define -->

                <div class="" id="dataDisplayArea">
                 
                </div>
                <!-- /.d-flex -->

                

                
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
   var page_url = $(document).find('.page_url').val();
  var display_area = $(document).find('.display_area').val();
  fetch_list_data_without_paginate(page_url,display_area,1);
 })


  $(document).on("click",".search_form_button",function(e){
    e.preventDefault();
      var data = $(document).find(".search_form").serialize();
      var page_url = $(this).attr("attr_url");
      var display_area ="#dataDisplayArea";
      fetch_list_data_without_paginate(page_url,display_area,data)


})



    
$(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var currentPage = $(this).attr('href').split('page=')[1];
        var page_url = $(document).find('.page_url').val();
       var display_area = $(document).find('.display_area').val();
       fetch_list_data_without_paginate(page_url,display_area,currentPage);
});
</script>
@endsection