@include('eight_hrm::reports.header_landscape')

<style type="text/css">
     @page {
              size: A3 landscape ;
              margin: 5mm 5mm 5mm 5mm;
            }
    .vertical_left{
        writing-mode: vertical-lr;
        transform: rotate(180deg);
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
    }
    .vertical_normal{
        white-space: nowrap;
        font-size: 12px;
        vertical-align: top;
    }
    .bold{
        font-weight: 600;
    }
    .text_right{
        text-align: right;
    }
    .text_left{
        text-align: left;
    }
</style>
    <body class="antialiased">
        <div  >
        <div style="width:100%;border-collapse: collapse;float: left;">
        <table style="width:100%;border-collapse: collapse;">
            <thead>
                <tr style="border:none;">
                    <td colspan="44" style="border:none;">
                        <div class="report_top_header">
                            <table style="width:100%;text-align:center;">
                                <tr style="border:none;">
                                    <td style="border:none;"> <span style="font-size: 22px;font-weight: bold;">{!! $company_name ?? '' !!}</span></td>
                                </tr>
                               
                                <tr style="border:none;">
                                    <td style="border:none;"> <span class="header_report_name">{{ $page_name ?? '' }} for the Month of {{ _number_to_month($period) }} , {{$year}}</span></td>
                                </tr>
                                
                            </table>
                           
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        GENERAL INFORMATION
                    </td>
                    <td colspan="5" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        SALARY EARNED
                    </td>
                    <td colspan="6" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        ATTENDANCE
                    </td>
                    <td colspan="12" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        ALLOWANCE
                    </td>
                    <td colspan="9" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        DEDUCTION
                    </td>
                    <td rowspan="2" style="text-align: center;font-size: 14px;font-weight: 600;vertical-align: top;">
                        NET <br>PAYABLE <br>SALARY
                    </td>
                    <td rowspan="2"  class="vertical_left">
                        BANK
                    </td>
                    <td rowspan="2" class="vertical_left">
                        CASH
                    </td>
                    <td rowspan="2" class="vertical_left">
                        MOBILE BANK
                    </td>
                </tr>
                <tr>
                    <td class="vertical_normal bold">#SL</td>
                    <td class="vertical_normal bold">Emp ID</td>
                    <td class="vertical_normal bold">Employee Name</td>
                    <td class="vertical_normal bold">DOJ</td>
                    <td class="vertical_normal bold">DESIGNATION</td>
                    <td class="vertical_normal bold">GRADE</td>
                    <td class="vertical_normal bold">DEPARTMENT</td>

                    <td class="vertical_left bold">BASIC</td>
                    <td class="vertical_left bold">HOUSE RENT</td>
                    <td class="vertical_left bold">MEDICAL</td>
                    <td class="vertical_left bold">CONVEYANCE</td>
                    <td class="vertical_left bold ">GROSS <br>SALARY</td>
                    <td class="vertical_left bold">PRESENT <br>DAY</td>
                    <td class="vertical_left bold">HOLIDAY</td>
                    <td class="vertical_left bold">ABSENT</td>
                    <td class="vertical_left bold">LWP</td>
                    <td class="vertical_left bold">PAYABLE <br>ATTENDANCE</td>


                    <td class="vertical_left bold">DUE SALARY</td>
                    <td class="vertical_left bold">NIGHT <br>ALLOWANCE</td>
                    <td class="vertical_left bold">FIXED OT <br>ALLOWANCE</td>
                    <td class="vertical_left bold">OT HOURS</td>
                    <td class="vertical_left bold">OT AMOUNT</td>
                    <td class="vertical_left bold">FIXED <br>ALLOWANCE</td>
                    <td class="vertical_left bold">ENTERTAINMENT</td>
                    <td class="vertical_left bold">ARREAR</td>
                    <td class="vertical_left bold">FUEL <br>ALLOWANCE</td>
                    <td class="vertical_left bold">TECHNICAL <br>ALLOWANCE</td>
                    <td class="vertical_left bold">INCENTIVE</td>
                    <td class="vertical_left bold">OTHER <br>ALLOWANCE</td>
                    <td class="vertical_normal bold">PAYABLE <br> GROSS</td>


                    <td class="vertical_left bold">LOAN/ADV.</td>
                    <td class="vertical_left bold">ADJUSTMENT</td>
                    <td class="vertical_left bold">ABSENT & LWP</td>
                    <td class="vertical_left bold">JOIN & RESIGN</td>
                    <td class="vertical_left bold">SECURITY <br>DEPOSITE</td>
                    <td class="vertical_left bold">CANTEEN <br>DEDUCTION</td>
                    <td class="vertical_left bold">OTHER <br>DEDUCTION</td>
                    <td class="vertical_left bold">TAX</td>
                    <td class="vertical_left bold">TOTAL</td>
                </tr>
               
            </thead>
            <tbody>
 @php
