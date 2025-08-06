
<?php $__env->startSection('title',$page_name); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="<?php echo e(route('cost-center.index')); ?>"> <?php echo $page_name ?? ''; ?> </a>
            <ol class="breadcrumb float-sm-right ml-2">
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-create')): ?>
              
               <a  
               class="btn btn-sm btn-info active " 
               href="<?php echo e(route('cost-center.create')); ?>">
                   <i class="nav-icon fas fa-plus"></i> Create New
                </a>
              <?php endif; ?>
            </ol>
          </div>

        
      </div><!-- /.container-fluid -->
    </div>
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
      <p><?php echo e($message); ?></p>
    </div>
    <?php endif; ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 <?php echo $__env->make('backend.cost-center.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <table class="table table-bordered _list_table ">
                      <thead>
                        <tr>
                         <th class="_no">No</th>
                         <th class="_action">Action</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Details</th>
                         <th>Condition</th>
                         <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        
                      
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                                <td style="display: flex;">
                           
                                <a   
                                  href="<?php echo e(route('cost-center.show',$data->id)); ?>"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-eye"></i></a>


                                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-edit')): ?>
                                  <a   
                                  href="<?php echo e(route('cost-center.edit',$data->id)); ?>"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-pen "></i></a>
                                  <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-delete')): ?>
                                 <?php echo Form::open(['method' => 'DELETE','route' => ['cost-center.destroy', $data->id],'style'=>'display:inline']); ?>

                                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-default"><i class="fa fa-trash _required"></i></button>
                                  <?php echo Form::close(); ?>

                               <?php endif; ?>  

                               <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cost-center-authorization-chain')): ?>
                                  <a  type="button" 
                                  href="<?php echo e(url('cost-center-chain')); ?>/<?php echo e($data->id); ?>"
                                  class="btn btn-sm btn-default  mr-1"><i class="fa fa-users "></i></a>
                                  <?php endif; ?> -->
                               
                        </td>  
                              
                            <td><?php echo e($data->id); ?> - <?php echo e($data->_name); ?></td>
                            <td><?php echo e($data->_code ?? ''); ?></td>
                            <td><?php echo e(_view_date_formate($data->_start_date ?? '')); ?></td>
                            <td><?php echo e(_view_date_formate($data->_end_date ?? '')); ?></td>
                            <td><?php echo e($data->_detail ?? ''); ?></td>
                            <td>
                  <?php if($data->_is_close==1): ?> <span class="btn btn-warning">Running</span> <?php endif; ?>
                  <?php if($data->_is_close==2): ?> <span class="btn btn-success">Completed</span> <?php endif; ?>
                  <?php if($data->_is_close==3): ?> <span class="btn btn-danger">Stop</span> <?php endif; ?>
                            </td>
                            <td>
                  <?php if($data->_status==1): ?> <span class="btn btn-success">Active</span> <?php endif; ?>
                  <?php if($data->_status==0): ?> <span class="btn btn-danger">Disable</span> <?php endif; ?>
                            </td>
                            
                           
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 <?php echo $datas->render(); ?>

                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/backend/cost-center/index.blade.php ENDPATH**/ ?>