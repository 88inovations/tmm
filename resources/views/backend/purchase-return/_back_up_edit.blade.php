@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <h1 class="m-0 _page_name"> {{ $page_name ?? '' }} </h1>
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">

               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <a target="__blank" href="{{url('purchase-return/print')}}/{{$data->id}}" class="btn btn-sm btn-warning"> <i class="nav-icon fas fa-print"></i> </a>
                  
                
               </li>
               @endcan
               @can('item-information-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-ship"></i> 
                </button>
               </li>
               @endcan
              
               @can('account-ledger-create')
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-users"></i> 
                </button>
               </li>
               @endcan
                @can('purchase-form-settings')
             <li class="breadcrumb-item ">
                 <button type="button" id="form_settings" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModal">
                   <i class="nav-icon fas fa-cog"></i> 
                </button>
               </li>
              @endcan
               @can('purchase-create')
              <li class="breadcrumb-item active">
                        <a title="Add New" class="btn btn-success btn-sm" href="{{ route('purchase-return.create') }}"> <i class="nav-icon fas fa-plus"></i> </a>
               </li>
              @endcan
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('purchase-return.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 
                    @if (count($errors) > 0)
                           <div class="alert _required">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                  @if ($message = Session::get('success'))
                    <div class="alert ">
                      <p>{{ $message }}</p>
                    </div>
                    @endif
                  @if ($message = Session::get('danger'))
                    <div class="alert _required">
                      <p>{{ $message }}</p>
                    </div>
                    @endif
                    
              </div>
             
              <div class="card-body">
               <form action="{{url('purchase-return/update')}}" method="POST" class="purchase_form" >
                @csrf
                      <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-3">
                        <input type="hidden" name="_form_name" value="purchases_return">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_date)}}" />
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                              <input type="hidden" name="_purchase_id" value="{{$data->id}}">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_number">Order Number:</label>
                              <input type="text" id="_order_number" name="_order_number" class="form-control _order_number" value="{{old('_order_number',$data->_order_number)}}" placeholder="Order Number" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_order_ref_id">Purchase Order:</label>
                              <input type="text" id="_order_ref_id" name="_order_ref_id" class="form-control _order_ref_id" value="{{old('_order_ref_id',$data->_order_ref_id)}}" placeholder="Purchase Order" >
                                
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Supplier:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{old('_search_main_ledger_id',$data->_ledger->_name ?? '' )}}" placeholder="Supplier" required>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->_ledger_id)}}" placeholder="Supplier" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_referance">Referance:</label>
                              <input type="text" id="_referance" name="_referance" class="form-control _referance" value="{{old('_referance',$data->_referance)}}" placeholder="Referance" >
                                
                            </div>
                        </div>
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-middle" >&nbsp;</th>
                                            <th class="text-middle" >ID</th>
                                            <th class="text-middle" >Item</th>
                                           @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                            <th class="text-middle" >Barcode</th>
                                            @else
                                            <th class="text-middle display_none" >Barcode</th>
                                            @endif
                                            @endif
                                            <th class="text-middle" >Qty</th>
                                            <th class="text-middle" >Rate</th>
                                            <th class="text-middle" >Sales Rate</th>
                                            @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                            <th class="text-middle" >VAT%</th>
                                            <th class="text-middle" >VAT</th>
                                             @else
                                            <th class="text-middle display_none" >VAT%</th>
                                            <th class="text-middle display_none" >VAT Amount</th>
                                            @endif
                                            @endif

                                            <th class="text-middle" >Value</th>
                                             @if(sizeof($permited_branch) > 1)
                                            <th class="text-middle" >Branch</th>
                                            @else
                                            <th class="text-middle display_none" >Branch</th>
                                            @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                            <th class="text-middle" >Cost Center</th>
                                            @else
                                             <th class="text-middle display_none" >Cost Center</th>
                                            @endif
                                             @if(sizeof($store_houses) > 1)
                                            <th class="text-middle" >Store</th>
                                            @else
                                             <th class="text-middle display_none" >Store</th>
                                            @endif
                                            @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                            <th class="text-middle" >Shelf</th>
                                            @else
                                             <th class="text-middle display_none" >Shelf</th>
                                            @endif
                                            @endif
                                           
                                          </thead>
                                          @php
                                          $_total_qty_amount = 0;
                                          $_total_vat_amount =0;
                                          $_total_value_amount =0;
                                          @endphp
                                          <tbody class="area__purchase_details" id="area__purchase_details">
                                            @forelse($data->_master_details as $detail)
                                             @php
                                              $_total_qty_amount += $detail->_qty ??  0;
                                              $_total_vat_amount += $detail->_vat_amount ??  0;
                                              $_total_value_amount += $detail->_value ??  0;
                                              @endphp
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{ $detail->id }}
                                                <input type="hidden" name="purchase_detail_id[]" value="{{ $detail->id }}" class="form-control purchase_detail_id" >
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item" value="{{$detail->_items->_name ?? '' }}">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" value="{{$detail->_item_id}}">
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td>
                                                <input type="text" name="_barcode[]" class="form-control _barcode "  value="{{$detail->_barcode ?? '' }}" >
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_barcode[]" class="form-control _barcode "  value="{{$detail->_barcode ?? '' }}" >
                                              </td>
                                              @endif
                                            @endif
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup"  value="{{$detail->_qty ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="{{$detail->_rate ?? 0 }}" >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate " value="{{$detail->_sales_rate ?? 0 }}" >
                                              </td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td>
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="{{$detail->_vat ?? 0 }}">
                                              </td>
                                              <td>
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="{{$detail->_vat_amount ?? 0 }}">
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" value="{{$detail->_vat ?? 0 }}">
                                              </td>
                                              <td class="display_none">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" value="{{$detail->_vat_amount ?? 0 }}" >
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="{{ $detail->_value ?? 0 }}" >
                                              </td>
                                            @if(sizeof($permited_branch) > 1)  
                                              <td>
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($detail->_branch_id)) @if($detail->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                             @if(sizeof($permited_costcenters) > 1)
                                                <td>
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($detail->_cost_center_id)) @if($detail->_cost_center_id == $costcenter->id) selected @endif   @endif > {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td>
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}"  @if(isset($detail->_store_id)) @if($detail->_store_id == $costcenter->id) selected @endif   @endif >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}"   @if(isset($detail->_store_id)) @if($detail->_store_id == $costcenter->id) selected @endif   @endif  >{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @endif
                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td>
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="{{$detail->_store_salves_id ?? '' }}">
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " value="{{$detail->_store_salves_id ?? '' }}" >
                                              </td>
                                              @endif
                                              @endif
                                              
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="purchase_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td  class="text-right"></td>
                                              @else
                                                <td  class="text-right display_none"></td>
                                             @endif
                                            @endif
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="{{$_total_qty_amount}}" readonly required>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="{{$_total_vat_amount ?? 0}}" readonly required>
                                              </td>
                                              @else
                                              <td class="display_none"></td>
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_vat_amount" class="form-control _total_vat_amount" value="{{$_total_vat_amount ?? 0}}" readonly required>
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="{{$_total_value_amount ?? 0}}" readonly required>



                                              </td>
                                              @if(sizeof($permited_branch) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif

                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td></td>
                                              @else
                                              @endif
                                              <td class="display_none"></td>
                                              @endif
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
                       
                          <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Account Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>ID</th>
                                            <th>Ledger</th>
                                            
                                          
                                            @if(sizeof($permited_costcenters)>1)
                                               <th>Branch</th>
                                              @else
                                               <th class="display_none">Branch</th>
                                              @endif
                                              @if(sizeof($permited_costcenters)>1)
                                                <th>Cost Center</th>
                                              @else
                                                <th class="display_none">Cost Center</th>
                                              @endif
                                            <th>Short Narr.</th>
                                            <th>Dr. Amount</th>
                                            <th>Cr. Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details form_body" id="area__voucher_details">
                                            @php
                                              $_account_dr_total = 0;
                                              $_account_cr_total = 0;
                                            @endphp
                                            @forelse($data->purchase_account as $account)

                                            @php
                                              $_account_dr_total += $account->_dr_amount ?? 0;
                                              $_account_cr_total += $account->_cr_amount ?? 0;
                                            @endphp
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                {{$account->id}}
                                                <input type="hidden" name="purchase_account_id[]" class="form-control purchase_account_id" value="{{$account->id}}">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger" value="{{ $account->_ledger->_name ?? '' }}">
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" value="{{$account->_ledger_id}}" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                               @if(sizeof($permited_costcenters)>1)
                                              <td>
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($account->_branch_id)) @if($account->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($account->_branch_id)) @if($account->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif

                                              @if(sizeof($permited_costcenters)>1)
                                                <td>
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($account->_cost_center)) @if($account->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                              <td class="display_none">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required  >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($account->_cost_center)) @if($account->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr" value="{{$account->_short_narr ?? '' }}">
                                              </td>
                                              <td>
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',$account->_dr_amount ?? 0 )}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',$account->_cr_amount ?? 0 )}}">
                                              </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td></td>
                                              <td></td>
                                              @if(sizeof($permited_costcenters)>1)
                                               <td></td>
                                              @else
                                               <td class="display_none"></td>
                                              @endif
                                              @if(sizeof($permited_costcenters)>1)
                                              <td></td>
                                              @else
                                              <td class="display_none"></td>
                                              @endif
                                             
                                              
                                              <td  class="text-right"><b>Total</b></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="{{$_account_dr_total}}" readonly required>
                                              </td>


                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="{{$_account_cr_total}}" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                          <table class="table" style="border-collapse: collapse;">
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_note">Note</label></td>
                              <td style="width: 70%;border:0px;">
                                @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('purchase/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note',$data->_note ?? '' )}}" placeholder="Note" required >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_sub_total">Sub Total</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_sub_total" class="form-control width_200_px" id="_sub_total" readonly value="{{ $data->_sub_total ?? 0 }}">
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_discount_input">Invoice Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_discount_input" class="form-control width_200_px" id="_discount_input" value="{{$data->_discount_input ?? 0}}" >
                              </td>
                            </tr>
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total_discount">Total Discount</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_discount" class="form-control width_200_px" id="_total_discount" readonly value="{{$data->_total_discount ?? 0}}">
                              </td>
                            </tr>
                            @if(isset($form_settings->_show_vat)) 
                            @if($form_settings->_show_vat==1)
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total_vat">Total VAT</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_total_vat" readonly value="{{$data->_total_vat ?? 0}}">
                              </td>
                            </tr>
                            @else
                            <tr class="display_none">
                              <td style="width: 10%;border:0px;"><label for="_total_vat">Total VAT</label></td>
                              <td style="width: 70%;border:0px;">
                                <input type="text" name="_total_vat" class="form-control width_200_px" id="_total_vat" readonly value="{{$data->_total_vat ?? 0}}">
                              </td>
                            </tr>
                            @endif
                            @endif
                            <tr>
                              <td style="width: 10%;border:0px;"><label for="_total">NET Total </label></td>
                              <td style="width: 70%;border:0px;">
                          <input type="text" name="_total" class="form-control width_200_px" id="_total" readonly value="{{$data->_total ?? 0}}">
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                          @if($sales_number > 0 )
                          <p>You Can not update This invoice Item.Please Use Purchase Return <a href="{{url('purchase-return/create')}}" class="btn btn-sm btn-danger">Purchase Return</a></p>
                          @else
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
                          @endif
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ url('purchase-settings')}}" method="POST">
        @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Purchase Form Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <div class="form-group row">
        <label for="_default_inventory" class="col-sm-5 col-form-label">Default Inventory</label>
        <select class="form-control col-sm-7" name="_default_inventory">
          @foreach($inv_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_inventory))@if($form_settings->_default_inventory==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_purchase" class="col-sm-5 col-form-label">Default Purchase Account</label>
        <select class="form-control col-sm-7" name="_default_purchase">
          @foreach($p_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_purchase))@if($form_settings->_default_purchase==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_discount" class="col-sm-5 col-form-label">Default Discount Account</label>
        <select class="form-control col-md-7" name="_default_discount">
          @foreach($dis_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_discount))@if($form_settings->_default_discount==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_default_vat_account" class="col-sm-5 col-form-label">Default VAT Account</label>
        <select class="form-control col-md-7" name="_default_vat_account">
          @foreach($vat_accounts as $account)
          <option value="{{$account->id}}" @if(isset($form_settings->_default_vat_account))@if($form_settings->_default_vat_account==$account->id) selected @endif @endif>{{ $account->_name ?? '' }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_vat" class="col-sm-5 col-form-label">Show VAT</label>
        <select class="form-control col-sm-7" name="_show_vat">
         
          <option value="0" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_vat))@if($form_settings->_show_vat==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_barcode" class="col-sm-5 col-form-label">Show Barcode</label>
        <select class="form-control col-sm-7" name="_show_barcode">
          <option value="0" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_barcode))@if($form_settings->_show_barcode==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_store" class="col-sm-5 col-form-label">Show Store</label>
        <select class="form-control col-sm-7" name="_show_store">
          <option value="0" @if(isset($form_settings->_show_store))@if($form_settings->_show_store==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_store))@if($form_settings->_show_store==1) selected @endif @endif>YES</option>
        </select>
      </div>
      <div class="form-group row">
        <label for="_show_self" class="col-sm-5 col-form-label">Show Shelf</label>
        <select class="form-control col-sm-7" name="_show_self">
          <option value="0" @if(isset($form_settings->_show_self))@if($form_settings->_show_self==0) selected @endif @endif>NO</option>
          <option value="1" @if(isset($form_settings->_show_self))@if($form_settings->_show_self==1) selected @endif @endif>YES</option>
        </select>
      </div>
         
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>