$grand_total_gross_salary           =0;
$grand_total_basic           =0;
$grand_total_bankpayment            =0;
$grand_total_house_rent             =0;
$grand_total_medical                =0;
$grand_total_conveyance             =0;
$grand_total_gross_salary           =0;
$grand_total_present_day            =0;
$grand_total_holiday                =0;
$grand_total_absent                 =0;
$grand_total_lwp                    =0;
$grand_total_payable_attendance     = 0;
$grand_total_due_salary     = 0;
$grand_total_night_allowance     = 0;
$grand_total_fixed_ot_allowance     = 0;
$grand_total_ot_hours     = 0;
$grand_total_ot_amount     = 0;
$grand_total_fixed_allowance     = 0;
$grand_total_fixed_enterrainment     = 0;
$grand_total_arrear     = 0;
$grand_total_fuel_allowance     = 0;
$grand_total_technical_allowance     = 0;
$grand_total_incentive     = 0;
$grand_total_other_allowance     = 0;
$grand_total_payable_gross     = 0;
$grand_total_payable_gross     = 0;
$grand_total_loan_adv     = 0;
$grand_total_adjustment     = 0;
$grand_total_absent_lwp     = 0;
$grand_total_join_resign     = 0;
$grand_total_security_deposite     = 0;
$grand_total_canteen_deposite     = 0;
$grand_total_other_deduction     = 0;
$grand_total_tax     = 0;
$grand_total_total     = 0;

$grand_total_net_pay     = 0;
$grand_total_total_deduction=0;
$grand_total_bank_amount=0;
$grand_total_cash_amount=0;
$grand_total_mobile_amount=0;
$grand_group_count=0;
$grand_total_approve_leave_count=0;
$grand_total_mobile_bank_amount =0;

                @endphp

                @forelse($data as $_department=>$department_val)

                @php
$sub_gross_salary           =0;
$sub_basic           =0;
$sub_bankpayment            =0;
$sub_house_rent             =0;
$sub_medical                =0;
$sub_conveyance             =0;
$sub_gross_salary           =0;
$sub_present_day            =0;
$sub_holiday                =0;
$sub_absent                 =0;
$sub_lwp                    =0;
$sub_approve_leave_count      = 0;
$sub_payable_attendance     = 0;
$sub_due_salary     = 0;
$sub_night_allowance     = 0;
$sub_fixed_ot_allowance     = 0;
$sub_ot_hours     = 0;
$sub_ot_amount     = 0;
$sub_fixed_allowance     = 0;
$sub_fixed_enterrainment     = 0;
$sub_arrear     = 0;
$sub_fuel_allowance     = 0;
$sub_technical_allowance     = 0;
$sub_incentive     = 0;
$sub_other_allowance     = 0;
$sub_payable_gross     = 0;
$sub_loan_adv     = 0;
$sub_adjustment     = 0;
$sub_absent_lwp     = 0;
$sub_join_resign     = 0;
$sub_security_deposite     = 0;
$sub_canteen_deposite     = 0;
$sub_other_deduction     = 0;
$sub_tax     = 0;
$sub_total     = 0;
$sub_net_pay     = 0;
$sub_total_deduction=0;
$sub_bank_amount=0;
$sub_cash_amount=0;
$sub_mobile_amount=0;
$sub_mobile_bank_amount =0;


