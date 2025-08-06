@extends('backend.layouts.app')
@section('title',$page_name)
@section('css')
<link rel="stylesheet" href="{{asset('backend/new_style.css')}}">
@endsection
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class=" col-sm-6 ">
            <h1 class="m-0 _page_name"><a  href="{{ route('voucher.index') }}"> {!! $page_name ?? '' !!} </a>  
              @include('backend.message.voucher-header')
              </h1>

          </div><!-- /.col -->
          <div class=" col-sm-6 ">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li> -->
              <li class="breadcrumb-item active">
                 <a class="btn btn-sm btn-success" title="List" href="{{ route('voucher.index') }}"> <i class="nav-icon fas fa-list"></i> </a>
               </li>
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
            <div class="card">
             
              <div class="card-body">
                {!! Form::open(array('url' => 'voucher-save','method'=>'POST','class'=>'voucher-form')) !!}
                    <div class="row">

                       <div class="col-xs-12 col-sm-12 col-md-3">
                        <input type="hidden" name="_form_name" value="voucher_masters">
                            <div class="form-group">
                                <label>Date:</label>
                                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                      <input type="text" name="_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                  </div>
                              </div>
                        </div>

                       <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Voucher Type: <span class="_required">*</span></label>
                               <select class="form-control _voucher_type" name="_voucher_type" required="true">
                                  
                                  @forelse($voucher_types as $voucher_type )
                                  <option value="{{$voucher_type->_code}}" @if(isset($request->_voucher_type)) @if($request->_voucher_type == $voucher_type->_code) selected @endif   @endif>
                                    {{ $voucher_type->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group ">
                                <label>Branch:<span class="_required">*</span></label>
                               <select class="form-control" name="_branch_id" required >
                                  
                                  @forelse($permited_branch as $branch )
                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group ">
                                <label>Cost Center:<span class="_required">*</span></label>
                               <select class="form-control" name="_cost_center_id" required >
                                   @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_cost_center_id)) @if($request->_cost_center_id == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 ">
                            <div class="form-group">
                              <label class="mr-2" for="_transection_ref">Reference:</label>
                              <input type="text" id="_transection_ref" name="_transection_ref" class="form-control _transection_ref" value="{{old('_transection_ref')}}" placeholder="Reference" >
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group ">
                                <label>Cash Accounts:<span class="_required">*</span></label>
                               <select class="form-control" name="_defalut_ledger_id" required >
                                   @forelse($_defalut_group_ledgers as $_ledger )
                                                  <option value="{{$_ledger->id}}" @if(isset($request->_defalut_ledger_id)) @if($request->_defalut_ledger_id == $_ledger->id) selected @endif   @endif> {{ $_ledger->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                </select>
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
                                          <thead>
                                            <th>&nbsp;</th>
                                            <th>Ledger</th>
                                            <th  class="@if(sizeof($permited_branch) == 1) display_none @endif" >Branch</th>
                                            <th  class="@if(sizeof($permited_costcenters) == 1) display_none @endif" >Cost Center</th>
                                            <th>Short Narr.</th>
                                            <th class="display_none">Dr. Amount</th>
                                            <th>Receive Amount</th>
                                          </thead>
                                          <tbody class="area__voucher_details" id="area__voucher_details">
                                            <tr class="_voucher_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a>
                                              </td>
                                              <td>
                                                <input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                                                <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                                                <div class="search_box">
                                                  
                                                </div>
                                              </td>
                                              <td class="@if(sizeof($permited_branch) == 1) display_none @endif" >
                                                <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required>
                                                  @forelse($permited_branch as $branch )
                                                  <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                             
                                                <td class="@if(sizeof($permited_costcenters) == 1) display_none @endif">
                                                 <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                                            
                                                  @forelse($permited_costcenters as $costcenter )
                                                  <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                                                  @empty
                                                  @endforelse
                                                </select>
                                              </td>
                                              
                                              <td>
                                                <input type="text" name="_short_narr[]" class="form-control width_250_px _short_narr" placeholder="Short Narr">
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Cr. Amount" value="{{old('_cr_amount',0)}}">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-info" onclick="voucher_row_add(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td  class="text-right @if(sizeof($permited_branch) == 1) display_none @endif"></td>
                                              <td  class="text-right @if(sizeof($permited_costcenters) == 1) display_none @endif"></td>
                                              <td  class="text-right"></td>
                                              <td  class="text-right"><b>Total</b></td>
                                              <td class="display_none">
                                                <input type="number" step="any" min="0" name="_total_dr_amount" class="form-control _total_dr_amount" value="0" readonly required>
                                              </td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_cr_amount" class="form-control _total_cr_amount" value="0" readonly required>
                                              </td>
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                            <div class="form-group">
                               
                                
                                <div class="row">
                                  <div class="col-md-1">
                                     <label class="mr-2" for="_note">Note:<span class="_required">*</span></label>
                                  </div>
                                  <div class="col-md-11">
                                    @if ($_print = Session::get('_print_value'))
                                     <input type="hidden" name="_after_print" value="{{$_print}}" class="_after_print" >
                                    @else
                                    <input type="hidden" name="_after_print" value="0" class="_after_print" >
                                    @endif
                                    @if ($_master_id = Session::get('_master_id'))
                                     <input type="hidden" name="_master_id" value="{{url('voucher/print')}}/{{$_master_id}}" class="_master_id">
                                    
                                    @endif
                                   
                                       <input type="hidden" name="_print" value="0" class="_save_and_print_value">

                                    <input type="text" id="_note"  name="_note" class="form-control _note" value="{{old('_note')}}" placeholder="Note" required >
                                  </div>
                                </div>
                                 @include('backend.message.send_sms')
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            <button type="submit" class="btn btn-warning submit-button _save_and_print"><i class="fa fa-print mr-2" aria-hidden="true"></i> Save & Print</button>
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
  var default_date_formate = `{{default_date_formate()}}`;
  var _after_print = $(document).find("._after_print").val();
  var _master_id = $(document).find("._master_id").val();
  if(_after_print ==1){
      var open_new = window.open(_master_id, '_blank');
      if (open_new) {
          //Browser has allowed it to be opened
          open_new.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
  }


 var single_row =  `<tr class="_voucher_row">
                      <td><a  href="" class="btn btn-default _voucher_row_remove" ><i class="fa fa-trash"></i></a></td>
                      <td><input type="text" name="_search_ledger_id[]" class="form-control _search_ledger_id width_280_px" placeholder="Ledger">
                      <input type="hidden" name="_ledger_id[]" class="form-control _ledger_id" >
                      <div class="search_box">
                      </div>
                      </td>
                      <td class="@if(sizeof($permited_branch) == 1) display_none @endif">
                      <select class="form-control width_150_px _branch_id_detail" name="_branch_id_detail[]"  required >
                        @forelse($permited_branch as $branch )
                            <option value="{{$branch->id}}" @if(isset($request->_branch_id)) @if($request->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                        </select>
                        </td>
                        <td class="@if(sizeof($permited_costcenters) == 1) display_none @endif">
                          <select class="form-control width_150_px _cost_center" name="_cost_center[]" required >
                            @forelse($permited_costcenters as $costcenter )
                              <option value="{{$costcenter->id}}" @if(isset($request->_cost_center)) @if($request->_cost_center == $costcenter->id) selected @endif   @endif> {{ $costcenter->_name ?? '' }}</option>
                            @empty
                            @endforelse
                            </select>
                            </td>
                            <td><input type="text" name="_short_narr[]" class="form-control width_250_px" placeholder="Short Narr"></td>
                            <td class="display_none">
                              <input type="number" name="_dr_amount[]" class="form-control  _dr_amount" placeholder="Dr. Amount" value="{{old('_dr_amount',0)}}">
                            </td>
                            <td>
                              <input type="number" name="_cr_amount[]" class="form-control  _cr_amount" placeholder="Receive Amount" value="{{old('_cr_amount',0)}}">
                              </td>
                            </tr>`;

  function voucher_row_add(event) {
      event.preventDefault();
      $("#area__voucher_details").append(single_row);
  }

  

  $(document).on('click','._voucher_row_remove',function(event){
      event.preventDefault();
      var ledger_id = $(this).parent().parent('tr').find('._ledger_id').val();
      if(ledger_id ==""){
          $(this).parent().parent('tr').remove();
      }else{
        if(confirm('Are you sure your want to delete?')){
          $(this).parent().parent('tr').remove();
        } 
      }
      _voucher_total_calculation();
  })

  // function _voucher_total_calculation(){
  //   var _total_dr_amount = 0;
  //   var _total_cr_amount = 0;
  //     $(document).find("._cr_amount").each(function() {
  //         _total_cr_amount +=parseFloat($(this).val());
  //     });
  //     $(document).find("._dr_amount").each(function() {
  //         _total_dr_amount +=parseFloat($(this).val());
  //     });
  //     $("._total_dr_amount").val(Math.round(_total_dr_amount));
  //     $("._total_cr_amount").val(Math.round(_total_cr_amount));
  // }


  $(document).on('keyup','._dr_amount',function(){
    $(this).parent().parent('tr').find('._cr_amount').val(0);
    $(document).find("._total_dr_amount").removeClass('required_border');
    $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })



  $(document).on('keyup','._cr_amount',function(){
     $(this).parent().parent('tr').find('._dr_amount').val(0);
     $(document).find("._total_dr_amount").removeClass('required_border');
      $(document).find("._total_cr_amount").removeClass('required_border');
    _voucher_total_calculation();
  })

  $(document).on('change','._voucher_type',function(){
    $(document).find('._voucher_type').removeClass('required_border');
  })

  $(document).on('keyup','._note',function(){
    $(document).find('._note').removeClass('required_border');
  })

  $(document).on('click','._save_and_print',function(){
    $(document).find('._save_and_print_value').val(1);
  })


  // $(document).on('click','.submit-button',function(event){
  //   event.preventDefault();
  //   var _total_dr_amount = $(document).find("._total_dr_amount").val();
  //   var _total_cr_amount = $(document).find("._total_cr_amount").val();
  //   var _voucher_type = $(document).find('._voucher_type').val();
  //   var _note = $(document).find('._note').val();
  //   var _search_ledger_id = $(document).find('._search_ledger_id').val();


  //   var empty_ledger = [];
  //   $(document).find("._ledger_id").each(function(){
  //       if($(this).val() ==""){
  //         alert(" Please Add Ledger  ");
  //         $(document).find('._search_ledger_id').focus().addClass('required_border');
  //         empty_ledger.push(1);
  //       }  
  //   })

  //   if(empty_ledger.length > 0){
  //     return false;
  //   }


  //   if(_total_dr_amount !=_total_cr_amount){
  //     $(document).find("._total_dr_amount").focus().addClass('required_border');
  //     $(document).find("._total_cr_amount").focus().addClass('required_border');
  //     return false;

  //   }else if(_voucher_type ==""){
  //      $(document).find('._voucher_type').focus().addClass('required_border');
  //      alert('Please Select Voucher Type.');
  //     return false;
  //   }else if(_note ==""){
       
  //      $(document).find('._note').focus().addClass('required_border');
  //     return false;
  //   }else if(_search_ledger_id ==""){
       
  //     $(document).find('._search_ledger_id').focus().addClass('required_border');
  //     return false;
  //   }else{
  //     $(document).find('.voucher-form').submit();
  //   }
  // })




 

$(".datetimepicker-input").val(date__today())

          function date__today(){
              var d = new Date();
            var yyyy = d.getFullYear().toString();
            var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
            var dd  = d.getDate().toString();
            if(default_date_formate=='DD-MM-YYYY'){
              return (dd[1]?dd:"0"+dd[0]) +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ yyyy ;
            }
            if(default_date_formate=='MM-DD-YYYY'){
              return (mm[1]?mm:"0"+mm[0])+"-" + (dd[1]?dd:"0"+dd[0]) +"-"+  yyyy ;
            }
            

            
          }

</script>
@endsection

