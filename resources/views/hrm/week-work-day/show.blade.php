
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 _page_name">{!! $page_name ?? '' !!} </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            
              
            </ol>
          </div><!-- /.col -->
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
             
              <div class="card-body table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td>Sunday</td>
                    <td>{!! $data->_sunday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Monday</td>
                    <td>{!! $data->_monday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Tuesday</td>
                    <td>{!! $data->_tuesday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Wednesday</td>
                    <td>{!! $data->_wednesday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Thursday</td>
                    <td>{!! $data->_thursday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Friday</td>
                    <td>{!! $data->_friday ?? '' !!}</td>
                  </tr>
                  <tr>
                    <td>Saturday</td>
                    <td>{!! $data->_saturday ?? '' !!}</td>
                  </tr>
                </table>
                
               
                        
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>
