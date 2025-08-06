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
            <a class="m-0 _page_name" href="{{ route('cat_wise_ta_bills.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('cat_wise_ta_bills-create')
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('cat_wise_ta_bills.create') }}">
                   <i class="nav-icon fas fa-plus"></i> {{__('label.create_new')}}
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
                      @include('backend.cat_wise_ta_bills.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         
                        
                             
                        
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered _list_table">
                     <thead>
                        <tr>
                         <th class=""><b>##</b></th>
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label._fescal_year')}}</b></th>
                         <th class=""><b>{{__('label._designation_id')}}</b></th>
                         <th class=""><b>{{__('label._da_bill')}}</b></th>
                         <th class=""><b>{{__('label._moto_bill')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        @foreach ($datas as $key => $data)
                        
                        <tr>
                            
                             <td style="display: flex;">
                              @can('cat_wise_ta_bills-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['cat_wise_ta_bills.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  {!! Form::close() !!}
                               @endcan 
                              <a  type="button" 
                                  href="{{ route('cat_wise_ta_bills.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>

                             @can('cat_wise_ta_bills-edit')
                                  <a  type="button" 
                                  href="{{ route('cat_wise_ta_bills.edit',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                              @endcan  
                               
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_fescal_year ?? '' }}</td>
                            <td>{{ $data->_emp_designation->name ?? '' }}</td>
                            <td>{{ _report_amount($data->_da_bill ?? 0) }}</td>
                            <td>{{ _report_amount($data->_moto_bill ?? 0) }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                            
                           
                        </tr>
                        
                        @endforeach
                        </tbody>
                          <tfoot>
                          <tr>
                            <td colspan="7">
                              <div class="d-flex flex-row justify-content-end">
                                 {!! $datas->render() !!}
                                </div>
                            </td>
                          </tr>
                        </tfoot>
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