
				<div class="box box-solid">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="">
								<label for="amount_1">Amount</label>
								<input type="text" class="form-control text-right payment" id="amount_1" name="amount[]" placeholder="" onkeyup="calculate_payments()"> <span id="amount_1_msg" style="display:none" class="text-danger"></span> </div>
						</div>
				<div class="col-md-6">
				<div class="">
				<label for="payment_type_1">Payment </label>
				@php
				$payment_accounts = \DB::select(" SELECT id,_name FROM account_ledgers WHERE _account_group_id IN($settings->_bank_group,$settings->_cash_group) order by id ASC ");
				@endphp
				<select class="form-control payment_group_change" id="payment_type_1" name="payment_type[]">
				@php
				$first_id = 0;
				@endphp
				@forelse($payment_accounts as $key=> $account)
				@php
				if($key ===0){
				$first_id = $account->id;
				}


				@endphp
				<option attr_value="{{$account->id}}" value="{{$account->id}}">{{$account->_name}}</option>
				@empty
				@endforelse

				<input type="hidden" class="payment_group" name="payment_group[]" id="payment_group_1" value="{{$first_id}}" /> 
				</select> <span id="payment_type_1_msg" style="display:none" class="text-danger"></span> </div>
				</div>
				<div class="clearfix"></div>
				</div>
				<div class="row">
				<div class="col-md-12">
				<div class="">
				<label for="payment_note_1">Payment Note</label>
				<textarea type="text" class="form-control" id="payment_note_1" name="payment_note[]" placeholder=""></textarea> <span id="payment_note_1_msg" style="display:none" class="text-danger"></span> </div>
				</div>
				<div class="clearfix"></div>
				</div>
				</div>
				</div>
				</div>
				<!-- col-md-12 -->
				</div>