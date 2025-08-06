@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('report-gross-profit')}}" method="POST">
                @csrf
                    <div class="row">
                      @include('basic.report_date_filter')
                      @include('basic.org_report')
                   
                  @if(sizeof($stores) > 1)
                      <div class="col-md-12">
                        <label>Store:</label>
                         <select class="form-control  _store multiple_select" multiple name="_store[]" size='2'  >
                                            
                            @forelse($stores as $store )
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
                      <label>Categories:<span class="_required">*</span></label><br></div>
                     <div class="row">
                        <select class="form-control  _item_category multiple_select" multiple name="_item_category[]" size='6'  >
                                            
                            @forelse($_item_categories as $_category )
                            <option value="{{$_category->id}}" 
                              @if(isset($previous_filter["_item_category"]))
                              @if(in_array($_category->id,$previous_filter["_item_category"])) selected @endif
                                 @endif
                              > {{ $_category->_parents->_name ?? '' }}/{{ $_category->_name ?? '' }}</option>
                            @empty
                            @endforelse
                          </select>
                      
                    </div>
                    <div class="row">
                      <label>Items:</label><br></div>
                     <div class="row">
                         <select id="_item_id" class="form-control  _item_id multiple_select" multiple name="_item_id[]"  size='6' >
                          @if(isset($request->_item_id))

                           
                          @endif
                         </select>
                     </div>

                     <div class="row mt-3">
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                            <button type="submit" class="btn btn-success mt-2 form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Report</button>
                        </div>
                         <div class="col-xs-6 col-sm-6 col-md-6 ">
                                     <a href="{{url('reset-gross-profit')}}" class="btn btn-danger mt-2 form-control" title="Search Reset"><i class="fa fa-retweet mr-2"></i> Reset</a>
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
          url: "{{url('stock-ledger-cat-item')}}",
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

