              
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voucher-create')): ?>
               
                        <a title="Journal Voucher" class="btn  btn-sm btn-default" href="<?php echo e(route('voucher.create')); ?>"> <i class="nav-icon fas fa-plus"></i> JV </a>
                        
                <?php endif; ?> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-receive')): ?>
                   
                        <a title="Cash Receive" class="btn  btn-sm btn-default" href="<?php echo e(url('cash-receive')); ?>"> <i class="nav-icon fas fa-plus"></i> CR </a>
                  
                <?php endif; ?> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cash-payment')): ?>
                   
                        <a title="Cash payment" class="btn  btn-sm btn-default" href="<?php echo e(url('cash-payment')); ?>"> <i class="nav-icon fas fa-plus"></i> CP </a>
                   
                <?php endif; ?> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('petty-cash')): ?>
                   
                        <a title="Petty Cash" class="btn  btn-sm btn-default" href="<?php echo e(url('petty-cash')); ?>"> <i class="nav-icon fas fa-plus"></i> PC </a>
                   
                <?php endif; ?> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-receive')): ?>
                    
                        <a title="Bank Receive" class="btn  btn-sm btn-default" href="<?php echo e(url('bank-receive')); ?>"> <i class="nav-icon fas fa-plus"></i> BR </a>
                   
                <?php endif; ?> 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bank-payment')): ?>
                     
                        <a title="Bank Payment" class="btn  btn-sm btn-default" href="<?php echo e(url('bank-payment')); ?>"> <i class="nav-icon fas fa-plus"></i> BP </a>
                   
                <?php endif; ?> 
                
                
                <?php /**PATH D:\xampp\htdocs\tmm\resources\views/backend/message/voucher-header.blade.php ENDPATH**/ ?>