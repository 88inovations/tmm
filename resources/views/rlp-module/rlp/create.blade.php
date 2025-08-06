@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')

  <div class="content ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card">
           <div class="row mb-2">
                  <div class="col-sm-6">
                    <a class="m-0 _page_name" href="{{ route('rlp.index') }}">{!! $page_name !!} </a>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div><!-- /.col -->
                </div><!-- /.row -->
          <div class="message-area">
    @include('backend.message.message')
    </div>
         
            <div class="card-body p-4" >
                {!! Form::open(array('route' => 'rlp.store','method'=>'POST')) !!}
                
            <div class="row" >
            <div class="col-xs-12 col-sm-12 col-md-2">
              <input type="hidden" name="_form_name" class="_form_name" value="rlp_create">
                  <div class="form-group">
                      <label>Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="request_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
              </div>
            
            <div class="col-xs-12 col-sm-12 col-md-2">
              <div class="form-group ">
                <label>Priority:<span class="_required">*</span></label>
                <select class="form-control priority" name="priority" required >
                  <option value="">{{__('label.select')}}</option>
                  @forelse(priorities() as $p_key=>$p_val)
                  <option value="{{$p_key}}">{{$p_val}}</option>
                  @empty
                  @endforelse
                </select>
              </div>
            </div>
            <!-- <div class="col-xs-12 col-sm-12 col-md-2">
                  <div class="form-group">
                      <label>RLP No:</label>
                        <div class="input-group" id="rlp_no" >
                          <input type="text" name="rlp_no" class="form-control" readonly />
                        </div>
                    </div>
              </div> -->

            <div class="col-xs-12 col-sm-12 col-md-2 ">
              <div class="form-group ">
                  <label>{!! __('label.rlp-chain') !!}:<span class="_required">*</span></label>
                  <select class="form-control _master_rlp_chain_id" name="chain_id" required >
                    <option value="">{{__('label.select')}} {{__('label.rlp-chain')}}</option>
                     @forelse($rlp_chains as $val )
                     <option value="{{$val->id}}" >{{ $val->chain_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
            <div class="col-xs-12 col-sm-12 col-md-2 ">
              <div class="form-group ">
                  <label>{!! __('label.organization') !!}:<span class="_required">*</span></label>
                  <select class="form-control _master_organization_id" name="organization_id" required >
                   
@if(sizeof($permited_organizations) > 0)
       <option value="">{{__('label.select')}} {{__('label.organization')}}</option>
@endif
                     @forelse($permited_organizations as $val )
                     <option value="{{$val->id}}" @if(isset($data->organization_id)) @if($data->organization_id == $val->id) selected @endif   @endif>{{ $val->id ?? '' }} - {{ $val->_name ?? '' }}</option>
                     @empty
                     @endforelse
                   </select>
               </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
                  <div class="form-group ">
                      <label>{{__('label.Branch')}}:<span class="_required">*</span></label>
                     <select class="form-control _master_branch_id" name="_branch_id" required >
@if(sizeof($permited_branch) > 0)
       <option value="">{{__('label.select')}} {{__('label.Branch')}}</option>
@endif
                        @forelse($permited_branch as $branch )
                        <option value="{{$branch->id}}" @if(isset($data->_branch_id)) @if($data->_branch_id == $branch->id) selected @endif   @endif>{{ $branch->id ?? '' }} - {{ $branch->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
                  <div class="form-group ">
                      <label>{{__('label.Cost center')}}:<span class="_required">*</span></label>
                     <select class="form-control _cost_center_id" name="_cost_center_id" required >
@if(sizeof($permited_costcenters) > 0)
       <option value="">{{__('label.select')}} {{__('label.Cost center')}}</option>
@endif
                        @forelse($permited_costcenters as $cost_center )
                        <option value="{{$cost_center->id}}" @if(isset($data->_cost_center_id)) @if($data->_cost_center_id == $cost_center->id) selected @endif   @endif>{{ $cost_center->id ?? '' }} - {{ $cost_center->_name ?? '' }}</option>
                        @empty
                        @endforelse
                      </select>
                  </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 ">
                  <div class="form-group ">
                      <label>{{__('Type')}}:<span class="_required">*</span></label>
                     <select class="form-control rlp_prefix" name="rlp_prefix" required >
                        <option value="">{{__('Select')}}</option>
                        @forelse(access_chain_types() as $key=> $val )
                        <option value="{{$key}}" > {{ $val }}</option>
                        @empty
                        @endforelse
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>{{__('label.request_person')}}</label>
                  <input type="text" name="requested_user_name" class="form-control requested_user_name" placeholder="{{__('label.request_person')}}">
                  <input type="hidden" name="request_person" class="request_person">
                  <input type="hidden" name="request_person_user_id" class="request_person_user_id">
                  <div class="search_box_employee"></div>

                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>{{__('label.request_department')}}</label>
                  <input type="text" name="request_department_name" class="form-control employee_request_department_name" placeholder="{{__('label.request_department')}}" readonly >
                  <input type="hidden" name="request_department" class="form-control employee_request_department" placeholder="{{__('label.request_department')}}" >
                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>{{__('label.designation')}}</label>
                  <input type="text" name="designation_name" class="form-control employee_designation_name" placeholder="{{__('label.designation')}}" readonly>
                  <input type="hidden" name="designation" class="form-control employee_designation" placeholder="{{__('label.designation')}}" >
                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>{{__('label.email')}}</label>
                  <input type="text" name="email" class="form-control employee_email" placeholder="{{__('label.email')}}" >
                  
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>{{__('label.contact_number')}}</label>
                  <input type="text" name="contact_number" class="form-control employee_contact_number" placeholder="{{__('label.contact_number')}}" >
                  
                </div>
              </div>

    
              
                <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Item Details</strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >{{__('label._item')}}</th>
                                            <th class="text-left" >{{__('label.purpose')}}</th>
                                            <th class="text-left" >{{__('label.Tran. Unit')}}</th>
                                            <th class="text-left" >{{__('label._qty')}}</th>
                                            <th class="text-left" >{{__('label._rate')}}</th>
                                            <th class="text-left" >{{__('label._value')}}</th>
                                          </thead>
                                          <tbody class="area__rlp_item_details" id="area__rlp_item_details">
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _rlp_item_row_remove" ><i class="fa fa-trash"></i></a>
                                                <input type="hidden" name="_item_row_id[]" class="form-control _item_row_id" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item"></div>

                                                <textarea style="margin-top:10px;" class="form-control _item_description" name="_item_description[]" placeholder="{{__('label.item_details')}}"></textarea>
                                              </td>

                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                              </td>
                                              <td>
                                                <input type="text" name="purpose[]" class="form-control purpose" placeholder="{{__('label.purpose')}}">
                                              </td>
                                              <td>
                                                <select class="form-control _transection_unit" name="_transection_unit[]"></select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="0" >
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " readonly value="0">
                                              </td>
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="_item_add_new_row(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="3"  class="text-right"><b>Total</b></td>
                                             <td>
                                                <input type="number" step="any" min="0" name="_total_qty_amount" class="form-control _total_qty_amount" value="0" readonly required>
                                              </td>
                                              <td></td>
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_value_amount" class="form-control _total_value_amount" value="0" readonly required>
                                              </td>
                                             
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12  ">
                             <div class="card">
                              <div class="card-header">
                                <strong>Others Expenses </strong>

                              </div>
                             
                              <div class="card-body">
                                <div class="table-responsive">
                                      <table class="table table-bordered" >
                                          <thead >
                                            <th class="text-left" >&nbsp;</th>
                                            <th class="text-left" >{{__('label._ledger')}}</th>
                                            <th class="text-left" >{{__('label._details')}}</th>
                                            <th class="text-left" >{{__('label.purpose')}}</th>
                                            <th class="text-left" >{{__('label._value')}}</th>
                                          </thead>
                                          <tbody class="area__rlp_ledger_details" id="area__rlp_ledger_details">
                                            <tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _rlp_ledger_row_remove" ><i class="fa fa-trash"></i></a>
                                                <input type="hidden" name="_rlp_ledger_row_id[]" class="form-control _rlp_ledger_row_id" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_rlp_ledger_id[]" class="form-control _search_rlp_ledger_id width_280_px" placeholder="{{__('label._ledger_id')}}">
                                                <input type="hidden" name="_rlp_ledger_id[]" class="form-control _rlp_ledger_id width_200_px" value="0">
                                                <div class="search_box_ledger"></div>
                                              </td>
                                              <td>
                                                <textarea class="form-control _rlp_ledger_description" name="_rlp_ledger_description[]"></textarea>
                                              </td>
                                              <td>
                                                <input type="text" name="_ledger_purpose[]" class="form-control _ledger_purpose" placeholder="{{__('label.purpose')}}">
                                              </td>
                                              <td>
                                                <input type="number" name="_ledger_amount[]" class="form-control _ledger_amount " value="0" >
                                            </tr>
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td>
                                                <a href="#none"  class="btn btn-default btn-sm" onclick="_ledger_add_new_row(event)"><i class="fa fa-plus"></i></a>
                                              </td>
                                              <td colspan="3"  class="text-right"><b>Total</b></td>
                                            
                                              <td>
                                                <input type="number" step="any" min="0" name="_total_ledger_amount" class="form-control _total_ledger_amount" value="0" readonly required>
                                              </td>
                                             
                                            </tr>
                                          </tfoot>
                                      </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label.remarks')}}:</label>
                                <textarea class="form-control" name="user_remarks"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._terms_condition')}}:</label>
                                <textarea class="form-control summernote" name="_terms_condition"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-header">
                              <h3>Apporoval Chain Details</h3>
                            </div>
                            <div class="card-body chain_detail_section"></div>
                          </div>
                        </div>

                      <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{__('label._status')}}:</label>
                                <select class="form-control" name="_status">
                                  <option value="1">Active</option>
                                  <option value="0">In Active</option>
                                </select>
                            </div>
                        </div> -->
                
                        <div class="col-xs-12 col-sm-12 col-md-12  text-middle">
                            <button type="submit" class="btn btn-success  ml-5"><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> {{__('label.save')}}</button>
                           
                        </div>
                        <br><br>
                    {!! Form::close() !!}
                
              </div>
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


 $(document).ready(function() {
  $('.summernote').summernote();
});
    $(function () {

     var default_date_formate = `{{default_date_formate()}}`
         $('#reservationdate').datetimepicker({
            format:default_date_formate
        });
   
     

 
  

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

     

 });


function _ledger_add_new_row(event){
  $(document).find("#area__rlp_ledger_details").append(`<tr class="_purchase_row">
                    <td>
                      <a  href="#none" class="btn btn-default _rlp_ledger_row_remove" ><i class="fa fa-trash"></i></a>
                      <input type="hidden" name="_rlp_ledger_row_id[]" class="form-control _rlp_ledger_row_id" value="0">
                    </td>
                    <td>
                      <input type="text" name="_search_rlp_ledger_id[]" class="form-control _search_rlp_ledger_id width_280_px" placeholder="{{__('label._ledger_id')}}">
                      <input type="hidden" name="_rlp_ledger_id[]" class="form-control _rlp_ledger_id width_200_px" value="0" >
                      <div class="search_box_ledger"></div>
                    </td>
                    <td>
                      <textarea class="form-control _rlp_ledger_description" name="_rlp_ledger_description[]"></textarea>
                    </td>
                    <td>
                      <input type="text" name="_ledger_purpose[]" class="form-control _ledger_purpose" placeholder="{{__('label.purpose')}}">
                    </td>
                    <td>
                      <input type="number" name="_ledger_amount[]" class="form-control _ledger_amount " value="0" >
                  </tr>`);
}

function _ledger_total_amount(){
  var _total_ledger_amount =0;
  $(document).find('._ledger_amount').each(function(){
    var _ledger_amount = $(this).val();
    _ledger_amount = parseFloat(_ledger_amount);
    if(isNaN(_ledger_amount)){ _ledger_amount=0 }
      _total_ledger_amount+=parseFloat(_ledger_amount);
  })

  $(document).find("._total_ledger_amount").val(_total_ledger_amount);
}

$(document).on('keyup','._ledger_amount',function(){
  _ledger_total_amount();
})

$(document).on('click','._rlp_ledger_row_remove',function(){
    $(this).closest('tr').remove();
    _ledger_total_amount();
})

 $(document).on('keyup','._search_rlp_ledger_id',delay(function(e){
   
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "{{url('ledger-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      console.log(_gloabal_this)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 300px;"><thead><tr><th>{{__('label.id')}}</th><th>{{__('label._code')}}</th><th>{{__('label._name')}}</th></tr></thead> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var ledger_id= data[i]?.id;
                          var ledger_name = data[i]?._name;
                          var ledger_code = data[i]?._code;
                          var address = data[i]?._address;
                          var phone = data[i]?._phone;
                          var balance = data[i]?._balance;
                          var single_data = JSON.toString(data[i]);
                         search_html += `<tr class="search_row_ledger_row _cursor_pointer"  >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_search_rlp_ledger_id_hidden" class="_search_rlp_ledger_id_hidden" value="${data[i]?.id}">
                                        </td> 
                                        <td>${isEmpty(data[i]?._code)}
                                        <input type="hidden" name="rlp_ledger_code" class="rlp_ledger_code" value="${isEmpty(data[i]?._code)}">
                                        </td>
                                        <td>${isEmpty(data[i]._name)}
                                        <input type="hidden" name="rlp_ledger_name" class="rlp_ledger_name" value="${isEmpty(data[i]?._name)}">
                                        
                                        <input type="hidden" name="rlp_ledger_address" class="rlp_ledger_address" value="${isEmpty(data[i]._address)}">
                                        <input type="hidden" name="rlp_ledger_phone" class="rlp_ledger_phone" value="${isEmpty(data[i]._phone)}">
                                        </td>
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3"><button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#exampleModalLong" title="Create Ledger"> New Ledger</button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_ledger').html(search_html);
      _gloabal_this.parent('td').find('.search_box_ledger').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on("click",".search_row_ledger_row",function(){

  var _rlp_ledger_id = $(this).children('td').find("._search_rlp_ledger_id_hidden").val();
  var  rlp_ledger_name = $(this).children('td').find(".rlp_ledger_name").val();
  var  rlp_ledger_code = $(this).children('td').find(".rlp_ledger_code").val();
  var  rlp_ledger_address = $(this).children('td').find(".rlp_ledger_address").val();
  var  rlp_ledger_phone  = $(this).children('td').find(".rlp_ledger_phone").val();

  $(this).parent().parent().parent().parent().parent().parent().find('._rlp_ledger_id ').val(_rlp_ledger_id);
  var _id_name = `${isEmpty(rlp_ledger_code)} `+isEmpty(rlp_ledger_name);
  $(this).parent().parent().parent().parent().parent().parent().find('._search_rlp_ledger_id').val(_id_name);

   $(document).find('.search_box_ledger').hide();
  $(document).find('.search_box_ledger').removeClass('search_box_show').hide();

});

 $(document).on('keyup','.requested_user_name',delay(function(e){
    
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "{{url('employee-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
      var search_html =``;
      var data = result.data; 
      console.log(data)
      if(data.length > 0 ){
            search_html +=`<div class="card"><table class="table-bordered" style="width: 300px;"><thead><th>{{__('label._code')}}</th><th>{{__('label._name')}}</th></tr></thead> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_select_employee_row _cursor_pointer" >
                                        <td>${data[i]._code}
                                        <input type="hidden" name="_emplyee_row_id" class="_emplyee_row_id" value="${data[i].id}">
                                        <input type="hidden" name="_emplyee_row_code_id" class="_emplyee_row_code_id" value="${isEmpty(data[i]._code)}">
                                        <input type="hidden" name="_emplyee_row_department_id" class="_emplyee_row_department_id" value="${isEmpty(data[i]?._emp_department?.id)}">
                                        <input type="hidden" name="_emplyee_row_department_name" class="_emplyee_row_department_name" value="${isEmpty(data[i]?._emp_department?._name)}">
                                        <input type="hidden" name="_emplyee_row_email" class="_emplyee_row_email" value="${isEmpty(data[i]._email)}">
                                        <input type="hidden" name="_emplyee_row_phone" class="_emplyee_row_phone" value="${isEmpty(data[i]._mobile1)}">
                                        <input type="hidden" name="_emplyee_row_jobtitle_id" class="_emplyee_row_jobtitle_id" value="${isEmpty(data[i]?._jobtitle_id)}">
                                        <input type="hidden" name="_emplyee_row_jobtitle_name" class="_emplyee_row_jobtitle_name" value="${isEmpty(data[i]?._emp_designation?._name)}">
                                        </td>
                                        <td>${isEmpty(data[i]._name)}
                                        <input type="hidden" name="_search_employee_name" class="_search_employee_name" value="${isEmpty(data[i]._name)}">
                                        
                                        </td>
                                        
                                       
                                        </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 300px;"> 
        <thead><th colspan="3">No Data Found</th></thead><tbody></tbody></table></div>`;
      }   

       _gloabal_this.parent('div').find('.search_box_employee').html(search_html);
      _gloabal_this.parent('div').find('.search_box_employee').addClass('search_box_show').show();  
      
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
}, 500)); 

 $(document).on('click','._select_employee_row',function(){
 var employee_row_id = $(this).children('td').find('._emplyee_row_id').val();
 var employee_code_id = $(this).children('td').find('._emplyee_row_code_id').val();
 var employee_name = $(this).children('td').find('._search_employee_name').val();
 var employee_email = $(this).children('td').find('._emplyee_row_email').val();
 var employee_contact_number = $(this).children('td').find('._emplyee_row_phone').val();
 var employee_designation = $(this).children('td').find('._emplyee_row_jobtitle_id').val();
 var employee_designation_name = $(this).children('td').find('._emplyee_row_jobtitle_name').val();
 var _emplyee_row_department_id = $(this).children('td').find('._emplyee_row_department_id').val();
 var _emplyee_row_department_name = $(this).children('td').find('._emplyee_row_department_name').val();



 



 console.log(employee_name)
 var _code_and_name = `${isEmpty(employee_code_id)} ${isEmpty(employee_name)}`;

$(document).find('.requested_user_name').val(_code_and_name);
$(document).find('.request_person').val(employee_code_id);
$(document).find('.request_person_user_id').val(employee_row_id);
$(document).find('.employee_designation').val(employee_designation);
$(document).find('.employee_designation_name').val(employee_designation_name);
$(document).find('.employee_email').val(employee_email);
$(document).find('.employee_contact_number').val(employee_contact_number);
$(document).find('.employee_request_department_name').val(_emplyee_row_department_name);
$(document).find('.employee_request_department').val(_emplyee_row_department_id);




  $(document).find('.search_box_employee').hide();
  $(document).find('.search_box_employee').removeClass('search_box_show').hide();
})

$(document).on('click','._rlp_item_row_remove',function(){
      $(this).closest('tr').remove();
      _rlp_total_calculation();
});

  $(document).on('change',"._master_rlp_chain_id",function(){
        var chain_id = $(this).val();
        var self = $(this);
        var request = $.ajax({
          url: "{{url('rlp-chain-wise-detail')}}",
          method: "GET",
          data: { chain_id:chain_id },
        });
         
        request.done(function( response ) {
          var data = response.data;

          $(document).find("._master_organization_id").val(data?.organization_id).change();
          $(document).find("._master_branch_id").val(data?._branch_id).change();
          $(document).find("._cost_center_id").val(data?._cost_center_id).change();

          var chain_user_details = data?._chain_user;
          var table=`<table class="table table-bordered">
          <tr>
          <th>Group</th>
          <th>EMP ID</th>
          <th>Name</th>
          <th>Order</th>
          </tr>`
          for (var i = 0; i < chain_user_details?.length; i++) {
            table+=`<tr style="background:${chain_user_details[i]?._user_group?._color}">
                    <td>${chain_user_details[i]?._user_group?._name}</td>
                    <td>${chain_user_details[i]?._user_info?._code}</td>
                    <td>${chain_user_details[i]?._user_info?._name}</td>
                    <td>${chain_user_details[i]?._order}</td>
                    
              </tr>`;
            chain_user_details[i]
          }
          table+=`<table>`;

          $(document).find(".chain_detail_section").html(table);

         console.log(response)
        });
         
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
        });
  })

  function _item_add_new_row(event){
    $(document).find("#area__rlp_item_details").append(`<tr class="_purchase_row">
                                              <td>
                                                <a  href="#none" class="btn btn-default _rlp_item_row_remove" ><i class="fa fa-trash"></i></a>
                                                <input type="hidden" name="_item_row_id[]" class="form-control _item_row_id" value="0">
                                              </td>
                                              <td>
                                                <input type="text" name="_search_item_id[]" class="form-control _search_item_id width_280_px" placeholder="Item">
                                                <input type="hidden" name="_item_id[]" class="form-control _item_id width_200_px" >
                                                <div class="search_box_item"></div>
                                                <textarea style="margin-top:10px;" class="form-control _item_description" name="_item_description[]" placeholder="{{__('label.item_details')}}"></textarea>
                                              </td>

                                               <td class="display_none">
                                                <input type="hidden" class="form-control _base_unit_id width_100_px" name="_base_unit_id[]" />
                                                <input type="text" class="form-control _main_unit_val width_100_px" readonly name="_main_unit_val[]" />
                                              </td>
                                              <td class="display_none">
                                                <input type="number" name="conversion_qty[]" min="0" step="any" class="form-control conversion_qty " value="1" readonly>
                                              </td>
                                              <td>
                                                <input type="text" name="purpose[]" class="form-control purpose" placeholder="{{__('label.purpose')}}">
                                              </td>
                                              <td>
                                                <select class="form-control _transection_unit" name="_transection_unit[]"></select>
                                              </td>
                                              <td>
                                                <input type="number" name="_qty[]" class="form-control _qty _common_keyup" value="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_rate[]" class="form-control _rate _common_keyup" value="0">
                                              </td>
                                              <td>
                                                <input type="number" name="_value[]" class="form-control _value " value="0" readonly >
                                            </tr>`);
  }
$(document).on('keyup','._search_item_id',delay(function(e){
    $(document).find('._search_item_id').removeClass('required_border');
    var _gloabal_this = $(this);
    var _text_val = $(this).val().trim();


  var request = $.ajax({
      url: "{{url('item-purchase-search')}}",
      method: "GET",
      data: { _text_val : _text_val },
      dataType: "JSON"
    });
     
    request.done(function( result ) {

      var search_html =``;
      var data = result.data; 
      if(data.length > 0 ){
            search_html +=`<div class="card"><table style="width: 500px;">
                            <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                          var   _manufacture_company = data[i]?. _manufacture_company;
                          var _balance = data[i]?._balance
                         search_html += `<tr class="search_row_item" >
                                        <td>${data[i].id}
                                        <input type="hidden" name="_id_item" class="_id_item" value="${data[i].id}">
                                        </td><td>${data[i]._name}
                                        <input type="hidden" name="_name_item" class="_name_item" value="${data[i]._name}">
                                  <input type="hidden" name="_item_barcode" class="_item_barcode" value="${data[i]._barcode}">
                                  <input type="hidden" name="_item_rate" class="_item_rate" value="${data[i]._pur_rate}">
                                  
                                   <input type="hidden" name="_main_unit_id" class="_main_unit_id" value="${data[i]._unit_id}">
                                  <input type="hidden" name="_main_unit_text" class="_main_unit_text" value="${data[i]._units?._name}">
                                   </td>
                                   <td>${_balance} ${data[i]._units?._name}</td>
                                   </tr>`;
                        }                         
            search_html += ` </tbody> </table></div>`;
      }else{
        search_html +=`<div class="card"><table style="width: 400px;"> 
        <thead><th colspan="4"><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong_item" title="Create New Item (Inventory) ">
                   <i class="nav-icon fas fa-plus"></i> New Item
                </button></th></thead><tbody></tbody></table></div>`;
      }     
      _gloabal_this.parent('td').find('.search_box_item').html(search_html);
      _gloabal_this.parent('td').find('.search_box_item').addClass('search_box_show').show();
      
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });

  

}, 500));

