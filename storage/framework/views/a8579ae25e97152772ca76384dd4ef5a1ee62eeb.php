
<?php $__env->startSection('title',$page_name ?? ''); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="<?php echo e(url('report-panel')); ?>">Report</a> / 
            <a class="_page_name" href="#"><?php echo e($page_name ?? ''); ?></a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              <?php echo $__env->make('backend.message.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    
                    
                        <div class="row">
                            <div class="col-md-3">
                                <input type="date" name="_datex" class="form-control _datex" value="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="_datey" class="form-control _datey" value="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="col-md-3">
                                <button id="filterBtn" class="btn btn-sm btn-primary">Filter</button>
                                <button id="resetBtn" class="btn btn-sm btn-secondary">Reset</button>
                            </div>
                        </div>
                  
                </div>
                <div class="card-body" id="reportTable">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    // Load initial data
 //   loadReportData();

    // Filter button click event
    $('#filterBtn').click(function() {
      //alert(1);
        loadReportData();
    });

    // Reset button click event
    $('#resetBtn').click(function() {
        $('#yearFilter').val(new Date().getFullYear());
        $('#monthFilter').val('all');
        loadReportData();
    });

    function loadReportData() {
        const _datex =$(document).find('._datex').val();
        const _datey =$(document).find('._datey').val();
        $.ajax({
            url: '<?php echo e(route("reports.income-expense.data")); ?>',
            type: 'GET',

            data: {
                _datex: _datex,
                _datey: _datey
            },
            beforeSend: function() {
                $('#reportTable tbody').html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
            },
            success: function(response) {
               // renderTableData(response.data, response.totals);

              $(document).find("#reportTable").html(response)
            },
            error: function(xhr) {
                $('#reportTable tbody').html('<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>');
                console.error(xhr.responseText);
            }
        });
    }

   
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u561342241/domains/saifinfotech.com/public_html/tmm/resources/views/reports/income-expense.blade.php ENDPATH**/ ?>