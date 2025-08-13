@extends('backend.layouts.app')

@section('content')
<div class="content">
<div class="container-fluid">
    <h4>Class-wise Student Attendance Report</h4>

    <form method="GET" action="">
        <div class="row">
            <div class="col-md-3">
                <label>Date:</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" required>
            </div>
            <div class="col-md-3">
                <label>Division:</label>
                <select name="division_id" class="form-control" required>
                    <option value="">Select Division</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                            {{ $division->_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Class:</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mt-4">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    @if(!empty($reports) && count($reports) > 0)
        
        <div class="_report_button_header">
    
    <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>

    <div id="printablediv">
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Student Roll</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th>Class</th>
                    <th>Date</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $r)
                    <tr>
                        <td>{{ $r->student_roll }}</td>
                        <td>{{ $r->student_name }}</td>
                        <td>{{ $r->division_name }}</td>
                        <td>{{ $r->class_name }}</td>
                        <td>{{ $r->date ? \Carbon\Carbon::parse($r->date)->format('Y-m-d') : '' }}</td>
                        <td>{{ $r->in_time }}</td>
                        <td>{{ $r->out_time }}</td>
                        <td>{{ $r->remarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(request()->filled('date') && request()->filled('class_id'))
        <div class="alert alert-warning mt-4">No attendance records found for this date & class.</div>
    @endif
</div>
</div>
@endsection
