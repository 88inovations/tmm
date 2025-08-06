
<?php $__env->startSection('title',$page_name ?? ''); ?>
<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="<?php echo e(route('hrm-employee.index')); ?>"><?php echo $page_name ?? ''; ?> </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hrm-employee-list')): ?>
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="<?php echo e(route('hrm-employee.index')); ?>"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               <?php endif; ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-md-12">
<div class="card">
<div class="card-header p-2">
<ul class="nav nav-pills">
<li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab"><?php echo e(__('label.personal_Details')); ?></a></li>
<li class="nav-item"><a class="nav-link" href="#current_salary_structures" data-toggle="tab"><?php echo e(__('label.current_salary_structures')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab"><?php echo e(__('label.hrm_education')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_emergencies" data-toggle="tab"><?php echo e(__('label.hrm_emergencies')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_empaddresses" data-toggle="tab"><?php echo e(__('label.hrm_empaddresses')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_experiences" data-toggle="tab"><?php echo e(__('label.hrm_experiences')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_guarantors" data-toggle="tab"><?php echo e(__('label.hrm_guarantors')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_jobcontracts" data-toggle="tab"><?php echo e(__('label.hrm_jobcontracts')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_languages" data-toggle="tab"><?php echo e(__('label.hrm_languages')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_nominees" data-toggle="tab"><?php echo e(__('label.hrm_nominees')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_rewards" data-toggle="tab"><?php echo e(__('label.hrm_rewards')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_trainings" data-toggle="tab"><?php echo e(__('label.hrm_trainings')); ?></a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_transfers" data-toggle="tab"><?php echo e(__('label.hrm_transfers')); ?></a></li>
</ul>
</div>
<div class="card-body">
  
                <?php echo Form::model($data, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['hrm-employee.update', $data->id]]); ?>

                <input type="hidden" name="_ledger_id" class="form-control _ledger_id" value="<?php echo e($data->_ledger_id); ?>">
<div class="tab-content">
    <?php
    $users = \Auth::user();
    $permited_organizations = permited_organization(explode(',',$users->organization_ids));
    $permited_branch = permited_branch(explode(',',$users->branch_ids));
    $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
    ?> 
<div class="tab-pane active" id="tab1">
    
    <?php echo $__env->make('hrm.hrm-employee.profesonal_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
   
</div><!-- End fo Tab One -->

<div class="tab-pane" id="tab2"><!-- Starting Point Two -->
    
   
    
    
</div><!-- End of Second Tab -->

<div class="tab-pane" id="tab3"><!-- Starting point tab 3 -->


    
    <div class="form-group">
        <label class="col-sm-2 col-form-label">Image:</label>
        <div class="col-sm-6">
       <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
       <img id="output_1" class="banner_image_create" src="<?php echo e(asset('/')); ?><?php echo e($settings->logo ?? ''); ?>"  style="max-height:100px;max-width: 100px; " />
    </div>
</div>


</div><!-- End of Tab Three -->




<?php echo $__env->make('hrm.hrm-employee.hrm_education', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.current_salary_structures', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_emergencies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_empaddresses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_experiences', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_guarantors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_jobcontracts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_languages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_nominees', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_rewards', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_trainings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('hrm.hrm-employee.hrm_transfers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="form-group row">
<div class="offset-sm-2 col-sm-6">
<button type="submit" class="btn btn-danger">Submit</button>
</div>
</div>

</div> <!-- End of tab content -->
</form> <!-- End of form -->

</div>
</div>

</div>
         
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
 $(document).ready(function(){
    payhead_calculatons();
 })
 
$(document).on('keyup','.payhead_amount',function(){
    payhead_calculatons();

})

function payhead_calculatons(){
    var total_earnings =0;
    var total_deduction=0;
    $(document).find('._deduction_salary').each(function(){
        var deduction = parseFloat(isEmpty($(this).val()));
        if(isNaN(deduction)){
            $(this).val(0);
            deduction=0;
        }
        total_deduction +=parseFloat(deduction);
    })
    $(document).find('._add_salary').each(function(){
        var earning = parseFloat(isEmpty($(this).val()));
        if(isNaN(earning)){
             $(this).val(0);
            earning=0
        }
        total_earnings +=parseFloat(earning);
    })
    var net_total_earning = (parseFloat(total_earnings)-parseFloat(total_deduction));

    $(document).find(".total_earnings").val(total_earnings);
    $(document).find(".total_deduction").val(total_deduction);
    $(document).find(".net_total_earning").val(net_total_earning);
}


    function addNew_hrm_transfers(event){
        var _hrm_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_transfers_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_transfers_id[]" value="<?php echo e($transfer->id ?? 0); ?>">
          </td>
           <td>
                 <select class="form-control _forganization_id" name="_forganization_id[]"  >
                    <?php if(sizeof($permited_organizations) > 1): ?> 
                    <option value="">--Select--</option>
                     <?php endif; ?>
                   
                   <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                   <option value="<?php echo e($val->id); ?>" ><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                   <?php endif; ?>
                 </select>
            </td>
            
            <td>
                 <select class="form-control _fbranch_id" name="_fbranch_id[]"  >
                               <?php if(sizeof($permited_branch) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($branch->id); ?>" ><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                <select class="form-control _fcost_center_id" name="_fcost_center_id[]"  >
                               <?php if(sizeof($permited_costcenters) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" ><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                 <input type="date"   name="_ttransfer[]" class="form-control _ttransfer " value="" placeholder="<?php echo e(__('label._ttransfer')); ?>" >
            </td>
            <td>
                 <select class="form-control _torganization_id" name="_torganization_id[]"  >
                    <?php if(sizeof($permited_organizations) > 1): ?> 
                    <option value="">--Select--</option>
                     <?php endif; ?>
                   
                   <?php $__empty_1 = true; $__currentLoopData = $permited_organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                   <option value="<?php echo e($val->id); ?>"><?php echo e($val->id ?? ''); ?> - <?php echo e($val->_name ?? ''); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                   <?php endif; ?>
                 </select>
            </td>
            
            <td>
                 <select class="form-control _tbranch_id" name="_tbranch_id[]"  >
                               <?php if(sizeof($permited_branch) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($branch->id); ?>" ><?php echo e($branch->id ?? ''); ?> - <?php echo e($branch->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                <select class="form-control _tcost_center_id" name="_tcost_center_id[]"  >
                               <?php if(sizeof($permited_costcenters) > 1): ?> 
                                <option value="">--Select--</option>
                                 <?php endif; ?>
                               <?php $__empty_1 = true; $__currentLoopData = $permited_costcenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost_center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                               <option value="<?php echo e($cost_center->id); ?>" ><?php echo e($cost_center->id ?? ''); ?> - <?php echo e($cost_center->_name ?? ''); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                             </select>
            </td>
            <td>
                 <input type="date"   name="_tjoin[]" class="form-control _tjoin " value="" placeholder="<?php echo e(__('label._tjoin')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_tnote[]" class="form-control _tnote " value="" placeholder="<?php echo e(__('label._tnote')); ?>" >
            </td>
            
        </tr>`;

        $(document).find('.hrm_transferss_body').append(_hrm_html);
    }

    $(document).on('click','.hrm_transfers_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })

    function addNew_hrm_trainings(event){
        var _hrm_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_trainings_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_trainings_id[]" value="0">
          </td>
           <td>
                 <input type="text"   name="training_type[]" class="form-control _type " value="" placeholder="<?php echo e(__('label._type')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="training_name[]" class="form-control _name " value="" placeholder="<?php echo e(__('label._name')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_subject[]" class="form-control _subject " value="" placeholder="<?php echo e(__('label._subject')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_organized[]" class="form-control _organized " value="" placeholder="<?php echo e(__('label._organized')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_place[]" class="form-control _place " value="" placeholder="<?php echo e(__('label._place')); ?>" >
            </td>
            <td>
                 <input type="date"   name="training_trfrom[]" class="form-control _trfrom " value="" placeholder="<?php echo e(__('label._trfrom')); ?>" >
            </td>
            <td>
                 <input type="date"   name="training_trto[]" class="form-control _trto " value="" placeholder="<?php echo e(__('label._trto')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_result[]" class="form-control _result " value="" placeholder="<?php echo e(__('label._result')); ?>" >
            </td>
            <td>
                 <input type="text"   name="training_note[]" class="form-control _note " value="" placeholder="<?php echo e(__('label._note')); ?>" >
            </td>
            
        </tr>`;

        $(document).find('.hrm_trainingss_body').append(_hrm_html);
    }

    $(document).on('click','.hrm_trainings_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })

    function addNew_hrm_rewards(event){
        var _hrm_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_rewards_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_rewards_id[]" value="0">
          </td>
           <td>
                 <input type="text"   name="_rcategory[]" class="form-control _rcategory " value="" placeholder="<?php echo e(__('label._rcategory')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_rtype[]" class="form-control _rtype " value="" placeholder="<?php echo e(__('label._rtype')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_rcause[]" class="form-control _rcause " value="" placeholder="<?php echo e(__('label._rcause')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_rnote[]" class="form-control _rnote " value="" placeholder="<?php echo e(__('label._rnote')); ?>" >
            </td>
            
        </tr>`;

        $(document).find('.hrm_rewardss_body').append(_hrm_html);
    }

    $(document).on('click','.hrm_rewards_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })


    function addNew_hrm_languages(event){
        var _hrm_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_languages_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_languages_id[]" value="0">
          </td>
           <td>
                 <input type="text"   name="_language[]" class="form-control _language " value="" placeholder="<?php echo e(__('label._language')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_fluency[]" class="form-control _fluency " value="" placeholder="<?php echo e(__('label._fluency')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_lnote[]" class="form-control _lnote " value="" placeholder="<?php echo e(__('label._lnote')); ?>" >
            </td>
            
        </tr>`;

        $(document).find('.hrm_languagess_body').append(_hrm_html);
    }

    $(document).on('click','.hrm_languages_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })



    function addNewhrm_experiences(event){
        var _hrm_education_html=`<tr><td>
            <a href="#none" class="btn btn-default hrm_experiences_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_experiences_id[]" value="0">
          </td>
           <td>
                 <input type="text" name="_company[]" class="form-control _company" placeholder="<?php echo e(__('label._company')); ?>">
            </td>
            <td>
                <select class="form-control " name="hrm_experiences_jobtitle_id[]"  >
                  <option value=""><?php echo e(__('label.select')); ?></option>
                  <?php $__empty_1 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <option value="<?php echo e($deg->id); ?>"><?php echo $deg->_name ?? ''; ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <?php endif; ?>
                </select>
            </td>
            <td>
                 <input type="date"   name="_wfrom[]" class="form-control _wfrom " value="" placeholder="<?php echo e(__('label._wfrom')); ?>" >
            </td>
            <td>
                 <input type="date"   name="_wto[]" class="form-control _wto " value="" placeholder="<?php echo e(__('label._wto')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_note[]" class="form-control _note " value="" placeholder="<?php echo e(__('label._note')); ?>" >
            </td>
            
            
        </tr>`;

        $(document).find('.hrm_experiences_body').append(_hrm_education_html);
    }

    $(document).on('click','.hrm_experiences_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })


    
    function addNew_hrm_education(event){
        var _hrm_education_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_education_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_education_id[]" value="0">
          </td>
           
            <td><input type="text"   name="_level[]" class="form-control _level " value="" placeholder="<?php echo e(__('label._level')); ?>" > </td>
            <td><input type="text"   name="_subject[]" class="form-control _subject " value="" placeholder="<?php echo e(__('label._subject')); ?>" ></td>
            <td><input type="text"   name="_institute[]" class="form-control _institute " value="" placeholder="<?php echo e(__('label._institute')); ?>" ></td>
            <td> <input type="text"   name="_year[]" class="form-control _year " value="" placeholder="<?php echo e(__('label._year')); ?>" >
            </td>
            <td><input type="text"   name="_score[]" class="form-control _score " value="" placeholder="<?php echo e(__('label._score')); ?>" ></td>
            <td><input type="date"   name="_edsdate[]" class="form-control _edsdate " value="" placeholder="<?php echo e(__('label._edsdate')); ?>" > </td>
            <td><input type="date"   name="_ededate[]" class="form-control _ededate " value="" placeholder="<?php echo e(__('label._ededate')); ?>" ></td>
        </tr>`;

        $(document).find('.hrm_educations_body').append(_hrm_education_html);
    }

    $(document).on('click','.hrm_education_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })


    function addNewhrm_emergencies(event){
        var hrm_emergencies_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_emergencies_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_emergencies_id[]" value="0">
          </td>
           
            <td><input type="text"   name="emerg_name[]" class="form-control _name " value="" placeholder="<?php echo e(__('label._name')); ?>" > </td>
            <td><input type="text"   name="emerg_relationship[]" class="form-control _relationship " value="" placeholder="<?php echo e(__('label._relationship')); ?>" ></td>
            <td><input type="text"   name="emerg_mobile[]" class="form-control _mobile " value="" placeholder="<?php echo e(__('label._mobile')); ?>" ></td>
            <td> <input type="text"   name="emerg_home[]" class="form-control _home " value="" placeholder="<?php echo e(__('label._home')); ?>" >
            </td>
            <td><input type="text"   name="emerg_work[]" class="form-control _work " value="" placeholder="<?php echo e(__('label._work')); ?>" ></td>
        </tr>`;

        $(document).find('.hrm_emergencies_body').append(hrm_emergencies_html);
    }

    $(document).on('click','.hrm_emergencies_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })


    function addNewhrm_empaddresses(event){
        var hrm_emergencies_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_empaddresses_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_empaddresses_id[]" value="0">
          </td>
           <td>
                 <select name="_type[]" class="form-control _type">
                     <option value="Present" >Present</option>
                     <option value="Parmanent" >Parmanent</option>
                 </select>
            </td>
            <td>
                 <input type="text"   name="_district[]" class="form-control _district " value="" placeholder="<?php echo e(__('label._district')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_police[]" class="form-control _police " value="" placeholder="<?php echo e(__('label._police')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_post[]" class="form-control _post " value="" placeholder="<?php echo e(__('label._post')); ?>" >
            </td>
            
            <td>
                 <input type="text"   name="_address[]" class="form-control _address " value="" placeholder="<?php echo e(__('label._address')); ?>" >
            </td>
            <td>
                 <input type="text"   name="_eaddress[]" class="form-control _eaddress " value="" placeholder="<?php echo e(__('label._eaddress')); ?>" >
            </td>
            
        </tr>`;

        $(document).find('.hrm_empaddresses_body').append(hrm_emergencies_html);
    }

    $(document).on('click','.hrm_empaddresses_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })
    function addNew_hrm_guarantors(event){
        var hrm_emergencies_html=`<tr>
            <td>
            <a href="#none" class="btn btn-default hrm_guarantors_remove_row"><i class="fa fa-trash"></i></a>
            <input type="hidden" name="hrm_guarantors_id[]" value="0">
          </td>
           <td>
            <input type="text"   name="gur_name[]" class="form-control gur_name " value="" placeholder="<?php echo e(__('label._name')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_father[]" class="form-control gur_father " value="" placeholder="<?php echo e(__('label._father')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_mother[]" class="form-control gur_mother " value="" placeholder="<?php echo e(__('label._mother')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_occupation[]" class="form-control gur_occupation " value="" placeholder="<?php echo e(__('label._occupation')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_workstation[]" class="form-control gur_workstation " value="" placeholder="<?php echo e(__('label._workstation')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_address1[]" class="form-control gur_address1 " value="" placeholder="<?php echo e(__('label._address1')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_address2[]" class="form-control gur_address2 " value="" placeholder="<?php echo e(__('label._address2')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_mobile[]" class="form-control gur_mobile " value="" placeholder="<?php echo e(__('label._mobile')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_email[]" class="form-control gur_email " value="" placeholder="<?php echo e(__('label._email')); ?>" >
           </td>
           <td>
            <input type="text"   name="gur_nationalid[]" class="form-control gur_nationalid " value="" placeholder="<?php echo e(__('label._nationalid')); ?>" >
           </td>
           <td>
            <input type="date"   name="gur_dob[]" class="form-control gur_dob " value="" placeholder="<?php echo e(__('label._dob')); ?>" >
           </td>
        </tr>`;

        $(document).find('.hrm_guarantorss_body').append(hrm_emergencies_html);
    }

    $(document).on('click','.hrm_guarantors_remove_row',function(){
        var confirmText = "Are you sure you want to delete this object?";
        if(confirm(confirmText)) {
            $(this).closest('tr').remove();
        }
    })
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/hrm/hrm-employee/edit.blade.php ENDPATH**/ ?>