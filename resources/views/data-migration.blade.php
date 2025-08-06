@extends('backend.layouts.app')
@section('title',$settings->title ?? 'Attandance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Data Migration from SQL Server to MySQL</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('data-migration.migrate') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="migration_date" class="col-md-4 col-form-label text-md-right">Select Date</label>

                            <div class="col-md-6">
                                <input id="migration_date" type="date" class="form-control @error('migration_date') is-invalid @enderror" name="migration_date" value="{{ old('migration_date') }}" required>

                                @error('migration_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Migrate Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection