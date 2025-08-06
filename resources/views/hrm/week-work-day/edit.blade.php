
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="#">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
           
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
            <div class="card">
             
              <div class="card-body">
               
                  {!! Form::model($data, ['method' => 'PATCH','route' => ['weekworkday.update', $data->id]]) !!}
                    <div class="row">
                      
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Saturday:</label>
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <select class="form-control" name="_saturday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_saturday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Sunday:</label>
                                <select class="form-control" name="_sunday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_sunday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Monday:</label>
                                <select class="form-control" name="_monday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_monday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Tuesday:</label>
                                <select class="form-control" name="_tuesday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_tuesday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Wednesday:</label>
                                <select class="form-control" name="_wednesday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_wednesday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Thursday:</label>
                                <select class="form-control" name="_thursday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_thursday) selected @endif>{{$off_cat}}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Friday:</label>
                                <select class="form-control" name="_friday">
                                  @forelse(office_days_cat() as $off_cat)
                                  <option value="{{$off_cat}}" @if($off_cat==$data->_friday) selected @endif>{{$off_cat}}</option>
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

