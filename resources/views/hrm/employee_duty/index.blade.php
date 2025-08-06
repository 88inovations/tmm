@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="{{ route('employee_duty.index') }}">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
             
            </ol>
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0 mt-1">
                  <div class="row">
                   @php
                   @endphp
                    <div class="col-md-4">
                      @include('hrm.employee_duty.search')
                    </div>
                    <div class="col-md-8">
                      
                    </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         
                         <th>SL</th>
                         <th>ID</th>
                         <th>{{__('label.entry_type')}}</th>
                         <th>{{__('label._branch_id')}}</th>
                         <th>{{__('label._employee_id')}}</th>
                         <th>{{__('label.username')}}</th>
                         <th>{{__('label._date')}}</th>
                         <th>{{__('label._time')}}</th>
                         <th>{{__('label.full_address')}}</th>
                         <th>{{__('label.state')}}</th>
                         <th>{{__('label.road')}}</th>
                         <th>{{__('label.postcode')}}</th>
                         <th>{{__('label.borough')}}</th>
                         <th>{{__('label.country')}}</th>
                         
                         <th>Created At</th>
                         <th>Updated At</th>
                                
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $data->id ?? '' }}</td>
                            <td>{{ $data->entry_type ?? '' }}</td>
                            <td>{{ $data->_branch->_name ?? '' }}</td>
                            <td>{{ $data->_employee->_name ?? '' }}</td>
                            <td>{{ $data->_user->name ?? '' }}</td>
                            <td>{{ _view_date_formate($data->_date ?? '') }}</td>
                            <td>{{ _time_formate($data->_time ?? '') }}</td>
                            <td>{{ $data->full_address ?? '' }}</td>
                            <td>{{ $data->state ?? '' }}</td>
                            <td>{{ $data->road ?? '' }}</td>
                            <td>{{ $data->postcode ?? '' }}</td>
                            <td>{{ $data->borough ?? '' }}</td>
                            <td>{{ $data->country ?? '' }}</td>
                            <td>{{ $data->created_at ?? '' }}</td>
                            <td>{{ $data->updated_at ?? '' }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 {!! $datas->render() !!}
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>

       <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid" id="modalImage" src="">
                </div>
            </div>
        </div>
    </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection


@section("script")

<script type="text/javascript">

  $(function () {
   var default_date_formate = `{{default_date_formate()}}`
   var _datex = `{{$request->_datex ?? '' }}`
   var _datey = `{{$request->_datey ?? '' }}`
    
     $('#reservationdate_datex').datetimepicker({
        format:'L'
    });
     $('#reservationdate_datey').datetimepicker({
         format:'L'
    });
 


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




  

function after_request_date__today(_date){
            var data = _date.split('-');
            var yyyy =data[0];
            var mm =data[1];
            var dd =data[2];
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

});
</script>
@endsection