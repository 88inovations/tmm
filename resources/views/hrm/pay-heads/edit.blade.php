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
                    <a class="m-0 _page_name" href="{{ route('pay-heads.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                   
                  </div><!-- /.col -->
                </div><!-- /.row -->
          
        
<div class="message-area">
    @include('backend.message.message')
    </div>


            <div class="card-body p-4" >
               {!! Form::model($data, ['method' => 'PATCH','route' => ['pay-heads.update', $data->id]]) !!}
                <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._payhead')}}:</label>
                                <input type="text" name="_ledger" class="form-control" value="{{old('_ledger',$data->_ledger)}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            
                            <div class="form-group">
                              <label class="mr-2" for="_main_ledger_id">{{__('label._ledger_id')}}:<span class="_required">*</span></label>
                            <input type="text" id="_search_main_ledger_id" name="_search_main_ledger_id" class="form-control _search_main_ledger_id" value="{{_ledger_name($data->_ledger_id ?? '')}}" placeholder="{{__('label._ledger_id')}}" required>

                            <input type="hidden" id="_main_ledger_id" name="_ledger_id" class="form-control _main_ledger_id" value="{{$data->_ledger_id ?? '' }}" placeholder="{{__('label._ledger_id')}}" required>
                            <div class="search_box_main_ledger"> </div>

                                
                          
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._type')}}:</label>
                                <select class="form-control " name="_type" required>
                                  <option value="">Select type</option>
                                  @forelse($payhead_typs  as $key=> $val)
                                  <option value="{{$val->id}}" @if($val->id==$data->_type) selected @endif>{!! $val->_name ?? '' !!}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" @if($data->_status==1) selected @endif>Active</option>
                                  <option value="0" @if($data->_status==0) selected @endif>In Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
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

