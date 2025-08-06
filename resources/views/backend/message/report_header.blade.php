<!-- <div style="width: 100%;position: relative;">
            <div class="logo_araa" style="width: 20%;
    float: left;">
               <img src="{{url($settings->logo ?? '')}}" alt="{{$settings->name ?? '' }}" style="width: 120px"  >
            </div>
            <div class="company_name_area" style="width: 38%;
    float: left;">
               <div style="padding-right: 10px;">
                 <div class="company_name_title" style="text-align: right;
    font-size: 26px;
    color: #00ff00;
    font-weight: 900;
    text-decoration: underline;">{{$settings->title ?? '' }}</div>
               <div class="company_sub_title" style="    text-align: right;
    color: #ff0066;
    font-weight: bold;">{{$settings->keywords ?? '' }}</div><br>
               
               </div>
            </div>
            <div class="company_address_area" style="width: 42%;
    float: left;">
              <div style="padding-left:5px;">
                 <div class="head_office">Corporate Office</div>
               <div style="font-size: 14px;">
                 {{$settings->_address ?? '' }}
                  {{$settings->_phone ?? '' }}<br>
                  {{$settings->_email ?? '' }}  
               </div><br>

               <div class="page_copy_araa">
                 
               </div>
              </div>
            </div>
          </div> -->

          <table class="table" style="border:none;width: 100%;">
          <tr>
<?php
$sequence_to_remove = "––------------–--";
?>
            <td style="border:none;width: 100%;text-align: center;">
              <table class="table" style="border:none;">
                <tr style="line-height: 16px;" > <td class="text-center company_name_title " style="border:none;font-size: 24px;padding-bottom: 10px;"><b>{{$settings->name ?? '' }}</b></td> </tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{$settings->_address ?? '' }}</td></tr>
                <tr style="line-height: 16px;" > <td class="text-center" style="border:none;">{{str_replace($sequence_to_remove, "", $settings->_email ?? '') }}<br>{{$settings->_phone ?? '' }}</td></tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><b>{{$page_name}} </b></td> </tr>
                 <tr style="line-height: 16px;" > <td class="text-center" style="border:none;"><strong>Date:{{ $previous_filter["_datex"] ?? '' }} To {{ $previous_filter["_datey"] ?? '' }}</strong></td> </tr>
               
              </table>
            </td>
            
          </tr>
        </table>