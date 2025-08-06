

  <form  class="invoice_wise_collection_save" >
  
<div class="row">
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_collection_date" class="form-label _required">{{__('label._date')}}</label>
                    <input type="date" name="modal_collection_date" class="form-control modal_collection_date" id="modal_collection_date" value="{{date('Y-m-d')}}" >
                    <input type="hidden" name="modal_collec_url" class="form-control modal_collec_url" id="modal_collec_url" value="{{route('invoice_wise_collection_save')}}" >
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_id" class="form-label">ID</label>
                    <input type="text" name="modal_invoice_id" class="form-control modal_invoice_id" id="modal_invoice_id" value="{{$data->id}}" readonly>
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_order_number" class="form-label">{{__('label._order_number')}}</label>
                    <input type="text" name="modal_invoice_order_number" class="form-control modal_invoice_order_number" id="modal_invoice_order_number"  value="{{$data->_order_number ?? ''}}" readonly>
                    
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_date" class="form-label">Invoice {{__('label._date')}}</label>
                    <input type="date" name="modal_invoice_date" class="form-control modal_invoice_date" id="modal_invoice_date" value="{{$data->_date}}" readonly>
                </div>

                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_code" class="form-label">{{__('label._code')}}</label>
                    <input type="text" name="modal_invoice_code" class="form-control modal_invoice_code" id="modal_invoice_code" readonly value="{{$data->_ledger->_code ?? ''}}">
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_ledger_id" class="form-label">{{__('label._ledger_id')}}</label>
                    <input type="hidden" name="modal_invoice_ledger_id" class="form-control modal_invoice_ledger_id" id="modal_invoice_ledger_id" readonly value="{{$data->_ledger_id}}">

                    <input type="text" name="modal_invoice_ledger_name" class="form-control modal_invoice_ledger_name" id="modal_invoice_ledger_name" readonly value="{{$data->_ledger->_name ?? ''}}">
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_total" class="form-label">Sales Amount</label>
                    <input type="text" name="modal_invoice_total" class="form-control modal_invoice_total" id="modal_invoice_total" readonly value="{{$data->_total ?? 0}}">
                </div>
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_receive_amount" class="form-label">Pre. {{__('label._receive_amount')}}</label>
                    <input type="text" name="modal_invoice_receive_amount" class="form-control modal_invoice_receive_amount" id="modal_invoice_receive_amount" value="{{$data->_receive_amount ?? 0}}" readonly>
                </div>

                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_due_amount" class="form-label">Pre. {{__('label._due_amount')}}</label>
                    <input type="text" name="modal_invoice_due_amount" class="form-control modal_invoice_due_amount" id="modal_invoice_due_amount" readonly value="{{$data->_due_amount ?? 0}}">
                </div>
           

               
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_collection_code" class="form-label _required">{{__('label._collection_ledger_id')}}</label>
                   <select class="form-control modal_collection_ledger_id" name="modal_collection_ledger_id">
                    @forelse($collection_ledgers as $c_ledger)
                       <option value="{{$c_ledger->id}}">{{$c_ledger->_name ?? ''}}</option>
                    @empty
                    @endforelse
                   </select>
                </div>
                
                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_collection_amount" class="form-label _required">{{__('label._collection_amount')}}</label>
                    <input type="number" step="any" min="0" max="{{$data->_due_amount ?? 0}}" id="modal_collection_amount" name="modal_collection_amount" class="form-control modal_collection_amount modal_common_keyup" placeholder="{{__('label._collection_amount')}}" value="0">
                </div>

                <div class="col-md-6 col-sm-12 ">
                    <label for="modal_invoice_current_due_amount" class="form-label">Current {{__('label._due_amount')}}</label>
                    <input type="text" name="modal_invoice_current_due_amount" class="form-control modal_invoice_current_due_amount" id="modal_invoice_current_due_amount" readonly value="{{$data->_due_amount ?? 0}}">
                </div>

                <div class="col-md-4 col-sm-12 ">
                    <label for="modal_is_close" class="form-label _required">{{__('label._is_close')}}</label>
                    <select class="form-control modal_is_close" name="modal_is_close">
                      <option value="0">Open</option>
                      <option value="1">Close</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12 ">
                    <label for="modal_is_effect" class="form-label _required">{{__('label._is_effect')}}</label>
                     <select class="form-control modal_is_effect" name="modal_is_effect">
                                                  <option value="1">Yes</option>
                                                  <option value="0">No</option>
                                                </select>
                </div>
                @if(\Auth::user()->user_type=='admin')
                <div class="col-md-4 col-sm-12 ">
                    <label for="modal_is_confirm" class="form-label _required">{{__('label._is_confirm')}}</label>
                     <select class="form-control modal_is_confirm" name="modal_is_confirm">
                                                  <option value="0">No</option>
                                                  <option value="1">Yes</option>
                                                </select>
                </div>
                @endif
                <div class="col-md-12 col-sm-12 ">
                    <label for="modal_invoice_note" class="form-label"> {{__('label._note')}}</label>
                    <input type="text" name="modal_invoice_note" class="form-control modal_invoice_note" id="modal_invoice_note"  value="" placeholder="{{__('label._note')}}">
                </div>
                
              
           

            <div class="col-md-12 mt-4 mb-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="invoiceWiseCollectionButton" class="btn btn-primary invoiceWiseCollectionButton">$ Collection </button>
            </div>
</div>

</form>