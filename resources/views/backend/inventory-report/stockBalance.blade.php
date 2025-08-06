@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="text-center">{{ $page_name ?? '' }}</h4>
                 @include('backend.message.message')
            </div>
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('report-stock-balance')}}" method="POST">
                @csrf
                    <div class="row">
                      
                      @include('basic.org_report')
                   
                  @if(sizeof($permited_stores) > 0)
                      <div class="col-md-12">
                        <label>Store:</label>
                         <select class="form-control width_150_px _store multiple_select" multiple name="_store[]" size='2'  >
                                            
                            @forelse($permited_stores as $store )
                            <option value="{{$store->id}}" 
                              @if(isset($previous_filter["_store"]))
                              @if(in_array($store->id,$previous_filter["_store"])) selected @endif
                                 @endif
                              > {{ $store->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      </div>
                   @endif 
                  
                    </div>
                    <div class="row">
                      <label>Manufacture Company:</label><br>
                        <select class="form-control width_150_px _manufacture_company select2" multiple  name="_manufacture_company[]"   >
                            @forelse($manufactures as $man_val )
                            <option value="{{$man_val->_manufacture_company}}" 

                              @if(isset($previous_filter["_manufacture_company"]))
                              @if(in_array($man_val->_manufacture_company,$previous_filter["_manufacture_company"])) selected @endif
                                 @endif

                              > {{$man_val->_manufacture_company}}</option>
                            @empty
                            @endforelse
                          </select>
                      
                    </div>
                    
                     <br>
                     <div class="row">
                         <select id="_with_zero" class="form-control  _with_zero " name="_with_zero"  >
                           <option value="1" @if(isset($previous_filter["_with_zero"])) @if($previous_filter["_with_zero"] ==1) selected @endif @endif >Without Zero QTY</option>
                           <option value="0" @if(isset($previous_filter["_with_zero"])) @if($previous_filter["_with_zero"] ==0) selected @endif @endif>With Zero QTY</option>
                           <option value="2" @if(isset($previous_filter["_with_zero"])) @if($previous_filter["_with_zero"] ==2) selected @endif @endif>Only Zero QTY</option>
                         
                         </select>
                     </div>
                     <br>
                     

                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('reset-stock-possition')}}" class="btn btn-danger form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> </a>
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

    var _item_category_ids = $(document).find('._item_category').val();
    if(_item_category_ids.length > 0){
      _category_base_items(_item_category_ids);
    }

$(document).find('._item_category').on('change',function(){
    var _category_id = $(this).val();
    _category_base_items(_category_id);
    
  })

    function _category_base_items(_category_id){
      var request = $.ajax({
          url: "{{url('stock-possition-cat-item')}}",
          method: "GET",
          data: { _category_id : _category_id },
          dataType: "HTML"
        });
      request.done(function( result ) {
        $("#_item_id").html(result);
        });
         
        request.fail(function( jqXHR, textStatus ) {
         console.log(textStatus)
        });
    }
     

  })

  


        

         

</script>
@endsection