$(document).on('click','.search_row_item',function(){
  var _vat_amount =0;
  var _id = $(this).children('td').find('._id_item').val();
  var _name = $(this).find('._name_item').val();
  var _item_barcode = $(this).find('._item_barcode').val();
  if(_item_barcode=='null'){ _item_barcode='' } 
  var _item_rate = $(this).find('._item_rate').val();

  var _main_unit_id = $(this).children('td').find('._main_unit_id').val();
  var _main_unit_val = $(this).children('td').find('._main_unit_text').val();

 

var self = $(this);

    var request = $.ajax({
      url: "{{url('item-wise-units')}}",
      method: "GET",
      data: { item_id:_id },
       dataType: "html"
    });
     
    request.done(function( response ) {
      self.parent().parent().parent().parent().parent().parent().find('._transection_unit').html("")
      self.parent().parent().parent().parent().parent().parent().find("._transection_unit").html(response);
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  

  $(this).parent().parent().parent().parent().parent().parent().find('._item_id').val(_id);
  var _id_name = `${_name} `;
  $(this).parent().parent().parent().parent().parent().parent().find('._search_item_id').val(_id_name);
  
  $(this).parent().parent().parent().parent().parent().parent().find('._qty').val(1);
  $(this).parent().parent().parent().parent().parent().parent().find('._rate').val(0);
  
  $(this).parent().parent().parent().parent().parent().parent().find('._value').val(0);
 
  $(this).parent().parent().parent().parent().parent().parent().find('._base_rate').val(_item_rate);
  $(this).parent().parent().parent().parent().parent().parent().find('._base_unit_id').val(_main_unit_id);
  $(this).parent().parent().parent().parent().parent().parent().find('._main_unit_val').val(_main_unit_val);

  _rlp_total_calculation();
  $(document).find('.search_box_item').hide();
  $(document).find('.search_box_item').removeClass('search_box_show').hide();
  
})

$(document).on('change','._transection_unit',function(){
  var __this = $(this);
  var conversion_qty = $('option:selected', this).attr('attr_conversion_qty');
 
  $(this).closest('tr').find(".conversion_qty").val(conversion_qty);

  converted_qty_value(__this);
})

function converted_qty_value(__this){

  var _vat_amount =0;
  var _qty = __this.closest('tr').find('._qty').val();
  var _rate = __this.closest('tr').find('._rate').val();
  var _base_rate = __this.closest('tr').find('._base_rate').val();
  var conversion_qty = parseFloat(__this.closest('tr').find('.conversion_qty').val());

  if(isNaN(conversion_qty)){ conversion_qty   = 1 }
  var converted_price_rate = (( conversion_qty/1)*_base_rate);

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }
   if(isNaN(_base_rate)){ _base_rate =0 }

  if(converted_price_rate ==0){
    converted_price_rate = _rate;
  }

   if(isNaN(_qty)){ _qty   = 0 }
   if(isNaN(_rate)){ _rate =0 }


   var _value = parseFloat(converted_price_rate*_qty).toFixed(2);
 __this.closest('tr').find('._rate').val(converted_price_rate);
 __this.closest('tr').find('._value').val(_value);
    _rlp_total_calculation();


}    

$(document).on('keyup','._common_keyup',function(){
  var _vat_amount =0;
  var _qty = parseFloat($(this).closest('tr').find('._qty').val());
  var _rate =parseFloat( $(this).closest('tr').find('._rate').val());
  if(isNaN(_qty)){ _qty   = 0 }
  if(isNaN(_rate)){ _rate =0 }
  $(this).closest('tr').find('._value').val((_qty*_rate));
    _rlp_total_calculation();
})

function _rlp_total_calculation(){
  console.log('calculation here')
    var _total_qty = 0;
    var _total__value = 0;
    var _total__vat =0;
    var _total_discount_amount = 0;
      $(document).find("._value").each(function() {
            var _s_value =parseFloat($(this).val());
            if(isNaN(_s_value)){_s_value = 0}
          _total__value +=parseFloat(_s_value);
      });
      $(document).find("._qty").each(function() {
            var _s_qty =parseFloat($(this).val());
            if(isNaN(_s_qty)){_s_qty = 0}
          _total_qty +=parseFloat(_s_qty);
      });
    
      $(document).find("._total_qty_amount").val(_total_qty);
      $(document).find("._total_value_amount").val(_total__value);

      var _discount_input = parseFloat($(document).find("#_purchase_discount_input").val());
      if(isNaN(_discount_input)){ _discount_input =0 }
      var _total_discount = parseFloat(_discount_input)+parseFloat(_total_discount_amount);
      $(document).find("#_purchase_sub_total").val(_math_round(_total__value));
      var _total = _math_round((parseFloat(_total__value)+parseFloat(_total__vat))-parseFloat(_total_discount));
      $(document).find("#_purchase_total").val(_total);
  }    

</script>
@endsection

