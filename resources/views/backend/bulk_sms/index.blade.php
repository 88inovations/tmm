@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<style type="text/css">
  ._sms_filter_body{
    width: 90%;
    margin: 0px auto;
    margin-bottom: 20px;
  }
</style>
  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                 <h4 class="text-center">{{ $page_name ?? '' }}</h4>
                @if (count($errors) > 0)
           <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
            </div>
          
         
            <div class="card-body _sms_filter_body" >
               <form  action="{{url('bulk-sms-send')}}" method="POST">
                @csrf
                    
                  <div class="row">
                    <div class="col-md-6">
                      <label>Ledger Group:<span class="_required">*</span></label><br>
                      <select id="_account_group_id" class="form-control _account_group_id multiple_select" name="_account_group_id[]" multiple  size='8'  required>
                           @forelse($account_groups as $group)
                           <option value="{{$group->id}}"
            @if(isset($previous_filter["_account_group_id"]))
                  @if(in_array($group->id,$previous_filter["_account_group_id"])) selected @endif
            @endif
                             >{{$group->_name}}</option>
                           @empty
                           @endforelse
                         </select>

                    </div>
                    <div class="col-md-6">
                       <label>Ledger:<span class="_required">*</span></label><br>
                       <select id="_account_ledger_id" class="form-control  _account_ledger_id multiple_select" name="_account_ledger_id[]" multiple size='8'>
                          @if(isset($request->_account_ledger_id)  )
                           @forelse($account_groups as $group)
                           <option value="{{$group->id}}">{{$group->_name}}</option>
                           @empty
                           @endforelse
                          @endif
                         </select>
                    </div>
                  </div>
                    
                     <div class="row">
                      <label>Message:<span class="_required">*</span></label><br></div>
                     <div class="row">
                       <textarea class="form-control" name="_message" required></textarea>
                     </div>
                     <br>
                     
                     <div class="row mt-3 text-center">
                         
                            <button type="submit" class="btn btn-success submit-button form-control"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> SEND SMS</button>
                       
                        
                        <br><br>
                     </div>
                    {!! Form::close() !!}
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">


 
  

    var _account_group_ids = $(document).find('._account_group_id').val();
    if(_account_group_ids.length > 0){
      _nv_group_base_ledger(_account_group_ids);
    }

  $(document).find('#_account_group_id').on('change',function(){
    var _account_group_id = $(this).val();
    
      _nv_group_base_ledger(_account_group_id);
    
  })

  function _nv_group_base_ledger(_account_group_id){
    var request = $.ajax({
        url: "{{url('group-base-sms-ledger')}}",
        method: "GET",
        data: { _account_group_id : _account_group_id },
        dataType: "HTML"
      });
    request.done(function( result ) {
      $("#_account_ledger_id").html(result);
      });
       
      request.fail(function( jqXHR, textStatus ) {
       console.log(textStatus)
      });
  }






  

        

         

</script>
@endsection

