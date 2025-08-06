<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ItemCategory;
use App\Models\ItemInventory;
use App\Models\ProductPriceList;
use App\Models\Units;
use App\Models\Warranty;
use App\Models\UnitConversion;
use App\Models\PurchaseFormSettings;
use App\Models\CylinderProductPriceList;
use App\Models\GeneralSettings;
use App\Models\StoreHouse;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\ItemPackSize;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Session;
use DB;

use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class InventoryController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:item-information-list|item-information-create|item-information-edit|item-information-delete', ['only' => ['index','store']]);
         $this->middleware('permission:item-information-create', ['only' => ['create','store']]);
         $this->middleware('permission:item-information-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item-information-delete', ['only' => ['destroy']]);
         $this->middleware('permission:item-sales-price-update', ['only' => ['salesPriceUpdate']]);
         $this->page_name = "Item Information";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


       // item_code_Regenerate(); 

        //return insert_item();
      //  return unit_conversion();

         if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_i_limit', $request->limit);
        }else{
             $limit= \Session::get('_i_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';
        $datas = Inventory::with(['_category','_units','_warranty_name','unit_conversion','_pack_size']);
        if($request->has('_item') && $request->_item !=''){
            $datas = $datas->where('_item','like',"%$request->_item%");
        }
        if($request->has('_code') && $request->_code !=''){
            $datas = $datas->where('_code','like',"%$request->_code%");
        }
        if($request->has('id') && $request->id !=''){
            $datas = $datas->where('id','=',$request->id);
        }
        if($request->has('_barcode') && $request->_barcode !=''){
            $datas = $datas->where('_barcode','like',"%$request->_barcode%");
        }
        if($request->has('_discount') && $request->_discount !=''){
            $datas = $datas->where('_discount','like',"%$request->_discount%");
        }
        if($request->has('_vat') && $request->_vat !=''){
            $datas = $datas->where('_vat','like',"%$request->_vat%");
        }
        if($request->has('_pur_rate') && $request->_pur_rate !=''){
            $datas = $datas->where('_pur_rate','like',"%$request->_pur_rate%");
        }
        if($request->has('_sale_rate') && $request->_sale_rate !=''){
            $datas = $datas->where('_sale_rate','like',"%$request->_sale_rate%");
        }
        if($request->has('_manufacture_company') && $request->_manufacture_company !=''){
            $datas = $datas->where('_manufacture_company','like',"%$request->_manufacture_company%");
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status','=',$request->_status);
        }
        if($request->has('_unit_id') && $request->_unit_id !=''){
            $datas = $datas->where('_unit_id','=',$request->_unit_id);
        }
        if($request->has('_unique_barcode') && $request->_unique_barcode !=''){
            $datas = $datas->where('_unique_barcode','=',$request->_unique_barcode);
        }
        if($request->has('_kitchen_item') && $request->_kitchen_item !=''){
            $datas = $datas->where('_kitchen_item','=',$request->_kitchen_item);
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id','=',$request->_category_id);
        }
        if($request->has('_warranty') && $request->_warranty !=''){
            $datas = $datas->where('_warranty','=',$request->_warranty);
        }
        if($request->has('_reorder') && $request->_reorder !=''){
            $datas = $datas->where('_reorder','=',$request->_reorder);
        }
        if($request->has('_order_qty') && $request->_order_qty !=''){
            $datas = $datas->where('_order_qty','=',$request->_order_qty);
        }


        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        $page_name = $this->page_name;

        $categories = ItemCategory::with(['_parents'])->orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->where('_status',1)->get();
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.item-information.master_print',compact('datas','page_name','request','limit','_warranties'));
            }
         }
          $units = Units::orderBy('_name','asc')->get();
        return view('backend.item-information.index',compact('datas','request','page_name','limit','categories','units','_warranties'));

    }







 public function showManufactureCompanys(Request $request){
         $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_manufacture_company';
        $text_val = $request->_text_val;

         $datas = Inventory::select('_manufacture_company');
         if($request->has('_text_val') && $request->_text_val !=''){
            $datas = $datas->where('_manufacture_company','like',"%$request->_text_val%");
        }
        
        $datas = $datas->distinct()->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);

        return response($datas);
    }



    public function cylinder_upload(Request $request){



       

         $organization_id = 1;
         $_p_balance = 0;
         $__sub_total = 0;
         $__total = 0;
         $__discount_input = 0;
         $__total_discount = 0;
         $__total_vat = 0;
         $_date = date('Y-m-d');

         $_main_branch_id = 1;
            $__table="purchases";
            $_order_number = make_order_number($__table,$organization_id,$_main_branch_id,$_date);
         

      
         $users = \Auth::user();
        $Purchase = new Purchase();
        $Purchase->_date = change_date_format(date('Y-m-d'));
        $Purchase->_time = date('H:i:s');
        $Purchase->_order_ref_id =0;
        $Purchase->_delivery_status = 1;
        $Purchase->_order_number = $_order_number;
        $Purchase->_referance = 'Opening';
        $Purchase->_ledger_id = 12;
        $Purchase->_user_id = 46;
        $Purchase->_created_by = 'admin';
        $Purchase->_user_id = 46;
        $Purchase->_user_name = 'admin';
        $Purchase->_note = $request->_note ?? 'Opening Inventory';
        $Purchase->_sub_total = $__sub_total;
        $Purchase->_discount_input = $__discount_input;
        $Purchase->_total_discount = $__total_discount;
        $Purchase->_total_vat = $__total_vat;
        $Purchase->_total =  $__total;
        $Purchase->_branch_id = $_branch_id ?? 1;
        $Purchase->organization_id = $organization_id;
        $Purchase->_cost_center_id = $_cost_center_id ?? 1;
        $Purchase->_address ='';
        $Purchase->_phone = '';
        $Purchase->_status = 1;
        $Purchase->_lock = $request->_lock ?? 0;
        $Purchase->save();
        $purchase_id = $Purchase->id;
        $_pfix = $Purchase->_order_number ?? '';



      //  return $request->all();
                $file_full = $_FILES['file'];

                // Get file properties
                 $fileName = $file_full['name'];
                $fileTmpName = $file_full['tmp_name'];
                $fileSize = $file_full['size'];
                $fileError = $file_full['error'];
                $fileType = $file_full['type'];

                // Get file extension
                $fileExt = explode('.', $fileName);
                 $fileActualExt = strtolower(end($fileExt));

                // Allowed file extensions
                $allowedCSV = array('csv');
                $allowedExcel = array('xls', 'xlsx');
                 // Check if the file extension is a CSV or Excel file
                if (in_array($fileActualExt, $allowedCSV) || in_array($fileActualExt, $allowedExcel)) {

                    // Check for errors
                    if ($fileError === 0) {
                            // Generate a unique file name
                             $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                             $fileDestination = 'uploads/' . $fileNameNew;

                            // Move the file to the destination
                           move_uploaded_file($fileTmpName, $fileDestination);

                            // Set the file destination
                            $log_file = $_FILES['file']['tmp_name'];
                            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            if ($extension == "csv") {
                              $handle = fopen($fileDestination, "r");
                            } elseif ($extension == "xls" || $extension == "xlsx") {
                              require 'PHPExcel/IOFactory.php';
                              $objPHPExcel = PHPExcel_IOFactory::load($log_file);
                              $sheet = $objPHPExcel->getSheet(0);
                              $highestRow = $sheet->getHighestRow();
                              $highestColumn = $sheet->getHighestColumn();
                            }


                            if ($extension == "csv") {
                                $i =0;
                                $rowCount=0;
                                $datas =[];
                              while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {

                              //  return $data;

                                
                                if($i !=0){
                 
                                
                                    $sl = $data[0] ?? '';
                                    $receive_date = $data[1] ?? '';
                                    $_name = $data[2] ?? '';
                                    $model = $data[3] ?? '';
                                    $cirum = $data[4] ?? '';
                                    $length = $data[5] ?? '';
                                    $_qty = $data[6] ?? 0;
                                    $_customer_location = $data[7] ?? '';
                                    $delivery_date = $data[8] ?? '';
                                     $store = trim($data[9] ?? '');
                        $store_empty = 0;
                            if(empty($store)){
                                $store_empty = 0;
                            }else{
                                $store_empty = 1;
                            }

                                    $_category_id = 2;
// Step 1: Remove unwanted characters (commas, currency, etc.)
$_qty = str_replace([',', '৳', '$', 'pcs', ' '], '', $_qty);

// Step 2: Check and convert
if (is_numeric($_qty)) {
    $_qty = floatval($_qty); // or intval($_qty) if you only allow integers
} else {
    $_qty = 0; // fallback for invalid input
}


                        if(!empty($_name) && $_qty > 0){

                                    $_store_id = 0;
                                    if($store="Imu Flxi"){ $_store_id = 1;}
                                    if($store="New Store"){ $_store_id = 1;}
                                    if($store="Office"){ $_store_id = 2;}
                                    if($store="Old Store"){ $_store_id = 1; }
                                    if($store="Store"){ $_store_id = 1; }

                                   

                                    $item_codes         =  item_code_generate(2);
                                    $_serial            =  $item_codes["_serial"] ?? '';
                                    $full_product_code  = $item_codes["full_product_code"] ?? '';
                                    $_item_code  = $item_codes["full_product_code"] ?? '';



                                    $inventory = Inventory::where('_item',$_name)->where('_category_id',2)->first();
                                    if(empty($inventory)){
                                        $inventory              = new Inventory();
                                    }
                                    $inventory->_item           = $_name;
                                    $inventory->_code           = $full_product_code;
                                    $inventory->_serial           = $_serial;
                                    $inventory->_item_category  = 'Inventory';
                                    $inventory->_barcode        = $model ?? '';
                                    $inventory->_category_id    = 2;
                                    $inventory->_unit_id        = 6;
                                    $inventory->_pack_size_id   = 1;
                                    $inventory->_brand_id       = 1;
                                    $inventory->_curum          = $cirum ?? '';
                                    $inventory->_length         = $length ?? '';
                                    $inventory->_description    = $_customer_location ?? '';
                                    $inventory->_status         = $_status ?? 1;
                                    $inventory->_is_used        = $_is_used ?? 1;
                                    $inventory->_unique_barcode    = $_unique_barcode ?? 0;
                                    $inventory->save();

                                    $_item_id = $inventory->id;


                                    $_receive_date = null;

                                    if (!empty($receive_date)) {
                                        if (is_numeric($receive_date)) {
                                            $_receive_date = ExcelDate::excelToDateTimeObject($receive_date)->format('Y-m-d');
                                        } else {
                                            try {
                                                $_receive_date = \Carbon\Carbon::parse($receive_date)->format('Y-m-d');
                                            } catch (\Exception $e) {
                                                $_receive_date = null;
                                            }
                                        }
                                    }

                                    // If still null, fallback to previous valid date
                                    if (empty($_receive_date) && !empty($last_valid_receive_date)) {
                                        $_receive_date = $last_valid_receive_date;
                                    }

                                    // If valid, update last valid date
                                    if (!empty($_receive_date)) {
                                        $last_valid_receive_date = $_receive_date;
                                    }

                                    // Only save if delivery date is empty
                                    if (!empty($_receive_date)) {
                                      

                                        $item_inventories = new ItemInventory();
                                        $item_inventories->_date = $last_valid_receive_date;
                                        $item_inventories->_item_id = $_item_id;
                                        $item_inventories->_item_name = $_name ?? '';
                                        $item_inventories->_unit_id = 6;
                                        $item_inventories->_unit_conversion = 1;
                                        $item_inventories->_transection_unit = 6;
                                        $item_inventories->_base_unit = 6;
                                        $item_inventories->_category_id = 2;
                                        $item_inventories->_pack_size_id = 1;
                                        $item_inventories->_brand_id = 1;
                                        $item_inventories->_transection = 'Purchase';
                                        $item_inventories->_transection_ref = 0;
                                        $item_inventories->_transection_detail_ref_id = 0;
                                        $item_inventories->_qty = $_qty;
                                        $item_inventories->_short_note = $_customer_location ?? '';
                                        $item_inventories->_item_code = $_item_code ?? '';
                                        $item_inventories->_status = 1;
                                        $item_inventories->_created_by = 46;
                                        $item_inventories->organization_id = 1;
                                        $item_inventories->_branch_id = 1;
                                        $item_inventories->_cost_center_id = 1;
                                        $item_inventories->_budget_id = 0;
                                        $item_inventories->_store_id = $_store_id;
                                        $item_inventories->save();
                                    } 




if(!empty($delivery_date)){


                                    $_delivery_date = null;
                                    if (!empty($delivery_date)) {
                                        if (is_numeric($delivery_date)) {
                                            $_delivery_date = ExcelDate::excelToDateTimeObject($delivery_date)->format('Y-m-d');
                                        } else {
                                            try {
                                                $_delivery_date = \Carbon\Carbon::parse($delivery_date)->format('Y-m-d');
                                            } catch (\Exception $e) {
                                                $_delivery_date = null;
                                            }
                                        }
                                    }

                                    // If still null, fallback to previous valid date
                                    if (empty($_delivery_date) && !empty($last_valid_delivery_date)) {
                                        $_delivery_date = $last_valid_delivery_date;
                                    }

                                    // If valid, update last valid date
                                    if (!empty($_delivery_date)) {
                                        $last_valid_delivery_date = $_delivery_date;
                                    }


                                     // Only save if delivery date is empty
                                    if (!empty($last_valid_delivery_date)) {
                                      

                                        $item_inventories = new ItemInventory();
                                        $item_inventories->_date = $last_valid_delivery_date;
                                        $item_inventories->_item_id = $_item_id;
                                        $item_inventories->_item_name = $_name ?? '';
                                        $item_inventories->_unit_id = 6;
                                        $item_inventories->_unit_conversion = 1;
                                        $item_inventories->_transection_unit = 6;
                                        $item_inventories->_base_unit = 6;
                                        $item_inventories->_category_id = 2;
                                        $item_inventories->_pack_size_id = 1;
                                        $item_inventories->_brand_id = 1;
                                        $item_inventories->_transection = 'Sales';
                                        $item_inventories->_transection_ref = 0;
                                        $item_inventories->_transection_detail_ref_id = 0;
                                        $item_inventories->_qty = -$_qty;
                                        $item_inventories->_short_note = $_customer_location ?? '';
                                        $item_inventories->_item_code = $_item_code ?? '';
                                        $item_inventories->_status = 1;
                                        $item_inventories->_created_by = 46;
                                        $item_inventories->organization_id = 1;
                                        $item_inventories->_branch_id = 1;
                                        $item_inventories->_cost_center_id = 1;
                                        $item_inventories->_budget_id = 0;
                                        $item_inventories->_store_id = $_store_id;
                                        $item_inventories->save();
                                    } 

}




            if($store_empty > 0 ){
                

                $PurchaseDetail = new PurchaseDetail();
                $PurchaseDetail->_item_id = $_item_id;
                $PurchaseDetail->_qty = $_qty;

                $PurchaseDetail->_transection_unit = 6;
                $PurchaseDetail->_unit_conversion = 1;
                $PurchaseDetail->_base_unit = 6;


                $PurchaseDetail->_barcode = $model;
                $PurchaseDetail->_base_rate =0;
                $PurchaseDetail->_rate =0;
                $PurchaseDetail->_short_note = '';
                $PurchaseDetail->_sales_rate = 0;
                $PurchaseDetail->_discount =  0;
                $PurchaseDetail->_discount_amount =  0;
                $PurchaseDetail->_vat =  0;
                $PurchaseDetail->_vat_amount =  0;
                $PurchaseDetail->_value =  0;
                $PurchaseDetail->_store_id = $_store_id ?? 1;
                $PurchaseDetail->_cost_center_id = $_cost_center_id ?? 1;
                $PurchaseDetail->_store_salves_id = '';
                $PurchaseDetail->organization_id = $organization_id ?? 1;
                $PurchaseDetail->_branch_id = $_branch_id ?? 1;
                $PurchaseDetail->_no = $purchase_id;
                $PurchaseDetail->_status = 1;
                $PurchaseDetail->_created_by = $users->id."-".$users->name;
                $PurchaseDetail->save();
                $_purchase_detail_id = $PurchaseDetail->id;



                    $product_prices = new ProductPriceList();
                    $product_prices->_master_id = $purchase_id ?? 1;
                    $product_prices->_purchase_detail_id = $_purchase_detail_id;
                    $product_prices->_item_id = $_item_id;
                    $product_prices->_category_id = $_category_id;
                    $product_prices->_brand_id = $_brand_id ?? 1;
                    $product_prices->_pack_size_id = $_pack_size_id ?? 1;
                    $product_prices->_base_unit = $_base_unit ?? 6;
                    $product_prices->_unit_id = $_base_unit ?? 6;
                    $product_prices->_transection_unit = $_transection_unit ?? 6;
                    $product_prices->_unit_conversion = $_unit_conversion ?? 1;
                    $product_prices->_item = $_name ?? '';
                    $product_prices->_input_type = 'Purchase';
                    $product_prices->_barcode = $model ?? '';
                    $product_prices->_qty = $_qty ?? 0;
                    $product_prices->organization_id = $organization_id ?? 1;
                    $product_prices->_branch_id = $_branch_id ?? 1;
                    $product_prices->_store_id = $_store_id ?? 1;
                    $product_prices->_cost_center_id = $_cost_center_id ?? 1;
                  
                    $product_prices->_status = $_status ?? 1;
                    $product_prices->_short_note = $_customer_location ?? '';
                    $product_prices->save();



                    }





                            } //End of Check Empty
                                    

 

                                }
                                    $i++;
                                    $rowCount++;
                              }


                              fclose($handle);
                            }


                           return redirect('item-information')->with('success','Data Uploaded Successfully'); 
                   
                
            }
        }


    }






    public function fileUpload(Request $request){

      //  return $request->all();
                $file_full = $_FILES['file'];

                // Get file properties
                 $fileName = $file_full['name'];
                $fileTmpName = $file_full['tmp_name'];
                $fileSize = $file_full['size'];
                $fileError = $file_full['error'];
                $fileType = $file_full['type'];

                // Get file extension
                $fileExt = explode('.', $fileName);
                 $fileActualExt = strtolower(end($fileExt));

                // Allowed file extensions
                $allowedCSV = array('csv');
                $allowedExcel = array('xls', 'xlsx');
                 // Check if the file extension is a CSV or Excel file
                if (in_array($fileActualExt, $allowedCSV) || in_array($fileActualExt, $allowedExcel)) {

                    // Check for errors
                    if ($fileError === 0) {
                            // Generate a unique file name
                             $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                             $fileDestination = 'uploads/' . $fileNameNew;

                            // Move the file to the destination
                            move_uploaded_file($fileTmpName, $fileDestination);

                            // Set the file destination
                            $log_file = $_FILES['file']['tmp_name'];
                            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            if ($extension == "csv") {
                              $handle = fopen($fileDestination, "r");
                            } elseif ($extension == "xls" || $extension == "xlsx") {
                              require 'PHPExcel/IOFactory.php';
                              $objPHPExcel = PHPExcel_IOFactory::load($log_file);
                              $sheet = $objPHPExcel->getSheet(0);
                              $highestRow = $sheet->getHighestRow();
                              $highestColumn = $sheet->getHighestColumn();
                            }


                            if ($extension == "csv") {
                                $i =0;
                                $rowCount=0;
                                $datas =[];
                              while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {

                              //  return $data;

                                
                                if($i !=0){
                 
                                    echo "<pre>";
                                    $Product_Name = $data[0];
                                    echo "</pre>";
                                    $description = $data[1] ?? '';
                                    $Pack_Size = $data[2] ?? '';
                                    $Stock = $data[3] ?? 0;
                                    $Pusr = $data[4] ?? 0;
                                    $Price = $data[5] ?? 0;
                                    $tp = $data[6] ?? 0;
                                    $MRP = $data[7] ?? 0;
                                    $Origin = $data[8] ?? '';
                                    $_is_used = 1;


        $item_codes         =  item_code_generate(1);
        $_serial            =  $item_codes["_serial"] ?? '';
        $full_product_code  = $item_codes["full_product_code"] ?? '';

        $data                   = new Inventory();
        $data->_item            = $Product_Name ?? '';
        $data->_unit_id         = 6;
        $data->_brand_id        = 2;
        $data->_pack_size_id    = 1;
        $data->_code            = $full_product_code;
        $data->_serial          = $_serial;
        $data->_barcode         = $full_product_code;
        $data->_category_id     = 1;
        $data->_status          = 1;
        $data->_is_used         = 1;
        $data->_item_category   = 'Inventory';
        $data->save();

                                    // $data=[
                                    //     'Product_Name'=>$Product_Name,
                                    //     'description'=>$description,
                                    //     'Pack_Size'=>$Pack_Size,
                                    //     'Stock'=>$Stock,
                                    //     'Pusr'=>$Pusr,
                                    //     'Price'=>$Price,
                                    //     'tp'=>$tp,
                                    //     'MRP'=>$MRP,
                                    //     'Origin'=>$Origin,
                                    //     '_is_used'=>$_is_used,
                                    // ];

                                    // $datas[]=  $data;


                                    // $pack_sizeid= \DB::table("item_pack_sizes")->where('_name',$data[2])->first()->id ?? 1;
                                    // $Inventory = Inventory::where('_item',$data[0])->where('_pack_size_id',$pack_sizeid)->first();
                                    // if(!empty($Inventory)){
                                    //     $Inventory->_balance = $Stock;
                                    //    $Inventory->_pur_rate = $Price;
                                    //    $Inventory->_sale_rate = $tp;
                                    //    $Inventory->_trade_price = $tp;
                                    //    $Inventory->_mrp_price = $MRP;
                                    //    $Inventory->_oringin = $Origin;
                                    //    $Inventory->_is_used = 1;
                                        
                                    //     $Inventory->save();
                                    // }

                                   
 

                                }
                                    $i++;
                                    $rowCount++;
                              }


                              fclose($handle);
                            }


                           return redirect('item-information')->with('success','Data Uploaded Successfully'); 
                    if ($extension == "xls" || $extension == "xlsx") {
                              for ($row = 1; $row <= $highestRow; $row++) {

                                return $rowData;
                                    $date_time = $rowData[0][2];
                                    exit($rowData[0]);
                                    
                                    $row_number++;

                              }
                            }
                
            }
        }


    }

    public function itemWiseUnits(Request $request){
        $_item_id = $request["item_id"];
        $units = Units::orderBy('_name','asc')->get();
        $conversionUnits = UnitConversion::where('_item_id',$_item_id)
                        ->where('_status',1)->orderBy('id','asc')->get();
        return view('backend.item-information.unit_option',compact('conversionUnits','units'));
    }
    public function itemWiseUnitConversion(Request $request){
        $_item_id = $request["item_id"];
        $base_unit_name = $request["base_unit_name"];
       // $_item_id = $request->_item_id;
        $units = Units::orderBy('_name','asc')->get();
        $conversionUnits = UnitConversion::where('_item_id',$_item_id)->where('_status',1)->get();
        return view('backend.item-information.unit_ajax',compact('conversionUnits','units','base_unit_name'));
       
    }

    public function itemWiseUnitConversionSave(Request $request){
        $conversion_id = $request->conversion_id ?? [];
        $conversion_item_id = $request->conversion_item_id ?? [];
        $_base_unit_id = $request->_base_unit_id ?? [];
        $_conversion_qty = $request->_conversion_qty ?? [];
        $_conversion_unit = $request->_conversion_unit ?? [];
        $_converted_unit_names = $request->_converted_unit_names ?? [];
        
        $item_id = $request->item_id;
        UnitConversion::where('_item_id',$item_id)->update(['_status'=>0]);
        for ($i=0; $i <sizeof($conversion_id) ; $i++) { 
            if($conversion_id[$i]==0){
                $UnitConversion = new UnitConversion();
            }else{
                $UnitConversion = UnitConversion::find($conversion_id[$i]);
            }
            $UnitConversion->_item_id = $item_id;
            $UnitConversion->_base_unit_id = $_base_unit_id[$i];
            $UnitConversion->_conversion_qty = $_conversion_qty[$i];
            $UnitConversion->_conversion_unit = $_conversion_unit[$i];
            $UnitConversion->_conversion_unit_name = _find_unit($_conversion_unit[$i]);
            $UnitConversion->_status = 1;
            $UnitConversion->save();
        }
        $data["message"]="success";
        return json_encode($data);

    }

    public function labelPrint(Request $request){
        $page_name="Label Print";
         $_id = $request->_id ?? 0;
         $_type = $request->_type;
         $_item_id=$request->_item_id ?? '';

        $datas = [];
        if($_id !=0 && $_type =='purchase' && $_item_id ==''){
              $datas = \App\Models\PurchaseDetail::with(['_items'])->where('_status',1)
               ->where('_no',$_id)
               ->get();
        }
        if($_id !=0 && $_type =='production' && $_item_id ==''){
              $datas = \App\Models\StockIn::with(['_items'])->where('_status',1)
               ->where('_no',$_id)
               ->get();
        }

        if($_id !=0 && $_type =='purchase' && $_item_id !=''){
               $datas = \App\Models\PurchaseDetail::with(['_items'])->where('_status',1)
               ->where('_no',$_id)
               ->where('_item_id',$_item_id)
               ->get();
        }

        

        if($_id !=0 && $_type =='production' && $_item_id !=''){
              $datas = \App\Models\StockIn::with(['_items'])->where('_status',1)
               ->where('_no',$_id)
               ->where('_item_id',$_item_id)
               ->get();
        }
        
        
        return view('backend.item-information.label-print',compact('page_name','datas'));
    }

    public function barcodePrintStore(Request $request){
         $data =  $request->all();
         $barcode_setting = $request->barcode_setting ?? 1;
         if($barcode_setting ==1){
            return view('backend.item-information.final_print_1',compact('data'));
         }
         if($barcode_setting ==2){
            return view('backend.item-information.final_print_2',compact('data'));
         }
         if($barcode_setting ==3){
            return view('backend.item-information.final_print_3',compact('data'));
         }
         if($barcode_setting ==4){
            return view('backend.item-information.final_print_4',compact('data'));
         }
         if($barcode_setting ==5){
            return view('backend.item-information.final_print_5',compact('data'));
         }
         if($barcode_setting ==6){
            return view('backend.item-information.final_print_6',compact('data'));
         }

        
    }

     public function reset(){
        Session::flash('_i_limit');
       return  \Redirect::to('item-information?limit='.default_pagination());
    }

     public function lotReset(){
        Session::flash('_i_limit');
       return  \Redirect::to('lot-item-information?limit='.default_pagination());
    }


    public function transfer_to_asset_item(Request $request){

      //  return $request->all();
        $id                     = $request->id;
        $ProductPriceList       = ProductPriceList::with(['_items'])->find($id);

        $_table_name = $ProductPriceList->_table_name ?? 'purchases';
        $_master_id = $ProductPriceList->_master_id ?? '';

        $purchase_info = \DB::table($_table_name)->where('id',$_master_id)->first();



        $category_id            = $ProductPriceList->_items->_category_id ?? 0;
        $available_qty          = $request->_qty ?? 0;
        $number_of_asset_items          = $ProductPriceList->_qty ?? 0;
        $_p_p_id                = $ProductPriceList->id ?? 0;
        $_input_type            = $ProductPriceList->_input_type ?? '';
        $_purchase_detail_id    = $ProductPriceList->_purchase_detail_id;

        $_salvage_value         = 0;
        $purchase_price         = 0;
        $extra_cost             = 0;
        $entry_price            = 0;
        $evaluated_price        = 0;
        $dep_rate               = 0;
        $insured_amount         = 0;
        $purchase_voucher_no    = 0;
        $purchase_date          = '';

        if($_input_type =='import_purchase'){

            $asset_import_cost_details      = \DB::table('asset_import_cost_details')->where('id',$_purchase_detail_id)->first();
            $_import_detail_qty = $asset_import_cost_details->_qty ?? 0;

            $_salvage_value                 = (($asset_import_cost_details->_salvage_value ?? 0)/$_import_detail_qty);
            $purchase_price                 = ($asset_import_cost_details->_cfr_value_bdt/$asset_import_cost_details->_qty);
            $extra_cost                     = ($asset_import_cost_details->_other_cost_bdt/$asset_import_cost_details->_qty);
            $entry_price                    = ($asset_import_cost_details->_asset_value_bdt/$asset_import_cost_details->_qty);
             $evaluated_price                = ($asset_import_cost_details->_depreciable_asset_value/$asset_import_cost_details->_qty);
            $insured_amount                 = ($asset_import_cost_details->_insurance_bdt/$asset_import_cost_details->_qty);
            $purchase_voucher_no            = id_to_cloumn($asset_import_cost_details->_no,'_voucher_number','asset_import_costs');
        }else{
             $purchase_price             = $ProductPriceList->_pur_rate ?? 0;
             $_salvage_value             = 0;
            
            $extra_cost                  = 0;
            $entry_price                 = $purchase_price ;
            $evaluated_price             = $purchase_price ;
            $insured_amount              =0;
            $purchase_voucher_no         = id_to_cloumn($ProductPriceList->_no,'_order_number','purchases');
        }

        $category               = ItemCategory::with(['category_ledger','dep_exp_category_ledger','acc_dep_category_ledger'])
                                ->where('id',$category_id)
                                ->first();

      // return $number_of_asset_items = \DB::table("asset_items")->where('_p_p_id',$_p_p_id)->count('id');


    if($number_of_asset_items >= $available_qty ){
            //Now Transfer 
        $_item_id                   = $ProductPriceList->_item_id;
        $name                       = $ProductPriceList->_items->_item ?? '';
        $category_id                = $ProductPriceList->_items->_category_id ?? '';
        $asset_ledger_id            = $category->asset_ledger_id ?? 0;
        $asset_dep_ledger_id        = $category->asset_dep_ledger_id ?? 0;
        $asset_dep_exp_ledger_id    = $category->asset_dep_exp_ledger_id ?? 0;
        $brand_id                   = $ProductPriceList->_items->_brand_id ?? 0;
        $organization_id            = $ProductPriceList->organization_id ?? 0;
        $branch_id                  = $ProductPriceList->_branch_id ?? 0;
        $project_id                 = $ProductPriceList->_cost_center_id ?? 0;
        $_budget_id                 = $ProductPriceList->_budget_id ?? 0;
        $model_no                   = $ProductPriceList->_items->_barcode ?? '';
       // $asset_code                 = $ProductPriceList->_items->_barcode ?? ''; //Need to 
        $serial_no                  = $ProductPriceList->serial_no ?? ''; //Need to 
        $_p_p_id                    = $ProductPriceList->id;
        $import_cost_detail_id      = $ProductPriceList->_purchase_detail_id ?? 0;
       
        $_selling_value             = $ProductPriceList->_sales_rate ?? 0;
        $_from_table                = 'product_price_lists';
        $purchase_date              = change_date_format($purchase_info->_date ?? '');
        $_date                      = date("Y-m-d");
        $dep_rate                   = $category->dep_rate ?? 0;
        $_qty                       = $ProductPriceList->_qty ?? 0;

        

       $asset_code = category_wise_serial($category_id);
       $serial_no = category_wise_serial($category_id);

for ($i=0; $i < $available_qty ; $i++) { 

                $data =[
                    '_item_id'              =>$_item_id,
                    'name'                  =>$name,
                    'category_id'           =>$category_id,
                    'organization_id'       =>$organization_id,
                    'branch_id'             =>$branch_id,
                    'project_id'            =>$project_id,
                    '_budget_id'            =>$_budget_id,
                    'asset_tag'             =>$asset_code,
                    'asset_ledger_id'       =>$asset_ledger_id,
                    'asset_dep_ledger_id'   =>$asset_dep_ledger_id,
                    'asset_dep_exp_ledger_id'=>$asset_dep_exp_ledger_id,
                    'brand_id'              =>$brand_id,
                    'asset_condition_id'    =>1,
                    'assign_status_id'      =>2,
                    'purchase_price'        =>$purchase_price,
                    '_salvage_value'        =>$_salvage_value,
                    'extra_cost'            =>$extra_cost,
                    'entry_price'            =>$entry_price,
                    'evaluated_price'       =>$evaluated_price,
                    'insured_amount'        =>$insured_amount,
                    'purchase_voucher_no'   =>$purchase_voucher_no,
                    'model_no'              =>$model_no,
                    'serial_no'             =>$serial_no,
                    '_p_p_id'               =>$_p_p_id,
                    'import_cost_detail_id' =>$import_cost_detail_id,
                    '_from_table'           =>$_from_table,
                    'purchase_date'         =>$purchase_date,
                    '_date'                 =>$_date,
                    'dep_rate'              =>$dep_rate,
                    'dep_date'              =>$purchase_date,
                    '_selling_value'        =>$_selling_value,
                    'status'                =>1,
                    '_is_sold'              =>0,


                                ];

             \App\Models\AssetManagement\AssetItem::create($data);
}



 $_unique_barcode       = $request->attr_unique_barcode ?? 0;
$barcode_string         = $request->_barcode ?? '';
$_qty  = $request->_qty ?? 0;

                $_p_qty             = $ProductPriceList->_qty;
                $_unique_barcode    = $ProductPriceList->_unique_barcode;
                //Barcode  deduction from old string data
                if($_unique_barcode ==1){
                     $_old_barcode_strings          =  $ProductPriceList->_barcode;
                        $_new_barcode_array         = array();
                        if($_old_barcode_strings !=""){
                            $_old_barcode_array     = explode(",",$_old_barcode_strings);
                        }
                        if($barcode_string !=""){
                            $_new_barcode_array     = explode(",",$barcode_string);
                        }
                        if(sizeof($_new_barcode_array) > 0 && sizeof($_old_barcode_array) > 0){
                          $_last_barcode_array      =  array_diff($_old_barcode_array,$_new_barcode_array);
                          if(sizeof($_last_barcode_array ) > 0){
                            $_last_barcode_string   = implode(",",$_last_barcode_array);
                          }else{
                            $_last_barcode_string   = $barcode_string;
                          }
                          
                          $ProductPriceList->_barcode = $_last_barcode_string;
                        }
                }

                $_status                            = (($_p_qty - $_qty) > 0) ? 1 : 0;
                $ProductPriceList->_qty             = ($_p_qty - $_qty);
                $_pur_rate = $ProductPriceList->_pur_rate ?? 0;
                $ProductPriceList->_value             = ($_pur_rate*($_p_qty - $_qty));

                $ProductPriceList->_status          = $_status;
                





if($_status ==0){
    $_transfer_to_asset=1;
}

$ProductPriceList->_transfer_to_asset       =$_transfer_to_asset ?? 0; 
$ProductPriceList->save(); 

       return redirect()->back()->with('success','Information Transfer successfully');     
        }else{
            return redirect()->back()->with('success','Information Already Transfer successfully');
        }

         



    }




    public function lotItemInformation(Request $request){
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_i_limit', $request->limit);
        }else{
             $limit= \Session::get('_i_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';





        
        $datas = ProductPriceList::with(['_units','_warranty_name','_items','_organization','_master_branch','_master_cost_center','_master_store'])->where('_qty','!=',0);
        if($request->has('id') && $request->id !=''){
            $datas = $datas->where('id',$request->id);
        }
        if($request->has('_item') && $request->_item !=''){
            $datas = $datas->where('_item','like',"%$request->_item%");
        }
        if($request->has('_input_type') && $request->_input_type !=''){
            $datas = $datas->where('_input_type','LIKE',"%$request->_input_type%");
        }
       
        if($request->has('_code') && $request->_code !=''){
             $datas = $datas->whereHas('_items', function ($query) use ($request) {
                    $query->where('_code', 'like', "%{$request->item_code}%");
                });
        }
        if($request->has('_barcode') && $request->_barcode !=''){
            $datas = $datas->where('_barcode','like',"%$request->_barcode%");
        }
        if($request->has('_discount') && $request->_discount !=''){
            $datas = $datas->where('_discount','like',"%$request->_discount%");
        }
        if($request->has('_vat') && $request->_vat !=''){
            $datas = $datas->where('_vat','like',"%$request->_vat%");
        }
        if($request->has('_pur_rate') && $request->_pur_rate !=''){
            $datas = $datas->where('_pur_rate','like',"%$request->_pur_rate%");
        }
        if($request->has('_sale_rate') && $request->_sale_rate !=''){
            $datas = $datas->where('_sale_rate','like',"%$request->_sale_rate%");
        }
        if($request->has('_manufacture_company') && $request->_manufacture_company !=''){
            $datas = $datas->where('_manufacture_company','like',"%$request->_manufacture_company%");
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id','=',$request->_category_id);
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status','=',$request->_status);
        }
        if($request->has('_unique_barcode') && $request->_unique_barcode !=''){
            $datas = $datas->where('_unique_barcode','=',$request->_unique_barcode);
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id','=',$request->_category_id);
        }
        if($request->has('_warranty') && $request->_warranty !=''){
            $datas = $datas->where('_warranty','=',$request->_warranty);
        }
        if($request->has('_unit_id') && $request->_unit_id !=''){
            $datas = $datas->where('_unit_id','=',$request->_unit_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_store_id') && $request->_store_id !=''){
            $datas = $datas->where('_store_id','=',$request->_store_id);
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        $page_name ='Lot Wise Item Information';
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();

        $categories = ItemCategory::with('_parents')->orderBy('_name','asc')->get();
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.item-information.lot_print',compact('datas','page_name','request','limit','_warranties'));
            }
         }
          $units = Units::orderBy('_name','asc')->get();
         return view('backend.item-information.lot_item',compact('datas','request','page_name','limit','categories','units','_warranties'));
    }


    public function cylinder_product(Request $request){
        if($request->has('limit')){
            $limit = $request->limit ??  default_pagination();
            session()->put('_i_limit', $request->limit);
        }else{
             $limit= \Session::get('_i_limit') ??  default_pagination();
            
        }
        
        $_asc_desc = $request->_asc_desc ?? 'DESC';
        $asc_cloumn =  $request->asc_cloumn ?? 'id';






        
        $datas = CylinderProductPriceList::with(['_units','_warranty_name','_items','_organization','_master_branch','_master_cost_center','_master_store','_customer','_supplier'])->where('_qty','!=',0);
        if($request->has('id') && $request->id !=''){
            $datas = $datas->where('id',$request->id);
        }
        if($request->has('_item') && $request->_item !=''){
            $datas = $datas->where('_item','like',"%$request->_item%");
        }
        if($request->has('_input_type') && $request->_input_type !=''){
            $datas = $datas->where('_input_type','LIKE',"%$request->_input_type%");
        }
       
        if($request->has('_code') && $request->_code !=''){
             $datas = $datas->whereHas('_items', function ($query) use ($request) {
                    $query->where('_code', 'like', "%{$request->item_code}%");
                });
        }
        if($request->has('_barcode') && $request->_barcode !=''){
            $datas = $datas->where('_barcode','like',"%$request->_barcode%");
        }
        if($request->has('_discount') && $request->_discount !=''){
            $datas = $datas->where('_discount','like',"%$request->_discount%");
        }
        if($request->has('_vat') && $request->_vat !=''){
            $datas = $datas->where('_vat','like',"%$request->_vat%");
        }
        if($request->has('_pur_rate') && $request->_pur_rate !=''){
            $datas = $datas->where('_pur_rate','like',"%$request->_pur_rate%");
        }
        if($request->has('_sale_rate') && $request->_sale_rate !=''){
            $datas = $datas->where('_sale_rate','like',"%$request->_sale_rate%");
        }
        if($request->has('_manufacture_company') && $request->_manufacture_company !=''){
            $datas = $datas->where('_manufacture_company','like',"%$request->_manufacture_company%");
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id','=',$request->_category_id);
        }
        if($request->has('_status') && $request->_status !=''){
            $datas = $datas->where('_status','=',$request->_status);
        }
        if($request->has('_unique_barcode') && $request->_unique_barcode !=''){
            $datas = $datas->where('_unique_barcode','=',$request->_unique_barcode);
        }
        if($request->has('_category_id') && $request->_category_id !=''){
            $datas = $datas->where('_category_id','=',$request->_category_id);
        }
        if($request->has('_warranty') && $request->_warranty !=''){
            $datas = $datas->where('_warranty','=',$request->_warranty);
        }
        if($request->has('_unit_id') && $request->_unit_id !=''){
            $datas = $datas->where('_unit_id','=',$request->_unit_id);
        }
        if($request->has('_branch_id') && $request->_branch_id !=''){
            $datas = $datas->where('_branch_id','=',$request->_branch_id);
        }
        if($request->has('_cost_center_id') && $request->_cost_center_id !=''){
            $datas = $datas->where('_cost_center_id','=',$request->_cost_center_id);
        }
        if($request->has('_store_id') && $request->_store_id !=''){
            $datas = $datas->where('_store_id','=',$request->_store_id);
        }
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        $page_name =__('label.cylinder_product');
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();

        $categories = ItemCategory::with('_parents')->orderBy('_name','asc')->get();
        if($request->has('print')){
            if($request->print =="single"){
                return view('backend.item-information.lot_print',compact('datas','page_name','request','limit','_warranties'));
            }
         }
          $units = Units::orderBy('_name','asc')->get();
         return view('backend.item-information.cylinder_product',compact('datas','request','page_name','limit','categories','units','_warranties'));
    }


    public function cylinder_product_edit($id){
        $data = CylinderProductPriceList::with(['_units','_warranty_name','_items','_organization','_master_branch','_master_cost_center','_master_store','_customer','_supplier'])->find($id);
        $units = Units::orderBy('_name','asc')->get();
        $page_name =__('label.cylinder_product');
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();

        $categories = ItemCategory::with('_parents')->orderBy('_name','asc')->get();
        $item_pack_sizes  = \DB::table('item_pack_sizes')->orderBy('_name','ASC')->get();
        $item_brands  = \DB::table('item_brands')->orderBy('_name','ASC')->get();

        return view('backend.item-information.cylinder_product_edit',compact('page_name','data','units','_warranties','categories','item_pack_sizes','item_brands'));
    }


    


    public function itemPurchaseSearch(Request $request){
        $limit = $request->limit ?? default_pagination();
        $_asc_desc = $request->_asc_desc ?? 'ASC';
        $asc_cloumn =  $request->asc_cloumn ?? '_item';
        $text_val = $request->_text_val;


        $datas = Inventory::with(['unit_conversion','_units','_brands','_pack_size','_category'])
            ->select('id','_item as _name','_code','_unit_id','_barcode','_discount','_vat','_pur_rate','_sale_rate','_manufacture_company','_unique_barcode','_warranty','_balance','_brand_id','_pack_size_id','_hs_code','_hs_code_2','_category_id','_model')
            ->where('_status',1);
          if($request->has('_text_val') && $request->_text_val !=''){
            $datas = $datas->where('_item','like',"%$request->_text_val%")
            ->orWhere('_code','like',"%$request->_text_val%")
            ->orWhere('_barcode','like',"%$request->_text_val%")
            ->orWhere('_model','like',"%$request->_text_val%")
            ->orWhere('id','like',"%$request->_text_val%");
        }
        
        
        
        $datas = $datas->orderBy($asc_cloumn,$_asc_desc)->paginate($limit);
        return json_encode( $datas);
    }


    public function salesPriceEdit($id){
        $data = ProductPriceList::find($id);

         $page_name = " Lot Wise Price Update -".$data->_item ?? '';
         
        $categories = ItemCategory::orderBy('_name','asc')->get();
         $units = Units::orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
       return view('backend.item-information.lot_edit',compact('page_name','categories','data','units','_warranties'));
    }

    public function salesPriceUpdate(Request $request){

        //return $request->all();


        $this->validate($request, [
            'id' => 'required',
            '_item' => 'required',
            '_unit_id' => 'required',
            '_sales_rate' => 'required',
            '_status' => 'required'
        ]);
        
        $data                       = ProductPriceList::find($request->id);
        $data->_item                = $request->_item;
        $data->_unit_id             = $request->_unit_id;
        $data->_barcode             = $request->_barcode ?? '';
        $data->_p_discount_input    = $request->_p_discount_input ?? 0;
        $data->_p_vat               = $request->_p_vat ?? 0;
        $data->_sales_rate          = $request->_sales_rate ?? 0;
        $data->_qty                 = $request->_qty ?? 0;
        $data->_status              = $request->_status ?? 0;
        $data->_unique_barcode      = $request->_unique_barcode ?? 0;
        $data->_warranty            = $request->_warranty ?? 0;
        $data->save();
        return redirect()->back()->with('success','Information save successfully');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function create()
    {
        $users =\Auth::user();
        $page_name = $this->page_name;
        $categories = ItemCategory::with(['_parents','_childs'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $pack_sizes=ItemPackSize::where('_status',1)->orderBy('id','ASC')->get();
        $item_brands=ItemBrand::where('_status',1)->orderBy('id','ASC')->get();
        

       return view('backend.item-information.create',compact('page_name','categories','units','_warranties','permited_branch','permited_costcenters','store_houses','permited_organizations','pack_sizes','item_brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
       public function new_item_using_modal()
    {
        $users =\Auth::user();
        $page_name = $this->page_name;
        $categories = ItemCategory::with(['_parents','_childs'])->where('_parent_id',0)->orderBy('_name','asc')->get();
        $units = Units::orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
        $permited_branch = permited_branch(explode(',',$users->branch_ids));
        $permited_costcenters = permited_costcenters(explode(',',$users->cost_center_ids));
        $store_houses = permited_stores(explode(',',$users->store_ids));
        $permited_organizations = permited_organization(explode(',',$users->organization_ids));
        $pack_sizes=ItemPackSize::where('_status',1)->orderBy('id','ASC')->get();
        $item_brands=ItemBrand::where('_status',1)->orderBy('id','ASC')->get();
        

       return view('backend.item-information.new_item_using_modal',compact('page_name','categories','units','_warranties','permited_branch','permited_costcenters','store_houses','permited_organizations','pack_sizes','item_brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      // return $request->all();

         $this->validate($request, [
            '_category_id' => 'required',
            '_item' => 'required',
            '_unit_id' => 'required',
            '_status' => 'required'
        ]);

         // DB::beginTransaction();
         // try {

            $_category_id = $request->_category_id;
            $_item = $request->_item;
            $_unit_id = $request->_unit_id;
            $_warranty = $request->_warranty;
            $_manufacture_company = $request->_manufacture_company;
            $_code = $request->_code;
            $_barcode = $request->_barcode;
            $_model = $request->_model;
            $_discount = $request->_discount;
            $_vat = $request->_vat;
            $_branch_id = $request->_branch_id;
            $_cost_center_id = $request->_cost_center_id;
            $_store_id = $request->_store_id;
           // $_sum_opening_qty = array_sum($request->_opening_qty ?? []);
            $_pur_rate = $request->_pur_rate;
            $_sale_rate = $request->_sale_rate;
            $_reorder = $request->_reorder ?? 0;
            $_order_qty = $request->_order_qty ?? 0;
            $_kitchen_item = $request->_kitchen_item ?? 0;
            $_unique_barcode = $request->_unique_barcode ?? 0;
            $_status = $request->_status ?? 0;



        $item_codes =  item_code_generate($request->_category_id);
        $_serial =     $item_codes["_serial"] ?? '';
        $full_product_code = $item_codes["full_product_code"] ?? '';

     $users = \Auth::user();


     $data = Inventory::where('_item',$request->_item)
                        ->where('_unit_id',$request->_unit_id)
                        ->where('_pack_size_id',$request->_pack_size_id)
                        ->where('_brand_id',$request->_brand_id)
                        ->first();
    if(empty($data)){
        $data = new Inventory();
    }


        
        $data->_item = $request->_item ?? '';
        $data->_unit_id = $request->_unit_id;
        $data->_brand_id = $request->_brand_id ?? 1;
        $data->_pack_size_id = $request->_pack_size_id ?? 1;
        $data->_code = $request->_code ?? $full_product_code;
        $data->_serial = $_serial;
        $data->_barcode = $request->_barcode ?? $full_product_code;
        $data->_category_id = $request->_category_id;
         $data->_hs_code_2 = $request->_hs_code_2 ?? '';
        $data->_hs_code = $request->_hs_code ?? '';
        $data->_item_category = $request->_item_category ?? '';
        $data->_model = $request->_model ?? '';

        $data->_generic_name = $request->_generic_name ?? '';
        $data->_strength = $request->_strength ?? '';
        $data->_oringin = $request->_oringin ?? '';
        $data->_description = $request->_description ?? '';

        $data->_discount = $request->_discount ?? 0;
        $data->_description = $request->_description ?? '';
        $data->_vat = $request->_vat ?? 0;
        $data->_pur_rate = $request->_pur_rate ?? 0;
        $data->_sale_rate = $request->_sale_rate ?? 0;
        $data->_trade_price = $request->_trade_price ?? 0;
        $data->_mrp_price = $request->_mrp_price ?? 0;
        $data->_manufacture_company = $request->_manufacture_company;
        $data->_status = $request->_status ?? 0;
        $data->_unique_barcode = $request->_unique_barcode ?? 0;
        $data->_warranty = $request->_warranty ?? 0;
        $data->_reorder = $request->_reorder ?? 0;
        $data->_order_qty = $request->_order_qty ?? 0;
        $data->_kitchen_item = $request->_kitchen_item ?? 0;
        $data->_opening_qty = $_sum_opening_qty ?? 0;
        $data->_balance = $_sum_opening_qty ?? 0;
        $data->_created_by = $users->id."-".$users->name;
        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }
        $data->save();

        $_item_id = $data->id;

        $UnitConversion = UnitConversion::where('_item_id',$_item_id)
                                            ->where('_base_unit_id',$request->_unit_id)
                                            ->where('_conversion_unit',$request->_unit_id)
                                            ->first();
            if(!$UnitConversion){
                $UnitConversion  =new UnitConversion();
            }
            
            $UnitConversion->_item_id = $_item_id;
            $UnitConversion->_base_unit_id =$request->_unit_id ;
            $UnitConversion->_conversion_qty = 1;
            $UnitConversion->_conversion_unit = $request->_unit_id;
            $UnitConversion->_status = 1;
            $UnitConversion->_conversion_unit_name = _find_unit($request->_unit_id);
            $UnitConversion->save();


           //  `_item_id`, `_base_unit_id`, `_conversion_qty`, `_conversion_unit`, `_status`, `_conversion_unit_name`,

            
        $item_info = Inventory::find($_item_id);

        //Opening Inventory add section
        $organization_ids = $request->organization_id ?? [];
        $_branch_ids = $request->_branch_id ?? [];
        $_cost_center_ids = $request->_cost_center_id ?? [];
        $_store_ids = $request->_store_id ?? [];
        $_opening_qtys = $request->_opening_qty ?? [];
        $_opening_rates = $request->_opening_rate ?? [];
        $_openig_sales_rates = $request->_openig_sales_rate ?? [];
        $_openig_amounts = $request->_openig_amount ?? [];
        $_total_opening_qty = $request->_total_opening_qty ?? 0;
        $_total_opening_amount = $request->_total_opening_amount ?? 0;

        if(sizeof($_opening_qtys) > 0){
            for ($i=0; $i <sizeof($_opening_qtys) ; $i++) { 
               $_opening_qty= $_opening_qtys[$i] ?? 0;
               $_opening_rate= $_opening_rates[$i] ?? 0;
               $_opening_sales_rate= $_openig_sales_rates[$i] ?? 0;
               $_opening_value= $_openig_amounts[$i] ?? 0;
               $__sub_total= $_openig_amounts[$i] ?? 0;
               $__discount_input=  0;
               $__total_discount=  0;
               $_total_vat=  0;
               $__total=  $__sub_total;

               $_item_organization_id = $organization_ids[$i] ?? 1;
                $_item_branch_id =      $_branch_ids[$i] ?? 1;
                $_item_cost_center_id = $_cost_center_ids[$i] ?? 1;
                $_item_store_id = $_store_ids[$i] ?? 1;

                //Fetch default Setup information
               $PurchaseFormSettings = PurchaseFormSettings::first();
                $_default_inventory = $PurchaseFormSettings->_default_inventory;
                $_default_purchase = $PurchaseFormSettings->_default_purchase;
                $general_settings =GeneralSettings::first();
                $_opening_ledger = $general_settings->_opening_ledger ?? 49;
if($_opening_qty > 0){
    $_p_balance = _l_balance_update($_opening_ledger);
            $Purchase = new Purchase();
            $Purchase->_date = change_date_format(date('Y-m-d'));
            $Purchase->_time = date('H:i:s');
            $Purchase->_order_ref_id = '';
            $Purchase->_referance = 'Opening Inventory';
            $Purchase->_ledger_id = $_opening_ledger;
            $Purchase->_created_by = $users->id."-".$users->name;
            $Purchase->_user_id = $users->id;
            $Purchase->_user_name = $users->name;
            $Purchase->_note = 'Opening Inventory';;
            $Purchase->_sub_total = $__sub_total ?? 0;
            $Purchase->_discount_input = $__discount_input ?? 0;
            $Purchase->_total_discount = $__total_discount ?? 0;
            $Purchase->_total_vat = $_total_vat ?? 0;
            $Purchase->_total =  $__total ?? 0;
            $Purchase->organization_id = $_item_organization_id;
            $Purchase->_branch_id = $_item_branch_id;
            $Purchase->_cost_center_id = $_item_cost_center_id;
            $Purchase->_store_id = $_item_store_id;
            $Purchase->_address = 'N/A';
            $Purchase->_phone = 'N/A';
            $Purchase->_status = 1;
            $Purchase->_lock = $request->_lock ?? 0;
            $Purchase->save();
            $purchase_id = $Purchase->id;

            $PurchaseDetail = new PurchaseDetail();
                $PurchaseDetail->_item_id = $_item_id;
                $PurchaseDetail->_qty = $_opening_qty;

                $PurchaseDetail->_transection_unit = 1;
                $PurchaseDetail->_unit_conversion = 1;
                $PurchaseDetail->_base_unit = $_unit_id;

                $PurchaseDetail->_barcode = '';
                $PurchaseDetail->_model = $item_info->_model ?? '';
                $PurchaseDetail->_rate = $_opening_rate;
                $PurchaseDetail->_short_note = '';
                $PurchaseDetail->_sales_rate = $_opening_sales_rate ?? 0;
                $PurchaseDetail->_discount = 0;
                $PurchaseDetail->_discount_amount = 0;
                $PurchaseDetail->_vat =0 ;
                $PurchaseDetail->_vat_amount = 0;
                $PurchaseDetail->_value = $__total ?? 0;
                $PurchaseDetail->organization_id = $_item_organization_id ?? 1;
                $PurchaseDetail->_branch_id = $_item_branch_id ?? 1;
                $PurchaseDetail->_cost_center_id = $_item_cost_center_id ?? 1;
                $PurchaseDetail->_store_id = $_item_store_id ?? 1;
                $PurchaseDetail->_store_salves_id = '';
                $PurchaseDetail->_no = $purchase_id;
                $PurchaseDetail->_status = 1;
                $PurchaseDetail->_created_by = $users->id."-".$users->name;
                $PurchaseDetail->save();
                $_purchase_detail_id = $PurchaseDetail->id;

 $ProductPriceList = new ProductPriceList();
                $ProductPriceList->_item_id = $item_info->id;
                $ProductPriceList->_item = $item_info->_item ?? '';
                $ProductPriceList->_barcode = $item_info->_barcode ?? '';
                $ProductPriceList->_manufacture_date =null;
                $ProductPriceList->_expire_date = null;
                $ProductPriceList->_qty = $_opening_qty ?? 0;
                $ProductPriceList->_pur_rate = $_opening_rate ?? 0 ;
                $ProductPriceList->_sales_rate =$_opening_sales_rate ?? 0;
                //Unit Conversion section
                $ProductPriceList->_transection_unit = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unit_conversion = 1;
                $ProductPriceList->_base_unit = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unit_id = $item_info->_unit_id ?? 1;
                $ProductPriceList->_unique_barcode = $item_info->_unique_barcode ?? 0;
                $ProductPriceList->_warranty = $item_info->_warranty ?? 0;
                $ProductPriceList->_sales_discount = $item_info->_discount ?? 0;
                $ProductPriceList->_p_discount_input =  0;
                $ProductPriceList->_p_discount_amount =  0;
                $ProductPriceList->_p_vat =  0;
                $ProductPriceList->_p_vat_amount =  0;
                $ProductPriceList->_sales_vat = $item_info->_vat ?? 0;;
                $ProductPriceList->_value =$__total ?? 0;
                $ProductPriceList->_purchase_detail_id =$_purchase_detail_id;
                $ProductPriceList->_master_id = $purchase_id;
                $ProductPriceList->organization_id = $_item_organization_id?? 1;
                $ProductPriceList->_branch_id = $_item_branch_id ?? 1;
                $ProductPriceList->_cost_center_id = $_item_cost_center_id ?? 1;
                $ProductPriceList->_store_salves_id = '';
                $ProductPriceList->_store_id = $_item_store_id ?? 1;
                $ProductPriceList->_status =1;
                $ProductPriceList->_created_by = $users->id."-".$users->name;
                $ProductPriceList->save();
                $product_price_id =  $ProductPriceList->id;
                

                $ItemInventory = new ItemInventory();
                $ItemInventory->_item_id =  $item_info->id ?? '';
                $ItemInventory->_item_name =  $item_info->_item ?? '';
                $ItemInventory->_unit_id =  $item_info->_unit_id ?? '';
                $ItemInventory->_category_id = $request->_category_id;
                $ItemInventory->_date = change_date_format(date('Y-m-d'));
                $ItemInventory->_time = date('H:i:s');
                $ItemInventory->_transection = "Purchase";
                $ItemInventory->_transection_ref = $purchase_id;
                $ItemInventory->_transection_detail_ref_id = $_purchase_detail_id;

                $ItemInventory->_qty = $_opening_qty;
                $ItemInventory->_rate = $_opening_rate;
                $ItemInventory->_cost_rate =  $_opening_rate;
                 //Unit Conversion section
                $ItemInventory->_transection_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_conversion =  1;
                $ItemInventory->_base_unit = $item_info->_unit_id ?? 1;
                $ItemInventory->_unit_id = $item_info->_unit_id ?? 1;

                $ItemInventory->_cost_value = $__total;
                $ItemInventory->_value = $__total ?? 0;
                $ItemInventory->organization_id = $_item_organization_id ?? 1;
                $ItemInventory->_branch_id = $_item_branch_id ?? 1;
                $ItemInventory->_store_id = $_item_store_id ?? 1;
                $ItemInventory->_cost_center_id = $_item_cost_center_id ?? 1;
                $ItemInventory->_store_salves_id =  '';
                $ItemInventory->_status = 1;
                $ItemInventory->_created_by = $users->id."-".$users->name;
                $ItemInventory->save(); 


        $_ref_master_id=$purchase_id;
        $_ref_detail_id=$purchase_id;
        $_short_narration='N/A';
        $_narration = 'Opening Inventory';
        $_reference= 'Opening Inventory';
        $_transaction= 'Purchase';
        $_date = change_date_format(date('Y-m-d'));
        $_table_name = 'purchases';
        $organization_id = $_item_organization_id;
        $_branch_id = $_item_branch_id;
        $_cost_center =   $_item_cost_center_id;
        $_name =$users->name;

        $__sub_total = $__total ?? 0;
        
        if($__sub_total > 0){

            //Default Purchase
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_opening_ledger),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,$__sub_total,0,$_branch_id,$_cost_center,$_name,1,$organization_id);
            //Default Supplier
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_opening_ledger,0,$__sub_total,$_branch_id,$_cost_center,$_name,2,$_item_organization_id);

            //Default Inventory
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_purchase),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_inventory,$__sub_total,0,$_branch_id,$_cost_center,$_name,3,$_item_organization_id);
            //Default Purchase 
            account_data_save($_ref_master_id,$_ref_detail_id,_find_ledger($_default_inventory),$_narration,$_reference,$_transaction,$_date,$_table_name,$_default_purchase,0,$__sub_total,$_branch_id,$_cost_center,$_name,4,$_item_organization_id);
        }

        $_l_balance = _l_balance_update($_opening_ledger);
            $__table="purchases";
            $_pfix = make_order_number($__table,$_item_organization_id,$_item_branch_id);


             \DB::table('purchases')
             ->where('id',$purchase_id)
             ->update(['_p_balance'=>$_p_balance,'_l_balance'=>$_l_balance,'_order_number'=>$_pfix]);
}
            

            }
        }


        return redirect()->route('item-information.index')->with('success','Information Save Successfully');

}
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxItemSave(Request $request)
    {

        //return dump($request->all());

        

        

        

         DB::beginTransaction();
        try {

        $users = \Auth::user();

            $_item_item = trim($request->_item_item ?? '');
        $old_item_check = Inventory::where('_item',$_item_item)->first();
        if($old_item_check){
            $id = 0;
            return $id;
        }

         $item_codes =  item_code_generate($request->_category_id);
         $_serial =     $item_codes["_serial"];
         $full_product_code = $item_codes["full_product_code"];
         $_opening_qty = $request->_item_opening_qty ?? 0;
         $_sale_rate = $request->_item_sale_rate ?? 0;

         

        $data                   = new Inventory();
        $data->_item            = trim($request->_item_item);
        $data->_code            = $request->_item_code ?? $full_product_code;
        $data->_serial          = $_serial;
        $data->_unit_id         = $request->_item_unit_id;
        $data->_pack_size_id    = $request->_item_pack_size_id;
        $data->_brand_id        = $request->_item_brand_id;
        $data->_barcode         = $request->_item_barcode ?? $full_product_code;
        $data->_hs_code         = $request->_itemhs_code ?? '';
        $data->_hs_code_2       = $request->_itemhs_code_2 ?? '';
        $data->_item_category   = $request->_item_category ?? '';
        $data->_curum           = $request->_item_curum ?? '';
        $data->_length          = $request->_item_length ?? '';




        $data->_category_id     = $request->_category_id;
        $data->_discount        = $request->_item_discount ?? 0;
        $data->_balance         = $_opening_qty ?? 0;
        $data->_vat             = $request->_item_vat ?? 0;
        $data->_pur_rate        = $request->_item_pur_rate ?? 0;
        $data->_sale_rate       = $request->_item_sale_rate ?? 0;
        $data->_manufacture_company = $request->_item_manufacture_company;
        $data->_status          = $request->_item_status ?? 0;
        $data->_unique_barcode  = $request->_item_unique_barcode ?? 0;
        $data->_kitchen_item    = $request->_item_kitchen_item ?? 0;
        $data->_created_by      = \Auth::user()->id."-".\Auth::user()->name;
        $data->save();
        $id = $data->id;

        $_item_id = $data->id;
        $_unit_id = $data->_unit_id;
        $_conversion_qty = 1;
        $_conversion_unit= $data->_unit_id;
        $_item_name = $data->_item;

        $unit_status= 1;
        $action= 0;
        unitConversation_save($_item_id,$_unit_id,$_conversion_qty,$_conversion_unit,$unit_status,$action);




         DB::commit();
            return $id;
       } catch (\Exception $e) {
           DB::rollback();
           $id=0;
           return $id;
        }

                                        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



        $page_name = $this->page_name;
         $data= Inventory::with(['_category','_units','unit_conversion','_brands','_pack_size','_warranty_name'])->find($id);
        $categories = ItemCategory::with(['_parents'])->orderBy('_name','asc')->get();
         $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
       return view('backend.item-information.show',compact('page_name','categories','data','_warranties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
         $page_name = $this->page_name;
         $data= Inventory::find($id);
         $categories = ItemCategory::with(['_parents','_childs'])->where('_parent_id',0)->orderBy('_name','asc')->get();
         $units = Units::orderBy('_name','asc')->get();
        $_warranties = Warranty::select('id','_name')->orderBy('_name','asc')->get();
        $pack_sizes=ItemPackSize::where('_status',1)->orderBy('id','ASC')->get();
        $item_brands=ItemBrand::where('_status',1)->orderBy('id','ASC')->get();
       return view('backend.item-information.edit',compact('page_name','categories','data','units','_warranties','pack_sizes','item_brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

       // return dump($request->all());
       $this->validate($request, [
            '_category_id' => 'required',
            '_item' => 'required',
            '_unit_id' => 'required',
            'id' => 'required',
            '_status' => 'required'
        ]);

        
            $_category_id = $request->_category_id;
            $_item = $request->_item;
            $_unit_id = $request->_unit_id;
            $_warranty = $request->_warranty;
            $_manufacture_company = $request->_manufacture_company;
            $_code = $request->_code;
            $_barcode = $request->_barcode;
            $_discount = $request->_discount;
            $_vat = $request->_vat;
            $_branch_id = $request->_branch_id;
            $_cost_center_id = $request->_cost_center_id;
            $_store_id = $request->_store_id;
           // $_sum_opening_qty = array_sum($request->_opening_qty ?? []);
            $_pur_rate = $request->_pur_rate;
            $_sale_rate = $request->_sale_rate;
            $_reorder = $request->_reorder ?? 0;
            $_order_qty = $request->_order_qty ?? 0;
            $_kitchen_item = $request->_kitchen_item ?? 0;
            $_unique_barcode = $request->_unique_barcode ?? 0;
            $_status = $request->_status ?? 0;
            $_serial = $request->_serial ?? 1;

        $__item_id = $request->id;
        $__unit_id = $request->_unit_id;

        UnitConversion::where('_item_id',$__item_id)
                        ->where('_base_unit_id',$__unit_id)
                        ->where('_conversion_unit',$__unit_id)
                        ->update(['_status'=>0]);

        $users = \Auth::user();


     $data = Inventory::where('id',$request->id)
                        ->first();
    if(empty($data)){
        $data = new Inventory();
    }


        
        $data->_item = $request->_item ?? '';
        $data->_unit_id = $request->_unit_id;
        $data->_brand_id = $request->_brand_id ?? 1;
        $data->_pack_size_id = $request->_pack_size_id ?? 1;
        $data->_code = $request->_code ?? '';
        $data->_serial = $_serial;
        $data->_barcode = $request->_barcode ?? '';
        $data->_model = $request->_model ?? '';
        $data->_hs_code_2 = $request->_hs_code_2 ?? '';
        $data->_hs_code = $request->_hs_code ?? '';
        $data->_category_id = $request->_category_id;

        $data->_generic_name = $request->_generic_name ?? '';
        $data->_strength = $request->_strength ?? '';
        $data->_oringin = $request->_oringin ?? '';
        $data->_description = $request->_description ?? '';
        $data->_item_category = $request->_item_category ?? '';

        $data->_discount = $request->_discount ?? 0;
        $data->_description = $request->_description ?? '';
        $data->_vat = $request->_vat ?? 0;
        $data->_pur_rate = $request->_pur_rate ?? 0;
        $data->_sale_rate = $request->_sale_rate ?? 0;
        $data->_trade_price = $request->_trade_price ?? 0;
        $data->_mrp_price = $request->_mrp_price ?? 0;
        $data->_manufacture_company = $request->_manufacture_company;
        $data->_status = $request->_status ?? 0;
        $data->_unique_barcode = $request->_unique_barcode ?? 0;
        $data->_warranty = $request->_warranty ?? 0;
        $data->_reorder = $request->_reorder ?? 0;
        $data->_order_qty = $request->_order_qty ?? 0;
        $data->_kitchen_item = $request->_kitchen_item ?? 0;
        $data->_opening_qty = $_sum_opening_qty ?? 0;
        $data->_balance = $_sum_opening_qty ?? 0;
        $data->_created_by = $users->id."-".$users->name;
        if($request->hasFile('_image')){ 
                $_image = UserImageUpload($request->_image); 
                $data->_image = $_image;
        }
        $data->save();




        DB::table('item_inventories')->where('_item_id',$data->id)
                                    ->update(['_category_id'=>$data->_category_id]);

        
            $UnitConversion = UnitConversion::where('_item_id',$request->id)
                                            ->where('_base_unit_id',$request->_unit_id)
                                            ->where('_conversion_unit',$request->_unit_id)
                                            ->first();
            if(!$UnitConversion){
                $UnitConversion  =new UnitConversion();
            }
            
            $UnitConversion->_item_id = $request->id;
            $UnitConversion->_base_unit_id =$request->_unit_id ;
            $UnitConversion->_conversion_qty = 1;
            $UnitConversion->_conversion_unit = $request->_unit_id;
            $UnitConversion->_status = 1;
            $UnitConversion->save();

             if($request->has('_update_all_item_name') && $request->_update_all_item_name==1){
                ProductPriceList::where('_item_id',$request->id)->update(['_item'=>$request->_item]);
                \DB::table("item_inventories")->where('_item_id',$request->id)->update(['_item_name'=>$request->_item]);
            }

        
        return redirect('item-information')->with('success','Information save successfully');
       
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
      public function destroy($id)
    {
        
      
        $numOfAccount = ItemInventory::where('_item_id',$id)->count();
        if($numOfAccount ==0){
            Inventory::find($id)->delete();
            return redirect('item-information')->with('success','Information deleted successfully');
        }else{
             return "You Can not delete this Information";
        }
        
    }
}
