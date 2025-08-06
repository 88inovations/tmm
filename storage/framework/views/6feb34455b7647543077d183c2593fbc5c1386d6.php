  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item-information-create')): ?>
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default new_item_using_modal" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   New Item
                </button>
               </li>
               <?php endif; ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-create')): ?>
             <li class="breadcrumb-item ">
                 <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="<?php echo e(url('account-type-for-new-ledger')); ?>" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button> 
               </li>
               <?php endif; ?><?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/common-modal/item_ledger_sub_link.blade.php ENDPATH**/ ?>