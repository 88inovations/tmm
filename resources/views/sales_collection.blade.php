<?php
require_once('app.function.php');
if(isset($_POST['collection'])){
  $TerritoryId=$_POST['TerritoryId'];
  $Customer_Id=$_POST['CustomerId'];
  $company_inf=NEW app();
  $employ_list=$company_inf->getAll("SELECT * FROM `employee` WHERE areaid=$TerritoryId");
  $territory_list=$company_inf->getAll("SELECT * FROM `territory` WHERE id=$TerritoryId");
  $data=$company_inf->getOne("SELECT * FROM `invsetup`");
  $Customer_Data=$company_inf->getOne("SELECT * FROM `party_info` WHERE id='$Customer_Id'");
  $ladger=$company_inf->getAll("SELECT * FROM (SELECT party_id, date,REF, null as remark, null as credit, total_amount as debit FROM `invoice` UNION SELECT collecton.party_id, collecton.date, collecton.reF,collecton.remurck, collecton.total_amount, null FROM collecton UNION SELECT cid, date,REF,remark,amount,null FROM sales_return) a WHERE a.party_id='$Customer_Id' ORDER BY date");

  $name=$cname;
  $address=$data['addres'];
  $Customer_Id=$Customer_Data['id'];
  $Customer_Name=$Customer_Data['name'];
  $Customer_Propitor=$Customer_Data['propaitor'];
  $Customer_CellNo=$Customer_Data['cellno'];
  $Customer_Address=$Customer_Data['address'];
 ?>
    <div class="form-control  pb-5">
    <h4 class="" style="font-size:14px;">Collection Form</h4>
   
    <div class="col text-center">
      <div class="party_information">
        <table class="table table-borderless table-sm party_info text-left" style="line-height: 1;">
        <tr><th class="w-" >ID</th><th>:</th><td class="w-100"><strong> <?php echo str_pad($Customer_Id,3,'0',STR_PAD_LEFT);?></strong></td></tr>
        <tr class="d-none" ><th >ID</th><th>:</th><td id="Customer_Id"><?php echo $Customer_Id; ?></td></tr>
        <tr><th>Name</th><th>:</th><td><?php echo $Customer_Name;?></td></tr>
        <tr><th>Propitor</th><th>:</th><td><?php echo $Customer_Propitor;?></td></tr>
        <tr><th>Cell No</th><th>:</th><td><?php echo $Customer_CellNo;?></td></tr>
        <tr><th>Address</th><th>:</th><td><?php echo $Customer_Address;?></td></tr>

        </table>
      </div>
            <?php
            
            $balance=0; 
            foreach ($ladger as $ladger) {
              $date=date_create($ladger['date']);
              $balance=$balance+$ladger['debit']-$ladger['credit'];
            }
            
            ?>
            <div class="row">
            <div class="col-6 text-left">
            <h5 class="float-start">Balance = <?php echo number_format($balance,2) ;?>tk</h5>

            <div class="input-group input-group-sm mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Collection Amount</span>
                </div>
                <input type="number" id="collection_amount" class="form-control collection_amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            </div>            
            <div class="input-group input-group-sm mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Referance</span>
                </div>
                <input type="text" id="reference" class="form-control reference" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            </div>            
            <div class="input-group input-group-sm mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="height:31px" id="inputGroup-sizing-sm">Officer</span>
                </div>
                  <select id="Officer" class="form-select float-start form-select-sm mb-1  w-50 " aria-label="Default select example">
                    <?php 
                    $list='';
                    foreach($employ_list as $employ_list){
                        $list.='<option value="'.$employ_list['id'].'">'.$employ_list['name'].'</option>';
                    }
                    echo $list;
                    ?>
                    </select>
                    </div>
                    <div class="input-group input-group-sm mb-1">
                    <div class="input-group-prepend">
                    <span class="input-group-text" style="height:31px" id="inputGroup-sizing-sm">Territory</span>
                  </div>

                    <select id="Territory" class="form-select form-select-sm mb-1 ml-1  w-50 " aria-label="Default select example">
                    <?php foreach($territory_list as $data){
                        $officer.='<option value="'.$data['id'].'">'.$data['name'].'</option>';
                    }
                    echo $officer;
                    unset($_POST['collection']);
                    ?>

                    </select>
                    </div>
            </div>
            <div class="col-4 pl-2 text-end">
            <div class="erorr text-danger ml-5" style="position:absolute"></div>
            </div>
            </div>


            <button id="collection" class="btn btn-sm btn-danger text-white float-end collection"><b>SUBMIT</b></button>

          </div>  
        

 <?php

}

