 


 {!! Form::open(array('route' => 'customer_payment.store','method'=>'POST','class'=>'voucher-form')) !!}
                    <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-2">
                        <input type="hidden" name="_form_name" class="_form_name" value="receive_payments">
                        <input type="hidden" name="_form_type" class="_form_type" value="entry_form">
                        <input type="hidden" name="_master_id" class="form-control _master_id" value="{{ $data->id ?? '' }}" >
                        <input type="hidden" name="find_customer_due_history" class="form-control find_customer_due_history" value="{{ url('find_customer_due_history') }}" >
                            <div class="form-group">
                                <label>Date:</label>
                                      <input type="date" name="_date" class="_date form-control" value="{{date('Y-m-d')}}" />
                              </div>
                        </div>

                       <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Voucher Type: <span class="_required">*</span></label>
                               <select class="form-control _voucher_type" name="_voucher_type" required="true">
                                  <option value="">--Voucher Type--</option>
                                  @forelse($voucher_types as $voucher_type )
                                  <option value="{{$voucher_type->_code}}" @if(isset($request->_voucher_type)) @if($request->_voucher_type == $voucher_type->_code) selected @endif   @endif>
                                    {{ $voucher_type->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        
                        @include("backend.widgets.budget_select")


                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_sales_man">{{__('label._sales_man_id')}}:</label>
                              <select class="form-control _sales_man" name="_sales_man_id">
                                <option value="{{$sales_man->id ?? '' }}">{!! $sales_man->_code ?? '' !!} | {!! $sales_man->_name ?? '' !!}</option>
                              </select>
                             
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">Customer:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{$data->_name ?? '' }}" placeholder="Customer" readonly>

                            <input type="hidden" id="_main_ledger_id" name="_main_ledger_id" class="form-control _main_ledger_id" value="{{old('_main_ledger_id',$data->id ?? '' )}}" placeholder="Customer" required>
                            <div class="search_box_main_ledger"> </div>

                                
                            </div>
                        </div>  
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_code">{{__('label._code')}}:</label>
                              <input  readonly type="text" id="_code" name="_code" class="form-control _code" value="{{old('_code',$data->_code ?? '' )}}" placeholder="{{__('label._code')}}" >
                            </div>
                          </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_phone">Phone:</label>
                              <input type="text" id="_phone" name="_phone" class="form-control _phone" value="{{old('_phone',$data->_phone ?? '' )}}" placeholder="Phone" >
                                
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2 _required" for="_is_confirm">{{__('label._is_confirm')}}:</label>
                              <select class="form-control _is_confirm" name="_is_confirm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                              </select>
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_address">Address:</label>
                              <input type="text" id="_address" name="_address" class="form-control _address" value="{{old('_address',$data->_address ?? '' )}}" placeholder="Address" >
                                
                            </div>
                        </div>
                        
                         
                           
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_alious">{{__('label._alious')}}:</label>
                              <input  readonly type="text" id="_alious" name="_alious" class="form-control _alious" value="{{old('_alious',$data->_alious ?? '' )}}" placeholder="{{__('label._alious')}}" >
                            </div>
                          </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_credit_limit">{{__('label._credit_limit')}}:</label>
                                <input readonly  type="text" id="_credit_limit" name="_credit_limit" class="form-control _credit_limit" value="{{old('_credit_limit',$data->_credit_limit ?? 0)}}" placeholder="{{__('label._credit_limit')}}" >
                                  
                              </div>
                          </div>
                          
                          <div class="col-xs-12 col-sm-12 col-md-2 ">
                              <div class="form-group">
                                <label class="mr-2" for="_balance">{{__('label._balance')}}:</label>
                                <input readonly  type="text" id="_balance" name="_balance" class="form-control _balance" value="{{old('_balance',$data->_balance ?? 0)}}" placeholder="{{__('label._balance')}}" >
                                  
                              </div>
                          </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_ref">Reference:</label>
                              <input type="text" id="_transection_ref" name="_transection_ref" class="form-control _transection_ref" value="{{old('_transection_ref')}}" placeholder="Reference" >
                                
                            </div>
                        </div>



@if(sizeof($datas) > 0)
 <div class="col-md-12  ">
                             <div class="card">
                              
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>{{__('label.sl')}}</th>
                                            <th>{{__('label._date')}}</th>
                                            <th>Invoice Number</th>
                                            <th>Terms</th>
                                            <th>Ref</th>
                                            <th>Sales Amount</th>
                                            <th>Pre.{{__('label._receive_amount')}}</th>
                                            <th>Pre.{{__('label._due_amount')}}</th>
                                            <th>{{__('label._collection_ledger')}}</th>
                                            <th>{{__('label.collect_amount')}}</th>
                                            <th>{{__('label.current_due')}}</th>
                                            <th>{{__('label._is_close')}}</th>
                                            <th>{{__('label.effect')}}</th>
                                          </thead>
                                          <tbody>
@php
$_grand_total   = 0;
$_grand_receive_amount   = 0;
$_grand_due_amount   = 0;
$_grand_collection_amount   = 0;
$_grand_due_balance   = 0;
@endphp
@forelse($datas as $key=>$val)



@php
$_grand_total            +=$val->_total ??  0;
$_grand_receive_amount   +=$val->_receive_amount ?? 0;
$_grand_due_amount       +=$val->_due_amount ?? 0;
$_grand_collection_amount +=$val->_collection_amount ?? 0;
$_grand_due_balance       += $val->_due_amount ?? 0;
@endphp

                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-sm  btn-danger due_invoice_row" onclick="return confirm('Are you sure!')"><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>{!! ($key+1) !!}</td>
                                              <td style="white-space: nowrap;"> {!! _view_date_formate($val->_date ?? '') !!}
                                                <input type="hidden" name="sales_id[]" value="{{$val->id ?? 0 }}">
                                                <input type="hidden" name="_order_number[]" value="{{$val->_order_number ?? ''}}">
                                              </td>
                                              <td style="white-space: nowrap;"> {!! $val->_order_number ?? '' !!}</td>
                                              <td style="white-space: nowrap;">  {{ _id_to_name($val->_payment_terms,'_name','transection_terms') }}</td>
                                              <td style="white-space: nowrap;"> {!! $val->_referance ?? '' !!}</td>
                                               <td>
                                                <input type="number" min="0" step="any" name="_total[]" class="form-control  _total" placeholder="{{__('label._total')}}" value="{{old('_total',$val->_total ?? 0)}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_receive_amount[]" class="form-control  _receive_amount" placeholder="{{__('label._receive_amount')}}" value="{{old('_receive_amount',$val->_receive_amount ?? 0)}}" readonly>
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_amount[]" class="form-control  _due_amount" placeholder="{{__('label._due_amount')}}" value="{{old('_due_amount',$val->_due_amount ?? 0)}}" readonly>
                                              </td>
                                               <td> 
                                                    <select class="form-control _collection_ledger_id" name="_collection_ledger_id[]" >
                                                    @forelse($collection_ledgers as $c_ledger)
                                                     <option value="{{$c_ledger->id ?? 0}}">{{$c_ledger->_code ?? ''}}-{{$c_ledger->_name ?? 0}}</option>
                                                     @empty
                                                     @endforelse
                                                    </select>
                                               </td>
                                               <td>
                                                <input type="number"  type="number" min="0" max="{{$val->_due_amount ?? 0}}" step="any" name="_collection_amount[]" class="form-control  _collection_amount" placeholder="{{__('label._collection_amount')}}" value="{{old('_collection_amount',$val->_collection_amount ?? 0)}}" >
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_due_balance[]" class="form-control  _due_balance" placeholder="{{__('label._due_balance')}}" value="{{old('_due_balance',$val->_due_amount ?? 0)}}" readonly>
                                              </td>
                                             
                                             
                                              <td>
                                                <select class="form-control _is_close" name="_is_close[]">
                                                  <option value="0">Open</option>
                                                  <option value="1">Close</option>
                                                </select>
                                               </td>
                                               <td>
                                                <select class="form-control _is_effect" name="_is_effect[]">
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                                </select>
                                               </td>
                                            </tr>
                                @empty

                                @endforelse
                                          </tbody>
                                          <tfoot>
                                          <tr class="_voucher_row">
                                              <td colspan="6">Grand Total</td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_total" class="form-control  _grand_total" placeholder="Total" value="{{$_grand_total}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_receive_amount" class="form-control  _grand_receive_amount" placeholder="Receive Amount" value="{{$_grand_receive_amount}}" readonly="">
                                              </td>
                                               
                                             
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_amount" class="form-control  _grand_due_amount" placeholder="Due Amount" value="{{$_grand_due_amount}}" readonly="">
                                              </td>
                                               <td> 
                                                   </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_collection_amount" class="form-control  _grand_collection_amount" placeholder="Collection Amount" value="{{$_grand_collection_amount}}" readonly>
                                              </td>
                                               <td>
                                                <input type="number"  type="number" min="0" step="any" name="_grand_due_balance" class="form-control  _grand_due_balance" placeholder="label._due_balance" value="{{$_grand_due_balance}}" readonly="">
                                              </td>
                                             
                                             
                                              <td> </td>
                                               <td></td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                               
                            </div>
                          </div>
                        </div>
        @else
        <div style="width: 100%;">
            <h4 style="text-align:center;color: red;">No Data Found</h4>
        </div>
        @endif


         <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                            <div class="form-group">
                               
                                
                                <div class="row">
                                  <div class="col-md-1">
                                     <label class="mr-2" for="_note">Note:<span class="_required">*</span></label>
                                  </div>
                                  <div class="col-md-11">
                                   
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">
                                       <input type="hidden" class="number_of_row" name="number_of_row" value="1">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                                  </div>
                                </div>
                               
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    </div>
                    {!! Form::close() !!}


                    <script type="text/javascript">

 


$(document).on('keyup','._collection_amount',function(){

 

  var line_this = $(this);
  var _total = parseFloat(line_this.closest('tr').find('._total').val());
  if(isNaN(_total)){_total=0}
  var _due_amount = parseFloat(line_this.closest('tr').find('._due_amount').val());
  if(isNaN(_due_amount)){_due_amount=0}
  var _receive_amount = parseFloat(line_this.closest('tr').find('._receive_amount').val());
  if(isNaN(_receive_amount)){_receive_amount=0}

  var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}

  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);

if(_due_balance < 0 ){
  _due_balance = 0;
  line_this.closest('tr').find('._collection_amount').val(_due_amount);
   var _collection_amount = parseFloat(line_this.closest('tr').find('._collection_amount').val());
  if(isNaN(_collection_amount)){_collection_amount=0}
  var _due_balance = parseFloat(parseFloat(_due_amount)-parseFloat(_collection_amount)).toFixed(2);

}
line_this.closest('tr').find('._due_balance').val(_due_balance);


  // Check if the _is_close value is already the same to prevent triggering the change event again
    var $isCloseField = line_this.closest('tr').find('._is_close');
    var currentCloseValue = $isCloseField.val();
    
    if (_due_balance == 0) {
        // Set value to 1 only if it's not already 1
        if (currentCloseValue != 1) {
            $isCloseField.val(1).change();
        }
    } else {
        // Set value to 0 only if it's not already 0
        if (currentCloseValue != 0) {
            $isCloseField.val(0).change();
        }
    }
payment_total_calculatins();



})


$(document).on('change','._is_close',function(){
  var _is_close  = $(this).closest('tr').find('._is_close').val();
  var _due_balance  = $(this).closest('tr').find('._due_balance').val();
   if(isNaN(_due_balance)){_due_balance=0}
  if(_due_balance !=0){
   // alert('Due Amount Must be Zero to Close this Invoice');
    $(this).closest('tr').find('._is_close').val(0).change();
  }


});

function payment_total_calculatins(){
  var _grand_total          = 0;
  var _grand_receive_amount = 0;
  var _grand_due_amount       = 0;
  var _grand_collection_amount = 0;
  var _grand_due_balance = 0;
 $(document).find('._total').each(function(index){
     var _total =parseFloat($(this).val());
     if(isNaN(_total)){_total=0}
      _grand_total +=_total;



  var line_total             = parseFloat($(document).find("._total").eq(index).val());
  if(isNaN(line_total)){line_total=0}
  var line_receive_amount    = parseFloat($(document).find("._receive_amount").eq(index).val());
  if(isNaN(line_receive_amount)){line_receive_amount=0}
  var line_due_amount        = parseFloat($(document).find("._due_amount").eq(index).val());
  if(isNaN(line_due_amount)){line_due_amount=0}
  var line_collection_amount = parseFloat($(document).find("._collection_amount").eq(index).val());
  if(isNaN(line_collection_amount)){line_collection_amount=0}
  var _due_balance  = parseFloat(parseFloat(line_due_amount)-parseFloat(line_collection_amount)).toFixed(2);
  $(document).find("._due_balance").eq(index).val(_due_balance);




 })
 $(document).find('._receive_amount').each(function(){
     var _receive_amount =parseFloat($(this).val());
     if(isNaN(_receive_amount)){_receive_amount=0}
      _grand_receive_amount +=_receive_amount;
 })
 $(document).find('._due_amount').each(function(){
     var _due_amount =parseFloat($(this).val());
     if(isNaN(_due_amount)){_due_amount=0}
      _grand_due_amount +=_due_amount;
 })

 $(document).find('._collection_amount').each(function(){
     var _collection_amount =parseFloat($(this).val());
     if(isNaN(_collection_amount)){_collection_amount=0}
      _grand_collection_amount +=_collection_amount;
 })

 $(document).find('._due_balance').each(function(){
     var _due_balance =parseFloat($(this).val());
     if(isNaN(_due_balance)){_due_balance=0}
      _grand_due_balance +=_due_balance;
 })

 $(document).find("._grand_total").val(_grand_total);
 $(document).find("._grand_receive_amount").val(_grand_receive_amount);
 $(document).find("._grand_collection_amount").val(_grand_collection_amount);
 $(document).find("._grand_due_amount").val(_grand_due_amount);
 $(document).find("._grand_due_balance").val(_grand_due_balance);



}
 

 $(document).on('click',".due_invoice_row",function(){
      var line_this = $(this);
      line_this.closest('tr').remove();
      payment_total_calculatins();
 })




</script>