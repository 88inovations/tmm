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
                      <div class="row">
                          <div class="col-md-12 d-flex">
                            <div class="form-group">
                                <a class="m-0 _page_name" href="{{ route('lc_manage.index') }}">{!! $page_name ?? '' !!} </a>
                              </div>
                            <div class="form-group ml-2">
                                @can('purchase-create')
                             
                                    <a title="Add New" class="btn btn-info btn-sm mr-1" href="{{ route('lc_manage.create') }}"><i class="nav-icon fas fa-plus"></i> Create New </a>
                                  @endcan
                              </div>
                            
                          
                              <div class="form-group ml-2">
                                    <button type="button" class="btn btn-sm btn-warning mr-3" data-toggle="modal" data-target="#modal-default" title="Advance Search"><i class="fa fa-search mr-2"></i> </button>
                                    
                              </div>

                              


                          </div>
                        </div><!-- end row -->
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
                               <div class="dropdown-divider"></div>
                              
                                <a target="__blank" href="{{$print_url_detal}}"  class="dropdown-item">
                                  <i class="fa fa-fax mr-2" aria-hidden="true"></i> Detail Print
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
                  
                  <table class="table table-bordered  table-hover _list_table">
                    <thead>
                      <tr>
                         <th class=" _nv_th_action _action_big"><b>Action</b></th>
                         <th><b>{{__('label.id')}}</b></th>
                         <th><b>{{__('label._is_close')}}</b></th>
                         <th><b>{{__('label.organization_id')}}</b></th>
                         <th><b>{{__('label._branch_id')}}</b></th>
                         <th><b>{{__('label._cost_center_id')}}</b></th>
                         <th><b>{{__('label._date')}}</b></th>
                         <th><b>{{__('label.po_no')}}</b></th>
                         <th><b>{{__('label.lc_ip_no')}}</b></th>
                         <th><b>{{__('label.amendment_date')}}</b></th>
                         <th><b>{{__('label.bill_no')}}</b></th>
                         <th><b>{{__('label.pi_no')}}</b></th>
                         <th><b>{{__('label.pi_date')}}</b></th>
                         <th><b>{{__('label.bill_of_enty_no')}}</b></th>
                         <th><b>{{__('label.bill_of_enty_date')}}</b></th>
                         <th><b>{{__('label.date_of_arrival')}}</b></th>
                         <th><b>{{__('label.lc_type')}}</b></th>
                         <th><b>{{__('label.lca_no')}}</b></th>
                         <th><b>{{__('label.transport_type')}}</b></th>
                         <th><b>{{__('label.partial_shipment')}}</b></th>
                         <th><b>{{__('label.bank')}}</b></th>
                         <th><b>{{__('label.supplier')}}</b></th>
                         <th><b>{{__('label.cnf')}}</b></th>
                         <th><b>{{__('label.bank_branch')}}</b></th>
                         <th><b>{{__('label.insurance_company')}}</b></th>
                         <th><b>{{__('label.insurance_cover_note')}}</b></th>
                         <th><b>{{__('label.insurance_cover_date')}}</b></th>
                         <th><b>{{__('label.lc_tt')}}</b></th>
                         <th><b>{{__('label.currency')}}</b></th>
                         <th><b>{{__('label._cif_value_foreign')}}</b></th>
                         <th><b>{{__('label._cif_value_local')}}</b></th>
                         <th><b>{{__('label._rate_to_bdt')}}</b></th>
                         <th><b>{{__('label._local_amount')}}</b></th>
                         <th><b>{{__('label._note')}}</b></th>
                         <th><b>{{__('label._is_close')}}</b></th>
                         <th><b>{{__('label._user_id')}}</b></th>
                         <th><b>{{__('label._user_name')}}</b></th>
                         <th><b>{{__('label._status')}}</b></th>
                         <th><b>{{__('label._created_by')}}</b></th>
                         <th><b>{{__('label._updated_by')}}</b></th>
                         <th><b>{{__('label.created_at')}}</b></th>
                         <th><b>{{__('label.updated_at')}}</b></th>
                         <th><b>{{__('label._lock')}}</b></th>
                        


                      </tr>
                    </thead>
                    <tbody>
                      
                   
                        @foreach ($datas as $key => $data)
                       

                       
                        <tr>
                            <td style="display: flex;">
                           
                                <a  
                                  href="{{url('/lc/lc_manage')}}/{{$data->id}}"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>

                                  @can('purchase-edit')
                                  <a  href="{{ route('lc_manage.edit',$data->id) }}" 
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  @endcan

                                 
                                  <a title="{{__('label.lc_product_costs')}}"  href="{{ route('lc_cost_calculation',$data->id) }}" 
                                  class="btn btn-sm btn-default  mr-1">{{__('label.lc_product_costs')}}</a>
                                  
                        </td>
                          <th>{{$data->id ?? '' }}</th>
                          <th>
                            @if($data->_is_close ==1)
                            <span class="btn btn-danger btn-sm">Close</span>
                            @else
                            <span class="btn btn-info btn-sm">Open</span>
                            @endif
                            {{$data->_is_close ?? '' }}
                          </th>
                         <th>{{$data->_organization->_name ?? '' }}</th>
                         <th>{{$data->_branch->_name ?? '' }}</th>
                         <th>{{$data->_cost_center->_name ?? '' }}</th>
                         <th>{{$data->_date ?? '' }}</th>
                         <th>{{$data->po_no ?? '' }}</th>
                         <th>{{$data->lc_ip_no ?? '' }}</th>
                         <th>{{$data->amendment_date ?? '' }}</th>
                         <th>{{$data->bill_no ?? '' }}</th>
                         <th>{{$data->pi_no ?? '' }}</th>
                         <th>{{$data->pi_date ?? '' }}</th>
                         <th>{{$data->bill_of_enty_no ?? '' }}</th>
                         <th>{{$data->bill_of_enty_date ?? '' }}</th>
                         <th>{{$data->date_of_arrival ?? '' }}</th>
                         <th>{{$data->lc_type ?? '' }}</th>
                         <th>{{$data->lca_no ?? '' }}</th>
                         <th>{{$data->transport_type ?? '' }}</th>
                         <th>{{$data->partial_shipment ?? '' }}</th>
                         <th>{{$data->_bank->_name ?? '' }}</th>
                         <th>{{$data->_supplier->_name ?? '' }}</th>
                         <th>{{$data->_cnf->_name ?? '' }}</th>
                         <th>{{$data->bank_branch ?? '' }}</th>
                         <th>{{$data->_insurance_company->_name ?? '' }}</th>
                         <th>{{$data->insurance_cover_note ?? '' }}</th>
                         <th>{{$data->insurance_cover_date ?? '' }}</th>
                         <th>{{$data->lc_tt ?? '' }}</th>
                         <th>{{$data->currency ?? '' }}</th>
                         <th>{{$data->_cif_value_foreign ?? '' }}</th>
                         <th>{{$data->_cif_value_local ?? '' }}</th>
                         <th>{{$data->_rate_to_bdt ?? '' }}</th>
                         <th>{{$data->_local_amount ?? '' }}</th>
                         <th>{{$data->_note ?? '' }}</th>
                         <th>{{$data->_is_close ?? '' }}</th>
                         <th>{{$data->_user_id ?? '' }}</th>
                         <th>{{$data->_user_name ?? '' }}</th>
                         <th>{{$data->_status ?? '' }}</th>
                         <th>{{$data->_created_by ?? '' }}</th>
                         <th>{{$data->_updated_by ?? '' }}</th>
                         <th>{{$data->created_at ?? '' }}</th>
                         <th>{{$data->updated_at ?? '' }}</th>
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
    var _table_name ="lc_masters";
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