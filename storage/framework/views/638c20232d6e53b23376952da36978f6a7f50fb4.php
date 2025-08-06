<?php if($settings->_sms_service ==1): ?>

<tr style="border:0px;">
	<td colspan="2" style="border:0px;">
		<table style="width: 100%;">
			<tr>
				<td style="border:0px;width:20%;"><label for="_send_sms">SMS Send </label></td>
				  <td style="border:0px;">
				    <select class="form-control" name="_send_sms" style="width:200px;">
				        <option value="no">No</option>
				        <option value="yes">Yes</option>
				      </select>
				  </td>
				  		<!-- <td style="border:0px;"><label for="_send_sms">Email Send </label></td>
					  <td style="border:0px;">
					    <select class="form-control" name="_send_email" style="width:150px;">
					        <option value="no">No</option>
					        <option value="yes">Yes</option>
					      </select>
					  </td> -->
				</tr>
		</table>
	</td> 
</tr>
<?php endif; ?>

<?php if($settings->_auto_lock ==1): ?>

<tr style="border:0px;">
	<td colspan="2" style="border:0px;">
		<table style="width: 100%;">
			<tr>
				<td style="border:0px;width:20%;"><label for="_lock">Auto Lock </label></td>
				  <td style="border:0px;">
				    <select class="form-control" name="_lock" style="width:200px;">
				        <option value="1">After Save Auto Lock</option>
				      </select>
				  </td>
				  		
				</tr>
		</table>
	</td> 
</tr>
<?php endif; ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/message/send_sms.blade.php ENDPATH**/ ?>