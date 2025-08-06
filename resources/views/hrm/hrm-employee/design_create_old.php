@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('item-information.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('item-information-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('item-information.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
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
            <div class="col-md-12">
<div class="card">
<div class="card-header p-2">
<ul class="nav nav-pills">
<li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">{{__('Professional Details')}}</a></li>
<li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">{{__('Pricing Personal Details')}}</a></li>
<li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">{{__('Salary Details')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_education')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_emergencies')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_empaddresses')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_experiences')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_guarantors')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_jobcontracts')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_languages')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_nominees')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_rewards')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_trainings')}}</a></li>
<li class="nav-item "><a class="nav-link" href="#hrm_education" data-toggle="tab">{{__('hrm_transfers')}}</a></li>
</ul>
</div>
<div class="card-body">
  
                {!! Form::open(array('route' => 'hrm-employee.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
<div class="tab-content">
    
<div class="tab-pane active" id="tab1">
    
    @include('hrm.hrm-employee.profesonal_details')
    
   
</div><!-- End fo Tab One -->

<div class="tab-pane" id="tab2"><!-- Starting Point Two -->
    
   
    
    
</div><!-- End of Second Tab -->

<div class="tab-pane" id="tab3"><!-- Starting point tab 3 -->


    
    <div class="form-group">
        <label class="col-sm-2 col-form-label">Image:</label>
        <div class="col-sm-6">
       <input type="file" accept="image/*" onchange="loadFile(event,1 )"  name="_image" class="form-control">
       <img id="output_1" class="banner_image_create" src="{{asset('/')}}{{$settings->logo ?? ''}}"  style="max-height:100px;max-width: 100px; " />
    </div>
</div>


</div><!-- End of Tab Three -->
<div class="tab-pane " id="hrm_education">
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{__('label.organization_id')}}</th>
            <th>{{__('label._branch_id')}}</th>
            <th>{{__('label._cost_center_id')}}</th>
            <th>{{__('label._store_id')}}</th>
            <th>{{__('label._qty')}}</th>
            <th>{{__('label._cost_rate')}}</th>
            <th>{{__('label._sales_rate')}}</th>
            <th>{{__('label._amount')}}</th>
        </tr>
    </thead>
    <tbody class="opeing_body">
        <tr>
            <td>
            <a href="#none" class="btn btn-default _opening_row_remove"><i class="fa fa-trash"></i></a>
          </td>
           
            
            <td>
                 <input type="number" step="any" min="0"  name="_opening_qty[]" class="form-control _opening_qty _common_keyup_opening" value="0" placeholder="Opening QTY" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_opening_rate[]" class="form-control _opening_rate _common_keyup_opening" value="0" placeholder="Opening Cost Rate" >
            </td>
            <td>
                 <input type="number" step="any" min="0"  name="_openig_sales_rate[]" class="form-control" value="0" placeholder="Opening Sales Rate" >
            </td>
            <td>
                <input type="number" step="any" min="0"  name="_openig_amount[]" class="form-control _opening_amount" value="0" readonly >
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
                <th colspan="2">
                    <a href="#none" class="btn btn-default" onclick="addNewRowForOpenig(event)"><i class="fa fa-plus"></i></a>
                  </th>
           
            <th colspan="3">{{__('label._total')}}</th>
            <th>
                <input type="text" name="_total_opening_qty" class="form-control _total_opening_qty" value="0" readonly>
            </th>
            <th></th>
            <th></th>
            <th>
                 <input type="text" name="_total_opening_amount" class="form-control _total_opening_amount" value="0" readonly>
            </th>
        </tr>
    </tfoot>
</table>

</div>
<div class="form-group row">
<div class="offset-sm-2 col-sm-6">
<button type="submit" class="btn btn-danger">Submit</button>
</div>
</div>

</div> <!-- End of tab content -->
</form> <!-- End of form -->

</div>
</div>

</div>
         
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>




@endsection
@section('script')

@endsection