</div>
<div class="modal fade" id="exampleModalLong_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create New Item (Inventory)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="_item_modal_form">
          <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Category: <span class="_required">*</span></label>
                               <select  class="form-control _category_id" name="_category_id" required>
                                  <option value="">--Select Category--</option>
                                  @forelse($categories as $category )
                                  <option value="{{$category->id}}" >{{ $category->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                      
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="_item">Item:<span class="_required">*</span></label>
                                <input type="text" id="_item" name="_item" class="form-control _item_item" value="{{old('_item')}}" placeholder="Item" required>
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_code">Code:</label>
                                <input type="text" id="_code" name="_code" class="form-control _item_code" value="{{old('_code')}}" placeholder="Code" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_unit">Unit:<span class="_required">*</span></label>

                                <select class="form-control _unit_id _item_unit_id" id="_unit_id" name="_unit_id" required>
                                  <option value="" >--Units--</option>
                                  @foreach($units as $unit)
                                   <option value="{{$unit->id}}" >{{$unit->_name ?? ''}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_barcode">Model:</label>
                                <input type="text" id="_barcode" name="_barcode" class="form-control _item_barcode" value="{{old('_barcode')}}" placeholder="Model" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_discount">Discount Rate:</label>
                                <input type="text" id="_discount" name="_discount" class="form-control _item_discount" value="{{old('_discount')}}" placeholder="Discount Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_vat">Vat Rate:</label>
                                <input type="text" id="_vat" name="_vat" class="form-control _item_vat" value="{{old('_vat')}}" placeholder="Vat Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_pur_rate">Purchase Rate:</label>
                                <input type="text" id="_pur_rate" name="_pur_rate" class="form-control _item_pur_rate" value="{{old('_pur_rate')}}" placeholder="Purchase Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_sale_rate">Sales Rate:</label>
                                <input type="text" id="_sale_rate" name="_sale_rate" class="form-control _item_sale_rate" value="{{old('_sale_rate')}}" placeholder="Sales Rate" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_manufacture_company">Manufacture Company:</label>
                                <input type="text" id="_manufacture_company" name="_manufacture_company" class="form-control _item_manufacture_company" value="{{old('_manufacture_company')}}" placeholder="Manufacture Company" >
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="_status">Status:</label>
                                <select class="form-control _item_status" name="_status" id="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
          </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_item">Save </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create Ledger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="_ledger_modal_form">
        <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Account Type: <span class="_required">*</span></strong>
                               <select type_base_group="{{url('type_base_group')}}" class="form-control _account_head_id" name="_account_head_id" required>
                                  <option value="">--Select Account Type--</option>
                                  @forelse($account_types as $account_type )
                                  <option value="{{$account_type->id}}" @if(isset($request->_account_head_id)) @if($request->_account_head_id == $account_type->id) selected @endif   @endif>{{ $account_type->id ?? '' }}-{{ $account_type->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <strong>Account Group:<span class="_required">*</span></strong>
                               <select class="form-control _account_groups" name="_account_group_id" required>
                                  <option value="">--Select Account Group--</option>
                                  @forelse($account_groups as $account_group )
                                  <option value="{{$account_group->id}}" @if(isset($request->_account_group_id)) @if($request->_account_group_id == $account_group->id) selected @endif   @endif>{{ $account_group->id ?? '' }} - {{ $account_group->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                <strong>Branch:<span class="_required">*</span></strong>
                               <select class="form-control _ledger_branch_id" name="_ledger_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Ledger Name:<span class="_required">*</span></strong>
                                
                                <input type="text" name="_name" class="form-control _ledger_name" value="{{old('_name')}}" placeholder="Ledger Name" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Address:</strong>
                                <input type="text" name="_address" class="form-control _ledger_address" value="{{old('_address')}}" placeholder="Address" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Code:</strong>
                                <input type="text" name="_code" class="form-control _ledger_code" value="{{old('_code')}}" placeholder="CODE Number">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Display Possition:</strong>
                                {!! Form::text('_short', null, array('placeholder' => 'Possition','class' => 'form-control _ledger_short')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>NID Number:</strong>
                               <input type="text" name="_nid" class="form-control _ledger_nid" value="{{old('_nid')}}" placeholder="NID Number">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="_email" class="form-control _ledger_email" value="{{old('_email')}}" placeholder="Email" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Phone:</strong>
                                <input type="text" name="_phone" class="form-control _ledger_phone" value="{{old('_phone')}}" placeholder="Phone" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Credit Limit:</strong>
                                <input type="number" step="any" name="_credit_limit" class="form-control _ledger_credit_limit" value="{{old('_credit_limit',0)}}" placeholder="Credit Limit" >
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Is User:</strong>
                                <select class="form-control _ledger_is_user" name="_is_user">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Sales Form:</strong>
                                <select class="form-control _ledger_is_sales_form" name="_is_sales_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Is Purchase Form:</strong>
                                <select class="form-control _ledger_is_purchase_form" name="_is_purchase_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Search For All Branch:</strong>
                                <select class="form-control _ledger_is_all_branch" name="_is_all_branch">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Status:</strong>
                                <select class="form-control _ledger_status" name="_status">
                                  @foreach(common_status() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                       
                      
                      
                    </div>
              </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_ledger">Save </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
  @if(empty($form_settings))
    $("#form_settings").click();
  @endif
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }


  $(document).on('click','.save_item',function(){
    var _category_id = $("._category_id").val();
    var _item_item = $("._item_item").val();
    var _item_code = $("._item_code").val();
    var _item_unit_id = $("._item_unit_id").val();
    var _item_barcode = $("._item_barcode").val();
    var _item_discount = $("._item_discount").val();
    var _item_vat = $("._item_vat").val();
    var _item_pur_rate = $("._item_pur_rate").val();
    var _item_sale_rate = $("._item_sale_rate").val();
    var _item_manufacture_company = $("._item_manufacture_company").val();
    var _item_status = $("._item_status").val();
    
    var reqired_fields = 0;
    if(_category_id ==""){
       $(document).find('._category_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._category_id').removeClass('required_border');
    }
    if(_item_item ==""){
       $(document).find('._item_item').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_item').removeClass('required_border');
    }
    if(_item_unit_id ==""){
       $(document).find('._item_unit_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_unit_id').removeClass('required_border');
    }
    
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'POST',
           url:"{{ url('ajax-item-save') }}",
           data:{_category_id,_item_item,_item_code,_item_unit_id,_item_barcode,_item_discount,_item_vat,_item_pur_rate,_item_sale_rate,_item_manufacture_company,_item_status
           },
           success:function(data){
              if(data !=""){
                alert("Information Save Successfully");
                $(document).find("._item_modal_form").trigger('reset');
                $(document).find(".modal_close").click();
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

  $(document).on('click','.save_ledger',function(){
    var _account_head_id = $("._account_head_id").val();
    var _account_groups = $("._account_groups").val();
    var _ledger_branch_id = $("._ledger_branch_id").val();
    var _ledger_name = $("._ledger_name").val();
    var _ledger_address = $("._ledger_address").val();
    var _ledger_code = $("._ledger_code").val();
    var _ledger_short = $("._ledger_short").val();
    var _ledger_nid = $("._ledger_nid").val();
    var _ledger_phone = $("._ledger_phone").val();
    var _ledger_email = $("._ledger_email").val();
    var _ledger_credit_limit = $("._ledger_credit_limit").val();
    var _ledger_is_user = $("._ledger_is_user").val();
    var _ledger_is_sales_form = $("._ledger_is_sales_form").val();
    var _ledger_is_purchase_form = $("._ledger_is_purchase_form").val();
    var _ledger_is_all_branch = $("._ledger_is_all_branch").val();
    var _ledger_status = $("._ledger_status").val();
    var reqired_fields = 0;
    if(_account_head_id ==""){
       $(document).find('._account_head_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_head_id').removeClass('required_border');
    }
    if(_account_groups ==""){
       $(document).find('._account_groups').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_groups').removeClass('required_border');
    }
    if(_ledger_name ==""){
       $(document).find('._ledger_name').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._ledger_name').removeClass('required_border');
    }
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'POST',
           url:"{{ url('ajax-ledger-save') }}",
           data:{_account_head_id,_account_groups,_ledger_branch_id,_ledger_name,_ledger_address,_ledger_code,_ledger_short,_ledger_nid,_ledger_phone,_ledger_email,_ledger_credit_limit,_ledger_is_user,_ledger_is_sales_form,_ledger_is_purchase_form,_ledger_is_all_branch,_ledger_status
           },
           success:function(data){
              if(data !=""){
                alert("Information Save Successfully");
                $(document).find("._ledger_modal_form").trigger('reset');
                $(document).find(".modal_close").click();
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

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
    $("._main_ledger_id").val(_id);
    $("._search_main_ledger_id").val(_name);

    $('.search_box_main_ledger').hide();
    $('.search_box_main_ledger').removeClass('search_box_show').hide();
  })

  $(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  <input type="hidden" name="_item_sales_rate" class="_item_sales_rate" value="${data[i]._sale_rate}">
                                  <input type="hidden" name="_item_vat" class="_item_vat" value="${data[i]._vat}">
                                   </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();
  var _item_sales_rate = $(this).find('._item_sales_rate').val();
  var _item_vat = parseFloat($(this).find('._item_vat').val());
  if(isNaN(_item_vat)){ _item_vat=0 }
  _vat_amount = ((_item_rate*_item_vat)/100)
  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._barcode').val(_item_barcode);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._sales_rate').val(_item_sales_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat').val(_item_vat);
  $(this).parent().parent().parent().parent().parent().parent().find('._vat_amount').val(_vat_amount);
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(_item_rate);

  _purchase_total_calculation();
  $('.search_box_item').hide();
  $('.search_box_item').removeClass('search_box_show').hide();
})

$(document).on('click',function(){
    var searach_show= $('.search_box_item').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box_item').removeClass('search_box_show').hide();
    }
})

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _item_vat = $(this).closest('tr').find('._vat').val();
   if(isNaN(_item_vat)){ _item_vat   = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   _vat_amount = Math.ceil(((_qty*_rate)*_item_vat)/100)

    $(this).closest('tr').find('._value').val((_qty*_rate));
  $(this).closest('tr').find('._vat_amount').val(_vat_amount);
    _purchase_total_calculation();
})

$(document).on('keyup','._vat_amount',function(){
 var _item_vat =0;
  var _qty = $(this).closest('tr').find('._qty').val();
  var _rate = $(this).closest('tr').find('._rate').val();
  var _vat_amount =  $(this).closest('tr').find('._vat_amount').val();
  
   if(isNaN(_vat_amount)){ _vat_amount = 0 }
   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   var _vat = parseFloat((_vat_amount/(_rate*_qty))*100).toFixed(2);
    $(this).closest('tr').find('._vat').val(_vat);

    $(this).closest('tr').find('._value').val((_qty*_rate));
 
    _purchase_total_calculation();
})

$(document).on("change","#_discount_input",function(){
  var _discount_input = $(this).val();
  var res = _discount_input.match(/%/gi);
  if(res){
     res = _discount_input.split("%");
    res= parseFloat(res);
    on_invoice_discount = ($("#_sub_total").val()*res)/100
    $("#_discount_input").val(on_invoice_discount)

  }else{
    on_invoice_discount = _discount_input;
  }

   $("#_total_discount").val(on_invoice_discount);
    _purchase_total_calculation()
})



 function _purchase_total_calculation(){
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
      $(document).find("._value").each(function() {
          _total__value +=parseFloat($(this).val());
      });
      $(document).find("._qty").each(function() {
          _total_qty +=parseFloat($(this).val());
      });
      $(document).find("._vat_amount").each(function() {
          _total__vat +=parseFloat($(this).val());
      });
      $("._total_qty_amount").val(_total_qty);
      $("._total_value_amount").val(_total__value);
      $("._total_vat_amount").val(_total__vat);

      var _discount_input = parseFloat($("#_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }

      $("#_sub_total").val(_total__value);
      $("#_total_vat").val(_total__vat);
      $("#_total_discount").val(_discount_input);
      var _total = (parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_discount_input)
      $("#_total").val(_total);
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td>
                      <input type="hidden" name="purchase_account_id[]" class="form-control purchase_account_id" value="0"  />
                      </td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                       @if(sizeof($permited_branch)>1)
                      <td>
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @else
                          <td class="display_none">
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        @endif

                         @if(sizeof($permited_costcenters)>1)
                        <td>
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @else
                        <td class="display_none">
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                        @endif
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td>
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }

var _purchase_row_single =`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                              <input type="hidden" name="purchase_detail_id[]" class="form-control purchase_detail_id" value="0" />
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item">
                                                  
                                                </div>
                                              </td>
                                              @if(isset($form_settings->_show_barcode)) @if($form_settings->_show_barcode==1)
                                              <td>
                                                <input type="text" name="_barcode[]" class="form-control _barcode " >
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_barcode[]" class="form-control _barcode " >
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="number" name="_sales_rate[]" class="form-control _sales_rate " >
                                              </td>
                                               @if(isset($form_settings->_show_vat)) @if($form_settings->_show_vat==1)
                                              <td>
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                              <td>
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" >
                                              </td>
                                              @else
                                                <td class="display_none">
                                                <input type="text" name="_vat[]" class="form-control  _vat _common_keyup" >
                                              </td>
                                              <td class="display_none">
                                                <input type="text" name="_vat_amount[]" class="form-control  _vat_amount" >
                                              </td>
                                              @endif
                                              @endif
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly >
                                              </td>
                                              @if(sizeof($permited_branch)>1)
                                              <td>
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control  _main_branch_id_detail" name="_main_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                              @if(sizeof($permited_costcenters)>1)
                                                <td>
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @else
                                               <td class="display_none">
                                                 <select class="form-control  _main_cost_center" name="_main_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_main_cost_center)) @if($request->_main_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              @endif
                                              @if(sizeof($store_houses) > 1)
                                              <td>
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <select class="form-control  _main_store_id" name="_main_store_id[]">
                                                  @forelse($store_houses as $store)
                                                  <option value="{{$store->id}}">{{$store->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                                
                                              </td>
                                              @endif
                                              @if(isset($form_settings->_show_self)) @if($form_settings->_show_self==1)
                                              <td>
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              @else
                                              <td class="display_none">
                                                <input type="text" name="_store_salves_id[]" class="form-control _store_salves_id " >
                                              </td>
                                              @endif

                                              @endif
                                              
                                            </tr>`;
function purchase_row_add(event){
   event.preventDefault();
      $("#area__purchase_details").append(_purchase_row_single);
}
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._item_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _purchase_total_calculation();
  })

  $(document).on('click','._voucher_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._ledger_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _voucher_total_calculation();
  })

  function _voucher_total_calculation(){
    var _total_dr_amount = 0;
    var _total_cr_amount = 0;
      $(document).find("._cr_amount").each(function() {
          _total_cr_amount +=parseFloat($(this).val());
      });
      $(document).find("._dr_amount").each(function() {
          _total_dr_amount +=parseFloat($(this).val());
      });
      $("._total_dr_amount").val(_total_dr_amount);
      $("._total_cr_amount").val(_total_cr_amount);
  }


  $(document).on('keyup','._dr_amount',function(){
    $(this).parent().parent('tr').find('._cr_amount').val(0);
    $(document).find("._total_dr_amount").removeClass('required_border');
    $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })



  $(document).on('keyup','._cr_amount',function(){
     $(this).parent().parent('tr').find('._dr_amount').val(0);
     $(document).find("._total_dr_amount").removeClass('required_border');
      $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })

  $(document).on('change','._voucher_type',function(){
    $(document).find('._voucher_type').removeClass('required_border');
  })

  $(document).on('keyup','._note',function(){
    $(document).find('._note').removeClass('required_border');
  })

  $(document).on('click','._save_and_print',function(){
    $(document).find('._save_and_print_value').val(1);
  })


  $(document).on('click','.submit-button',function(event){
    event.preventDefault();
    var _total_dr_amount = $(document).find("._total_dr_amount").val();
    var _total_cr_amount = $(document).find("._total_cr_amount").val();
    var _voucher_type = $(document).find('._voucher_type').val();
    var _note = $(document).find('._note').val();
    var _main_ledger_id = $(document).find('._main_ledger_id').val();
    if(_main_ledger_id  ==""){
       alert(" Please Add Ledger  ");
        $(document).find('._search_main_ledger_id').addClass('required_border').focus();
        return false;
    }


    var empty_ledger = [];
    $(document).find("._search_item_id").each(function(){
        if($(this).val() ==""){
          console.log($(this))
          alert(" Please Add Item  ");
          $(this).addClass('required_border');
          empty_ledger.push(1);
        }  
    })

    if(empty_ledger.length > 0){
      return false;
    }


    if( parseFloat(_total_dr_amount) !=parseFloat(_total_cr_amount)){
      $(document).find("._total_dr_amount").addClass('required_border').focus();
      $(document).find("._total_cr_amount").addClass('required_border').focus();
      return false;

    }else if(_voucher_type ==""){
       $(document).find('._voucher_type').addClass('required_border').focus();
       alert('Please Select Voucher Type.');
      return false;
    }else if(_note ==""){
       
       $(document).find('._note').focus().addClass('required_border');
      return false;
    }else if(_main_ledger_id ==""){
       
      $(document).find('._search_main_ledger_id').focus().addClass('required_border');
      return false;
    }else{
      $(document).find('.purchase_form').submit();
    }
  })




 

$(".datetimepicker-input").val(date__today())

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

</script>
@endsection

