@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">

        <div class="col-sm-12" style="display: flex;">
             <a class="m-0 _page_name" href="{{ route('approval-chain.index') }}"> {!! $page_name ?? '' !!} </a>
            
          </div>

        
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
              
              <div class="card-body">
 {!! Form::open(array('route' => 'approval-chain.store','method'=>'POST')) !!} 
 @csrf
                    <div class="row">
                 

@include('basic.org_create')
<div class="col-xs-12 col-sm-12 col-md-2 ">
    <div class="form-group ">
        <label>{{__('label.chain_type')}}:<span class="_required">*</span></label>
       <select class="form-control chain_type" name="chain_type" required >
          
          @forelse(access_chain_types() as $key=> $val )
          <option value="{{$key}}" > {{ $val }}</option>
          @empty
          @endforelse
        </select>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-2">
    <div class="form-group">
        <label>Status</label>
        <select class="form-control " name="_status">
              <option value="1"  >Active</option>
              <option value="0"  >In Active</option>
            </select>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 ">
    <div class="form-group ">
        <label>{{__('label.chain_name')}}:<span class="_required">*</span></label>
      <input type="text" name="chain_name" class="form-control" required value="{!! old('chain_name') !!}" placeholder="{!! __('label.chain_name') !!}" />
    </div>
</div>
<div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >Group Name</th>
                                            <th class="text-left" >User</th>
                                            <th class="text-left" >Order</th>
                                            
                                          </thead>
                                          
                        @forelse($rlp_user_groups as $key=>$group)

                        <tbody class="area__user_chain__{{$key}}" id="area__user_chain__{{$key}}" style="background:{!! $group->_color ?? '' !!} !important">
                          
                        <tr>
                          <td colspan="2"></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr class="_purchase_row" style="background:{!! $group->_color ?? '' !!} !important">
                          <td>
                            <a  href="#none" class="btn btn-default _purchase_row_remove" >
                              <i class="fa fa-trash"></i></a>
                            <input type="hidden" name="_row_id[]" value="0">
                          </td>
                          <td>
                            <input type="hidden" class="user_group" name="user_group[]" value="{{$group->id}}"  />
                            <input type="text" class="form-control user_group_name" name="user_group_name[]" value="{{$group->_name}}" readonly />
                          </td>
                          <td>
                              <input type="text" name="user_id_name[]" class="form-control user_id_name" placeholder="{{__('label.user')}}">

                               <input type="hidden" class="user_row_id" name="user_row_id[]" value="0"  />
                               <input type="hidden" class="user_id" name="user_id[]" value="0"  />
                               <div class="search_box_employee"> </div>
                               
                          </td>
                          <td>
                              <input type="text" name="ack_order[]" class="form-control" value="{{$group->_order}}" readonly>
                          </td>
                          <td>
                            <a href="#none"  class="btn btn-default btn-sm" onclick="add_new_user({{$key}},{{$group}})"><i class="fa fa-plus"></i></a>
                          </td>
                         
                        </tr>    
                        </tbody>
                         @empty
                        @endforelse
                                          
                                      </table>
                                </div>
                            </div>
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
            <!-- /.card -->

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
 $(document).on('click','._purchase_row_remove',function(event){
      event.preventDefault();
      $(this).parent().parent('tr').remove();
      
  })

   

            function add_new_user($_row_key,$group){
              console.log($group);
              var group_id = $group.id;
              var group_name=$group._name;
              var order_number = $group._order;
                $(document).find("#area__user_chain__"+$_row_key).append(`<tr class="_purchase_row">
              <td>
                <a  href="#none" class="btn btn-default _purchase_row_remove" ><i class="fa fa-trash"></i></a>
                <input type="hidden" name="_row_id[]" value="0">
              </td>
               <td>
                      <input type="hidden" class="user_group" name="user_group[]" value="${group_id}"  />
                      <input type="text" class="form-control user_group" name="user_group_name[]" value="${group_name}" readonly />
                    </td>
              <td>
                    <input type="text" name="user_id_name[]" class="form-control user_id_name" placeholder="{{__('label.user')}}">
                     <input type="hidden" class="user_row_id" name="user_row_id[]" value="0"  />
                     <input type="hidden" class="user_id" name="user_id[]" value="0"  />
                      <div class="search_box_employee"> </div>
                </td>

              <td>
                  <input readonly type="text" name="ack_order[]" class="form-control" value="${order_number}">
              </td>
              <td></td>
            </tr>`);
                
            }

            
</script>

@endsection