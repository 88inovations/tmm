 
  <?php if(count($errors) > 0): ?>
                           <div class="alert  ">
                            
                                <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li style="color: red;"><?php echo $error; ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                  <?php if($message = Session::get('success')): ?>
                    <div class="alert  ">
                      <p><?php echo $message; ?></p>
                      
                    </div>
                    <?php endif; ?>
                  <?php if($message = Session::get('danger')): ?>
                    <div class="alert  _required _over_qty">
                      <p><?php echo $message; ?></p>
                    </div>
                    <?php endif; ?>
                  <?php if($message = Session::get('error')): ?>
                    <div class="alert  _required _over_qty">
                      <p><?php echo $message; ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($__message)): ?>

                      <h1 class="text-center _required"><?php echo $__message ?? ''; ?></h1>
                    <?php endif; ?>
<?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/message/message.blade.php ENDPATH**/ ?>