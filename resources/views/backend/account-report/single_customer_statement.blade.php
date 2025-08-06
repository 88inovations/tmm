@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                 <h4 class="text-center">{{ $page_name ?? '' }}</h4>
            </div>
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('single_customer_statement')}}" method="GET">
                @csrf
                   @include('basic.report_date_filter')
                   
                    
                    <div class="row">
                      <label>Ledger:</label><br>
                      
@php
$_ledger_id  = $previous_filter["_ledger_id"] ?? '';
@endphp
                    </div>
                     <div class="row">
                      <select class="form-control _ledger_id select2" name="_ledger_id" required>
                        <option value="">Select Ledger</option>
                        @forelse($customer_ledgers as $ledger)
                        <option value="{{$ledger->id}}" @if($_ledger_id == $ledger->id) selected @endif>{!! $ledger->_name ?? '' !!} | {!! $ledger->_phone ?? '' !!}| {!! $ledger->_entry_branch->_name ?? '' !!}</option>
                        @empty
                        @endforelse
                      </select>
                         
                     </div>
                     <br>
                    
                    <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success  form-control mt-2"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                      <a href="{{url('single_customer_statement')}}"  class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset </a>
                        </div>
                        <br><br>
                     </div>

                     

                     
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>

@if($request->has('_datex') && $request->has('_datey') && $request->has('_ledger_id'))

@php
$_ledger_id = $request->_ledger_id ?? '';
$ledger_id_rows = $request->_ledger_id ?? '';
$_datex = change_date_format($request->_datex ?? '');
$_datey = change_date_format($request->_datey ?? '');
$customer_info= \DB::table('account_ledgers')->where('id',$_ledger_id)->first();
@endphp

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    

        <table class="table" style="border:none;width:750px;margin: 0px auto;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title" style="border:none;font-size: 28px;"><b>{{$settings->name ?? '' }}</b><br><br>
                </td>
                </tr>
                <tr style="display:none;"> 
                  <td class="text-right company_sub_title" style="border:none;font-size: 24px;"><div style="padding-right:225px;"> {{$settings->keywords ?? '' }}</div>
                </td> </tr>
                
<?php
$sequence_to_remove = "––------------–--";
?>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        <table class="table" style="border:none;width: 100%;margin-bottom: 0px !important;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;margin-bottom: 0px !important;">
                


                <tr style="border:none;">
                  <td style="border:none;">
                      <table class="table" >
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Date </th>
                          <td style="width:90%;text-align: left;border: none;">:{{date('d-m-Y')}} </td>
                          
                         
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Name of Territory  </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ id_to_cloumn($customer_info->_branch_id,'_name','branches') }} </td>
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Customer ID             </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ $customer_info->_code ?? '' }} </td>
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Name of Customer </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ $customer_info->_name ?? '' }} </th>
                           </td>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Proprietor         </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ $customer_info->_alious ?? '' }} </td>
                         
                        </tr>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Cell Phone No. </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ $customer_info->_phone ?? '' }} </th>
                           </td>
                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Address  </th>
                          <td style="width:90%;text-align: left;border: none;">:{!! $customer_info->_address ?? ''  !!} </td>
                         
                        </tr>

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Subject </th>
                          <td style="width:90%;text-align: left;border: none;">:Customer Ledger </td>
                         
                        </tr>

                        <tr>
                          <th style="width:10%;text-align: left;border: none;">Business Period       </th>
                          <td style="width:90%;text-align: left;border: none;">:{{ _view_date_formate($_datex)}}  To  {{_view_date_formate($_datey)}} </td>
                         
                        </tr>
                      </table>
                  </td>
                </tr>
              </table>
            </td>
            
          </tr>
        </table>
      

    <!-- Table row -->
   <table class="cewReportTable">
          <thead>
          <tr>
             
           
            <td style="width: 5%;">{{__('label.sl')}}</td>
            <td style="width: 10%;">Date</td>
            <td style="width: 10%;">Invoice No.</td>
            <td style="width: 10%;">Particulars</td>
            <td style="width: 10%;">Sales</td>
            <td style="width: 10%;">Sales Return</td>
            <td style="width: 10%;">Discount</td>
            <td style="width: 10%;">Net Sales</td>
            <td style="width: 10%;">Incentive</td>
            <td style="width: 10%;display: none;">Commision</td>
            <td style="width: 10%;">Bad Debt Exp.</td>
            <td style="width: 10%;">Collection</td>
            <td style="width: 10%;">Balance</td>
            
          </tr>
          
          
          </thead>
          <tbody>

