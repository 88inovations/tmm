<div class="row"> 




@can('stmd_today_collection_expense')
@php
$datas = \DB::select(" SELECT 
  t2._name,
    t1.`_bill_type`, 
    t1.`_collection_ledger_id`,
    SUM(t1.`_collection_amount`) AS total_collection_amount
FROM 
    `stm_collection_master_details` AS t1
    INNER JOIN account_ledgers as t2 ON t2.id=t1._collection_ledger_id
WHERE 
    t1.`_status` = 1  AND DATE(t1.`_date`) = CURDATE()
    
GROUP BY 
    t1.`_bill_type` ")
@endphp
<div class="col-md-6">
  <div class="card ">
   <caption><h5 class="text-center text-bold">To Day Collections</h5></caption>
    <div class="card-body table-responsive p-0 info-box">
      <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._ledger_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._amount')}}</td>
          </tr>
          
          
          </thead>
          <tbody>
          @php
          $_total_amount=0;
          @endphp
          @forelse($datas as $d_key=>$data)
          @php
          $_total_amount +=$data->total_collection_amount ?? 0;
          @endphp
                  <tr>
                      <td class="white_space">{{ ($d_key+1) }}</td>
                      <td class="white_space">{!! _fee_lebel($data->_bill_type ?? '') !!} </td>
                      <td class="white_space">{!! ($data->total_collection_amount ?? 0)  !!}</td>
                    </tr>
          @empty
          <tr>
                      <td colspan="3" class="white_space text-center">No Data Found</td>
                    </tr>
          @endforelse
          
          @if(sizeof($datas) > 0)
            <tr>
                      <th colspan="2" class="white_space">Total </th>
                      <th class="white_space">{!! ($_total_amount ?? 0)  !!}</th>
                    </tr>
          @endif
                    </tbody>
                    
                  </table>
    </div>
  </div>
</div>


@endcan
@can('stmd_today_collection_expense')
@php
$datas = \DB::select(" SELECT t2._name,t2._code,SUM(t1._dr_amount-t1._cr_amount) as _amount 
FROM `accounts` as t1 
INNER JOIN account_ledgers as t2 ON t2.id=t1._account_ledger 
INNER JOIN account_heads as t3 ON t3.id=t2._account_head_id 
WHERE t1._status=1 AND t3._account_id=4   AND DATE(t1.`_date`) = CURDATE()
GROUP BY t1._account_ledger 
ORDER BY t2._name ASC ")
@endphp
<div class="col-md-6">
  <div class="card ">
   <caption><h5 class="text-center text-bold">To Day Expenses</h5></caption>
    <div class="card-body table-responsive p-0 info-box">
      <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._ledger_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._amount')}}</td>
          </tr>
          
          
          </thead>
          <tbody>
          @php
          $_total_expense_amount=0;
          @endphp
          @forelse($datas as $d_key=>$data)
          @php
          $_total_expense_amount +=$data->_amount ?? 0;
          @endphp
                  <tr>
                      <td class="white_space">{{ ($d_key+1) }}</td>
                      <td class="white_space">{!! $data->_name ?? '' !!} </td>
                      <td class="white_space">{!! ($data->_amount ?? 0)  !!}</td>
                    </tr>
          @empty
          <tr>
                      <td colspan="3" class="white_space text-center">No Data Found</td>
                    </tr>
          @endforelse
          
          @if(sizeof($datas) > 0)
            <tr>
                      <th colspan="2" class="white_space">Total </th>
                      <th class="white_space">{!! ($_total_expense_amount ?? 0)  !!}</th>
                    </tr>
          @endif
                    </tbody>
                    
                  </table>
    </div>
  </div>
</div>


@endcan


<div class="col-md-12">
<div class="row">
@can('stmd_student_count')
@php
$datas = \App\Models\STM\StmDivisionClassStudent::where('_status',1);
         $datas = $datas->select(
                '_session',
                '_division_id',
                '_class_id',
                DB::raw('count(*) as _number_of_student')
            )->groupBy('_session', '_division_id', '_class_id')
            ->orderBy('_session')
            ->orderBy('_division_id')
            ->orderBy('_class_id')
            ->get();
@endphp
<div class="col-md-6">
  <div class="card " >
   <caption><h5 class="text-center text-bold">Student Count</h5></caption>
    <div class="card-body table-responsive p-0 info-box" >
      <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._session')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._division_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._class_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._number_of_student')}}</td>
          </tr>
          
          
          </thead>
          <tbody >
          @php
          $_total_number_of_student=0;
          @endphp
          @forelse($datas as $d_key=>$data)
          @php
          $_total_number_of_student +=$data->_number_of_student ?? 0;
          @endphp
                  <tr>
                      <td class="white_space">{{ ($d_key+1) }}</td>
                      <td class="white_space">{!! _id_to_name($data->_session,'_name','stm_education_sessions') !!} </td>
                      <td class="white_space">{!! _id_to_name($data->_division_id,'_name','stm_divisions') !!} </td>
                      <td class="white_space">{!! _id_to_name($data->_class_id,'_name','stm_classes') !!}</td>
                      <td class="white_space">{!! ($data->_number_of_student ?? 0)  !!}</td>
                    </tr>
          @empty
          @endforelse
          <tr>
            <tr>
                      <th colspan="4" class="white_space">Total Student</th>
                      <th class="white_space">{!! ($_total_number_of_student ?? 0)  !!}</th>
                    </tr>
          </tr>
                    </tbody>
                    
                  </table>
    </div>
  </div>
