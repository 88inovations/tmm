@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
@include('messages.language_message')
<div class="content">
<div class="container-fluid">
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_sales_list')
            <li class="breadcrumb-item"><a href="{{route('asset_sales_list')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('asset_sales_store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>

@php
$organization_id = $data->organization_id ?? '';
$_branch_id = $data->_branch_id ?? '';
$_cost_center_id = $data->_cost_center_id ?? '';
$_budget_id = $data->_budget_id ?? '';
@endphp
          <div class="row g-5">
            <div class="col-12 col-xl-12">
              
<div class="row g-0 border-top border-bottom border-300" style="padding:10px; ;">
               
                             <label class=" text-1000 col-md-4 text-right mt-2">{{__('label._date')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="date"   name="_date" class="form-control _date" value="{{old('_date',date('Y-m-d'))}}" placeholder="{{__('label._date')}}" >
                          </div>
                        
                       
                     <label class="text-1000 col-md-4 _required text-right mt-2">{{__('label.organization_id')}}</label><br>
                            <div class="col-md-6">
                             <select class="form-control mt-2" name="organization_id" required>
                                 <option value="">Select {{__('label.organization_id')}}</option>
                                @forelse($organizations as $key=>$val)
                                <option value="{{$val->id}}" @if($organization_id==$val->id) selected @endif >{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                              
                        </div>
                            <label class="text-1000 col-md-4 _required text-right mt-2">{{__('label._branch_id')}}</label><br>
                        <div class="col-md-6">
                           
                             <select class="form-control mt-2" name="_branch_id" required>
                                 <option value="">Select {{__('label._branch_id')}}</option>
                                @forelse($branchs as $key=>$val)
                                <option value="{{$val->id}}"   @if($_branch_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                               
                        </div>
                            <label class="text-1000 col-md-4 _required text-right mt-2">{{__('label._cost_center_id')}}</label><br>
                        <div class="col-md-6">
                            <div >
                             <select class="form-control mt-2" name="_cost_center_id" required>
                                 <option value="">Select {{__('label._cost_center_id')}}</option>
                                @forelse($cost_centers as $key=>$val)
                                <option value="{{$val->id}}"  @if($_cost_center_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>
                            <label class="text-1000 col-md-4 _required text-right mt-2">{{__('label._budget_id')}}</label><br>
                        <div class="col-md-6">
                            <div >
                             <select class="form-control mt-2" name="_budget_id" >
                                 <option value="">Select {{__('label._budget_id')}}</option>
                                @forelse($budgets as $key=>$val)
                                <option value="{{$val->id}}"   @if($_budget_id==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                @empty
                                @endforelse
                              </select>
                                </div>
                        </div>     
                      
                   <label class=" col-md-4 mt-2 text-right text-1000">{{__('label.asset_ledger_id')}}<span class="_required">*</span></label>
                 
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id mt-2" value="{{old('_search_main_ledger_id')}}" placeholder="{{__('label.asset_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}" readonly>

                            <input type="hidden" id="asset_ledger_id" name="asset_ledger_id" class="form-control asset_ledger_id" value="{{old('asset_ledger_id')}}"  required>
                            <div class="search_box_main_ledger"> </div>
                    </div>
               
         
                         
                    
                   <label class="col-sm-4 mt-2 text-1000 text-right">{{__('label.asset_dep_ledger_id')}}<span class="_required">*</span></label>
                  
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search_asset_dep_ledger_id" name="_search_asset_dep_ledger_id" class="form-control _search_asset_dep_ledger_id" value="{{old('_search_asset_dep_ledger_id')}}" placeholder="{{__('label.asset_dep_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}" readonly>

                            <input type="hidden" id="asset_dep_ledger_id" name="asset_dep_ledger_id" class="form-control asset_dep_ledger_id" value="{{old('asset_dep_ledger_id')}}"  required>
                            <div class="asset_dep_search_box_main_ledger"> </div>
                    </div>
               
               
                   <label class="col-sm-4 mt-2 text-1000 text-right">{{__('label.asset_dep_exp_ledger_id')}}<span class="_required">*</span></label>
                  
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search_asset_dep_exp_ledger_id" name="_search_asset_dep_exp_ledger_id" class="form-control _search_asset_dep_exp_ledger_id" value="{{old('_search_asset_dep_exp_ledger_id')}}" placeholder="{{__('label.asset_dep_exp_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}" readonly>

                            <input type="hidden" id="asset_dep_exp_ledger_id" name="asset_dep_exp_ledger_id" class="form-control asset_dep_exp_ledger_id" value="{{old('asset_dep_exp_ledger_id')}}"  required>
                            <div class="asset_dep_exp_search_box_main_ledger"> </div>
                    </div>
             
                
                      
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.name')}}<span class="_required">*</span></label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="name" class="form-control asset_name_search mt-2" value="{!! old('name') !!}" placeholder="{{__('label.name')}}" attr_url="{{route('asset_search')}}">
                               <input type="hidden" id="_asset_id" name="_asset_id" class="form-control _asset_id" value="{{old('_asset_id')}}"  required >
                            <div class="asset_name_box"> </div>

                          </div>
                       
                        
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.asset_tag')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_tag" class="form-control asset_tag" value="{{old('asset_tag')}}" placeholder="{{__('label.asset_tag')}}"  attr_url="{{route('asset_search')}}">
                                <div class="asset_name_box"> </div>
                              </div>
                        
                       
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.asset_code')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_code" class="form-control asset_code" value="{{old('asset_code')}}" placeholder="{{__('label.asset_code')}}" attr_url="{{route('asset_search')}}">
                               <div class="asset_name_box"> </div>
                          </div>
                      
                         
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.model_no')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="model_no" class="form-control model_no" value="{{old('model_no')}}" placeholder="{{__('label.model_no')}}" attr_url="{{route('asset_search')}}">
                              <div class="asset_name_box"> </div>
                          </div>
                        
                         
                        

                        
                        
                       
                        
                       
                       
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.purchase_price')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="number" min="0" step="any"  name="purchase_price" class="form-control purchase_price" value="{{old('purchase_price')}}" placeholder="{{__('label.purchase_price')}}" readonly>
                          </div>
                     
                       
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.extra_cost')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="number" min="0" step="any"  name="extra_cost" class="form-control extra_cost" value="{{old('extra_cost')}}" placeholder="{{__('label.extra_cost')}}" readonly>
                          </div>
                        
                        
                        
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.evaluated_price')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="number" min="0" step="any"  name="evaluated_price" class="form-control evaluated_price" value="{{old('evaluated_price')}}" placeholder="{{__('label.evaluated_price')}}" readonly>
                          </div>
                      
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.accumulated_dep_val')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control accumulated_dep_val" type="number" min="0" step="any" name="accumulated_dep_val" value="{{old('accumulated_dep_val')}}" placeholder="{{__('label.accumulated_dep_val')}}" readonly >
                         </div>
                      
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.book_value')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control book_value" type="number" min="0" step="any" name="book_value" value="{{old('book_value')}}" placeholder="{{__('label.book_value')}}" readonly>
                         </div>
                       
                         
                 
                   <label class="col-sm-4 mt-2 text-1000 text-right">{{__('label.customer_ledger_id')}}<span class="_required">*</span></label>
                 
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search_customer_ledger_id" name="_search_customer_ledger_id" class="form-control _search_customer_ledger_id" value="{{old('_search_customer_ledger_id')}}" placeholder="{{__('label.customer_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="customer_ledger_id" name="customer_ledger_id" class="form-control customer_ledger_id" value="{{old('customer_ledger_id')}}"  required>
                            <div class="customer_search_box_main_ledger"> </div>
                    </div>
              
                         
                 
                   <label class=" col-sm-4 mt-2 text-1000 text-right">Cash/Bank Account</label>
                  
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search__payment_receive_id" name="_search__payment_receive_id" class="form-control _search__payment_receive_id" value="{{old('_search__payment_receive_id')}}" placeholder="{{__('label._payment_receive_id')}}"   attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="_payment_receive_id" name="_payment_receive_id" class="form-control _payment_receive_id" value="{{old('_payment_receive_id')}}"  >
                            <div class="cash_bank_search_box_main_ledger"> </div>
                    </div>
             
                         
                   
                   <label class=" mt-2 text-1000 text-right col-sm-4">{{__('label.gain_or_loss_ledger_id')}}<span class="_required">*</span></label>
                  
                    <div class="col-sm-6 mt-2">
                  
                            <input type="text" id="_search_gain_or_loss_ledger_id" name="_search_gain_or_loss_ledger_id" class="form-control _search_gain_or_loss_ledger_id" value="{{old('_search_gain_or_loss_ledger_id')}}" placeholder="{{__('label.gain_or_loss_ledger_id')}}"   attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="gain_or_loss_ledger_id" name="gain_or_loss_ledger_id" class="form-control gain_or_loss_ledger_id" value="{{old('gain_or_loss_ledger_id')}}"  >
                            <div class="gain_loss_box"> </div>
                    </div>
              
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.sale_price')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control sale_price" type="number" min="0" step="any" name="sale_price" value="{{old('sale_price')}}" placeholder="{{__('label.sale_price')}}" >
                         </div>
                      
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label.gain_loss')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control gain_loss" type="number" min="0" step="any" name="gain_loss" value="{{old('gain_loss')}}" placeholder="{{__('label.gain_loss')}}" readonly>
                         </div>
                    
                             <label class="mt-2 text-1000 text-right col-md-4">{{__('label._note')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control _note" type="text"  name="_note" value="{{old('_note')}}" placeholder="{{__('label._note')}}" >
                         </div>
                      

                       
                        
                         
                        </div>
                        
                      </div>
                  <div class="col-12 mt-2 mb-4">
                <div class="row  justify-content-center">
                  
                  <div class="col-auto">
                    <button class="btn btn-primary px-5 px-sm-15" type="submit" >SAVE</button></div>
                </div>
              </div>

                    
                   
                </div>
              
              
              
            
            
          
        </form>
</div>
</div>
</div>
        @endsection

@section('script')
  <script>
    $(function () { $('.summernote').summernote(); })

    // $(document).on('change','.organization_id',function(){
    //   var organization_id = $(this).val();
    //   var url = $(this).attr('attr_url');
    //   var user_id =0;
    //   organizationWisechain(organization_id,url,user_id);


    // })
    // $(document).on('change','.asset_user_id',function(){
    //   var url = `{{url('basic/user_base_org_chain')}}`;
    //   var user_id =$(this).val();
    //   if(!user_id){return false;}
    //   user_base_org_chain(url,user_id);;

    // })


    // function user_base_org_chain(url,user_id){
    //   var request = $.ajax({
    //       url: url,
    //       method: "GET",
    //       data: {user_id },
    //       dataType: "html",
    //       async:false,
    //     });
         
    //     request.done(function( response ) {
    //       $( ".userWisechainBody" ).html( response );
    //     });
         
    //     request.fail(function( jqXHR, textStatus ) {
    //       alert( "Request failed: " + textStatus );
    //     });
    // }

    // function organizationWisechain(organization_id,url,user_id){
    //   var request = $.ajax({
    //       url: url,
    //       method: "GET",
    //       data: { organization_id,user_id },
    //       dataType: "html",
    //       async:false,
    //     });
         
    //     request.done(function( response ) {
    //       $( ".organizationWisechainBody" ).html( response );
    //     });
         
    //     request.fail(function( jqXHR, textStatus ) {
    //       alert( "Request failed: " + textStatus );
    //     });
    // }


  
  </script>
@endsection