
@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
 
  @media print {
   .table th {
    vertical-align: top;
    color: #000;
    background-color: #fff; 
}
}
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('hrm-employee')}}" role="button"><i class="fa fa-arrow-left"></i></a>
 @can('hrm-employee-edit')
 <a  href="{{ route('hrm-employee.edit',$data->id) }}" 
    class="nav-link "  title="Edit"  >
    <i class="nav-icon fas fa-edit"></i>
     </a>
  @endcan
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
      @include('backend.message.message')
  </div>

<section class="invoice" id="printablediv">
    
    <div class="container-fluid">
     
    <!-- /.row -->
    <table class="table table-bordered">
      <tr>
         <tr> 
          <td colspan="6" class="text-center" style="border:none;"> {{ $settings->_top_title ?? '' }}<br>
            <b>{{$settings->name ?? '' }}</b><br/>
            <b>{{$settings->_address ?? '' }}<br>
              <b>{{$settings->_phone ?? '' }}</b><br><b>{{$settings->_email ?? '' }}</b><br><h3>{{$page_name}} </h3></td> 
            </tr>
      </tr>



      <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="2">{{__('label.personal_Details')}}</th>
              </tr>
            
            </thead>
            <tbody>
             <tr>
                
                    <td colspan="2" style="width: 23%;"><img id="output_1" class="banner_image_create" src="{{asset($data->_photo)}}"  style="max-height:100px;max-width: 100px; " /></td>
                  </tr>
             <tr>
                    <td style="width: 10%;">{{__('label._code')}}:</td>
                    <td style="width: 23%;">{{ $data->_code ?? ''  }}</td>
      </tr>
      <tr>
                    <td style="width: 10%;">{{__('label._name')}}:</td>
                    <td style="width: 23%;">{{ $data->_name ?? ''  }}</td>
                  </tr>
       
      <tr>
        <td style="width: 10%;">{{__('label._father')}}:</td>
        <td style="width: 23%;">{{ $data->_father ?? ''  }}</td>
            </tr>
      <tr>
        <td style="width: 10%;">{{__('label._mother')}}:</td>
        <td style="width: 23%;">{{ $data->_mother ?? ''  }}</td>
         </tr>
      <tr>
        <td style="width: 10%;">{{__('label._spouse')}}:</td>
        <td style="width: 23%;">{{ $data->_spouse ?? ''  }}</td>
      </tr>
      <tr>
           <td style="width: 10%;">{{__('label._mobile1')}}:</td>
        <td style="width: 23%;">{{ $data->_mobile1 ?? ''  }}</td>
      </tr>
      <tr>
     
        <td style="width: 10%;">{{__('label._mobile2')}}:</td>
        <td style="width: 23%;">{{ $data->_mobile2 ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label._spousesmobile')}}:</td>
        <td style="width: 23%;">{{ $data->_spousesmobile ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label._nid')}}:</td>
        <td style="width: 23%;">{{ $data->_nid ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label._gender')}}:</td>
        <td style="width: 23%;">{{ $data->_gender ?? ''  }}</td>
</tr>
      <tr>

        <td style="width: 10%;">{{__('label._bloodgroup')}}:</td>
        <td style="width: 23%;">{{ $data->_bloodgroup ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label._religion')}}:</td>
        <td style="width: 23%;">{{ $data->_religion ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._dob')}}:</td>
        <td style="width: 23%;">{{ $data->_dob ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label._education')}}:</td>
        <td style="width: 23%;">{{ $data->_education ?? ''  }}</td>
      </tr>
     


  
            </tbody>
          </table>
        </td>
      </tr>
    
      
      <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="4">Current Possitions</th>
              </tr>
            </thead>
            <tbody>
            <tr>
        <td style="width: 10%;">{{__('label.organization_id')}}:</td>
        <td style="width: 23%;">{{ $data->_organization->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label.Branch')}}:</td>
        <td style="width: 23%;">{{ $data->_branch->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._cost_center_id')}}:</td>
        <td style="width: 23%;">{{ $data->_cost_center->_name ?? ''  }}</td>
      </tr>
      <tr>
        <td style="width: 10%;">{{__('label.employee_category_id')}}:</td>
        <td style="width: 23%;">{{ $data->_employee_cat->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._department_id')}}:</td>
        <td style="width: 23%;">{{ $data->_emp_department->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._jobtitle_id')}}:</td>
        <td style="width: 23%;">{{ $data->_emp_designation->_name ?? ''  }}</td>
        </tr>
      <tr>
      
        <td style="width: 10%;">{{__('label._grade_id')}}:</td>
        <td style="width: 23%;">{{ $data->_emp_grade->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._location')}}:</td>
        <td style="width: 23%;">{{ $data->_emp_location->_name ?? ''  }}</td>
        </tr>
      <tr>
        <td style="width: 10%;">{{__('label._status')}}:</td>
        <td style="width: 23%;">{{ selected_status($data->_status) }}</td>
      </tr>
            </tbody>
          </table>
        </td>
      </tr>
        <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="4">Bank Information</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <td style="width: 10%;">{{__('label._bank')}}:</td>
              <td style="width: 23%;">{{ $data->_bank ?? ''  }}</td>
              <td style="width: 10%;">{{__('label._bankac')}}:</td>
              <td style="width: 23%;">{{ $data->_bankac ?? ''  }}</td>
            </tr>
            </tbody>
          </table>
        </td>
      </tr>
      
      @php

$hrm_experiences      = $data->hrm_experiences  ?? [];   //1
$_hrm_education       = $data->_hrm_education  ?? [];   //2
$hrm_emergencies      = $data->hrm_emergencies  ?? [];   //3
$hrm_empaddresses     = $data->hrm_empaddresses  ?? [];
$_hrm_languages       = $data->_hrm_languages  ?? [];
$_hrm_rewards         = $data->_hrm_rewards  ?? [];
$_hrm_trainings       = $data->_hrm_trainings  ?? [];
$_hrm_transfers       = $data->_hrm_transfers  ?? [];
$hrm_nominees         = $data->hrm_nominees  ?? '';
$hrm_jobcontracts     = $data->hrm_jobcontracts  ?? '';
      @endphp
@if(sizeof($hrm_experiences) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="8">{{__('label.hrm_experiences')}}</th>
              </tr>
             <tr>
                <th>#</th>
                <th>{{__('label._company')}}</th>
                <th>{{__('label._jobtitle_id')}}</th>
                <th>{{__('label._wfrom')}}</th>
                <th>{{__('label._wto')}}</th>
                <th>{{__('label._note')}}</th>
            </tr>
            </thead>
            <tbody>
              @forelse($hrm_experiences as $hrm_ex=>$val)
          <tr>
            <td>{{ ($hrm_ex+1) }}</td>
           <td>{{$val->_company ?? '' }}</td>
            <td>{{ id_to_cloumn($val->_jobtitle_id,'_name','designations') }}</td>
            <td>{{$val->_wfrom ?? '' }}</td>
            <td>{{$val->_wto ?? '' }}</td>
            <td>{{$val->_note ?? ''}}
            </td>
            
            
        </tr>

              @empty
              @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
@if(sizeof($_hrm_education) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="8">{{__('label._hrm_education')}}</th>
              </tr>
              <tr>
            <th>#</th>
            <th>{{__('label._level')}}</th>
            <th>{{__('label._subject')}}</th>
            <th>{{__('label._institute')}}</th>
            <th>{{__('label._year')}}</th>
            <th>{{__('label._score')}}</th>
            <th>{{__('label._edsdate')}}</th>
            <th>{{__('label._ededate')}}</th>
        </tr>
            </thead>
            <tbody>
              @forelse($_hrm_education as $he=>$edu_val)
              <tr>
          
            <td>{{ ($he+1) }} </td>
            <td>{{$edu_val->_level ?? '' }} </td>
            <td>{{$edu_val->_subject ?? ''}}</td>
            <td>{{$edu_val->_institute ?? '' }}</td>
            <td>{{$edu_val->_year ?? '' }}</td>
            <td>{{$edu_val->_score ?? '' }}</td>
            <td>{{ $edu_val->_edsdate ?? '' }}</td>
            <td>{{ $edu_val->_ededate ?? '' }}
            </td>
        </tr>

              @empty
              @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
      
@if(sizeof($hrm_emergencies) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="6">{{__('label.hrm_emergencies')}}</th>
              </tr>
            <tr>
                <th>#</th>
                <th>{{__('label._name')}}</th>
                <th>{{__('label._relationship')}}</th>
                <th>{{__('label._mobile')}}</th>
                <th>{{__('label._home')}}</th>
                <th>{{__('label._work')}}</th>
            </tr>
            </thead>
            <tbody>
               @forelse($hrm_emergencies as $em_key=>$em_val)
        <tr>
            <td>{{($em_key+1)}}</td>
            <td>{{$em_val->_name ?? '' }}</td>
            <td>{{$em_val->_relationship ?? ''}} </td>
            <td>{{$em_val->_mobile ?? '' }}</td>
            <td>{{$em_val->_home ?? '' }}</td>
            <td>{{$em_val->_work ?? '' }}</td>
            
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif

@if(sizeof($_hrm_languages) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="4">{{__('label.hrm_languages')}}</th>
              </tr>
            
        <tr>
            <th>#</th>
            <th>{{__('label._language')}}</th>
            <th>{{__('label._fluency')}}</th>
            <th>{{__('label._lnote')}}</th>
        </tr>
            </thead>
            <tbody>
@forelse($_hrm_languages as $h_e_key=>$lan)
        <tr>
            <td>{{($h_e_key+1)}}</td>
           <td>{{$lan->_language ?? '' }}</td>
            
            <td>{{$lan->_fluency ?? ''}}</td>
            <td>{{$lan->_lnote ?? '' }}</td>
            
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
      
@if(sizeof($hrm_empaddresses) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="8">{{__('label.hrm_empaddresses')}}</th>
              </tr>
            
        <tr>
            <th>#</th>
            <th>{{__('label._type')}}</th>
            <th>{{__('label._district')}}</th>
            <th>{{__('label._police')}}</th>
            <th>{{__('label._post')}}</th>
            <th>{{__('label._address')}}</th>
            <th>{{__('label._eaddress')}}</th>
        </tr>
            </thead>
            <tbody>
 @forelse($hrm_empaddresses as $h_e_key=>$val)
        <tr>
            <td>{{($h_e_key+1)}}</td>
           <td>@if($val->_type=="Present") Present @endif
              @if($val->_type=="Parmanent") Parmanent @endif </td>
            <td>{{$val->_district ?? '' }}</td>
            <td>{{$val->_police ?? '' }}</td>
            <td>{{$val->_post ?? '' }}</td>
            <td>{{$val->_address ?? ''}}</td>
            <td>{{$val->_eaddress ?? '' }}
            </td>
            
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
        
@if(sizeof($_hrm_rewards) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="5">{{__('label.hrm_rewards')}}</th>
              </tr>
            
        <tr>
            <th>#</th>
            <th>{{__('label._rcategory')}}</th>
            <th>{{__('label._rtype')}}</th>
            <th>{{__('label._rcause')}}</th>
            <th>{{__('label._rnote')}}</th>
        </tr>
            </thead>
            <tbody>
    @forelse($_hrm_rewards as $h_e_key=>$reword)
        <tr>
            <td>{{($h_e_key+1)}}</td>
          <td>{{$reword->_rcategory ?? '' }} </td>
            <td>{{$reword->_rtype ?? ''}}</td>
            <td>{{$reword->_rcause ?? '' }}</td>
            <td>{{$reword->_rnote ?? '' }} </td>
            
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
    
@if(sizeof($_hrm_trainings) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="10">{{__('label.hrm_trainings')}}</th>
              </tr>
            
        <tr>
            <th>#</th>
            <th>{{__('label._type')}}</th>
            <th>{{__('label._name')}}</th>
            <th>{{__('label._subject')}}</th>
            <th>{{__('label.organization_id')}}</th>
            <th>{{__('label._place')}}</th>
            <th>{{__('label._trfrom')}}</th>
            <th>{{__('label._trto')}}</th>
            <th>{{__('label._result')}}</th>
            <th>{{__('label._note')}}</th>
        </tr>
            </thead>
            <tbody>
 @forelse($_hrm_trainings as $h_e_key=>$training)
     
        <tr>
            <td>{{($h_e_key+1)}}</td>
            <td>{{$training->_type ?? '' }}</td>
            <td>{{$training->_name ?? ''}}</td>
            <td>{{$training->_subject ?? '' }} </td>
            <td>{{$training->_organized ?? '' }}</td>
            <td>{{$training->_place ?? '' }}</td>
            <td>{{$training->_trfrom ?? '' }}</td>
            <td>{{$training->_trto ?? '' }}</td>
            <td>{{$training->_result ?? '' }}</td>
            <td>{{$training->_note ?? '' }}</td>
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif
     
@if(sizeof($_hrm_transfers) > 0)
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="10">{{__('label.hrm_transfers')}}</th>
              </tr>
            
          <tr>
            <th>#</th>
            <th>{{__('label._forganization_id')}}</th>
            <th>{{__('label._fbranch_id')}}</th>
            <th>{{__('label._fcost_center_id')}}</th>
            <th>{{__('label._ttransfer')}}</th>
            <th>{{__('label._torganization_id')}}</th>
            <th>{{__('label._tbranch_id')}}</th>
            <th>{{__('label._tcost_center_id')}}</th>
            <th>{{__('label._tjoin')}}</th>
            <th>{{__('label._tnote')}}</th>
        </tr>
            </thead>
            <tbody>
  @forelse($_hrm_transfers as $h_e_key=>$transfer)
     
        <tr>
            <td>{{($h_e_key+1)}}</td>
            <td>{{ id_to_cloumn($transfer->_forganization_id,'_name','companies') }}</td>
            <td>{{ id_to_cloumn($transfer->_fbranch_id,'_name','branches') }}</td>
            <td>{{ id_to_cloumn($transfer->_fcost_center_id,'_name','cost_centers') }}</td>
            <td>{{$transfer->_ttransfer ?? '' }}</td>
            <td>{{ id_to_cloumn($transfer->_torganization_id,'_name','companies') }}</td>
            <td>{{ id_to_cloumn($transfer->_tbranch_id,'_name','branches') }}</td>
            <td>{{ id_to_cloumn($transfer->_tcost_center_id,'_name','cost_centers') }}</td>
            <td>{{$transfer->_tjoin ?? '' }}</td>
            <td>{{$transfer->_tnote ?? '' }}</td>
            
        </tr>
        @empty
        @endforelse
            </tbody>
          </table>
        </td>
      </tr>
@endif   
@if($hrm_jobcontracts !='')
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="2">{{__('label.hrm_jobcontracts')}}</th>
              </tr>
            
            </thead>
            <tbody>
 
     
        <tr>
            <td>{{__('label._ctype')}}</td>
            <td> : {{$hrm_jobcontracts->_ctype ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._csdate')}}</td>
            <td> : {{$hrm_jobcontracts->_csdate ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._cedate')}}</td>
            <td> : {{$hrm_jobcontracts->_cedate ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._cdetail')}}</td>
            <td> : {{$hrm_jobcontracts->_cdetail ?? ''}}</td> 
        </tr>
       
  
            </tbody>
          </table>
        </td>
      </tr>
@endif
         
@if($hrm_nominees !='')
       <tr>
        <td colspan="6" style="border:none;">
          <table style="width:100%;">
            <thead>
              <tr>
                <th colspan="4">{{__('label.hrm_nominees')}}</th>
              </tr>
            
            </thead>
            <tbody>
 
     
        <tr>
            <td>{{__('label._nname')}}</td>
            <td> : {{$hrm_nominees->_nname ?? ''}}</td> 
            <td>{{__('label._nfather')}}</td>
            <td> : {{$hrm_nominees->_nfather ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._nmother')}}</td>
            <td> : {{$hrm_nominees->_nmother ?? ''}}</td> 
            <td>{{__('label._ndob')}}</td>
            <td> : {{$hrm_nominees->_ndob ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._nnationalid')}}</td>
            <td> : {{$hrm_nominees->_nnationalid ?? ''}}</td> 
            <td>{{__('label._nmobile')}}</td>
            <td> : {{$hrm_nominees->_nmobile ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._naddress1')}}</td>
            <td> : {{$hrm_nominees->_naddress1 ?? ''}}</td> 
            <td>{{__('label._naddress2')}}</td>
            <td> : {{$hrm_nominees->_naddress2 ?? ''}}</td> 
        </tr>
        <tr>
            <td>{{__('label._nrelation')}}</td>
            <td> : {{$hrm_nominees->_nrelation ?? ''}}</td> 
            <td>{{__('label._nbenefit')}}</td>
            <td> : {{$hrm_nominees->_nbenefit ?? ''}}</td> 
        </tr>
  
            </tbody>
          </table>
        </td>
      </tr>
@endif
      
    </table>
    
    

    

    
    </div>
  </section>


<!-- Page specific script -->

@endsection

@section('script')

@endsection