 
  @if (count($errors) > 0)
                           <div class="alert  ">
                            
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color: red;">{!! $error  !!}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                  @if ($message = Session::get('success'))
                    <div class="alert  ">
                      <p>{!! $message  !!}</p>
                      
                    </div>
                    @endif
                  @if ($message = Session::get('danger'))
                    <div class="alert  _required _over_qty">
                      <p>{!! $message  !!}</p>
                    </div>
                    @endif
                  @if ($message = Session::get('error'))
                    <div class="alert  _required _over_qty">
                      <p>{!! $message  !!}</p>
                    </div>
                    @endif

                    @if(isset($__message))

                      <h1 class="text-center _required">{!!$__message ?? '' !!}</h1>
                    @endif
