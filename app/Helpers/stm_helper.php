<?php
use Carbon\Carbon;



// function _getStudentName($student_id) {
//     return \App\Models\STM\StmStudent::find($student_id)?->_name_in_bangla ?? 'N/A';
// }

// function _getStudentRoll($student_id) {
//     return \App\Models\STM\StmStudent::find($student_id)?->_roll_no ?? 'N/A';
// }

// function _getDivisionName($id) {
//     return \App\Models\STM\StmDivision::find($id)?->_name ?? 'N/A';
// }

// function _getClassName($id) {
//     return \App\Models\STM\StmClass::find($id)?->_name ?? 'N/A';
// }


function _division_wise_districts($division_id){
	return \DB::table('districts')->where('division_id',$division_id)->orderBy('name','ASC')->get();
    
}


function _district_wise_upazillas($district_id){
	return \DB::table('upazilas')->where('district_id',$district_id)->orderBy('name','ASC')->get();
    
}

function _upazilla_wise_postcodes($district_id,$upazila){
	return \DB::table('postcodes')->where('district_id',$district_id)
				->where('upazila',$upazila)->orderBy('postOffice','ASC')->get();
    
}



function _fees_types(){
	return $bill_types = [
			'_tution_fee'=>__('label._tution_fee'),
			'_anual_fee'=>__('label._anual_fee'),
			'_exam_fee'=>__('label._exam_fee'),
			'_monthly_food_fee'=>__('label._monthly_food_fee'),
			'_residential_fee'=>__('label._residential_fee'),
			'_other_fee'=>__('label._other_fee'),
			'_other_2_fee'=>__('label._other_2_fee'),
			'_other_3_fee'=>__('label._other_3_fee')
			];
}


function _fee_lebel($key){
	$bill_types = _fees_types();
	if($key=='_admission_fee'){
		return __('label._admission_fee');
	}

	return $bill_types[$key] ?? '';
}