<?php



$grand_total_balance = 0;
$grand_total_sales=0;
$grand_total_sales_return=0;
$grand_total_discount=0;
$grand_total_incentive=0;
$grand_total_commission=0;
$grand_total_bad_debt=0;
$grand_total_net_sales=0;
$grand_total_collection=0;
?>



<?php
$customer_group=9;

 $query_1 = " SELECT s1._ledger_id,s1._name,s1._code,s1._branch_id,'' as b_name,SUM(s1._balance) as _balance  FROM(

SELECT  t2.id as _ledger_id,t2._name,t2._code,t1._branch_id, SUM(t1._dr_amount-t1._cr_amount) AS _balance
            FROM accounts as t1
            INNER JOIN account_ledgers as t2 on t1._account_ledger=t2.id
               WHERE t1._status=1  AND t2.id IN(".$ledger_id_rows.") AND t1._date <'".$_datex."'  GROUP BY t1._account_ledger
    ) as s1

    GROUP BY s1._ledger_id ORDER BY s1._name ASC ";

$branch_wise_user_and_opening_balances = \DB::select($query_1);



// dump($branch_wise_user_and_opening_balances);
// die();
$sl =1;
$branch_wise_balance = 0;

 $branch_wise_total_sales=0;
$branch_wise_total_sales_return=0;
$branch_wise_total_discount=0;
$branch_wise_total_incentive=0;
$branch_wise_total_commission=0;
$branch_wise_total_bad_debt=0;
$branch_wise_total_collection=0;




?>




@php
 $sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;


@endphp



<?php
 $sub_total_sales=0;
$sub_total_sales_return=0;
$sub_total_discount=0;
$sub_total_incentive=0;
$sub_total_commission=0;
$sub_total_bad_debt=0;
$sub_total_collection=0;
$sub_total_balance=0;


$_balance = $branch_wise_user_and_opening_balances[0]->_balance ?? 0;
$branch_wise_balance += $branch_wise_user_and_opening_balances[0]->_balance ?? 0;
$grand_total_balance += $branch_wise_user_and_opening_balances[0]->_balance ?? 0;
$sub_total_balance += $branch_wise_user_and_opening_balances[0]->_balance ?? 0;

$_ledger_id =$request->_ledger_id; 



//Customer Wise Voucher code find
 $customer_all_vouchers = \DB::table("accounts")
                ->where('_account_ledger',$_ledger_id)
                // ->whereIn("accounts.organization_id",$request_organizations)
                // ->whereIn("accounts._cost_center",$_cost_center_ids)
                // ->where("accounts._branch_id",$_branch_id)
                ->whereBetween('accounts._date', [$_datex, $_datey])
                 //->where('accounts._voucher_code','!=','')
                ->where('accounts._status',1)
                ->pluck('accounts._voucher_code');
// dump($customer_all_vouchers);
// die();



$general_settings             = \DB::table("general_settings")->first();
$account_group_configs        = \DB::table("account_group_configs")->first();
$sales_form_settings          = \DB::table("sales_form_settings")->first();
$sales_return_form_settings   = \DB::table("sales_return_form_settings")->first();
$purchase_form_settings       = \DB::table("purchase_form_settings")->first();

$_cash_group                  = $account_group_configs->_cash_group ?? '';
$_bank_group                  = $account_group_configs->_bank_group ?? '';

