@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('holidays.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('holidays-create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('holidays.create') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>

               </li>
              @endcan
            </ol>
          </div>
          
         
        </div><!-- /.row -->
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
                                
                                
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             @endcan   
                        
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>{{__('label.sl')}}</b></th>
                         <th class=""><b>{{__('label.action')}}</b></th>
                         <th class=""><b>{{__('label.from_date')}}</b></th>
                         <th class=""><b>{{__('label.to_date')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      @php
                      $sum_of_amount=0;
                      @endphp
                        @forelse ($datas as $key => $data)
                        @php
                           $sum_of_amount += $data->_amount ?? 0;
                        @endphp
                        <tr>
                            
                             <td style="display: flex;">
                              <a  type="button" 
                                  href="{{ route('holidays.show',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  <a  type="button" 
                                  href="{{ route('holidays.edit',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>  
                               
                               
                               
                                <a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ _view_date_formate($data->_dfrom ?? '' ) }}</td>
                            <td>{{ _view_date_formate($data->_dto ?? '' ) }}</td>
                            <td>{{ $data->_entry_by->name ?? '' }}</td>
                            

                            </td>
                            
                           
                        </tr>
                        <tr>
                          <td colspan="12" >
                           <div class="collapse" id="collapseExample__{{$key}}">
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
                        @empty
                        @endforelse
                        

                        </tbody>
                    </table>
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
 $(function () {
   var default_date_formate = `{{default_date_formate()}}`
   var _datex = `{{$request->_datex ?? '' }}`
   var _datey = `{{$request->_datey ?? '' }}`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 


function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }


  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});

 

</script>
@endsection