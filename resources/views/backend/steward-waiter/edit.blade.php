@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <a class="m-0 _page_name" href="{{ route('steward-waiter.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('steward-waiter.index') }}"> {{ $page_name ?? '' }} </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="message-area">
    @if (count($errors) > 0)
           <div class="alert alert-danger">
               
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               
                   {!! Form::model($data, ['method' => 'PATCH','route' => ['steward-waiter.update', $data->id]]) !!}
                    @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label>Branch:</label>
                                
                                <select class="form-control" name="_branch_id" required>
                                  @forelse($branchs as $branch)
                                  <option value="{{$branch->id}}" @if($data->_branch_id==$branch->id) selected @endif>{{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        

                          @php
                          $_string_ids = $data->_ledgers ?? 0;
                          if($_string_ids !=0){
                            $_selected_stewards = explode(",",$_string_ids);
                          }else{
                            $_selected_stewards =[];
                          }
                          @endphp
     
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Steward/Waiter:</label>
                                <select multiple class="form-control _ledgers select2" name="_ledgers[]" >
                                    <option value="">Steward/Waiter</option>
                                    @forelse($_ledgerss as $ledger)
                                    <option value="{{$ledger->id}}" @if(in_array($ledger->id,$_selected_stewards)) selected @endif >{{$ledger->_name ?? ''}}</option>
                                    @empty
                                    @endforelse
                                  </select>
                               
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" name="_status">
                                  <option value="1" @if($data->_status==1) selected @endif >Active</option>
                                  <option value="0" @if($data->_status==0) selected @endif >In Active</option>
                                </select>
                            </div>
                        </div>
                       
                        
                       <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                           
                        </div>
                        <br><br>
                    </div>
                    </form>
                
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