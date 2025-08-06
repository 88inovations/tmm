@extends('backend.layouts.app')
@section('title',$page_name ?? '')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">🕵️ Audit Logs</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('audit_logs') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-3">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
         <div class="col-md-3">
        <label for="model" class="form-label">Model</label>
        <select name="model" id="model" class="form-control">
            <option value="">-- All Models --</option>
            @foreach ($modelTypes as $type)
                <option value="{{ $type }}" @selected(request('model') == $type)>
                    {{ class_basename($type) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
    <label for="limit" class="form-label">Show</label>
    <select name="limit" id="limit" class="form-control">
        <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
        <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
        <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
        <option value="all" {{ request('limit') == 'all' ? 'selected' : '' }}>All</option>
    </select>
</div>
        <div class="col-md-3 d-flex mt-2">
            <button type="submit" class="btn btn-primary mr-2">🔍 Filter</button>
            <a href="{{ route('audit_logs') }}" class="btn btn-outline-secondary">🔄 Reset</a>
        </div>
    </form>

    <!-- Logs Table -->
    <div class="table-responsive shadow-sm rounded border">
        <table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>User</th>
            <th>Model (Table)</th>
            <th>Model ID</th>
            <th>Changed Fields</th>
        </tr>
    </thead>
    <tbody>
        @forelse($logs as $key=>$log)
            <tr>
                <td>{{ ($key+1) }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td>{{ class_basename($log->auditable_type) }}</td>
                <td>{{ $log->auditable_id }}</td>
                <td>
    @php
        $changes = array_keys($log->new_values ?? []);
    @endphp

    @if (count($changes))
        <ul class="list-unstyled mb-0 small">
            @foreach ($changes as $field)
                @php
                    $old = $log->old_values[$field] ?? 'N/A';
                    $new = $log->new_values[$field] ?? 'N/A';
                @endphp
                @if ($old != $new)
                    <li>
                        <strong>{{ ucwords(str_replace('_', ' ', $field)) }}</strong>:
                        <span class="text-danger">{{ $old }}</span>
                        →
                        <span class="text-success">{{ $new }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <span class="text-muted">No changes</span>
    @endif
</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No updated records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
    </div>

    <!-- Pagination -->
   
        @if ($limit !== 'all')
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        @endif
    
</div>
@endsection
