<?php
use Carbon\Carbon;




// Assigned Organization IDS

function assign_org_ids(){
    return explode(",",\Auth::user()->organization_ids ?? '');
}

function assign_branch_ids(){
    return explode(",",\Auth::user()->branch_ids ?? '');
}

function assign_costcenter_ids(){
    return explode(",",\Auth::user()->cost_center_ids ?? '');
}

function assign_store_ids(){
    return explode(",",\Auth::user()->store_ids ?? '');
}

function assign_department_ids(){
    return explode(",",\Auth::user()->department_ids ?? '');
}

function assign_building_ids(){
    return explode(",",\Auth::user()->building_ids ?? '');
}

function assign_actual_location_ids(){
    return explode(",",\Auth::user()->actual_location_ids ?? '');
}



function takeFirstLetter($string){
    if(strlen($string) > 0){
        preg_match_all('/\b\w/', $string, $matches);
        return $firstLetters = implode('', $matches[0]);
    }else{
        return "";
    }
        
}

function inspection_checkOrNot($_inspections,$inspection_id){
    foreach($_inspections as $key=>$val){
        if($val->inspect_list_id ==$inspection_id){
            return "checked";
        }
    }
}

function inspection_checkOrNotWithVal($_inspections,$inspection_id){
    foreach($_inspections as $key=>$val){
        if($val->inspect_list_id ==$inspection_id){
            return $val->chek_list_chek ?? 0;
        }
    }
    return 0;
}
function inspection_remarks($_inspections,$inspection_id){
    foreach($_inspections as $key=>$val){
        if($val->inspect_list_id ==$inspection_id){
            return $val->remarks;
        }
    }
    return '';
}
function inspection_row_id($_inspections,$inspection_id){
    foreach($_inspections as $key=>$val){
        if($val->inspect_list_id ==$inspection_id){
            return $val->id;
        }
    }
    return 0;
}

function assign_status(){
    return [1=>"Stuff",2=>"A",2=>"Stock In Hand"];
}

function selct_assign_status($id){
    $val='';
    foreach(assign_status() as $key=>$val){
        if($id==$key){
            return $val;
        }
    }
    return $val;
}




if (!function_exists('_imageUploader')) {

  function _imageUploader($query) // Taking input image as parameter
    {
        $image_name = date('mdYHis') . uniqid();
        $ext = strtolower($query->getClientOriginalExtension()); // You can use also getClientOriginalName()
        
        $image_full_name = $image_name.'.'.$ext;
        $upload_path = 'images/';    //Creating Sub directory in Public folder to put image
        $image_url = $upload_path.$image_full_name;
        $success = $query->move($upload_path,$image_full_name);
 
        return $image_url; // Just return image
    }
}


