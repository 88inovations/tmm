

<div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>


<section class="invoice p-2" id="printablediv">
    

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
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  <h3>{!! $page_name ?? '' !!}</h3>
              </td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">
                  Date & Time: {{ date('d-m-Y H:s a') }}
              </td></tr>


                
              </table>
            </td>
            
          </tr>
        </table>
        
      

    <!-- Table row -->
   <table class="cewReportTable">
          
 <thead>
        <tr>
                <th>SL</th>
                <th>Division</th>
                <th>Class</th>
                <th>Name</th>
                <th>{{__('label._name_in_english')}}</th>
                <th>Roll</th>
                @for ($i = 1; $i <= 12; $i++)
                    <th>{{ strtoupper(DateTime::createFromFormat('!m', $i)->format('M')) }}</th>
                @endfor
                <th>Total</th>
            </tr>
    </thead>
    <tbody>
            @php
            $sl=1;
                $monthTotals = array_fill(1, 12, 0);
                $grandTotal = 0;
            @endphp

            @forelse ($reportData as $row)
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $row['division'] }}</td>
                    <td>{{ $row['class'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['_name_in_english'] }}</td>
                    <td>{{ $row['roll'] }}</td>
                    @for ($i = 1; $i <= 12; $i++)
                        @php
                            $monthTotals[$i] += $row['monthly'][$i];
                        @endphp
                        <td>{{ $row['monthly'][$i] > 0 ? _report_amount($row['monthly'][$i]) : '' }}</td>
                    @endfor
                    <td>
                        @php $grandTotal += $row['total']; @endphp
                        {{ _report_amount($row['total']) }}
                    </td>
                </tr>
            @empty
            @endforelse

            {{-- Total Row --}}
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="6" style="text-align:right">Total</td>
                @for ($i = 1; $i <= 12; $i++)
                    <td>{{ _report_amount($monthTotals[$i]) }}</td>
                @endfor
                <td>{{ _report_amount($grandTotal) }}</td>
            </tr>
        </tbody>
          <tfoot>
            <tr style="border:none;">
              <td colspan="17" style="border: none;">
                 @include('backend.message.invoice_footer')
              </td>
            </tr>
          </tfoot>
        </table>


    
    <!-- /.row -->
  </section>