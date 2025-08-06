@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="wrapper print_content">
  <style type="text/css">
  .table td, .table th {
    padding: 0.10rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}


/* Initially setting modal size */
.modal-dialog {
    max-width: 80%; /* Optional: To make it large but not 100% */
    margin: 30px auto;
}

/* Fullscreen modal styling */
.modal-fullscreen .modal-dialog {
    max-width: 100%;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.modal-fullscreen .modal-content {
    height: 100%;
    overflow-y: auto;
}

/* Background color when fullscreen */
.modal-fullscreen .modal-content {
   
}


  </style>
<div class="_report_button_header">
    
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    
     @include('backend.message.message')
    
        <table class="table" style="border:none;width: 100%;">
          <tr>
            
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;font-size: 24px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_phone ?? '' }},{{$settings->_email ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>AS ON: {{ date('d-M-Y H:s a') }}  </strong></td> </tr>
                 
              </table>
            </td>
           
          </tr>
        </table>
       

        <table class="table" style="border:1px solid silver;width: 600px;">
          <tr>
            <th>Customer Outstanding</th>
            <th> : {{_report_amount($total_receivable ?? 0)}}</th>

            <input type="hidden" name="_form_name" class="_form_name" value="receive_payments">
            <input type="hidden" name="_form_type" class="_form_type" value="entry_form">
            

          </tr>
          <tr>
            <th>Supplier Outstanding</th>
            <th> : {{_report_amount($total_payable ?? 0)}}</th>
          </tr>
@php
$net_receiv_payable = (($total_receivable ?? 0)+($total_payable ?? 0));
@endphp
          <tr>
            <th>Net Outstanding @if($net_receiv_payable > 0) (Receivable) @else (Payable) @endif</th>
            <th> : {{_report_amount(($total_receivable ?? 0)+($total_payable ?? 0))}}</th>
          </tr>
        </table>
       

    <!-- Table row -->
     <table class="cewReportTable">
          
          <tbody>
           
          @php
          $grand_total_balance =0;
          @endphp
            @forelse($datas as $key=>$value)
            <tr>
              <th colspan="7" class="text-center">{!! $key ?? '' !!}</th>
            </tr>
              <tr>
                <th style="border:1px solid silver;width: 7%;" class="text-left" >ID</th>
                <th style="border:1px solid silver;width: 10%;" class="text-left" >Group </th>
                <th style="border:1px solid silver;width: 7%;" class="text-left" >Detail </th>
                <th style="border:1px solid silver;width: 30%;" class="text-left" >Code </th>
                <th style="border:1px solid silver;width: 30%;" class="text-left" >Ledger </th>
                <th style="border:1px solid silver;width: 30%;" class="text-left" >Phone </th>
                <th style="border:1px solid silver;width: 20%;" class="text-left" >Ledger Balance</th>
              </tr>
@php
$sub_total_balance =0;
@endphp
                  @forelse($value as $k_key=>$data)

@php
$grand_total_balance    +=$data->_balance ?? 0;
$sub_total_balance      +=$data->_balance ?? 0;
@endphp
                    <tr>
                        <td style="border:1px solid silver;width: 7%;" class="text-left" >{{($k_key+1)}}</td>
                        <td style="border:1px solid silver;width: 10%;white-space: nowrap;" class="text-left" >{!! $data->_group_name ?? '' !!} </td>
                        <td style="border:1px solid silver;width: 7%;" class="text-left" >
                            @can('so_wise_due_invoice')
                            <button type="button" 
                         class="btn btn-sm btn-success customer_wise_due_invoice customer_wise_due_invoice__{{$data->_account_ledger}} mr-3 ml-3" 
                         attr_id="{{$data->_account_ledger}}"
                         
                         attr_url="{{url('customer_wise_due_collection')}}"
                         data-toggle="modal" 
                         data-target="#exampleModalSecond" title="Invoice Wise Due Collection">Details </button>

                         @endcan

                         </td>
                        <td style="border:1px solid silver;width: 30%;" class="text-left" >{!! $data->_code ?? '' !!} </td>
                        <td style="border:1px solid silver;width: 30%;" class="text-left" >{!! $data->_ledger_name ?? '' !!} </td>
                        <td style="border:1px solid silver;width: 30%;" class="text-left" >{!! $data->_phone ?? '' !!} </td>
                        <td style="border:1px solid silver;width: 20%;" class="text-left" >{{_report_amount($data->_balance ?? 0)}}</td>
                      </tr>
                  @empty
                  @endforelse

               <tr>
                <th colspan="6" class="text-left" >{!! $key ?? '' !!}</th>
                <th style="border:1px solid silver;width: 20%;" class="text-left" >{{_report_amount($sub_total_balance ?? 0)}}</th>
              </tr>

              @empty
              @endforelse

              <tr>
                <th colspan="6" class="text-left" >Net Balance</th>
                <th style="border:1px solid silver;width: 20%;" class="text-left" >{{_report_amount($grand_total_balance ?? 0)}}</th>
              </tr>
          
          </tbody>
          
        </table>

      

    
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')

<script type="text/javascript">
   $(document).on("click", ".customer_wise_due_invoice", function() {
    var _id = $(this).attr("attr_id");
    var _form_name = 'receive_payments';
    var _form_type = 'entry_form';
    var _master_id = 0;

    var url = $(this).attr("attr_url");
    $(document).find("#exampleModalSecondLabel").text('Customer Wise Due Invoice Details');

    // Make the modal fullscreen when clicked
    $(document).find("#exampleModalSecond").addClass('modal-fullscreen');

    var request = $.ajax({
        url: url,
        method: "GET",
        data: { _id, _form_name,_form_type, _master_id, url },
        dataType: "HTML"
    });

    request.done(function(result) {
        $(document).find("#commonEntryModalFormSecond").html(result);
    });
});

// Close button functionality to remove fullscreen
$(document).on("click", ".commonModalClose", function() {
    $(document).find("#exampleModalSecond").removeClass('modal-fullscreen');
});

// Add event listener for clicking outside of the modal content (backdrop)
$(document).on("click", "#exampleModalSecond", function(e) {
    if (e.target === this) {  // If clicked outside of modal content (backdrop)
        $(document).find("#exampleModalSecond").removeClass('modal-fullscreen');
    }
});



</script>

@endsection