$cash_bank_group_array = [];
$cash_bank_group_1 = explode(",", $_cash_group);
$cash_bank_group_2 = explode(",", $_bank_group);

$cash_bank_group_array = array_merge($cash_bank_group_1,$cash_bank_group_2);
$cash_and_bank_ledgers = \DB::table("account_ledgers")->whereIn('_account_group_id',$cash_bank_group_array)->pluck('id')->toArray();

$cash_and_bank_ledgers_string = implode(',',$cash_and_bank_ledgers);
$_sales_discount        =   $sales_form_settings->_default_discount ?? 0;
$_incentice_expneses    = $general_settings->_customer_incentive_ledger ?? 0;
$sales_id               = $sales_form_settings->_default_sales ?? 0;
$sales_return          = $sales_return_form_settings->_default_sales ?? 0;
$sales_commision        = $general_settings->_customer_incentive_ledger ?? 0;
$bad_debt               = $general_settings->_baddebt_ledgers ?? 0;
$_default_purchase      = $purchase_form_settings->_default_purchase ?? 0;


  //  $_sales_discount=7;
  //  $_incentice_expneses=592;
    $sales_returns=[$sales_return,$_default_purchase];
   // $sales_commision=8;
   // $bad_debt=29;

     $collection_ledgers    = [];
     foreach($cash_and_bank_ledgers as $cb_led){
      array_push($collection_ledgers,intval($cb_led));
     }
      array_push($collection_ledgers,intval($sales_id));
      array_push($collection_ledgers,intval($sales_return));
      array_push($collection_ledgers,intval($_sales_discount));
      array_push($collection_ledgers,intval($_incentice_expneses));
      array_push($collection_ledgers,intval($sales_return));
      array_push($collection_ledgers,intval($sales_commision));
      array_push($collection_ledgers,intval($bad_debt));
      array_push($collection_ledgers,intval($_default_purchase));



 $all_data_rows = \DB::table('accounts')
    ->join('account_ledgers', 'account_ledgers.id', '=', 'accounts._account_ledger')
    ->leftJoin('voucher_masters', function($join) {
        $join->on(\DB::raw('voucher_masters._code COLLATE utf8mb4_unicode_ci'), '=', \DB::raw('accounts._voucher_code COLLATE utf8mb4_unicode_ci'));
    })
    ->select(
        "accounts.id",
        "accounts._account_ledger",
        "accounts._voucher_code",
        "accounts._dr_amount",
        "accounts._cr_amount",
        "accounts._narration as _note",
        "accounts._date",
        "voucher_masters._amount",
        "accounts._short_narration",
        "accounts._branch_id",
        "accounts.organization_id",
        "accounts._cost_center"
    )
    ->whereIn('accounts._voucher_code', $customer_all_vouchers)
    ->whereIn('accounts._account_ledger', $collection_ledgers)
    // ->whereIn('accounts.organization_id', $request_organizations)
    // ->whereIn('accounts._cost_center', $_cost_center_ids)
    // ->whereIn('account_ledgers._branch_id', $_branch_ids)
    ->whereBetween('accounts._date', [$_datex, $_datey])
    ->where('accounts._status', 1)
    ->orderBy('accounts._date', 'ASC')
    ->orderBy('accounts.id', 'ASC')
    ->get();

// dump($all_data_rows );
// die();


?>



<tr>
             
          
            <td style="width: 5%;white-space: nowrap;">{{$sl++}}</td>
            <td>{{_view_date_formate($_datex ?? '')}}</td>
            <td style="width: 5%;white-space: nowrap;font-weight: bold;" >   </td>
            <td style="width: 10%;white-space: nowrap;">Opening Balance </td>
            <td style="width: 10%;white-space: nowrap;font-weight: bold;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;"></td>
            <td style="width: 10%;text-align: right;white-space: nowrap;font-weight: bold;">{{_report_amount($branch_wise_user_and_opening_balances[0]->_balance ?? 0)}}</td>
            
          </tr>


@forelse($all_data_rows as $key=>$val)