$group_count=0;

$sl_no =1;
                @endphp
                 <tr>
                    <td colspan="44" class="vertical_normal bold text_left" >{{$_department ?? ''}}</td>
                </tr>

                @forelse($department_val as $main_key=>$main_val)

               
                <tr>
                    <td class="vertical_normal bold">{{($sl_no++)}}</td>
                    <td class="vertical_normal ">{!! $main_key !!}</td>
                    <td class="vertical_normal ">{!! $main_val[0]["emp_name"] ?? ''  !!}</td>
                    <td class="vertical_normal ">{!! $main_val[0]["join_date"] ?? ''  !!}</td>
                    <td class="vertical_normal ">{!! $main_val[0]["designation"] ?? ''  !!}</td>
                    <td class="vertical_normal ">{!! $main_val[0]["empgrade"] ?? ''  !!}</td>
                    <td class="vertical_normal ">{!! $main_val[0]["department"] ?? ''  !!}</td>
                   
@php
$paytype = $main_val[0]["paytype"] ?? '';
$bank_amount =0;
$cash_amount =0;
$mobile_bank_amount=0;

if($paytype=='Bank'){
    $cash_amount =$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $sub_cash_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $grand_total_cash_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
}
if($paytype=='Cash'){
    $bank_amount =$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $sub_bank_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $grand_total_bank_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
}
if($paytype=='Mobile Banking'){
    $mobile_bank_amount =$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $sub_mobile_bank_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
    $grand_total_mobile_bank_amount +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;;
}




$group_count++;
$grand_group_count++;
  $sub_basic +=$emaployee_field_amount[$main_key]["Basic"] ??  0;
  $sub_house_rent +=$emaployee_field_amount[$main_key]["House Rent"] ??  0;
  $sub_medical +=$emaployee_field_amount[$main_key]["Medical Allowance"] ??  0;
  $sub_conveyance +=$emaployee_field_amount[$main_key]["Conveyance Allowance"] ??  0;
  $sub_gross_salary +=$emaployee_field_amount[$main_key]["Gross Pay"] ??  0;
  $sub_due_salary +=$emaployee_field_amount[$main_key]["DUE SALARY"] ??  0;
  $sub_night_allowance +=$emaployee_field_amount[$main_key]["Night Shift Allowance"] ??  0;
  $sub_fixed_ot_allowance +=$emaployee_field_amount[$main_key]["Fixed OT"] ??  0;
  $sub_ot_amount +=$emaployee_field_amount[$main_key]["Overtime Allowance"] ??  0;
  $sub_fixed_allowance +=$emaployee_field_amount[$main_key]["Fixed Allowance"] ??  0;
  $sub_fixed_enterrainment +=$emaployee_field_amount[$main_key]["Entertainment Allowance"] ??  0;
  $sub_arrear +=$emaployee_field_amount[$main_key]["Arrear Salary"] ??  0;
  $sub_fuel_allowance +=$emaployee_field_amount[$main_key]["Fuel  Allowance"] ??  0;
  $sub_technical_allowance +=$emaployee_field_amount[$main_key]["Technical Allowance"] ??  0;
  $sub_incentive +=$emaployee_field_amount[$main_key]["Incentive"] ??  0;
  $sub_other_allowance +=$emaployee_field_amount[$main_key]["Other Allowance"] ??  0;
  $sub_payable_gross +=$emaployee_field_amount[$main_key]["Gross Pay"] ??  0;

  $sub_loan_adv +=$emaployee_field_amount[$main_key]["Loan/Advance Deduction"] ??  0;
  $sub_adjustment +=$emaployee_field_amount[$main_key]["Adjustment"] ??  0;
  $sub_absent_lwp +=$emaployee_field_amount[$main_key]["Absent Deduction"] ??  0;
  $sub_join_resign +=$emaployee_field_amount[$main_key]["Join / Resign Deduction"] ??  0;
  $sub_security_deposite +=$emaployee_field_amount[$main_key]["Security Deposit"] ??  0;
  $sub_canteen_deposite +=$emaployee_field_amount[$main_key]["Canteen Deduction"] ??  0;
  $sub_other_deduction +=$emaployee_field_amount[$main_key]["Other deduction"] ??  0;
  $sub_tax +=$emaployee_field_amount[$main_key]["TDS"] ??  0;
  $sub_net_pay +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;
