<!-- Modal -->

@php

$users =\Auth::user();
$permited_branch = permited_branch(explode(',',$users->branch_ids));      
$store_houses = permited_stores(explode(',',$users->store_ids));
$permited_organizations = permited_organization(explode(',',$users->organization_ids));
$permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
@endphp 

<div class="modal fade" id="exampleModalLong_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create New Item (Inventory)</h5>
        <button type="button" class="close inventoryEntryModal" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body   item_entery_modal_form">
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal_close inventoryEntryModal" >Close</button>
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
        <button type="button" class="close ledgerEntryModal" >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body new_ledger_create_form">
        <form class="_ledger_modal_form">
        <div class="row">
                                  
                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Account Type: <span class="_required">*</span></strong>
                               <select type_base_group="{{url('type_base_group')}}" class="form-control _account_head_id " name="_account_head_id" required>
                                 
                                </select>
                            </div>
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                                  @php
                                  $account_groups = $account_groups ?? [];
                                  @endphp
                                <strong>Account Group:<span class="_required">*</span></strong>
                               <select class="form-control _account_groups " name="_account_group_id" required>
                                  <option value="">--Select Account Group--</option>
                                  @forelse($account_groups as $account_group )
                                  <option value="{{$account_group->id}}" f>{{ $account_group->id ?? '' }} - {{ $account_group->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                       


                            <div class="col-xs-12 col-sm-12 col-md-12 @if(sizeof($permited_organizations)==1) display_none @endif">
                             <div class="form-group ">
                                 <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
                                <select class="form-control _ledger_organization_id" name="organization_id" required >

                                   
                                   @forelse($permited_organizations as $val )
                                   <option value="{{$val->id}}">{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                   @empty
                                   @endforelse
                                 </select>
                             </div>
                            </div>
                            
                        <div class="col-xs-12 col-sm-12 col-md-12 @if(sizeof($permited_costcenters)==1) display_none @endif">
                         <div class="form-group ">
                             <label>Cost Center:<span class="_required">*</span></label>
                            <select class="form-control _ledger_cost_center_id" name="_cost_center_id" required >
                               
                               @forelse($permited_costcenters as $cost_center )
                               <option value="{{$cost_center->id}}" >{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                               @empty
                               @endforelse
                             </select>
                         </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group ">
                              @php
                                  $permited_branch = $permited_branch ?? [];
                                  @endphp
                                <strong>Branch:<span class="_required">*</span></strong>
                               <select class="form-control _ledger_branch_id" name="_ledger_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" >{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Ledger Name:<span class="_required">*</span></strong>
                                
                                <input type="text" name="_name" class="form-control _ledger_name" value="" placeholder="Ledger Name" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Address:</strong>
                                <input type="text" name="_address" class="form-control _ledger_address" value="" placeholder="Address" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Code:</strong>
                                <input type="text" name="_code" class="form-control _ledger_code" value="" placeholder="CODE Number">
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
                               <input type="text" name="_nid" class="form-control _ledger_nid" value="0" placeholder="NID Number">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Email:</strong>
                                <input type="email" name="_email" class="form-control _ledger_email" value="0" placeholder="Email" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Phone:</strong>
                                <input type="text" name="_phone" class="form-control _ledger_phone" value="0" placeholder="Phone" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Credit Limit:</strong>
                                <input type="number" step="any" name="_credit_limit" class="form-control _ledger_credit_limit" value="0" placeholder="Credit Limit" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Opening Dr Amount:</label>
                                <input id="opening_dr_amount" type="number" name="opening_dr_amount" class="form-control opening_dr_amount" placeholder="Dr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Opening Cr Amount:</label>
                                <input id="opening_cr_amount" type="number" name="opening_cr_amount" class="form-control opening_cr_amount" placeholder="Cr Amount" value="0" step="any" min="0">
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-6 display_none">
                            <div class="form-group">
                                <strong>Is User:</strong>
                                <select class="form-control _ledger_is_user" name="_is_user">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-group">
                                <strong>Sales Form:</strong>
                                <select class="form-control _ledger_is_sales_form" name="_is_sales_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-group">
                                <strong>Is Purchase Form:</strong>
                                <select class="form-control _ledger_is_purchase_form" name="_is_purchase_form">
                                  @foreach(yes_nos() as $key=>$s_val)
                                  <option value="{{$key}}">{{$s_val}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
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
        <button type="button" class="btn btn-secondary modal_close ledgerEntryModal" >Close</button>
        <button type="button" class="btn btn-primary save_ledger">Save </button>
      </div>
    </div>
  </div>
</div>

