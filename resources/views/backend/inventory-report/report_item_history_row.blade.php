@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('filter-item-history')}}" role="button">
          <i class="fas fa-search"></i>
        </a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
    
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Item Name: </strong>{{ $previous_filter["_search_item_id"] ?? '' }}</td> </tr>
               
              </table>
            </td>
            
          </tr>
        </table>

    <!-- Table row -->
    
      <?php 
       if(sizeof($purchase_details) > 0){
        ?>
        <div class="table-responsive">
    <table class="cewReportTable">
          <tbody>
           <?php
           foreach ($purchase_details as $key=>$value) {
              $keys = array_keys((array)$value);
              if($key==0){ ?>
                <tr>
                  <?php 
                  foreach ($keys as $key_val) { ?>
                    <td><?php echo $key_val; ?></td>
                <?php  } ?>
                </tr>
            <?php   } ?>

            <tr>
                <?php
                foreach ($keys as  $key_val) { ?>
                <td>
                    <input type="text" 
                    attr_url="{{url('item-history-update')}}"
                    name="<?php echo $key_val; ?>" 
                    attr_table="<?php echo $value->_table_name; ?>"
                    attr_column_name="<?php echo $key_val; ?>"
                    attr_id="<?php echo $value->id; ?>"
                    value="<?php echo $value->$key_val; ?>" 
                    class="form-control item_history_keyup" 
                    <?php if($key_val=="id"){ echo "readonly"; }  ?>
                    <?php if($key_val=="_table_name"){ echo "readonly"; } ?>
                    >
                     
                   </td>
  
                  <?php  } ?>
            </tr>
        <?php    }  ?>
          </tbody>
    </table>
  </div>
     <?php    }  ?>

     <?php 
     //purchase_return_details
       if(sizeof($purchase_return_details) > 0){
        ?>
        <div class="table-responsive">
    <table class="cewReportTable">
          <tbody>
           <?php
           foreach ($purchase_return_details as $key=>$value) {
              $keys = array_keys((array)$value);
              if($key==0){ ?>
                <tr>
                  <?php 
                  foreach ($keys as $key_val) { ?>
                    <th><?php echo $key_val; ?></th>
                <?php  } ?>
                </tr>
            <?php   } ?>

            <tr>
                <?php
                foreach ($keys as  $key_val) { ?>
                <td>
                    <input type="text" 
                    attr_url="{{url('item-history-update')}}"
                    name="<?php echo $key_val; ?>" 
                    attr_table="<?php echo $value->_table_name; ?>"
                    attr_column_name="<?php echo $key_val; ?>"
                    attr_id="<?php echo $value->id; ?>"
                    value="<?php echo $value->$key_val; ?>" 
                    class="form-control item_history_keyup" 
                    <?php if($key_val=="id"){ echo "readonly"; }  ?>
                    <?php if($key_val=="_table_name"){ echo "readonly"; } ?>
                    >
                     
                   </td>
  
                  <?php  } ?>
            </tr>
        <?php    }  ?>
          </tbody>
    </table>
  </div>
     <?php    }  ?>
 <?php 
     //sales_details
       if(sizeof($sales_details) > 0){
        ?>
        <div class="table-responsive">
    <table class="cewReportTable">
          <tbody>
           <?php
           foreach ($sales_details as $key=>$value) {
              $keys = array_keys((array)$value);
              if($key==0){ ?>
                <tr>
                  <?php 
                  foreach ($keys as $key_val) { ?>
                    <th><?php echo $key_val; ?></th>
                <?php  } ?>
                </tr>
            <?php   } ?>

            <tr>
                <?php
                foreach ($keys as  $key_val) { ?>
                <td>
                    <input type="text" 
                    attr_url="{{url('item-history-update')}}"
                    name="<?php echo $key_val; ?>" 
                    attr_table="<?php echo $value->_table_name; ?>"
                    attr_column_name="<?php echo $key_val; ?>"
                    attr_id="<?php echo $value->id; ?>"
                    value="<?php echo $value->$key_val; ?>" 
                    class="form-control item_history_keyup" 
                    <?php if($key_val=="id"){ echo "readonly"; }  ?>
                    <?php if($key_val=="_table_name"){ echo "readonly"; } ?>
                    >
                     
                   </td>
  
                  <?php  } ?>
            </tr>
        <?php    }  ?>
          </tbody>
    </table>
     </div>
     <?php    }  ?>
 <?php 
     //sales_return_details
       if(sizeof($sales_return_details) > 0){
        ?>
        <div class="table-responsive">
    <table class="cewReportTable">
          <tbody>
           <?php
           foreach ($sales_return_details as $key=>$value) {
              $keys = array_keys((array)$value);
              if($key==0){ ?>
                <tr>
                  <?php 
                  foreach ($keys as $key_val) { ?>
                    <th><?php echo $key_val; ?></th>
                <?php  } ?>
                </tr>
            <?php   } ?>

            <tr>
                <?php
                foreach ($keys as  $key_val) { ?>
                <td>
                    <input type="text" 
                    attr_url="{{url('item-history-update')}}"
                    name="<?php echo $key_val; ?>" 
                    attr_table="<?php echo $value->_table_name; ?>"
                    attr_column_name="<?php echo $key_val; ?>"
                    attr_id="<?php echo $value->id; ?>"
                    value="<?php echo $value->$key_val; ?>" 
                    class="form-control item_history_keyup" 
                    <?php if($key_val=="id"){ echo "readonly"; }  ?>
                    <?php if($key_val=="_table_name"){ echo "readonly"; } ?>
                    >
                     
                   </td>
  
                  <?php  } ?>
            </tr>
        <?php    }  ?>
          </tbody>
    </table>
     </div>
     <?php    }  ?>

   
 <?php 
     //damage_adjustment_details
       if(sizeof($damage_adjustment_details) > 0){
        ?>
        <div class="table-responsive">
    <table class="cewReportTable">
          <tbody>
           <?php
           foreach ($damage_adjustment_details as $key=>$value) {
              $keys = array_keys((array)$value);
              if($key==0){ ?>
                <tr>
                  <?php 
                  foreach ($keys as $key_val) { ?>
                    <th><?php echo $key_val; ?></th>
                <?php  } ?>
                </tr>
            <?php   } ?>

            <tr>
                <?php
                foreach ($keys as  $key_val) { ?>
                <td>
                    <input type="text" 
                    attr_url="{{url('item-history-update')}}"
                    name="<?php echo $key_val; ?>" 
                    attr_table="<?php echo $value->_table_name; ?>"
                    attr_column_name="<?php echo $key_val; ?>"
                    attr_id="<?php echo $value->id; ?>"
                    value="<?php echo $value->$key_val; ?>" 
                    class="form-control item_history_keyup" 
                    <?php if($key_val=="id"){ echo "readonly"; }  ?>
                    <?php if($key_val=="_table_name"){ echo "readonly"; } ?>
                    >
                     
                   </td>
  
                  <?php  } ?>
            </tr>
        <?php    }  ?>
          </tbody>
    </table>
     </div>
     <?php    }  ?>

   
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')

<script type="text/javascript">

  $(document).on('change','.item_history_keyup',function(e){
    var row_id = $(this).attr('attr_id');
    var table_name = $(this).attr("attr_table");
    var column_name = $(this).attr("attr_column_name");
    var column_value = $(this).val();
    var attr_url = $(this).attr("attr_url");

    $(".ajax_loader").show();
    $(".loading_text").text('Updating..');

    var request = $.ajax({
                url:attr_url,
                method: "GET",
                async:true,
                data: { row_id,table_name,column_name,column_value },
              });
               
              request.done(function( result ) {
                console.log(result);
                $(".ajax_loader").hide();
                
              })

  

});
</script>

@endsection
