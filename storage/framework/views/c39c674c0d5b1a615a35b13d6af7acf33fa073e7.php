

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('daily_dashboard')): ?>

 <?php 
$_to_day = change_date_format(date('Y-m-d'));
$auth_user   = \Auth::user();
$_ac_type    = $auth_user->_ac_type ?? 0; // 1 = Sales Officer
$user_type   = $auth_user->user_type ?? '';
$_sales_man_id   = $auth_user->ref_id ?? 0;
 ?>

<style type="text/css">
	.card {
	    box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2) !important;
	    margin-bottom: 1rem !important;

	}
	.text_blue{
		color: blue;
		font-weight: 900;
	}
	.card-header{
		padding: 2px !important;
	}
	.card-footer{
		padding: 2px !important;
	}
</style>
 <div class="row" style="
    padding-top: 10px;">
<?php


?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_sales_order')): ?>
<?php 


	$order_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM sales_orders AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$order_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$order_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$sales_orders = \DB::select($order_query);







 ?>

		
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center ">
			    	<div class="card-header "><h6>Sales Order</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales_orders[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center ">
			    	<div class="card-header"><h6>Sales Order ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales_orders[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>

<?php endif; ?>




<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_sales')): ?>
<?php 



	$sales_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM sales AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$sales_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$sales_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$sales = \DB::select($sales_query);


 ?>

		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Sales Invoice</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Sales Invoice ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>


<?php endif; ?>


<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_sales_return')): ?>
<?php 

	$sales_return_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM sales_returns AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$sales_return_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$sales_return_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$sales_returns = \DB::select($sales_return_query);



 ?>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Sales Return</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales_returns[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Sales Return ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($sales_returns[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_purchase_order')): ?>
		
<?php 


$purchase_orders_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM purchase_orders AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$purchase_orders_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$purchase_orders_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$purchase_orders = \DB::select($purchase_orders_query);


 ?>

		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase Order</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchase_orders[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase Order ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchase_orders[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>

<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_purchase')): ?>

<?php 

$purchases_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM purchases AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$purchases_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$purchases_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$purchases = \DB::select($purchases_query);


 ?>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchases[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchases[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>

<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_purchase_return')): ?>
<?php 


$purchase_returns_query = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._total) AS _total_amount 
			FROM purchase_returns AS t1 WHERE t1._status=1 ";
			if($user_type !='admin' && $_ac_type ==1){
					$purchase_returns_query .=	" AND t1._sales_man_id=$_sales_man_id ";
			}
	$purchase_returns_query .="	AND t1._date BETWEEN '".$_to_day."' AND '".$_to_day."' ";
	$purchase_returns = \DB::select($purchase_returns_query);



 ?>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase Return</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchase_returns[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Purchase Return ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($purchase_returns[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
<?php endif; ?>



<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_collection')): ?>
<?php

$_bank_group = $settings->_bank_group ?? '';
$_cash_group = $settings->_cash_group ?? '';
$_bank_group_array = explode(',',$_bank_group);
$_cash_group_array = explode(',',$_cash_group);

$bank_and_cash_group = array_merge($_bank_group_array,$_cash_group_array);

$find_bank_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$_bank_group_array)->select('id','_name')->get();
$find_cash_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$_cash_group_array)->select('id','_name')->get();

$cash_and_bank_ledger_ids = [];
foreach($find_bank_ledgers as $bank_ledger){
	$cash_and_bank_ledger_ids[]=$bank_ledger->id ?? 0;
}
foreach($find_cash_ledgers as $cash_ledger){
	$cash_and_bank_ledger_ids[]=$cash_ledger->id ?? 0;
}

//dump($_cash_group);

if(sizeof($cash_and_bank_ledger_ids) > 0){
	$cash_and_bank_ledger_ids_string = implode(',', $cash_and_bank_ledger_ids);

$query_string = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._dr_amount) AS _total_amount FROM `accounts` AS t1  
WHERE t1._status=1 ";

if($user_type !='admin' && $_ac_type ==1){
		$query_string .=	" AND t1._sales_man_id=$_sales_man_id ";
}

$query_string .= " AND t1._account_ledger IN(".$cash_and_bank_ledger_ids_string.")
AND t1._dr_amount > 0 AND  t1._date BETWEEN '".$_to_day."' AND '".$_to_day."'  ";
//dump($query_string);
$collections = \DB::select($query_string);
}else{
	$collections = [];
}





//dump($collections);

 ?>

		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Collection</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($collections[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Collection ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($collections[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>

<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_payment')): ?>


<?php

$_bank_group = $settings->_bank_group ?? '';
$_cash_group = $settings->_cash_group ?? '';
$_bank_group_array = explode(',',$_bank_group);
$_cash_group_array = explode(',',$_cash_group);

$bank_and_cash_group = array_merge($_bank_group_array,$_cash_group_array);

$find_bank_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$_bank_group_array)->select('id','_name')->get();
$find_cash_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$_cash_group_array)->select('id','_name')->get();

$cash_and_bank_ledger_ids = [];
foreach($find_bank_ledgers as $bank_ledger){
	$cash_and_bank_ledger_ids[]=$bank_ledger->id ?? 0;
}
foreach($find_cash_ledgers as $cash_ledger){
	$cash_and_bank_ledger_ids[]=$cash_ledger->id ?? 0;
}

//dump($_cash_group);

if(sizeof($cash_and_bank_ledger_ids) > 0){
	$cash_and_bank_ledger_ids_string = implode(',', $cash_and_bank_ledger_ids);
		$payment_query_string = " SELECT COUNT(t1.id) AS number_of_rows,  SUM(t1._cr_amount) AS _total_amount FROM `accounts` AS t1  
		WHERE t1._status=1 ";

		if($user_type !='admin' && $_ac_type ==1){
				$payment_query_string .=	" AND t1._sales_man_id=$_sales_man_id ";
		}

		$payment_query_string .= " AND t1._account_ledger IN(".$cash_and_bank_ledger_ids_string.")
		AND t1._cr_amount > 0 AND  t1._date BETWEEN '".$_to_day."' AND '".$_to_day."'  ";
		//dump($payment_query_string);
		$payments = \DB::select($payment_query_string);
}else{
	$payments = [];
}




//dump($collections);

 ?>


		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Payment</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($payments[0]->number_of_rows ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
		<div class="col-md-2 col-sm-6 col-6">
			<div class="card text-center">
			    	<div class="card-header"><h6>Payment ৳</h6></div>
			    	<div class="card-footer text_blue text-bold">
			    		<h3><?php echo e(_report_amount($payments[0]->_total_amount ?? 0)); ?></h3>
			    	</div>
			  </div>
		</div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('outstanding_detail_report')): ?>
		<div class="col-md-2">
			<div class="card text-center">
			    	
			    	<div class="card-footer text_blue text-bold">
			    		<a target="__blank" class="btn btn-sm btn-info" href="<?php echo e(url('outstanding_detail_report')); ?>"><?php echo e(__('label.outstanding_detail_report')); ?></a>
			    	</div>
			  </div>
		</div>
		<?php endif; ?>
   </div>

    <div class="row" style="
    padding-top: 10px;">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_cash_possition')): ?>
    	<?php if($_cash_group !=''): ?>
		<?php

		$cash_possition_query = " SELECT t1._account_ledger,t2._name,t2._code,  SUM(t1._dr_amount-t1._cr_amount) AS _total_amount 
FROM `accounts` AS t1  
INNER JOIN account_ledgers AS t2 ON t1._account_ledger=t2.id
WHERE t1._status=1 AND t2._account_group_id IN(".$_cash_group.")
GROUP BY t1._account_ledger 
ORDER BY t2._name ASC  ";
//dump($cash_possition_query);
$cash_possitions = \DB::select($cash_possition_query);


		 ?>
		
		<div class="col-md-6">
			<div class="card text-left">
			    	<div class="card-header text-center"><h6>Cash Possition ৳</h6></div>
			    	<div class="card-footer  text-bold">
			    		<table class="table table-striped">
			    			<?php if(sizeof($cash_possitions) > 0): ?>
							<?php
							$cash_total =0;
							?>
			    				<?php $__empty_1 = true; $__currentLoopData = $cash_possitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cash_possitions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<?php
								$cash_total +=$cash_possitions->_total_amount ?? 0;
								?>
			    				<tr>
			    					<td><?php echo $cash_possitions->_name ?? ''; ?></td>
			    					<td class="text-right"><?php echo _show_amount_dr_cr(_report_amount($cash_possitions->_total_amount ?? 0)); ?></td>
			    				</tr>
			    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			    				<?php endif; ?>

			    			<tr>
			    				<th class="text_blue">Grand Total</th>
			    				<th class="text_blue text-right"><?php echo _show_amount_dr_cr(_report_amount($cash_total ?? 0)); ?></th>
			    			</tr>

			    			<?php endif; ?>

			    		</table>
			    	</div>
			  </div>
		</div>
		<?php endif; ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard_bank_possition')): ?>
    	<?php if($_bank_group !=''): ?>
		<?php

		$cash_possition_query = " SELECT t1._account_ledger,t2._name,t2._code,  SUM(t1._dr_amount-t1._cr_amount) AS _total_amount 
FROM `accounts` AS t1  
INNER JOIN account_ledgers AS t2 ON t1._account_ledger=t2.id
WHERE t1._status=1 AND t2._account_group_id IN(".$_bank_group.")
GROUP BY t1._account_ledger 
ORDER BY t2._name ASC  ";
//dump($cash_possition_query);
$cash_possitions = \DB::select($cash_possition_query);


		 ?>
		
		<div class="col-md-6">
			<div class="card text-left">
			    	<div class="card-header text-center"><h6>Bank Possition ৳</h6></div>
			    	<div class="card-footer  text-bold">
			    		<table class="table table-striped">
			    			<?php if(sizeof($cash_possitions) > 0): ?>
							<?php
							$cash_total =0;
							?>
			    				<?php $__empty_1 = true; $__currentLoopData = $cash_possitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cash_possitions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<?php
								$cash_total +=$cash_possitions->_total_amount ?? 0;
								?>
			    				<tr>
			    					<td><?php echo $cash_possitions->_name ?? ''; ?></td>
			    					<td class="text-right"><?php echo _show_amount_dr_cr(_report_amount($cash_possitions->_total_amount ?? 0)); ?></td>
			    				</tr>
			    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
			    				<?php endif; ?>

			    			<tr>
			    				<th class="text_blue">Grand Total</th>
			    				<th class="text_blue text-right"><?php echo _show_amount_dr_cr(_report_amount($cash_total ?? 0)); ?></th>
			    			</tr>

			    			<?php endif; ?>

			    		</table>
			    	</div>
			  </div>
		</div>
		<?php endif; ?>

		<?php endif; ?>
	
   </div>

   <?php endif; ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/dashboard/daily_dashboard.blade.php ENDPATH**/ ?>