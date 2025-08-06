@extends('backend.layouts.app')
@section('title',$page_name ?? '')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a class="m-0 _page_name" href="{{ route('monthly-salary-structure.index') }}">{!! $page_name ?? '' !!} </a>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             @can('monthly-salary-structure-list')
              <li class="breadcrumb-item active">
                 <a class="btn btn-info" href="{{ route('monthly-salary-structure.index') }}"> <i class="fa fa-th-list" aria-hidden="true"></i></a>
               </li>
               @endcan
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    
    <div class="content">
      <div class="container-fluid">
<div class="card ">
<div class="card-body">
                 @include('backend.message.message')
                {!! Form::open(array('route' => 'monthly-salary-structure.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                <div class="form-group row ">

                            <label class="col-sm-2 col-form-label" >{{__('label._payment_type')}}:</label>
                            <div class="col-md-2">
                                <select class="form-control _payment_type" name="_payment_type">
                                    <option value="1">Salary</option>
                                   
                                </select>
                            </div><label class="col-sm-2 col-form-label" >{{__('label._month')}}:</label>
                            <div class="col-md-2">
                                <select class="form-control _month" name="_month" required>
                                    <option value="">{{__('label.select')}}</option>
                                    @forelse(_month_names() as $month_key=>$month)
                                    <option value="{{$month_key}}">{{$month ?? '' }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                    <label class="col-sm-2 col-form-label" >{{__('label._year')}}:</label>
                             <div class="col-sm-2">
                                <select name="_year" class="form-control" required>
    <?php
    // Get the current year
    $currentYear = date('Y');

    // Display the last two years
    for ($i = 2; $i > 0; $i--) {
        $year = $currentYear - $i;
        echo "<option value='$year'>$year</option>";
    }

    // Display the current year
    echo "<option value='$currentYear' selected>$currentYear</option>";

    // Display the next year
    $nextYear = $currentYear + 1;
    echo "<option value='$nextYear'>$nextYear</option>";
    ?>
</select>

                            </div>
                </div>
                <div class="form-group row ">
                            <label class="col-sm-2 col-form-label" >{{__('EMP ID')}}:</label>
                            <div class="col-md-4">
                                <input type="hidden" name="_employee_id" class="_employee_id" value="">
                                <input type="hidden" name="_employee_ledger_id" class="_employee_ledger_id" value="">
                                <input type="text" name="_employee_id_text" class="form-control _employee_id_text" placeholder="{{__('EMP ID')}}">
                               <div class="search_box_employee"> </div>
                            </div>
                    <label class="col-sm-2 col-form-label" >{{__('Employee Name')}}:</label>
                             <div class="col-sm-4">
                                <input type="text" name="_employee_name_text" class="form-control _employee_name_text" placeholder="{{__('Employee')}}">
                               <div class="search_box_employee"> </div>
                            </div>
                </div>
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label" >{{__('label.organization_id')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="organization_id_name" class="form-control organization_id_name" placeholder="{{__('label.organization_id')}}" readonly>
                         <input type="hidden" name="organization_id" class="organization_id" value="0">
                    </div>
                    <label class="col-md-2 col-form-label" >{{__('label._branch_id')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_branch_id_name" class="form-control _branch_id_name" placeholder="{{__('label._branch_id')}}" readonly>
                         <input type="hidden" name="_branch_id" class="_branch_id" value="0">
                    </div>
                   
                </div>
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label" >{{__('label._cost_center_id')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_cost_center_id_name" class="form-control _cost_center_id_name" placeholder="{{__('label._cost_center_id')}}" readonly>
                         <input type="hidden" name="_cost_center_id" class="_cost_center_id" value="0">
                    </div>
                    <label class="col-md-2 col-form-label" >{{__('label._budget_id')}}:</label>
                     <div class="col-md-4">

                      <select class="form-control _master_budget_id" name="_budget_id"  >
                           @if(sizeof($permited_budgets)>1) 
                             <option value="">{{__('label.select')}}</option>
                           @endif
                          @forelse($permited_budgets as $b_val )
                                <option value="{{$b_val->id}}" @if(isset($data->_budget_id)) @if($data->_budget_id == $b_val->id) selected @endif   @endif> {{ $b_val->_name ?? '' }}</option>
                           @empty
                           @endforelse
                       </select>
                                        
                    </div>
                   
                </div>
                
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label" >{{__('Department')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_department" class="form-control _department" placeholder="{{__('Department')}}" readonly>
                         <input type="hidden" name="_department_id" class="_department_id" value="0">
                    </div>
                    <label class="col-md-2 col-form-label" >{{__('Designation')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_emp_designation" class="form-control _emp_designation" placeholder="{{__('Designation')}}" readonly>
                        <input type="hidden" name="_jobtitle_id" class="_jobtitle_id" value="0">
                    </div>
                </div>
                
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label" >{{__('Grade')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_emp_grade" class="form-control _emp_grade" placeholder="{{__('Grade')}}" readonly>
                        <input type="hidden" name="_grade_id" class="_grade_id" value="0">
                    </div>
                    <label class="col-md-2 col-form-label" >{{__('Emp Category')}}:</label>
                     <div class="col-md-4">
                        <input type="text" name="_employee_cat" class="form-control _employee_cat" placeholder="{{__('Emp Category')}}" readonly>
                         <input type="hidden" name="_category_id" class="_category_id" value="0">
                    </div>
                </div>
                



                <div class="row" style="background:#e9ecef;padding:5px;">
                    <div class="col-md-3">
                            <table class="">
                                <tr>
                                    <td>{{__('label._present_days')}}</td>
                                    <td>
                                        <input type="number" step="any" min="0" name="_present_days" class="form-control _present_days" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('label._absent_days')}}</td>
                                    <td>
                                        <input type="number" step="any" min="0" name="_absent_days" class="form-control _absent_days" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('label._arrdays')}}</td>
                                    <td>
                                        <input type="number" step="any" min="0" name="_arrdays" class="form-control _arrdays" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{__('label._paydays')}}</td>
                                    <td>
                                        <input type="number" step="any" min="0" name="_paydays" class="form-control _paydays" value="0">
                                    </td>
                                </tr>
                            </table>
                    </div>
                    @forelse($payheads as $p_key=>$p_val)
                    <div class="col-md-3 ">
                        <h3>{!! $p_key ?? '' !!}</h3>
                        @if(sizeof($p_val) > 0)
                            @forelse($p_val as $l_val)
                            @php
                            //dump($l_val);
                            @endphp
                            <div class="form-group row ">
                            <label class="col-sm-6 col-form-label" for="_item">{{$l_val->_ledger ?? '' }}:</label>
                             <div class="col-sm-6">
                                <input type="hidden" name="_payhead_id[]" class="_payhead_id _payhead_id__{{$l_val->id}}" value="{{$l_val->id}}">
                                <input type="hidden" name="_payhead_type_id[]" class="_payhead_type_id _payhead_type_id__{{$l_val->id}}" value="{{$l_val->_type}}">
                              <input type="number"  name="_amount[]" class="form-control payhead_amount payhead_amount__{{$l_val->id}} @if($l_val->_payhead_type->cal_type==1) _add_salary @endif  @if($l_val->_payhead_type->cal_type==2) _deduction_salary @endif" value="0" placeholder="{{__('label._amount')}}" >
                            </div>
                        </div>
                        @empty
                        @endforelse
                        @endif
                    </div>

                        @empty
                        @endforelse
                        
                    
                </div>

              <div class="form-group row ">
                        <label class="col-sm-2 col-form-label" >Total Earnings:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_earnings" class="form-control total_earnings" value="0"  readonly>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-2 col-form-label" >Total Deduction:</label>
                         <div class="col-sm-6">
                            <input type="text" name="total_deduction" class="form-control total_deduction" value="0"  readonly>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-2 col-form-label" >Net Total Salary:</label>
                         <div class="col-sm-6">
                            <input type="text" name="net_total_earning" class="form-control net_total_earning" value="0"  readonly>
                        </div>
                    </div>


<div class="col-xs-12 col-sm-12 col-md-12 bottom_save_section text-middle">
                            <button type="submit" class="btn btn-success submit-button ml-5" ><i class="fa fa-credit-card mr-2" aria-hidden="true"></i> Save</button>
                            
                        </div>


</form> <!-- End of form -->
</div><!-- End of Card body -->
</div><!-- End of Card -->
</div><!-- End of Container -->
</div><!-- End of Content -->



@endsection
@section('script')
<script type="text/javascript">

    

$(document).on('keyup','.payhead_amount',function(){
    var total_earnings =0;
    var total_deduction=0;
    $(document).find('._deduction_salary').each(function(){
        var deduction = parseFloat(isEmpty($(this).val()));
        total_deduction +=parseFloat(deduction);
    })
    $(document).find('._add_salary').each(function(){
        var earning = parseFloat(isEmpty($(this).val()));
        total_earnings +=parseFloat(earning);
    })
    var net_total_earning = (parseFloat(total_earnings)-parseFloat(total_deduction));

    $(document).find(".total_earnings").val(total_earnings);
    $(document).find(".total_deduction").val(total_deduction);
    $(document).find(".net_total_earning").val(net_total_earning);

})


$(document).on('keyup','._employee_id_text',delay(function(e){
    
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  employee_search_with_code_name(_gloabal_this,_text_val);
  
}, 500));

$(document).on('keyup','._employee_name_text',delay(function(e){
    
  var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  employee_search_with_code_name(_gloabal_this,_text_val);
  
}, 500));

function employee_search_with_code_name(_gloabal_this,_text_val){
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
            search_html +=`<div class="card"><table style="width: 300px;"> <tbody>`;
                        for (var i = 0; i < data.length; i++) {
                         search_html += `<tr class="_employee_search_row_em _cursor_pointer" >
                                        <td style="border:1px solid #000;">${data[i]._code}
                                        <input type="hidden" name="_emp_all_data" class="_emp_all_data" attr_value='${JSON.stringify(data[i])}'>
                                        <input type="hidden" name="_emplyee_row_id" class="_emplyee_row_id" value="${data[i].id}">
                                        <input type="hidden" name="_emplyee_row_code_id" class="_emplyee_row_code_id" value="${data[i]?._code}">
                                        </td>
                                        <td style="border:1px solid #000;">${data[i]?._name}
                                        <input type="hidden" name="_search_employee_name" class="_search_employee_name" value="${data[i]?._name}">
                                        
                                        </td>
                                        <td style="border:1px solid #000;">${data[i]?._emp_designation?._name}
                                        </td>
                                        <td style="border:1px solid #000;">${data[i]?._organization?._name}
                                        <br>${data[i]?._branch?._name}
                                        <br>${data[i]?._cost_center?._name}
                                        </td>
                                        <td>
                                        <input type="hidden" class="_employee_organization_id" value="${data[i]?.organization_id}" />
                                        <input type="hidden" class="_employee_organization_name" value="${data[i]?._organization?._name}" />
                                        <input type="hidden" class="_employee_branch_id" value="${data[i]?._branch_id}" />
                                        <input type="hidden" class="_employee_branch_name" value="${data[i]?._branch?._name}" />
                                        <input type="hidden" class="_employee_cost_center_id" value="${data[i]?._cost_center_id}" />
                                        <input type="hidden" class="_employee_cost_center_name" value="${data[i]?._cost_center?._name}" />
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
}

    


$(document).on('click','._employee_search_row_em',function(){
 var _emp_all_data = $(this).children('td').find('._emp_all_data').attr('attr_value');

var data = JSON.parse(_emp_all_data);
//console.log(data)
$(document).find("._employee_name_text").val(data?._name);
$(document).find("._employee_id").val(data?.id);
$(document).find("._employee_id_text").val(data?._code);
$(document).find("._employee_ledger_id").val(data?._ledger_id);
$(document).find("._department").val(data?._emp_department?._name);
$(document).find("._emp_designation").val(data?._emp_designation?._name);
$(document).find("._emp_grade").val(data?._emp_grade?._name);
$(document).find("._employee_cat").val(data?._employee_cat?._name);
$(document).find(".organization_id_name").val(data?._organization?._name);
$(document).find(".organization_id").val(data?._organization?.id);
$(document).find("._branch_id_name").val(data?._branch?._name);
$(document).find("._branch_id").val(data?._branch?.id);
$(document).find("._cost_center_id_name").val(data?._cost_center?._name);
$(document).find("._cost_center_id").val(data?._cost_center?.id);
$(document).find("._cost_center_id_name").val(data?._cost_center?._name);
$(document).find("._cost_center_id").val(data?._cost_center?.id);
$(document).find("._jobtitle_id").val(data?._jobtitle_id);
$(document).find("._grade_id").val(data?._grade_id);
$(document).find("._category_id").val(data?._category_id);
$(document).find("._department_id").val(data?._department_id);

var employee_id = data?.id;

var _gloabal_this = $(this);
  var _text_val = $(this).val().trim();
  var request = $.ajax({
      url: "{{url('salary-structure-search')}}",
      method: "GET",
      data: { employee_id : employee_id },
      dataType: "JSON"
    });
     
    request.done(function( result ) {
        console.log(result);
        var _details = result?._details;
        if(_details?.length > 0){
            for (var i = 0; i < _details?.length; i++) {
                var _amount = _details[i]?._amount;
                if(isNaN(_amount)){ _amount=0 }
                $(document).find(".payhead_amount__"+_details[i]?._payhead_id).val(_amount);
            }
        }
        payhead_calculation();
    });
     
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });


$(document).find('.search_box_employee').hide();
$(document).find('.search_box_employee').removeClass('search_box_show').hide();


})

function payhead_calculation(){
    var total_earnings =0;
    var total_deduction=0;
    $(document).find('._deduction_salary').each(function(){
        var deduction = parseFloat(isEmpty($(this).val()));
        total_deduction +=parseFloat(deduction);
    })
    $(document).find('._add_salary').each(function(){
        var earning = parseFloat(isEmpty($(this).val()));
        total_earnings +=parseFloat(earning);
    })
    var net_total_earning = (parseFloat(total_earnings)-parseFloat(total_deduction));

    $(document).find(".total_earnings").val(total_earnings);
    $(document).find(".total_deduction").val(total_deduction);
    $(document).find(".net_total_earning").val(net_total_earning);
}

</script>

@endsection