function find_user_id($name){
    $data =  \App\Models\AssetManagement\AssetsUser::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_asset_location_id($name){
    $data =  \App\Models\AssetManagement\AssetsLocation::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_room_device_location($name){
    $data =  \App\Models\AssetManagement\AssetsDeviceLocation::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_branch_id($name){
    $data =  \App\Models\Basic\Branch::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_category_id($name){
    $data =  \App\Models\AssetManagement\AssetsCategory::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_brand_id($name){
    $data =  \App\Models\AssetManagement\AssetBrand::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_vendor_id($name){
    $data =  \App\Models\AssetManagement\AssetsVendor::where('name',$name)->first();
    return $data->id ?? 0;
}
function find_asset_condition_id($name){
    $data =  \App\Models\AssetManagement\AssetsCondition::where('name',$name)->first();
    return $data->id ?? 0;
}
function get_asset_code(){
    $data =  $org_count = \DB::table('asset_items')->count();
    return "AC-".($data+1);
}
function find_group_serial_no($category_id){
    $cate = \DB::table('assets_categories')->find($category_id);
    $cate_id = $cate->id ?? 0;
    if(strlen($cate_id)==1){
        $cate_id = "0".$cate_id;
    }
    $data =  $org_count = \DB::table('asset_items')->where('category_id',$category_id)->count();
    return $cate_id."-".($data+1);
}


//Create Organization wise Code
function assetUserCode($org_id){
    $org_count = \DB::table('assets_users')->where('organization_id',$org_id)->count();
    $new_id = ($org_count+1);
    if(strlen($new_id)==1){
        $new_id = "00000".$new_id;
    }
    if(strlen($new_id)==2){
        $new_id = "0000".$new_id;
    }
    if(strlen($new_id)==3){
        $new_id = "000".$new_id;
    }
    if(strlen($new_id)==4){
        $new_id = "00".$new_id;
    }
    if(strlen($new_id)==5){
        $new_id = "0".$new_id;
    }
$user_code = org_code($org_id)."-".$new_id;
    return $user_code;
}

function org_code($org_id){
    $data = \DB::table("organizations")->find($org_id);
    return $data->code ?? '';
}

 function buildTree(array $elements, $parentId = 0) {
    $branch = [];

    foreach ($elements as $element) {
        if ($element->parent_id == $parentId) {
            $children = buildTree($elements, $element->id);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}



function removeAllSpace($string=''){
  $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string);
}
    




if (!function_exists('_text_status')) {

  function _text_status() // Taking input image as parameter
    {
        return ["published","draft","pending"];
    }
}

if (!function_exists('_status_base_class')) {

  function _status_base_class($status) // Taking input image as parameter
    {
        if($status==0){
            return "badge-phoenix-danger";
        }else{
            return "badge-phoenix-success";
        }
    }
}





if (! function_exists('_translate_langs')) {
    function _translate_langs()
    {
        $languages = \DB::table('languages')->get();
        return $languages;            
    }
}



if (! function_exists('selected_featured')) {
    function selected_featured($value)
    {
        if($value==1){
            return "<span class='badge badge-phoenix fs--2 badge-phoenix-success'>Featured</span>";
        }else{
            return "";
        }
    }
}



if (! function_exists('_default_language')) {
    function  _default_language()
    {

        return Session::get("current_language") ?? \App\Models\Settings\Language::where('lang_is_default',1)->first()->lang_code;
        
    }
}

if (! function_exists('_key_wise_lang')) {
    function  _key_wise_lang($key)
    {
        $languages = _all_languages();
        if(array_key_exists($key, $languages)){
            return $languages[$key];
        }
    }
}



if (! function_exists('_all_languages')) {
    function  _all_languages()
    {

       return $languages = [
        'af'             => ['af', 'af', 'Afrikaans', 'ltr', 'za'],
        'ar'             => ['ar', 'ar', 'العربية', 'rtl', 'ar'],
        'ary'            => ['ar', 'ary', 'العربية المغربية', 'rtl', 'ma'],
        'az'             => ['az', 'az', 'Azərbaycan', 'ltr', 'az'],
        'azb'            => ['az', 'azb', 'گؤنئی آذربایجان', 'rtl', 'az'],
        'bel'            => ['be', 'bel', 'Беларуская мова', 'ltr', 'by'],
        'bg_BG'          => ['bg', 'bg_BG', 'български', 'ltr', 'bg'],
        'bn_BD'          => ['bn', 'bn_BD', 'বাংলা', 'ltr', 'bd'],
        'bo'             => ['bo', 'bo', 'བོད་སྐད', 'ltr', 'tibet'],
        'bs_BA'          => ['bs', 'bs_BA', 'Bosanski', 'ltr', 'ba'],
        'ca'             => ['ca', 'ca_ES', 'Catalan', 'ltr', 'es'],
        'ceb'            => ['ceb', 'ceb', 'Cebuano', 'ltr', 'ph'],
        'cs_CZ'          => ['cs', 'cs_CZ', 'Čeština', 'ltr', 'cz'],
        'cy'             => ['cy', 'cy', 'Cymraeg', 'ltr', 'gb-wls'],
        'da_DK'          => ['da', 'da_DK', 'Dansk', 'ltr', 'dk'],
        'de_CH'          => ['de', 'de_CH', 'Deutsch', 'ltr', 'ch'],
        'de_CH_informal' => ['de', 'de_CH_informal', 'Deutsch', 'ltr', 'ch'],
        'de_DE'          => ['de', 'de_DE', 'Deutsch', 'ltr', 'de'],
        'de_DE_formal'   => ['de', 'de_DE_formal', 'Deutsch', 'ltr', 'de'],
        'el'             => ['el', 'el', 'Ελληνικά', 'ltr', 'gr'],
        'en_AU'          => ['en', 'en_AU', 'English', 'ltr', 'au'],
        'en_CA'          => ['en', 'en_CA', 'English', 'ltr', 'ca'],
        'en_GB'          => ['en', 'en_GB', 'English', 'ltr', 'gb'],
        'en_NZ'          => ['en', 'en_NZ', 'English', 'ltr', 'nz'],
        'en_ZA'          => ['en', 'en_ZA', 'English', 'ltr', 'za'],
        'en_US'          => ['en', 'en_US', 'English', 'ltr', 'us'],
        'es_AR'          => ['es', 'es_AR', 'Español', 'ltr', 'ar'],
        'es_CL'          => ['es', 'es_CL', 'Español', 'ltr', 'cl'],
        'es_CO'          => ['es', 'es_CO', 'Español', 'ltr', 'co'],
        'es_ES'          => ['es', 'es_ES', 'Español', 'ltr', 'es'],
        'es_GT'          => ['es', 'es_GT', 'Español', 'ltr', 'gt'],
        'es_MX'          => ['es', 'es_MX', 'Español', 'ltr', 'mx'],
        'es_PE'          => ['es', 'es_PE', 'Español', 'ltr', 'pe'],
        'es_VE'          => ['es', 'es_VE', 'Español', 'ltr', 've'],
        'et'             => ['et', 'et', 'Eesti', 'ltr', 'ee'],
        'eu'             => ['eu', 'eu', 'Euskara', 'ltr', 'fr'],
        'fa_AF'          => ['fa', 'fa_AF', 'فارسی', 'rtl', 'af'],
        'fa_IR'          => ['fa', 'fa_IR', 'فارسی', 'rtl', 'ir'],
        'fi'             => ['fi', 'fi', 'Suomi', 'ltr', 'fi'],
        'fo'             => ['fo', 'fo', 'Føroyskt', 'ltr', 'fo'],
        'fr_BE'          => ['fr', 'fr_BE', 'Français', 'ltr', 'be'],
        'fr_FR'          => ['fr', 'fr_FR', 'Français', 'ltr', 'fr'],
        'fy'             => ['fy', 'fy', 'Frysk', 'ltr', 'nl'],
        'gd'             => ['gd', 'gd', 'Gàidhlig', 'ltr', 'gb-sct'],
        'gl_ES'          => ['gl', 'gl_ES', 'Galego', 'ltr', 'gl'],
        'gu'             => ['gu', 'gu', 'ગુજરાતી', 'ltr', 'in'],
        'haz'            => ['haz', 'haz', 'هزاره گی', 'rtl', 'af'],
        'he_IL'          => ['he', 'he_IL', 'עברית', 'rtl', 'il'],
        'hi_IN'          => ['hi', 'hi_IN', 'हिन्दी', 'ltr', 'in'],
        'hr'             => ['hr', 'hr', 'Hrvatski', 'ltr', 'hr'],
        'hu_HU'          => ['hu', 'hu_HU', 'Magyar', 'ltr', 'hu'],
        'hy'             => ['hy', 'hy', 'Հայերեն', 'ltr', 'am'],
        'id_ID'          => ['id', 'id_ID', 'Bahasa Indonesia', 'ltr', 'id'],
        'is_IS'          => ['is', 'is_IS', 'Íslenska', 'ltr', 'is'],
        'it_IT'          => ['it', 'it_IT', 'Italiano', 'ltr', 'it'],
        'ja'             => ['ja', 'ja', '日本語', 'ltr', 'jp'],
        'jv_ID'          => ['jv', 'jv_ID', 'Basa Jawa', 'ltr', 'id'],
        'ka_GE'          => ['ka', 'ka_GE', 'ქართული', 'ltr', 'ge'],
        'kk'             => ['kk', 'kk', 'Қазақ тілі', 'ltr', 'kz'],
        'kh'             => ['kh', 'kh', 'Cambodia', 'ltr', 'kh'],
        'ko_KR'          => ['ko', 'ko_KR', '한국어', 'ltr', 'kr'],
        'ckb'            => ['ku', 'ckb', 'کوردی', 'rtl', 'kurdistan'],
        'lo'             => ['lo', 'lo', 'ພາສາລາວ', 'ltr', 'la'],
        'lt_LT'          => ['lt', 'lt_LT', 'Lietuviškai', 'ltr', 'lt'],
        'lv'             => ['lv', 'lv', 'Latviešu valoda', 'ltr', 'lv'],
        'mk_MK'          => ['mk', 'mk_MK', 'македонски јазик', 'ltr', 'mk'],
        'mn'             => ['mn', 'mn', 'Монгол хэл', 'ltr', 'mn'],
        'mr'             => ['mr', 'mr', 'मराठी', 'ltr', 'in'],
        'ms_MY'          => ['ms', 'ms_MY', 'Bahasa Melayu', 'ltr', 'my'],
        'my_MM'          => ['my', 'my_MM', 'ဗမာစာ', 'ltr', 'mm'],
        'mv'             => ['mv', 'mv', 'Maldives', 'rtl', 'mv'],
        'nb_NO'          => ['nb', 'nb_NO', 'Norsk Bokmål', 'ltr', 'no'],
        'ne_NP'          => ['ne', 'ne_NP', 'नेपाली', 'ltr', 'np'],
        'nl_NL'          => ['nl', 'nl_NL', 'Nederlands', 'ltr', 'nl'],
        'nl_NL_formal'   => ['nl', 'nl_NL_formal', 'Nederlands', 'ltr', 'nl'],
        'nn_NO'          => ['nn', 'nn_NO', 'Norsk Nynorsk', 'ltr', 'no'],
        'pl_PL'          => ['pl', 'pl_PL', 'Polski', 'ltr', 'pl'],
        'ps'             => ['ps', 'ps', 'پښتو', 'rtl', 'af'],
        'pt_BR'          => ['pt', 'pt_BR', 'Português', 'ltr', 'br'],
        'pt_PT'          => ['pt', 'pt_PT', 'Português', 'ltr', 'pt'],
        'ro_RO'          => ['ro', 'ro_RO', 'Română', 'ltr', 'ro'],
        'ru_RU'          => ['ru', 'ru_RU', 'Русский', 'ltr', 'ru'],
        'si_LK'          => ['si', 'si_LK', 'සිංහල', 'ltr', 'lk'],
        'sk_SK'          => ['sk', 'sk_SK', 'Slovenčina', 'ltr', 'sk'],
        'sl_SI'          => ['sl', 'sl_SI', 'Slovenščina', 'ltr', 'si'],
        'so_SO'          => ['so', 'so_SO', 'Af-Soomaali', 'ltr', 'so'],
        'sq'             => ['sq', 'sq', 'Shqip', 'ltr', 'al'],
        'sr_RS'          => ['sr', 'sr_RS', 'Српски језик', 'ltr', 'rs'],
        'su_ID'          => ['su', 'su_ID', 'Basa Sunda', 'ltr', 'id'],
        'sv_SE'          => ['sv', 'sv_SE', 'Svenska', 'ltr', 'se'],
        'szl'            => ['szl', 'szl', 'Ślōnskŏ gŏdka', 'ltr', 'pl'],
        'ta_LK'          => ['ta', 'ta_LK', 'தமிழ்', 'ltr', 'lk'],
        'th'             => ['th', 'th', 'ไทย', 'ltr', 'th'],
        'tl'             => ['tl', 'tl', 'Tagalog', 'ltr', 'ph'],
        'tr_TR'          => ['tr', 'tr_TR', 'Türkçe', 'ltr', 'tr'],
        'ug_CN'          => ['ug', 'ug_CN', 'Uyƣurqə', 'ltr', 'cn'],
        'uk'             => ['uk', 'uk', 'Українська', 'ltr', 'ua'],
        'ur'             => ['ur', 'ur', 'اردو', 'rtl', 'pk'],
        'uz_UZ'          => ['uz', 'uz_UZ', 'Oʻzbek', 'ltr', 'uz'],
        'vi'             => ['vi', 'vi', 'Tiếng Việt', 'ltr', 'vn'],
        'zh_CN'          => ['zh', 'zh_CN', '中文 (中国)', 'ltr', 'cn'],
        'zh_HK'          => ['zh', 'zh_HK', '中文 (香港)', 'ltr', 'hk'],
        'zh_TW'          => ['zh', 'zh_TW', '中文 (台灣)', 'ltr', 'tw'],
    ];
        
    }
}