if(isset($_POST['collection_amount'])){
  $Customer_Id=$_POST['Customer_Id'];
  $collection_amount=$_POST['collection_amount'];
  $reference=$_POST['reference'];
  $officer=$_POST['officer'];
  $TerriTory=$_POST['TerriTory'];
 
  $collection=NEW app();
  $TaxId=$collection->getOne("SELECT max(reF) as TaxId FROM `collecton`");
  $TxrId=$TaxId['TaxId'];
  $New_TxrId=$collection->TxrId($TxrId); //invoice number generating.
  $New_Collection="INSERT INTO `collecton` (reF,party_id,territory_id,sales_byid,total_amount,remurck) VALUES ('$New_TxrId','$Customer_Id','$TerriTory','$officer','$collection_amount','$reference')";
  $collection_status=$collection->execute($New_Collection);
  if($collection_status==true){
    $status="Clected";
  }

  $ladger=$collection->getAll("SELECT * FROM (SELECT party_id, date,REF, null as remark, null as credit, total_amount as debit FROM `invoice` UNION SELECT collecton.party_id, collecton.date, collecton.reF,collecton.remurck, collecton.total_amount, null FROM collecton UNION SELECT cid, date,REF,remark,amount,null FROM sales_return) a WHERE a.party_id='$Customer_Id' ORDER BY date");
  $balance=0; 
  foreach ($ladger as $ladger) {
    $date=date_create($ladger['date']);
    $balance=$balance+$ladger['debit']-$ladger['credit'];
  }
  ?>
  <table class="table table-borderless table-sm party_info text-left" style="line-height: 1;">
  <tr><th>Collection Statas</th><th>:</th><td><?php echo $status;?></td></tr>
  <tr><th>TxrId</th><th>:</th><td><?php echo $New_TxrId;?></td></tr>
  <tr><th>New Balance</th><th>:</th><td><?php echo $balance;?></td></tr>
  </table>

  <?php
  unset($_POST['collection_amount']);

  }
  //Collection delete
  if(isset($_POST['TxrId'])){
    $code=New app();
    $TxrId=$_POST['TxrId'];
    $collection="SELECT* FROM(SELECT collecton.id as collectionid ,collecton.date,collecton.reF as TxrId, collecton.total_amount, party_info.id,party_info.name,party_info.propaitor,collecton.remurck FROM `collecton` INNER JOIN party_info ON collecton.party_id=party_info.id)a WHERE TxrId='$TxrId'";
    $data=$code->getOne($collection);
        if($data==false){
      echo json_encode(0);
      unset($_POST['TxrId']);
    }else if($data==true){
    ?>
        <div class="form-contro  pb-5">
       <h4 class="" style="font-size:14px;">Collection Delete</h4>

      <table class="table table-sm table-bordered">
        <thead class="text-capitalize text-center" style="font-size:12px;">
          <th>date</th><th>id</th><th>name</th><th>Propitor</th><th>colletion no</th><th>particullar</th><th>amount</th><th>Option</th>
        </thead>
        <tbody >
          <?php
          $TxrId=$data['collectionid'];
            $list='<tr>

            <td>'.date_format(date_create($data['date']),"d-m-Y").'</td>
            <td>'.$data['id'].'</td><td>'.$data['name'].'</td>
            <td>'.$data['propaitor'].'</td>
            <td>'.$data['TxrId'].'</td>
            <td>'.$data['remurck'].'</td>
            <td>'.number_format($data['total_amount'],2).'tk.</td>
            <td><button id="collection_delete_btn" class="btn btn-sm btn-danger" value="'.$TxrId.'"><b>Delete</b></button></td>
            
            </tr>';
            echo $list;
    
        ?>
      </tbody>
      </table>
      
      </div>
    <?php
    }
    isset($_POST['TxrId']);

  }
