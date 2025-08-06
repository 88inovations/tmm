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
            <a class="m-0 _page_name" href="{{ route('rlp.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               
             <li class="breadcrumb-item active">
                <a type="button" 
               class="btn btn-sm btn-info" 
              
               href="{{ route('rlp.create') }}">
                   <i class="nav-icon fas fa-plus"></i> {{__('label.create_new')}}
                </a>

               </li>
              
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
                      @include('rlp-module.rlp.search')
                    </div>
                    <div class="col-md-8">
                      <div class="d-flex flex-row justify-content-end">
                         
                        <li class="nav-item dropdown remove_from_header">
                              <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fa fa-print " aria-hidden="true"></i> <i class="right fas fa-angle-down "></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                               <div class="dropdown-divider"></div>
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
                                </a>
                              
                                    
                            </li>
                             
                        
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
                         <th class=""><b>{{__('label.action')}}</b></th>
                         <th class=""><b>{{__('label.id')}}</b></th>
                         <th class=""><b>{{__('label.priority')}}</b></th>
                         <th class=""><b>{{__('label.organization_id')}}</b></th>
                         <th class=""><b>{{__('label._branch_id')}}</b></th>
                         <th class=""><b>{{__('label._cost_center_id')}}</b></th>
                         <th class=""><b>{{__('label.rlp_no')}}</b></th>
                         <th class=""><b>{{__('label.request_date')}}</b></th>
                         <th class=""><b>{{__('label._amount')}}</b></th>
                         <th class=""><b>{{__('label._status')}}</b></th>
                         <th class=""><b>{{__('label.user')}}</b></th>
                         <th class=""><b>{{__('label._lock')}}</b></th>
                      </tr>
                     </thead>
                     <tbody>
                      
                        @foreach ($datas as $key => $data)
        @php
        $_rlp_acks = $data->_rlp_ack ?? [];
         $find_group_and_permision=find_group_and_permision($_rlp_acks,$__user);
        @endphp

                        <tr>
                            
                             <td style="display: flex;">
                              @can('rlp-delete')
                                 {!! Form::open(['method' => 'DELETE','route' => ['rlp.destroy', $data->id],'style'=>'display:inline']) !!}
                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i>  {{__('label.trash')}}</button>
                                  {!! Form::close() !!}
                               @endcan 
                              

                             @can('rlp-edit')
                                  <a  type="button" 
                                  href="{{ route('rlp.edit',$data->id) }}"
                                 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i> {{__('label.edit')}}</a>
                              @endcan 

                              <a target="__blank"  type="button" 
                                  href="{{ route('rlp.show',$data->id) }}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"> {{__('label._details')}}</i></a> 
                               
                            </td>

                            <td>

    @if($find_group_and_permision ==2 || $find_group_and_permision ==3 || $find_group_and_permision ==4)
    @if($data->rlp_status !=1)
                               <a  type="button" 
                                  href="#None"
                                  attr_rlp_id="{{$data->id}}"
                                  attr_rlp_no="{{$data->rlp_no}}"
                                  attr_rlp_action="approve"
                                  attr_rlp_action_title="Approve"

                                 data-toggle="modal" data-target="#ApproveModal" data-whatever="@mdo"
                                  class="btn btn-sm btn-success approve_reject_revert_button  mr-1"><i class="fa fa-check "></i> {{__('label.approve')}}
                                </a>
                            
                               <a  type="button" 
                                  href="#None"
                                  attr_rlp_id="{{$data->id}}"
                                  attr_rlp_no="{{$data->rlp_no}}"
                                  attr_rlp_action="reject"
                                  attr_rlp_action_title="Reject"

                                 data-toggle="modal" data-target="#ApproveModal" data-whatever="@mdo"
                                 
                                  class="btn btn-sm btn-warning approve_reject_revert_button  mr-1"><i class="fa fa-trash "></i> {{__('label.reject')}}</a>
                            
                               <a  type="button" 
                                  href="#None"
                                  attr_rlp_id="{{$data->id}}"
                                  attr_rlp_no="{{$data->rlp_no}}"
                                  attr_rlp_action="revert"
                                  attr_rlp_action_title="Revert"

                                 data-toggle="modal" data-target="#ApproveModal" data-whatever="@mdo"
                                 
                                  class="btn btn-sm btn-info approve_reject_revert_button  mr-1"><i class="fa fa-undo "></i> {{__('label.revert')}}</a>
                      @endif