@php
$__net_sales  = 0;
@endphp
<tr>
             
          
            
            <td style="width: 5%;white-space: nowrap;" rowspan ="">{{($key+1)}} </td>
            <td style="width: 10%;white-space: nowrap;">{!! _view_date_formate($val->_date ?? '') !!}</td>
            <td style="width: 10%;white-space: nowrap;">{!! $val->_voucher_code ?? ''  !!} </td>
             <td style="width: 250px;white-space: nowrap;">{!! $val->_note ?? ''  !!} </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==4 && $val->_cr_amount > 0)
               @php
$sub_total_sales +=$val->_cr_amount ?? 0;
$branch_wise_total_sales +=$val->_cr_amount ?? 0;
$grand_total_sales +=$val->_cr_amount ?? 0;
$_balance += $val->_cr_amount ?? 0;
$sub_total_balance += $val->_cr_amount ?? 0;

$branch_wise_balance += $val->_cr_amount ?? 0;
$grand_total_balance += $val->_cr_amount ?? 0;




               @endphp
              {{ _report_amount($val->_cr_amount) }}

              @php
              $__net_sales  +=$val->_cr_amount ?? 0;
               @endphp
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$sales_returns) && $val->_dr_amount > 0)
               @php
$sub_total_sales_return +=$val->_dr_amount ?? 0;
$branch_wise_total_sales_return +=$val->_dr_amount ?? 0;
$grand_total_sales_return +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;
$__net_sales  -=$val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}

              

              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$_sales_discount && $val->_dr_amount > 0)
               @php
$sub_total_discount +=$val->_dr_amount ?? 0;
$branch_wise_total_discount +=$val->_dr_amount ?? 0;
$grand_total_discount +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;


$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;
$__net_sales  -=$val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif

                @if($val->_account_ledger==$_sales_discount && $val->_cr_amount > 0)
               @php
$sub_total_discount -=$val->_cr_amount ?? 0;
$branch_wise_total_discount -=$val->_cr_amount ?? 0;
$grand_total_discount -=$val->_cr_amount ?? 0;
$_balance += $val->_cr_amount ?? 0;
$sub_total_balance += $val->_cr_amount ?? 0;


$branch_wise_balance += $val->_cr_amount ?? 0;
$grand_total_balance += $val->_cr_amount ?? 0;
$__net_sales  +=$val->_cr_amount ?? 0;


               @endphp
              {{ _report_amount(-$val->_cr_amount) }}
              @endif


            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;"></td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$_incentice_expneses && $val->_dr_amount > 0)
               @php
$sub_total_incentive +=$val->_dr_amount ?? 0;
$branch_wise_total_incentive +=$val->_dr_amount ?? 0;
$grand_total_incentive +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;display: none;">
               @if($val->_account_ledger==$sales_commision && $val->_dr_amount > 0)
               @php
$sub_total_commission +=$val->_dr_amount ?? 0;
$branch_wise_total_commission +=$val->_dr_amount ?? 0;
$grand_total_commission +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;


               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>
            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if($val->_account_ledger==$bad_debt && $val->_dr_amount > 0)
               @php
$sub_total_bad_debt +=$val->_dr_amount ?? 0;
$branch_wise_total_bad_debt +=$val->_dr_amount ?? 0;
$grand_total_bad_debt +=$val->_dr_amount ?? 0;
$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;

               @endphp
              {{ _report_amount($val->_dr_amount) }}
              @endif
            </td>



            <td style="width: 10%;text-align: right;white-space: nowrap;">
               @if(in_array($val->_account_ledger,$cash_and_bank_ledgers) && $val->_dr_amount > 0)
@if($val->_cr_amount !=$val->_amount)
<?php
$cash_back_multiple_entrys = \DB::table("accounts")->where('_voucher_code',$val->_voucher_code)
                                                  ->where("_account_ledger",$_ledger_id)
                                                  ->where('_status',1)
                                                  ->first();

      $sub_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
      $branch_wise_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
      $grand_total_collection +=$cash_back_multiple_entrys->_cr_amount ?? 0;
