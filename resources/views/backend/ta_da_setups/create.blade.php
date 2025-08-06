@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
@php
$__user= Auth::user();
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
              <a class="m-0 _page_name" href="{{ route('ta_da_setups.index') }}">{!! $page_name ?? '' !!} </a>
           
          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
             
                
              <li class="breadcrumb-item ">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('ta_da_setups.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                 
                   @include('backend.message.message')
                    
              </div>
            
              <div class="card-body">
               <form action="{{route('ta_da_setups.store')}}" method="POST" class="purchase_form" >
                @csrf
                
                  <div class="row">
                     

                       <div class="col-xs-12 col-sm-12 col-md-3 ">
                        
                            <div class="form-group ">
                                   <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
                                  <select class="form-control _master_organization_id" name="organization_id" required >
                              @if(sizeof($permited_organizations) > 1)
                              <option value=""><---Select---></option>
                              @endif
                                     
                                     @forelse($permited_organizations as $val )
                                     <option value="{{$val->id}}" @if(isset($request->organization_id)) @if($request->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                                     @empty
                                     @endforelse
                                   </select>
                               </div>
                             
                        </div>
                        
                   

                       @php
                          $currentYear = date('Y');
                          $_year = $request->_year ?? $currentYear;
                          $year_start = ($currentYear - 10);
                      @endphp

                      <div class="col-xs-12 col-sm-12 col-md-3">
                          <label class="mr-2" for="_fescal_year">{{ __('label._year') }}</label>
                          <select name="_fescal_year" class="form-control" required>
                              @for ($i = $year_start; $i <= $currentYear; $i++)
                                  <option value="{{ $i }}" @if ($i == $_year) selected @endif>{{ $i }}</option>
                              @endfor
                          </select>
                      </div>
                        
                          <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <label class="mr-2" for="_sloat_min">Min Collection Amount:<span class="_required">*</span></label>
                            <input type="number" min="0" step="any" id="_sloat_min" name="_sloat_min" class="form-control _sloat_min " value="{{old('_sloat_min')}}" >
                        </div>
                          <div class="col-xs-12 col-sm-12 col-md-3 ">
                            <label class="mr-2" for="_sloat_max">Max Collection Amount:<span class="_required">*</span></label>
                            <input type="number" min="0" step="any" id="_sloat_max" name="_sloat_max" class="form-control _sloat_max " value="{{old('_sloat_max')}}">
                        </div>
                        @php
$_type  = old('_type');
$_status  = old('_status') ?? 1;
                        @endphp
                        <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_type">{{__('label._type')}}</label>
                              <select class="form-control _type" name="_type">
                                  <option value="Percentage" @if($_type=='Percentage') selected @endif>Percentage</option>
                                  <option value="Fixed" @if($_type=='Fixed') selected @endif>Fixed</option>
                                </select>
                            </div>
                        </div>

                          <div class="col-xs-12 col-sm-12 col-md-2 _ta_rate_row">
                            <label class="mr-2" for="_ta_rate">Tax Rate%:</label>
                            <input type="text" id="_ta_rate" name="_ta_rate" class="form-control _ta_rate " value="{{old('_ta_rate')}}">
                        </div>
                        
                         
                          <div class="col-xs-12 col-sm-12 col-md-2 _fixed_amount_row">
                            <label class="mr-2" for="_fixed_amount">Fixed Amount:</label>
                            <input type="text" id="_fixed_amount" name="_fixed_amount" class="form-control _fixed_amount " value="{{old('_fixed_amount')}}" >
                        </div>
                        
                         
                         <div class="col-xs-12 col-sm-12 col-md-2 ">
                            <div class="form-group">
                              <label class="mr-2" for="_status">{{__('label._status')}}</label>
                              <select class="form-control" name="_status">
                                  <option value="1" @if($_status==1) selected @endif>Active</option>
                                  <option value="0" @if($_status==0) selected @endif>In Active</option>
                                </select>
                            </div>
                        </div>
                         
                        
                        
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>
                        <br><br>
                        
                    </div>
                    {!! Form::close() !!}
                
              </div>
            </div>
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>



</div>

@endsection

@section('script')

<script type="text/javascript">

  var after_desimal=4;

 

</script>
@endsection

