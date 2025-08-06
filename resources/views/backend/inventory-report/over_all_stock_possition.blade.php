@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container">
          <div class="card bg-info">
            <div class="card-body " >
              <div class="row">
                <div class="col-md-12">
                  <h3>{{$page_name ?? ''}}</h3>
                </div>
                <div class="col-md-6">
                 <form  action="" method="GET">
                @csrf
                    <div class="row">
@php
$_datex  = $request->_datex ?? date("Y-m-d");
$_datey  = $request->_datey ?? date("Y-m-d");
@endphp
                      
                      <div class="col-md-6">
                      <label>Start Date:</label>
                        <input type="date" name="_datex" class="form-control" value="{{$_datex}}">
                      </div>

                      <div class="col-md-6">
                        <label>AS Date:</label>
                        <input type="date" name="_datey" class="form-control" value="{{$_datey}}">
                      </div>
                      <div class="col-md-12">
                        @php
$item_categories = \DB::table('item_categories')->select('id','_name')->orderBy('_name','ASC')->get();
$_category_id = $request->_category_id ?? 'all';

                        @endphp
                        <label>Item Category:</label>
                        <select class="form-control select2" name="_category_id" >
                          <option value="all">All</option>
                          @forelse($item_categories as $c_key=>$category)
<option value="{{$category->id}}" @if($category->id==$_category_id) selected @endif >{{$category->id ?? ''}} - {{$category->_name ?? ''}}</option>
                          @empty
                          @endforelse
                        </select>

                      </div>
                      
                    </div>
                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         
                        <br><br>
                     </div>
                  </form>
                </div>
              </div>
               
                
              </div>
        <!-- /.row -->
      </div>
    </div>  
@if($request->has('_datex') && $request->has('_datey'))
<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

<section class="invoice" id="printablediv">
    <div class="container">
      <table class="table table-borderd" >
         <thead style="border:0px !important">
          <tr>
            <td colspan="7" style="border:0px !important">
               @include('backend.message.report_header')
            </td>
          </tr>
              <tr>
                <td colspan="7" style="border:0px !important">
              <h3 class="text-center">{{$page_name ?? ''}}</h3>
              
            </td>
          </tr>

          <tr>
             
            <th style="border:1px solid silver;">SL </th>
            <th style="border:1px solid silver;">Item ID </th>
            <th style="border:1px solid silver;">Item Name </th>
            <th style="width: 10%;border:1px solid silver;">Unit</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">Opening</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">Stock In</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">Stock Out</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">Closing</th>
          </tr>
        </thead>
        <tbody>
          @forelse($datas as $category_key=> $category_data)
             <tr>
              <th colspan="7" style="border:1px solid silver;">
               Category: {{ _category_name($category_key) }}
              </th>
            </tr>
           @php
              $_sub_total_opening =0;
              $_sub_total_stockin =0;
              $_sub_total_stockout =0;
              $_sub_total_balance =0;

              $sl_no   = 0;
            @endphp

             @forelse($category_data as $g_value)

            @php
             $_sub_total_opening += $g_value->_opening;
              $_sub_total_stockin += $g_value->_stockin;
              $_sub_total_stockout += $g_value->_stockout;
              $_sub_total_balance += ($g_value->_opening+$g_value->_stockin+$g_value->_stockout);

              $line_balance = ($g_value->_opening+$g_value->_stockin+$g_value->_stockout);

            
            @endphp
            @if($line_balance > 0)
            <tr>
             

            <td style="border:1px solid silver;">{!! ($sl_no+1) !!} </td>
            <td style="border:1px solid silver;">{!! $g_value->_item_id ?? '' !!} </td>
            <td style="border:1px solid silver;">{!! $g_value->_name ?? '' !!} </td>
            <td style="width: 10%;border:1px solid silver;">{!! $g_value->_unit ?? '' !!}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($g_value->_opening) !!}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($g_value->_stockin) !!}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($g_value->_stockout) !!}</td>
            <td style="width: 10%;border:1px solid silver;" class="text-right">{{ _report_amount($g_value->_opening+$g_value->_stockin+$g_value->_stockout) }}</td>
          </tr>
          
         

          @endif

          @empty
          @endforelse
          <tr>
            

            <th colspan="4" class="text-left"  style="border:1px solid silver;">Sub Total </th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_sub_total_opening) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_sub_total_stockin) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_sub_total_stockout) !!}</th>
            <th style="width: 10%;border:1px solid silver;" class="text-right">{!! _report_amount($_sub_total_balance) !!}</th>
          </tr>
          @empty
          @endforelse
        </tbody>
        <tfoot style="border:0px solid #000;">
            <tr style="border:0px solid #000;">
              <td colspan="7" style="border:0px solid #000;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
      </table>
    </div>
  </section>

  @endif
</div>



@endsection