//Grand Total

  $grand_total_basic +=$emaployee_field_amount[$main_key]["Basic"] ??  0;
  $grand_total_house_rent +=$emaployee_field_amount[$main_key]["House Rent"] ??  0;
  $grand_total_medical +=$emaployee_field_amount[$main_key]["Medical Allowance"] ??  0;
  $grand_total_conveyance +=$emaployee_field_amount[$main_key]["Conveyance Allowance"] ??  0;
  $grand_total_gross_salary +=$emaployee_field_amount[$main_key]["Gross Pay"] ??  0;
  $grand_total_due_salary +=$emaployee_field_amount[$main_key]["DUE SALARY"] ??  0;
  $grand_total_night_allowance +=$emaployee_field_amount[$main_key]["Night Shift Allowance"] ??  0;
  $grand_total_fixed_ot_allowance +=$emaployee_field_amount[$main_key]["Fixed OT"] ??  0;
  $grand_total_ot_amount +=$emaployee_field_amount[$main_key]["Overtime Allowance"] ??  0;
  $grand_total_fixed_allowance +=$emaployee_field_amount[$main_key]["Fixed Allowance"] ??  0;
  $grand_total_fixed_enterrainment +=$emaployee_field_amount[$main_key]["Entertainment Allowance"] ??  0;
  $grand_total_arrear +=$emaployee_field_amount[$main_key]["Arrear Salary"] ??  0;
  $grand_total_fuel_allowance +=$emaployee_field_amount[$main_key]["Fuel  Allowance"] ??  0;
  $grand_total_technical_allowance +=$emaployee_field_amount[$main_key]["Technical Allowance"] ??  0;
  $grand_total_incentive +=$emaployee_field_amount[$main_key]["Incentive"] ??  0;
  $grand_total_other_allowance +=$emaployee_field_amount[$main_key]["Other Allowance"] ??  0;
  $grand_total_payable_gross +=$emaployee_field_amount[$main_key]["Gross Pay"] ??  0;

  $grand_total_loan_adv +=$emaployee_field_amount[$main_key]["Loan/Advance Deduction"] ??  0;
  $grand_total_adjustment +=$emaployee_field_amount[$main_key]["Adjustment"] ??  0;
  $grand_total_absent_lwp +=$emaployee_field_amount[$main_key]["Absent Deduction"] ??  0;
  $grand_total_join_resign +=$emaployee_field_amount[$main_key]["Join / Resign Deduction"] ??  0;
  $grand_total_security_deposite +=$emaployee_field_amount[$main_key]["Security Deposit"] ??  0;
  $grand_total_canteen_deposite +=$emaployee_field_amount[$main_key]["Canteen Deduction"] ??  0;
  $grand_total_other_deduction +=$emaployee_field_amount[$main_key]["Other deduction"] ??  0;
  $grand_total_tax +=$emaployee_field_amount[$main_key]["TDS"] ??  0;
  $grand_total_net_pay +=$emaployee_field_amount[$main_key]["Net Pay"] ??  0;


  $loan_adv  =$emaployee_field_amount[$main_key]["Loan/Advance Deduction"] ??  0;
  $adjustment  =$emaployee_field_amount[$main_key]["Adjustment"] ??  0;
  $absent_lwp  =$emaployee_field_amount[$main_key]["Absent Deduction"] ??  0;
  $join_resign  =$emaployee_field_amount[$main_key]["Join / Resign Deduction"] ??  0;
  $security_deposite  =$emaployee_field_amount[$main_key]["Security Deposit"] ??  0;
  $canteen_deposite  =$emaployee_field_amount[$main_key]["Canteen Deduction"] ??  0;
  $other_deduction  =$emaployee_field_amount[$main_key]["Other deduction"] ??  0;
  $tax  =$emaployee_field_amount[$main_key]["TDS"] ??  0;
  $total_deduction  =($loan_adv+$adjustment+$absent_lwp+$join_resign+$security_deposite+$canteen_deposite+$other_deduction+$tax);


