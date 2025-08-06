

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
                <tr style="line-height: 16px;" > 
                    <td class="text-center" style="border:none;">
                      <h3>{!! $page_name ?? '' !!}</h3>
                  </td>
              </tr>
            <tr style="line-height: 16px;" >
                 <td class="text-center" style="border:none;">
                       {{__('label._stm_division_id')}} : <b> {{ id_to_cloumn($request->_education_type,'_name','stm_divisions') }}</b>
                  </td>
            </tr>
            <tr style="line-height: 16px;" >
                 <td class="text-center" style="border:none;">
                       {{__('label._admission_class_id')}} : <b> {{ id_to_cloumn($request->_admission_class_id,'_name','stm_classes') }}</b>
                  </td>
            </tr>

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
            <tr style="background-color: #f0f0f0;">
                <th>{{__('label.sl')}}</th>
                <th>{{__('label._roll_no')}}</th>
                <th>{{__('label._name_in_bangla')}}</th>
                <th>{{__('label._name_in_english')}}</th>
                <th>{{__('label._father_name_bangla')}}</th>
                <th>{{__('label._date')}}</th>
                <th>{{__('label._roshid_book_no')}}</th>
                <th>{{__('label._roshid_no')}}</th>
                <th>{{__('label._admission_fee')}}</th>
                <th>{{__('label._tution_fee')}}</th>
                <th>{{__('label._remarks')}}</th>
        </thead>
        <tbody>

            @php
    $_total_admission_fee  = 0;
    $_total_tution_fee     = 0;
            @endphp

            @forelse($datas as $key=> $c)
  @php
   

    $_bill_type  = $c->_bill_type ?? '';
            @endphp

            @php
            if($_bill_type =='_admission_fee'){
                $_total_admission_fee  += $c->_collection_amount ?? 0;

            }
            if($_bill_type =='_tution_fee'){
                $_total_tution_fee     += $c->_collection_amount ?? 0;

            }
            @endphp


            <tr>
                <td>{{ ($key+1) }}</td>
                
                <td>{{ $c->_roll_no ?? '' }}</td>
                <td>{{ $c->_name_in_bangla ?? '' }}</td>
                <td>{{ $c->_name_in_english ?? '' }}</td>
                <td>{{ $c->_father_name_bangla ?? '' }}</td>

                <td>{{ _view_date_formate($c->_date ?? '') }}</td>
                <td>{{ $c->_roshid_book_no ?? '' }}</td>
                <td>{{ $c->_roshid_no ?? '' }}</td>
                <td style="text-align:right;">
                    @if($_bill_type =='_admission_fee')
                    {{ _report_amount($c->_collection_amount ?? 0) }}
                    @endif
                </td>
                <td style="text-align:right;">
                  @if($_bill_type =='_tution_fee')
                    {{ _report_amount($c->_collection_amount ?? 0) }}
                    @endif
                </td>
                <td>{{ $c->_note ?? '' }}</td>

            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center">কোন তথ্য পাওয়া যায়নি</td>
            </tr>
            @endforelse

             <tr style="font-weight:bold; background-color: #ddd;">
                <td colspan="8" style="text-align:right;">মোট</td>
                <td style="text-align:right;">{{ _report_amount($_total_admission_fee ?? 0) }}</td>
                <td style="text-align:right;">{{ _report_amount($_total_tution_fee ?? 0) }}</td>
                <td style="text-align:right;"></td>
                
            </tr>
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