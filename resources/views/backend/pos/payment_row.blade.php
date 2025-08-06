<?php
$id = $row_count;
$id = ($id+1)
?>
<div class="col-md-12 payments_div payments_div_<?php echo $id; ?>">
          <div class="box box-solid bg-gray">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm btn-danger" onclick="remove_row(<?php echo $id; ?>)">X</button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
         
                <div class="col-md-6">
                  <div class="">
                  <label for="amount_<?php echo $id; ?>">Amount</label>
                    <input type="text" class="form-control text-right paid_amt only_currency" id="amount_<?php echo $id; ?>" name="amount[]" placeholder="" onkeyup="calculate_payments()" >
                      <span id="amount_<?php echo $id; ?>_msg" style="display:none" class="text-danger"></span>
                </div>
               </div>
                <div class="col-md-6">
                  <div class="payment_section">
                    <label for="payment_type_<?php echo $id; ?>">Payment (Bank)</label>
                    <select class="form-control payment_group_change" id='payment_type_<?php echo $id; ?>' name="payment_type[]" >
                      		@forelse($payment_accounts as $key=>$account )
									  <option attr_value="<?php echo  $account->id; ?>"    value="<?php echo  $account->id; ?>"><?php echo  $account->_name; ?></option>
                    @empty
                    @endforelse

								                   
					  </select>
					  <input type="hidden" class="payment_group" name="payment_group[]" id="payment_group_<?php echo $id; ?>" value="30" />
                    <span id="payment_type_<?php echo $id; ?>_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
            <div class="clearfix"></div>
        </div>  
        <div class="row">
               <div class="col-md-12">
                  <div class="">
                    <label for="payment_note_<?php echo $id; ?>">Payment Note</label>
                    <textarea type="text" class="form-control" id="payment_note_<?php echo $id; ?>" name="payment_note[]" placeholder="" ></textarea>
                    <span id="payment_note_<?php echo $id; ?>_msg" style="display:none" class="text-danger"></span>
                  </div>
               </div>
                
            <div class="clearfix"></div>
        </div>   
        </div>
        </div>
      </div><!-- col-md-12 -->
<script>
	$(document).find(".payment_group_change").on('change',function(){
	var group_name =$('option:selected', this).attr('attr_value');
	$(this).parent().find('.payment_group').val(group_name);
	console.log(group_name)
})
</script>