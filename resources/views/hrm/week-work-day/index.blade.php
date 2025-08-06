@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-sm-12" style="display: flex;">
            <a class="m-0 _page_name" href="#">{!! $page_name ?? '' !!} </a>
            <ol class="breadcrumb float-sm-right ml-2">
              
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   <div class="message-area">
    @include('backend.message.message')
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                 
                 
              </div>
              <div class="card-body">
                <div class="">
                  <table class="table table-bordered _list_table">
                      <thead>
                        <tr>
                         <th>Action</th>
                         <th>Sunday</th>
                         <th>Monday</th>
                         <th>Tuesday</th>
                         <th>Wednesday</th>
                         <th>Thursday</th>
                         <th>Friday</th>
                         <th>Saturday</th>
                      </tr>
                      </thead>
                      <tbody>
                       
                        <tr>
                            
                    <td style="display: flex;">
                           
                                <button  type="button" 
                                  attr_base_edit_url="{{ route('weekworkday.show',$data->id ?? 0) }}"
                                  data-toggle="modal" 
                                  data-target="#commonEntryModal_item" 
                                  class="btn btn-sm btn-default attr_base_edit_url mr-1"><i class="fa fa-eye"></i></button>


                                  <button  type="button" 
                                  attr_base_edit_url="{{ route('weekworkday.edit',$data->id ?? 0) }}"
                                  data-toggle="modal" 
                                  data-target="#commonEntryModal_item" 
                                  class="btn btn-sm btn-default attr_base_edit_url mr-1"><i class="fa fa-pen "></i></button>  
                               
                        </td>

                          <td>{!! $data->_sunday ?? '' !!}</td>
                          <td>{!! $data->_monday ?? '' !!}</td>
                          <td>{!! $data->_tuesday ?? '' !!}</td>
                          <td>{!! $data->_wednesday ?? '' !!}</td>
                          <td>{!! $data->_thursday ?? '' !!}</td>
                          <td>{!! $data->_friday ?? '' !!}</td>
                          <td>{!! $data->_saturday ?? '' !!}</td>
                            
                           
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.d-flex -->

                

                <div class="d-flex flex-row justify-content-end">
                 
                </div>
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection