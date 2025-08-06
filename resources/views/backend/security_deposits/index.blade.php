@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp

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
                    <div class="col-md-6">
                       @include('backend.security_deposits.search')
                    </div>
                    <div class="col-md-6">
                      <div class="d-flex flex-row justify-content-end">
                         @can('purchase-print')
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               
                                <div class="dropdown-divider"></div>
                                
                                <a target="__blank" href="{{$print_url}}" class="dropdown-item">
                                  <i class="fa fa-print mr-2" aria-hidden="true"></i>Main  Print
                                </a>
                               
                              
                                    
                            </li>
                            @endcan   
                            <div class="form-group ml-2">
                                {!! $datas->render() !!}
                            </div>  
                            <div class="form-group ml-2">
                              <form action="" method="GET">
                                  @csrf
                                <select name="limit" class="form-control" onchange="this.form.submit()">
                                        @forelse(filter_page_numbers() as $row)
                                         <option  @if($limit == $row) selected @endif  value="{{ $row }}">{{$row}}</option>
                                        @empty
                                        @endforelse
                                </select>
                              </form>
                              </div>
                             
                         
                          </div>
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  
                  <table class="table table-bordered table-striped table-hover _list_table">
                    <thead>
                      <tr>
                         <th class="width_100_px"><b>{{__('label.Action')}}</b></th>
                         <th class="width_100_px"><b>{{__('label._lock')}}</b></th>
                         <th><b>{{__('label.id')}}</b></th>
                         <th><b>{{__('label._order_number')}}</b></th>
                         <th><b>{{__('label._date')}}</b></th>
                          <th><b>{{__('label._ledger_code')}}</b></th>
                         <th><b>{{__('label._ledger_id')}}</b></th>
                         <th><b>{{__('label._type')}}</b></th>
                         <th><b>{{__('label._amount')}}</b></th>
                         <th><b>{{__('label._bank_name')}}</b></th>
                         <th><b>{{__('label._bank_branch_name')}}</b></th>
                         <th><b>{{__('label._cheque_no')}}</b></th>
                         <th><b>{{__('label._cheque_date')}}</b></th>
                         <th><b>{{__('label._remarks')}}</b></th>
                         <th><b>{{__('label._voucher_no')}}</b></th>
                         <th><b>{{__('label.organization_id')}}</b></th>
                         <th><b>{{__('label._branch_id')}}</b></th>
                         <th><b>{{__('label._cost_center_id')}}</b></th>
                         <th><b>{{__('label._user_name')}}</b></th>
                         <th><b>{{__('label.created_at')}}</b></th>
                         <th><b>{{__('label.updated_at')}}</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      
@php
$sum_amount=0;
@endphp
                        @foreach ($datas as $key => $data)
                        
@php
$sum_amount +=$data->_amount ?? 0;
@endphp
                       
                        <tr>
                            <td >
                                <a   href="{{url('security_deposits')}}/{{$data->id}}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>
                                  @can('security_deposits-edit')
                                  <a  href="{{ route('security_deposits.edit',$data->id) }}" 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan
                            </td>
                          
                        <td style="display: flex;white-space: nowrap;">
                          @can('lock-permission')
                          <input class="form-control _invoice_lock" type="checkbox" name="_lock" _attr_invoice_id="{{$data->id}}" value="{{$data->_lock}}" @if($data->_lock==1) checked @endif>
                          @endcan

                          @if($data->_lock==1)
                          <i class="fa fa-lock _green ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                          @else
                          <i class="fa fa-lock _required ml-1 _icon_change__{{$data->id}}" aria-hidden="true"></i>
                          @endif

                        </td>
                            
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->_order_number ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }} </td>
                            <td>{{ $data->_ledger->_code ?? '' }}</td>
                            <td>{{ $data->_ledger->_name ?? '' }}</td>
                            <td>
                              @if($data->_type =="Receive")
                              <button type="button" class="btn btn-success"> {{ $data->_type ?? '' }}</button>
                              @else
                              <button  type="button" class="btn btn-danger"> {{ $data->_type ?? '' }}</button>
                              @endif
                            </td>
                            <td>{{ _report_amount($data->_amount ?? 0) }}</td>
                            <td>{{ $data->_bank_name ?? '' }}</td>
                            <td>{{ $data->_bank_branch_name ?? '' }}</td>
                            <td>{{ $data->_cheque_no ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_cheque_date ?? '') }}</td>
                            <td>{{ $data->_remarks ?? '' }}</td>
                            <td>{{ $data->_voucher_no ?? '' }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            <td>{{ $data->_master_cost_center->_name ?? '' }}</td>
                            <td>{{ $data->_user_name ?? ''  }}</td>
                            <td>{{ $data->created_at ?? ''  }}</td>
                            <td>{{ $data->updated_at ?? ''  }}</td>
                           
                            
                           
                        </tr>
                        

                       
                        @endforeach
                        <tr>
                          <td colspan="8" class="text-center"><b>Total</b></td>
                          <td><b>{{ _report_amount($sum_amount) }} </b></td>
                          <td colspan="12"></td>
                        </tr>
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
 
$(document).on("click","._single_data_click",function(){
      var has_class = $(this).hasClass("already_show")
      if(has_class){return false; }
        var invoice_id = $(this).attr("attr_invoice_id");
        var _attr_key = $(this).attr("_attr_key");
        $(this).addClass("already_show");
        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        $.ajax({
           type:'POST',
           url:"{{ url('purchase-wise-detail') }}",
           data:{invoice_id,_attr_key},
           success:function(data){
            $(document).find("._single_data_display__"+invoice_id).html(data);
           }
        });
    })
 

// if(_datex =='' && _datey =='' ){
//   $(".datetimepicker-input_datex").val(date__today());
//   $(".datetimepicker-input_datey").val(date__today());
//   console.log('Ok new Page')
// }else{
//   $(".datetimepicker-input_datex").val(after_request_date__today( `{{$request->_datex}}` ))
//   $(".datetimepicker-input_datey").val(after_request_date__today( `{{$request->_datey}}` ))
//   console.log('after search')
// }

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

//  $(document).on('keyup','._search_main_ledger_id',delay(function(e){
//     $(document).find('._search_main_ledger_id').removeClass('required_border');
//     var _gloabal_this = $(this);
//     var _text_val = $(this).val().trim();
//     var _account_head_id = 13;

//   var request = $.ajax({
//       url: "{{url('main-ledger-search')}}",
//       method: "GET",
//       data: { _text_val,_account_head_id },
//       dataType: "JSON"
//     });
     
//     request.done(function( result ) {

//       var search_html =``;
//       var data = result.data; 
//       if(data.length > 0 ){
//             search_html +=`<div class="card"><table style="width: 300px;">
//                             <tbody>`;
//                         for (var i = 0; i < data.length; i++) {
//                          search_html += `<tr class="search_row_ledger" >
//                                         <td>${data[i].id}
//                                         <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
//                                         </td><td>${data[i]._name}
//                                         <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                  
//                                    </td></tr>`;
//                         }                         
//             search_html += ` </tbody> </table></div>`;
//       }else{
//         search_html +=`<div class="card"><table style="width: 300px;"> 
//         <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
//       }     
//       _gloabal_this.parent('div').find('.search_box_main_ledger').html(search_html);
//       _gloabal_this.parent('div').find('.search_box_main_ledger').addClass('search_box_show').show();
      
//     });
     
//     request.fail(function( jqXHR, textStatus ) {
//       alert( "Request failed: " + textStatus );
//     });

  

// }, 500));


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
    var _table_name ="security_deposits";
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