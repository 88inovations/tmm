
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
  </style>
<div class="_report_button_header">
    <a class="nav-link"  href="{{url('ledger-report')}}" role="button"><i class="fas fa-search"></i></a>
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <!-- title row -->
    
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col text-center">
        <h2 class="page-header">
            {{$settings->name ?? '' }}
          
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-12 invoice-col text-center">
        <h3 class="text-center"><b>{{$page_name ?? ''}}</b></h3>
      </div>
      <!-- /.col -->
      
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <table class="cewReportTable" >
          <thead>
          <tr>
            <td>&emsp;&emsp;&emsp;&emsp;<b>Title</b></th>
          </tr>
          <tbody>
            @php
            $data_level_one = \DB::table('main_account_head')->orderBy('id','ASC')->get();
            @endphp
            @forelse($data_level_one as $key=> $value)
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;<b> {!! $value->id ?? '' !!}. {!! $value->_name ?? '' !!}</b></td>
            </tr>
             @php
            $data_level_twos = \DB::table('account_heads')->where('_account_id',$value->id)->where('_parent_id',0)->orderBy('_name','ASC')->get();
            @endphp
            @forelse($data_level_twos as $_type_value)
            <tr>
             
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>{!! $_type_value->_code ?? '' !!}. {!! $_type_value->_name ?? '' !!}</b></td>
            </tr>
            @if($_type_value->_has_child ==1)<!-- Has Child -->
            @php
            $data_level_threes = \DB::table('account_heads')->where('_parent_id',$_type_value->id)->orderBy('_name','ASC')->get();
            @endphp

            @forelse($data_level_threes as $_group_value)
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>{!! $_group_value->_code ?? '' !!}. {!! $_group_value->_name ?? '' !!}</b>
              </td>
            </tr>
@php
            $data_level_fours = \DB::table('account_groups')->where('_account_head_id',$_group_value->id)->orderBy('_name','ASC')->get();
            @endphp
@forelse($data_level_fours as $_fours)
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{!! $_fours->_code ?? '' !!}. {!! $_fours->_name ?? '' !!}
              </td>
            </tr>
@empty
@endforelse            

            @empty
            @endforelse

            @else
@php
            $data_level_fours = \DB::table('account_groups')->where('_account_head_id',$_type_value->id)->orderBy('_name','ASC')->get();
            @endphp
@forelse($data_level_fours as $_fours)
            <tr>
              <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{!! $_fours->_code ?? '' !!}. {!! $_fours->_name ?? '' !!}
              </td>
            </tr>
@empty
@endforelse

            @endif <!-- ENd Has Child -->


            @empty
            @endforelse

            @empty
            @endforelse
          </tbody>
          <tfoot>
           
          </tfoot>
        </table>
     

  
    <!-- /.row -->
  </section>

</div>
@endsection

@section('script')

<script type="text/javascript">

 function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
         

</script>
@endsection