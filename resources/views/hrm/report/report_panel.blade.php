@extends('backend.layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> HRM DASHBOARD </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Layout</a></li>
              <li class="breadcrumb-item active">Top Navigation</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
              	@include('hrm.report.reports_link')
                
                
              </div>
            </div>

            
          </div>
          <div class="col-md-8">
            <div class="card">
              <form action="{{route('hrm_user_report')}}" method="GET" class="form-horizontal" id="report_form" target="__blank">
                @csrf
                  <div class="card-body">
                  <div class="form-group row">

                    <label for="report_name" class="col-sm-2 col-form-label">Report Name</label>
                    <div class="col-sm-10">
                        <select class="form-control report_name" name="report_name" id="report_name"> 
                          <option value="employee_job_card">Employee Job Card</option>
                          <option value="jobcard_staff_assosiate">Jobcard Staff (Assosiate)</option>
                          <option value="movement_registerx">Movement Register</option>
                          <option value="summary_attendance_assosiate">Summary Attendance (Assosiate)</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="emp_id" class="col-sm-2 col-form-label">EMP ID</label>
                    <div class="col-sm-10">
                      <input type="text" name="emp_id" class="form-control emp_id" id="emp_id" placeholder="EMP ID">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="year" class="col-sm-2 col-form-label">Year</label>
                    <div class="col-sm-10">
                      <input type="number" min="0" step="any" name="year" class="form-control year" id="year" placeholder="year">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="period" class="col-sm-2 col-form-label">Month</label>
                    <div class="col-sm-10">
                      <input type="number" min="0" step="any" name="period" class="form-control period" id="period" placeholder="period">
                    </div>
                  </div>
                  
                  </div>

                  <div class="card-footer">
                      <button type="submit" attr_url="{{route('hrm_user_report')}}"  class="btn btn-info show_report">Show Report</button>
                  </div>

                  </form>
            </div>

            
          </div>
          <!-- /.col-md-6 -->
          
          <!-- /.col-md-6 -->
        </div>

        <div class="row" id="report_display_area">
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('script')
<script type="text/javascript">

  $(document).on('click','#show_report',function(){

    var url = $(this).attr('attr_url');
    var formData = $("#report_form").serialize(); // Serialize form data
      $.ajax({
            url: url,
            type: "GET",
            data: formData,
            contentType: "application/json",
            dataType: "HTML",
            success: function(response) {
              console.log(response)
               
            },
            error: function(xhr, status, error) {
                
            }
        });

  })

  
</script>
@endsection