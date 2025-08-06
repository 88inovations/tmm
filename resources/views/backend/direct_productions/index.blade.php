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
            <a class="m-0 _page_name" href="{{ url('partical_production_receive_list') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('production-create')
              <li class="breadcrumb-item active">
                  <a title="Add New" class="btn btn-info btn-sm" href="{{ url('partical-production-receive') }}"> Add New </a>
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
                       @include('backend.direct_productions.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         @can('production-print')
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
                <div >
                  
                  <table class="table table-bordered table-striped table-hover _list_table">
                      <thead>
                        <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th class=" _no"><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label._date')}}</b></th>
                         <th class=""><b>{{__('label._order_number')}}</b></th>
                         <th class=""><b>{{__('label._production_no')}}</b></th>
                         <th class=""><b>{{__('label._start_date')}}</b></th>
                         <th class=""><b>{{__('label.organization_id')}}</b></th>
                         <th class=""><b>{{__('label._branch_id')}}</b></th>
                         <th class=""><b>{{__('label._cost_center_id')}}</b></th>
                         <th class=""><b>{{__('label._store_id')}}</b></th>
                         <th class=""><b>{{__('label._note')}}</b></th>
                         <th class=""><b>{{__('label._type')}}</b></th>
                         <th class=""><b>{{__('label._p_status')}}</b></th>
                         <th class=""><b>{{__('label._total_amount')}}</b></th>
                         
                         <th class=""><b>{{__('label._created_by')}}</b></th>
                         <th class=""><b>{{__('label._updated_by')}}</b></th>
                         <th class=""><b>{{__('label.created_at')}}</b></th>
                         <th class=""><b>{{__('label.updated_at')}}</b></th>
                         <th class=""><b>{{__('label._lock')}}</b></th>
                         
 
                      </tr>
                      </thead>
                      <tbody>
                      @forelse($datas as $key=>$data)
                        <tr>
                            
                             <td style="display: flex;">
                              <div class="dropdown mr-1">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     @can('production-edit')
                                        <a class="dropdown-item " href="{{ route('direct_productions.edit',$data->id) }}" >
                                          Edit
                                        </a>
                                    @endcan
                                    @can('production-print')
                                     <a class="dropdown-item " href="{{url('partical-production-receive-print1')}}?production_id={{$data->_production_id}}&created_at={{$data->created_at}}&_date={{$data->_date}}&production_partial_receives_id={{$data->id}}" >
                                         Print 1
                                      </a>
                                     @endcan
                                    @can('production-print')
                                     <a class="dropdown-item " href="{{url('partical-production-receive-print2')}}?production_id={{$data->_production_id}}&created_at={{$data->created_at}}&_date={{$data->_date}}&production_partial_receives_id={{$data->id}}" >
                                         Print 2
                                      </a>
                                     @endcan
                                    
                                     
                                  </div>
                                </div>
                                
                                
                                
                                @can('labels-print')
                                    <a title="Model Barcode Print" target="__blank" class="btn btn-default" href="{{url('labels-print')}}?_id={{$data->_production_id}}&_type=production"><i class=" fas fa-barcode"></i></a>
                                  @endcan
                            </td>
                            <td>{{ $data->id }}</td>
                            
                            <td>{{ _view_date_formate($data->_date ?? '') }} </td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ $data->_production_order_number ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_start_date ?? '') }} </td>
                            <td>{{ $data->_organization->_name ?? ''  }}</td>
                            <td>{{ $data->_master_branch->_name ?? ''  }}</td>
                            <td>{{ $data->_master_cost_center->_name ?? ''  }}</td>
                            <td>{{ _store_name($data->_store_id ?? 1) }}</td>
                            <td>{{ $data->_note ?? '' }}</td>
                            <td>{{ $data->_type ?? '' }}</td>

                            <td>
                              <span class="btn btn-sm @if($data->_p_status ==3) btn-success @elseif($data->_p_status ==2) btn-warning @else btn-info @endif">{{ _p_t_status($data->_p_status ?? '') }}</span>
                            </td>
                            

                            
                            <td>{{ $data->_created_by ?? ''  }}</td>
                            <td>{{ $data->_updated_by ?? ''  }}</td>
                           
                            <td>{{ $data->created_at ?? ''}}</td>
                            <td>{{ $data->updated_at ?? ''}}</td>
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
                       @empty
                       
                        @endforelse
                        
                        </tbody>

                        <tfoot>
                          <tr>
                            <td colspan="21"> {!! $datas->render() !!}</td>
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

 $(document).on('keyup','._search_main_ledger_id',delay(function(e){
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _account_head_id = 13;

  var request = $.ajax({
      url: "{{url('main-ledger-search')}}",
      method: "GET",
      data: { _text_val,_account_head_id },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_ledger" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                  
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find('.search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $("._ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);

    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })
  
  $(document).on("click",'.search_modal',function(){
    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })


  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="production_partial_receives";
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