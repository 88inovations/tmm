@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('style')

@endsection

@section('content')
 <style type="text/css">
    .form-control{
        width: 350px ;
    }
</style>
        <nav class="mb-2" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{url('assets-dashboard')}}">{{__('label.dashboard')}}</a></li>
            @can('asset_maintainces_list')
            <li class="breadcrumb-item"><a href="{{route('asset_maintainces.index')}}">{!! $page_name ?? '' !!}</a></li>
            @endcan
            <li class="breadcrumb-item active">{!! $new_page_name ?? '' !!}</li>
          </ol>
        </nav>
        @include('messages.message')
        <form class="mb-9" method="post" action="{{ route('asset_maintainces.store') }}" enctype='multipart/form-data'>
        @csrf
          <div class="row g-3 flex-between-end mb-5">
            <div class="col-auto">
              <h2 class="mb-2">{!! $page_name ?? '' !!}</h2>
            </div>

          </div>
          <div class="row g-5">
            <div class="col-12 col-xl-12">
              @php
$asset_maintainces_id = $data->id ?? '';


$organization_id = $data->organization_id ?? '';
$_branch_id = $data->_branch_id ?? '';
$_cost_center_id = $data->_cost_center_id ?? '';
$_budget_id = $data->_budget_id ?? '';

              @endphp
<div class="row g-0 border-top border-bottom border-300" style="padding:10px; ;">
    @if($asset_maintainces_id !='')
               
                             <label class="mt-2 text-right col-md-4">{{__('label.id')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="text"   name="asset_maintainces_id" class="form-control asset_maintainces_id" value="{{old('asset_maintainces_id',$data->id)}}" placeholder="{{__('label.id')}}" readonly>
                          </div>
                       
    @endif
               
                             <label class="mt-2 text-right col-md-4">{{__('label._date')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="date"   name="_date" class="form-control _date" value="{{old('_date',$data->_date ?? date('Y-m-d'))}}" placeholder="{{__('label._date')}}" >
                          </div>
                      
                      <label class="mb-1 text-1000 col-md-4 text-right mt-2">{{__('label._voucher_id')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="text"   name="_voucher_id" class="form-control _voucher_id" value="{{old('_voucher_id',$data->_voucher_id ?? '' )}}" placeholder="{{__('label._voucher_id')}}"  readonly>
                           </div>
                            <label class="mb-1 text-1000 col-md-4 text-right mt-2">{{__('label._voucher_number')}}</label>
                              <div class="col-md-6 mt-2">
                              <input type="text"   name="_voucher_code" class="form-control _voucher_number" value="{{old('_voucher_number',$data->_voucher_code ?? '' )}}" placeholder="{{__('label._voucher_number')}}"  readonly>
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


                         <label class="mb-1 text-1000 col-md-4 text-right mt-2 _required">{{__('label._expense_ledger_id')}}</label>


                           <div class="col-md-6">
                  
                            <input type="text" id="_search_expense_ledger_id" name="_search_expense_ledger_id" class="form-control _search_expense_ledger_id mt-2" value="{{_find_ledger($data->_expense_ledger_id ?? '' )}}" placeholder="{{__('label._expense_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="asset_dep_ledger_id" name="_expense_ledger_id" class="form-control asset_dep_ledger_id mt-2" value="{{old('_expense_ledger_id',$data->_expense_ledger_id ?? '')}}"  required>
                            <div class="_expense_ledger_search_box"> </div>
                    </div>
                     <label class="mb-1 text-1000 col-md-4 text-right mt-2 _required">{{__('label._payable_ledger_id')}}</label>

                    <div class="col-md-6">
                            <input type="text" id="_search_payable_ledger_id" name="_search_payable_ledger_id" class="form-control _search_payable_ledger_id mt-2" value="{{_find_ledger($data->_payable_ledger_id ?? '')}}" placeholder="{{__('label._payable_ledger_id')}}" required  attr_url="{{url('main-ledger-search')}}">

                            <input type="hidden" id="_payable_ledger_id" name="_payable_ledger_id" class="form-control _payable_ledger_id" value="{{$data->_payable_ledger_id ?? ''}}"  required>
                            <div class="payable_ledger_search_box"> </div>
                    </div>
                      
                       
                         
                        
                       
                        
                          
                             <label class="mt-2 text-right col-md-4">{{__('label.name')}}<span class="_required">*</span></label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="name" class="form-control asset_name_search" value="{!! old('name',$data->_asset_item->name ?? '') !!}" placeholder="{{__('label.name')}}" attr_url="{{route('asset_search')}}">
                               <input type="hidden" id="_asset_id" name="_asset_id" class="form-control _asset_id" value="{{old('_asset_id',$data->asset_id ?? '')}}"  required >
                            <div class="asset_name_box"> </div>

                          </div>
                       
                         
                             <label class="mt-2 text-right col-md-4">{{__('label.asset_tag')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_tag" class="form-control asset_tag" value="{{old('asset_tag',$data->_asset_item->asset_tag ?? '' )}}" placeholder="{{__('label.asset_tag')}}"  attr_url="{{route('asset_search')}}">
                                <div class="asset_name_box"> </div>
                              </div>
                      
                         
                             <label class="mt-2 text-right col-md-4">{{__('label.asset_code')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="asset_code" class="form-control asset_code" value="{{old('asset_code',$data->_asset_item->asset_code ?? '' )}}" placeholder="{{__('label.asset_code')}}" attr_url="{{route('asset_search')}}">
                               <div class="asset_name_box"> </div>
                          </div>
                       
                         
                             <label class="mt-2 text-right col-md-4">{{__('label.model_no')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="text" name="model_no" class="form-control model_no" value="{{old('model_no',$data->_asset_item->model_no 
                              ?? '' )}}" placeholder="{{__('label.model_no')}}" attr_url="{{route('asset_search')}}">
                              <div class="asset_name_box"> </div>
                          </div>
                       
                         
                        
                             <label class="mt-2 text-right col-md-4">{{__('label.cost')}}</label>
                             <div class="col-md-6 mt-2">
                              <input type="number" min="0" step="any"  name="cost" class="form-control cost" value="{{old('cost',$data->cost ?? 0)}}" placeholder="{{__('label.cost')}}" >
                          </div>
                      
                      
                             <label class="mt-2 text-right col-md-4">{{__('label.description')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control description" type="text"  name="description" value="{!! old('description',$data->description ?? '' ) !!}" placeholder="{{__('label.description')}}" >
                         </div>
                     
                      
                             <label class="mt-2 text-right col-md-4">{{__('label.technician_name')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control technician_name" type="text"  name="technician_name" value="{!! old('technician_name',$data->technician_name ?? '' ) !!}" placeholder="{{__('label.technician_name')}}" >
                         </div>
                        
                      
                             <label class="mt-2 text-right col-md-4">{{__('label._note')}}</label>
                             <div class="col-md-6 mt-2">
                             <input  class="form-control _note" type="text"  name="_note" value="{!! old('_note',$data->_note ?? '' ) !!}" placeholder="{{__('label._note')}}" >
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