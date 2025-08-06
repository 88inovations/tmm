@extends('backend.layouts.app')
@section('title',$settings->title)

@section('content')
<style type="text/css">
    .label_div{
        width: 250px;
    }
    .form-group{
        display: flex;
        border: 1px solid silver;
    }
</style>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">{!! $page_name ?? '' !!} </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @can('account-ledger-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('account-ledger.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">ID:</div>
                        {{ $data->id }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label.organization_id')}}:</div>
                        {{ _id_to_name($data->organization_id ?? 1,'_name','companies')  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._branch_id')}}:</div>
                        {{ _id_to_name($data->_branch_id,'_name','branches')  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._main_account_id')}}:</div>
                        {{ _id_to_name($data->_main_account_id,'_name','main_account_head')  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Ledger:</div>
                        {{ $data->_name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._alious')}}:</div>
                        {{ $data->_alious ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Account Type:</div>
                       {{ $data->account_type->_name ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Account Group:</div>
                      {{ $data->account_group->_name ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Code:</div>
                      {{ $data->_code ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Email:</div>
                      {{ $data->_email ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Phone:</div>
                      {{ $data->_phone ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._nid')}}:</div>
                      {{ $data->_nid ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._address')}}:</div>
                      {{ $data->_address ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._designation')}}:</div>
                      {{ $data->_designation ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._specialist')}}:</div>
                      {{ $data->_specialist ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._address_2')}}:</div>
                      {{ $data->_address_2 ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._date_of_birth')}}:</div>
                      {{ $data->_date_of_birth ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._whatsup_number')}}:</div>
                      {{ $data->_whatsup_number ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._reg_no')}}:</div>
                      {{ $data->_reg_no ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._credit_limit')}}:</div>
                      {{ $data->_credit_limit ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._is_user')}}:</div>
                      {{ $data->_is_user ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._user_id')}}:</div>
                      {{ $data->_user_id ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._is_sales_form')}}:</div>
                      {{ $data->_is_sales_form ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._is_purchase_form')}}:</div>
                      {{ $data->_is_purchase_form ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._is_used')}}:</div>
                      {{ $data->_is_used ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._note')}}:</div>
                      {{ $data->_note ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label.created_at')}}:</div>
                      {{ $data->created_at ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label.updated_at')}}:</div>
                      {{ $data->updated_at ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Balance:</div>
                      {{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Possition:</div>
                    {{ $data->_short ?? '' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._image')}}:</div>
                        <a href="{{ asset($data->_image ?? $settings->logo) }}" download>
                    <img src="{{asset($data->_image ?? $settings->logo)}}" style="width:200px;height: auto;" />
                </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._nid_image')}}:</div>
                        <a href="{{ asset($data->_nid_image ?? $settings->logo) }}" download>
                    <img src="{{asset($data->_nid_image ?? $settings->logo)}}" style="width:200px;height: auto;" />
                </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">{{__('label._checkpage_image')}}:</div>
                        <a href="{{ asset($data->_checkpage_image ?? $settings->logo) }}" download>
                    <img src="{{asset($data->_checkpage_image ?? $settings->logo)}}" style="width:200px;height: auto;" />
                </a>
                    </div>
                </div>

 
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="label_div">Status:</div>
                    {{ selected_status($data->_status) }}
                    </div>
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