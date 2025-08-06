
@if ($message = Session::get('success'))
<div class="alert alert-outline-success " style="padding: 5px;" role="alert">{!! $message !!}</div>
@endif
@if ($message = Session::get('danger'))
<div class="alert alert-outline-danger " style="padding: 5px;" role="alert">{!! $message !!}</div>
@endif
@if ($message = Session::get('info'))
<div class="alert alert-outline-info " style="padding: 5px;" role="alert">{!! $message !!}</div>
@endif
@if ($message = Session::get('warning'))
<div class="alert alert-outline-warning " style="padding: 5px;" role="alert">{!! $message !!}</div>
@endif
@if ($message = Session::get('primary'))
<div class="alert alert-outline-primary " style="padding: 5px;" role="alert">{!! $message !!}</div>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error-message">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif