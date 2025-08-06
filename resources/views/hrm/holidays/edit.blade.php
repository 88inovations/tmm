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
                    <a class="m-0 _page_name" href="{{ route('holidays.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
         
            <div class="card-body p-4" >
               {!! Form::model($data, ['method' => 'PATCH','route' => ['holidays.update', $data->id]]) !!}
                <div class="row">
                      <div class="com-md-4">
                        <label>Start Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="_datex" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{_view_date_formate($data->_dfrom)}}" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <input type="hidden" name="_old_filter" class="_old_filter" value="1">
                      </div>
                      <div class="col-md-8"></div>
                         
                </div>
                <div class="row">
                      <div class="com-md-4">
                        <label>End Date:</label>
                        <div class="input-group date" id="reservationdate_2" data-target-input="nearest">
                                      <input type="text" name="_datey" class="form-control datetimepicker-input_2" data-target="#reservationdate_2" required value="{{_view_date_formate($data->_dto)}}" />
                                      <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                      </div>
                      <div class="col-md-8"></div>
                         
                </div>
                <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>
                              </div>
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>{{__('label.name')}}</th>
                                            <th>{{__('label.date')}}</th>
                                            <th>{{__('label.type')}}</th>
                                          </thead>
                                          @php
                                          $holiday_details = $data->holiday_details ?? [];
                                          @endphp
                                          <tbody class="area__voucher_details" id="area__voucher_details">
                                            @forelse($holiday_details as $d_val)

                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                                <input type="hidden" name="_detail_id[]" value="{{$d_val->id}}">
                                              </td>
                                              <td>
                                                <input type="text" name="_name[]" class="form-control  width_280_px" placeholder="{{__('label.title')}}" value="{!! $d_val->_name ?? '' !!}">
                                              </td>
                                              <td>
                                                <input type="date" name="_date[]" class="form-control width_250_px _date" placeholder="{{__('label.date')}}" value="{!! $d_val->_date !!}">
                                              </td>
                                              <td>
                                                <select class="form-control" name="_type[]">
                                                  @forelse(full_half() as $fh)
                                                  <option value="{{$fh}}" @if($d_val->_type==$fh) selected @endif >{!! $fh ?? '' !!}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-info" onclick="new_row_holiday(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="3" class="text-right"></td>
                                              
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
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
                        <input type="hidden" name="_detail_id[]" value="0">
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