$sub_total_deduction += $total_deduction ;

 $p_count = $attendance_data[$main_key][0]["p_count"] ?? 0;
 $l_count = $attendance_data[$main_key][0]["l_count"] ?? 0;
 $eo_count = $attendance_data[$main_key][0]["eo_count"] ?? 0;
 $PM_count = $attendance_data[$main_key][0]["PM_count"] ?? 0;
 $LE_count = $attendance_data[$main_key][0]["LE_count"] ?? 0;
 $A_count = $attendance_data[$main_key][0]["A_count"] ?? 0;
 $LWP_count = $attendance_data[$main_key][0]["LWP_count"] ?? 0;
 $WO_count = $attendance_data[$main_key][0]["WO_count"] ?? 0;
 $GH_count = $attendance_data[$main_key][0]["GH_count"] ?? 0;
 $approve_leave_count = $attendance_data[$main_key][0]["approve_leave_count"] ?? 0;
 $actual_ot = $attendance_data[$main_key][0]["actual_ot"] ?? 0;
 $app_ot = $attendance_data[$main_key][0]["app_ot"] ?? 0;



$sub_present_day            +=($p_count+$l_count+$eo_count+$PM_count+$LE_count+$approve_leave_count);
$sub_holiday                +=($WO_count+$GH_count);
$sub_absent                 +=($A_count);
$sub_lwp                    +=($LWP_count);
$sub_approve_leave_count     += ($approve_leave_count);
$sub_payable_attendance     += ($p_count+$l_count+$eo_count+$PM_count+$LE_count+$WO_count+$GH_count+$approve_leave_count);

$grand_total_present_day            +=($p_count+$l_count+$eo_count+$PM_count+$LE_count+$approve_leave_count);
$grand_total_holiday                +=($WO_count+$GH_count);
$grand_total_absent                 +=($A_count);
$grand_total_lwp                    +=($LWP_count);
$grand_total_approve_leave_count     += ($approve_leave_count);
$grand_total_payable_attendance     += ($p_count+$l_count+$eo_count+$PM_count+$LE_count+$WO_count+$GH_count+$approve_leave_count);





@endphp
                    <td class="vertical_left bold">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Basic"] ?? '' ) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["House Rent"] ?? '' ) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Medical Allowance"] ?? '' ) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Conveyance Allowance"] ?? '') !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Gross Pay"] ?? '') !!}</td>
                 
                    
                    <td class="vertical_left">{!! ($p_count+$l_count+$eo_count+$PM_count+$LE_count+$approve_leave_count) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($WO_count+$GH_count) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($A_count) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($LWP_count) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($p_count+$l_count+$eo_count+$PM_count+$LE_count+$WO_count+$GH_count+$approve_leave_count) !!}</td>


                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["DUE SALARY"] ?? '' ) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Night Shift Allowance"] ?? '' ) !!}</td>
                    <td class="vertical_left">{!! _empty_report_amount($emaployee_field_amount[$main_key]["Fixed OT"] ?? '' ) !!}</td>
                   
                    <td class="vertical_left">{{_empty_report_amount($attendance_data[$main_key][0]["actual_ot"] ?? '')}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Overtime Allowance"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Fixed Allowance"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Entertainment Allowance"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Arrear Salary"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Fuel  Allowance"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Technical Allowance"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Incentive"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Other Allowance"] ?? '' )}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($emaployee_field_amount[$main_key]["Gross Pay"] ?? '' )}}</td>


                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Loan/Advance Deduction"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Adjustment"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Absent Deduction"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Join / Resign Deduction"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Security Deposit"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Canteen Deduction"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["Other deduction"] ?? '' )}}</td>
                    <td class="vertical_left">{{_empty_report_amount($emaployee_field_amount[$main_key]["TDS"] ?? '' )}}</td>
                    <td class="vertical_left">{{($sub_total_deduction) }}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($emaployee_field_amount[$main_key]["Net Pay"] ?? '' )}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($cash_amount )}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($bank_amount )}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($mobile_bank_amount )}}</td>
                  
                   
                </tr>



