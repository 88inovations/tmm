@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')

<link rel="stylesheet" href="{{asset('backend/pos-template/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <a class="m-0 _page_name" href="{{ route('category-allocation.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('category-allocation.index') }}"> {{ $page_name ?? '' }} </a>
               </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @include('backend.message.message')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
             
              <div class="card-body">
               
                  {!! Form::model($data, ['method' => 'PATCH','route' => ['category-allocation.update', $data->id]]) !!}
                    @csrf
                    <div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label>Branch:</label>
                                
                                <select class="form-control" name="_branch_ids" required>
                                  @forelse($branchs as $branch)
                                  <option value="{{$branch->id}}" @if($data->_branch_ids==$branch->id) selected @endif>{{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                  
                                </select>
                            </div>
                        </div>
                        

                          @php
                          $_string_ids = $data->_category_ids ?? 0;
                          if($_string_ids !=0){
                            $selected_category = explode(",",$_string_ids);
                          }else{
                            $selected_category =[];
                          }
                          @endphp
     
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Category:</label>
                                <select multiple class="form-control _category_ids select2" name="_category_ids[]" >
                                    
                                    @forelse($categories as $value)
                                    <option value="{{$value->id}}" @if(in_array($value->id,$selected_category)) selected @endif >{{$value->_parents->_name ?? ''}} / {{$value->_name ?? ''}}</option>
                                    @empty
                                    @endforelse
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