@endif
<a class="btn btn-sm btn-default _action_button" data-toggle="collapse" href="#collapseExample__{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                      <i class=" fas fa-angle-down"></i>
                                    </a>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ selected_priority($data->priority ?? '') }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>{{ $data->_cost_center->_name ?? '' }}</td>
                            <td>{{ $data->rlp_no ?? '' }}</td>
                            <td>{{ _view_date_formate($data->request_date ?? '') }}</td>
                            <td>{{ _report_amount($data->totalamount ?? 0) }}</td>
                           <td>{!! selected_rlp_status($data->rlp_status ?? 0) !!}</td>
                            <td>{{ $data->_entry_by->name ?? '' }}</td>
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
                        <tr>
                          <td colspan="14" >
                           <div class="collapse" id="collapseExample__{{$key}}">
                           @php
                      $_item_detail = $data->_item_detail ?? [];
                      $row_span= sizeof($_item_detail);
                      $purpose =[];
                      $suppliers =[];
                      $item_total_qty=[];
                      $item_total_amount=[];
                      @endphp
                          @if(sizeof($_item_detail) > 0)   
                            <div class="card " >
                              <table class="table">
                                <thead >
                                    <th class="text-left" >&nbsp;</th>
                                    <th class="text-left" >{{__('label.note_sheet')}}</th>
                                     <th class="text-left" >{{__('label.supplier_details')}}</th>
                                    <th class="text-left" >{{__('label._item')}}</th>
                                   
                                    <th class="text-left" >{{__('label.purpose')}}</th>
                                    <th class="text-left" >{{__('label.Tran. Unit')}}</th>
                                    <th class="text-left" >{{__('label._qty')}}</th>
                                    <th class="text-left" >{{__('label._rate')}}</th>
                                    <th class="text-left" >{{__('label._value')}}</th>

                                  </thead>

                                <tbody>
                   @php
                      $sl=1;
                      $last_key = (sizeof($_item_detail)-1);
                      @endphp
                      @forelse($_item_detail as $key=>$item)
                       @php
                      
                      $item_total_qty[]=$item->quantity ?? 0;
                      $item_total_amount[]=$item->amount ?? 0;

                      
                      @endphp
                      <tr>
                        <td>{{$sl}}</td>
                        <td>
                          <!-- @if($data->rlp_status==1)
                          <a target="__blank" class="btn btn-primary" href="{{url('rlp-to-notesheet')}}?rlp_no={{$data->rlp_no}}&rlp_id={{$data->id}}&supplier_id={{$data->_ledger_id ?? ''}}">{{__('label.notesheet')}}</a>
                          @endif -->
                        </td>
                        <td>
                         
                           {!! $item->_supplier->_name ?? '' !!}
                          
                          </td>
                        <td>{!! $item->_items->_item ?? '' !!} <br>
                          {!! $item->_item_description ?? '' !!}
                        </td>
                       
                        <td >
                          @if(!in_array($item->purpose,$purpose))
                          @php
                          array_push($purpose,$item->purpose);
                          @endphp
                           {!! $item->purpose ?? '' !!} 
                           @endif
                        </td>
                       
                        <td>{!! _find_unit($item->_unit_id) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->quantity ?? 0) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->unit_price ?? 0) !!}</td>
                        <td style="text-align:right;">{!! _report_amount($item->amount ?? 0) !!}</td>
                        
                      </tr>
                      
                      @php
                      $sl++;
                      @endphp
                      @empty
                      @endforelse
                                </tbody>
                              </table>
                            </div>

                            @endif
                          </div>
                        </td>
                      </tr>
                        
                        @endforeach
                        

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
<div class="modal fade" id="ApproveModal" tabindex="-1" role="dialog" aria-labelledby="ApproveModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:332px;margin: 0px auto;height: auto;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ApproveModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          
          <div class="form-group">
            <label for="message-text" class="col-form-label">{{__('label.rlp_remarks')}}:</label>
            <textarea cols="6"  class="form-control" id="rlp_app_reject_remarks"></textarea>
            <input type="hidden" name="rlp_id_app_reject" class="rlp_id_app_reject" >
            <input type="hidden" name="rlp_no_app_reject" class="rlp_no_app_reject" >
            <input type="hidden" name="attr_rlp_action_app_reject" class="attr_rlp_action_app_reject" >
            <input type="hidden" name="attr_rlp_action_title_action_app_reject" class="attr_rlp_action_title_action_app_reject" >

            




          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn  rlpApproveRejectSubmit" data-dismiss="modal">{{__('label.submit')}}</button>
      </div>
    </div>
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


 $(document).on('click','.approve_reject_revert_button',function(){
  var rlp_id = $(this).attr('attr_rlp_id');
  var rlp_no = $(this).attr('attr_rlp_no');
  var attr_rlp_action = $(this).attr('attr_rlp_action');
  var attr_rlp_action_title = $(this).attr('attr_rlp_action_title');
  var success = $(this).hasClass("btn-success");
  var warning = $(this).hasClass("btn-warning");
  var btn_info = $(this).hasClass("btn-info");
  var button_class="btn-primary";
  if(success ==true){ button_class ="btn-success"; }
  if(warning ==true){ button_class ="btn-warning"; }
  if(btn_info ==true){ button_class ="btn-info"; }

  console.log(button_class);
  


$(document).find(".rlp_id_app_reject").val(rlp_id);
$(document).find(".rlp_no_app_reject").val(rlp_no);
$(document).find(".attr_rlp_action_app_reject").val(attr_rlp_action);
$(document).find(".attr_rlp_action_title_action_app_reject").val(attr_rlp_action_title);
  



  $(".rlpApproveRejectSubmit").removeClass("btn-success").removeClass("btn-warning").removeClass("btn-info");
  $("#ApproveModalLabel").html(attr_rlp_action_title);
  $(".rlpApproveRejectSubmit").addClass(button_class);
  $(".rlpApproveRejectSubmit").html(attr_rlp_action_title);

 })

 $(document).on("click",".rlpApproveRejectSubmit",function(){
  var rlp_id = $(document).find(".rlp_id_app_reject").val();
  var rlp_no = $(document).find(".rlp_no_app_reject").val();
  var rlp_action = $(document).find(".attr_rlp_action_app_reject").val();
  var rlp_remarks = $(document).find("#rlp_app_reject_remarks").val();
  


   $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        $.ajax({
           type:'POST',
           url:"{{ url('rlp-approve-reject') }}",
           data:{rlp_id,rlp_no,rlp_action,rlp_remarks},
           success:function(data){
            alert(data?.message);
            location.reload();
              console.log(data);
           }
        });
  
 })

 
  $(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    console.log(_id)
    var _table_name ="rlp_masters";
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