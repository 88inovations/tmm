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
                    <a class="m-0 _page_name" href="{{ route('companies.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          <div class="message-area">
    @include('backend.message.message')
    </div>
         
            <div class="card-body p-4" >
                {!! Form::open(array('route' => 'companies.store','method'=>'POST')) !!}
                
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._code')}}:<span class="_required">*</span></label>
                                <input class="form-control" type="text" name="_code" placeholder="{{__('label._code')}}" value="{{old('_name',$data->_code ?? '' )}}" required>
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._name')}}:<span class="_required">*</span></label>
                                <input class="form-control" type="text" name="_name" placeholder="{{__('label._name')}}" value="{{old('_name',$data->_name ?? '' )}}" required>
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._bin')}}:</label>
                                <input class="form-control" type="text" name="_bin" placeholder="{{__('label._bin')}}" value="{{old('_bin',$data->_bin ?? '' )}}" >
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._details')}}:</label>
                                <textarea class="form-control" type="text" name="_details" placeholder="{{__('label._details')}}">{{old('_details',$data->_details ?? '' )}}</textarea>
                                
                            </div>
                        </div>
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._address')}}:</label>
                                <textarea class="form-control" type="text" name="_address" placeholder="{{__('label._address')}}">{{old('_address',$data->_address ?? '' )}}</textarea>
                                
                            </div>
                        </div>
                      
                      <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
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

