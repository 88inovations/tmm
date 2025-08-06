@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="{{ route('cat_wise_ta_bills.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
         <div class="message-area">
    @include('backend.message.message')
    </div>
            <div class="card-body p-4" >
                {!! Form::open(array('route' => 'cat_wise_ta_bills.store','method'=>'POST')) !!}
                
@php
                          $currentYear = date('Y');
                          $_year = $data->_fescal_year ?? $currentYear;
                          $year_start = ($currentYear - 10);
                      @endphp

                      <div class="form-group row">
                          <label class="col-md-2" for="_fescal_year">{{ __('label._year') }}</label>
                          <div class="col-md-5 display_flex">
                          <select name="_fescal_year" class="form-control" required>
                              @for ($i = $year_start; $i <= $currentYear; $i++)
                                  <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                      </div>

                  <div class="form-group row">
                                <label class="col-md-2">{!!__('label._jobtitle_id') !!}:<span class="_required">*</span></label>
                        <div class="col-md-5 display_flex">
                                <select class="form-control sub_jobtitle_id" name="_designation_id" required >
                                  <option value="">{{__('label.select')}}</option>
                                  @forelse($designations as $val)
                                  <option value="{{$val->id}}" @if(old('_designation_id')==$val->id) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                                <button type="button"  
                                 attr_base_create_url="{{url('hrm-emp-category_sub_new')}}"
                                 attr_modal_name="#exampleModalSecond"
                                 attr_content_display_area="#commonEntryModalFormSecond"
                                 attr_modal_title_area="#exampleModalSecondLabel"
                                attr_save_url="{{url('sub_entry_data_save')}}"
                                 attr_modal_title="{!!__('label._designation_id') !!}"
                                _column_name="_name"
                                 attr_table_name="designations"
                                 attr_select_option_class=".sub_jobtitle_id"
                                  class="btn btn-sm btn-warning sub_form_data_entry mr-1">+</button>
                            </div>
                        </div>

                      <div class="form-group row">
                            
                                 <label class="col-md-2">{{__('label._da_bill')}}:<span class="_required">*</span></label>
                                 <div class="col-md-5 display_flex">
                                <input class="form-control" type="number" min="0" step="any" name="_da_bill" placeholder="{{__('label._da_bill')}}" value="{{old('_da_bill',$data->_da_bill ?? 0 )}}" required>
                            </div>
                        </div>
                      <div class="form-group row">
                            
                                 <label class="col-md-2">{{__('label._moto_bill')}}:<span class="_required">*</span></label>
                                 <div class="col-md-5 display_flex">
                                <input class="form-control" type="number" min="0" step="any"  name="_moto_bill" placeholder="{{__('label._moto_bill')}}" value="{{old('_moto_bill',$data->_moto_bill ?? 0 )}}" required>
                            </div>
                        </div>
                      
                      
                      
                      
                            <div class="form-group row">
                                <label class="col-md-2">{{__('label._status')}}:</label>
                                  <div class="col-md-5 display_flex">
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                              </div>
                            </div>
                        
                
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
                        <br><br>
                    
                 
                    
                    
                     
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



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




    function new_row_holiday(event){

      var _row =`<tr class="_voucher_row">
                      <td>
                        <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                      </td>
                      <td>
                        <input type="text" name="_name[]" class="form-control  width_280_px" placeholder="{{__('label.title')}}">
                      </td>
                      <td>
                        <input type="date" name="_date[]" class="form-control width_250_px _date" placeholder="{{__('label.date')}}">
                      </td>
                      <td>
                        <select class="form-control" name="_type[]">
                          @forelse(full_half() as $fh)
                          <option value="{{$fh}}">{!! $fh ?? '' !!}</option>
                          @empty
                          @endforelse
                        </select>
                      </td>
                    </tr>`;

      $(document).find('.area__voucher_details').append(_row);

    }

  

  

     

         

</script>
@endsection

