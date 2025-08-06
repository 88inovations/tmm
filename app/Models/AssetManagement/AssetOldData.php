<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetOldData extends Model
{
    use HasFactory;
    protected $table="asset_old_data";
    //protected $table="asset_stff_old_data";
    //protected $table="student_old_data";

    protected $fillable=['asset_tag', 'serial_number', 'duplicate', 'computer_name', 'category', 'os', 'domain_intune', 'description', 'campus_location', 'room_device_location', 'supplier_vendor', 'condition', 'model_no', 'warranty', 'assigned_user', 'assigned_user_organization', 'assigned_user_branch', 'assigned_date', 'remarks', 'tab_name', 'created_at', 'updated_at'];
}


 