/*****\
******** sales and collection report code
******/

  if(isset($_POST['CollecTion']) or isset($_POST['area'])){
    $app=NEW app();
    $date1=$_POST['date1'];
    $date2=$_POST['date2'].' 23:59:59';
    if($_POST['CollecTion']==true and $_POST['area']>0){
    $area_id=$_POST['area'];
    $territory=$app->getOne("SELECT * FROM `territory` WHERE id='$area_id'");
    $area=$territory['name'];
    $sql="SELECT * FROM (SELECT party_info.name as name, invoice.date,invoice.REF,invoice.party_id as pid,invoice.territory_id as territory, invoice.total_amount as salesamount, null as collectionamoun, null as remurck FROM `invoice` INNER JOIN party_info ON party_info.id=invoice.party_id UNION SELECT party_info.name, collecton.date,collecton.reF,collecton.party_id,collecton.territory_id, null,collecton.total_amount,collecton.remurck FROM `collecton` INNER JOIN party_info ON party_info.id=collecton.party_id  ) a WHERE a.territory='$area_id' and  a.date>='$date1' and a.date<='$date2' ORDER by a.date";
    $date1=date_format(date_create($date1),'d-m-Y');
    $date2=date_format(date_create($date2),'d-m-Y');
    $subject="Sales And Collection Report of {$area} Form {$date1} To {$date2}";
    $salesreturn="SELECT sales_return.date,party_info.name,party_info.address,party_info.territory_id,sales_return.REF,sales_return.amount FROM party_info INNER JOIN sales_return on party_info.id=sales_return.cid WHERE sales_return.date>='$date1' and sales_return.date>='$date2' and party_info.territory_id='$area_id'";


    }elseif($_POST['CollecTion']==TRUE){
    $area="All Territory";
    $sql="SELECT * FROM (SELECT party_info.name as name, invoice.date,invoice.REF,invoice.party_id as pid,invoice.territory_id as territory, invoice.total_amount as salesamount, null as collectionamoun, null as remurck FROM `invoice` INNER JOIN party_info ON party_info.id=invoice.party_id UNION SELECT party_info.name, collecton.date,collecton.reF,collecton.party_id,collecton.territory_id, null,collecton.total_amount,collecton.remurck FROM `collecton` INNER JOIN party_info ON party_info.id=collecton.party_id) a WHERE  a.date>='$date1' and a.date<='$date2' ORDER by a.date";
    $date1=date_format(date_create($date1),'d-m-Y');
    $date2=date_format(date_create($date2),'d-m-Y');
    $subject="Sales And Collection Report Form {$date1} To {$date2}";
    $salesreturn="SELECT sales_return.date,party_info.name,party_info.address,party_info.territory_id,sales_return.REF,sales_return.amount FROM party_info INNER JOIN sales_return on party_info.id=sales_return.cid WHERE sales_return.date>='$date1' and sales_return.date>='$date2'";

    } 
      $line='';
      $salcoll=$app->getAll($sql);
      $total_sales=0;
      $total_collection=0;
      $addjustmentTotal=0;
      foreach($salcoll as $salcoll){
        $date=date_format(date_create($salcoll['date']),'d-m-Y'); 
        $folio=$salcoll['REF'];
        $ParyName=$salcoll['name'];
        $sales=$salcoll['salesamount'];
        $total_sales=$total_sales+$sales;
        $collection=$salcoll['collectionamoun'];
        $particullar=trim($salcoll['remurck'],' ');
        
        if($particullar==="Collection"){
          $collection=$collection;
          $total_collection+=$collection;
          $addjustment='';
        }else{
          $addjustment=$collection;
          $addjustmentTotal+=$addjustment;
          $collection='0';
        }
        
        $sales=number_format($sales,2);
        if($sales==0){
          $sales='';
        }else {
          $sales=$sales;
        }
        $collection=number_format($collection,2);
        if($collection==0){
          $collection='';
        }else {
          $collection=$collection;
        }

        //$total_collection=number_format($total_collection,2);
       $line.="<tr  style='font-size:13px;'>
       <td class='' style=width:85px;>{$date}</td>
       <td  class='text-start' style='width:300px;'>{$ParyName}</td>
       <td class='text-center' style='width:85px;'>{$folio}</td>
       <td class='text-center' style='width:85px;'>{$particullar}</td>
       <td class='text-end' style='width:40px;'  >{$sales}</td>
       <td class='text-end' style='width:85px;'>{$collection}</td>
       <td class='text-end' style='width:20px;'>".numberformat($addjustment,2)."</td>
       </tr>";
      }
      $total_sales=number_format($total_sales,2);
      $total_collection=number_format($total_collection,2);
      $addjustmentTotal=numberformat($addjustmentTotal,2);
      $line.="<tr class='fs-7 fw-bold text-end'>
      <td colspan='4' style='width:px;'>Total = </td>
      <td style='width:85px;'>{$total_sales}</td>
      <td style='width:85px;'>{$total_collection}</td>
      <td style='width:85px;'>{$addjustmentTotal}</td>
      </tr>";
      ?>
      <div id="head"> 
      <h5><?php echo $cname; ?></h5>
      <p class="text-justify text-center " style="font-size:13px; width: 620px; margin: 0 auto;"><?php echo $caddress; ?></p>
      </div>
      
    <table class="table-borderless table-sm text-start mt-1 mb-1"style="font-size:13px;line-height: 0.6em;">
    <tr><th>Date</th><th>:</th><td class="w-100 text-start"><?php echo date('d-m-Y'); ?></td></tr>
    <tr><th>Terretory</th><th>:</th><td><?php echo $area;?></td></tr>
    <tr><th>Subject</th><th>:</th><td><?php echo $subject; ?></td></tr>
    
    </table>
   
    <table id="SCR" class="table-bordered" style="font-size:13px;">
    <thead class="text-uppercase bg-info"> 
      <th style="width:85px;">Date</th>
      <th style="width:300px;" >name of Party</th>
      <th style="width:85px;">SC No</th>
      <th style="width:85px;">particullar</th>
      <th style="width:40px;">Sales</th>
      <th style="width:85px;">Collecton</th>
      <th style="width:20px;">Adjustment</th>
    </thead>
    <tbody>

      <?php
      echo $line;
  }