</div>
@endcan




@can('stmd_student_count')
@php
$datas = \App\Models\STM\StmStudent::where('_status', 0)
    ->select(
        '_admission_session_id as _session',
        '_education_type as _division_id',
        '_admission_class_id as _class_id',
        DB::raw('COUNT(*) as _number_of_student')
    )
    ->groupBy('_admission_session_id', '_education_type', '_admission_class_id')
    ->orderBy('_admission_session_id')
    ->orderBy('_education_type')
    ->orderBy('_admission_class_id')
    ->get();
@endphp
<div class="col-md-6">
  <div class="card " >
   <caption><h5 class="text-center text-bold">Inactive Student Count</h5></caption>
    <div class="card-body table-responsive p-0 info-box" >
      <table class="cewReportTable">
          <thead>
          <tr>
            <td style="width:5%;" class="white_space">{{__('label.sl')}}</td>
            <td style="width:15%;"class="white_space">{{__('label._session')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._division_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._class_id')}}</td>
            <td style="width:15%;" class="white_space">{{__('label._number_of_student')}}</td>
          </tr>
          
          
          </thead>
          <tbody >
          @php
          $_total_number_of_student=0;
          @endphp
          @forelse($datas as $d_key=>$data)
          @php
          $_total_number_of_student +=$data->_number_of_student ?? 0;
          @endphp
                  <tr>
                      <td class="white_space">{{ ($d_key+1) }}</td>
                      <td class="white_space">{!! _id_to_name($data->_session,'_name','stm_education_sessions') !!} </td>
                      <td class="white_space">{!! _id_to_name($data->_division_id,'_name','stm_divisions') !!} </td>
                      <td class="white_space">{!! _id_to_name($data->_class_id,'_name','stm_classes') !!}</td>
                      <td class="white_space">{!! ($data->_number_of_student ?? 0)  !!}</td>
                    </tr>
          @empty
          @endforelse
          <tr>
            <tr>
                      <th colspan="4" class="white_space">Total Student</th>
                      <th class="white_space">{!! ($_total_number_of_student ?? 0)  !!}</th>
                    </tr>
          </tr>
                    </tbody>
                    
                  </table>
    </div>
  </div>
</div>
@endcan
</div>
</div>



@can('stmd_30_days_income_barchart')
<!-- Sales Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 days Income Chart</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="stmd_30_days_income_barchart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
@endcan

@can('stmd_30_days_expense_barchart')
<!-- Sales Related Chart Start -->
  <div class="col-lg-6 mt-2">
   <div class="card bg-white">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Last 30 days Expense Chart</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="stmd_30_days_expense_barchart" height="200"></canvas>
                </div>
              </div>
            </div>
  </div>
@endcan

@can('stmd_monthly_income_expense_compare')
<!-- Combined Income/Expense Bar Chart -->
<div class="col-lg-6 col-md-6 mt-2">
  <div class="card bg-white">
    <div class="card-header border-0">
      <h3 class="card-title">Monthly Income vs Expense Comparison</h3>
    </div>
    <div class="card-body">
      <canvas id="stmd_monthly_income_expense_compare" height="200"></canvas>
    </div>
  </div>
</div>
@endcan

 

 </div><!-- End of Row -->