$_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;
$sub_total_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;

$branch_wise_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;
$grand_total_balance -= $cash_back_multiple_entrys->_cr_amount ?? 0;


?>
{{ _report_amount($cash_back_multiple_entrys->_cr_amount ?? 0) }} 
@else
  @php
$sub_total_collection +=$val->_dr_amount ?? 0;

$_balance -= $val->_dr_amount ?? 0;
$sub_total_balance -= $val->_dr_amount ?? 0;

$branch_wise_balance -= $val->_dr_amount ?? 0;
$grand_total_balance -= $val->_dr_amount ?? 0;
               @endphp
              {{ _report_amount($val->_dr_amount) }}

@endif

             
              @endif
            </td>
           
         
          
            <td style="width: 10%;text-align: right;white-space: nowrap;">{{_report_amount($_balance ?? 0)}}</td>
            
          </tr>

  @empty
@endforelse 
@if(sizeof($all_data_rows) > 0)
<tr>


             
            <th colspan="4" style="width: 5%;text-align: left;">Grand Total</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales_return)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_discount)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_sales-($sub_total_sales_return+$sub_total_discount))}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_incentive)}}</th>
            <th style="width: 10%;text-align: right;display: none;">{{_report_amount($sub_total_commission)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_bad_debt)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_collection)}}</th>
            <th style="width: 10%;text-align: right;">{{_report_amount($sub_total_balance)}}</th>
            
          </tr>       

@endif

          </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="11" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>

  @endif



@endsection

@section('script')

<script type="text/javascript">

    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
    
     $('#reservationdate').datetimepicker({
        format:default_date_formate
    });

     $('#reservationdate_2').datetimepicker({
        format:default_date_formate
    });
     
     var _old_filter = $(document).find("._old_filter").val();
     if(_old_filter==0){
        $(".datetimepicker-input").val(date__today())
        $(".datetimepicker-input_2").val(date__today())
     }


     function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            
          }
     

  })

$(document).on('keyup','._search_ledger_id_ledger',delay(function(e){
  var _gloabal_this = $(this);

  var _text_val = $(this).val().trim();
console.log($(this).val());

  var request = $.ajax({
      url: "{{url('ledger-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
        
            search_html +=`<div class="card"><table class="_filter_ledger_search_table">
            <thead>
            <th>ID</th>
            <th>CODE</th>
            <th>Name</th>
            <th>Proprietor</th>
            <th>Phone</th>
            <th>Balance</th>
            <th>Teritory</th>
            <th>Credit Limit</th>
            </thead>
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="search_row _ledger_search_row" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_ledger" class="_id_ledger" value="${data[i].id}">
                                        </td>
                                        <td>${data[i]?._code}</td>
                                        <td>${data[i]._name}
                                        <input type="hidden" name="_name_leder" class="_name_leder" value="${data[i]._name}">
                                        </td>
                                        <td>${data[i]?._alious}</td>
                                        <td>${data[i]?._phone}</td>
                                        <td>${data[i]?._balance}</td>
                                        <td>${data[i]?._entry_branch?._name}</td>
                                        <td>${data[i]?._credit_limit}</td>
                                        </tr>`;


                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }     
      $(document).find('.search_box').html(search_html);
      $(document).find('.search_box').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

  
 $(document).on('click','._ledger_search_row',function(){
  var _id = $(this).children('td').find('._id_ledger').val();
  var _name = $(this).find('._name_leder').val();
  $(document).find('._ledger_id').val(_id);
  var _id_name = `${_name} `;
  $(document).find('._search_ledger_id_ledger').val(_id_name);

  $('.search_box').hide();
  $('.search_box').removeClass('search_box_show').hide();
})

$(document).on('click',function(){
    var searach_show= $('.search_box').hasClass('search_box_show');
    if(searach_show ==true){
      $('.search_box').removeClass('search_box_show').hide();
    }
})

        

         

</script>
@endsection

