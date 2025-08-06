@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row  ">
          <div class="col-md-12 text-center">
            <a class="_page_name" href="{{url('report-panel')}}">Report</a> / 
            <a class="_page_name" href="#">{{ $page_name ?? '' }}</a>
          
          </div><!-- /.col -->
          <div class="col-md-12">
              @include('backend.message.message')
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
            
          
         
            <div class="card-body filter_body" >
               <form  action="{{url('group-wise-ledger-report')}}" method="GET">
                @csrf
              
                
                  <div class="form-group row">
                    <label for="_account_head_id" class="col-sm-4 col-form-label">Account Type:</label>
                    <div class="col-sm-8 ">
                      <select class="form-control select2 _account_head_id" name="_account_head_id">
                        <option value="">Type</option>
                        @forelse($account_types as $account_type )
                        <option value="{{$account_type->id}}" @if(isset($request->_account_head_id)) @if($request->_account_head_id == $account_type->id) selected @endif   @endif>{{ $account_type->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Account Group:</label>
                    <div class="col-sm-8 ">
                      <select class="form-control select2 _account_groups" name="_account_group_id">
                          <option value="">Group</option>
                          @forelse($account_groups as $account_group )
                          <option value="{{$account_group->id}}" @if(isset($request->_account_group_id)) @if($request->_account_group_id == $account_group->id) selected @endif   @endif>{{ $account_group->_name ?? '' }}</option>
                          @empty
                          @endforelse
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">ID:</label>
                    <div class="col-sm-8">
                      <input type="text" name="id" class="form-control" placeholder="Exp:1,2,3,4" value="@if(isset($request->id)) {{$request->id ?? ''}}  @endif">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Name:</label>
                    <div class="col-sm-8">
                      <input type="text" name="_name" class="form-control" placeholder="Search By Name" value="@if(isset($request->_name)) {{$request->_name ?? ''}}  @endif">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Phone:</label>
                    <div class="col-sm-8">
                      <input type="text" name="_phone" class="form-control" placeholder="Search By Phone" value="@if(isset($request->_phone)) {{$request->_phone ?? ''}}  @endif">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Email:</label>
                    <div class="col-sm-8">
                       <input type="text" name="_email" class="form-control" placeholder="Search By Email" value="@if(isset($request->_email)) {{$request->_email ?? ''}}  @endif">
                    </div>
                  </div>

                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Order By:</label>
                    <div class="col-sm-8">
                      @php
                        $cloumns = [ 'id'=>'ID','_account_group_id'=>'Account Group','_account_head_id'=>'Account Head','_name'=>'Name','_code'=>'Code','_nid'=>'NID', '_email'=>'Email','_phone'=>'Phone'];

                      @endphp
                       <select class="form-control" name="asc_cloumn" >
                            
                            @foreach($cloumns AS $key=>$val)
                            <option value="{{$key}}" @if(isset($request->asc_cloumn)) @if($key==$request->asc_cloumn) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>
                     
                     <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Sort Order:</label>
                    <div class="col-sm-8">
                       <select class=" form-control" name="_asc_desc">
                        @foreach(asc_desc() AS $key=>$val)
                            <option value="{{$val}}" @if(isset($request->_asc_desc)) @if($val==$request->_asc_desc) selected @endif @endif >{{$val}}</option>
                        @endforeach
                        </select>

                        <input type="hidden" name="filtter" value="1">
                    </div>
                  </div>   
                     <div class="form-group row ">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary "><i class="fa fa-search mr-2"></i> Search</button>
                      </div>
                    
                  </div>    

                           
                  
               
              </div>
            </form>
                
              </div>
          
          </div>
        </div>
        <!-- /.row -->

        @if(sizeof($datas) > 0)
        <div class="_report_button_header">
    
 <a style="cursor: pointer;" class="nav-link"  title="Print" onclick="javascript:printDiv('printablediv')"><i class="fas fa-print"></i></a>
      <a style="cursor: pointer;" onclick="fnExcelReport();" class="nav-link"  title="Excel Download" ><i class="fa fa-file-excel" aria-hidden="true"></i></a>
  </div>
        <section class="invoice" id="printablediv">
   
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-2 invoice-col">
        
      </div>
      <!-- /.col -->
      <div class="col-sm-8 invoice-col text-center">
        <h2 class="page-header">
            {{$settings->name ?? '' }}
          <small class="float-right"></small>
        </h2>
        <address>
          <strong>{{$settings->_address ?? '' }}</strong><br>
          {{$settings->_phone ?? '' }}<br>
          {{$settings->_email ?? '' }}<br>
          <b>Account Ledger</b>
        </address>
       
      </div>
      <!-- /.col -->
      <div class="col-sm-2 invoice-col text-right">
        
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  
<div class="table-responsive">
   <table class="table table-bordered">
                <thead>
                    <tr>
                         <th>ID</th>
                         <th>Type</th>
                         <th>Group</th>
                         <th>Name</th>
                         <th>Code</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Balance</th>
                         <th>Possition</th>
                         <th>Status</th>
                        
                      </tr>
                </thead>
                <tbody>
                  
                      @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->account_type->_name ?? '' }}</td>
                            <td>{{ $data->account_group->_name ?? '' }}</td>
                            <td>{{ $data->_name }}</td>
                            <td>{{ $data->_code ?? '' }}</td>
                            <td>{{ $data->_email ?? '' }}</td>
                            <td>{{ $data->_phone ?? '' }}</td>
                           <td>{{ _show_amount_dr_cr(_report_amount(_last_balance($data->id)[0]->_balance ?? 0))  }}</td>
                            <td>{{ $data->_short ?? '' }}</td>
                            <td>{{ selected_status($data->_status) }}</td>
                           
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                   <tr>
                     <td colspan="10">
                       <div class="col-12 mt-5">
                          <div class="row">
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Received By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Prepared By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;">Checked By</span></div>
                            <div class="col-3 text-center " style="margin-bottom: 50px;"><span style="border-bottom: 1px solid #f5f9f9;"> Approved By</span></div>
                          </div>
                        </div>
                     </td>
                   </tr>
                </tfoot>
                      
                        
                    </table>
                </div>
    
    
  </section>

        @endif
      </div>
    </div>  
</div>



@endsection

@section('script')

<script type="text/javascript">

$(document).ready(function(){

var _account_head_id = $(document).find("._account_head_id").val();
account_head_to_group(_account_head_id,"_account_groups");

  var _account_group_ids = $(document).find('._account_group_id').val();
    if(_account_group_ids?.length > 0){
      _nv_group_base_ledger(_account_group_ids);
    }

})
 

    
 



        

         

</script>
@endsection