@empty
@endforelse

        <tr>
                    
                    <td colspan="7" class="vertical_normal text_right"><b>{!! $_department ?? '' !!}:{{$group_count}} </b></td>
                    <td class="vertical_left bold" >{{_empty_report_amount($sub_basic ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($sub_house_rent ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($sub_medical ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($sub_conveyance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_gross_salary ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_present_day ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_holiday ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_absent  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_lwp ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_payable_attendance ?? '')}}</td>


                    <td class="vertical_left bold">{{_empty_report_amount($sub_due_salary ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_night_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_fixed_ot_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($actual_ot ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_ot_amount ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_fixed_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_fixed_enterrainment ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_arrear ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_fuel_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_technical_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_incentive ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_other_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_payable_gross ?? '')}}</td>
                    

                    <td class="vertical_left bold">{{_empty_report_amount($sub_loan_adv ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_adjustment ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_absent_lwp ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_join_resign ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_security_deposite ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_canteen_deposite ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_other_deduction ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_tax ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_total_deduction ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_net_pay ?? '')}}</td>
                   <td class="vertical_left bold">{{_empty_report_amount($sub_cash_amount  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_bank_amount  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($sub_mobile_bank_amount  ?? '')}}</td>
                    </tr>


                @empty
                @endforelse

                <tr>
                    
                    <td colspan="7" class="vertical_normal text_right"><b>Grand Total:{{$grand_group_count}} </b></td>
                    <td class="vertical_left bold" >{{_empty_report_amount($grand_total_basic ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($grand_total_house_rent ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($grand_total_medical ?? '')}}</td>
                    <td class="vertical_left bold" >{{_empty_report_amount($grand_total_conveyance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_gross_salary ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_present_day ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_holiday ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_absent  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_lwp ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_payable_attendance ?? '')}}</td>


                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_due_salary ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_night_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_fixed_ot_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($actual_ot ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_ot_amount ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_fixed_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_fixed_enterrainment ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_arrear ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_fuel_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_technical_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_incentive ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_other_allowance ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_payable_gross ?? '')}}</td>
                    

                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_loan_adv ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_adjustment ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_absent_lwp ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_join_resign ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_security_deposite ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_canteen_deposite ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_other_deduction ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_tax ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_total_deduction ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_net_pay ?? '')}}</td>
                   <td class="vertical_left bold">{{_empty_report_amount($grand_total_cash_amount  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_bank_amount  ?? '')}}</td>
                    <td class="vertical_left bold">{{_empty_report_amount($grand_total_mobile_bank_amount  ?? '')}}</td>
                    </tr>
                           
                
                 <tr>
                    <td colspan="44" style="border:none;">
                        
                        <span style="font-weight: 500;">In Words:  {{ nv_number_to_text($grand_total_net_pay ?? 0) }}</span>

                    </td>
                    
                </tr>
            </tbody>
            <tfoot style="padding-bottom: 50px;">
                
               
                <tr>
                    <td colspan="3" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Prepared By</span>
                    </td>
                    <td colspan="3" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Checked By</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Head of HR</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Finance & Accounts</span>
                    </td>
                    <td colspan="10" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Director</span>
                    </td>
                    <td colspan="8" style="text-align:center;border:none;padding-top: 100px;">
                        <span></span><br>
                        <span style="font-weight:bold;border-top: 1px solid #000;">Managing Director</span>
                    </td>
                   
                </tr>
                <tr>
                    <td colspan="44" style="border: none;">
                        <div style="padding-top:70px;">
                              <p style="border-top: 1px solid silver;"> Powered By: 88innovations Engineering Ltd , Printed Date:  {{date('F j, Y \T\i\m\e: g:i a')}}</p> 
                        </div>
                    </td>
                </tr>
            </tfoot>

            
        </table>
    </div>

</div>
</body>
@include('eight_hrm::reports.report_footer')
