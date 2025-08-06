@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('salary_sheet_list') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
               @can('salary_sheet')
                <a class="btn btn-sm btn-info active " 
               href="{{ route('salary_sheet') }}">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
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
              <div class="card-header border-0 mt-1">
                 

                  <div class="row">
                 
                    <div class="col-md-4">
                     
                    </div>
                    <div class="col-md-8">
                      
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th>{{__('Action')}}</th>
                         <th>{{__('SL')}}</th>
                         <th>{{__('label.voucher_id')}}</th>
                         <th>{{__('label.voucher_code')}}</th>
                         <th>{{__('label._month')}}</th>
                         <th>{{__('label._year')}}</th>
                         <th>{{__('label.organization_id')}}</th>
                         <th>{{__('label._branch_id')}}</th>
                         <th>{{__('label._cost_center_id')}}</th>
                         <th>{{__('label.salary_amount')}}</th>
                         <th>{{__('label.allowance_amount')}}</th>
                         <th>{{__('label.deduction_amount')}}</th>
                         <th>{{__('label.net_payable_amount')}}</th>
                         <th>{{__('label._note')}}</th>
                         <th>{{__('label._user_name')}}</th>
                         <th>{{__('label._is_posting')}}</th>
                         <th>{{__('label._lock')}}</th>
                         <th>{{__('Created At')}}</th>
                         <th>{{__('Updated At')}}</th>
                         <th>{{__('label._status')}}</th>
                         @php
                         $default_image = $settings->logo;
                         @endphp           
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                          <td >
                           <a href="{{ route('branch_wise_sallary_sheet',$data->id) }}"
                                 class="btn btn-sm btn-info" >Salary Sheet</a>
                        </td>

                             
                            


                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->voucher_id ?? '' }}</td>
                            <td>{{ $data->voucher_code ?? '' }}</td>
                            <td>{{ _number_to_month($data->_month) ?? '' }}</td>
                            <td>{{ $data->_year ?? '' }}</td>
                            <td>{{ $data->_organization->_name ?? '' }}</td>
                            <td>{{ $data->_master_branch->_name ?? '' }}</td>
                            <td>{{ $data->_master_cost_center->_name ?? '' }}</td>
                            <td>{{ _report_amount($data->salary_amount ?? 0) }}</td>
                            <td>{{ _report_amount($data->allowance_amount ?? 0) }}</td>
                            <td>{{ _report_amount($data->deduction_amount ?? 0) }}</td>
                            <td>{{ _report_amount($data->net_payable_amount ?? 0) }}</td>
                            
                            <td>{!! $data->_note ?? '' !!}</td>
                            <td>{!! $data->_user_name ?? '' !!}</td>
                            <td>{!! $data->_is_posting ?? '' !!}</td>
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
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                           <td>{{ selected_status($data->_status) }}</td>
                           
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


@section("script")
<script type="text/javascript">
   $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });

$(document).on("click","._invoice_lock",function(){
    var _id = $(this).attr('_attr_invoice_id');
    var _table_name ="salary_sheets";
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