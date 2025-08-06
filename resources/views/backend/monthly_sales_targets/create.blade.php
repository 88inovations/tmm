@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

         <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('monthly_sales_targets.index') }}"> {!! $page_name ?? '' !!} </a>
          </div>
      </div><!-- /.container-fluid -->
    </div>
    
  
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-3">
<a href="{{route('monthly_sales_targets.create')}}" class="btn btn-info btn-block mb-3"><i class="nav-icon fas fa-plus"></i> Create New</a>
<div class="card">
<div class="card-header">
<h3 class="card-title">Folders</h3>
<div class="card-tools">
<button type="button" class="btn btn-tool" data-card-widget="collapse">
<i class="fas fa-minus"></i>
</button>
</div>
</div>
<div class="card-body p-0">
    <ul class="nav nav-pills flex-column">
       
        <li class="nav-item">
        <a href="{{url('monthly_sales_targets?_group=2')}}" class="nav-link">
        <i class="far fa-envelope"></i> {{__('label.sales_target_customer')}}
        </a>
        </li>
        

    </ul>
</div>

</div>



</div>

<div class="col-md-9">
<div class="card card-primary card-outline">
<div class="card-header">
<h3 class="card-title">{{$page_name ?? '' }}</h3>


</div>

<div class="message-area">
    @include('backend.message.message')
    </div>

<div class="card-body ">

{!! Form::open(array('route' => 'monthly_sales_targets.store','method'=>'POST')) !!}
                    <div class="row">
                        @include("backend.widgets.budget_select")
                       <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>{{__('label._group')}}:</label>
                                <select class="form-control" name="_group">
                                    @forelse(insective_groups() as $key=>$val)
                                  <option value="{{$key}}">{{$val}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._year')}}:</label>
                                {!! Form::text('_year', null, array('placeholder' => __('label._year'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._month_no')}}:</label>
                                <select class="form-control" name="_month_no" required>
                                    <option value="">--{{__('label.select')}}--</option>
                                    @forelse(_month_names() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @empty
                                    @endforelse
                                </select>
                               
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._period_start')}}:</label>
                                {!! Form::date('_period_start', null, array('placeholder' => __('label._period_start'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>{{__('label._period_end')}}:</label>
                                {!! Form::date('_period_end', null, array('placeholder' => __('label._period_end'),'class' => 'form-control','required' => 'true')) !!}
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h3>Ledger Wise target</h3>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th>##</th>
                                        <th>{{__('label.sl')}}</th>
                                        <th>{{__('label._ledger_id')}}</th>
                                        <th>{{__('label._target_amount')}}</th>
                                        <th>{{__('label._branch_id')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="area__ledger_details">
                                <tr class="_purchase_row" >
                                      <td>
                                        <a  href="#none" class="btn btn-default _purchase_row_remove" >
                                          <i class="fa fa-trash"></i></a>
                                        <input type="hidden" name="_row_id[]" value="0">
                                      </td>
                                      <td></td>
                                      <td>
                                          <input type="text" name="_ledger_id_name[]" class="form-control sales_target_ledger_id" placeholder="{{__('label._ledger_id')}}">
                                           <input type="hidden" class="_ledger_id" name="_ledger_id[]" value="0"  />
                                           <div class="search_box_employee"> </div>
                                           
                                      </td>
                                      <td >
                                        <input type="number" min="0" step="any"  class="form-control _target_amount" name="_target_amount[]" value="0"  />
                                      </td>
                                      
                                      <td>
                                          <input type="hidden" name="_branch_id[]" class="form-control _branch_id">
                                          <input type="text" readonly name="_branch_id_name[]" class="form-control _branch_id_name">
                                      </td>
                                      
                                      
                                      <td class="display_none">
                                        <input type="number" min="0" step="any"  readonly class="form-control _sales_amount" name="_sales_amount[]" value="0"  />
                                      </td>
                                      <td class="display_none">
                                        <input type="number" min="0" step="any" readonly class="form-control _sales_return_amount" name="_sales_return_amount[]" value="0"  />
                                      </td>
                                      <td class="display_none">
                                        <input type="number" min="0" step="any" readonly class="form-control _collection_amount" name="_collection_amount[]" value="0"  />
                                      </td>
                                    </tr>  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                        <a href="#none"  class="btn btn-default btn-sm" onclick="add_new_user()"><i class="fa fa-plus"></i></a>
                                      </td>
                                      <td>
                                          
                                      </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                       
                       <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div>
                        
                       
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>

                    </div>
                    {!! Form::close() !!}

</div>


</div>

</div>

</div>
</div>
</section>



@endsection

@section('script')
<script type="text/javascript">
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      $(this).parent().parent('tr').remove();
      
  })

   

            function add_new_user(){
                $(document).find(".area__ledger_details").append(`<tr class="_purchase_row" >
                                      <td>
                                        <a  href="#none" class="btn btn-default _purchase_row_remove" >
                                          <i class="fa fa-trash"></i></a>
                                        <input type="hidden" name="_row_id[]" value="0">
                                      </td>
                                      <td></td>
                                      <td>
                                          <input type="text" name="_ledger_id_name[]" class="form-control sales_target_ledger_id" placeholder="{{__('label._ledger_id')}}">
                                           <input type="hidden" class="_ledger_id" name="_ledger_id[]" value="0"  />
                                           <div class="search_box_employee"> </div>
                                           
                                      </td>
                                      <td >
                                        <input type="number" min="0" step="any"  class="form-control _target_amount" name="_target_amount[]" value="0"  />
                                      </td>
                                      
                                      <td>
                                          <input type="hidden" name="_branch_id[]" class="form-control _branch_id">
                                          <input type="text" readonly name="_branch_id_name[]" class="form-control _branch_id_name">
                                      </td>
                                      
                                      
                                      <td class="display_none">
                                        <input type="number" min="0" step="any"  readonly class="form-control _sales_amount" name="_sales_amount[]" value="0"  />
                                      </td>
                                      <td class="display_none">
                                        <input type="number" min="0" step="any" readonly class="form-control _sales_return_amount" name="_sales_return_amount[]" value="0"  />
                                      </td>
                                      <td class="display_none">
                                        <input type="number" min="0" step="any" readonly class="form-control _collection_amount" name="_collection_amount[]" value="0"  />
                                      </td>
                                    </tr> `);
                
            }

            
</script>

@endsection