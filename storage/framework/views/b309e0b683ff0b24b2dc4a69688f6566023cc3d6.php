<!DOCTYPE html>

<html  lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta Tags -->
  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="<?php echo e($settings->name ?? ''); ?>">
  <!-- Site Title -->
  <title>Sales Invoice</title>
  <link rel="stylesheet" href="<?php echo e(asset('backend/invoices/style.css?v=1.4')); ?>">
  <style>
      .tm_mb2{
          font-size:20px !important;
      }
      .tm_primary_color{
          font-size:20px;
          font-weight:bold;
      }
  </style>
</head>

<body cz-shortcut-listen="true">
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style1" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_head tm_align_center tm_mb20">
            <div class="tm_invoice_left">
              <div class="tm_logo">
                <img src="<?php echo e(asset($settings->logo ?? '')); ?>" alt="Logo" style="width:250px;height:auto;">
              </div>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <div class="tm_primary_color tm_f50 tm_text_uppercase">Invoice</div>
            </div>
          </div>
          <div class="tm_invoice_info tm_mb20">
            <div class="tm_invoice_seperator "><?php echo e(invoice_barcode($data->_order_number ?? '')); ?></div>
            <div class="tm_invoice_info_list">
              <p class="tm_invoice_number tm_m0">Invoice No: <b class="tm_primary_color"><?php echo $data->_order_number ?? ''; ?></b></p>
              <p class="tm_invoice_date tm_m0">Date: <b class="tm_primary_color"><?php echo _view_date_formate($data->_date ?? ''); ?></b></p>
            </div>
          </div>
          <div class="tm_invoice_head tm_mb10">
            <div class="tm_invoice_left">
              <p class="tm_mb2"><b class="tm_primary_color"> <?php echo e($settings->name ?? ''); ?></b></p>
              <p style="font-size:12px;">
                
                <?php echo e($settings->_address ?? ''); ?> <br><?php echo e($settings->_phone ?? ''); ?> <br>
                <?php echo e($settings->_email ?? ''); ?>

              </p>
            </div>
            <div class="tm_invoice_right tm_text_right">
              <p class="tm_mb2"><b class="tm_primary_color"></b></p>
              <p >
                  <?php
                  $_alious  = $data->_ledger->_alious ?? '' ;
                  ?>
                  <b>
                      <span class="tm_mb2">
                <?php if($form_settings->_defaut_customer ==$data->_ledger_id): ?>
                  Customer :    <?php echo e($data->_referance ?? $data->_ledger->_name); ?>

                  <?php else: ?>
                   Customer : <?php echo e($data->_ledger->_name ?? ''); ?>

                  <?php endif; ?>
                  </span> <br>
                  <?php if($_alious !=''): ?>
                Proprietor:<?php echo e($data->_ledger->_alious ?? ''); ?><br>
                <?php endif; ?>
                </b>
                Address: <?php echo e($data->_address ?? ''); ?><br>
                Phone: <?php echo e($data->_phone ?? ''); ?> <br>
                Email: <?php echo e($data->_email ?? ''); ?>

              </p>
            </div>
          </div>
          <div class="tm_table tm_style1 tm_mb30">
            <div class="tm_round_border">
              <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">SL</th>
                      <th class="tm_width_6 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Description</th>
                      <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Qty</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg" style="border:1px solid silver;">Price</th>
                      <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right" style="border:1px solid silver;">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(sizeof($_master_detail_reassign) > 0): ?>
         <?php
                                    $_value_total = 0;
                                    $_vat_total = 0;
                                    $_qty_total = 0;
                                    $_total_discount_amount = 0;
                                    $id=1;
                                  ?>
                                  <?php $__empty_1 = true; $__currentLoopData = $_master_detail_reassign; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_key=>$_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <?php if(sizeof($_item) > 0): ?>
                      <td><?php echo e(($id)); ?>.</td>
                      <td class="tm_width_3" style="border:1px solid silver;">
                        <?php $__empty_2 = true; $__currentLoopData = $_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_in_item_key=>$in_itemVal_multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <?php
                                      $_value_total +=$in_itemVal_multi->_value ?? 0;
                                      $_vat_total += $in_itemVal_multi->_vat_amount ?? 0;
                                      $_qty_total += $in_itemVal_multi->_qty ?? 0;
                                      $_total_discount_amount += $in_itemVal_multi->_discount_amount ?? 0;
                                     ?>
                                     <?php if($_in_item_key==0): ?>
                                            <?php echo $in_itemVal_multi->_items->_name ?? ''; ?> 
                                    <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <?php endif; ?> 
                      </td>

                      <td class="tm_width_4" style="border:1px solid silver;">
                         <?php
                           $row_qty =0;
                          ?>
                          <?php $__empty_2 = true; $__currentLoopData = $_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_in_item_key=>$in_itemVal_multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php
                                 $row_qty +=($in_itemVal_multi->_qty ?? 0);
                             ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                          <?php endif; ?>

                                   <?php echo _report_amount($row_qty ?? 0); ?>

                                   
                                   <?php $__empty_2 = true; $__currentLoopData = $_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_in_item_key=>$in_itemVal_multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                              <?php if($_in_item_key==0): ?>
                                  <?php echo _find_unit($in_itemVal_multi->_transection_unit ?? ''); ?>

                              <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                              <?php endif; ?>
                      </td>
                      <td class="tm_width_2" style="border:1px solid silver;">
                         <?php $__empty_2 = true; $__currentLoopData = $_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_in_item_key=>$in_itemVal_multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                              <?php if($_in_item_key==0): ?>
                                 <?php echo _report_amount($in_itemVal_multi->_sales_rate ?? 0); ?>

                              <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                              <?php endif; ?>
                      </td>
                      <td class="tm_width_1" style="border:1px solid silver;">
                        <?php
                           $row__value =0;
                          ?>
                          <?php $__empty_2 = true; $__currentLoopData = $_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $_in_item_key=>$in_itemVal_multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php
                                 $row__value +=($in_itemVal_multi->_value ?? 0);
                             ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                          <?php endif; ?>



                                              <?php echo _report_amount($row__value ?? 0); ?>

                      </td>
                       <?php endif; ?>
                    </tr>
                    <?php
                                  $id++;
                                  ?>


                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                  <?php endif; ?>
                    
                    <?php endif; ?>
                    <tr>
                              <td colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em; border:1px solid silver;vertical-align:top;text-align: right;"><b>Total</b></td>
                              <td style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;"> <b><?php echo e(_report_amount($_qty_total ?? 0)); ?></b> </td>
                              <td style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;"></td>
                              
                              <td style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><b> <?php echo e(_report_amount($_value_total ?? 0)); ?></b>
                              </td>
                            </tr>
                            <tr>
                             
                                      <th colspan="3" style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Sub Total</b></th>
                                      <th colspan="2" style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount($data->_sub_total ?? 0); ?></th>
                                    </tr>
                                   <?php if($data->_total_discount > 0): ?>
                                    <tr>
                                      <th colspan="3" style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Discount[-]</b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount($data->_total_discount ?? 0); ?></th>
                                    </tr>
                                   <?php endif; ?>

                                    <?php if($form_settings->_show_vat==1 && $data->_total_vat > 0): ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>VAT[+]</b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount($data->_total_vat ?? 0); ?></th>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Net Total</b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount($data->_total ?? 0); ?></th>
                                    </tr>
                                    <?php
                                    $accounts = $data->s_account ?? [];
                                    $_due_amount =$data->_total ?? 0;
                                    ?>
                                    <?php if(sizeof($accounts) > 0): ?>
                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($ac_val->_ledger->id !=$data->_ledger_id): ?>
                                     <?php if($ac_val->_cr_amount > 0): ?>
                                     <?php
                                      $_due_amount +=$ac_val->_cr_amount ?? 0;
                                     ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b> <?php echo $ac_val->_ledger->_name ?? ''; ?>[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;"><?php echo _report_amount( $ac_val->_cr_amount ?? 0 ); ?></th>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($ac_val->_dr_amount > 0): ?>
                                     <?php
                                      $_due_amount -=$ac_val->_dr_amount ?? 0;
                                     ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b> <?php echo $ac_val->_ledger->_name ?? ''; ?>[+]
                                        </b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount( $ac_val->_dr_amount ?? 0 ); ?></th>
                                    </tr>
                                    <?php endif; ?>

                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Invoice Due </b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _report_amount( $_due_amount); ?></th>
                                    </tr>

                                    <?php endif; ?>
                                  
                            </tr>
                              <?php if($form_settings->_show_p_balance==1): ?>
                              <?php
                              $_p_balance = $data->_p_balance ?? 0;
                              $_l_balance = $data->_l_balance ?? 0;
                              ?>
                              <?php if($_p_balance !=0): ?>
                              <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Previous Balance </b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _show_amount_dr_cr(_report_amount($data->_p_balance ?? 0)); ?></th>
                                    </tr>
                                    
                              <?php endif; ?>
                              <?php if($_l_balance !=0): ?>
                                    <tr>
                                      <th  colspan="3"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align: right;" ><b>Current Balance </b></th>
                                      <th  colspan="2"  style="font-size: 1em;color: #000;line-height: 1.2em;border:1px solid silver;vertical-align:top;text-align:right;"><?php echo _show_amount_dr_cr(_report_amount($data->_l_balance ?? 0)); ?></th>
                                    </tr>
                            <?php endif; ?>
                            <?php endif; ?>
                            <tr>
                                  <td  colspan="5"  style="font-size: 1em;"><p class="lead"> In Words:  <?php echo e(nv_number_to_text($data->_total ?? 0)); ?> </p></td>
                                </tr>
                                <?php
                                $_sales_note = $settings->_sales_note ?? '';
                                ?>
                                <?php if($_sales_note !=''): ?>
                                 <tr>
                                  <td  colspan="5"  style="font-size: 1em;">

                                    <?php echo e($settings->_sales_note ?? ''); ?>

                                  </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                  <td  colspan="5" >
                                    <?php echo $__env->make("backend.sales.invoice_history", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                  </td>
                                </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div >
              <?php echo $__env->make('backend.message.invoice_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
          
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></rect><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"></path><circle cx="392" cy="184" r="24" fill="currentColor"></circle></svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path></svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
        <input type="hidden" id="download_page_name" value="invoice_<?php echo e($data->_order_number); ?>">
<br>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sales-edit')): ?>
<a class="tm_invoice_btn tm_color2"  title="Edit" href="<?php echo e(route('sales.edit',$data->id)); ?>">Edit</a>
<?php endif; ?>

<br>
<a class="tm_invoice_btn tm_color2"  title="Back" href="<?php echo e(url('sales')); ?>">Back</a>
      </div>
    </div>
  </div>
  <script src="<?php echo e(asset('backend/invoices/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/invoices/jspdf.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/invoices/html2canvas.min.js')); ?>"></script>
  <script src="<?php echo e(asset('backend/invoices/main.js')); ?>"></script>

</body>
</html><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/sales/print.blade.php ENDPATH**/ ?>