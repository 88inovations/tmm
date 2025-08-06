<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TM Madrasah Admission Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 16px;
    }
    .dotted-input {
      border: none;
      border-bottom: 2px dotted #000;
      background: none;
      outline: none;
      margin-left: 10px;
      margin-right: 10px;
      width:100%;
    }
    .form-inline-group {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      margin-bottom: 10px;
    }
    .form-inline-group label {
      margin-right: 10px;
      white-space: nowrap;
    }
    .checkbox-group {
      display: flex;
      flex-wrap: wrap;
    }
    .checkbox-group label {
      margin-right: 15px;
    }
    .section-title {
      font-weight: bold;
      color: #3f51b5;
      margin: 20px 0 10px;
      text-decoration: underline;
    }
    .signature-line {
      display: flex;
      justify-content: space-between;
      margin-top: 40px;
      padding: 0 10%;
    }
    .signature-line div {
      border-top: 1px solid #000;
      width: 20%;
      text-align: center;
    }
 
    .border_bottom_dotted{
        border-bottom: 1px dotted #000;
    }
  </style>
</head>

@php
$_main_subjects  = $data->_main_subjects ?? old('_main_subjects');

$_main_subjects_array = explode(",", $_main_subjects);
$_optional_subjects  = $data->_optional_subjects ?? old('_optional_subjects');
$_optional_subjects_array = explode(",", $_optional_subjects);
@endphp
<body>
  <div class="container  position-relative">
    <div class="row">
      <div class="col-3">
        <div class="logo">
              <img src="{{ asset($settings->logo ?? '') }}" 
                     alt="Logo"
                     style="height: 120px; width: auto; display: block; margin-bottom: 10px;" />
        </div>
      </div>
      <div class="col-6">
        <div class="text-center">
          <h4 class="font-weight-bold text-primary">{{$settings->name ?? '' }}</h4>
          <p>
           {{$settings->_address ?? '' }}</br>
            {{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}
          </p>
          <h5 class="bg-primary border px-4 py-2 d-inline-block" style="border-radius: 20px;color: #FFFFFF;">Admission Form</h5>
        </div>
      </div>
      <div class="col-3">
        <div class="student-photo">
            <img id="output_1" class="banner_image_create" 
                 src="{{ asset($data->_student_image ?? '') }}"  
                 style="height:150px; width:auto; border:1px solid #000; padding:5px;" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-2">
        <div class="form-inline-group">
          <label>Admit To Class:</label>
        </div>
      </div>
      <div class="col-10 ">
        <div class="row">
         
              
            
           @forelse($edu_class as $class)
                  <div class="col-2">
            <div class="checkbox-group">
                    <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name="_optional_classs[]" id="_optional_classs__{{$class->id}}" value="{{$class->id}}" 
                           @if($data->_admission_class_id==$class->id) checked @endif
                          style="width: 16px;height: 16px;">
                          <label class="form-check-label" for="_optional_classs__{{$class->id}}" style="font-size: 14px;">{{$class->_name ?? ''}}</label>
                        </div>
</div>
          </div>
                 @empty
                 @endforelse

        </div>
      </div>
    </div>
    
    <div class="section-title">Student Information</div>
    <div class="row">
        <div class="col-2">
          <div class="form-inline-group">
            <label>Student's Name</label>
          </div>
        </div>
        <div class="col-4">
          <input type="text" class="dotted-input" value="{!! $data["_name_in_english"] ?? '' !!}">
        </div>
        <div class="col-2">
          <div class="form-inline-group">
            <label>{{__('label._name_in_bangla')}}</label>
          </div>
        </div>
        <div class="col-4">
          <input type="text" class="dotted-input" value="{!! $data["_name_in_bangla"] ?? '' !!}">
        </div>
</div>
<div class="row">
        <div class="col-2">
          <div class="form-inline-group">
            <label>Date of Birth</label>
          </div>
        </div>
        
        <div class="col-3">
          <input type="text" class="dotted-input" value="{!! _view_date_formate($data["_date_of_birth"] ?? '') !!}">
        </div>

        <div class="col-1">
          <div class="form-inline-group">
            <label>Gender</label>
          </div>
        </div>
        
        <div class="col-3">
          <input type="text" class="dotted-input" value="{!! $data['_gender'] ?? '' !!}">
        </div>

        <div class="col-1">
          <div class="form-inline-group">
            <label>Religion</label>
          </div>
        </div>
        
        <div class="col-2">
          <input type="text" class="dotted-input" value="{!! $data['_religion'] ?? '' !!}">
        </div>

        <div class="col-2">
          <div class="form-inline-group">
            <label>Birth Certificate No</label>
          </div>
        </div>
        
        <div class="col-3">
          <input type="text" class="dotted-input" value="{!! $data['_barth_id'] ?? '' !!}">
        </div>

        <div class="col-1">
          <div class="form-inline-group">
            <label>Nationality</label>
          </div>
        </div>
        
        <div class="col-3">
           <input type="text" class="dotted-input" value="{!! $data['_nationality'] ?? '' !!}">
        </div>
         

        <div class="col-1">
          <div class="form-inline-group">
            <label>Blood Group</label>
          </div>
        </div>
        
        <div class="col-2">
         <input type="text" class="dotted-input" value="{!! $data['_bloodgroup'] ?? '' !!}">
        </div>

        <div class="col-1">
          <div class="form-inline-group">
            <label>Mobile</label>
          </div>
        </div>
        
        <div class="col-3">
         <input type="text" class="dotted-input" value="{!! $data['_mobile'] ?? '' !!}">
        </div>

        <div class="col-1">
          <div class="form-inline-group">
            <label>Mail</label>
          </div>
        </div>
        
        <div class="col-7">
         <input type="text" class="dotted-input" value="{!! $data['_email'] ?? '' !!}">
        </div>
    </div>


    <div class="section-title">Address</div>
    <div class="row">
     
      <div class="col-2">
        <div class="form-inline-group">
          <label>Present Address</label>
        </div>
      </div>
      
      <div class="col-4">
       <input type="text" class="dotted-input" value="{!! $data['_present_address'] ?? '' !!}">
      </div>
 
      <div class="col-1">
        <div class="form-inline-group">
          <label>Thana</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_cur_thana->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Post Code</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_cur_post_office ?? '' !!}">
      </div>

      <div class="col-2"></div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>District</label>
        </div>
      </div>
      
      <div class="col-3">
       <input type="text" class="dotted-input" value="{!! $data->_cur_district->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Division</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_cur_division->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Country</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_cur_country->countryname ?? '' !!}">
      </div>

      <div class="col-2">
        <div class="form-inline-group">
          <label>Permanent Address</label>
        </div>
      </div>
      <div class="col-4">
       <input type="text" class="dotted-input" value="{!! $data['_parmanent_address'] ?? '' !!}">
      </div>
 
      <div class="col-1">
        <div class="form-inline-group">
          <label>Thana</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_per_thana->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Post Code</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_per_post_office ?? '' !!}">
      </div>

      <div class="col-2"></div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>District</label>
        </div>
      </div>
      
      <div class="col-3">
       <input type="text" class="dotted-input" value="{!! $data->_per_district->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Division</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_per_division->name ?? '' !!}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Country</label>
        </div>
      </div>
      
      <div class="col-2">
       <input type="text" class="dotted-input" value="{!! $data->_per_country->countryname ?? '' !!}">
      </div>

    </div>


    <div class="section-title">Family Information</div>
    <div class="row">
      
      <div class="col-1">
        <div class="form-inline-group">
          <label>Father's Name</label>
        </div>
      </div>
      
      <div class="col-4">
        <input type="text" class="dotted-input" value="{{$data->_father_name_bangla ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Occupation</label>
        </div>
      </div>
      
      <div class="col-2">
        <input type="text" class="dotted-input" value="{{$data->_occupation ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Mobile</label>
        </div>
      </div>
      
      <div class="col-3">
       <input type="text" class="dotted-input" value="{{$data->_f_mobile_no ?? ''}}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Mother's Name</label>
        </div>
      </div>
      
      <div class="col-4">
        <input type="text" class="dotted-input" value="{{$data->_mother_name_of_bangla ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Occupation</label>
        </div>
      </div>
      
      <div class="col-2">
        <input type="text" class="dotted-input" value="{{$data->_mother_occupation ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Mobile</label>
        </div>
      </div>
      
      <div class="col-3">
        <input type="text" class="dotted-input" value="{{$data->_mother_mobile_no ?? ''}}">
      </div>

      <div class="col-2">
        <div class="form-inline-group">
          <label>Local Guardian's Name</label>
        </div>
      </div>
      
      <div class="col-3">
        <input type="text" class="dotted-input" value="{{$data->_local_guardian_name ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Occupation</label>
        </div>
      </div>
      
      <div class="col-2">
        <input type="text" class="dotted-input" value="{{$data->_local_guardian_occupation ?? ''}}">
      </div>
      <div class="col-1">
        <div class="form-inline-group">
          <label>Mobile</label>
        </div>
      </div>
      
      <div class="col-3">
        <input type="text" class="dotted-input" value="{{$data->_local_guardian_mobile ?? ''}}">
      </div>

    </div>

    <div class="section-title">Previous Institute Information (if any)</div>
    <div class="row">
      <div class="col-2">
        <div class="form-inline-group">
          <label>Institution's Name</label>
        </div>
      </div>
      
      <div class="col-4">
         <input type="text" class="dotted-input" value="{{$data->_previous_institute_name ?? ''}}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Class</label>
        </div>
      </div>
      
      <div class="col-2">
         <input type="text" class="dotted-input" value="{{$data->_pre_class ?? ''}}">
      </div>

      
      <div class="col-1">
        <div class="form-inline-group">
          <label>Roll</label>
        </div>
      </div>
      
      <div class="col-2">
         <input type="text" class="dotted-input" value="{{$data->_pre_roll_no ?? ''}}">
      </div>

      <div class="col-1">
        <div class="form-inline-group">
          <label>Result</label>
        </div>
      </div>
      
      <div class="col-2">
         <input type="text" class="dotted-input" value="{{$data->_pre_result ?? ''}}">
      </div>
    
        <div class="col-1">
        <div class="form-inline-group">
          <label>Note</label>
        </div>
      </div>
      
      <div class="col-2">
         <input type="text" class="dotted-input" value="{{$data->_details ?? ''}}">
      </div>
    </div>
    



    <div class="row">
      <div class="col-2">
        <div class="form-inline-group">
          <label>Subjects:</label>
        </div>
      </div>
      <div class="col-10 ">
        <div class="row">


           @forelse($subjects as $subject)
          <div class="col-2">
            <div class="checkbox-group">
              <label><input type="checkbox" @if(in_array($subject->id,$_main_subjects_array)) checked @endif > {{$subject->_name ?? ''}}</label>
            </div>
          </div>
    @empty
    @endforelse



        </div>
      </div>
    </div>
   

    <div class="row">
      <div class="col-2">
        <div class="form-inline-group">
          <label>Optional Subject:</label>
        </div>
      </div>
      <div class="col-10 ">
        <div class="row">

      @forelse($subjects as $subject)
          <div class="col-2">
            <div class="checkbox-group">
              <label><input type="checkbox" @if(in_array($subject->id,$_optional_subjects_array)) checked @endif > {{$subject->_name ?? ''}}</label>
            </div>
          </div>
    @empty
    @endforelse


                         

        </div>
      </div>
    </div>

    <div class="row pt-4">
      <div class="col-12 signature-line">
        <div>Student Signature</div>
        <div>Guardian Signature</div>
        <div>Examiner's Signature</div>
        <div>Principal Signature</div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
      window.print();
      
  </script>
</body>
</html>
